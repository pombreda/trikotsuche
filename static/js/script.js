$(function(){
  initNav();
  imp();
  linkHd();
  asyncReq();
  tabMenu();
});

function linkHd() {
  var curr = document.location.href;
  if (curr != base_url) {
    $('#hd').click(function(){
      document.location.href = base_url;
    });
    $('#hd').css('cursor', 'pointer');
    $('#hd').attr('title', 'Home');
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
  }
  else {
    $('#nav .subnav:first').show();
  }
  $('#nav .subnav-header').click(function(){
    $('#nav .subnav').hide();
    var subnav = $(this).next('.subnav');
    subnav.css('display', 'block');
    createCookie('selected-subnav',subnav.attr('id'));
  });
}

function tabMenu() {
  $('#right ul.subnav').hide();
  $('#right ul.subnav:first').show();
  
  var html = '<ul class="tab-menu">';
  $('#right .subnav-header').each(function(){
    html += '<li>' + $(this).html() + '</li>';
    $(this).hide();
  });
  html += '</ul>';
  $('#right').prepend(html);
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