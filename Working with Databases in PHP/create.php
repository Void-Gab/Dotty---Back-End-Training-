<html>
<body>
<h1>MongoDB</h1>
<br />
<a href="index.php">menu</a>
<br />
<form action="#" method="post">
    <label for="fname">First name:</label><br>
    <input type="text" id="fname" name="fname" value="John"><br>
    <label for="lname">Last name:</label><br>
    <input type="text" id="lname" name="lname" value="Smith"><br><br>
    <label for="email">email:</label><br>
    <input type="text" id="email" name="email" value="John.Smith@test.com"><br><br>
    <input type="submit" value="Submit">
</form>
</body>
</html>

<?php
    // https://www.php.net/manual/en/mongo.writeconcerns.php
    // https://www.php.net/manual/en/mongocollection.insert.php
    // https://www.php.net/manual/en/mongodb.installation.php
    // https://pecl.php.net/package/mongodb
    // https://pecl.php.net/package/mongodb/1.8.0/windows
    // https://www.php.net/manual/en/mongodb.tutorial.library.php
    // https://www.php.net/manual/en/class.mongodb-driver-manager.php
    // https://www.php.net/manual/en/mongodb-driver-bulkwrite.insert.php

    if(isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]))
    {
        $manager = new MongoDB\Driver\Manager("mongodb+srv://username:password01@cluster0.rtzkury.mongodb.net/PersonDB?retryWrites=true&w=majority&appName=Cluster0");

        $firstname = $_POST["fname"];
        $lastname = $_POST["lname"];
        $email = $_POST["email"];

        $newPerson = array("Firstname" => $firstname, 
                           "Lastname" => $lastname, 
                           "Email" => $email,
                            "Pid" => rand(1000, 10000));

        $bulk = new MongoDB\Driver\BulkWrite;
        $id = $bulk->insert($newPerson);

        $result = $manager->executeBulkWrite('PersonalDB.Person', $bulk);

        header("Location: list.php");
    }    
?>