function update_time_title() {
  var current_time = $('.time-text').html();
  var title_element = $('title');
  var title = $(title_element).html();

  console.log(current_time);
  current_time = Date();
  $(title_element).html(current_time + ' | ' + title);
}