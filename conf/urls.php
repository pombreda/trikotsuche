<?php
$urls = array(
  '^land/' => 'Trikot.countries',
  '^[\w\pL]+/verein/' => 'Trikot.teams',
  '^[\w\pL]+/spieler/' => 'Trikot.players',
  '^fanartikel/' => 'Trikot.item',
  '^tags/.+' => 'Trikot.tags',
  '^hersteller/.+' => 'Trikot.manufacturer',
  '^s/' => 'Trikot.search',
  '^sitemap.xml$' => 'Trikot.xml_sitemap',
  '^$' => 'Trikot.index'
);
