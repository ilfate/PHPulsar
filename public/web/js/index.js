/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Main js entrance to my engine
 */

function Action() 
{
  this.refresh = function()
  {
    document.location.reload(true);
  }
  this.redirect = function(data)
  {
	  window.location = data;
  }
}
Action = new Action();

function ilAlert(data)
{
  var html = '<div class="alert fade in"><button class="close" data-dismiss="alert" type="button"><i class="icon-off icon-white"></i></button><div id="alert-text">'+data+'</div></div>';
  $('.container.main').prepend(html);
  $('.alert').show('slow');
  $('.alert').alert();
}

function ilfate_init() {
  Ajax.init();
  $('.tip').tooltip();
  $('.tip-bottom').tooltip({placement:'bottom'});
  $('.tip-left').tooltip({placement:'left'});
  $('.tip-right').tooltip({placement:'right'});
  stars();
}
$(document).ready(function(){
  ilfate_init();
});

F.manageEvent('ajaxloadcompleted', ilfate_init);


function info(data)
{
  console.info(data);
}


function stars() 
{
	$('.label-stars').each(function(){
		//if()
		var el =  $(this);
		if(el.prev().hasClass('before-stars')) return ;
		el.before('<div class="container-stars"></div>');
		el.appendTo(el.prev());
		el.before('<div class="before-stars"></div>');
	});
}