var Zws = {
  /**
   * function to add scripts to html header
   */
  addScript : function(url) {
    var script = document.createElement('script');
    // preventing caching of the Web Service call by adding timestamp
    script.src = url + '&t=' + new Date().getMinutes(); 
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);
  },

  /**
   * zanox product search
   * @see http://wiki.zanox.com/en/Products_Resource
   */
  productSearch : function(version, applicationid, adspace, region, programs, minPrice, maxPrice, category, page, items, q, callback) {
    var url = 'http://api.zanox.com/json/' + version + '/products?applicationid=' + applicationid;
    if (adspace) url += '&adspace=' + adspace;
    if (region) url += '&region=' + region;
    if (programs) url += '&programs=' + programs;
    if (category) url += '&category=' + category;
    if (page) url += '&page=' + page;
    if (items) url += '&items=' + items;
    if (minPrice) url += '&minPrice=' + minPrice;
    if (maxPrice) url += '&maxPrice=' + maxPrice;
    if (callback) url += '&callback=' + callback;
    if (q) url += '&q=' + q;
    Zws.addScript(url);
    console.log(url);
  },
  
  handler : function(data) {
    if (data.productsResult) {
      var items = data.productsResult.productItem;
      // ID of a UL HTML element
      var zxAdList = document.getElementById('zxAdList');
      for (var i = 0; i < items.length; i++) {
        var item = items[i];
        var link = '';
        if (item.url.adspace instanceof Array) {
          // select tracking link related to the first Adspace
          link = item.url.adspace[0].$;
        }
        else {
          link = item.url.adspace.$;
        }
        var content = item.name + ' bei ' + item.program.$ + ' für ' + item.price + ' ' + item.currency;
        Zws.renderItem(content, link, zxAdList);
      }
    }
  },

  renderItem : function(content, link, container) {
    var li = document.createElement("li");
    li.innerHTML = '<a href="' + link + '">' + content + '</a>';  
    container.appendChild(li);
  }
};