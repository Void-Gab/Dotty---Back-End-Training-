<?php
    $root = './books';
    $title = $_REQUEST['title'];
    $author = $_REQUEST['author'];

    if (!file_exists("$root/$author")) {
        mkdir("$root/$author");
    }
    $putdata = fopen('php://input', 'r');
    $dest = fopen("$root/$author/$title.txt", 'w');
    while ($data = fread($putdata, 1024)) {
        fwrite($dest, $data);
    }
    fclose($dest);
    fclose($putdata);
?>
