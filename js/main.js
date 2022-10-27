  $(function () {
  if (window.location.hash == '#signin') {
    $('#signin').addClass('appearance');
    $('#signup').addClass('disappearance');
  } else if (window.location.hash == '#signup') {
    $('#signin').removeClass('form_active');
    $('#signup').addClass('form_active');
    $('#signup').addClass('appearance');
    $('#signin').addClass('disappearance');
  }

  $('a[href="#signin"]').on('click', function () {
    $('form.appearance').removeClass('appearance');
    $('form.disappearance').removeClass('disappearance');
    $('#signup').removeClass('form_active');
    $('#signin').addClass('form_active');
    $('#signin').addClass('appearance');
    $('#signup').addClass('disappearance');
  });

  $('a[href="#signup"]').on('click', function () {
    $('form.appearance').removeClass('appearance');
    $('form.disappearance').removeClass('disappearance');
    $('#signin').removeClass('form_active');
    $('#signup').addClass('form_active');
    $('#signup').addClass('appearance');
    $('#signin').addClass('disappearance');
  });

  $('body').on('click', '.search-result__spoiler', function () {
    $(this).toggleClass('search-result__spoiler-active');
    if ($(this).hasClass('search-result__arrest')) {
      $('.search-result__arrests').toggleClass('search-result__arrests-active');
    } else if ($(this).hasClass('search-result__violation')) {
      $('.search-result__violations').toggleClass('search-result__violations-active');
    } else {
      $('.search-result__warnings').toggleClass('search-result__warnings-active');
    }
  });

  if (window.location.pathname == '/mdt.php') {
    getmdtcallstable();
    getmdtcalltable();
    getmdtstatus();
    getmdtnotifications();
    getmdtpeoplebolo();
    getmdtvehiclebolo();
  } else if (window.location.pathname == '/cad.php') {
    getcadcallstable();
    getcadnotifications();
    getcadavailableunits();
    getcadunavailableunits();
    getcadpeoplebolo();
    getcadvehiclebolo();
    getonlinemap(map);
  }

  function getmdtcallstable() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        mdtcallstable: 'update'
      },
      success: function (result) {
        $('#calls-table').html(result);
        setTimeout(getmdtcallstable, 5000);
      }
    });
  }

  function getmdtcalltable() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        mdtcalltable: 'update'
      },
      success: function (result) {
        $('#call-table').html(result);
        setTimeout(getmdtcalltable, 5000);
      }
    });
  }

  function getmdtstatus() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        mdtstatus: 'update'
      },
      success: function (result) {
        $('#status').html(result);
        setTimeout(getmdtstatus, 5000);
      }
    });
  }

  function getmdtnotifications() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        mdtnotifications: 'update'
      },
      success: function (result) {
        $('#notifications').html(result);
        setTimeout(getmdtnotifications, 5000);
      }
    });
  }

  function getmdtpeoplebolo() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        mdtpeoplebolo: 'update'
      },
      success: function (result) {
        $('#pbolo').html(result);
        setTimeout(getmdtpeoplebolo, 5000);
      }
    });
  }

  function getmdtvehiclebolo() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        mdtvehiclebolo: 'update'
      },
      success: function (result) {
        $('#vbolo').html(result);
        setTimeout(getmdtvehiclebolo, 5000);
      }
    });
  }

  function getcadcallstable() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        cadcallstable: 'update'
      },
      success: function (result) {
        $('#calls-table').html(result);
        setTimeout(getcadcallstable, 5000);
      }
    });
  }

  function getcadnotifications() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        cadnotifications: 'update'
      },
      success: function (result) {
        $('#notifications').html(result);
        setTimeout(getcadnotifications, 5000);
      }
    });
  }

  function getcadavailableunits() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        cadavailableunits: 'update'
      },
      success: function (result) {
        $('#available-units').html(result);
        setTimeout(getcadavailableunits, 5000);
      }
    });
  }

  function getcadunavailableunits() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        cadunavailableunits: 'update'
      },
      success: function (result) {
        $('#unavailable-units').html(result);
        setTimeout(getcadunavailableunits, 5000);
      }
    });
  }

  function getcadpeoplebolo() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        cadpeoplebolo: 'update'
      },
      success: function (result) {
        $('#people-bolo').html(result);
        setTimeout(getcadpeoplebolo, 5000);
      }
    });
  }

  function getcadvehiclebolo() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      data: {
        cadvehiclebolo: 'update'
      },
      success: function (result) {
        $('#vehicle-bolo').html(result);
        setTimeout(getcadvehiclebolo, 5000);
      }
    });
  }

  $('#signup').submit(function (event) {
    event.preventDefault();
    $('.form_active .form__result').html('');
    $.ajax({
      type: 'POST',
      url: 'actions/register.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $('.form__loader').css('display', 'block');
      },
      complete: function () {
        setTimeout(function () {
          $('.form__loader').css('display', 'none');
        }, 1000);
      },
      success: function (result) {
        setTimeout(function () {
          $('.form_active .form__result').html(result);
        }, 1000);
      },
    });
  });

  $('#signin').submit(function (event) {
    event.preventDefault();
    $('.form_active .form__result').html('');
    $.ajax({
      type: 'POST',
      url: 'actions/login.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $('.form__loader').css('display', 'block');
      },
      complete: function () {
        setTimeout(function () {
          $('.form__loader').css('display', 'none');
        }, 1000);
      },
      success: function (result) {
        setTimeout(function () {
          if (result == 'ok') {
            window.location.href = '/';
          } else {
            $('.form_active .form__result').html(result);
          }
        }, 1000);
      },
    });
  });

  $('.unit-information__select .select_checked').on('click', function () {
    $('.database__select .select__dropdown').removeClass('select__dropdown_open');
    $('.unit-information__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('.database__select .select_checked').on('click', function () {
    $('.unit-information__select .select__dropdown').removeClass('select__dropdown_open');
    $('.database__select .select__dropdown').toggleClass('select__dropdown_open');
    $('.database__select .select__dropdown input').val('');
    $('.response-result').html('');
    $('.database__select .select__dropdown input').focus();
  });

  $('.create-violation__select .select_checked').on('click', function () {
    $('.create-violation__select .select__dropdown').toggleClass('select__dropdown_open');
    $('.create-violation__select .select__dropdown input').val('');
    $('.response-result').html('');
    $('.create-violation__select .select__dropdown input').focus();
  });

  $('.create-warning__select .select_checked').on('click', function () {
    $('.create-warning__select .select__dropdown').toggleClass('select__dropdown_open');
    $('.create-warning__select .select__dropdown input').val('');
    $('.response-result').html('');
    $('.create-warning__select .select__dropdown input').focus();
  });

  $('.create-call__select .select_checked').on('click', function () {
    $('.create-call__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('.create-attach__select .select_checked').on('click', function () {
    $('.create-attach__select .select__dropdown').toggleClass('select__dropdown_open');
    $('.create-attach__select .select__dropdown input').val('');
    $('.response-result').html('');
    $('.create-attach__select .select__dropdown input').focus();
  });

  $('.select__role .select_checked').on('click', function () {
    $('.select__role .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('.select__type .select_checked').on('click', function () {
    $('.select__type .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('.create-pf-marital__select .select_checked').on('click', function () {
    $('.create-pf-sex__select .select__dropdown').removeClass('select__dropdown_open');
    $('.create-pf-race__select .select__dropdown').removeClass('select__dropdown_open');
    $('.create-pf-marital__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('.create-pf-sex__select .select_checked').on('click', function () {
    $('.create-pf-marital__select .select__dropdown').removeClass('select__dropdown_open');
    $('.create-pf-race__select .select__dropdown').removeClass('select__dropdown_open');
    $('.create-pf-sex__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('.edit-pf-marital__select .select_checked').on('click', function () {
    $('.edit-pf-sex__select .select__dropdown').removeClass('select__dropdown_open');
    $('.edit-pf-race__select .select__dropdown').removeClass('select__dropdown_open');
    $('.edit-pf-marital__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('.edit-pf-sex__select .select_checked').on('click', function () {
    $('.edit-pf-marital__select .select__dropdown').removeClass('select__dropdown_open');
    $('.edit-pf-race__select .select__dropdown').removeClass('select__dropdown_open');
    $('.edit-pf-sex__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('.edit-pf-race__select .select_checked').on('click', function () {
    $('.edit-pf-marital__select .select__dropdown').removeClass('select__dropdown_open');
    $('.edit-pf-sex__select .select__dropdown').removeClass('select__dropdown_open');
    $('.edit-pf-race__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('.create-pf-race__select .select_checked').on('click', function () {
    $('.create-pf-sex__select .select__dropdown').removeClass('select__dropdown_open');
    $('.create-pf-marital__select .select__dropdown').removeClass('select__dropdown_open');
    $('.create-pf-race__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('.header-top__item').on('click', function () {
    $('.header-top__nav').toggleClass('header-top__nav-active');
  });

  $(document).mouseup(function (e) {
    var div = $('.select');
    if (!div.is(e.target) && div.has(e.target).length === 0) {
      $('.select__dropdown').removeClass('select__dropdown_open');
    }
    var div = $('.header-top__user');
    if (!div.is(e.target) && div.has(e.target).length === 0) {
      $('.header-top__nav').removeClass('header-top__nav-active');
    }
  });

  $('body').on('click', '.table-btn', function (event) {
    event.preventDefault();
    var value = $(this).attr('value');
    if (value == 'Код 4') {
      var value = $(this).attr('data-value');
      var data = {
        id: value,
        message: 'Код 4'
      };
      var json = JSON.stringify(data);
      $.ajax({
        type: 'POST',
        url: 'actions/call.php',
        dataType: 'json',
        data: json,
        cache: false
      });
    } else if (value == 'Удалить') {
      var value = $(this).attr('data-value');
      var type = $(this).attr('data-bolo');
      var data = {
        id: value,
        message: 'Удалить',
        type: type
      };
      var json = JSON.stringify(data);
      $.ajax({
        type: 'POST',
        url: 'actions/call.php',
        dataType: 'json',
        data: json,
        cache: false
      });
    } else if (value == 'Редактировать') {
      var value = $(this).attr('data-value');
      var type = $(this).attr('data-bolo');
      var data = {
        id: value,
        message: 'Редактировать',
        type: type
      };
      var json = JSON.stringify(data);
      $.ajax({
        type: 'POST',
        url: 'actions/call.php',
        dataType: 'json',
        data: json,
        cache: false,
        success: function (data) {
          if (type == 'Автомобиль') {
            $('#edit-vehicle-bolo-id').val(value);
            $('#model').val(data['model']);
            $('#color').val(data['color']);
            $('#number').val(data['number']);
            $('#features').val(data['features']);
            $('#last-place').val(data['last_place']);
            $('#last-date').val(data['last_date']);
            $('#reason-vehicle').val(data['reason']);
          } else if (type == 'Человек') {
            $('#edit-people-bolo-id').val(value);
            $('#name').val(data['name']);
            $('#surname').val(data['surname']);
            $('#sex').val(data['sex']);
            $('#mark').val(data['mark']);
            $('#description').val(data['description']);
            $('#reason-people').val(data['reason']);
          } else {
            $('#edit-pf-id').val(value);
            $('#namee').val(data['name']);
            $('#dob').val(data['dob']);
            if (data['sex'] == 'Неизвестно') {
              $('#edit-sex-select').val(1);
              $('.edit-pf-sex__select .select_checked').html('<span style="color: #fff">Неизвестно</span>');
            } else if (data['sex'] == 'Мужской') {
              $('#edit-sex-select').val(2);
              $('.edit-pf-sex__select .select_checked').html('<span style="color: #fff">Мужской</span>');
            } else if (data['sex'] == 'Женский') {
              $('#edit-sex-select').val(3);
              $('.edit-pf-sex__select .select_checked').html('<span style="color: #fff">Женский</span>');
            }
            if (data['race'] == 'Неизвестно') {
              $('#edit-race-select').val(1);
              $('.edit-pf-race__select .select_checked').html('<span style="color: #fff">Неизвестно</span>');
            } else if (data['race'] == 'Белый / Европеоид') {
              $('#edit-race-select').val(2);
              $('.edit-pf-race__select .select_checked').html('<span style="color: #fff">Белый / Европеоид</span>');
            } else if (data['race'] == 'Афроамериканец') {
              $('#edit-race-select').val(3);
              $('.edit-pf-race__select .select_checked').html('<span style="color: #fff">Афроамериканец</span>');
            } else if (data['race'] == 'Латиноамериканец') {
              $('#edit-race-select').val(4);
              $('.edit-pf-race__select .select_checked').html('<span style="color: #fff">Латиноамериканец</span>');
            } else if (data['race'] == 'Араб') {
              $('#edit-race-select').val(5);
              $('.edit-pf-race__select .select_checked').html('<span style="color: #fff">Араб</span>');
            } else if (data['race'] == 'Азиат') {
              $('#edit-race-select').val(6);
              $('.edit-pf-race__select .select_checked').html('<span style="color: #fff">Азиат</span>');
            }
            if (data['marrital_status'] == 'Неизвестно') {
              $('#edit-marital-select').val(1);
              $('.edit-pf-marital__select .select_checked').html('<span style="color: #fff">Неизвестно</span>');
            } else if (data['marrital_status'] == 'Женат (-замужем)') {
              $('#edit-marital-select').val(2);
              $('.edit-pf-marital__select .select_checked').html('<span style="color: #fff">Женат (-замужем)</span>');
            } else if (data['marrital_status'] == 'Не женат (-не замужем)') {
              $('#edit-marital-select').val(3);
              $('.edit-pf-marital__select .select_checked').html('<span style="color: #fff">Не женат (-не замужем)</span>');
            }
            $('#por').val(data['por']);
            $('#skin').val(data['skin']);
          }
        }
      });
    } else if (value == 'Одобрить') {
      var value = $(this).attr('data-value');
      $('#request-id').val(value);
      var value = $(this).attr('data-name');
      $('#username1').val(value);
    } else if (value == 'Отклонить') {
      var value = $(this).attr('data-value');
      $('#denied-id').val(value);
      var value = $(this).attr('data-name');
      $('#username2').val(value);
    } else {
      var value = $(this).attr('data-value');
      $('#call-attach').val(value);
    }
  });

  $('body').on('click', '#btn-edit-pf', function () {
    var value = $(this).attr('data-id');
    $('#edit-pf-id').val(value);
  });

  $('body').on('click', '.unit-information__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#select-status').val(value);
    $('.unit-information__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    setTimeout(function () {
      $('.unit-information__select .select_checked').text('Выберите статус');
    }, 100);
    $('.unit-information__select .select__dropdown').toggleClass('select__dropdown_open');
    var data = {
      status: value
    };
    var json = JSON.stringify(data);
    $.ajax({
      type: 'POST',
      url: 'actions/status.php',
      dataType: 'json',
      data: json,
      cache: false
    });
  });

  $('body').on('click', '.section__info .select__option', function () {
    var value = $(this).attr('data-value');
    $('.unit-information__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    setTimeout(function () {
      $('.unit-information__select .select_checked').text('Выберите статус');
    }, 100);
    var data = {
      status: value
    };
    var json = JSON.stringify(data);
    $.ajax({
      type: 'POST',
      url: 'actions/status.php',
      dataType: 'json',
      data: json,
      cache: false
    });
  });

  $('body').on('click', '.database__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#select-civil').val(value);
    $('.database__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.database__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.create-violation__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#violation-select-civil').val(value);
    $('.create-violation__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.create-violation__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.create-warning__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#warning-select-civil').val(value);
    $('.create-warning__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.create-warning__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.create-call__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#select-call-type').val(value);
    var value = $(this).text();
    $('.create-call__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.create-call__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.create-attach__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#select-unit').val(value);
    $('.create-attach__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.create-attach__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.select__role .select__option', function () {
    var value = $(this).attr('data-value');
    $('#new-type').val(value);
    var value = $(this).text();
    $('.select__role .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.select__role .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.select__type .select__option', function () {
    var value = $(this).attr('data-value');
    $('#type').val(value);
    var value = $(this).text();
    $('.select__type .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.select__type .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.create-pf-marital__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#create-marital-select').val(value);
    var value = $(this).text();
    $('.create-pf-marital__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.create-pf-marital__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.create-pf-sex__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#create-sex-select').val(value);
    var value = $(this).text();
    $('.create-pf-sex__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.create-pf-sex__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.edit-pf-sex__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#edit-sex-select').val(value);
    var value = $(this).text();
    $('.edit-pf-sex__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.edit-pf-sex__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.create-pf-race__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#create-race-select').val(value);
    var value = $(this).text();
    $('.create-pf-race__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.create-pf-race__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.edit-pf-race__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#edit-race-select').val(value);
    var value = $(this).text();
    $('.edit-pf-race__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.edit-pf-race__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('body').on('click', '.edit-pf-marital__select .select__option', function () {
    var value = $(this).attr('data-value');
    $('#edit-marital-select').val(value);
    var value = $(this).text();
    $('.edit-pf-marital__select .select_checked').html('<span style="color: #fff">' + value + '</span>');
    $('.edit-pf-marital__select .select__dropdown').toggleClass('select__dropdown_open');
  });

  $('#search-button').on('click', function () {
    var value = $('#select-civil').val();
    var data = {
      name: value
    };
    $('#select-civil').val('');
    $('.database__select .select_checked').text('Выберите гражданского');
    $.ajax({
      type: 'POST',
      url: 'actions/ncic.php',
      data: {
        name: value
      },
      dataType: 'text',
      cache: false,
      success: function (data) {
        $('.search-result').html(data);
      }
    });
  });

  $('.search-input').on('keyup focus', function () {
    var query = $(this).val();
    if (query.length >= 0) {
      $.ajax({
        type: 'POST',
        url: 'actions/search-civil.php',
        data: {
          q: query
        },
        success: function (data) {
          $('.response-result').html(data);
        },
        dataType: 'text',
        cache: false
      });
    }
  });

  $('.search-unit').on('keyup focus', function () {
    var query = $(this).val();
    if (query.length >= 0) {
      $.ajax({
        type: 'POST',
        url: 'actions/search-unit.php',
        data: {
          q: query
        },
        success: function (data) {
          $('.response-result').html(data);
        },
        dataType: 'text',
        cache: false
      });
    }
  });

  $('body').on('click', '#panic-button', function () {
    $('#notifications').html('<button type="button" class="btn btn-danger">КНОПКА ПАНИКИ АКТИВНА</button>');
    $.ajax({
      type: 'POST',
      url: 'actions/panic-button.php',
      data: {
        message: 'panic'
      },
      cache: false,
      dataType: 'text'
    });
  });

  $('body').on('click', '#signal_100', function () {
    var signal = $('#notifications').html();
    var html = '<button type="button" class="btn btn-danger" id="signal_100">СИГНАЛ 100 АКТИВЕН</button>';
    if (signal == html) {
      $('#notifications').html('<button type="button" class="btn btn-danger" id="signal_100">СИГНАЛ 100</button>');
    } else {
      $('#notifications').html('<button type="button" class="btn btn-danger" id="signal_100">СИГНАЛ 100 АКТИВЕН</button>');
    }
    $.ajax({
      type: 'POST',
      url: 'actions/panic-button.php',
      data: {
        message: 'signal'
      },
      cache: false,
      dataType: 'text'
    });
  });
  $('#penal-code').on('click', function () {
    window.open('https://forum.mh-rp.ru/threads/Уголовный-кодекс.3868/');
  });

  $('#wordslist').on('click', function () {
    window.open('https://imgur.com/a/7ciDJEw');
  });

  $('#admin-code').on('click', function () {
    window.open('https://forum.mh-rp.ru/threads/Административный-кодекс.3845/');
  });

  $('#traffic-code').on('click', function () {
    window.open('https://forum.mh-rp.ru/threads/Уголовно-процессуальный-кодекс.3838/');
  });

  $('#rangs-system').on('click', function () {
    window.open('https://lscsd.ru/index.php?forums/los-santos-county-sheriff-manual.175/');
  });

  $('#patrol-report').on('click', function () {
    window.open('#');
  });

  $('#ten-cods').on('click', function () {
    window.open('#');
  });

  $('#create-pf_form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/create-pf.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#create-pf').modal('hide');
          $('.create-pf__result').html('');
          $('#create-pf input').val('');
          $('#create-pf .select_checked').text('');
        } else {
          $('.create-pf__result').html(data);
        }
      }
    });
  });

  $('#create-violation_form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/create-violation.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#create-violation').modal('hide');
          $('.create-violation__result').html('');
          $('#create-violation input').val('');
          $('.create-violation__select .select_checked').text('Выберите гражданского');
        } else {
          $('.create-violation__result').html(data);
        }
      }
    });
  });

  $('#create-warning_form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/create-warning.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#create-warning').modal('hide');
          $('.create-warning__result').html('');
          $('#create-warning input').val('');
          $('.create-warning__select .select_checked').text('Выберите гражданского');
        } else {
          $('.create-warning__result').html(data);
        }
      }
    });
  });

  $('#create-call_form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/create-call.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#create-call').modal('hide');
          $('.create-call__result').html('');
          $('#create-call input').val('');
          $('#create-call textarea').val('');
          $('.create-call__select .select_checked').text('');
        } else {
          $('.create-call__result').html(data);
        }
      }
    });
  });

  $('#create-attach__submit').on('click', function (event) {
    event.preventDefault();
    var call = $('#call-attach').val();
    var unit = $('#select-unit').val();
    var data = {
      id: call,
      unit: unit,
      message: 'Прикрепить'
    };
    var json = JSON.stringify(data);
    $.ajax({
      type: 'POST',
      url: 'actions/call.php',
      dataType: 'json',
      data: json,
      cache: false,
      success: function (data) {
        if (data['message'] == 'ok') {
          $('#create-attach').modal('hide');
          $('.create-attach__select .select_checked').text('Выберите юнита');
          $('#select-unit').val('');
        }
      }
    });
  });

  $('#create-vehicle-bolo_form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/create-bolo.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#create-vehicle-bolo').modal('hide');
          $('.create-vehicle-bolo__result').html('');
          $('#create-vehicle-bolo input').val('');
        } else {
          $('.create-vehicle-bolo__result').html(data);
        }
      }
    });
  });

  $('#create-people-bolo_form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/create-bolo.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#create-people-bolo').modal('hide');
          $('.create-people-bolo__result').html('');
          $('#create-people-bolo input').val('');
        } else {
          $('.create-people-bolo__result').html(data);
        }
      }
    });
  });

  $('#edit-people-bolo_form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/edit-bolo.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#edit-people-bolo').modal('hide');
          $('.edit-people-bolo__result').html('');
          $('#edit-people-bolo input').val('');
        } else {
          $('.edit-people-bolo__result').html(data);
        }
      }
    });
  });

  $('#edit-vehicle-bolo_form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/edit-bolo.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#edit-vehicle-bolo').modal('hide');
          $('.edit-vehicle-bolo__result').html('');
          $('#edit-vehicle-bolo input').val('');
        } else {
          $('.edit-vehicle-bolo__result').html(data);
        }
      }
    });
  });

  $('#edit-pf_form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/edit-bolo.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#edit-pf').modal('hide');
          $('.edit-pf__result').html('');
          $('#edit-pf input').val('');
          $('#edit-pf .select_checked').text('');
        } else {
          $('.edit-pf__result').html(data);
        }
      }
    });
  });

  $('#change-password_form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/change-password.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#change-user-password').modal('hide');
          $('.change-password__result').html('');
          $('#change-user-password input').val('');
        } else {
          $('.change-password__result').html(data);
        }
      }
    });
  });

  $('#accept-form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/admin-actions.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#accept').modal('hide');
          $('.accept__result').html('');
          $('#accept .select_checked').text('Выберите роль');
        } else {
          $('.accept__result').html(data);
        }
      }
    });
  });

  $('#denied-form').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/admin-actions.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'ok') {
          $('#denied').modal('hide');
          $('#denied input').val('');
          $('.denied__result').html('');
        } else {
          $('.denied__result').html(data);
        }
      }
    });
  });

  $('#change-password').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/admin-actions.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'Пароль успешно изменён.') {
          $('#change-password .form__result').html(data);
          $('#change-password input').val('');
          setTimeout(function () {
            $('#change-password .form__result').html('');
          }, 10000);
        } else {
          $('#change-password .form__result').html(data);
        }
      }
    });
  });

  $('#change-identifier').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/admin-actions.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'Идентификатор успешно изменён.') {
          $('#change-identifier .form__result').html(data);
          $('#change-identifier input').val('');
          setTimeout(function () {
            $('#change-identifier .form__result').html('');
          }, 10000);
        } else {
          $('#change-identifier .form__result').html(data);
        }
      }
    });
  });

  $('#change-username').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/admin-actions.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'Никнейм успешно изменён.') {
          $('#change-username .form__result').html(data);
          $('#change-username input').val('');
          setTimeout(function () {
            $('#change-username .form__result').html('');
          }, 10000);
        } else {
          $('#change-username .form__result').html(data);
        }
      }
    });
  });

  $('#change-type').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/admin-actions.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'Роль успешно изменена.') {
          $('#change-type .form__result').html(data);
          $('#change-type input').val('');
          $('#change-type .select_checked').text('Выберите роль');
          setTimeout(function () {
            $('#change-type .form__result').html('');
          }, 10000);
        } else {
          $('#change-type .form__result').html(data);
        }
      }
    });
  });

  $('#delete-username').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'actions/admin-actions.php',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == 'Аккаунт успешно удалён.') {
          $('#delete-username .form__result').html(data);
          $('#delete-username input').val('');
          setTimeout(function () {
            $('#delete-username .form__result').html('');
          }, 10000);
        } else {
          $('#delete-username .form__result').html(data);
        }
      }
    });
  });

  if (window.location.pathname == '/cad.php') {
    var p_markers = [];
    var sampType = new SanMapType(0, 3, function (zoom, x, y) {
      return x == -1 && y == -1 ?
        "img/tiles/map.outer.png" :
        "img/tiles/samp." + zoom + "." + x + "." + y + ".png";
    });

    var map = SanMap.createMap(
      document.getElementById('map-canvas'), {
        'SAMP': sampType
      },
      1,
      SanMap.getLatLngFromPos(0, 0), false, 'SAMP'
    );
  }

  function getonlinemap() {
    $.ajax({
      type: 'GET',
      url: 'actions/update.php',
      dataType: 'json',
      data: {
        onlinemap: 'update'
      },
      success: function (data) {
        deleteMarkers();
        checkonlinemap(data);
        setTimeout(getonlinemap, 5000);
    }
    });
  }

  function createMarker(id, data, LastTime)
			{
				var p_windows = new google.maps.InfoWindow({
		    		content: "<p style='color: #000; text-align: center;'>"+data[id].username+"<br>Последнее обновление: "+LastTime+" секунд(ы) назад</p>"
		    	});
		    var p_marker = new google.maps.Marker({
		    		position: SanMap.getLatLngFromPos(data[id].coordx, data[id].coordy),
		    		map: map,
		    		icon: "../img/map_icon.png"
		    	});
				google.maps.event.addListener(p_marker, 'click', function() {
          p_windows.open(map,p_marker);
        });
        p_markers.push(p_marker);
      }
    
      function setMapOnAll(map) {
        for (var i = 0; i < p_markers.length; i++) {
          p_markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }
      
    function checkonlinemap(data) {
      if (data !== "") {

        for (var i = 0, time = Math.round(Date.now() / 1000); i < Object.keys(data).length; i++) {
          var LastTime = time - data[i].coordtime;
          if (LastTime < 180) {
            createMarker(i, data, LastTime);
            google.maps.event.addListener(map, 'click', function(event) {
              var pos = SanMap.getPosFromLatLng(event.latLng);
              });
            }
      }
    }
    }

});