<?php
class VM {
  private $local = true;
  private $path = "";
  private $name = "";
  private $description = "";
  private $ip;
  private $sshuser;
  private $sshpass;
  private $rootuser;
  private $rootpass;

  function __construct($l="", $p="", $n="", $d = "") {
    $this->local = $l;
    $this->path = $p;
    $this->name = $n;
    $this->description = $d;
  }

  public function setFromPost($key, $value){
    switch ($key) {
      case 'local':
        $this->local = $value;
        break;
      case 'path':
        $this->path = $value;
        break;
      case 'name':
        $this->name = $value;
        break;
      case 'description':
        $this->description = $value;
        break;
      case 'ip':
        $this->ip = $value;
        break;
      case 'sshuser':
        $this->sshuser = $value;
        break;
      case 'sshpass':
        $this->sshpass = $value;
        break;
      case 'rootuser':
        $this->rootuser = $value;
        break;
      case 'rootpass':
        $this->rootpass = $value;
        break;
      default:
        return false;
        break;
    }
  }

  public function isLocal(){
    return $this->local;
  }
  public function getPath(){
    return $this->path;
  }
  public function getName(){
    return $this->name;
  }
  public function getDescription(){
    return $this->description;
  }
  public function getIP(){
    return $this->ip;
  }
  public function setIP($ip){
    return $this->ip = $ip;
  }
  public function getSshUser(){
    return $this->sshuser;
  }
  public function getSshPass(){
    return $this->sshpass;
  }
  public function getRootUser(){
    return $this->rootuser;
  }
  public function getRootPass(){
    return $this->rootpass;
  }
}
?>
