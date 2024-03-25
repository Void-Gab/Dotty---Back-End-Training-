<?php
  interface Electricity{
    public function voltage();
    public function electricity();
    public function outletStyle();
  }

  class Television implements Electricity{
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