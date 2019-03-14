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
  private $snapshots;

  function __construct($l="", $p="", $n="", $d = "") {
    $this->local = $l;
    $this->path = $p;
    $this->name = $n;
    $this->description = $d;
  }

  public function setFromPost($key, $value){
    $value = htmlentities($value);
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

  public function startVM($controller){
    return $controller->secureCommand("vmrun start \"".$this->getPath()."\"");
  }

  public function stopVM($controller){
    return $controller->secureCommand("vmrun stop \"".$this->getPath()."\"");
  }

  public function getScreenshot($controller, $id){
    if ($this->getRootPass() !== null) {
      return $controller->secureCommand('vmrun -T ws -gu "'.$this->getRootUser().'" -gp "'.$this->getRootPass().'" captureScreen "'.$this->getPath().'" "assets/img/'.$id.'.png"');
    } else {
      return "Root password not set";
    }
  }

  public function getSnapshots($controller){
    $this->snapshots = preg_split('/$\R?^/m', $controller->secureCommand("vmrun listSnapshots  \"".$this->getPath()."\""));
    return $this->snapshots;
  }

  public function revertToSnapshot($controller, $id){
    $snap = $controller->secureCommand("vmrun revertToSnapshot \"".$this->getPath()."\" \"".trim($this->getSnapshots($controller)[$id])."\"");
    $this->startVM($controller);
    return $snap;
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
