<?php
# FIXME hard coded urls
define('ZWS_IMAGE_SMALL_URL', 'http://www.trikotsuche.de/static/img/no-image-small.jpg');
define('ZWS_IMAGE_MEDIUM_URL', 'http://www.trikotsuche.de/static/img/no-image-medium.jpg');
define('ZWS_IMAGE_LARGE_URL', 'http://www.trikotsuche.de/static/img/no-image-large.jpg');
define('ZWS_MANUFACTURER', 'N.A.');
define('ZWS_NO_DATA', 'N.A.');

abstract class PageZws extends Page {
  public function __construct($client) {
    parent::__construct();
    $this->client = $client;
  }
  
  protected function client() {
    return $this->client;
  }

  /**
   * Get HTML template for single item.
   *
   * @param void
   * @return string
   */
  function item_html() {
    return<<<EOF
<li class="item" id="id-%s">
  <div class="left">
    <div class="image"><a href="%s"><img class="small" src="%s" alt="%s" /></a></div>
  </div>
  <div class="right">
    <h4>%s</h4>
    <div class="info small">Hersteller: <a href="%s">%s</a></div>
    <div class="link small" rel="nofollow"><a href="%s">%s %s bei %s</a></div>
  </div>
</li>
EOF;
  }
  
  function item_page_html() {
    return<<<EOF
<div class="left">
  <div class="image"><img class="large" src="%s" alt="%s" /></div>
</div>
<div class="right">
  <h4>%s</h4>
  <div class="info">Hersteller: <a href="%s">%s</a></div>
  <div class="link" rel="nofollow"><a href="%s">%s %s bei %s</a></div>
</div>
EOF;
  }

  /**
   * Render item for display.
   *
   * @param void
   * @return string
   */
  function item_render($template, $item, $path = '') {
    if (!$path) {
      $path = 'fanartikel';
    }
    $item_uri = $this->path() . $path . '/'
      . $this->urify($item['name']) . '/'
      . $item['id'] . '/' . $this->padre();
    if (!$item['image_small']) {
      $item['image_small'] = ZWS_IMAGE_SMALL_URL;
    }
    $manufacturer_search = $this->path() . 'hersteller/' . urlencode($item['manufacturer']);
    return sprintf(
      $template,
      $item['id'],
      $item_uri,
      $item['image_small'],
      $item['name'],
      $item['name'],
      $manufacturer_search,
      $item['manufacturer'],
      $item['url'],
      $item['price'],
      $item['currency'],
      $item['program']);
  }
  
  function item_page_render($template, $item) {
    if (!$item['image_large']) {
      $item['image_large'] = ZWS_IMAGE_LARGE_URL;
    }
    $manufacturer_search = $this->path() . 'hersteller/' . urlencode($item['manufacturer']);
    return sprintf(
      $template,
      $item['image_large'],
      $item['name'],
      $item['name'],
      $manufacturer_search,
      $item['manufacturer'],
      $item['url'],
      $item['price'],
      $item['currency'],
      $item['program']);
  }

  function items_html($items, $path = '') {
    $html = '<ul id="items">';
    $template = $this->item_html();
    foreach ($items as $item) {
      $html .= $this->item_render(
        $template, $item, $path);
    }
    $html .= '</ul>';
    return $html;
  }

  public function item_page($item, $path = '') {
    $uri = $this->uri();
    $html = '<div id="item_page">';
    $template = $this->item_page_html();
    $html .= $this->item_page_render($template, $item);
    $html .= '</div>';
    $html .= '<div id="social" class="clear">';
    $html .= '<div class="floatl"><iframe src="http://www.facebook.com/plugins/like.php?href=' . urlencode($uri) . '&amp;layout=box_count&amp;show_faces=false&amp;width=50&amp;action=like&amp;colorscheme=light&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:65px;" allowTransparency="true"></iframe></div>';
    $html .= '<div class="floatl"><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>';
    $html .= '</div>';
    return $html;
  }
  
  public function items_feed($items, $path = '') {
    $xml = '';
    $template = $this->feed_item_template();
    $date = date('D, d M Y H:i:s T');
    foreach ($items as $item) {
      $i = $item;
      $xml .= sprintf($template,
        $i['name'],
        $i['url'],
        $i['manufacturer'],
        $date,
        $i['url'],
        $i['image_large'],
        'image/jpeg'
      );
    }
    return $xml;
  }
  
  /**
   * FIXME use media:rss instead of enclosure, enclosure requires length
   */
  public function feed_item_template() {
    return <<<EOF
<item>
<title>%s</title>
<link>%s</link>
<description>%s</description>
<pubDate>%s</pubDate>
<guid isPermaLink="true">%s</guid>
<enclosure url="%s" type="%s" /></item>
EOF;
  }
}