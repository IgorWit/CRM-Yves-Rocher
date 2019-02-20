<?php
$page_title = "TM Experts";
include_once '../service/template/header.php';
?>
    <script>
        setInterval(function () {
        if(document.getElementById("Vici-login").readOnly==true){
        Lock();
            $.ajax({
                type: "POST",
                url: "../service/ajax/ajax-tm",
                data: {act: "Check"}, success: function (responce) {
                    $('#fetched').html(responce);
                }
            })
}else{$('#fetched').innerHTML='<tr><td>Must be logged in</td></tr>';}
        }, 1000)
    </script>
    
    <script>
        function Call(number) {
       var agent= $('input[name="Vici-login"]').val();
            $.ajax({
                type: "POST",
                url: "../service/ajax/ajax-tm",
                data: {
                    act: "Getta",
                    number: number,
                    agent:agent
                }, success: function (responce) {
                    console.log(responce)
                }, error: function (responce) {
                    console.log(responce)
                }
            })
        }
    </script>

<!--suppress JSUnresolvedVariable -->
<script>
function Lock(){
var usr=$('input[name="Vici-login"]').val();
                $.ajax({
                type: "POST",
                url: "../service/ajax/ajax-tm",
                dataType:'json',
                data: {
                    act: "CheckAgent",
                    user:usr
                    },success:function(responce){
                    document.getElementById("user").innerHTML=responce.user;
                    document.getElementById("camp").innerHTML=responce.campaign_id;
                    document.getElementById("state").innerHTML=responce.status;
                    document.getElementById("Vici-login").readOnly=responce.user!=null;
                    }
});

}
</script>

    <div class="row">
     <div class="col-md-3">
    <div class="input-group">
      <input type="text" name="Vici-login" id="Vici-login" class="form-control" placeholder="Your agent login here">
      <span class="input-group-btn">
        <button class="btn btn-primary" type="button" onclick="Lock()">Log in</button>
      </span>
    </div>
  </div>
</div>
    </br></br>
<table class="table-responsive table">
        <tbody id="agnStat">
<tr>
<td align="center" ><div id="user"></div></td>
<td align="center" ><div id="camp"></div></td>
<td align="center" ><div id="state"></div></td>
</tr>
        </tbody>
    </table>
    </br></br>
    <table class="table-responsive table table-striped">
        <thead>
        <td align="center"><strong>Время звонка</strong></td>
        <td align="center"><strong>Номер телефона</strong></td>
        <td align="center"><strong>Действие</strong></td>
        </thead>
        <tbody id="fetched">

        </tbody>
    </table>

<?php
include_once "../service/template/footer.php";
?>