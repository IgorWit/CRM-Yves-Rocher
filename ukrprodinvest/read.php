<?php
$page_title = "Звернення № " . $_GET['id'];
require '../service/databases/MAIN_DB.php';
$id = $_GET['id'];
global $datastr;
if (null == $id) {
    echo "ERROR!";
    header('/ukrprodinvest/index');
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM MAIN.AGROPROD_TREATMENTS WHERE RECORD_ID = ' . $_GET['id'];
    $q = $pdo->prepare($sql);
    $q->execute();
    $datastr = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
#|RECORD_ID|RECORD_CREATED|USER|CLIENT_FIO|CLIENT_PHONE|TREATMENT_CATEGORY|COMPANY|REGION|VILLAGE|TREATMENT_REASON|AUDIO_RECORD|
include_once "../service/template/header.php";
?>
<form action='#' method='post' xmlns="http://www.w3.org/1999/html">
    <table class='table table-hover table-condensed table-bordered'>
        <tr>
            <td>Дата створення:</td>
            <td valign="center"><input type='text' name='record_date' class="form-control"
                                       value="<?php echo urldecode($datastr['RECORD_CREATED']); ?>"
                                       readonly></td>
        </tr>
        <tr>
            <td>Користувач:</td>
            <td valign="center"><input type='text' name='user' class="form-control"
                                       value="<?php echo urldecode($datastr['USER']); ?>" readonly>
            </td>
        </tr>
        <tr>
            <td>ПІБ Клієнта:</td>
            <td valign="center"><input type='text' name='fio_client' class="form-control"
                                       value="<?php echo $datastr['CLIENT_FIO']; ?>"
                                       readonly></td>
        </tr>
        <tr>
            <td>Номер телефону:</td>
            <td valign="center"><input type='text' name='mob_phone' class='form-control'
                                       value="<?php echo $datastr['CLIENT_PHONE']; ?>"
                                       readonly></td>
        </tr>
        <tr>
            <td>Категорія звернення:</td>
            <td valign="center"><input type='text' name='category' class='form-control'
                                       value="<?php echo $datastr['TREATMENT_CATEGORY']; ?>" readonly></td>
        </tr>
        <tr>
            <td>Підприємство:</td>
            <td valign="center"><input type="text" name='company' class='form-control'
                                       value="<?php echo $datastr['COMPANY']; ?>"
                                       readonly></td>
        </tr>
        <tr>
            <td>Район:</td>
            <td valign="center"><input type="text" name='region' class='form-control'
                                       value="<?php echo $datastr['REGION']; ?>"
                                       readonly></td>
        </tr>
        <tr>
            <td>Селище:</td>
            <td valign="center"><input type="text" name='village' class='form-control'
                                       value="<?php echo $datastr['VILLAGE']; ?>"
                                       readonly></td>
        </tr>
        <tr>
            <td>Текст звернення:</td>
            <td><textarea name='comment' class='form-control' maxlength="2000"
                          readonly><?php echo $datastr['TREATMENT_REASON']; ?></textarea></td>
        </tr>
        <tr>
            <td>Назва аудіофайла:</td>
            <td><input type="text" name='audio' class='form-control' value="<?php echo $datastr['AUDIO_RECORD']; ?>"
                       readonly></td>
        </tr>


        <td colspan="2" style="border: none;">
            <button type="button" onclick="location.href='/ukrprodinvest/'"
                    class="btn-primary btn form-control">Повернутись
            </button>
        </td>
    </table>

    <?php
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
            height: auto;
        }

        label {
            font-size: small;
        }


    </style>