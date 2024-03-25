<?php
// https://www.php.net/manual/en/mongodb-driver-bulkwrite.delete.php

    $Pid = $_GET["Pid"];

    $manager = new MongoDB\Driver\Manager("mongodb+srv://username:password01@cluster0.rtzkury.mongodb.net/PersonDB?retryWrites=true&w=majority&appName=Cluster0");

    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->delete(['Pid'=>intval($Pid)], ['limit' => 1]);

    $result = $manager->executeBulkWrite('PersonalDB.Person', $bulk);

    header("Location: list.php");
?>