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
    $this->$local = $l;
    $this->$path = $p;
    $this->$name = $n;
    $this->description = $d;
  }

  public function isLocal(){
    return $this->$local;
  }
}
?>
