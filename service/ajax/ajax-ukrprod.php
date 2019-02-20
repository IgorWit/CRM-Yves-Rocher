<?php
# include data base
include "mysql.inc.php";

switch ($_POST['action']):

    case "showRegionForInsert":
        echo '<option value="">-Оберiть район-</option>';
        $sql = "SELECT * FROM agroprod_regions WHERE id_company = '" . mysql_real_escape_string($_POST['id_country'], $link) . "' ORDER BY region ASC";
        $resource = mysql_query($sql, $link);
        while ($row = mysql_fetch_assoc($resource))
            echo '<option value="' . $row['id_region'] . '">' . $row['region'] . '</option>';
        break;

    case "showCityForInsert":
        echo '<option value="">-Оберiть село-</option>';
        $sql = "SELECT * FROM agroprod_villages WHERE id_region = '" . mysql_real_escape_string($_POST['id_region'], $link) . "' ORDER BY village ASC";
        $resource = mysql_query($sql, $link);
        while ($row = mysql_fetch_assoc($resource))
            echo '<option value="' . $row['id_village'] . '">' . $row['village'] . '</option>';
        break;

    case "Save":
        require_once '../databases/MAIN_DB.php';
        $creator = Database::connect();
        $creator->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $que = $creator->prepare('INSERT INTO AGROPROD_TREATMENTS VALUES (DEFAULT,DEFAULT, ?,?,?,?,?,?,?,?,?)');
        $que->bindValue(1, urldecode($_POST['USER']));
        $que->bindValue(2, urldecode($_POST['CLIENT_FIO']));
        $que->bindValue(3, $_POST['CLIENT_PHONE']);
        $que->bindValue(4, urldecode($_POST['TREATMENT_CATEGORY']));
        $que->bindValue(5, urldecode($_POST['COMPANY']));
        $que->bindValue(6, urldecode($_POST['REGION']));
        $que->bindValue(7, urldecode($_POST['VILLAGE']));
        $que->bindValue(8, urldecode($_POST['TREATMENT_REASON']));
        $que->bindValue(9, urldecode($_POST['AUDIO_RECORD']));
        $que->execute();
        Database::disconnect();
        break;

endswitch;
?>