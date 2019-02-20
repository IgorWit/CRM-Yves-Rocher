<?php
$page_title = "Звернення УКРПРОМІНВЕСТ-АГРО";
include_once "../service/template/header.php";

?>

    <table class="table table-striped table-hover table-condensed">
        <thead>
        <td align="center"><strong>ID</strong></td>
        <td align="center"><strong>Дата дзвінка</strong></td>
        <td align="center"><strong>ПІБ Клієнта</strong></td>
        <td align="center"><strong>Номер телефона</strong></td>
        <td align="center"><strong>Категорія звернення</strong></td>
        <td align="center"><strong>Дії</strong></td>
        </thead>
        <tbody>
        <?php
        include '../service/databases/MAIN_DB.php';

        if (isset($_GET['page'])) $page = ($_GET['page']); else $page = 1;

        $limit = 20;
        $start = ($page * $limit) - $limit;

        $conn = Database::connect();
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sqle = $conn->prepare('SELECT RECORD_ID,RECORD_CREATED,CLIENT_FIO,CLIENT_PHONE,TREATMENT_CATEGORY FROM MAIN.AGROPROD_TREATMENTS ORDER BY RECORD_ID DESC LIMIT :start,:limit');
        $sqle->bindParam(':start', $start);
        $sqle->bindParam(':limit', $limit);
        $sqle->execute();

        foreach ($sqle as $row) {
            echo '<tr>';
            echo '<td align="center">' . $row['RECORD_ID'] . '</td>';
            echo '<td align="center">' . $row['RECORD_CREATED'] . '</td>';
            echo '<td align="center">' . $row['CLIENT_FIO'] . '</td>';
            echo '<td align="center">' . $row['CLIENT_PHONE'] . '</td>';
            echo '<td align="center">' . $row['TREATMENT_CATEGORY'] . '</td>';
            echo '<td align="center"><a class="btn btn-primary" href="/ukrprodinvest/read?id=' . $row['RECORD_ID'] . '">Переглянути</a></td>';
            echo '</tr>';
        }
        Database::disconnect();
        ?>
        </tbody>

    </table>
<?php
include_once "page_buttons.php";
echo '<br>';
#echo "Показаны результаты ".$start."-".$limit." из ".$total_rows;
echo '<br>';
echo '<br>';

include_once "../service/template/footer.php";
?>