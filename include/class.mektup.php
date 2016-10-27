<?php

class mektup {
    const MESAJ_GIDEN = 1;
    const MESAJ_GELEN = 2;
    const MESAJ_SILINEN = 3;

    const MESAJ_DURUM_OKUNMADI = 0;
    const MESAJ_DURUM_OKUNDU = 1;
    const MESAJ_DURUM_SILINDI = 2;

    const MESAJ_TIP_BASVURU = 1;
    const MESAJ_TIP_MESAJ = 2;
    const MESAJ_TIP_MULAKAT = 3;
    const MESAJ_TIP_DUYURU = 4;

    const MULAKAT_BEKLIYOR = 0;
    const MULAKAT_ONAY = 1;
    const MULAKAT_RED = 2;

    const MESAJ_READER_ISVEREN = 1;
    const MESAJ_READER_ADAY = 2;

    static $secenek_mesaj_tip = array(self::MESAJ_TIP_BASVURU => 'Başvuru', self::MESAJ_TIP_MESAJ => 'Mesaj', self::MESAJ_TIP_MULAKAT => 'Mülakat', self::MESAJ_TIP_DUYURU => 'Duyuru');
    static $secenek_mulakat_durum = array(self::MULAKAT_BEKLIYOR => 'Onay Bekliyor', self::MULAKAT_ONAY => 'Kabul Edildi', self::MULAKAT_RED => 'Reddedildi');

    public $link = 'isveren';
    public $reader = 1;
    public $id = 0;

    function set_reader($r) {
        $this->reader = $r;
    }

    function set_reader_id($id) {
        $this->id = $id;
    }

