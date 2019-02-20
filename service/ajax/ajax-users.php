<?php
include_once "mysql.inc.php";
switch ($_POST['action']):

    case "getUserGroups":
        echo '<option value="">-Выберите группу-</option>';
        $sql = "SELECT * FROM user_group ORDER BY group_id ASC";
        $resource = mysql_query($sql, $link);
        while ($row = mysql_fetch_assoc($resource))
            echo '<option value="" ' . $row['group_id'] . '">' . $row['group_desc'] . '</option>';
        break;

    case "Save":
        include_once "../databases/MAIN_DB.php";
        $pdo = Database::connect();
        $query = $pdo->prepare('INSERT INTO MAIN.users (user_login,user_password,user_fullname, user_group) VALUES (:login,:pass,:fio,:grou)');
        $query->bindValue(':login', $_POST['USER']);
        $query->bindValue(':pass', $_POST['USER_PASS']);
        $query->bindValue(':fio', $_POST['FIO_USER']);
        $query->bindValue(':grou', $_POST['USER_GROUP']);
        $query->execute();
        break;

    case "CheckLogin":

        break;

endswitch;

?>