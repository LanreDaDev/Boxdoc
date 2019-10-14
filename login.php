<?php
$pageTitle = "login";
include("../boxdoc/inc/adminHeader.php");

session_start();



$userName = "user";
$password = "password";

if (isset($_SESSION['36392D7A-FBFE-44A3-A695-AD4924BA2494']) && $_SESSION['36392D7A-FBFE-44A3-A695-AD4924BA2494'] == true) {
    header("Location: ../boxdoc/backend/insert.php");
}
if (isset($_POST['userName']) && isset($_POST['password'])) {
    if ($_POST['userName'] == $userName && $_POST['password'] == $password) {
        $_SESSION['36392D7A-FBFE-44A3-A695-AD4924BA2494'] = true;
        header("Location: ../boxdoc/backend/insert.php");
    }
}

?>
<style>
    form {
        display: flex;
        flex-direction: column;
        max-width: 350px;
        margin: 0 auto;
    }

    input {
        margin-bottom: 10px;
    }
</style>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <div class="form-group">
        <label for="userName">Username: </label>
        <input type="text" class="form-control" name="userName" id="userName" value="<?php echo $userName; ?>">

    </div>
    <div class="form-group">
        <label for="password">Password: </label>
        <input type="password" class="form-control" name="password" id="password" value="<?php echo $password; ?>">
    </div>
    <input type="submit" class="btn btn-primary" value="Login!">
</form>

<?php
include("../boxdoc/inc/footer.php");

?>