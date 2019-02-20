<?php
$page_title = "Нове звернення";
include_once "../service/template/header.php";
?>
<script type="text/javascript" src="/service/ajax/jquery.js"></script>
<script src="/service/alerts/sweet-alert.min.js"></script>
<link rel="stylesheet" type="text/css" href="/service/alerts/sweet-alert.css">
<script language="JavaScript">

    function selectRegion() {
        var id_country = $('select[name="country"]').val();
        if (!id_country) {
            $('select[name="selectDataRegion"]').html('');
            $('select[name="selectDataCity"]').html('');
        } else {
            $.ajax({
                type: "POST",
                url: "/service/ajax/ajax-ukrprod",
                data: {action: "showRegionForInsert", id_country: id_country},
                success: function (responce) {
                    $('select[name="selectDataRegion"]').html(responce);
                }
            });
        }
    }

    function selectCity() {
        var id_region = $('select[name="selectDataRegion"]').val();
        $.ajax({
            type: "POST",
            url: "/service/ajax/ajax-ukrprod",
            data: {action: 'showCityForInsert', id_region: id_region},
            success: function (responce) {
                $('select[name="selectDataCity"]').html(responce);
            }
        });

    }

    function SaveTR() {

        var USER = $('input[name="user"]').val();
        var CLIENT_FIO = $('input[name="fio_client"]').val();
        var CLIENT_PHONE = $('input[name="mob_phone"]').val();
        var TREATMENT_CATEGORY = $('#category').find('option:selected').text();
        var COMPANY = $('#company').find('option:selected').text();
        var REGION = $('#region').find('option:selected').text();
        var VILLAGE = $('#village').find('option:selected').text();
        var TREATMENT_REASON = $('textarea[name="comment"]').val();
        var AUDIO_RECORD = $('input[name="audio"]').val();
        $.ajax({
            type: "POST",
            url: "/service/ajax/ajax-ukrprod",
            data: {
                action: "Save",
                USER: USER,
                CLIENT_FIO: CLIENT_FIO,
                CLIENT_PHONE: CLIENT_PHONE,
                TREATMENT_CATEGORY: TREATMENT_CATEGORY,
                COMPANY: COMPANY,
                REGION: REGION,
                VILLAGE: VILLAGE,
                TREATMENT_REASON: TREATMENT_REASON,
                AUDIO_RECORD: AUDIO_RECORD
            },
            success: function () {
            }
        });
        swal({title: "", text: "Звернення успiшно збережено!", timer: 2000, type: "success"});
    }

</script>
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Користувач:</td>
        <td><input type='text' name='user' class="form-control" value="<?php echo $_GET['user'] ?>"></td>
    </tr>
    <tr>
        <td>ПІБ Клієнта:</td>
        <td><input type='text' name='fio_client' class="form-control"></td>
    </tr>
    <tr>
        <td>Номер телефону:</td>
        <td><input type='text' name='mob_phone' value="<?php echo $_GET['number'] ?>" class='form-control'></td>
    </tr>
    <tr>
        <td>Категорія звернення:</td>
        <td><select id="category" name='category' class='form-control'>
                <option value="1">Інформація з зворотнім зв'язком</option>
                <option value="2">Скарга</option>
                <option value="3">Хуліганство/Спам</option>
                <option value="4">Довідкова інформація</option>
                <option value="5">Інформація без зворотнього зв'язку</option>
                <option value="6">Повторна заявка</option>
                <option value="7">Зрив зв'язку</option>
        </td>
    </tr>
    <tr>
        <td>Підприємство:</td>
        <td>
            <select size="1" id="company" name="country" onchange="selectRegion()" class="form-control">
                <option value="">-Оберіть підприємство-</option>
                <option value="1">ПрАТ «ПК «Поділля»</option>
                <option value="2">ТОВ «ПК «Зоря Поділля»</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Район:</td>
        <td>
            <select size="1" id="region" name="selectDataRegion" onchange="selectCity()" class="form-control">
                <option value="">-Оберiть район-</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Село:</td>
        <td>
            <select id="village" name="selectDataCity" class="form-control">
                <option value="">-Оберiть село-</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Текст звернення:</td>
        <td><textarea name='comment' class='form-control' maxlength="2000"></textarea></td>
    </tr>
    <tr>
        <td>Назва аудіофайла:</td>
        <td><input hidden="hidden" type="text" name='audio' class='form-control' value="<?php echo $_GET['audio'] ?>">
        </td>
    </tr>
    <td>
        <button type="button" onclick="location.href='/ukrprodinvest/'"
                class="btn-success btn-block btn form-control">Повернутись
        </button>
    </td>
    <td>
        <button type="submit" onclick="SaveTR()"
                class="btn-primary btn form-control">Зберегти
        </button>
    </td>
</table>
<?php
include_once "../service/template/footer.php";
?>
<style>
    textarea {
        resize: vertical;
    }

    label {
        font-size: small;
    }


</style>