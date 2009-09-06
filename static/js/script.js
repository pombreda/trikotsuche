$(function(){
  imp();
  asyncReq();
});

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