<?php
$page_title = "Record # " . $_GET['id'];
require '../service/databases/MAIN_DB.php';
$id = $_GET['id'];

if (null == $id) {
    echo "ERROR!";
    header('/yves-rocher/index');
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM MAIN.YvesRocher_ORDERS WHERE RECORD_ID = ' . $_GET['id'];
    $q = $pdo->prepare($sql);
    $q->execute();
    $yvdatastr = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
include_once "../service/template/header.php";
?>
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Время:</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['RECORD_TIME']; ?>"
                   readonly></td>
    </tr>
    <tr hidden>
        <td>Номер пользователя</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['USER_ADDED']; ?>"
                   readonly></td>
    </tr>

    <tr>
        <td>Пользователь</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['UESR_DESC']; ?>" readonly>
        </td>
    </tr>

    <tr>
        <td>Название аудио</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['RECORD_NAME']; ?>"
                   readonly></td>
    </tr>

    <tr>
        <td>Номер листа</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['list_id']; ?>"
                   readonly></td>
    </tr>


    <tr>
        <td>Код клиента</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['CLIENT_CODE']; ?>"
                   readonly>
        </td>
    </tr>

    <tr>
        <td>ФИО клиента</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['CLIENT_FIO']; ?>"
                   readonly>
        </td>
    </tr>

    <tr>
        <td>Ключ</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['CLIENT_KEY']; ?>"
                   readonly></td>
    </tr>

    <tr>
        <td>Город</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['CLIENT_CITY']; ?>"
                   readonly>
        </td>
    </tr>

    <tr>
        <td>Мобильный телефон:</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['CLIENT_PHONE']; ?>"
                   readonly></td>
    </tr>

    <tr>
        <td>Домашний телефон:</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['CLIENT_ALT_PHONE']; ?>"
                   readonly>
        </td>
    </tr>

    <tr>
        <td>Презентация:</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['CLIENT_RESULT_KEY']; ?>"
                   readonly>
        </td>
    </tr>
    <tr>
        <td>Заказ:</td>
        <td><input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['ORDER_ISSALE']; ?>"
                   readonly>
        </td>
    </tr>
    <tr>
        <td>Сумма заказа:</td>
        <td>
            <input type='text' class='form-control' name="user" value="<?php echo $yvdatastr['ORDER_CHECKSUM']; ?>"
                   readonly>
        </td>
        </td>
    </tr>
    <tr>
        <td>Комментарий:</td>
        <td><textarea name='comment' class='form-control'
                      maxlength="300" readonly><?php echo $yvdatastr['ORDER_COMMENT']; ?></textarea>
        </td>
    </tr>
</table>

<button type="button" onclick="location.href='../yves-rocher/'"
        class="btn-warning btn form-control">Вернутся
</button>


<?php
#echo "<div class='page-header'>";
#echo "<h4>История звонков по клиенту(зарегистрированных):</h4>";
#echo "</div>";
#if (isset ($yvdatastr['CLIENT_CODE'])) {
#    include_once "../service/databases/MAIN_DB.php";
#    echo '
#    <table class="table table-striped table-bordered">
#    <thead>
#    <td align="center"><strong>#</strong></td>
#    <td align="center"><strong>Дата</strong></td>
#    <td align="center"><strong>Пользователь</strong></td>
#    <td align="center"><strong>Утил.</strong></td>
#    <td align="center"><strong>Продажа</strong></td>
#    <td align="center"><strong>Коммент</strong></td>';
#    $conn = Database::connect();
#    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
#    $query = $conn->prepare('SELECT RECORD_ID,RECORD_TIME,UESR_DESC,CLIENT_RESULT_KEY,ORDER_ISSALE,OREDER_COMMENT FROM MAIN.YvesRocher_ORDERS WHERE CLIENT_CODE=:client ORDER BY RECORD_TIME DESC');
#    $query->bindParam(':client', $yvdatastr['CLIENT_CODE']);
#    $query->execute();#
#
#    foreach ($query as $row) {
#        echo '<tr>';
#        echo '<td align="center">' . $row['RECORD_ID'] . '</td>';
#        echo '<td align="center">' . $row['RECORD_TIME'] . '</td>';
#        echo '<td align="center">' . $row['UESR_DESC'] . '</td>';
#        echo '<td align="center">' . $row['CLIENT_RESULT_KEY'] . '</td>';
#        echo '<td align="center">' . $row['ORDER_ISSALE'] . '</td>';
#        echo '<td align="center">' . $row['OREDER_COMMENT'] . '</td>';
#        echo '</tr>';
#    }
#
#} else {
#    echo "<h5>Записей не найдено.</h5>";
#}
include_once "../service/template/footer.php";
?>
<style>
    button[type=submit] {
        background-color: rgb(254, 70, 10);
        border-color: #e63c0c;
        color: #ffffff;
    }

    textarea {
        resize: vertical;
    }

    label {
        font-size: small;
    }

</style>
