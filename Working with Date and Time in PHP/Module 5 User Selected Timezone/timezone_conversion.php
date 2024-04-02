<?php

$tzone_idents = DateTimeZone::listIdentifiers();
$user_tzone_target = "";
$user_tzone_from = "";
$input_time = "";

if(isset($_POST['submit'])){
  $user_tzone_from = $_POST['tz_from'];
  $user_tzone_from_obj = new DateTimeZone($user_tzone_from);

  $user_tzone_target = $_POST['tz_target'];
  $user_tzone_target_obj = new DateTimeZone($user_tzone_target);

  $input_time = $_POST['time_string'];
}
function create_tz_select_option($idents_array, $selected_tz) {

  $dt = new DateTime('now');
  $option_string = "";

  foreach($idents_array as $zone) {

      $this_tz = new DateTimeZone($zone);
      $dt->setTimezone($this_tz);
      $offset = $dt->format('P');

      $option_string.= '<option value="'. $zone . '"';
      if ($selected_tz == $zone) { $option_string.= ' selected'; }
      $option_string.= '>' . $zone . '(UTC/GMT' . $offset . ') </option>';
  }

  return $option_string;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Time Zone Selection</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <div id="main-content">
    <h1>Time Zone Conversion</h1>

    <form action="" method="post">
      <?php $dt = new DateTime("now"); ?>

      <label for="time_string">Enter time String: </label>
      <input type="text" name="time_string" value="<?= $input_time; ?>"/>

      <div class="controls">
      <label for="tz_from">Initial Time Zone: </label>

      <select name="tz_from">
      <?php
        echo create_tz_select_option($tzone_idents, $user_tzone_from);
      ?>
      </select>
      </div>
      <div class="controls">
      <label for="tz_target">Target Time Zone: </label>

      <select name="tz_target">
        <?php
        echo create_tz_select_option($tzone_idents, $user_tzone_target);
        ?>
      </select>
      </div>

      <?php 
        if(isset($_POST['submit'])) {
          $new_dt = new DateTime('now');
          $initial_tzone_offset = $new_dt->getOffSet();
      ?>
      <div class="controls">
        <label>Time at: <?= $user_tzone_from ?>: </label>
        <?php echo $new_dt->format('F j, Y g:i a');?>
      </div>

      <?php
      $new_dt->setTimezone($user_tzone_target_obj);
      $user_selected_tzone_offset = $new_dt->getOffset();
      $diff = $initial_tzone_offset - $user_selected_tzone_offset;
      ?>

      <div class="controls">
        <label>Time at: <?= $user_tzone_target ?>: </label>
        <?php echo $new_dt->format('F j, Y g:i a');?>
      </div>

      <div class="controls">
        <label>Time Difference: </label>
        <?php echo $diff/3600 . 'hours'; ?>
      </div>

  <?php } ?>

  <div class="controls">
      <input type="submit" name="submit" value="Submit" />
  </div>
</form>

</div>

</body>
</html>