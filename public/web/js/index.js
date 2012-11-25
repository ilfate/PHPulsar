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
  $('.label-stars').starred();
}
$(document).ready(function(){
  ilfate_init();
});

F.manageEvent('ajaxloadcompleted', ilfate_init);


function info(data)
{
  console.info(data);
}




$.fn.starred = function() 
{
    
  $(this).each(function(event, el){
    el = $(el);
    var value = el.data('value');
    if(el.prev().hasClass('before-stars')) return ;
    el.before('<div class="container-stars"></div>');
    el.appendTo(el.prev());
    el.before('<div class="before-stars label"></div>');
    var width = el.css('width');
    var width_num = parseInt(width);
    var pad = Math.floor((width_num-18*4)/8);
    var modulo = Math.floor(((width_num-18*4)%8)/2);
    width = width_num - modulo;
    
    
    el.prev().css({width: width+'px', height : el.css('height'), 'padding-left': 4+modulo});
    var star_div = '<div class="star"><div class="under-star"></div><div class="img-star"></div></div>';
    el.prev().append(star_div + star_div + star_div + star_div);

    if(pad) {
      el.prev().find('.star').css('padding', '0px '+pad+'px')
      .last().css('padding', '0px 0px 0px '+pad+'px');
    }
    
    for(var i = 0; i < 4; i++) {
      if(value < (i+1)*25) {
        var star = el.prev().find('.star .under-star').eq(i);
        if(value < i*25) {
          star.width('0px');
        } else {
          star.width(Math.floor(((value - i*25)/25)*18) + 'px');
        }
      }
      
    }
	});
  
};