<form name="frmMulakat" class="dialogform">
    <table>
        <tr><th width="150px">Aday :</th><td><?=$basvuru->ad?> <?=$basvuru->soyad?></td></tr>
        <tr><th>İlan :</th><td><?=$basvuru->pozisyon_adi?> (<?=$basvuru->ilan_id?>) <input type="hidden" name="mulakat_id" value="<?=$mulakat->id?>"><input type="hidden" name="ilan_id" value="<?=$basvuru->ilan_id?>"><input type="hidden" name="basvuru_id" value="<?=$basvuru->id?>"></td></tr>
        <tr><th>Görüşme Tarihi :</th><td><?=$mulakat->tarih?> - <?=$mulakat->saat?></td></tr>
        <tr><th>Yetkililer :</th><td><?=$mulakat->yetkili?></td></tr>
        <tr><th>Mülakat Yeri :</th><td><?=$mulakat->yer?></td></tr>
        <tr><th>Mülakat Tipi :</th><td><?=site::$mulakat_tipleri[$mulakat->tip]?></td></tr>
        <tr><th>Ek Bilgiler:</th><td><?=$mulakat->ekbilgi?></td></tr>
    </table>
</form>