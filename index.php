<?php
include_once "service/template/header.php"
?>
<style>
    body {
        background-color: #474647;
        marign: 0;
        padding: 0;
    }

    form {
        position: absolute;
        top: 35%;
        left: 50%;
        margin-left: -150px;
        margin-top: -90px;
        width: 300px;
        height: 180px;
    }

    input[type=submit] {
        background-color: rgb(254, 70, 10);
        border-color: #e63c0c;
        color: #ffffff;
    }

    div[class=page-header] {
        display: none;
    }

</style>
<body>
<form action="admin/users/auth" method="post">

    <img src="service/images/logo.png" WIDTH="300" height="110"></br></br>
    <div class="form-group" align="center">
        <input type="text" class="form-control" placeholder="Enter login" width="200"></br>
        <input type="password" class="form-control" placeholder="Enter password"></br>
        <input type="submit" class="form-control" value="Log in">
    </div>
</form>
</body>
