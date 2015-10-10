<?php
/**
 *  Circular Sword Fight Game.
 *  A number of samurai wearing numbered T-shirts are sitting in a circle.
 *  There is 1 sword, handed to samurai wearing shirt # 1.
 *  Each samurai has taken a blood oath to kill the samurai sitting behind him and
 *  pass the sword onto one sitting behind the killed one.
 *  Game goes on till there is only one survivor.
 */

// TODO: Add Strict Validation
// TODO: Add Docs
// TODO: Add Unit tests

class Samurai {
  public $shirtNumber;
  public $next;

  public function __construct($shirtNumber) {
    $this->shirtNumber = $shirtNumber;
    $this->next = null;
  }

  public function __toString() {
    return $this->shirtNumber;
  }
}

class SamuraiCircle {
  public $first;
  public $current;

  public function __construct() {
    $this->current = $this->first = null;
  }

  public function add($shirtNumber) {
    $samurai           = new Samurai($shirtNumber);
    $samurai->next     = $this->first;

    if (!$this->first) {
      $this->current  = $this->first  = & $samurai;
    } else {
      $this->current->next  = & $samurai;
      $this->current        = $samurai;
    }
  }
}

class SadisticSwordFight {
  public $min;
  public $max;

  public $samuraiCircle;

  public function __construct($min = 1, $max = 100) {
    $this->min = $min;
    $this->max = $max;
    $this->initList();
  }

  protected function initList() {
    $this->samuraiCircle = new SamuraiCircle();
    foreach (range($this->min, $this->max) as $i) {
      $this->samuraiCircle->add($i);
    }
  }

  public function fight() {
    $samurai = $this->samuraiCircle->first;
    // the first part of condition is not really needed as it is a circular linked list. should probably remove it.
    while ($samurai->next && $samurai->next != $samurai) {
      //echo $samurai->shirtNumber . " kills " . $samurai->next->shirtNumber . " and hands to " . $samurai->next->next->shirtNumber . PHP_EOL;
      $samuraiToDelete  = $samurai->next;
      $samurai->next    = $samuraiToDelete->next;
      $samurai          = $samurai->next;
      unset($samuraiToDelete);
    }
    echo $samurai->shirtNumber . " Survived" . PHP_EOL;
  }
}

$game = new SadisticSwordFight(1, 100);
$game->fight();
