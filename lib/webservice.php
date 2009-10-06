<?php
abstract class WebService {
  
  var $request_uri = '';
  
  abstract protected function build_request();
  
  public function __toString() {
    #var_dump($this);
    return get_class($this);
  }
  
  public function request_uri() {
    return $this->request_uri;
  }
  
  public function request($request) {
    
  }
}