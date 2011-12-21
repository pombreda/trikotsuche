<?php
error_reporting(E_NOTICE | E_WARNING | E_ERROR);
header('Content-Type: text/plain');
include_once('../conf/settings.php');
include_once('../lib/3rd/zanox/client/ApiClient.php');

#$params = array('region' => $zws_region, 'adspace' => $zws_adspace_id);
$zx = ApiClient::factory(PROTOCOL_JSON, VERSION_2011_03_01);
$zx->setConnectId($zws_connect_id);
$zx->setSecretKey($zws_secret_key);
$zx->setPublicKey($zws_public_key);

foreach (range(0,2) as $idx)
    var_dump(search($zx, $idx));

function search($zx, $page) {
  return $zx->searchProducts(
    'trikot',
    'phrase',
  null,
  null,
  array(),
  true,
  0,
  null,
  994828,
  $page,
  10
  );
}