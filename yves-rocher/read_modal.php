<?php
require '../service/databases/MAIN_DB.php';
$id = $_POST['record'];

if (null == $id) {
    echo "ERROR!";
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM MAIN.YvesRocher_ORDERS WHERE RECORD_ID = ' . $_POST['record'];
    $q = $pdo->prepare($sql);
    $q->execute();
    $yvdatastr = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
echo json_encode($yvdatastr);
/*
echo "<div class='page-header'>";
echo "<h4>История звонков по клиенту(зарегистрированных):</h4>";
echo "</div>";
if (isset ($yvdatastr['CLIENT_CODE'])) {
    include_once "../service/databases/MAIN_DB.php";
    echo '
    <table class="table table-striped table-bordered">
    <thead>
    <td align="center"><strong>#</strong></td>
    <td align="center"><strong>Дата</strong></td>
    <td align="center"><strong>Пользователь</strong></td>
    <td align="center"><strong>Утил.</strong></td>
    <td align="center"><strong>Продажа</strong></td>
    <td align="center"><strong>Коммент</strong></td>';
    $conn = Database::connect();
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $query = $conn->prepare('SELECT RECORD_ID,RECORD_TIME,UESR_DESC,CLIENT_RESULT_KEY,ORDER_ISSALE,OREDER_COMMENT FROM MAIN.YvesRocher_ORDERS WHERE CLIENT_CODE=:client ORDER BY RECORD_TIME DESC');
    $query->bindParam(':client', $yvdatastr['CLIENT_CODE']);
    $query->execute();

    foreach ($query as $row) {
        echo '<tr>';
        echo '<td align="center">' . $row['RECORD_ID'] . '</td>';
        echo '<td align="center">' . $row['RECORD_TIME'] . '</td>';
        echo '<td align="center">' . $row['UESR_DESC'] . '</td>';
        echo '<td align="center">' . $row['CLIENT_RESULT_KEY'] . '</td>';
        echo '<td align="center">' . $row['ORDER_ISSALE'] . '</td>';
        echo '<td align="center">' . $row['OREDER_COMMENT'] . '</td>';
        echo '</tr>';
    }

} else {
    echo "<h5>Записей не найдено.</h5>";
}*/
?>