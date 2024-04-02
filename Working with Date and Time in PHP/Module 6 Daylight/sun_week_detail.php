<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sun rise-set details</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body id="main-content">

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
            <input type="submit" name="check" value="Check"/>
        </div>
    </form>
</div>

<?php
if (isset($_POST['check'])) {

    $long = isset($_POST['longitude']) && !empty($_POST['longitude']) ? $_POST['longitude'] : 77.102493;
    $lat = isset($_POST['latitude']) && !empty($_POST['latitude']) ? $_POST['latitude'] : 28.704060;
    $input_date = isset($_POST['date']) && !empty($_POST['date']) ? $_POST['date'] : date('Y-m-j');

    ?>
    <div>
        <p>
            Longitude: <?= $long ?> <br>
            Latitude: <?= $lat ?> <br>
            Date: <?= $input_date ?>
        </p>
    </div>

    <table>
        <tr>
            <th>Date</th>
            <th>Sunrise</th>
            <th>Sunset</th>
            <th>Daylight</th>
        </tr>

        <?php

        $date = new DateTimeImmutable($input_date);

        for ($day = 0; $day <= 7; $day++) {

            if (0 != $day)
                $date = $date->modify('+1 day');

            $sun_info = date_sun_info($date->getTimestamp(), $lat, $long);

            $sunrise = date(('g:i a'), $sun_info['sunrise']);
            $sunrise_dt = $date->setTimestamp($sun_info['sunrise']);

            $sunset = date(('g:i a'), $sun_info['sunset']);
            $sunset_dt = $date->setTimestamp($sun_info['sunset']);

            $daylight = $sunrise_dt->diff($sunset_dt);
            ?>

            <tr>
                <td><?= $date->format('D M j') ?></td>
                <td><?= $sunrise; ?></td>
                <td><?= $sunset; ?></td>
                <td><?= $daylight->format('%h hours %i minutes'); ?></td>
            </tr>

        <?php } ?>
    </table>

<?php } ?>
</body>
</html>