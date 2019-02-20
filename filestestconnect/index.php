<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Some type text</h1>

<?php
echo "php here";
?>
<?php

$servername = "localhost";
$username = "root";
$password = "Daisy123";
$dbname = "data_names";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


/* $sql = "SELECT id, firstname, secondname FROM males"; */
$sql = "SELECT * FROM males";


$result = $conn->query($sql);

echo "<br>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Names: " . $row["firstname"]. " " . $row["secondname"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();



?>







</body>
</html>

