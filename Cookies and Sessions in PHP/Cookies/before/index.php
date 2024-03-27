<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>PHP Predefined Variables</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link href="assets/css/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body class="background">

        <div class="container col-md-8">
            <div class="navbar-area text-center">
                <a class="page-scroll" href="index.php">HOME</a>
                <a class="page-scroll" href="about-us.php">ABOUT US</a>
            </div>

            <div class="text-center">
                <h4 class="title">Subscribe to our Services</h4>
                <?php if (isset($_COOKIE['name'])) : ?>
                    <h3 class="title">Welcome <?php echo $_COOKIE['name']?></h3>
                <?php else: ?>
                    <form method="post" action="about-us.php">
                        <div class="row">
                            <label for="name" class="col-sm-3">Your Name:</label>
                            <input  type="text" name="name" class="col-sm-6" />
                        </div>
                        <button class="btn btn-primary" type="submit" name="subscribe">Subscribe</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>


