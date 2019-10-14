<?php
session_start();
if (!isset($_SESSION['36392D7A-FBFE-44A3-A695-AD4924BA2494']) || $_SESSION['36392D7A-FBFE-44A3-A695-AD4924BA2494'] == false) {
    header("Location: ../login.php");
}
