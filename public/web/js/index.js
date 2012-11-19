/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Main js entrance to my engine
 */


function ilAlert(data)
{
  var html = '<div class="alert fade in"><button class="close" data-dismiss="alert" type="button"><i class="icon-off icon-white"></i></button><div id="alert-text">'+data+'</div></div>';
  $('.container.main').prepend(html);
  $('.alert').show('slow');
  $('.alert').alert();
}

function info(data)
{
  console.info(data);
}