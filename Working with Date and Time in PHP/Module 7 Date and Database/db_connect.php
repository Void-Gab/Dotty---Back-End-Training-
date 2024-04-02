<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=employee_details', 'root', '');
} catch (PDOException $e) {
    echo $e->getMessage();
}