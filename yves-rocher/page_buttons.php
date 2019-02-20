<?php
$page_dom = "index";

echo "<ul class=\"pagination\">";

if ($page > 1) {
    echo "<li><a href='{$page_dom}' title='Первая страница.'>";
    echo "<<";
    echo "</a></li>";
}
function countAll()
{
    include_once '../service/databases/MAIN_DB.php';
    $cou = Database::connect();
    $query = "SELECT RECORD_ID FROM MAIN.YvesRocher_ORDERS";
    $stmt = $cou->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();

    return $num;
}

$total_rows = countAll();
$total_pages = ceil($total_rows / $limit);

$range = 5;

$initial_num = $page - $range;
$condition_limit_num = ($page + $range) + 1;

for ($x = $initial_num; $x < $condition_limit_num; $x++) {

    if (($x >= 1) && ($x <= $total_pages)) {

        if ($x == $page) {
            echo "<li class='active'><a href=\"#\">$x<span class=\"sr-only\">(current)</span></a></li>";
        } else {
            echo "<li><a href='{$page_dom}?page=$x'>$x</a></li>";
        }
    }
}
if ($page < $total_pages) {
    echo "<li><a href='" . $page_dom . "?page={$total_pages}' title='Последняя страница {$total_pages}.'>";
    echo ">>";
    echo "</a></li>";
}

echo "</ul>";
?>