<?php
require_once 'db_connect.php';
//$sql = 'SELECT name, phone, joined_at FROM employees';
$sql = 'SELECT name, phone, DATE_FORMAT(joined_at, "%W %b %e, %Y %l:%i %p") AS joined FROM employees';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dates from DB</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body id="main-content">
<h1>Displaying Dates from a Database</h1>

<table>
    <?php if ($db) { ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Joined On</th>
        </tr>

        <?php
        foreach ($db->query($sql) as $row) {
            //$joined_at = date('D, M j, Y \a\t g:i A', strtotime($row['joined_at'])); ?>

            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['joined']
                //= $joined_at 
                 ?></td>

            </tr>

        <?php }
        } ?>
    </table>
</body>
</html>