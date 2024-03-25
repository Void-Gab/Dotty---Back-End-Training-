<?php
  require_once "person.php";
  class Author extends Person{

    public static $centuryPopular = "19th";
    private $penName;

    function __construct($tempFirst = "", $tempLast = "", $tempYear = "", $tempPenName = ""){
        //echo "Author Constructor".PHP_EOL;
        parent::__construct($tempFirst, $tempLast, $tempYear);

        $this->penName = $tempPenName;
    }
  
    public function getPenName(){
      return $this->penName.PHP_EOL;
    }
    public function getCompleteName(){
  
      return $this->getFullName()." a.k.a " . $this->penName.PHP_EOL;
    }
    public static function getCenturyPopular(){
      return self::$centuryPopular;
    }

    function __destruct(){
      echo "message" . $this->penName;
    }
  }
//$newAuthor = new Author("name", "clemens","1010","twain");