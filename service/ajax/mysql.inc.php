<?php
$link = mysql_connect('localhost', 'root', 'Rfhfylfi') or die ('Не могу соединиться: ' . mysql_error());
mysql_select_db('crmyrdb', $link) or die ('Не удалось выбрать базу: ' . mysql_error());
mysql_set_charset('utf8', $link);
?>
