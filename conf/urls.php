<?php
$urls = array(
  '^land/' => 'Countries.countries',
  '^[\w\pL]+/verein/' => 'Countries.teams',
  '^[\w\pL]+/spieler/' => 'Countries.players',
  'fanartikel/' => 'Countries.item',
  '' => 'Countries.index'
);