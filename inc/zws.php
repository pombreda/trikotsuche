<?php
define('ZWS_IMAGE_SMALL_URL', 'no-image-small.jpg');
define('ZWS_IMAGE_MEDIUM_URL', 'no-image-medium.jpg');
define('ZWS_IMAGE_LARGE_URL', 'no-image-large.jpg');
define('ZWS_MANUFACTURER', 'N.A.');
define('ZWS_NO_DATA', 'N.A.');
/**
 * Get ZWS item as array.
 *
 * @param object $item
 * @return array $i
 */
function zwsItemAsArray($item) {
  if (!isset($item->name)) {
    $i['name'] = ZWS_NO_DATA;
  }
  else {
    $i['name'] = check_plain($item->name);
  }
  
  if (!isset($item->program->_)) {
    $i['program'] = ZWS_NO_DATA;
  }
  else {
    $i['program'] = check_plain($item->program->_);
  }
  
  if (!isset($item->currency)) {
    $i['currency'] = ZWS_NO_DATA;
  }
  else {
    $i['currency'] = check_plain($item->currency);
  }
  
  if (!isset($item->price)) {
    $i['price'] = ZWS_NO_DATA;
  }
  else {
    $i['price'] = check_plain($item->price);
  }
  
  if (!isset($item->url->adspace->_)) {
    $i['url'] = '';
  }
  else {
    $i['url'] = check_uri($item->url->adspace->_);
  }
  
  if (!isset($item->manufacturer)) {
    $i['manufacturer'] = ZWS_MANUFACTURER;
  }
  else {
    $i['manufacturer'] = check_plain($item->manufacturer);
  }
  
  if (!isset($item->image->small)) {
    $i['image_small'] = ZWS_IMAGE_SMALL_URL;
  }
  else {
    $i['image_small'] = check_uri($item->image->small);
  }
  
  if (!isset($item->image->medium)) {
    $i['image_medium'] = ZWS_IMAGE_MEDIUM_URL;
  }
  else {
    $i['image_medium'] = check_uri($item->image->medium);
  }
  
  if (!isset($item->image->large)) {
    $i['image_large'] = ZWS_IMAGE_LARGE_URL;
  }
  else {
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
function zwsItemHtml() {
  return <<<EOF
<li class="product yui-gf">
  <div class="yui-u first">
    <div class="image"><a href="%s"><img class="small" src="%s" alt="%s" /></a></div>
  </div>
  <div class="yui-u">
    <h2><a href="%s">%s</a></h2>
    <div class="info">Preis: <span class="price">%s</span> %s</div>
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
function zwsRenderItem($template, $item) {
  return sprintf(
    $template,
    $item['url'],
    $item['image_small'],
    $item['name'],
    $item['url'],
    $item['name'],
    $item['price'],
    $item['currency']
   );
}

function zwsItemsHtml($items) {
  $html = '<ul id="products">';
  $item_template = zwsItemHtml();
  foreach ($items as $item) {
    $html .= zwsRenderItem($item_template, zwsItemAsArray($item));
  }
  $html .= '</ul>';
  return $html;
}
