<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sun rise-set details</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body id= "main-content">
<h1>Sunrise and Sunset for next 7 days</h1>

<div>
    <form method="post">
        <div class="controls">
            <label for="latitute">Latitude: </label>
            <input type="text" name="latitude" id="latitude">
        </div>
        <div class="controls">
            <label for="longitude">Longitude: </label>
            <input type="text" name="longitude" id="longitude">
        </div>
        <div class="controls">
            <label for="date">Date: </label>
            <input type="date" name="date" id="date">
        </div>
        <div class="controls btn">
            <input type="submit" name="check" value="Check" />
        </div>
        
    </form>
</div>

<?php
  date_default_timezone_set('Asia/Singapore');
  if(isset($_POST['check'])){
    $long = isset($_POST['longitude']) && ! empty($_POST['longitude'])? $_POST['longitude'] : 121.043701;
    $lat = isset($_POST['latitude']) && ! empty($_POST['latitude']) ? $_POST['latitude'] : 14.676041;
    $input_date = isset($_POST['date']) && !empty($_POST['date']) ? $_POST['date'] : date('Y-m-j');
?>
<div>
<p>
  Longitude: <?= $long ?> <br>
  Latitude: <?= $lat ?>
</p>
</div>

<table>
<tr>
  <th>Date</th>
  <th>Sunrise</th>
  <th>Sunset</th>
</tr>
<?php
  $date = new DateTime($input_date);

  for($day=0;$day <=7; $day++){
    if(0!=$day){
      $date = $date->modify('+1 day');
    }
    $sun_info = date_sun_info($date->getTimestamp(), $lat,$long);

    $sunrise = date(('g: i a'), $sun_info['sunrise']);
    $sunset = date(('g:i a'), $sun_info['sunset']);
    ?>
    <tr>
      <td><?= $date->format('D M j') ?></td>
      <td><?= $sunrise; ?></td>
      <td><?= $sunset; ?></td>
    </tr>
  <?php } ?>
</table>
<?php } ?>
</body>
</html>