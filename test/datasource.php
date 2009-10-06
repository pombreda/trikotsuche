<?php
function __autoload($class_name) {
  $class_name = strtolower($class_name);
  require '../lib/' . $class_name . '.php';
}

$zws = new Zws();
$flickr = new Flickr();
$cache = new Cache('.', 1);
$datasource = new Datasource($zws, $cache);

$datasource->search();