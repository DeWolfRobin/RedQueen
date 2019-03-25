<?php
class CommandHandler {
  private static $instance = null;
  private $VMs;
  private $projects;
  private $activeVM;
  private $activeProject;

  function __construct() {
    $this->VMs = [];
    $this->projects = [];
  }

//Singleton
  public static function getInstance()
  {
    if (self::$instance == null)
    {
      self::$instance = new CommandHandler();
    }

    return self::$instance;
  }

  public function secureCommand($c){
    return shell_exec($c);
  }

  public function getVMs(){
    return $this->VMs;
  }
  public function getKali(){
    foreach ($this->VMs as $key => $vm) {
      if ($vm->isKali()) {
        return $vm;
      }
    }
    return $this->VMs;
  }
  public function getActiveVM(){
    return $this->activeVM;
  }
  public function setActiveVM(VM $v){
    return $this->activeVM = $v;
  }

  public function getProjects(){
    return $this->projects;
  }

  public function getActiveVMs(){
    $list = preg_split('/$\R?^/m', shell_exec("vmrun list"));
    unset($list[0]);
    $xlist = [];
    foreach ($list as $listkey => $pathname) {
      foreach ($this->VMs as $VMkey => $VM) {
        if (trim($pathname) == trim($VM->getPath())) {
          $xlist[sizeof($xlist)] = $VM;
        }
      }
    }
    return $xlist;
  }

  public function getActiveTitle(){
    return preg_split('/$\R?^/m', shell_exec("vmrun list"))[0];
  }

  public function setVMs(VM ...$vms){
    $this->VMs = $vms;
    return $this->VMs;
  }

  public function addVM(VM $VM){
    array_push($this->VMs,$VM);
    return $this->VMs;
  }

  public function setProjects(Project ...$ps){
    $this->projects = $ps;
    return $this->projects;
  }

  public function setActiveProject(Project $p){
    return $this->activeProject = $p;
  }
  public function getActiveProject(){
    return $this->activeProject;
  }

  public function addProject(Project $ps){
    array_push($this->projects,$ps);
    return $this->projects;
  }
}
?>
