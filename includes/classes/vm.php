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

  function __construct($l, $p, $n, $d = "") {
    $this->local = $l;
    $this->path = $p;
    $this->name = $n;
    $this->description = $d;
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
