<!-- Module 2-->
<?php
  /*
  phpinfo(); // cant change Asia/Kolkata to Asia/Singapore in default timezone value

  date_default_timezone_set('Asia/Singapore'); // used this but still cant change
  phpinfo();
  */
  ?>
<!-- Module 3 Clip 1 & 2-->
<?php
  /*
  $timestamp_now = time();
  echo "Timestamp for now: {$timestamp_now} \n";
  echo "<br>";

  $timestamp_tomorrow = $timestamp_now + (60*60*24);
  echo "Timestamp for tomorrow: {$timestamp_tomorrow} \n";
  echo "<br>";

  $timestamp_tomorrow = strtotime('+1 day');
  echo "Timestamp for tomorrow: {$timestamp_tomorrow} \n" ;
  echo "<br>";

  $timestamp_newyear = strtotime('first day of January 2024');
  echo "Timestamp for New Year: {$timestamp_newyear} \n";
  echo "<br>";

  $timestamp_newyear2 = mktime(0,0,0,1,1,2024);
  echo "Timestamp for New Year mktime(): {$timestamp_newyear2} \n";

  echo "\n \n";

  echo 'Today is ' . date('g:i:s a \o\n l, F j, Y') . "\n" ;
  echo 'Tomorrow is ' .date('g:i:s a \o\n l, F j, Y',$timestamp_tomorrow). "\n";
  echo 'New year 2024 is a ' .date('l', $timestamp_newyear). "\n";

  echo "\n\n";

  $year = 2021;

  if(checkdate(2,29,$year)) {
    echo "{$year} is a leap year";
  } else {
    echo "{$year} is not a leap year";
  }
  */
  ?>
<!-- Module 4 Clip 1-->
<?php
  /*
  $date_now = new DateTime();
  $date = new DateTime('April 1, 2024');

  echo "\n<br>";
  echo $date_now->format('l, F, j, Y g:i a') . "\n<br>";
  echo $date->format('l, F, j, Y, g:i: a') . "\n<br>";

  $time_now = $date_now->getTimeStamp();
  $date->setTimestamp($time_now);

  echo $date->format('l, F, j, Y, g:i a');
  */
  ?>
<!-- Module 4 Clip 2-->
<?php
  /*
  $date = new DateTime();
  $sun_info = date_sun_info($date->getTimestamp(), 28.704060, 77.102493);

  echo '<pre>';
  print_r($sun_info);
  */
  ?>
<!-- Module 4 Clip 3-->
<?php
  /*
  echo '<br>';

  $date1 = new DateTime();
  echo 'Date1: ' . $date1->format('g:i:s a, F j, Y') . '<br>';

  $date2 = $date1->modify('+1 day 9:30 pm');
  echo 'Date1: ' . $date1->format('g:i:s a, F j, Y') . '<br>';
  echo 'Date2: ' . $date2->format('g:i:s a, F j, Y') . '<br>';

  echo '<hr>';

  $date3 = new DateTimeImmutable();
  echo 'Date3: ' . $date3->format('g:i:s a, F j, Y') . '<br>';

  $date4 = $date3->modify('+1 day 9:30 pm');
  echo 'Date3: ' . $date3->format('g:i:s a, F j, Y') . '<br>';
  echo 'Date4: ' . $date4->format('g:i:s a, F j, Y') . '<br>';
  */
  ?>
<!--Module 4 Clip 4-->
<?php
  /*
  echo '<br>';
  $date = new DateTime();
  echo $date->format('g:i:s a, F j, Y') . '<br>';

  echo $date->setDate(2019, 13, 23)
          ->setTime(3, 75)
          ->format('g:i:s a, F j, Y') . '<br>';
  */
  ?>
<!--Module 4 Clip 5-->
<?php
  /*
  echo '<br>';

  $date = new DateTime('09/05/2020');
  echo $date->format('F j, Y') . '<br>';

  $date = DateTime::createFromFormat('d/m/Y', '09/05/2020');
  echo $date->format('F j, Y') . '<br>';
  */
  ?>
  
<!--Module 5 Clip 1-->
<?php
  /*
  // returns a numerically indexed array containing all defined timezone identifiers
  $tzone_idents = DateTImeZone::listIdentifiers();

  echo "</br>";
  echo "Total timezone identifiers = ". count($tzone_idents);
  echo "</br><pre>";
  print_r($tzone_idents);

  $tzone = new DateTimeZone('Asia/Manila');
  echo "</br>";

  //return location information for a timezone
  print_r($tzone->getLocation());
  echo "</br>";

  //return the name of the timezone
  echo $tzone->getName();
  */
  ?>
