<form name="frmAdayLogin" method="POST" action="?b=aday/fotograf_kirp">
    <table class="standart">
    <tr><td width="232px">
        Aktif fotoğrafınız
        <div class="aday-foto">
            <img src="<?=(!empty($_SESSION['aday']['foto']) ? '/user/photo/'.$_SESSION['aday']['foto']:'/static/images/no-img-'.$_SESSION['aday']['cinsiyet'].'.jpg')?>">
        </div>
    </td><td>Yeni fotoğraf yüklemek için fotoğraf yükle linkline tıklayarak fotoğrafınızı seçiniz. Fotoğrafınızın boyutu en fazla <b>2 MB (Megabayt)</b> olabilir. Fotoğraf yüklendikten sonra açılacak olan editör aracılığı ile fotoğrafınızı kırpabilirsiniz.<br><br>
        <a href="#" id="btnFotoYukle">Fotoğraf Yükle</a>
    </table>
    <div class="crop gizli">
        <div id="#cropimg"></div>
        <input type="submit" name="btnKirp" value="Kırp ve Kaydet!">
        <input type="hidden" id="cord" name="cord">
        <input type="hidden" id="image" name="image">
    </div>
</form>
<script type="text/javascript" src="/static/jquery.uploadify-3.1.min.js"></script>
<script type="text/javascript" src="/static/jquery.Jcrop.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#btnFotoYukle").uploadify({
                "swf"  : "/static/uploadify.swf",
                "uploader"    : "/index.php?a=aday/fotograf",
                "buttonText" : "Fotoğraf Yükle",
                "buttonClass" : "underline",
                'fileSizeLimit' : '2MB',
                'fileTypeExts' : '*.jpg;',
                "auto" : true,
                "onUploadSuccess" : function(file, data, response) {
                    var res = $.parseJSON(data);
                    console.log(data);
                    if(res.state==1){
	                    $("form[name=frmAdayLogin] table").hide();
	                    $("div.crop div").html("<img src=\"/user/photo/"+res.msg+"\">");
	                    $("div.crop").show();
	                    $("div.crop #image").val(res.msg);
	                    
	                    //$("#dialog").dialog("option","height",700);
	                    $(".crop img").Jcrop({
	                        aspectRatio: 1,
	                        bgOpacity:   .4,
	                        setSelect:   [ 100, 100, 300, 300 ],
	                        onSelect : function(a){
	                            $("#cord").val(a.x+","+a.y+","+a.w+","+a.h);
	                        }
	                    });
                    }
                    else{
						alert(res.msg);
                    }
                } 
    	});
    });
</script>