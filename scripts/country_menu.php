<?php
$cwd = dirname(__FILE__);
$csv = $argv[1];
$path = $argv[2];

$countries_by_continent = countries_by_continent($csv);
ksort($countries_by_continent);
echo country_menu($countries_by_continent, $path);

function countries_by_continent($csv) {
  $countries_by_continent = array();
  if (FALSE !== ($fh = fopen($csv, 'r'))) {
    while (FALSE !== ($data = fgetcsv($fh, 1000, ';', '"'))) {
      $country = $data[0];
      $continent = $data[1];
      if (!isset($countries_by_continent[$continent])) {
        $countries_by_continent[$continent] = array();
      }
      array_push($countries_by_continent[$continent], $country);
    }
    fclose($fh);
  }
  return $countries_by_continent;
}

function country_menu($countries_by_continent, $path) {
  $html = '';
  foreach ($countries_by_continent as $continent => $countries) {
    $li = '';
    asort($countries);
    foreach ($countries as $c)
      $li .= tag('li', array(), tag('a', array('href' => $path . urlencode($c)), $c));
    $html .= tag('li', array(), tag('a', array('href' => '#'), $continent) . tag('ul', array(), $li));
  }
  return tag('div', array('class' => 'menu'), tag('ul', array(), $html));
}

# FIXME move to common.inc
function tag($elt, array $attr = array(), $c = '') {
  $sattr = '';
  if ($attr)
    foreach ($attr as $k => $v)
      $sattr .= sprintf(' %s="%s"', $k, $v);
  if ($c)
    $tag = sprintf('<%s%s>%s</%s>', $elt, $sattr, $c, $elt);
  else
    $tag = sprintf('<%s%s />', $sattr, $elt);
  return $tag;
}