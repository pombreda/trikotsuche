<?php
function renderPage($page, $template) {
  header('Content-Type: text/html');
  include_once($template);
}
function pager($total, $limit, $page) {
  $html = '';
  if ($total > $limit && $limit != 0) {
    $max_page = ceil($total / $limit) - 1;
    $html .= '<div id="pagination" class="">';
    $html .= sprintf('<div>Seite %d von %d</div>', $page, $max_page);
    $html .= sprintf('<div>Gesamt %d, Anzahl %d</div>', $total, $limit);
    # previous link
    if ($page > 0) {
      $html .= sprintf('<a onclick="pager(%d)">&lt;&lt;</a>', $page -1);
    }
    # next link
    if ($max_page > $page) {
      $html .= sprintf('<a onclick="pager(%d)">&gt;&gt;</a>', $page + 1);
    }
    
    $html .= '</div>';
  }
  return $html;
}
function renderCountries() {
  global $path_root_www; # ugly
  $html = '<ul>';
  $template = '<li><a href="%s">%s</a></li>';
  $countries = countries();
  foreach ($countries as $country) {
    $path = $path_root_www . 'land/' . strtolower($country);
    $html .= sprintf($template, $path, $country);
  }
  $html .= '</ul>';
  return $html;
}
function countries() {
  return array(
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
    'Brasilien',
    'Argentinien',
    'Mexiko',
    'Chile',
    'USA',
    'Elfenbeinküste',
    'Südafrika',
    'Nigeria',
    'Ägypten',
    'Japan',
    'Südkorea'
  );
}