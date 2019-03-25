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
  private $kali = false;

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
      case 'kali':
        $this->kali = $value;
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

  public function startVM(CommandHandler $controller){
    return $controller->secureCommand("vmrun start \"".$this->getPath()."\"");
  }

  // public function startSSH($controller){
  //   return $controller->secureCommand("putty ".$this->getIP());
  // }

  public function exec(CommandHandler $controller, $command){
    $controller->secureCommand("vmrun -T ws -gu ".$this->getRootUser()." -gp ".$this->getRootPass()." runScriptInGuest '".$this->getPath()."' '/bin/bash' \"".htmlentities($command)." 2>error 1>/tmp.cmd\"");
    $controller->secureCommand("vmrun  -T ws -gu ".$this->getRootUser()." -gp ".$this->getRootPass()." CopyFileFromGuestToHost \"".$this->getPath()."\" /tmp.cmd ./tmp");
    $controller->secureCommand("vmrun  -T ws -gu ".$this->getRootUser()." -gp ".$this->getRootPass()." CopyFileFromGuestToHost \"".$this->getPath()."\" /error ./error");
    return file_get_contents("tmp");
  }
  public function debug_exec(){
    return "CopyFileFromGuestToHost \"".$this->getPath()."\" /tmp/commandoutput ./tmp";
  }

  public function stopVM(CommandHandler $controller){
    return $controller->secureCommand("vmrun stop \"".$this->getPath()."\"");
  }

  public function getScreenshot(CommandHandler $controller, $id){
    if ($this->getRootPass() !== null) {
      return $controller->secureCommand('vmrun -T ws -gu "'.$this->getRootUser().'" -gp "'.$this->getRootPass().'" captureScreen "'.$this->getPath().'" "assets/img/'.$id.'.png"');
    } else {
      return "Root password not set";
    }
  }

  public function getSnapshots(CommandHandler $controller){
    $this->snapshots = preg_split('/$\R?^/m', $controller->secureCommand("vmrun listSnapshots  \"".$this->getPath()."\""));
    return $this->snapshots;
  }

  public function revertToSnapshot(CommandHandler $controller, $id){
    $snap = $controller->secureCommand("vmrun revertToSnapshot \"".$this->getPath()."\" \"".trim($this->getSnapshots($controller)[$id])."\"");
    $this->startVM($controller);
    return $snap;
  }

  public function isLocal(){
    return $this->local;
  }
  public function iskali(){
    return $this->kali;
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
