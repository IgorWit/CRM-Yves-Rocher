<?php
include_once "../service/template/header.php"
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

    strong {
        font-family: "Courier New", serif;
        font-size: 22px;
        color: #e8e8e8;
    }
</style>
</head>
<body>
<div align="center">
    <form action="/index">
        <img src="/service/images/logo.png" WIDTH="300" height="110"></br></br>
        <strong><p/>

            <p/>
            Ошибка 404! Запрашиваемая страница не найдена.</br>
        </strong>
        <input type="submit" class="form-control" value="На главную">
    </form>
</div>


</body>
</html>

