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

  public function startVM(VM $vm){
    $this->secureCommand("vmrun start ".$vm->getPath());
  }

  private function secureCommand($c){
    shell_exec($c);
  }

  public function getVMs(){
    return $this->VMs;
  }

  public function setVMs(VM ...$vms){
    $this->VMs = $vms;
    return $this->VMs;
  }

  public function addVM(VM $VM){
    array_push($this->VMs,$VM);
    return $this->VMs;
  }
}
?>