<!--Module 5 Clip 2-->
<?php
  /*
  echo '<br/>';

  $dtime = new DateTime('October 23, 2020');

  $tzone = $dtime->getTimezone();
  echo 'Default Timezone: ' . $tzone->getName() . '<br/>';

  echo 'Offset DT: ' . $dtime->getOffset() . '<br/>';
  echo 'Offset TZ: ' . $tzone->getOffset($dtime) . '<br/>';

  echo '<hr>';

  $tzone_la = new DateTimeZone('America/Los_Angeles');

  $dtime->setTimezone($tzone_la);
  $new_tz = $dtime->getTimezone();
  echo 'New Timezone: ' . $new_tz->getName() . '<br/>';

  echo '<hr>';

  $dtime2 = new DateTime('October 23, 2020', $tzone_la);
  $new_tz2 = $dtime2->getTimezone();
  echo 'New Timezone2: ' . $new_tz2->getName() . '<br/>';

  echo '<hr>';

  $dtime3 = new DateTime('October 23, 2020 America/New_York', $tzone_la);
  $new_tz3 = $dtime3->getTimezone();
  echo 'New Timezone3: ' . $new_tz3->getName() . '<br/>';


  echo '<pre>';

  $country_ident = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, 'US');

  echo count($country_ident) . ' identifiers found:</p>';
  print_r($country_ident);
  */
  ?>
<!--Module 6 Clip 1-->
<?php
  /*
  echo '<pre>';

  $interval = new DateInterval('P2Y');
  print_r($interval);

  echo '<hr>';

  $interval = new DateInterval('P1W');
  print_r($interval);

  echo '<hr>';

  $interval = new DateInterval('P2Y3M4D');
  print_r($interval);

  echo '<hr>';

  $interval = new DateInterval('P2Y3M4DT6H8M');
  print_r($interval);
  */
  ?>
<!--Module 6 Clip 2-->
<?php
  /*
  echo '<pre>';

  $interval = new DateInterval('P2Y');
  print_r($interval);

  $interval = DateInterval::createFromDateString('2 years');
  print_r($interval);

  echo '<hr>';

  $interval = new DateInterval('P1W');
  print_r($interval);

  $interval = DateInterval::createFromDateString('1 week');
  print_r($interval);

  echo '<hr>';

  $interval = new DateInterval('P2Y3M4D');
  print_r($interval);

  $interval = DateInterval::createFromDateString('2 years + 3 months + 4 days');
  print_r($interval);

  echo '<hr>';

  $interval = new DateInterval('P2Y3M4DT6H8M');
  print_r($interval);

  $interval = DateInterval::createFromDateString('2 years + 3 months + 4 days + 6 hours + 8 minutes');
  print_r($interval);

  echo $interval->format('%y years %m months %d days %h hours %i minutes');
  */
  ?>

<!--Module 6 Clip 3-->
<?php
  /*
  echo '<pre>';

  $date1 = new DateTime('12 January 2020 4:30 am');
  echo 'Date 1: ' . $date1->format('F j, Y g:i a') . '<br>';

  $date2 = new DateTime('10 September 2020 5:30:20 am');
  echo 'Date 2: ' . $date2->format('F j, Y g:i:s a') . '<br>';

  $interval = new DateInterval('P2Y');
  echo 'Date 1 add 2 years: ' . $date1->add($interval)->format('F j, Y g:i:s a') . '<br>';


  $interval = new DateInterval('P1Y3M4DT6H8M');
  echo 'Date 2 sub 1Y3M4DT6H8M: ' . $date2->sub($interval)->format('F j, Y g:i:s a') . '<br>';

  $diff_interval = $date1->diff($date2);
  echo 'Interval: ' . $diff_interval->format('%r %y years %m months %d days %h hours %i minutes');
  */
  ?>
<!--Module 6 Clip 5-->
<?php
  echo '<pre>';

  $from = new DateTime('December 31, 2019');
  $to = new DateTime('January 1, 2021');

  //$interval = new DateInterval('P2W');
  $meeting_dates = DateInterval::createFromDateString('last thursday of next month');


  $meetings = new DatePeriod($from, $meeting_dates, $to, DatePeriod::EXCLUDE_START_DATE);

  foreach ($meetings as $meeting) {
      echo $meeting->format('l, F j, Y') . '<br>';
  }
























