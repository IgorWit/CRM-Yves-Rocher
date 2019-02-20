<?php
$page_title = "Утильные";
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
                action: "GetUtils",
                StDate: StartReportDate,
                LsDate: EndReportDate
            }, success: function (responce) {
                $('#fetchedData').html(responce);
            }
        })
    }
</script>
<script>
    $(document).ready(function () {
        $.ajax({
                type: "POST",
                url: "../service/ajax/ajax-yves",
                data: {action: "GetCountOrders"},
                success: function (responce) {
                    $('#fetchedDataBases').html(responce);
                },
                error: function (res) {
                    $('#fetchedDatabases').html(res);
                }
            }
        )

    });
</script>
<form class="form-inline">
    <div class="col-xs-5 date">
        <div class="input-group input-append date" id="dateFromPicker">
            <input id="dateFrom" placeholder="От:" type="text" class="form-control"/>
            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
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
        });
    </script>

    <div>
        <div class="input-group input-append date" id="dateToPicker">
            <button type="button" class="btn btn-success" name="setRange" onclick='GetReport()'>Обновить</button>
        </div>
    </div>
</form>

<?php
echo "<div class='page-header'>";
echo "<h4>Кол-во утильных контактов по дням</h4>";
echo "</div>";
echo '
    </br>
    <table class="table table-hover table-bordered">
    <thead>
    <td align="center"><strong>Дата</strong></td>
    <td align="center"><strong>Кол-во</strong></td>
    </thead>';
echo '<tbody id="fetchedData">';

echo '</tbody></table>';


echo '<br><br><br>';
echo "<div class='page-header'>";
echo "<h4>Кол-во заказов по базам</h4>";
echo "</div>";
echo '
    </br>
    <table class="table table-hover table-bordered">
    <thead>
    <td align="center"><strong>База</strong></td>
    <td align="center"><strong>Кол-во заказов</strong></td>
    </thead>';
echo '<tbody id="fetchedDataBases">';

echo '</tbody></table>';


?>


<?php
include_once "../service/template/footer.php";
?>
