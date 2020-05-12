let doBreak = 'begin';
let time = 0;
let minutes = 0;
let seconds = 0;


$(document).ready(function () {
  init();
});

function init() {
  update_monthList();
  update_timeBalance()
}

function startWork () {
    $('#start-button').prop('disabled', true);
    $('#break-button').prop('disabled', false);
    $('#finish-button').prop('disabled', false);

    $.post('/API/track.php', {
        action: 'start',
        type: 'work:start'
    },
      function (response) {
        $('#time-list').append(response);
        update_monthList();
    });
}

function makeBreak(str) {

    $.post('/API/track.php', {
        action: 'break',
        type: 'break:' + str
    },
      function (response) {

          if(str == 'begin'){
              var break_button = $("#break-button");

              $("#time-list").append(response);
              doBreak = 'end';

              break_button.val('Pause Ende');
              break_button.css('white-space', 'normal');
              break_button.css('line-height', '15px');
              break_button.css('padding', '5px 10px');

              start_clock();
          }
          if(str == 'end'){
              $("#time-list").append(response);

              doBreak = 'begin';
              $("#break-button").val('Pause');

              stop_clock();
          }
      }
    );
}

function endWork() {
    $.post('/API/track.php', {
          action: 'finish',
          type: 'work:end'
      },
      function (response) {
          $('#time-list').append(response);

          $('#start-button').prop('disabled', false);
          $('#break-button').prop('disabled', true);
          $('#finish-button').prop('disabled', true);
      });
}

function download_PDF() {
    var months = $('#month-list').val();
    console.log(months);

    $.post('/API/pdf.php', {
      action: 'collectTracks',
      months: months
    }, function (response) {
        if(response) {
            $('pdf-button').val('Succeed')
        }
    });
}


function update_monthList() {
  $.post('/API/update.php', {action: 'months'}, function (data) {
    if (typeof data === 'string') {
      $('#month-list').html(data);
    }
  });
}

function update_timeBalance() {
  $.post('/API/update.php', {action: 'display_timeBalance'}, function (data) {
    if (typeof data === 'string') {
      var color;

      if (data < 0) color = '#aa0011';
      else color = '#00ee00';

      data = parseFloat(data).toFixed(2)
      $('label[for=time-list]').append('<i style="color: ' + color + '">' + data + '</i>');
    }
  });
}


function update_time_title(time) {
  var title_element = $('title');

  var title = $(title_element).html();
  $(title_element).html(time);

}

function start_clock() {

  setInterval(function(){
    timer(++time)
  }, 1000);
}

function stop_clock() {
  clearInterval(timer());
  time = 0;
  $('#timer').hide();
}

function timer(time) {
  seconds++;
  if (time > 59) {
    seconds = 0;
    minutes++;
    time = 0;
  }

  var display_time = minutes + ':' + seconds;
  update_time_title(display_time);
  $('#timer').html(display_time).show();
}

if ($('#month-list').html() == null) {
    $('#pdf-button').prop('disabled', true);
}