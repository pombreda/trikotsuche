<?php
/**
 * Datasource class acts as an adapter for data requests.
 */
class Datasource {
  
  /**
   * @var WebService
   */
  protected $web_service;
  
  /**
   * @var Cache
   */
  protected $cache;
  
  public function __construct($web_service, $cache) {
    $this->web_service = $web_service;
    $this->cache = $cache;

    var_dump($this);
  }
}