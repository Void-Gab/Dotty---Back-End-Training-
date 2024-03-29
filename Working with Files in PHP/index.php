<?php
    //$filename = "C:/Tutorials/workingWithFiles/02/demos/books/Charles Dickens/A Tale of Two Cities.txt"; 
    
// Demo 2-1 Reading Whole Files
    /*
    print(file_get_contents($filename));
    readfile($filename);
    print_r(file($filename));
    */
// Demo 2-2 Reading Partial Files
    /*
    $f = fopen($filename, 'r');

    while ($data = fgets($f)) {
        echo $data;
    }
    
    //prints 512 characters after you press enter till there are contents on file
    while (!feof($f)) { 
        echo fread($f, 512);
        fgets(STDIN);
    }
    $fclose($f);
    */

// Demo 2-3 Writing in Files
    /*
    $f = fopen('library.csv', 'r');
    $entries = [];

    while(($entry = fgetcsv($f))!= null) {
        if($entry[1] == 'Charles Dickens') {
            $entries[] = $entry;
        }
    }
    fclose($f);

    $dest = fopen('dickens_books.csv', 'w');
    foreach($entries as $entry){
        fputcsv($dest, $entry);
    }
    fclose($dest);
    echo 'run ?';
    */
    


    

// Demo 3-1 File Metadata
    /*
    $info = [];
    $filename = './books/Charles Dickens/Great Expectations.txt';

    $info['last accessed'] = new DateTime('@'.fileatime($filename));
    $info['last modified'] = new DateTime('@'.filemtime($filename));
    $info['size (B)'] = filesize($filename);
    $info['type'] = filetype($filename);
    $info['readable?'] = is_readable($filename);
    $info['writable?'] = is_writable($filename);
    $info['executable?'] = is_executable($filename);
    $info['link?'] = is_link($filename);

    var_dump($info);
    */

// Demo 3-2 File Permissions
    /*
    $filename = './books/Charles Dickens/A Christmas Carol.txt'; 

    function getPermissionInfo($filename) {
        return [
            'file owner' => fileowner($filename),
            'owning group' => filegroup($filename),
            'permissions' => sprintf('%o', fileperms($filename))
        ];
    }

    var_dump(getPermissionInfo($filename));

    chmod($filename, 0640); // Doesnt work on Windows

    var_dump(getPermissionInfo($filename));
    */

// Demo 4-1 Querying the File System
    /*
    $dir = getcwd();
    $fmt = "%s: %g \n";

    echo sprintf("%s: %s \n", 'CWD', $dir);
    echo sprintf($fmt, 'Free space', disk_free_space($dir));
    echo sprintf($fmt, 'Total space', disk_total_space($dir));

    echo sprintf($fmt, 'File?', is_file($dir));
    echo sprintf($fmt, 'Directory?', is_dir($dir));
    echo sprintf($fmt, 'foo/bar exists ?', file_exists('foo/bar'));
    */
// Demo 4-2 Navigating Creating and Deleting Directories
    /*
    $root = './books';
    $dir = opendir($root);

    $library = [];

    while(($author = readdir($dir)) != FALSE) {
        if($author == '.' || $author == '..') {
            continue;
        }
        $books = scandir("$root/$author");
        foreach($books as $title){
            if (is_dir($title)) {
                continue;
            }
            $library[] = [$author, substr($title, 0, -4)];
        }
    }
    

    closedir($dir);

    echo "Which book would you like to read ? \n\n";
    foreach ($library as $idx => $book) {
        $option = $idx + 1;
        echo "$option) $book[1] by $book[0]\n";
    }

    list($option) = fscanf(STDIN, "%d\n");
    list($author, $title) = $library[$option];

    $filename = "$root/$author/$title.txt";
    $f = fopen($filename, 'r');

    echo $filename;

    while (!feof($f)) {
        echo fread($f, 512);
        fgets(STDIN);
    }
    fclose($f);
    */

// Demo 5-1 Sending files Webservice
    /*
    $filename = './books/Charles Dickens/Great Expectations.txt';
    header("content-type: text/plain");

    readfile($filename);
    */
// Demo 5-2 Post Request File
    ?>
    <!-- 
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP eReader</title>
    </head>
    <body>
        <//?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
        <form action="<//?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <h2>Please select a book to upload using POST</h2>
            <input type="text" name="title" id="title" placeholder="Title"><br>
            <input type="text" name="author" id="author" placeholder="Author"><br>
            <input type="file" name="content" id="content"><br>
            <button type="submit">Submit</button>
        </form>
        <//?php
        } else {
            $title = $_REQUEST['title'];
            $author = $_REQUEST['author'];
            $root = './books';
            if (!file_exists("$root/$author")) {
                mkdir("$root/$author");
            }
            $result = move_uploaded_file($_FILES['content']['tmp_name'], "$root/$author/$title.txt");
            if ($result) {
                echo "File saved successfully";
            } else {
                echo "Failed to save file";
            }
        }
        ?>
    </body>
    </html>
    -->

    <?php
// Demo 5-3 Put Request File
    ?>
    <!--
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP eReader</title>
    </head>
    <body>
        <form action="/" method="post" enctype="multipart/form-data">
            <h2>Please select a book to upload</h2>
            <input type="text" name="title" id="title" placeholder="Title"><br>
            <input type="text" name="author" id="author" placeholder="Author"><br>
            <input type="file" name="content" id="content"><br>
            <button type="submit">Submit</button>
        </form>
        <script>
            const form = document.querySelector('form');
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                const title = document.getElementById('title').value;
                const author = document.getElementById('author').value;
                fetch(`new.php?title=${title}&author=${author}`, {
                    method: 'put',
                    body: document.getElementById('content').files[0]
                });
            });
        </script>
    </body>
    </html>
    -->
    <?php
// Demo 5-4 Securing a web Service
    ?>
    <!--
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP eReader</title>
    </head>
    <body>
        <?php
        //if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
        <form action="<//?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
            <h2>Please select a book to upload</h2>
            <input type="text" name="title" id="title" placeholder="Title"><br>
            <input type="text" name="author" id="author" placeholder="Author"><br>
            <input type="file" name="content" id="content"><br>
            <button type="submit">Submit</button>
        </form>
        
        <?php
        /*
        } else {
            $title = $_REQUEST['title'];
            $author = basename($_REQUEST['author']);
            if ($author == '' || $author == '.' || $author == '..') {
                echo "Invalid author name";
            } else {
                $root = './uploads';
                if (!file_exists("$root/$author")) {
                    mkdir("$root/$author");
                }
                $result = move_uploaded_file($_FILES['content']['tmp_name'], "$root/$author/$title.txt");
                if ($result) {
                    echo "File saved successfully";
                } else {
                    echo "Failed to save file";
                }
            }
        }*/
        ?>
        
    </body>
    </html>
    -->
            
