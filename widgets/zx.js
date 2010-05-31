var ZX = {
  'callback' : function(json) {
    var html = '';
    var items = json.productItems.productItem;
    if (1 < json.items) {
      for (i in items) {
        var n = items[i].name;
        var d = items[i].descriptionLong;
        var l = items[i].trackingLinks.trackingLink.ppc;
        var m = items[i].manufacturer;
        var p = items[i].price;
        var c = items[i].currency;
        var s = items[i].program.$;
        var i = items[i].image.small;
        html += ZX.renderItem(n, d, l, m, p, c, s, i);
      }
    }
    else if (1 == json.items) {
      var n = items.name;
      var d = items.descriptionLong;
      var l = items.trackingLinks.trackingLink.ppc;
      var m = items.manufacturer;
      var p = items.price;
      var c = items.currency;
      var s = items.program.$;
      var i = items.image.small;
      html += ZX.renderItem(n, d, l, m, p, c, s, i);
    }
    document.getElementById('zx_data').innerHTML=html;
  },
  'request' : function(url) {
    var script = document.createElement('script');
    script.src = url;
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);
  },
  'renderItem' : function(n, d, l, m, p, c, s, i) {
    return '<div class="zx_item">'
      + '<a target="_top" href="'+l+'" title="'+d+'"><img src="'+i+'" alt="'+n+'" /></a>'
      + '<h3><a target="_top" href="'+l+'">'+n+'</a></h3>'
      + '<ul>'
      + '<li>Hersteller: '+m+'</li>'
      + '<li>Preis: '+p+' '+c+'</li>'
      + '<li>bei: '+s+'</li>'        
      + '</ul></div>';
  }
};
