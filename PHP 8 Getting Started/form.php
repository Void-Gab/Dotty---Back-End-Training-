<?php
  $name = '';
  $password = '';
  $gender = '';
  $color = '';
  $languages = [];
  $comments = '';
  $tc = '';


  if (isset($_POST['submit'])) {
    $ok = true;

    if (!isset($_POST['name']) || $_POST['name'] === '') {
      $ok = false;
    } else {
      $name = $_POST['name'];
    };
    if (!isset($_POST['password']) || $_POST['password'] === '') {
      $ok = false;
    } else {
      $password = $_POST['password'];
    };
    if (!isset($_POST['gender']) || $_POST['gender'] === '') {
      $ok = false;
    } else {
      $gender = $_POST['gender'];
    };
    if (!isset($_POST['color']) || $_POST['color'] === '') {
      $ok = false;
    } else {
      $color = $_POST['color'];
    };
    if (!isset($_POST['languages']) || !is_array($_POST['languages']) 
        || count($_POST['languages']) === 0) {
      $ok = false;
      } else {
        $languages = $_POST['languages'];
    };
    if (!isset($_POST['comments']) || $_POST['comments'] === '') {
      $ok = false;
    } else {
      $comments = $_POST['comments'];
    };
    if (!isset($_POST['tc']) || $_POST['tc'] === '') {
      $ok = false;
    } else {
      $tc = $_POST['tc'];
    };
    if ($ok) {
      $db = new mysqli('localhost','root','','php');
      $sql = sprintf("INSERT INTO users (name, gender, color) VALUES ('%s','%s','%s')",
      $db->real_escape_string($name),
      $db->real_escape_string($gender),
      $db->real_escape_string($color));

      $db->query($sql);
      echo "user added";
      $db->close();
    };
    }

  ?>
<form action="" method="POST">
    User name: <input type="text" name="name" value="<?php
      echo htmlspecialchars($name, ENT_QUOTES);
    ?>"><br>
    Password: <input type="password" name="password"><br>
    Gender: 
      <input type="radio" name="gender" value="f"<?php
        if ($gender === 'f') {
          echo ' checked';
        }
      ?>> female
      <input type="radio" name="gender" value="m"<?php
        if ($gender === 'm') {
          echo ' checked';
        }
      ?>> male
      <input type="radio" name="gender" value="o"<?php
        if ($gender === 'o') {
          echo ' checked';
        }
      ?>> other<br>
    Favorite color: 
      <select name="color">
        <option value="">Please select</option>
        <option value="#f00"<?php
          if ($color === '#f00') {
            echo ' selected';
          }
        ?>>red</option>
        <option value="#0f0"<?php
          if ($color === '#0f0') {
            echo ' selected';
          }
        ?>>green</option>
        <option value="#00f"<?php
          if ($color === '#00f') {
            echo ' selected';
          }
        ?>>blue</option>
      </select><br>
    Languages spoken: 
      <select name="languages[]" multiple size="3">
        <option value="en"<?php
          if (in_array('en', $languages)) {
            echo ' selected';
          }
        ?>>English</option>
        <option value="fr"<?php
          if (in_array('fr', $languages)) {
            echo ' selected';
          }
        ?>>French</option>
        <option value="it"<?php
          if (in_array('it', $languages)) {
            echo ' selected';
          }
        ?>>Italian</option>
      </select><br>
    Comments: <textarea name="comments"><?php
      echo htmlspecialchars($comments, ENT_QUOTES);
    ?></textarea><br>
    <input type="checkbox" name="tc" value="ok"<?php
      if ($tc === 'ok') {
        echo ' checked';
      }
    ?>>
      I accept the T&amp;C<br>
    <input type="submit" name="submit" value="Register">
</form>