<?php
$pageTitle = "List of Boxers";
include('inc/header.php');
function boxerCard($star, $image, $rank, $name, $nationality, $win, $lose, $draw, $bID)
{
    echo '<div class="card mb-3 mt-3 mr-5" style="width: 18rem;">';
    echo '<img class="card-img-top" src="img/display/' .  $image . '"alt="Card image cap">';
    echo '<div class="card-body">';
    echo '<div class="d-flex justify-content-around">';
    echo '<div class="d-flex mt-2 mr-auto">';
    for ($star; $star > 0.5; $star--) {

        echo '<img src="icons/star.png" alt="Star" height="10px" width="10px">';
    }
    if ($star == 0.5) {

        echo '<img src="icons/halfStar.png" alt="Half Star" height="10px" width="10px">';
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
    echo '<img src="img/flags/' . $nationality  . '.png" ' .  ' alt="' . $nationality . '" height="20px" width="20px" >';

    echo  '</div>';
    echo  '</div>';
    echo  '<div>';
    echo '<p>' . $win . ' wins ' . $lose . ' loses ' . $draw . ' draws </p>';
    echo  '</div>';
    echo '<a class="btn btn-outline-primary" href="profile.php?id=' . $bID . '"> More info...</a>';

    echo  '</div>';
    echo  '</div>';
}


?>
<style>
    .flex {
        display: flex;
    }

    .wrap flex-wrap: wrap;
    }

    .flex.wrap>div {
        margin: 10px;
    }

    .flex1 {
        flex: 1;
    }

    .flex4 {
        flex: 4;
        margin: 0 20px;
    }

    .column {
        flex-direction: column;
    }
</style>
<div class="container">


    <div class="row">

        <div class="col-8 mt-4 ">
            <?php
            $sql = "SELECT * from boxer";
            $displayBy = $_GET['displayBy'];
            $displayValue = urldecode($_GET['displayValue']);
            $min = $_GET['min'];
            $max = $_GET['max'];

            if (isset($displayBy) && isset($displayValue)) {
                $sql .= " WHERE $displayBy";
            }
            if (isset($displayValue) && $displayValue != "") {
                $sql .= "= '$displayValue'";
            }
            if (isset($min) && isset($max)) {
                $sql .= " BETWEEN $min AND $max ";
            }
            // if ($displayby != "" && $displayvalue != "") {
            // 	$sql = "SELECT * FROM cd_catalog_class WHERE $displayby LIKE '$displayvalue'";
            // }




            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo '<p>Bad query</p>';
            } else {
                if (mysqli_num_rows($result) == 0) {
                    echo '<p>No results returned</p>';
                } else {
                    echo "<div class=\"d-flex flex-wrap\">";
                    while ($row = mysqli_fetch_assoc($result)) {
                        extract($row);
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
                        ?>

                    <?php
                    }
                    echo "</div>";
                }
            }
            ?>
        </div>
        <div class="col-4 mt-5">
            <?php include('widgets.php') ?>
        </div>

    </div>
</div>
<?php
include('inc/footer.php');
?>