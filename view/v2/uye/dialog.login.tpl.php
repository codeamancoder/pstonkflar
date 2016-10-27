<form name="frmAdayLogin" method="POST" action="?b=aday/login" class="dialogform">
    <table class="standart">
    <tr><td colspan=2 id="hata"></td></tr>
    <tr><td width="100px"><b>Eposta Adresi </b></td><td><input type="text" name="eposta" class="intext"></td></tr>
    <tr><td><b>Şifre</b></td><td><input type="password" name="sifre" class="intext"></td></tr>
    <tr><td></td><td><input type="submit" name="btnAdayLogin" value="Oturum Aç" class="btn2 right"></td></tr>
    <tr><td></td><td><a  href="?b=aday/yeni" style="float:right;display:inline-block;padding:5px;color:#888;" >Hemen Üye Ol</a></td></tr>
    </table>
</form>
<script type="text/javascript">
   $(document).ready(function(){
        $("input[name=btnAdayLogin]").live("click",function(){ 
            $.post("?a=aday/login",{eposta:$("input[name=eposta]").val(),sifre:$("input[name=sifre]").val()}, function(a){
                if(a==1){
                    oturum = 1;
                    if(dobject){
                        var a = dobject;
                        dobject = null;
                        a.trigger('click');
                    }
                    else if(daction){
                        var a = daction;
                        daction= null;
                        location.href=a;
                    }
                    dialog.dialog('close');
                }
                else {
                    $("#hata").html("Eposta adresiniz ve/veya şifreniz yanlış").css("color","red");
                }
            });
            return false;
        });
    });    
</script>