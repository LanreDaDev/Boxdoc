<?php
require "config.php";
require "connect.php";
?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <meta name="theme-color" content="#fafafa">
</head>

<body>
    <header>

        <nav>

            <ul class="nav navbar-light bg-light">
                <li class="nav-item mr-auto"><a class="nav-link active" href="<?php echo BASE_URL; ?>">BoxDoc</a></li>
                <li class="nav-item"><a class="nav-link active" href="<?php echo BASE_URL; ?>backend/insert.php">Add</a></li>
                <li class="nav-item"><a class="nav-link active" href="<?php echo BASE_URL; ?>backend/edit.php">Edit</a></li>
                <li class="nav-item"><a class="nav-link active" href="<?php echo BASE_URL; ?>backend/delete.php">Delete</a></li>
                <?php if (isset($_SESSION['36392D7A-FBFE-44A3-A695-AD4924BA2494'])) {
                    echo ' <li class="nav-item"><a class="nav-link active" href="../logout.php">Logout</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link active" href="../login.php">Login</a></li>';
                }
                ?>
            </ul>
        </nav>

    </header>