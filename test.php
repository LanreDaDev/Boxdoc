<?php
include('inc/header.php');
function boxerCard($star, $image, $rank, $name, $nationality, $win, $lose, $draw)
{
    echo '<div class="card mb-3 " style="width: 18rem;">';
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
    echo '<div d-flex>';
    echo '<p>' . $rank . '/ 1000</p>';
    echo '</div>';
    echo '</div>';
    echo '<div class="d-flex justify-content-start ">';

    echo '<h4 class="card-title mr-3">' . $name . '</h4>';
    echo '<div>';
    echo '<img src="img/flags/' . $nationality  . '.png" ' .  ' alt="' . $nationality . '" height="20px" width="20px" >';

    echo  '</div>';
    echo  '</div>';
    echo  '<div>';
    echo '<p>' . $win . ' wins ' . $lose . ' loses ' . $draw . ' drawz </p>';
    echo  '</div>';
    echo '<form method="post" action="delete.php">';
    echo '<input  class="btn btn-outline-primary" type="submit" name="submit" value="More Info">';
    echo '</form>';

    echo  '</div>';
    echo  '</div>';
}
$sql = "SELECT * from boxer";
$result = mysqli_query($conn, $sql);
// now to execute the statement
while ($row = mysqli_fetch_assoc($result)) {

    $star =  $row['star'];
    $ranking = $row['ranking'];
    $name  = $row['name'];
    $nationality = $row['nationality'];
    $win = $row['win'];
    $lose = $row['lose'];
    $draw = $row['draw'];
    $bID = $row['boxerID'];
    $image = $row['image'];

    $resulter = boxerCard($star, $image, $ranking, $name, $nationality, $win, $lose, $draw);
    echo $resulter;





    //  $search Result =   '< l i cl a ss="movi e Li s  t ">' . $name  .  '<a h r ef="profile. p hp?mID='  .  $bID    .     '">' . '  Vi ew Deta i l  s  < /a>' .  '  < /li> ' .  '  <br>';
    // echo $searchResult;
}
