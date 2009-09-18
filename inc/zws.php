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
  if (!isset($item->id)) {
    return false;
  }
  $i['id'] = $item->id;
  
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
function zwsRenderItem($template, $item, $p) {
  $item_path = $p->path() . 'fanartikel/' . $p->urify($item['name']) . '/' . $item['id'] . '/' . $p->padre();
  return sprintf(
    $template,
    $item['id'],
    $item_path,
    $item['image_small'],
    $item['name'],
    $item['name'],
    $item['manufacturer'],
    $item['url'],
    $item['price'],
    $item['currency'],
    $item['program']
   );
}

function zwsItemsHtml($items, $p) {
  $html = '<ul id="items">';
  $item_template = zwsItemHtml();
  foreach ($items as $item) {
    $html .= zwsRenderItem($item_template, zwsItemAsArray($item), $p);
  }
  $html .= '</ul>';
  return $html;
}

function zwsItem($item, $p) {
  $html = '<div id="item">';
  $item_template = zwsItemHtml();
  $html .= zwsRenderItem($item_template, zwsItemAsArray($item), $p);
  $html .= '</div>';
  return $html;
}