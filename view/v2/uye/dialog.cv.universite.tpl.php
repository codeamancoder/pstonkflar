<form name="jxfrm">
    <table class="td2 wsoru dialogform">
        <tr><td width="150px"><b>Eğitim Seviyesi*</b></td><td><?=$site->get_secenek_select_zorunlu(site::T_EGITIM_SEVIYESI,$univ->egitim_seviyesi,'Seçiniz..',0,'id','','and id>10013')?></td></tr>
        <tr><td><b>Başlangıç Tarihi</b></td><td><?=html::select_ay('bas_ay_univ',$univ->baslangic_ay,'Ay','insel2')?> <?=html::select_range(date('Y'), 1940, 'bas_yil_univ',$univ->baslangic_yil,'Yıl','insel2')?> </td></tr>
        <tr><td><b>Mezuniyet Tarihi</b></td><td><?=html::select_ay('son_ay_univ',$univ->bitis_ay,'Ay','insel2')?> <?=html::select_range(2023, 1940, 'son_yil_univ',$univ->bitis_yil,'Yıl','insel2')?> Hala öğrenci iseniz mezun olacağınız tarihi giriniz.</td></tr>
        <tr><td><b>Diploma Notu</b></td><td><input type="text" name="diploma_notu" class="intext" value="<?=$univ->diploma_notu?>"></td></tr>
        <tr><td><b>Not Sistemi</b></td><td><?=html::selecta(site::$secenek_not_sistemi, 'not_sistemi', $univ->not_sistemi,'Seçiniz..','insel')?></td></tr>
        <tr><td><b>Ülke</b></td><td><?=$site->get_secenek_select(site::T_ULKE,$univ->ulke ? $univ->ulke : site::P_ULKE_TURKIYE,'',0,'oncelik desc,ad')?></td></tr>
        <tr id="sehir" class="<?=$univ->ulke && $univ->ulke != site::P_ULKE_TURKIYE? 'gizli':''?>"><td><b>Şehir</b></td><td><?=$site->get_secenek_select(site::T_SEHIR,$univ->sehir,'Seçiniz..',0,'oncelik desc,ad')?></td></tr>
        <tr><td><b>Üniversite*</b></td><td><?=$site->get_secenek_select_zorunlu(site::T_UNIVERSITE,$univ->universite_adi,'Seçiniz..')?></td></tr>
        <tr><td><b>Fakülte*</b></td><td><?=$site->get_secenek_select_zorunlu(site::T_FAKULTE,$univ->fakulte_adi,'Seçiniz..')?></td></tr>
        <tr><td><b>Bölüm*</b></td><td><select name="bolum_id" class="coklusecim filtre" ajax="aday/universite_bolum" multiple="true" max="1" valid="secim"><?=$bolum_pre_selects?></select></td></tr>
        <tr><td><input type="hidden" name="id" value="<?=$cv->cv_id?>"><input type="hidden" name="univ_id" value="<?=$univ->uni_id?>"></td> <td>
                <br><input type="submit" name="btnSubmit" value="Kaydet" class="btn2">
                <?=$univ->uni_id ? '<input type="submit" name="btnSil" value="Sil" class="btn2">' :''?>
            </td></tr>
    </table>
</form>


<script type="text/javascript">
$(document).ready(function(){
	var act = '';
    $('input[name=btnSil]').click(function(){
        act = '/sil';
        $('input[name=btnSubmit]').click();
        act = '';
        return false;
    });
    
    $('input[name=btnSubmit]').click(function(){
    	if(!fk()) return false;
        $.post('?a=aday/cv_duzenle/universite'+act,$('form[name=jxfrm]').serialize(),function(a){
        	var a = jQuery.parseJSON(a);
            if(a.res==1 || a.res=='1'){
                $('#egitim_bilgileri').html(a.msg);
                dialog.dialog('close');
            }
            else{
                alert(a.msg);
            }
        });

        return false;
    });

    $('.teksecim').multiselect({multiple:false,header:'',selectedList: 1, firstChild:'none'});
	$('.coklusecim').multiselect({header:'', selectedList: 1 });
	$('.coklusecim.filtre,.teksecim.filtre').multiselectfilter();
    $('input[name=diploma_notu]').numeric({allow:'.'});
});
</script>