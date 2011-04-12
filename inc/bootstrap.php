<?php
$path_root = dirname(dirname(__FILE__)) . '/';
$path_conf = $path_root . 'conf/';
$path_inc = $path_root . 'inc/';
$path_lib = $path_root . 'lib/';

include $path_conf . 'settings.php';

include $path_inc . 'common.php';

include $path_lib . 'cache.php';
include $path_lib . 'wsclient.php';
include $path_lib . 'datasource.php';