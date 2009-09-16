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
include($path_inc . 'countries.php');
include($path_inc . 'zws.php');

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

foreach ($urls as $pattern => $action) {
  $re = '!' . $pattern . '!msi';
  if (preg_match($re, $q)) {
    $a = explode('.', $action);
    $class = $a[0];
    $method = $a[1];
    $p = new $class();
    $p->$method();
    break;
  }
}

if (!$p) {
  header('Location: ' . $path_root_www, TRUE, 302);
  exit();
}

$parent = $p->padre();

$page_num = $zws_page;
if (isset($_REQUEST['page'])) {
  $page_num = $_REQUEST['page'];
}

$item_total_count = 0;
$search = trim($p->topic() . ' ' . $site_topic);
$search_display = ucwords(check_plain($search));

$page['base_url'] = $path_root_www;
$page['site_name'] = $site_name;
$page['site_slogan'] = $site_slogan;
$page['title'] = $search_display . ' suchen und kaufen';
$page['search_display'] = $search_display;
$page['search_info'] = '';
$page['content'] = 'Keine Ergebnisse';
$page['pager'] = '';
$page['left'] = $p->menu('nav', $p->countries(), $path_root_www . 'land/');
$page['right'] = '';

$teams = $p->teams();
if (isset($teams[$parent])) {
  $page['right'] .= $p->menu_items($teams[$parent], 'Vereine', $path_root_www . $parent . '/verein/');
}
$players = $p->players();
if (isset($players[$parent])) {
  $page['right'] .= $p->menu_items($players[$parent], 'Spieler', $path_root_www . $parent . '/spieler/');
}

$page['footer'] = $site_footer;

$cache_id = md5($search . $page_num);
$cache = new Cache($path_cache, 86400, true);
$result = null;

if (false === ($result = $cache->get($cache_id))) {
  $params = array('region' => $zws_region, 'adspace' => $zws_adspace_id);
  $zx = ZanoxAPI::factory('soap');
  $zx->setMessageCredentials($zws_application_id, $zws_shared_key);
  $result = $zx->searchProducts($search, $params, $page_num, $zws_item_count);

  if (isset($result->total) && $result->total > 0) {
    $cache->set($cache_id, $result);
  }
  else {
    $result = null;
  }
}

if ($result) {
  $page['search_info'] = 'Suchergebnisse: ' . $result->total;
  $page['content'] = zwsItemsHtml($result->productsResult->productItem);
  $page['pager'] .= $p->pager($result->total, $zws_item_count, $result->page);
}

$p->render($page, $template_page);