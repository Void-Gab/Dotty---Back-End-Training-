<html>
<head>
<?php

// https://www.php.net/manual/en/class.mongodb-driver-query.php
// https://www.php.net/manual/en/mongodb-driver-bulkwrite.update.php

    $Pid = $_GET["Pid"];

    $manager = new MongoDB\Driver\Manager("mongodb+srv://username:password01@cluster0.rtzkury.mongodb.net/PersonDB?retryWrites=true&w=majority&appName=Cluster0");
    $query = new MongoDB\Driver\Query(['Pid'=>intval($Pid)]);
    $cursor = $manager->executeQuery("PersonalDB.Person", $query);

    $iterator = new IteratorIterator($cursor);
    $iterator->rewind();
    $document = null;
    if ($iterator->valid()) {
        $document = $iterator->current();
    }
?>
</head>
<body>
<h1>MongoDB</h1>
<br />
<a href="index.php">menu</a>
<br />
<form action="#" method="post">
    <label for="fname">First name:</label><br>
    <input type="text" value="<?php print $document->Firstname ?>" id="fname" name="fname" value="John"><br>
    <label for="lname">Last name:</label><br>
    <input type="text" value="<?php print $document->Lastname ?>" id="lname" name="lname" value="Smith"><br><br>
    <label for="email">Last name:</label><br>
    <input type="text" id="email" value="<?php print $document->Email ?>" name="email" value="John.Smith@test.com"><br><br>
    <input type="submit" value="Submit">
</form>
</body>
</html>

<?php

    if(isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]))
    {
        $firstname = $_POST["fname"];
        $lastname = $_POST["lname"];
        $email = $_POST["email"];

        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['Pid' => intval($Pid)],
            ['$set' => ["Firstname" => $firstname, "Lastname" => $lastname, 
                "Email" => $email]],
            ['multi' => false, 'upsert' => false]
        );

        $result = $manager->executeBulkWrite('PersonalDB.Person', $bulk);

        header("Location: list.php");
    }    
?>