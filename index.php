<?php
error_reporting(E_ERROR|E_WARNING|E_NOTICE);

// Bootstrap
$path_root_fs = getcwd() . DIRECTORY_SEPARATOR;
$path_conf = $path_root_fs . 'conf' . DIRECTORY_SEPARATOR;
$path_inc = $path_root_fs . 'inc' . DIRECTORY_SEPARATOR;
$path_lib = $path_root_fs . 'lib' . DIRECTORY_SEPARATOR;
$path_lib3rd = $path_lib . '3rd' . DIRECTORY_SEPARATOR;
$path_cache = $path_root_fs . 'cache' . DIRECTORY_SEPARATOR;
$path_templates = $path_root_fs . 'templates' . DIRECTORY_SEPARATOR;
$template_page = $path_templates . 'page.php';

// Includes
include($path_conf . 'settings.php');
include($path_conf . 'urls.php');
include($path_inc . 'common.php');
include($path_inc . 'page.php');
include($path_inc . 'page.zws.php');
include($path_inc . 'page.zws.trikot.php');

// Libraries
include($path_lib . 'cache.php');
include($path_lib3rd . 'zx_php_client_2009-02-01/zanox-api.class.php');

$path_root_www = 'http://' . $_SERVER['HTTP_HOST'] . base_path();
$path_static = $path_root_www . 'static/';

// Static files and paths
$page = array();
$page['path_img'] = $path_static . 'img/';
$page['file_js'] = $path_static . 'js/script.js';
$page['path_css'] = $path_static . 'css/';

// Query parameters
$search = $site_default_search;
$current = '';

$p = null;
$class = '';
$method = '';

$q = '';
if (isset($_REQUEST['q'])) {
  $q = $_REQUEST['q'];
}

$params = array('region' => $zws_region, 'adspace' => $zws_adspace_id);
$zx = ZanoxAPI::factory('soap');
$zx->setMessageCredentials($zws_application_id, $zws_shared_key);

foreach ($urls as $pattern => $action) {
  $re = '!' . $pattern . '!u';
  if (preg_match($re, $q)) {
    $a = explode('.', $action);
    $class = $a[0];
    $method = $a[1];
    $p = new $class($path_root_www, $zx);
    $p->params($params);
    $p->$method();
    break;
  }
}

if (!$p) {
  header('Location: ' . $path_root_www, TRUE, 302);
  exit();
}

$title = ucwords(check_plain($p->topic()));
$page['base_url'] = $path_root_www;
$page['site_name'] = $site_name;
$page['site_slogan'] = $site_slogan;
$page['title'] = $title . ' - Trikots suchen und kaufen';
$page['search_display'] = $page['title'];
$page['search_info'] = '';
$page['content'] = 'Keine Ergebnisse';
$page['pager'] = '';
$page['left'] = $p->box('left');
$page['right'] = $p->box('right');
$page['footer'] = $site_footer;

#var_dump($title, $q);
$cache_id = md5($title . $q . $p->num());
$cache = new Cache($path_cache, 86400, true);
$result = null;

if (false === ($result = $cache->get($cache_id))) {
  $result = $p->content();
  if (is_array($result) || is_object($result)) {
    $cache->set($cache_id, $result);
  }
}

if (isset($result->productsResult->productItem)) {
  $path = 'fanartikel';
  $item = $result->productsResult->productItem;
  if (isset($result->total)) {
    $page['search_info'] = 'Suchergebnisse: ' . $result->total;
    $page['content'] = $p->items_html($item, $path);
    $page['pager'] = $p->pager($result->total, $zws_item_count);
  }
  else {
    $page['content'] = $p->item_page($item, $path);
  }
}
elseif (is_string($result)) {
  $page['content'] = $result;
}

#var_dump($page['content']);
#debug_print_backtrace();
$p->render($page, $template_page);
