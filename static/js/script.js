$(function(){
  initNav();
  imp();
  linkHd();
  asyncReq();
  tabMenu();
  
  // FIXME hack
  if (document.location.href == base_url) {
    $('#pagination').hide();
  }
});

function linkHd() {
  var curr = document.location.href;
  if (curr != base_url) {
    $('#site-info').click(function(){
      document.location.href = base_url;
    });
    $('#site-info').css('cursor', 'pointer');
    $('#site-info').attr('title', 'Home');
  }
}

function asyncReq() {
  $('.async').click(function(){
    $.get($(this).attr('href'), function(data){
      $('#content-top, #pager').empty();
      $('#content').html(data);
    });
    return false;
  });
}

function imp(){
  var url = base_url + 'static/html/impressum.html';
  var imp = document.createElement('a');
  imp.setAttribute('href', url);
  imp.setAttribute('class', 'async');
  imp.setAttribute('rel', 'nofollow');
  imp.innerHTML = 'Impressum';
  document.getElementById('bottom').appendChild(imp);
}

function pager(page){
  var loc = document.location.href.replace(/\?page=\d+/, '');
  document.location.href = loc + '?page=' + page;
}

function initNav() {
  $('#nav .subnav').hide();
  var selected = readCookie('selected-subnav');
  if (selected) {
    $('#' + selected).show();
    $('#' + selected).prev('.subnav-header').addClass('active');
  }
  else {
    $('#nav .subnav:first').show();
    $('#nav .subnav-header:first').addClass('active');
  }

  $("#nav .subnav-header").click(function(){
    var subnav = $(this).next('.subnav');
    $(this).toggleClass('active');
    subnav.slideToggle(300);
    subnav.siblings('.subnav').slideUp('slow');
    $(this).siblings('.subnav-header').removeClass('active');
    createCookie('selected-subnav',subnav.attr('id'));
  });

}

function tabMenu() {
  $('.tab-content .subnav-header').hide();
  $('.tab-content').hide();

  var re = /\-(\d+)$/;
  
  var selected = readCookie('selected-tab');
  if (selected) {
    var shown = false;
    $('.tab-content').each(function(){
      var reg = new RegExp('\-' + selected + '$', 'i');
      if($(this).attr('id').match(reg)) {
        $(this).show();
        shown = true;
      }
    });
    if (!shown) {
      $('.tab-content').show();
    }
  }
  else {
    $('.tab-content:first').show();
  }
  
  // TODO implement multiple tabs using parent id
  $('.tab-header').click(function(){
    $('.tab-content').hide();
    var c_id = $(this).attr('id').replace('tab-header', 'tab-content');
    $('#' + c_id).show();
    createCookie('selected-tab', c_id.match(re)[1]);
  });
}

/**
 * cookie functions from quirksmode
 * @see http://www.quirksmode.org/js/cookies.html
 */
function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function eraseCookie(name) {
  createCookie(name,"",-1);
}