<?php
class Project {
  private $stealth = 0;
  private $name = "";
  private $active = false;

  function __construct() {
  }

  public function setFromPost($key, $value){
    $value = htmlentities($value);
    switch ($key) {
      case 'stealth':
        $this->stealth = $value;
        break;
      case 'active':
        $this->active = $value == "on" ? true : false ;
        break;
      case 'name':
        $this->name = $value;
        break;
      default:
        return false;
        break;
    }
  }

  public function setStealth(int $i){
    return $this->stealth = $i;
  }
  public function getStealth(){
    return $this->stealth;
  }
  public function setName(string $n){
    return $this->name = $n;
  }
  public function getName(){
    return $this->name;
  }
  public function setActive(bool $a){
    return $this->active = $a;
  }
  public function isActive(){
    return $this->active;
  }

}
?>
