<?php
switch ($_POST['act']):
    case"Check":
        require_once '../databases/vicidial-db-asterisk.php';
        $con = Database_vici_asterisk::connect();
        $query = $con->prepare('SELECT entry_date, phone_number FROM vicidial_list WHERE list_id="103" AND status="AFTHRS"');
        $query->execute();
        foreach ($query as $row) {
            echo '<tr>';
            echo '<td align="center">' . $row['entry_date'] . '</td>';
            echo '<td align="center">' . $row['phone_number'] . '</td>';
            echo '<td align="center"><button type="button" class="btn-success btn-group-justified btn-block" onclick="Call(' . $row['phone_number'] . ')">В работу</button></td>';
            echo '</tr>';
        }
        break;

    case"Getta":
        require_once '../databases/vicidial-db-asterisk.php';
        //setting status for selected phone number, end removing from pool
        $con = Database_vici_asterisk::connect();
        $query = $con->prepare('UPDATE vicidial_list SET status="NEW" WHERE list_id="103" AND status="AFTHRS" AND phone_number=' . $_POST['number']);
        $query->execute();
        Database_vici_asterisk::disconnect();
        //generate url string for call vicidial api, and execute th.
        $numb = substr($_POST['number'], 2, 10);
        $generate_url = 'http://10.0.210.10/agc/api.php?source=test&user=7701&pass=7701&agent_user=' . urldecode($_POST['agent']) . '&function=external_dial&value=' . $numb . '&phone_code=1&search=YES&preview=NO&focus=YES&dial_prefix=5';
        $curl = curl_init($generate_url);
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;

        break;

    case "CheckAgent":
        require_once '../databases/vicidial-db-asterisk.php';
        $c = Database_vici_asterisk::connect();
        $q = $c->prepare('SELECT user,status,campaign_id FROM vicidial_live_agents WHERE user=' . $_POST['user']);
        $q->execute();
        $result = $q->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
        break;
endswitch;
