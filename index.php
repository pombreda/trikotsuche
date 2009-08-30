<?php
#error_reporting(E_ERROR|E_WARNING|E_NOTICE);
// Bootstrapping
$path_root = getcwd() . DIRECTORY_SEPARATOR;





// include zanox API client library
var_dump();die;
require_once '/usr/local/lib/php/zx_php_client_2009-02-01/zanox-api.class.php';
$zx = ZanoxAPI::factory('soap');
$zx->setMessageCredentials($application_id, $shared_key);

#var_dump($zx->getProgramsByAdspace($adspace_id));die;

$params = array('region' => 'de', 'adspace' => $adspace_id);
$result = $zx->searchProducts('deutschland trikot', $params, $page, $products);
$page = $result->page;
$item_total_count = $result->total;
$item_count = $result->items;

if ($item_total_count > 0) {
  foreach ($result->productsResult->productItem as $item) {
    echo renderItem($item);
  }
}

function renderItem($item) {
#  var_dump($item);
  $name = $item->name;
  $program = $item->program->_;
  $manufacturer = $item->manufacturer;
  $program = $item->program->_;
  $currency = $item->currency;
  $price = $item->price;
  $image_small = $item->image->small;
  $image_medium = $item->image->medium;
  $image_large = $item->image->large;
  $url = $item->url->adspace->_;
  
  $template = itemTemplate();
  return sprintf($template, $url, $name, $url, $image_small, $name, $price, $currency);
}

function itemTemplate() {
  return <<<EOF
<li class="product">
<h2><a href="%s">%s</a></h2>
<div class="image"><a href="%s"><img class="small" src="%s" alt="%s" /></a></div>
<div class="info">Preis: <span class="price">%s</span> %s</div>
</li>
EOF;
}