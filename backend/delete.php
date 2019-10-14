<?php
include("../inc/loggedin.php");
require "../inc/connect.php";
$pageTitle = "Delete";



include("../inc/adminHeader.php");
function boxerCard($star, $image, $rank, $name, $nationality, $win, $lose, $draw, $bID)
{
    echo '<div class="card mb-3 mt-3 mr-5" style="width: 18rem;">';
    echo '<img class="card-img-top" src="../img/display/' .  $image . '"alt="Card image cap">';
    echo '<div class="card-body">';
    echo '<div class="d-flex justify-content-around">';
    echo '<div class="d-flex mt-2 mr-auto">';
    for ($star; $star > 0.5; $star--) {

        echo '<img src="../icons/star.png" alt="Star" height="10px" width="10px">';
    }
    if ($star == 0.5) {

        echo '<img src="../icons/halfStar.png" alt="Half Star" height="10px" width="10px">';
    }
    echo '</div>';
    if ($rank > 0) {
        echo '<div d-flex>';
        echo '<p>' . $rank . ' / 1000</p>';
        echo '</div>';
    } else {
        echo '<div d-flex>';
        echo '<p> Retired </p>';
        echo '</div>';
    }
    echo '</div>';
    echo '<div class="d-flex justify-content-start ">';

    echo '<h4 class="card-title mr-3">' . $name . '</h4>';
    echo '<div>';
    echo '<img src="../img/flags/' . $nationality  . '.png" ' .  ' alt="' . $nationality . '" height="20px" width="20px" >';

    echo  '</div>';
    echo  '</div>';
    echo  '<div>';
    echo '<p>' . $win . ' wins ' . $lose . ' loses ' . $draw . ' draws </p>';
    echo  '</div>';

    echo '<a class="btn btn-outline-primary" href="delete.php?deleteID=' . $bID . '">';
    echo 'Delete';
    echo '</a>';

    echo  '</div>';
    echo  '</div>';
}



$sql = "SELECT * from boxer";
$result = mysqli_query($conn, $sql);
?>
<div class=" container d-flex flex-column-reverse mt-5">
    <div class=" row  justify-content-between flex-wrap">
        <?php

        while ($row = mysqli_fetch_assoc($result)) {
            $bID = $row['boxerID'];
            if ($bID) {
                $star =  $row['star'];
                $ranking = $row['ranking'];
                $name  = $row['name'];
                $nationality = $row['nationality'];
                $win = $row['win'];
                $lose = $row['lose'];
                $draw = $row['draw'];
                $bID = $row['boxerID'];
                $image = $row['image'];

                $resulter = boxerCard($star, $image, $ranking, $name, $nationality, $win, $lose, $draw, $bID);
                echo $resulter;
            }
        }
        ?>

    </div>
    <div class="row justify-content-center">

        <?php

        if (isset($_GET['deleteID'])) {
            $deleteID = $_GET['deleteID'];
            $sql = "DELETE from boxer where boxerID = $deleteID ";


            if (mysqli_query($conn, $sql)) {
                $delete = true;
                $success = 'new record deleted successfully ';

                header('location:delete.php');
                echo '<div class="alert alert-success" role="alert">';
                echo $success;
                echo '</div>';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                $delete = false;
            }
        }

        ?>

    </div>
</div>
<?php
include("../inc/footer.php");
?>