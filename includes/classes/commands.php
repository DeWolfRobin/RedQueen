<?php
class CommandHandler {
  private static $instance = null;
  public $whitelist;
  private $VMs;
  private $stealth;

  function __construct() {
    // $this->$VmwarePath = $path;
    // $this->$VMs = array_filter(explode("\n",shell_exec("find ".$this->$VmwarePath." | grep .vmx$")));
    $this->$VMs = [];
    $this->$stealth = 0;
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

  public function getVMs(){
    return $this->$VMs;
  }
  public function setStealth(int $i){
    return $this->$stealth = $i;
  }
  public function addVM(VM $VM){
    array_push($this->$VMs,$VM);
    return $this->$VMs;
  }
}
?>
