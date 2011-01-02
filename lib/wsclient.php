<?php
define('PATH_LIB', dirname(__FILE__) . DIRECTORY_SEPARATOR);

abstract class WSClient {
  
  var $request_uri = '';
  
  var $result_meta = array();
  
  abstract protected function build_request();
  
  public function __toString() {
    #var_dump($this);
    return get_class($this);
  }
  
  public function request_uri() {
    return $this->request_uri;
  }
  
  public function result_meta($result_meta = array()) {
    if ($result_meta) {
      $this->result_meta = $result_meta;
    }
    return $this->result_meta;
  }
}