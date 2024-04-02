<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>HTML5 Date Input</title>
    <link href="style.css" rel="stylesheet" type="text/css">  
  </head>

  <body id="main-content">

    <h1>Date in PHP & MYSQL</h1>

    <div>
        <form method="post">
            <div class="controls">
                <label for="date">Date: </label>
                <input type="date" name="date" id="date">
            </div>
            <div class="controls btn">
                <input type="submit" name="submit" value="Check" />
            </div>
        </form>
    </div>

      <?php
        if (isset($_POST['submit'])) {
            $date = date('Y-m-d H:i:s', strtotime($_POST['date']));
            echo '<p>The selected date is ' . $date . '</p>';
        }    
      ?>
  </body>
</html>