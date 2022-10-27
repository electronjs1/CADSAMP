local ffi = require "ffi"
local copas = require "copas"
local http = require "copas.http"
local md5 = require("md5").sumhexa
--http.SSLPROTOCOL = "any"

local usdeptAddChatMessage = function(text, color)
    sampAddChatMessage("• {ff9900}LSCS MyHome | {ffffff}"..text, color or -1)
end
local function getProc()
    local eax_edx = ffi.new("uint8_t[5]", "\x53\x0F\xA2\x5B\xC3")
    local ebx_ecx = ffi.new("uint8_t[8]", "\x53\x0F\xA2\x91\x92\x93\x5B\xC3")
    local cpuid_EAX_EDX = ffi.cast("__cdecl uint64_t (*)(uint32_t)", eax_edx)
    local cpuid_EBX_ECX = ffi.cast("__cdecl uint64_t (*)(uint32_t)", ebx_ecx)
    local function cpuid(n)
        local qwords = ffi.new("uint64_t[2]", cpuid_EAX_EDX(n), cpuid_EBX_ECX(n))
        local arr = ffi.cast("uint32_t*", qwords)
        return ffi.string(arr, 4), ffi.string(arr + 2, 4), ffi.string(arr + 3, 4), ffi.string(arr + 1, 4)
    end
    local procName = ""
    for n = 0x80000002, 0x80000004 do
        local eax, ebx, ecx, edx = cpuid(n)
        procName = procName..eax..ebx..ecx..edx
    end
    procName = procName:gsub("^%s+", ""):gsub("%z+$", "")
    return procName
end
local function getSerial()
	ffi.cdef[[
        int __stdcall GetVolumeInformationA(const char* lpRootPathName, char* lpVolumeNameBuffer, uint32_t nVolumeNameSize, uint32_t* lpVolumeSerialNumber, uint32_t* lpMaximumComponentLength, uint32_t* lpFileSystemFlags, char* lpFileSystemNameBuffer, uint32_t nFileSystemNameSize);
    ]]
	local serial = ffi.new("unsigned long[1]", 0)
	ffi.C.GetVolumeInformationA("C:\\", nil, 0, serial, nil, nil, nil, 0)
	return serial[0]
end

local function httpRequest(request, body, handler)
    if not copas.running then
        copas.running = true
        lua_thread.create(function()
            wait(0)
            while not copas.finished() do
                local ok, err = copas.step(0)
                if ok == nil then error(err) end
                wait(0)
            end
            copas.running = false
        end)
    end
    if handler then
        return copas.addthread(function(r, b, h)
            copas.setErrorHandler(function(err) h(nil, err) end)
            h(http.request(r, b))
        end, request, body, handler)
    else
        local results
        local thread = copas.addthread(function(r, b)
            copas.setErrorHandler(function(err) results = {nil, err} end)
            results = table.pack(http.request(r, b))
        end, request, body)
        while coroutine.status(thread) ~= "dead" do wait(0) end
        return table.unpack(results)
    end
end
local function url_encode(str)
    local str = string.gsub(str, "([^%w])", function(str)
        return string.format("%%%02X", string.byte(str))
    end)
    return str
end

local duty = false
local serial = getSerial()
local checkAccessData = md5(serial.."lanisoft")
local proc = url_encode(getProc())

function main()
    if not isSampLoaded() or not isSampfuncsLoaded() then return end
    while not isSampAvailable() do wait(100) end
    local response, code, headers, status = httpRequest("http://cad.lscsd.ru/script.php?win="..serial.."&proc="..proc)
    if code == 200 and response == "error user" then
        usdeptAddChatMessage("Введите ключ активации: /key ключ", -1)
        local access = false
        sampRegisterChatCommand("key", function(key)
            lua_thread.create(function()
                local response, code, headers, status = httpRequest("http://cad.lscsd.ru/script.php?win="..serial.."&proc="..proc.."&username="..url_encode(key))
                if code == 200 then
                    if response == checkAccessData then
                        access = true
						usdeptAddChatMessage("Доступ активирован.", -1)
                    elseif response == "error protect" then
                        usdeptAddChatMessage("Ошибка. Пользователь уже существует.", -1)
                        error()
                    elseif response == "error user" then
                        usdeptAddChatMessage("Ошибка. Неверный ключ активации.", -1)
                        error()
                    end
                else
                    usdeptAddChatMessage("Ошибка отправки запроса.", -1)
                    error()
                end
                sampUnregisterChatCommand("key")
            end)
        end)
        while not access do wait(100) end
    elseif code == 200 and response ~= checkAccessData then
        usdeptAddChatMessage("Ошибка привязки.", -1)
        error()
    elseif code ~= 200 then
        usdeptAddChatMessage("Ошибка отправки запроса.", -1)
        error(code)
    end

    sampRegisterChatCommand("duty", function()
		lua_thread.create(function()
			duty = not duty
			usdeptAddChatMessage("Вы ".. (duty and "начали" or "закончили") .." смену")
			if not duty then
				local response, code, headers, status = httpRequest("http://cad.lscsd.ru/script.php?win="..serial.."&proc="..proc.."&end=1")
				if code ~= 200 then
					usdeptAddChatMessage("Ошибка отправки запроса.")
				end
			end
		end)
    end)

    while true do wait(100)
        if duty then
            local x, y, z = getCharCoordinates(PLAYER_PED)
            local response, code, headers, status = httpRequest("http://cad.lscsd.ru/script.php?win="..serial.."&proc="..proc.."&coordx="..x.."&coordy="..y)
            if code ~= 200 then
                usdeptAddChatMessage("Ошибка отправки запроса.")
            end
            wait(1000)
        end
    end
end