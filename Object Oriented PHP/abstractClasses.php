<?php
echo "print this \n";
  abstract class Electricity{
    abstract function voltage();
    abstract function electricity();
    abstract function outletStyle();
    
    public function powerOn(){

    }
    public function powerOff(){
      
    }
  }
  echo "do not print";

  class Television extends Electricity{
    public function changeChannel(){

    }
    public function adjustVolume(){

    }
    public function voltage(){

    }

    public function electricity(){

    }

    public function outletStyle(){
      
    }
  }