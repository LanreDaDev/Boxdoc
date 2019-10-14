<?php
session_start();
include("../boxdoc/inc/adminHeader.php");



if (isset($_SESSION['36392D7A-FBFE-44A3-A695-AD4924BA2494'])) {

    session_destroy();
    echo '<div class="container">';
    echo '<div class="row justify-content-center">';
    echo '<h1 class="text-center">You are succesfully Logged out</h1>';
    echo '</div>';
    echo '<div class="row justify-content-center mb-5">';
    echo '<a href="login.php"> Login here</a>';

    echo '</div>';
    echo '</div>';
} else {
    header("Location: ../boxdoc/login.php");
}
include("../boxdoc/inc/footer.php");
