<?php
$page_title = "Yves Rocher";
include_once '../service/template/header.php';
?>
<!--suppress JSUnresolvedVariable -->
<script>
    // Loading data for modal
    function GetRecord(rec_id) {
        $.ajax({
            type: "POST",
            url: "read_modal",
            dataType: 'json',
            data: {
                record: rec_id
            },
            success: function (responce) {
                document.getElementById("r_time").innerHTML = responce.RECORD_TIME;
                document.getElementById("r_user").innerHTML = responce.UESR_DESC;
                document.getElementById("r_audio").innerHTML = responce.RECORD_NAME;
                document.getElementById("r_list").innerHTML = responce.list_id;
                document.getElementById("r_code").innerHTML = responce.CLIENT_CODE;
                document.getElementById("r_fio").innerHTML = responce.CLIENT_FIO;
                document.getElementById("r_key").innerHTML = responce.CLIENT_KEY;
                document.getElementById("r_city").innerHTML = responce.CLIENT_CITY;
                document.getElementById("r_mobi").innerHTML = responce.CLIENT_PHONE;
                document.getElementById("r_home").innerHTML = responce.CLIENT_ALT_PHONE;
                document.getElementById("r_util").innerHTML = responce.CLIENT_RESULT_KEY;
                document.getElementById("r_sale").innerHTML = responce.ORDER_ISSALE;
                document.getElementById("r_summ").innerHTML = responce.ORDER_CHECKSUM;
                document.getElementById("r_comm").innerHTML = responce.OREDER_COMMENT;

            }
        });
    }
</script>
<table class="table table-hover table-codensed">
    <thead>
    <td align="center"><strong>#</strong></td>
    <td align="center"><strong>Создано</strong></td>
    <td align="center"><strong>Пользователь</strong></td>
    <td align="center"><strong>Номер телефона</strong></td>
    <td align="center"><strong>Утильный</strong></td>
    <td align="center"><strong>Продажа</strong></td>
    <td align="center"><strong>Сумма</strong></td>
    <td align="center"><strong>Действия</strong></td>

    </thead>
    <tbody>
    <?php
    include_once '../service/databases/MAIN_DB.php';

    if (isset($_GET['page'])) $page = ($_GET['page']); else $page = 1;

    $limit = 100;
    $start = ($page * $limit) - $limit;

    $conn = Database::connect();
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sqle = $conn->prepare('SELECT RECORD_ID,RECORD_TIME,UESR_DESC,CLIENT_PHONE, CLIENT_RESULT_KEY,ORDER_ISSALE,ORDER_CHECKSUM FROM YvesRocher_ORDERS ORDER BY RECORD_ID DESC LIMIT :start,:limit');
    $sqle->bindParam(':start', $start);
    $sqle->bindParam(':limit', $limit);
    $sqle->execute();


    foreach ($sqle as $row) {
        echo '<tr>';
        echo '<td  align="center">' . $row['RECORD_ID'] . '</td>';
        echo '<td align="center">' . $row['RECORD_TIME'] . '</td>';
        echo '<td align="center">' . $row['UESR_DESC'] . '</td>';
        echo '<td align="center">' . $row['CLIENT_PHONE'] . '</td>';
        echo '<td align="center">' . $row['CLIENT_RESULT_KEY'] . '</td>';
        echo '<td align="center">' . $row['ORDER_ISSALE'] . '</td>';
        echo '<td align="center">' . $row['ORDER_CHECKSUM'] . '</td>';
        echo '<td align="center"><button class="btn-block btn-success" onclick="GetRecord(' . $row['RECORD_ID'] . ')" data-toggle="modal" data-target="#MyModal">Подробно</button></td>';
        echo '</tr>';
    }
    Database::disconnect();

    ?>
    </tbody>

</table>

<div class="modal fade" id="MyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="mod_rec_head" class="modal-title">Record # </h4>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-bordered table-striped">
                    <tbody>
                    <tr>
                        <td align="center">Время:</td>
                        <td align="center">
                            <div id="r_time"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Пользователь:</td>
                        <td align="center">
                            <div id="r_user"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Аудиофайл:</td>
                        <td align="center">
                            <div id="r_audio"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Номер листа:</td>
                        <td align="center">
                            <div id="r_list"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Код клиента:</td>
                        <td align="center">
                            <div id="r_code"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">ФИО клиента:</td>
                        <td align="center">
                            <div id="r_fio"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Ключ:</td>
                        <td align="center">
                            <div id="r_key"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Город:</td>
                        <td align="center">
                            <div id="r_city"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Мобильный телефон:</td>
                        <td align="center">
                            <div id="r_mobi"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Домашний телефон:</td>
                        <td align="center">
                            <div id="r_home"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Презентация:</td>
                        <td align="center">
                            <div id="r_util"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Заказ:</td>
                        <td align="center">
                            <div id="r_sale"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Сумма заказа:</td>
                        <td align="center">
                            <div id="r_summ"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">Комментарий:</td>
                        <td align="center">
                            <div id="r_comm"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
include_once "page_buttons.php";
include_once "../service/template/footer.php";
?>


