<?php
include('../conf/settings.php');
include('../lib/3rd/zx_php_client_2009-02-01/zanox-api.class.php');

$params = array('region' => $zws_region, 'adspace' => $zws_adspace_id);
$zx = ZanoxAPI::factory('soap');
$zx->setMessageCredentials($zws_application_id, $zws_shared_key);
#$result = $zx->searchProducts('trikot', $params, 0, 10);
$result = $zx->getProduct('2951342e36e21506e05a0cd42308eade');
var_dump($result);