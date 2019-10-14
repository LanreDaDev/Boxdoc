<?php

echo "<h3 class=\"mb-3\">Random Boxers</h3>";
$sql = "SELECT * from boxer ORDER BY RAND() LIMIT 2";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
    $bID = $row['boxerID'];

    echo '<li class="list-group-item">' . $name .  '<a href="profile.php?id=' . $bID . '"> More info...</a>' . '</li>';
}


echo "<h3 class=\"mb-3 mt-3\">Random Inactive Boxers</h3>";
$sql = "SELECT * from boxer WHERE status = 'Retired' ORDER BY RAND() LIMIT 3";
$result = mysqli_query($conn, $sql);
echo '<ul class="list-group">';
while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
    $bID = $row['boxerID'];

    echo '<li class="list-group-item">' . $name .  '<a href="profile.php?id=' . $bID . '"> More info...</a>' . '</li>';
}
echo '</ul>';

echo "<h3 class=\"mb-3 mt-3\">By Division</h3>";
$sql = "SELECT distinct division FROM boxer ORDER BY division ";
$result = mysqli_query($conn, $sql);
echo '<ul class="list-group">';
while ($row = mysqli_fetch_assoc($result)) {
    $division = $row['division'];


    echo '<li class="list-group-item">' . '<a href="list.php?displayBy=division&displayValue=' . urlencode($division) . '">' . $division . '</a>' . '</li>';
}
echo '</ul>';
