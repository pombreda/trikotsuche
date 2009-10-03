<?php
/*
 * Created on Sep 18, 2009
 *
 */
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
   * Get ZWS item as array.
   *
   * @param object $item
   * @return array $i
   */
  private function item_prepare($item) {
    if (!isset ($item->id)) {
      return false;
    }
    $i['id'] = $item->id;
    
    if (!isset ($item->name)) {
      $i['name'] = ZWS_NO_DATA;
    } else {
      $i['name'] = check_plain($item->name);
    }

    if (!isset ($item->program->_)) {
      $i['program'] = ZWS_NO_DATA;
    } else {
      $i['program'] = check_plain($item->program->_);
    }

    if (!isset ($item->currency)) {
      $i['currency'] = ZWS_NO_DATA;
    } else {
      $i['currency'] = check_plain($item->currency);
    }

    if (!isset ($item->price)) {
      $i['price'] = ZWS_NO_DATA;
    } else {
      $i['price'] = check_plain($item->price);
    }

    $i['url'] = '';
    $params = $this->params();
    $adspace_id = $params['adspace'];
    if (!isset ($item->url->adspace->_)) {
      if (isset($item->url->adspace)) {
        foreach ($item->url->adspace as $a) {
          if ($a->id == $adspace_id) {
            $i['url'] = check_uri($a->_);
            break;
          }
        }
      }
    } else {
      $i['url'] = check_uri($item->url->adspace->_);
    }

    if (!isset ($item->manufacturer)) {
      $i['manufacturer'] = ZWS_MANUFACTURER;
    } else {
      $i['manufacturer'] = check_plain($item->manufacturer);
    }

    if (!isset ($item->image->small)) {
      $i['image_small'] = ZWS_IMAGE_SMALL_URL;
    } else {
      $i['image_small'] = check_uri($item->image->small);
    }

    if (!isset ($item->image->medium)) {
      $i['image_medium'] = ZWS_IMAGE_MEDIUM_URL;
    } else {
      $i['image_medium'] = check_uri($item->image->medium);
    }

    if (!isset ($item->image->large)) {
      $i['image_large'] = ZWS_IMAGE_LARGE_URL;
    } else {
      $i['image_large'] = check_uri($item->image->large);
    }

    return $i;
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
    <div class="info">Hersteller: %s</div>
    <div class="info"><a href="%s">%s %s bei %s</a></div>
  </div>
</li>
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
      $path = 'i';
    }

    $item_uri = $this->path() . $path . '/'
      . $this->urify($item['name']) . '/'
      . $item['id'] . '/' . $this->padre();
    return sprintf(
      $template,
      $item['id'],
      $item_uri,
      $item['image_small'],
      $item['name'],
      $item['name'],
      $item['manufacturer'],
      $item['url'],
      $item['price'],
      $item['currency'],
      $item['program']);
  }

  function items_html($items, $path = '') {
    $html = '<ul id="items">';
    $item_template = $this->item_html();
    foreach ($items as $item) {
      $html .= $this->item_render(
        $item_template, $this->item_prepare($item), $path);
    }
    $html .= '</ul>';
    return $html;
  }

  public function item_page($item, $path = '') {
    $html = '<div id="item">';
    $item_template = $this->item_html();
    $html .= $this->item_render(
      $item_template, $this->item_prepare($item), $path);
    $html .= '</div>';
    return $html;
  }
  
  public function items_feed($items, $path = '') {
    $xml = '';
    $template = $this->feed_item_template();
    $date = date('D, d M Y H:i:s T');
    foreach ($items as $item) {
      $i = $this->item_prepare($item);
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