<?php
$page_title = "Detail for " . $_GET['user'];
include_once '../service/template/header.php';
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

<script>
    function get(name) {
        if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
            return decodeURIComponent(name[1]);
    }

    function GetReport() {
        var StartReportDate = $('#dateFrom').val();
        var EndReportDate = $('#dateTo').val();
        var USR = get('user');
        $.ajax({
            type: "POST",
            url: "../service/ajax/ajax-yves",

            data: {
                action: "GetAgentTime",
                StDate: StartReportDate,
                LsDate: EndReportDate,
                user: USR
            }, success: function (responce) {
                $('#fetchedTimeData').html(responce);
            }
        });

    }
</script>
<script>
    function get(name) {
        if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
            return decodeURIComponent(name[1]);
    }
    function GetReport2()
    var StartReportDate = $('#dateFrom').val();
    var EndReportDate = $('#dateTo').val();
    var USR = get('user');
    $.ajax({
        type: "POST",
        url: "../service/ajax/ajax-yves",

        data: {
            action: "GetAgentOrderSummary",
            StDate: StartReportDate,
            LsDate: EndReportDate,
            user: USR
        }, success: function (responce) {
            $('#fetchedOSD').html(responce);
        }
    })
</script>
<div class="form-inline nav-justified">
    <div class="col-xs-5 date">
        <div class="input-group input-append date" id="dateFromPicker">
            <input id="dateFrom" placeholder="От:" type="text" class="form-control"/>
            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
        <!--suppress JSUnresolvedFunction -->
        <script>
            $(document).ready(function () {
                $('#dateFromPicker')
                    .datepicker({
                        format: 'yyyy-mm-dd 00:00:01',
                        startDate: '2015-01-01',
                        endDate: 'today'
                    })
            });
        </script>
    </div>
    <div class="col-xs-5 date">
        <div class="input-group input-append date" id="dateToPicker">
            <input id="dateTo" placeholder="До:" type="text" class="form-control"/>
            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
        <!--suppress JSUnresolvedFunction -->
        <script>
            $(document).ready(function () {
                $('#dateToPicker')
                    .datepicker({
                        format: 'yyyy-mm-dd 23:59:59',
                        startDate: '2015-01-01',
                        endDate: 'today'
                    })
            });
        </script>
    </div>
    <script>

        $(document).ready(function () {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();

            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            today = yyyy + '-' + mm + '-' + dd;

            $('#dateFrom').val(today + ' 00:00:01');
            $('#dateTo').val(today + ' 23:59:59');
            GetReport();
            GetReport2();
        });
    </script>

    <div>
        <div class="input-group input-append date" id="dateToPicker">
            <button type="button" class="btn btn-success" name="setRange" onclick='GetReport()'>Обновить</button>
        </div>
    </div>
</div>
<?php
echo '<h3 align="center">Time </h3>
    <table class="table table-hover table-bordered table-condensed">
    <thead>
    <td align="center"><strong>Колл-беки</strong></td>
    <td align="center"><strong>Кофе</strong></td>
    <td align="center"><strong>Обучение</strong></td>
    <td align="center"><strong>Ланч</strong></td>
    <td align="center"><strong>СС</strong></td>
    <td align="center"><strong>Ожидание</strong></td>
    <td align="center"><strong>Разговор</strong></td>
    <td align="center"><strong>Пауза</strong></td>
    <td align="center"><strong>DISPO</strong></td>
    <td align="center"><strong>DEAD</strong></td>
    <td align="center"><strong>LOGIN TIME</strong></td>
    </thead>';

echo '<tbody id="fetchedTimeData">';

echo '</tbody></table>'

?>
<h3 align="center">Orders list</h3>
<table class="table table-striped table-bordered table-condensed">
    <thead>
    <td align="center"><strong>#</strong></td>
    <td align="center"><strong>Создано</strong></td>
    <td align="center"><strong>Код клиента</strong></td>
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

    $conn = Database::connect();
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sqle = $conn->prepare('SELECT RECORD_ID, CLIENT_CODE, RECORD_TIME,UESR_DESC,CLIENT_PHONE, CLIENT_RESULT_KEY,ORDER_ISSALE,ORDER_CHECKSUM FROM crmyrdb.YvesRocher_ORDERS WHERE UESR_DESC=:usersel AND ORDER_ISSALE="Y" ORDER BY RECORD_ID DESC');
    $sqle->bindParam(':usersel', urldecode($_GET['user']));
    $sqle->execute();


    foreach ($sqle as $row) {
        echo '<tr>';
        echo '<td align="center">' . $row['RECORD_ID'] . '</td>';
        echo '<td align="center">' . $row['RECORD_TIME'] . '</td>';
        echo '<td align="center">' . $row['CLIENT_CODE'] . '</td>';
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

<?php
include_once "page_buttons.php";
include_once "../service/template/footer.php";
?>


