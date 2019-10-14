<?php
$pageTitle = 'Detail View';
include('inc/header.php');
$bID = $_GET['id'];

function boxerCard($star, $image, $rank, $name, $nationality, $win, $lose, $draw, $bID)
{
    echo '<div class="card mb-3 mt-3 mr-5" style="width: 18rem; border:0;">';
    echo '<img class="card-img-top" src="img/thumbnail/' .  $image . '"alt="Card image cap">';
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
    echo '<div d-flex>';

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
    // echo '<a class="btn btn-outline-primary" href="profile.php?id=' . $bID . '"> More info...</a>';

    echo  '</div>';
    echo  '</div>';
}
function boxerDesc($name, $status, $nationality, $dob, $division, $champion, $stance, $height, $reach, $win, $lose, $draw, $koPercent, $rank, $star, $alias)
{


    echo '<p>';
    echo $name;
    if ($status == 'Active') {
        echo  ' is an ' . lcfirst($status) . ' boxer from ' . $nationality . ' and was born on ' . $dob . '. ';
    } else {
        echo ' is a ' . lcfirst($status) . ' boxer from ' . $nationality . ' and was born on ' . $dob . '. ';
    }

    echo 'He competes in the ' . $division . ' division. ';
    if ($champion != '') {
        echo 'He is a current champion and hold the ' . $champion . '. ';
    }
    echo 'He fights from a ' . $stance . ' stance. ';
    echo 'He stands at a height of ' . $height . 'cm' . ' with a reach of ' . $reach . 'cm. ';
    echo 'So far in his career, he has ' . $win . ' wins, ' . $lose . ' loses and ' . $draw . ' draws.';
    echo ' He has a knockout percentage of ' . $koPercent . '%, ';
    echo 'he is currently ranked number ' . $rank . ' in the World ' . $division . ' list' . ' and has a ' . $star . ' star rating on Boxrec.com';
    if ($alias != '') {
        echo 'He is also known as ' . $alias . ' to his fans';
    }

    echo '</p>';
}
$sql = "SELECT * FROM boxer where boxerID ='$bID'";

$results = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($results);
$url = $row['youtubeURL'];


preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
$id = $matches[1];
$width = '800px';
$height = '450px';
?>
<!-- <style>
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
</style> -->
<div class="container">
    <div class="jumbotron">
        <iframe id="ytplayer" class="w-100 m-auto" type="text/html" width="<?php echo $width ?>" height="<?php echo $height ?>" src="https://www.youtube.com/embed/<?php echo $id ?>?rel=0&showinfo=0&color=white&iv_load_policy=3" frameborder="0" allowfullscreen></iframe>
    </div>
    <div class="row">
        <div class="col-8 mt-4">
            <div class="d-flex flex-wrap">


                <?php $sql = "SELECT * FROM boxer where boxerID ='$bID'";

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) == 0) {
                    echo "<h1>Nothing to Show</h1>";
                } else {
                    echo "<div class=\"d-flex flex-wrap\">";

                    while ($row = mysqli_fetch_array($result)) {

                        $star =  $row['star'];
                        $ranking = $row['ranking'];
                        $name  = $row['name'];
                        $nationality = $row['nationality'];
                        $win = $row['win'];
                        $lose = $row['lose'];
                        $draw = $row['draw'];
                        $bID = $row['boxerID'];
                        $image = $row['image'];
                        $status = $row['status'];
                        $dob = $row['dob'];
                        $division = $row['division'];
                        $champion = $row['titles'];
                        $stance = $row['stance'];
                        $height = $row['height'];
                        $reach = $row['reach'];
                        $koPercent = $row['koPercent'];
                        $alias = $row['	alias'];

                        $resulter = boxerCard($star, $image, $ranking, $name, $nationality, $win, $lose, $draw, $bID);
                        echo $resulter;
                        $descResult = boxerDesc($name, $status, $nationality, $dob, $division, $champion, $stance, $height, $reach, $win, $lose, $draw, $koPercent, $ranking, $star, $alias);
                        echo $descResult;
                        echo "</div>";
                    }
                }

                ?>

            </div>
        </div>
        <div class="col-4 mt-5">
            <?php include('widgets.php') ?>
        </div>
    </div>
</div>
<?php

include('inc/footer.php');
?>