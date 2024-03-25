<html>
<head>
<?php
//https://www.php.net/manual/en/class.mongodb-driver-cursor.php

    $manager = new MongoDB\Driver\Manager("mongodb+srv://username:password01@cluster0.rtzkury.mongodb.net/PersonDB?retryWrites=true&w=majority&appName=Cluster0");
    $query = new MongoDB\Driver\Query([]);
    $cursor = $manager->executeQuery("PersonalDB.Person", $query);
?>
</head>
<body>
<h1>MongoDB</h1>
<br />
<a href="index.php">menu</a>
<br />
<table>
    <tr>
    <th>Id</th>
    <th>FirstName</th>
    <th>LastName</th>
    <th>Email</th>
    <th></th>
    <th></th>
    </tr>
    <?php foreach($cursor as $document) { ?>
        <tr>
            <td><?php print $document->Pid ?></td>
            <td><?php print $document->Firstname ?></td>
            <td><?php print $document->Lastname ?></td>
            <td><?php print $document->Email ?></td>
            <td><a href="update.php?Pid=<?php print $document->Pid ?>">update</a></td>
            <td><a href="delete.php?Pid=<?php print $document->Pid ?>">delete</a></td>
        </tr>
    <?php } ?>
    </table>
</body>
</html>