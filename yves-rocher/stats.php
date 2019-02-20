<?php
$page_title = "Сводный лист";
include_once '../service/template/header.php';
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script>
    function GetReport() {
        var StartReportDate = $('#dateFrom').val();
        var EndReportDate = $('#dateTo').val();
        $.ajax({
            type: "POST",
            url: "../service/ajax/ajax-yves",
            data: {
                action: "GetReportORDERS",
                StDate: StartReportDate,
                LsDate: EndReportDate
            }, success: function (responce) {
                $('#fetchedData').html(responce);
            }
        })
    }
</script>
<form class="form-inline">
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
                        startDate: '2016-01-01',
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
                        startDate: '2016-01-01',
                        endDate: 'today'
                    })
            });
        </script>
    </div>
    <script>

        $(document).ready(function () {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
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
        });
    </script>

    <div>
        <div class="input-group input-append date" id="dateToPicker">
            <button type="button" class="btn btn-primary" name="setRange" onclick='GetReport()'>Обновить</button>
        </div>
    </div>
</form>

<?php
echo '</br>
    <table class="table table-condensed table-bordered table-hover table-striped">
    <thead>
    <td align="center"><strong>ФИО</strong></td>
    <td align="center"><strong><410</strong></td>
    <td align="center"><strong>410-459</strong></td>
    <td align="center"><strong>460-509</strong></td>
    <td align="center"><strong>510-559</strong></td>
    <td align="center"><strong>>560 </strong></td>
    <td align="center"><strong>Всего</strong></td>
    <td align="center"><strong>Средний чек</strong></td>
    <td align="center"><strong>Выручка</strong></td>
    <td align="center"><strong>КФ. обработки базы</strong></td>
    </thead>';
echo '<tbody id="fetchedData">';

echo '</tbody></table>'

?>

<?php
include_once "../service/template/footer.php";
?>
