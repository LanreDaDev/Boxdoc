<?php
session_start();
require "../inc/connect.php";
$pageTitle = "Search";
include("../inc/header.php");

function boxerCard($star, $image, $rank, $name, $nationality, $win, $lose, $draw, $bID)
{
    echo '<div class="card mb-3 mt-3 mr-3" style="width: 18rem;">';
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
    echo '<a class="btn btn-outline-primary" href="../profile.php?id=' . $bID . '"> More info...</a>';

    echo  '</div>';
    echo  '</div>';
}
?>
<div class="jumbotron">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <div class="input-group">
            <input type="text" class="form-control" name="search" id="search" placeholder="Search for something..." value="<?php echo $search; ?>" aria-label="" aria-describedby=" basic-addon1">
            <div class="input-group-append">
                <input type="submit" class="btn btn-primary" name="submit" value="Search!">
            </div>
        </div>
    </form>
</div>
<!-- <style>
    .searchResult {
        display: flex;
        flex-direction: column;
    }

    form {
        display: flex;

        flex-direction: column;
        align-items: center;
    }

    form div {
        margin: 30px 0 5px 0;
    }

    .searchText {
        width: 400px;
    }
</style> -->
<div class="container">
    <div class="row justify-content-center">

        <?php
        if (isset($_POST['submit'])) {
            $search = trim($_POST['search']);


            $sql = "Select * from boxer where name like '%$search%' or nationality like '%$search%' or division LIKE '%$search%' or stance LIKE '%$search%' or status LIKE '%$search%'";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 0) {
                echo "sorry, no result found";
            } else {
                // echo '<ul class="searchResult">';
                while ($row = mysqli_fetch_assoc($result)) {
                    // $name = $row['movieName'];
                    // $mID = $row['movieID'];

                    // $searchResult = '<li>' . $name . '<a href="../profile.php?mID=' .  $mID  . '">' . ' View Details</a>' . ' </li> ' . ' <br> ';
                    // echo $searchResult;
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


                // echo '</ul>';
            }
        }


        ?>
    </div>
</div>
<?php
include("../inc/footer.php");
?>