    function get_html($konum = self::MESAJ_GELEN) {
        $this->link = $this->reader == self::MESAJ_READER_ISVEREN ? 'isveren' : 'aday';

        switch ($konum) {
            case self::MESAJ_GELEN:
                $islemler .= '<a href="#" class="okundu">Okunmadı Olarak İşaretle</a>';

            case self::MESAJ_GIDEN:
                $islemler .= '<a href="#" class="cop">Çöpe Gönder</a>';
                break;

            case self::MESAJ_SILINEN:
                $islemler .= '<a href="#" class="geri">Çöpten Geri Al</a>';
                $islemler .= '<a href="#" class="sil">Kalıcı Olarak Sil</a>';
                break;
        }

        $out = '<table class="wa" id="mailbox">
                    <tr>
                        <td width="200px">
                        <div class="stdbg">
                            <h1 class="baslik2">Mesajlar</h1>
                            <ul>
                                <li><a href="?b=' . $this->link . '/mektup/' . self::MESAJ_GELEN . '">Gelen Kutusu</a></li>
                                <li><a href="?b=' . $this->link . '/mektup/' . self::MESAJ_GIDEN . '">Giden Kutusu</a></li>
                                <li><a href="?b=' . $this->link . '/mektup/' . self::MESAJ_SILINEN . '">Çöp Kutusu</a></li>
                            </ul>
                        </div>
                        </td>
                        <td style="padding-left:15px;">
                           
                                <div id="mk">
                                    ' . $this->get_mektup_reader($konum) . '
                                </div>
                                <div id="mesajIslem">
                                    
                          ' . $islemler . '
                                </div>
                                <div id="mesajdetayi">
                                
                                </div>
                        </td>
                    </tr>
                </table>';

        $out .= factory::get('js')->ready()->add("
                    $('#mk tbody tr').click(function(){
                        $(this).siblings().removeClass('okunuyor');
                        $(this).addClass('okunuyor');
                        $(this).removeClass('okunmadi');
                        yukleniyor('#mesajdetayi');
                        $.post('?b=ajax/mektup/oku',{id:$(this).attr('dbid')},function(a){ $('#mesajdetayi').html(a); });
                    });
                
                    $('#mesajIslem a.okundu').click(function(){
                        var a = $('#mk input:checked').map(function(){ return $(this).parents('tr[dbid]').addClass('okunmadi').attr('dbid'); }).get().join(',');
                        $.post('?b=ajax/mektup/okunmadi',{ids:a});
                    });

                    $('#mesajIslem a.cop').click(function(){
                        var a = $('#mk input:checked').map(function(){ return $(this).parents('tr[dbid]').hide().attr('dbid'); }).get().join(',');
                        $.post('?b=ajax/mektup/cop',{ids:a});
                    });

                    $('#mesajIslem a.geri').click(function(){
                        var a = $('#mk input:checked').map(function(){ return $(this).parents('tr[dbid]').hide().attr('dbid'); }).get().join(',');
                        $.post('?b=ajax/mektup/gerial',{ids:a});
                    });

                    $('#mesajIslem a.sil').click(function(){
                        if(confirm('Mektuplar kalıcı olarak siliniyor. Emin misiniz?'))
                        {
                            var a = $('#mk input:checked').map(function(){ return $(this).parents('tr[dbid]').hide().attr('dbid'); }).get().join(',');
                            $.post('?b=ajax/mektup/sil',{ids:a});
                        }
                    });

                
                    $('#mesajdetayi a[href=kabul]').live('click',function(){
                        if(confirm('Mülakat davetini kabul ediyorsunuz. Firmaya kabul edildiği bildirilecek. Emin misiniz?'))
                        {
                            $.get('?b=ajax/mulakat/kabul&id='+$(this).attr('rid'));
                            $('#mesajdetayi .islem').html('Mülakat Daveti Kabul Edildi.');
                        }
                        return false;
                    });

                    $('#mesajdetayi a[href=red]').live('click',function(){
                        if(confirm('Mülakat davetini reddediyorsunuz. Emin misiniz?'))
                        {
                            $.get('?b=ajax/mulakat/red&id='+$(this).attr('rid'));
                            $('#mesajdetayi .islem').html('Mülakat Daveti Reddedildi.');
                        }
                        return false;
                    });
                ")->getAll();

        return $out;
    }

    static function get_mektup($id) {
        global $db;

        $uid = $_SESSION['aday'] ? $_SESSION['aday']['id'] : $_SESSION['isveren']['id'];

        if ($mesaj = $db->sorgu("select * from mektup where id=%d and (gonderici=%d or alici=%d)", $id, $uid, $uid)->satirObj()) {

            if ($mesaj->alici == $uid) $db->set('mektup', $id, array('durum' => self::MESAJ_DURUM_OKUNDU));

            switch ($mesaj->tip) {
                case self::MESAJ_TIP_MULAKAT :
                    $mulakat = $db->sorgu("SELECT m.*,a.ad,a.soyad,i.pozisyon_adi FROM mulakat m,aday a,ilan i where m.id=%d and m.aday_id=a.id and m.ilan_id=i.id", $mesaj->mesaj)->satirObj();
                    $out = '<b>' . $mesaj->baslik . '</b><br><br>
                    <div class="davetiye">
                        <b>Aday :</b> ' . $mulakat->ad . ' ' . $mulakat->soyad . '<br>
                        <b>İlan :</b> ' . $mulakat->pozisyon_adi . '<br>
                        <b>Mülakat Tarihi :</b> ' . $mulakat->tarih . '<br>
                        <b>Mülakat Saati :</b> ' . $mulakat->saat . '<br>
                        <b>Mülakat Yeri :</b> ' . $mulakat->yer . '<br>
                        <b>Yetkililer :</b> ' . preg_replace('/\|/', ', ', $mulakat->yetkili) . '<br>
                        <b>Ek Bilgi :</b> ' . $mulakat->ekbilgi . '<br>
                    </div>';

                    if ($mesaj->alici == $uid) {
                        $out .= '<br><div class="islem">' . ($mulakat->kabul ? self::$secenek_mulakat_durum[$mulakat->kabul] : '<a href="kabul" rid="' . $mulakat->id . '">Kabul Et</a> | <a href="red" rid="' . $mulakat->id . '">Reddet</a>') . '</div>';
                    } else {
                        $out .= '<br><div class="islem">' . self::$secenek_mulakat_durum[$mulakat->kabul] . '</div>';
                    }

                    return $out;

                    break;

                default :
                    return '<b>' . $mesaj->baslik . '</b><br><br> ' . $mesaj->mesaj;

            }

        }
    }

    static function okunmadi($id) {
        global $db;

        $uid = $_SESSION['aday'] ? $_SESSION['aday']['id'] : $_SESSION['isveren']['id'];
        $db->sorgu("update mektup set durum=0 where find_in_set(id,'$id') and alici=$uid");
    }

    static function gonder($alici, $gonderici, $mesaj, $baslik, $tip = 1, $basvuru_id = 0) {
        global $db;

        $id = $db->add('mektup', array(
            'alici' => $alici,
            'gonderici' => $gonderici,
            'mesaj' => $mesaj,
            'baslik' => $baslik,
            'tip' => $tip,
            'durum' => 0,
            'tarih_gonderme' => dbDateTime(),
            'basvuru_id' => $basvuru_id,
            'silindi' => 0
        ));

        return $id;
    }

    static function copegonder($id) {
        global $db;

        if ($uid = $_SESSION['aday']['id']) $silindi = 1;//0001;
        elseif ($uid = $_SESSION['isveren']['id']) $silindi = 4; //0100
        else return;

        $db->sorgu("update mektup set silindi=silindi|$silindi where find_in_set(id,'$id') and (alici=$uid or gonderici=$uid)");
    }

    static function gerial($id) {
        global $db;

        if ($uid = $_SESSION['aday']['id']) $silindi = 14; //'1110';
        elseif ($uid = $_SESSION['isveren']['id']) $silindi = 11; //'1011';
        else return;

        $db->sorgu("update mektup set silindi=silindi&%d where find_in_set(id,'%s') and (alici=%d or gonderici=%d)", $silindi, $id, $uid, $uid);
    }

    static function sil($id) {
        global $db;

        if ($uid = $_SESSION['aday']['id']) $silindi = 3;
        elseif ($uid = $_SESSION['isveren']['id']) $silindi = 12;
        else return;

        $db->sorgu("update mektup set silindi=silindi|%d where find_in_set(id,'%s') and (alici=%d or gonderici=%d)", $silindi, $id, $uid, $uid);
    }

    function get_mektup_reader($mesaj_konumu) {
        global $db;

        if ($this->reader == self::MESAJ_READER_ISVEREN) {
            $cols = "concat(i.ad,' ',i.soyad) as kisi";
            $tables = "aday i";
            $silindi = $mesaj_konumu < self::MESAJ_SILINEN ? ' and (m.silindi>>2)&3=0' : ' and (m.silindi>>2)&3=1';
        } elseif ($this->reader == self::MESAJ_READER_ADAY) {
            $cols = "i.firma_ad as kisi";
            $tables = "isveren i";
            $silindi = $mesaj_konumu < self::MESAJ_SILINEN ? ' and m.silindi&3=0' : ' and m.silindi&3=1';
        }

        if ($mesaj_konumu == self::MESAJ_GELEN) $query = 'SELECT m.*,' . $cols . ' FROM mektup m, ' . $tables . ' where alici=' . $this->id . ' and i.id=m.gonderici ' . $silindi . ' order by tarih_gonderme desc';
        elseif ($mesaj_konumu == self::MESAJ_GIDEN) $query = 'SELECT m.*,' . $cols . ' FROM mektup m, ' . $tables . ' where gonderici=' . $this->id . ' and i.id=m.alici  ' . $silindi . ' order by tarih_gonderme desc';
        elseif ($mesaj_konumu == self::MESAJ_SILINEN) $query = 'SELECT m.*,' . $cols . ' FROM mektup m, ' . $tables . ' where alici=' . $this->id . ' and i.id=m.gonderici  ' . $silindi . ' union SELECT m.*,' . $cols . ' FROM mektup m, ' . $tables . ' where gonderici=' . $this->id . '  and i.id=m.alici  ' . $silindi . ' order by tarih_gonderme desc';

        if ($query) {
            if ($liste = $db->sorgu($query)->listeObj()) {
                foreach ($liste as $m) {
                    $tr .= '<tr dbid="' . $m->id . '"' . ($m->durum == self::MESAJ_DURUM_OKUNMADI && $m->gonderici != $this->id ? ' class="okunmadi"' : '') . '>
                                <td><input type="checkbox"></td>
                                <td>' . $m->kisi . '</td>
                                <td>' . $m->baslik . '</td>
                                <td>' . self::$secenek_mesaj_tip[$m->tip] . '</td>
                                <td>' . towebdate($m->tarih_gonderme) . '</td>
                            </tr>';
                }
            }
        }

        if (!$tr) $tr = '<tr class="hata"><td colspan=5>Mesaj kutunuz boştur.</td></tr>';

        return '<table class="wa">
                    <thead>
                        <tr><td width="20px"><input type="checkbox"></td><td>' . ($mesaj_konumu == self::MESAJ_GELEN ? 'Kimden' : ($mesaj_konumu == self::MESAJ_GIDEN ? 'Kime' : 'Kime/Kimden')) . '</td><td>Başlık</td><td>Mesaj Tipi</td><td>Mesaj Tarihi</td></tr>
                    </thead>
                    
                    <tbody>
                        ' . $tr . '
                    </tbody>
                </table>';

    }
}