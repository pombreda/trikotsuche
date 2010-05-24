var ZX = {
  'callback' : function(json) {
    var html = '';
    var items = json.productItems.productItem;
    for (i in items) {
      var n = items[i].name;
      var d = items[i].descriptionLong;
      var l = items[i].trackingLinks.trackingLink.ppc;
      var m = items[i].manufacturer;
      var p = items[i].price;
      var c = items[i].currency;
      var s = items[i].program.$;
      var i = items[i].image.small;

      html += '<div class="zx_item">'
        + '<a href="'+l+'" title="'+d+'"><img src="'+i+'" alt="'+n+'" /></a>'
        + '<h3><a href="'+l+'" title="'+d+'">'+n+'</a></h3>'
        + '<ul>'
        + '<li>Hersteller: '+m+'</li>'
        + '<li>Preis: '+p+' '+c+'</li>'
        + '<li>bei: '+s+'</li>'        
        + '</ul></div>';
    }
    document.getElementById('zx_data').innerHTML=html;
  },
  'request' : function(url) {
    var script = document.createElement('script');
    script.src = url;
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);
  }
};
