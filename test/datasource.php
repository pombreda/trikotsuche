<?php
require '../inc/bootstrap.php';
require '../lib/zws.php';
require '../lib/flickr.php';

//function __autoload($class_name) {
//  $class_name = strtolower($class_name);
//  require '../lib/' . $class_name . '.php';
//}

$zws = new Zws($zws_connect_id, $zws_public_key, $zws_secret_key, $zws_adspace_id);
$flickr = new Flickr();
$cache = new Cache('.', 1);
$datasource = new Datasource($zws, $cache);

$zws->search('trikot spanien');