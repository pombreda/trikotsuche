<?php
require 'slim/Slim.php';

Slim::init();

//GET routes
Slim::get('/land/:country', 'country');
function country($country) {
    var_dump($country);
}

Slim::get('/:country/verein/:team', 'team');
function team($country, $team) {
    var_dump($country, $team);
}

Slim::get('/:country/spieler/:name', 'player');
function player($country, $name) {
    var_dump($country, $name);
}

Slim::get('/fanartikel/:uri_title/:id/(:country)', 'item');
function item($uri_title, $id, $country = '') {
    var_dump($uri_title, $id, $country);
}

Slim::run();
