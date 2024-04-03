<?php
  //Module 3 Clip 2
    /*
    //-- print out the associative array of the Environment Predefined Variable

    print "<pre>";
    print_r($_ENV);
    print "</pre>";


    print "<pre>";
    //print_r($_ENV['APACHE_RUN_USER']); Decaf coffee
    print_r($_ENV['USERNAME']);
    print "</pre>";
    */

  //Module 3 Clip 4

    //-- grab just the one environment variable (works even when environment predefined variables are turned off)
    //print getenv('APACHE_LOG_DIR'); //doesnt work if the apache directory is different
  //Module 4 
  /*
  print "<pre>";
  print_r($_SERVER);
  print "</pre>";

  print "<pre>";
  print_r($_SERVER['PHP_SELF']);
  print "</pre>";

  print $_SERVER['REQUEST_URI'];

  echo $_SERVER['DOCUMENT_ROOT'];

  echo $_SERVER['SERVER_ADDR'];

  echo $_SERVER['REMOTE_ADDR'];

  echo $_SERVER['HTTP_HOST'];

  echo $_SERVER['HTTP_USER_AGENT'];
  */
  echo $_SERVER['REQUEST_TIME']; // just a bunch of numbers, time stamp
  $timeStamp = $_SERVER['REQUEST_TIME']; //Onix Time Format
  echo "<br>";
  print date('Y-m-d H:i:s', $timeStamp);
  /*
  

  



  

  

  

  
  
  */