$(function(){
  newPage();
  footerLinks();
  linkHd();
  asyncReq();
  tabMenu();
  ('localhost' == document.location.host) && localFix();//FIXME
});

function newPage() {
  $('a:not([href="#"])').click(function(e){
    (1 != e.button) && loading();
  });
}

function localFix() {
  $('a').click(function(){
    var e = $(this);
    e.attr('href', e.attr('href').replace('http://trikotsuche.de/', 'http://localhost/trikotsuche.de/'));
  });
}

function linkHd() {
  var curr = document.location.href;
  if (curr != base_url) {
    $('#site_info').click(function(){
      document.location.href = base_url;
    });
    $('#site_info').css('cursor', 'pointer');
    $('#site_info').attr('title', 'Home');
  }
}

function asyncReq() {
  $('.async').click(function(){
    $.get($(this).attr('href'), function(data){
      $('#content_top, #pager').empty();
      $('#content').html(data);
    });
    return false;
  });
}

function footerLinks(){
  $('#bottom').append(document.createElement('ul'));
  imp();
  he();
}

function imp(){
  var url = base_url + 'static/html/impressum.html';
  var imp = document.createElement('a');
  imp.setAttribute('href', url);
  imp.setAttribute('class', 'async');
  imp.setAttribute('rel', 'nofollow');
  imp.innerHTML = 'Impressum';
  var li = document.createElement('li');
  $('#bottom ul').append(li.appendChild(imp));
}

function he(){
  var html = '<li><a href="http://affiliate.hosteurope.de/click.php/6pOQgQ-8ti4wxqwPeXT0CYbBR3TImb76L6lq-qdeUBw," title="hosted by Host Europe">hosted by Host Europe</a><img src="http://affiliate.hosteurope.de/view.php/6pOQgQ-8ti4wxqwPeXT0CYbBR3TImb76L6lq-qdeUBw," alt=""/></li>';
  $('#bottom ul').append(html);
}

function pager(page){
  var loc = document.location.href.replace(/\?page=\d+/, '');
  document.location.href = loc + '?page=' + page;
}

function tabMenu() {
  $('.tab_content .subnav_header').hide();
  $('.tab_content').hide();

  var re = /\-(\d+)$/;
  
  var selected = readCookie('selected_tab');
  if (selected) {
    var shown = false;
    $('.tab_content').each(function(){
      var reg = new RegExp('\-' + selected + '$', 'i');
      if($(this).attr('id').match(reg)) {
        var c_id = $(this).attr('id').replace('tab_content', 'tab_header');
        $('#' + c_id).addClass('active');
        $(this).show();
        shown = true;
      }
    });
    if (!shown) {
      $('.tab_content').show();
      $('.tab_header').addClass('active');
    }
  }
  else {
    $('.tab_content:first').show();
    $('.tab_header:first').addClass('active');
  }
  // TODO implement multiple tabs using parent id
  $('.tab_header').click(function(){
    $('.tab_content').hide();
    $(this).toggleClass('active');
    $(this).siblings('.tab_header').removeClass('active');
    var c_id = $(this).attr('id').replace('tab_header', 'tab_content');
    $('#' + c_id).show();
    createCookie('selected_tab', c_id.match(re)[1]);
  });
}

function loading() {
  $('body').append('<div id="darkbox" class="fg_overlay"></div><div class="bg_overlay"></div>');
  appender = loadingText('darkbox', 'Loading');
  setInterval("appender(' .')", 100);
}

function loadingText(id, t) {
  var b = document.getElementById(id);
  b.innerHTML = t;
  return function (c) {
    b.innerHTML += c;
  }
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
