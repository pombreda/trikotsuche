<?php
abstract class WebService {
  
  var $request_uri = '';
  
  abstract protected function build_request();
  
  public function request_uri() {
    return $this->request_uri;
  }
}