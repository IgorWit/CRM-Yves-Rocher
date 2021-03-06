<?php
$page_title = "Новая запись";

include_once "../service/template/header.php";
?>
    <script type="text/javascript" src="../service/ajax/jquery.js"></script>
    <script src="../service/alerts/sweet-alert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../service/alerts/sweet-alert.css">

    <script>
        function Save() {
            var intege = $('input[name="amountInteger"]').val();
            var fracti = $('input[name="amountFraction"]').val();
            var SUMM = parseFloat(intege.concat(".", fracti));

            var USER = $('input[name="user"]').val();
            var USER_DESC = $('input[name="desc"]').val();
            var AUDIO_RECORD = $('input[name="record"]').val();
            var CODE_CLIENT = $('input[name="code_client"]').val();
            var FIO_CLIENT = $('input[name="fio_client"]').val();
            var PROPOSAL_KEY = $('input[name="proposal_key"]').val();
            var CLIENT_CITY = $('input[name="city"]').val();
            var CLIENT_PHONE = $('input[name="mob_phone"]').val();
            var HOME_PHONE = $('input[name="home_phone"]').val();
            var ISUTIL = $('#is_util').find('option:selected').val();
            var ISSALE = $('#is_sale').find('option:selected').val();
            var CHECKSUM = SUMM;
            var COMMENT = $('textarea[name="comment"]').val();
            var LIST = $('input[name="list"]').val();
            $.ajax({
                type: "POST",
                url: "../service/ajax/ajax-yves",
                data: {
                    action: "Save",
                    USER: USER,
                    USER_DESC: USER_DESC,
                    AUDIO_RECORD: AUDIO_RECORD,
                    CODE_CLIENT: CODE_CLIENT,
                    FIO_CLIENT: FIO_CLIENT,
                    PROPOSAL_KEY: PROPOSAL_KEY,
                    CLIENT_CITY: CLIENT_CITY,
                    CLIENT_PHONE: CLIENT_PHONE,
                    HOME_PHONE: HOME_PHONE,
                    ISUTIL: ISUTIL,
                    ISSALE: ISSALE,
                    CHECKSUM: CHECKSUM,
                    COMMENT: COMMENT,
                    LIST: LIST
                }, success: function () {
                    swal({
                        title: "",
                        text: "Сохранено!",
                        type: "success",
                        timer: 2000

                    });

                    location.href = '../yves-rocher/';
                }
            });
        }


    </script>

    <style>
        textarea {
            resize: vertical;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Номер пользователя</td>
            <td><input readonly type='text' class='form-control' name="user" value="<?php echo $_GET['user_num']; ?>"</td>
        </tr>

        <tr>
            <td>ФИО пользователя</td>
            <td><input readonly type='text' class='form-control'
                       name="desc" value="<?php echo urldecode($_GET['user_desc']); ?>"</td>
        </tr>

        <tr hidden>
            <td>Название аудио</td>
            <td><input type='text' class='form-control' name="record" value="<?php echo $_GET['audio']; ?>"
            </td>
        </tr>

        <tr hidden>
            <td>Номер листа</td>
            <td><input type='text' class='form-control' name="list" value="<?php echo $_GET['list']; ?>"</td>
        </tr>


        <tr>
            <td>Код клиента</td>
            <td><input readonly type='text' name='code_client' value="<?php echo urldecode($_GET['code']); ?>"
                       class='form-control' ></td>
        </tr>

        <tr>
            <td>ФИО клиента</td>
            <td><input readonly type='text' name='fio_client' value="<?php echo urldecode($_GET['fio']); ?>"
                       class='form-control' ></td>
        </tr>

        <tr>
            <td>Ключ</td>
            <td><input readonly type='text' name='proposal_key' value="<?php echo $_GET['key']; ?>" class='form-control'
                       ></td>
        </tr>

        <tr>
            <td>Город</td>
            <td><input readonly type='text' name='city' class='form-control' value="<?php echo urldecode($_GET['city']); ?>"
                       ></td>
        </tr>

        <tr>
            <td>Мобильный телефон:</td>
            <td><input readonly type='text' name='mob_phone' class='form-control' value="<?php echo $_GET['mobile']; ?>"
                       ></td>
        </tr>

        <tr>
            <td>Домашний телефон:</td>
            <td><input readonly type='text' name='home_phone' value="<?php echo $_GET['home']; ?>" class='form-control'
                       ></td>
        </tr>

        <tr>
            <td>Презентация:</td>
            <td><select id="is_util" name='is_util' class='form-control'>
                    <option value='N'>Нет</option>
                    <option value='Y'>Да</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Заказ:</td>
            <td>
                <select id="is_sale" name='is_sale' class='form-control'>
                    <option value='N'>Нет</option>
                    <option value='Y'>Да</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Сумма заказа:</td>
            <td>
                <form class="form-inline">
                    <div class="form-group">
                        <input type="text" required id="integ" name="amountInteger" class="form-control" placeholder="0"
                               onkeyup='this.value=parseInt(this.value) | 0'
                               maxlength="5"/>
                        <input type="text" required id="fraction" name="amountFraction" class="form-control"
                               placeholder="00"
                               onkeyup='this.value=parseInt(this.value) | 0'
                               maxlength="2"/>
                    </div>
                </form>
            </td>
        </tr>
        <tr>
            <td>Комментарий:</td>
            <td><textarea name='comment' class='form-control' maxlength="2000"></textarea></td>
        </tr>
    </table>

    <button id="savebut" type="button" onclick="Save()" class="btn-success btn form-control">Сохранить</button>
	<script type="text/javascript">
	$('body').one('click','#savebut',function(){ 
	alert('Один раз нажал и хватит!'); 
	});  
	</script type="text/javascript">
<?php
include_once "client_history.php";
include_once "../service/template/footer.php";
?>
