<?php
function renderPage($page, $template) {
  header('Content-Type: text/html');
  include_once($template);
}
function pager($total, $limit, $page) {
  $html = '';
  if ($total > $limit && $limit != 0) {
    $max_page = ceil($total / $limit) - 1;
    $html .= '<div id="pagination">';
    # previous link
    if ($page > 0) {
      $html .= sprintf('<a onclick="pager(%d)">&lt;&lt;</a>', 0);
      $html .= '&nbsp;&nbsp;';
      $html .= sprintf('<a onclick="pager(%d)">&lt;</a>', $page -1);
    }
    $html .= sprintf('<span class="pager-info">%d von %d</span>', $page + 1, $max_page + 1);
    # next link
    if ($max_page > $page) {
      $html .= sprintf('<a onclick="pager(%d)">&gt;</a>', $page + 1);
      $html .= '&nbsp;&nbsp;';
      $html .= sprintf('<a onclick="pager(%d)">&gt;&gt;</a>', $max_page);
    }
    
    $html .= '</div>';
  }
  return $html;
}
function renderCountries() {
  global $path_root_www; # ugly
  $html = '<div id="nav">';
  $template = '<li><a href="%s">%s</a></li>';
  $countries = countries();
  foreach ($countries as $continent => $countries) {
    $html .= sprintf('<h3 class="subnav-header">%s</h3>', $continent);
    $html .= sprintf('<ul class="subnav" id="%s">', strtolower($continent));
    foreach($countries as $country) {
       $path = $path_root_www . 'land/' . strtolower($country);
      $html .= sprintf($template, $path, $country);
    }
    $html .= '</ul>';
  }
  $html .= '</div>';
  return $html;
}
function countries() {
  return array(
    'Europa' => array(
      'Deutschland',
      'England',
      'Spanien',
      'Italien',
      'Portugal',
      'Türkei',
      'Frankreich',
      'Holland',
      'Schweden',
      'Schweiz',
      'Dänemark',
    ),
    'Amerika' => array(
      'Brasilien',
      'Argentinien',
      'Mexiko',
      'Chile',
      'USA',
    ),
    'Afrika' => array(
      'Elfenbeinküste',
      'Südafrika',
      'Nigeria',
      'Ägypten',
    ),
    'Asien' => array(
      'Japan',
      'Südkorea'
    ),
    'Ozeanien' => array(
      'Australien',
    )
  );
}