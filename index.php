<?php
session_start();
include('inc/header.php');
function boxerCard($star, $image, $rank, $name, $nationality, $win, $lose, $draw, $bID)
{
    echo '<div class="card mb-3 mt-3 mr-3" style="width: 18rem;">';
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
// function boxerDesc($name, $status, $nationality, $dob, $division, $champion, $stance, $height, $reach, $win, $lose, $draw, $koPercent, $rank, $star, $alias)
// {
//     echo '<p>';
//     echo $name . 'is an ' . $status . ' boxer from ' . $nationality . ' and was born on' . $dob;
//     echo 'He competes in the ' . $division . '.';
//     if ($champion != '') {
//         echo 'He is a current champion and hold the ' . $champion . '.';
//     }
//     echo 'He fights from a ' . $stance . ' stance.';
//     echo 'He stands at a height of ' . $height . 'cm' . 'with a reach of ' . $reach . ' cm';
//     echo 'so far in his career, he has' . $win . ' wins,' . $lose . ' loses' . $draw . 'draw.';
//     echo 'He has a KO% of' . $koPercent . '%';
//     echo 'He is currently ranked number' . $rank . ' in the world ' . $division . ' list' . ' and has a ' . $star . ' star rating on Boxrec.com';
//     if ($alias != '') {
//         echo 'He is also known as ' . $alias . ' to his fans';
//     }

//     echo '</p>';
// }

$pageTitle = "BoxDoc";
?>

<div class="jumbotron w-75 m-auto ">
    <h1 class="display-3 text-center">BoxDoc</h1>
    <p class="lead">This is a datase of Boxers and Interesting infomation about their career. This meant to be a mock of the real website <a href="boxrec.com">BoxRec.com</a>, the official record keeper of boxing data. The aim is to use the site as a way to see fun infomation about our favourite boxers and as well as a to use more search filters.</p>
    <hr class="my-2">
    <p>If you have an admin account with BoxDoc you may log in to add, edit and delete a record, otherwise please click on the link below to see the list of all boxers .</p>

    <div class="row justify-content-center">


        <a class="btn btn-primary btn-lg mr-5" href="list.php" role="button"> Boxers</a>
        <a class="btn btn-secondary btn-lg ml-5" href="login.php" role="button">Login</a>
    </div>


</div>
<div class="d-flex justify-content-center">
    <?php
    $sql = "SELECT * from boxer ORDER BY RAND() LIMIT 2";
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


        $resulter = boxerCard($star, $image, $ranking, $name, $nationality, $win, $lose, $draw, $bID);
        echo $resulter;





        // $searchResult = '<li class="movieList">' . $name . '<a href="profile.php?mID=' .  $bID  . '">' . ' View Details</a>' . ' </li> ' . ' <br> ';
        // echo $searchResult;
    } ?>
</div>
<?php
include('inc/footer.php')
?>