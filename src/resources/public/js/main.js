let doBreak = 'begin';
let windowObject;
let strWindowFeatures = 'toolbar=1,scrollbars=1,location=1,statusbar=0,menubar=1,resizable=1,width=430,height=350';
let url = 'http://localhost/index.php';

openWindow();

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

              break_button.val('Pause\nEnde');
              break_button.css('white-space', 'normal');
              break_button.css('line-height', '15px');
              break_button.css('padding', '5px 10px');
          }
          if(str == 'end'){
              $("#time-list").append(response);

              doBreak = 'begin';
              $("#break-button").val('Pause');
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
      $('label[for=time-list]').append(data);
    }
  });
}

function update_time_title() {
  var current_time = $('.time-text').html();
  var title_element = $('title');
  var title = $(title_element).html();

  console.log(current_time);
  current_time = Date();
  $(title_element).html(current_time + ' | ' + title);
}



function openWindow(){
    windowObject = window.open(url, 'Timetracker', strWindowFeatures);

}


if ($('#month-list').html() == null) {
    $('#pdf-button').prop('disabled', true);
}