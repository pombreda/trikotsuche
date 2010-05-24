<?php
error_reporting(E_NOTICE | E_WARNING | E_ERROR);
header('Content-Type: text/plain');
include_once('../conf/settings.php');
include_once('../lib/3rd/zxapiclient_2009_07_01/ApiClient.php');

#$params = array('region' => $zws_region, 'adspace' => $zws_adspace_id);
$zx = ApiClient::factory(PROTOCOL_JSON, VERSION_2009_07_01);
$zx->setConnectId($zws_connect_id);
$zx->setSecretKey($zws_secret_key);
$zx->setPublicKey($zws_public_key);

#$result = $zx->searchProducts('trikot', $params, 0, 10);
$result = json_decode($zx->getProgramsByAdspace(961381, 0, 50));
foreach ($result->programItems->programItem as $i) {
  printf("%d\t%s\n", $i->{'@id'}, $i->name);
}
#var_dump($result);