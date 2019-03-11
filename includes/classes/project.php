<?php
class Project {
  private $stealth;

  function __construct($s) {
    $this->stealth = $s;
  }

  public function setStealth(int $i){
    return $this->stealth = $i;
  }
}
?>
