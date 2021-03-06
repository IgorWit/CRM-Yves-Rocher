<?php
include_once "mysql.inc.php";
switch ($_POST['action']):
    case"Save":

        require_once '../databases/MAIN_DB.php';
        $creator = Database::connect();
        $creator->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $que = $creator->prepare('INSERT INTO YvesRocher_ORDERS VALUES (DEFAULT,DEFAULT, ?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $que->bindValue(1, urldecode($_POST['USER']));
        $que->bindValue(2, urldecode($_POST['USER_DESC']));
        $que->bindValue(3, urldecode($_POST['CODE_CLIENT']));
        $que->bindValue(4, urldecode($_POST['FIO_CLIENT']));
        $que->bindValue(5, urldecode($_POST['PROPOSAL_KEY']));
        $que->bindValue(6, urldecode($_POST['CLIENT_CITY']));
        $que->bindValue(7, urldecode($_POST['CLIENT_PHONE']));
        $que->bindValue(8, urldecode($_POST['HOME_PHONE']));
        $que->bindValue(9, urldecode($_POST['ISUTIL']));
        $que->bindValue(10, urldecode($_POST['CHECKSUM']));
        $que->bindValue(11, urldecode($_POST['COMMENT']));
        $que->bindValue(12, urldecode($_POST['ISSALE']));
        $que->bindValue(13, urldecode($_POST['AUDIO_RECORD']));
        $que->bindValue(14, urldecode($_POST['LIST']));

        $que->execute();
        Database::disconnect();

        break;

    case "GetReportORDERS":
        require_once '../databases/MAIN_DB.php';
        $report = Database::connect();
        $report->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query1 = $report->prepare("SELECT
  USR,
  FIR,
  SEC,
  THI,
  FIF,
  SIX,
  AVGS,
SUM,
  TOTC,
  TOTC / CALLS KF
FROM
  (SELECT DISTINCT
     UESR_DESC USR,
     YROUD.q   FIR,
     YROUD1.q  SEC,
     YROUD2.q  THI,
     YROUD4.q  FIF,
     YROUD5.q  SIX,
     YROUD6.q  AVGS,
	YROUD7.q SUM,
     YROUD8.q  TOTC,
     YROUD9.q  CALLS
   FROM YvesRocher_ORDERS AS MAINTB
       LEFT JOIN (SELECT DISTINCT
                  UESR_DESC                 q1,
                  COUNT(DISTINCT RECORD_ID) q
                FROM YvesRocher_ORDERS
                WHERE ORDER_CHECKSUM BETWEEN '298.89' AND '409.99' AND ORDER_ISSALE = 'Y' AND
                      RECORD_TIME BETWEEN :STARTi AND :ENDi
                GROUP BY q1) AS YROUD ON YROUD.q1 = MAINTB.UESR_DESC

    LEFT JOIN (SELECT DISTINCT
                  UESR_DESC                 w1,
                  COUNT(DISTINCT RECORD_ID) q
                FROM YvesRocher_ORDERS
                WHERE ORDER_CHECKSUM BETWEEN '410.00' AND '459.99' AND ORDER_ISSALE = 'Y' AND
                      RECORD_TIME BETWEEN :STARTi AND :ENDi
                GROUP BY w1) AS YROUD1 ON YROUD1.w1 = MAINTB.UESR_DESC
                
      LEFT JOIN (SELECT DISTINCT
                  UESR_DESC                 e1,
                  COUNT(DISTINCT RECORD_ID) q
                FROM YvesRocher_ORDERS
                WHERE ORDER_CHECKSUM BETWEEN '460.00' AND '509.99' AND ORDER_ISSALE = 'Y' AND
                      RECORD_TIME BETWEEN :STARTi AND :ENDi
                GROUP BY e1) AS YROUD2 ON YROUD2.e1 = MAINTB.UESR_DESC
                
      LEFT JOIN (SELECT DISTINCT
                  UESR_DESC                 r1,
                  COUNT(DISTINCT RECORD_ID) q
                FROM YvesRocher_ORDERS
                WHERE ORDER_CHECKSUM BETWEEN '510.00' AND '559.99' AND ORDER_ISSALE = 'Y' AND
                      RECORD_TIME BETWEEN :STARTi AND :ENDi
                GROUP BY r1) AS YROUD4 ON YROUD4.r1 = MAINTB.UESR_DESC
                
     LEFT JOIN (SELECT DISTINCT
                  UESR_DESC                 t1,
                  COUNT(DISTINCT RECORD_ID) q
                FROM YvesRocher_ORDERS
                WHERE ORDER_CHECKSUM > '560.00' AND ORDER_ISSALE = 'Y' AND
                      RECORD_TIME BETWEEN :STARTi AND :ENDi
                GROUP BY t1) AS YROUD5 ON YROUD5.t1 = MAINTB.UESR_DESC
                      
    LEFT JOIN (SELECT DISTINCT
                  UESR_DESC                                   y1,
                  CAST(AVG(ORDER_CHECKSUM) AS DECIMAL(15, 2)) q
                FROM YvesRocher_ORDERS
                WHERE ORDER_CHECKSUM > '298.89' AND ORDER_ISSALE = 'Y' AND
                      RECORD_TIME BETWEEN :STARTi AND :ENDi
                GROUP BY y1) AS YROUD6 ON YROUD6.y1 = MAINTB.UESR_DESC

	LEFT JOIN (SELECT DISTINCT
                  UESR_DESC                                   o1,
                  CAST(SUM(ORDER_CHECKSUM) AS DECIMAL(15, 2)) q
                FROM YvesRocher_ORDERS
                WHERE ORDER_ISSALE = 'Y' AND
                      RECORD_TIME BETWEEN :STARTi AND :ENDi
                GROUP BY o1) AS YROUD7 ON YROUD7.o1 = MAINTB.UESR_DESC
                
   LEFT JOIN (SELECT DISTINCT
                  UESR_DESC        u1,
                  COUNT(RECORD_ID) q
                FROM YvesRocher_ORDERS
                WHERE ORDER_CHECKSUM > '298.89' AND ORDER_ISSALE = 'Y' AND
                      RECORD_TIME BETWEEN :STARTi AND :ENDi
                GROUP BY u1) AS YROUD8 ON YROUD8.u1 = MAINTB.UESR_DESC
               
     LEFT JOIN (SELECT DISTINCT
                  UESR_DESC        i1,
                  COUNT(RECORD_ID) q
                FROM YvesRocher_ORDERS
                WHERE RECORD_TIME BETWEEN :STARTi AND :ENDi
                GROUP BY i1) AS YROUD9 ON YROUD9.i1 = MAINTB.UESR_DESC
                
   WHERE RECORD_TIME BETWEEN :STARTi AND :ENDi
   GROUP BY UESR_DESC
   ORDER BY AVGS DESC) s;
");

        $query1->bindParam(':STARTi', $_POST['StDate']);
        $query1->bindParam(':ENDi', $_POST['LsDate']);
        $query1->execute();

        foreach ($query1 as $row) {
            echo '<tr href="user_detail?user=' . $row['USR'] . '">';
            echo '<td align="center"><a target="_blank" style="text-decoration: none" href="user_detail?user=' . $row['USR'] . '">' . $row['USR'] . '</a></td>';
            echo '<td align="center">' . $row['FIR'] . '</td>';
            echo '<td  align="center">' . $row['SEC'] . '</td>';
            echo '<td align="center">' . $row['THI'] . '</td>';
            echo '<td  align="center">' . $row['FIF'] . '</td>';
            echo '<td  align="center">' . $row['SIX'] . '</td>';
            echo '<td align="center">' . $row['TOTC'] . '</td>';
            echo '<td align="center">' . $row['AVGS'] . '</td>';
            echo '<td align="center">' . $row['SUM'] . '</td>';
            echo '<td align="center">' . $row['KF'] . '</td>';

        }

        $query2 = $report->prepare("SELECT

 CNT,
  AVGI,
  SUMMA,
  FIRSEQ,
  SECEQ,
  THIEQ,
  FIFEQ,
  SIXEQ,
  CALLS,
  CNT / CALLS KF
FROM (SELECT
        (SELECT COUNT(DISTINCT RECORD_ID)
         FROM YvesRocher_ORDERS
         WHERE ORDER_CHECKSUM > '298.89' AND ORDER_ISSALE = 'Y'  
		AND RECORD_TIME BETWEEN :STARTi AND :ENDi)                         CNT,

        (SELECT CAST(AVG(ORDER_CHECKSUM) AS DECIMAL(15, 2))
         FROM YvesRocher_ORDERS
         WHERE ORDER_CHECKSUM > '298.89' AND ORDER_ISSALE = 'Y'
	     AND RECORD_TIME BETWEEN :STARTi AND :ENDi)   AVGI,


(SELECT CAST(SUM(ORDER_CHECKSUM) AS
                     DECIMAL(15, 2))
         FROM YvesRocher_ORDERS
         WHERE ORDER_CHECKSUM > '298.89' AND ORDER_ISSALE = 'Y'
		    AND RECORD_TIME BETWEEN :STARTi AND :ENDi)                           SUMMA,
         
        (SELECT COUNT(DISTINCT RECORD_ID)
         FROM YvesRocher_ORDERS
         WHERE ORDER_CHECKSUM BETWEEN '298.89' AND '409.99' AND ORDER_ISSALE = 'Y' AND
               RECORD_TIME BETWEEN :STARTi AND :ENDi)                        FIRSEQ,
         
        (SELECT COUNT(DISTINCT RECORD_ID)
         FROM YvesRocher_ORDERS
         WHERE ORDER_CHECKSUM BETWEEN '410.00' AND '459.99' AND ORDER_ISSALE = 'Y' AND
               RECORD_TIME BETWEEN :STARTi AND :ENDi)                             SECEQ,
         
        (SELECT COUNT(DISTINCT RECORD_ID)
         FROM YvesRocher_ORDERS
         WHERE ORDER_CHECKSUM BETWEEN '460.00' AND '509.99' AND ORDER_ISSALE = 'Y' AND
               RECORD_TIME BETWEEN :STARTi AND :ENDi)                             THIEQ,
         
        (SELECT COUNT(DISTINCT RECORD_ID)
         FROM YvesRocher_ORDERS
         WHERE ORDER_CHECKSUM BETWEEN '510.00' AND '559.99' AND ORDER_ISSALE = 'Y' AND
               RECORD_TIME BETWEEN :STARTi AND :ENDi)                              FIFEQ,
        
	  (SELECT COUNT(DISTINCT RECORD_ID)
         FROM YvesRocher_ORDERS
         WHERE ORDER_CHECKSUM >= '560.00' AND ORDER_ISSALE = 'Y' 
		AND RECORD_TIME BETWEEN :STARTi AND :ENDi) 						SIXEQ,


       (SELECT count(DISTINCT RECORD_ID)
         FROM YvesRocher_ORDERS
         WHERE RECORD_TIME BETWEEN :STARTi AND :ENDi)                     CALLS
      LIMIT 1) AS s");

        $query2->bindParam(':STARTi', $_POST['StDate']);
        $query2->bindParam(':ENDi', $_POST['LsDate']);
        $query2->execute();
        foreach ($query2 as $row2) {
            echo '<tr data-href="index">';
            echo '<td align="center"><strong><a target="_blank" style="text-decoration: none" href="index">TOTAL:</a></strong></td>';
            echo '<td align="center"><strong>' . $row2['FIRSEQ'] . '</strong></td>';
            echo '<td align="center"><strong>' . $row2['SECEQ'] . '</strong></td>';
            echo '<td align="center"><strong>' . $row2['THIEQ'] . '</strong></td>';
            echo '<td align="center"><strong>' . $row2['FIFEQ'] . '</strong></td>';
            echo '<td align="center"><strong>' . $row2['SIXEQ'] . '</strong></td>';
            echo '<td align="center"><strong>' . $row2['CNT'] . '</strong></td>';
            echo '<td align="center"><strong>' . $row2['AVGI'] . '</strong></td>';
            echo '<td align="center"><strong>' . $row2['SUMMA'] . '</strong></td>';
            echo '<td align="center"><strong>' . $row2['KF'] . '</strong></td>';
            echo '</tr>';
        }
        Database::disconnect();

        break;


    case "GetUtils":
        require_once '../databases/MAIN_DB.php';
        $util = Database::connect();
        $util->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $queryutil = $util->prepare("SELECT date(RECORD_TIME) days, COUNT(DISTINCT CLIENT_CODE) utlc  FROM YvesRocher_ORDERS WHERE CLIENT_RESULT_KEY='Y' AND RECORD_TIME BETWEEN :startd AND :endd GROUP BY day(RECORD_TIME) ORDER BY DAY(RECORD_TIME)");
        $queryutil->bindParam(':startd', $_POST['StDate']);
        $queryutil->bindParam(':endd', $_POST['LsDate']);
        $queryutil->execute();
        foreach ($queryutil as $row3) {
            echo '<tr>';
            echo '<td align="center"><strong>' . $row3['days'] . '</strong></td>';
            echo '<td align="center">' . $row3['utlc'] . '</td>';
        }
        $queryutil2 = $util->prepare("SELECT COUNT(DISTINCT CLIENT_CODE) utlc  FROM YvesRocher_ORDERS WHERE CLIENT_RESULT_KEY='Y' AND RECORD_TIME BETWEEN :startd AND :endd ");
        $queryutil2->bindParam(':startd', $_POST['StDate']);
        $queryutil2->bindParam(':endd', $_POST['LsDate']);
        $queryutil2->execute();
        foreach ($queryutil2 as $row4) {
            echo '<tr>';
            echo '<td align="center"><strong>TOTAL: </strong></td>';
            echo '<td align="center">' . $row4['utlc'] . '</td>';
        }
        break;


    case "GetReportTime":
        require_once '../databases/vicidial_db-asterisk1.php';
        $time = Database_vici_asterisk1::connect();
        $time->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $querytime = $time->prepare("SELECT
  dd.full_name           FIO,
  dd.user_group          USRGR,
  sec_to_time(CBP.tim)   CALLBK,
  sec_to_time(COF.tim)   Coffee,
  sec_to_time(ED.tim)    EDUCATION,
  sec_to_time(LUN.tim)   LUNCH,
  sec_to_time(CC.tim)    CC,
  sec_to_time(WAIT.tim)  WAIT,
  sec_to_time(TALK.tim)  TALK,
  sec_to_time(DISPO.tim) DISPO,
  sec_to_time(DEAD.tim)  DEAD,
  sec_to_time(PAUSE.tim) PAUSE,
  sec_to_time(TOTAL.tim) TOTAL

FROM vicidial_agent_log AS TIMETAB
  INNER JOIN (SELECT
                user,
                full_name,
                user_group
              FROM vicidial_users) AS dd
    ON dd.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE sub_status = 'CBACK' AND user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS CBP
    ON CBP.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE sub_status = 'COFFEE' AND user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS COF
    ON COF.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE sub_status = 'EDU' AND user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS ED
    ON ED.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE sub_status = 'LAUNCH' AND user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS LUN
    ON LUN.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE sub_status = 'CC' AND user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS CC
    ON CC.user = TIMETAB.user

  LEFT JOIN (
              SELECT
                user,
                sum(wait_sec) tim
              FROM vicidial_agent_log
              WHERE user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS WAIT
    ON WAIT.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(talk_sec) tim
              FROM vicidial_agent_log
              WHERE user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS TALK
    ON TALK.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(dispo_sec) tim
              FROM vicidial_agent_log
              WHERE user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS DISPO
    ON DISPO.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(dead_sec) tim
              FROM vicidial_agent_log
              WHERE user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS DEAD
    ON DEAD.user = TIMETAB.user
LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS PAUSE
    ON PAUSE.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                (sum(wait_sec) + sum(talk_sec) + sum(dispo_sec) + sum(dead_sec) + sum(pause_sec)) tim
              FROM vicidial_agent_log
              WHERE user_group='Yves_Rocher' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS TOTAL
    ON TOTAL.user = TIMETAB.user

WHERE dd.user_group='Yves_Rocher' AND event_time BETWEEN :startd AND :endd
GROUP BY dd.full_name;");
        $querytime->bindParam(':startd', $_POST['StDate']);
        $querytime->bindParam(':endd', $_POST['LsDate']);
        $querytime->execute();
        foreach ($querytime as $row4) {
            echo '<tr>';
            echo '<td align="center"><strong>' . $row4['FIO'] . '</strong></td>';
            echo '<td align="center">' . $row4['USRGR'] . '</td>';
            echo '<td align="center">' . $row4['CALLBK'] . '</td>';
            echo '<td align="center">' . $row4['Coffee'] . '</td>';
            echo '<td align="center">' . $row4['EDUCATION'] . '</td>';
            echo '<td align="center">' . $row4['LUNCH'] . '</td>';
            echo '<td align="center">' . $row4['CC'] . '</td>';
            echo '<td align="center">' . $row4['WAIT'] . '</td>';
            echo '<td align="center">' . $row4['TALK'] . '</td>';
            echo '<td align="center">' . $row4['PAUSE'] . '</td>';
            echo '<td align="center">' . $row4['DISPO'] . '</td>';
            echo '<td align="center">' . $row4['DEAD'] . '</td>';
            echo '<td align="center"><strong>' . $row4['TOTAL'] . '</strong></td>';


            echo '</tr>';
        }

        break;


    case "GetCountOrders":
        require_once "../databases/MAIN_DB.php";
        require_once "../databases/vicidial_db-asterisk1.php";
        $con = Database::connect();
        $quebase = $con->prepare("SELECT list_id list, COUNT(RECORD_ID) coun FROM YvesRocher_ORDERS WHERE ORDER_ISSALE='Y' AND ORDER_CHECKSUM>'0.00' GROUP BY list_id");
        $quebase->execute();
        foreach ($quebase as $bas) {
            echo '<tr>';
            echo '<td align="center"><strong>' . $bas['list'] . '</strong></td>';
            echo '<td align="center">' . $bas['coun'] . '</td>';
        }

        break;

    case "GetAgentTime":
        require_once '../databases/vicidial_db-asterisk1.php';
        $time = Database_vici_asterisk1::connect();
        $time->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $getagent = $time->prepare("SELECT user FROM vicidial_users WHERE full_name=:agn_fullname");
        $getagent->bindParam(':agn_fullname', urldecode($_POST['user']), PDO::PARAM_STR);
        $getagent->execute();
        $agn = $getagent->fetch(PDO::FETCH_ASSOC);
        $querytime = $time->prepare("SELECT
  TIMETAB.user,
  sec_to_time(CBP.tim)   CALLBK,
  sec_to_time(COF.tim)   Coffee,
  sec_to_time(ED.tim)    EDUCATION,
  sec_to_time(LUN.tim)   LUNCH,
  sec_to_time(CC.tim)    CC,
  sec_to_time(WAIT.tim)  WAIT,
  sec_to_time(TALK.tim)  TALK,
  sec_to_time(DISPO.tim) DISPO,
  sec_to_time(DEAD.tim)  DEAD,
  sec_to_time(PAUSE.tim) PAUSE,
  sec_to_time(TOTAL.tim) TOTAL

FROM vicidial_agent_log AS TIMETAB
  INNER JOIN (SELECT
                user,
                full_name,
                user_group
              FROM vicidial_users WHERE user=:reusr) AS dd
    ON dd.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE user=:reusr AND sub_status = 'CBACK' AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS CBP
    ON CBP.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE sub_status = 'COFFEE' AND user=:reusr AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS COF
    ON COF.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE sub_status = 'EDU' AND user=:reusr AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS ED
    ON ED.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE sub_status = 'LAUNCH' AND user=:reusr AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS LUN
    ON LUN.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE sub_status = 'CC' AND user=:reusr AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS CC
    ON CC.user = TIMETAB.user

  LEFT JOIN (
              SELECT
                user,
                sum(wait_sec) tim
              FROM vicidial_agent_log
              WHERE user=:reusr AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS WAIT
    ON WAIT.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(talk_sec) tim
              FROM vicidial_agent_log
              WHERE user=:reusr AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS TALK
    ON TALK.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(dispo_sec) tim
              FROM vicidial_agent_log
              WHERE user=:reusr AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS DISPO
    ON DISPO.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                sum(dead_sec) tim
              FROM vicidial_agent_log
              WHERE user=:reusr AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS DEAD
    ON DEAD.user = TIMETAB.user
LEFT JOIN (
              SELECT
                user,
                sum(pause_sec) tim
              FROM vicidial_agent_log
              WHERE user=:reusr AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS PAUSE
    ON PAUSE.user = TIMETAB.user
  LEFT JOIN (
              SELECT
                user,
                (sum(wait_sec) + sum(talk_sec) + sum(dispo_sec) + sum(dead_sec) + sum(pause_sec)) tim
              FROM vicidial_agent_log
              WHERE user=:reusr AND
                    event_time BETWEEN :startd AND :endd GROUP BY user) AS TOTAL
    ON TOTAL.user = TIMETAB.user

WHERE event_time BETWEEN :startd AND :endd GROUP BY TIMETAB.user;");
        $querytime->bindParam(':startd', $_POST['StDate']);
        $querytime->bindParam(':endd', $_POST['LsDate']);
        $querytime->bindParam(':reusr', $agn['user']);
        $querytime->execute();
        $res_single_agent = $querytime->fetch(PDO::FETCH_ASSOC);
        echo '<tr>';
        echo '<td align="center">' . $res_single_agent['CALLBK'] . '</td>';
        echo '<td align="center">' . $res_single_agent['Coffee'] . '</td>';
        echo '<td align="center">' . $res_single_agent['EDUCATION'] . '</td>';
        echo '<td align="center">' . $res_single_agent['LUNCH'] . '</td>';
        echo '<td align="center">' . $res_single_agent['CC'] . '</td>';
        echo '<td align="center">' . $res_single_agent['WAIT'] . '</td>';
        echo '<td align="center">' . $res_single_agent['TALK'] . '</td>';
        echo '<td align="center">' . $res_single_agent['PAUSE'] . '</td>';
        echo '<td align="center">' . $res_single_agent['DISPO'] . '</td>';
        echo '<td align="center">' . $res_single_agent['DEAD'] . '</td>';
        echo '<td align="center"><strong>' . $res_single_agent['TOTAL'] . '</strong></td>';
        echo '</tr>';


        break;

    case "GetAgentOrderSummary":
        require_once '../databases/MAIN_DB.php';
        $single_agent_orders = Database::connect();
        $single_agent_orders->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $get_sin_ord = $single_agent_orders->prepare("SELECT DISTINCT
  UESR_DESC USR,
  YROUD.q   FIR,
  YROUD1.w  SEC,
  YROUD2.e  THI,
  YROUD3.r  FOU,
  YROUD4.t  AVGS,
  YROUD6.u  TOTC
FROM YvesRocher_ORDERS AS MAINTB
  LEFT JOIN (SELECT DISTINCT
               UESR_DESC                   q1,
               COUNT(DISTINCT RECORD_ID) q
             FROM YvesRocher_ORDERS
             WHERE user=:reusr AND ORDER_CHECKSUM BETWEEN '0.01' AND '320.00' AND ORDER_ISSALE = 'Y' AND
                   RECORD_TIME BETWEEN :STARTi AND :ENDi
             GROUP BY q1) AS YROUD ON YROUD.q1 = MAINTB.UESR_DESC

  LEFT JOIN (SELECT DISTINCT
               UESR_DESC                   w1,
               COUNT(DISTINCT RECORD_ID) w
             FROM YvesRocher_ORDERS
             WHERE user=:reusr AND ORDER_CHECKSUM BETWEEN '320.01' AND '399.99' AND ORDER_ISSALE = 'Y' AND
                   RECORD_TIME BETWEEN :STARTi AND :ENDi
             GROUP BY w1) AS YROUD1 ON YROUD1.w1 = MAINTB.UESR_DESC

  LEFT JOIN (SELECT DISTINCT
               UESR_DESC                   e1,
               COUNT(DISTINCT RECORD_ID) e
             FROM YvesRocher_ORDERS
             WHERE user=:reusr AND ORDER_CHECKSUM BETWEEN '400.00' AND '599.99' AND ORDER_ISSALE = 'Y' AND
                   RECORD_TIME BETWEEN :STARTi AND :ENDi
             GROUP BY e1) AS YROUD2 ON YROUD2.e1 = MAINTB.UESR_DESC

  LEFT JOIN (SELECT DISTINCT
               UESR_DESC                   r1,
               COUNT(DISTINCT RECORD_ID) r
             FROM YvesRocher_ORDERS
             WHERE user=:reusr AND ORDER_CHECKSUM > '600.00' AND ORDER_ISSALE = 'Y' AND
                   RECORD_TIME BETWEEN :STARTi AND :ENDi
             GROUP BY r1) AS YROUD3 ON YROUD3.r1 = MAINTB.UESR_DESC

  LEFT JOIN (SELECT DISTINCT
               UESR_DESC                                   t1,
               CAST(AVG(ORDER_CHECKSUM) AS DECIMAL(15, 2)) t
             FROM YvesRocher_ORDERS
             WHERE user=:reusr AND ORDER_CHECKSUM>'0.01' AND ORDER_ISSALE = 'Y' AND
                   RECORD_TIME BETWEEN :STARTi AND :ENDi
             GROUP BY t1) AS YROUD4 ON YROUD4.t1 = MAINTB.UESR_DESC

  LEFT JOIN (SELECT DISTINCT
               UESR_DESC                                   y1,
               CAST(SUM(ORDER_CHECKSUM) AS DECIMAL(15, 2)) y
             FROM YvesRocher_ORDERS
             WHERE user=:reusr AND ORDER_ISSALE = 'Y' AND
                   RECORD_TIME BETWEEN :STARTi AND :ENDi
             GROUP BY y1) AS YROUD5 ON YROUD5.y1 = MAINTB.UESR_DESC

  LEFT JOIN (SELECT DISTINCT
               UESR_DESC                   u1,
               COUNT(RECORD_ID) u
             FROM YvesRocher_ORDERS
             WHERE user=:reusr AND ORDER_ISSALE = 'Y' AND
                   RECORD_TIME BETWEEN :STARTi AND :ENDi
             GROUP BY u1) AS YROUD6 ON YROUD6.u1 = MAINTB.UESR_DESC
WHERE user=:reusr AND ORDER_ISSALE='Y'AND RECORD_TIME BETWEEN :STARTi AND :ENDi
GROUP BY UESR_DESC;");
        $get_sin_ord->bindParam(':STARTi', $_POST['StDate']);
        $get_sin_ord->bindParam(':ENDi', $_POST['LsDate']);
        $get_sin_ord->bindParam(':reusr', $_POST['user'], PDO::PARAM_STR);
        $get_sin_ord->execute();
        $single_agent_summary = $get_sin_ord->fetch(PDO::FETCH_ASSOC);
        echo '<tr>';
        echo '<td align="center"><strong>TOTAL</strong></td>';
        echo '<td align="center"><strong>' . $single_agent_summary['FIRSEQ'] . '</strong></td>';
        echo '<td align="center"><strong>' . $single_agent_summary['SECEQ'] . '</strong></td>';
        echo '<td align="center"><strong>' . $single_agent_summary['THIEQ'] . '</strong></td>';
        echo '<td align="center"><strong>' . $single_agent_summary['FOUEQ'] . '</strong></td>';
        echo '<td align="center"><strong>' . $single_agent_summary['CNT'] . '</strong></td>';
        echo '<td align="center"><strong>' . $single_agent_summary['AVGI'] . '</strong></td>';
        echo '</tr>';
        Database::disconnect();
        break;
endswitch;
