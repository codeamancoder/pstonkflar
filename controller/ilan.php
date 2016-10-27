<?php

class ilan extends controller {
    static $dparams;
    static $vitrinler = array(20000, 20001, 20002, 2495, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16);
    static $siralama_tipleri = array(
        1 => 'i.fiyat desc',
        2 => 'i.fiyat',
        3 => 'i.tarih desc',
        4 => 'i.tarih',
        5 => 'i.km desc',
        6 => 'i.km',
        7 => 'i.tarih desc',
        8 => 'i.tarih',
    );

    function ilan() {
        parent::__construct();

        if (!self::$dparams) {
            self::$dparams = $this->db->sorgu("select id,val from params where not cat='kategori'")->sozluk('id', 'val');
        }
    }

    public function cron($request) {
        if ($request[0] == 'yayin') {
            if ($liste = $this->db->sorgu("select i.*,u.ad,u.eposta from ilan i,uye u where i.tarih<now()-interval 60 day and i.yayin_durum=1 and u.id=i.uye_id")->listeObj()) {
                foreach ($liste as $i) {
                    factory::get('mailer')->fast_send($i->eposta, $i->ad, 'İlanınızın Yayın Süresi Sona Erdi', 'Sayın, ' . $i->ad . '<br><br><b>' . $i->baslik . '</b> ilanınızın yayın süresi sona ermiştir. <br><br> Saygılarımızla <a href="http://www.pistonkafalar.com">PistonKafalar.com</a>');
                }

                $this->db->sorgu("update ilan set yayin_durum=0 where tarih<now()-interval 60 day and yayin_durum=1");
            }

            if ($liste = $this->db->sorgu("select i.*,u.ad,u.eposta from ilan i,uye u where (to_days(now())-to_days(i.tarih)=53 or to_days(now())-to_days(i.tarih)=57)  and i.yayin_durum=1 and u.id=i.uye_id")->listeObj()) {
                foreach ($liste as $i) {
                    factory::get('mailer')->fast_send($i->eposta, $i->ad, 'İlanınızın Yayından Kalkmak Üzere', 'Sayın, ' . $i->ad . '<br><br><b>' . $i->baslik . '</b> ilanınızın yayın süresi sona ermek üzeredir. Bitiş tarihine istinaden siteniz yayından kaldırılacaktır. <br><br> Saygılarımızla <a href="http://www.pistonkafalar.com">PistonKafalar.com</a>');
                }
            }

            if ($liste = $this->db->sorgu("select * from uye where day(dogum)=day(now()) and month(dogum)=month(now())")->listeObj()) {
                foreach ($liste as $i) {
                    factory::get('mailer')->fast_send($i->eposta, $i->ad, 'Doğum Gününüz Kutlu Olsun!', 'Sayın, ' . $i->ad . '<br><br>PistonKafalar.com ekibi doğum gününüzü kutlar. Nice mutlu yıllar dileriz.<br><br> Saygılarımızla <a href="http://www.pistonkafalar.com">PistonKafalar.com</a>');
                }
            }
        }

        exit();
    }

    private function get_menu($cat) {
        global $site;

        $out = '';
        if ($alt = fi($_GET['alt'])) {
            $alt = $site->get_param($alt);
        }

        if ($cat) {
            $up = $site->get_param($cat);
            $ust[] = $up;
            $id = $up->ust_id;

            while ($up = $site->get_param($id)) {
                if ($alt && $up->id == 2) $up = $alt;

                $ust[] = $up;
                $id = $up->ust_id;

            }

            if ($ust) {
                $ust = array_reverse($ust);
                foreach ($ust as $i => $o) {
                    $li .= '<li class="ic_' . ($i) . ' ' . ($o->id == $cat ? 'active' : '') . '"><a href="/index.php?b=ilan&cat=' . $o->id . ($alt && $i ? '&alt=' . $alt->id : '') . '">' . $o->val . '</a></li>';
                }
                $i++;
            }
            $ac = 1;
        }

        if (!$cat) {
            $links = $this->db->sorgu("select p1.val as uval,p1.id as uid, p2.* from params p1 left outer join params p2 on(p1.cat=p2.cat and p1.id=p2.ust_id) where p1.cat='kategori' and  p1.ust_id=0 order by p1.sira,p1.val")->listeObj();

            $li .= '<li class="yanimg cat_1"><a href="/index.php?b=ilan&acil">Acil Acil</a></li>';
            $li .= '<li class="yanimg cat_2"><a href="/index.php?b=ilan&fiyatidusenler">Fiyatı Düşenler</a></li>';
            $li .= '<li class="divider"></li>';

            $cc = '';
            foreach ($links as $a) {
                if ($cc != $a->uval) {
                    $li .= '<li class="yanimg cat_' . $a->uid . '"><a href="/index.php?b=ilan&cat=' . $a->uid . '">' . $a->uval . '</a></li>';
                    $cc = $a->uval;
                }

                $li .= '<li class="ic_1"><a href="/index.php?b=ilan&cat=' . $a->id . ($a->alt_id ? '&alt=' . $a->id : '') . '">' . $a->val . '</a></li>';
            }
        } elseif ($links = $this->db->sorgu("select * from params where cat='kategori' and (ust_id=%d %s) order by sira,val", $cat, $alt && $i < 3 ? ' or ust_id=2' : '')->listeObj()) {
            foreach ($links as $o) {
                $ili .= '<li class="ic_' . ($i) . '"><a href="/index.php?b=ilan&cat=' . $o->id . ($alt ? '&alt=' . $alt->id : ($o->alt_id ? '&alt=' . $o->id : '')) . '">' . $o->val . '</a></li>';
            }

            $li .= '<li><ul class="ic_ul">' . $ili . '</ul></li>';
        }

        $out = $li . ($ac ? '<li class="divider"></li><li><a href="/index.php?b=ilan">Tüm Vasıtalar</a></li>' : '');

        return $out . '<input type="hidden" name="cat" value="' . $cat . '">' . ($alt ? '<input type="hidden" name="alt" value="' . $alt->id . '">' : '');
    }

    /*
     * aday ana sayfası
     * 
     * @return string
     */
    function index() {
        $data['uye'] = $_SESSION['uye'];

        $cat = isset($_GET['cat']) ? fi($_GET['cat']) : 0;
        $cat2 = isset($_GET['alt']) ? fi($_GET['alt']) : 0;

        $vitrin = isset($_GET['vitrin']) ? fi($_GET['vitrin']) : '';
        $aravitrin = isset($_GET['aravitrin']) ? fi($_GET['aravitrin']) : '';

        $doping .= isset($_GET['acil']) ? ' and i.doping_acil=1' : '';
        $doping .= isset($_GET['fiyatidusenler']) ? ' and i.doping_fiyat=1' : '';

        if ($magaza_id = $_GET['magaza_id']) {
            $magaza = $this->db->sorgu("select group_concat(uye.id) as uyeler,magaza.* from magaza, uye  where magaza.id=%s and magaza.id=uye.magaza_id group by magaza.id", $magaza_id)->satirObj();
            $magazaw = ' and i.uye_id in(' . $magaza->uyeler . ')';
        }

        if ($uye_id = $_GET['uye_id']) {
            $magazaw = ' and i.uye_id in(' . $uye_id . ')';
        }

        if ($cat) {
            $cats = $this->site->get_sub_cat_ids($cat);
            $cats[] = $cat;
            $catp = $this->site->get_param($cat);
            $kategori = 'AND i.kategori in(' . implode(',', $cats) . ')';
        }

        if ($cat2) $kategori .= ' AND i.kategori2=' . $cat2;

        $anahtar = $_GET['anahtar'] ? "AND (MATCH (i.baslik,i.icerik,i.anahtar) AGAINST ('*" . fi($_REQUEST['anahtar']) . "*' IN BOOLEAN MODE)" . (is_numeric($_GET['anahtar']) ? ' or i.ilan_id=' . $_GET['anahtar'] : '') . ')' : '';

        if (!$doping && !$vitrin && !$aravitrin && !$magaza_id && !$uye_id && !$anahtar && (!$cat || in_array($cat, self::$vitrinler))) {
            $data['baslik'] = $catp ? $catp->val . ' Vitrini' : 'Vitrin';
            $data['menu'] = $this->get_menu($cat);
            $data['reklam'] = $this->db->sorgu("select * from blog where tip='reklam' and kategori='%d' and onay=%d order by id desc limit 1", site::REKLAM_IKINCI_EL_BANNER, $cat ? $cat : 0)->satirObj();
            $swhere = !$cat ? ' i.doping_manset=1' : 'i.doping_manset2=1';

            $data['ilanlar'] = $this->db->sorgu("SELECT i.*, if(d.id,concat(d.id,'.',d.uzanti),'noimage.jpg') as foto FROM ilan i left outer join dosya d on(d.ref_id=i.ilan_id and d.ref_name='ilan' and d.sira=1) WHERE %s %s and i.yayin_durum=1 GROUP BY i.ilan_id order by rand() desc  limit 36", $swhere, $kategori ? $kategori : '')->listeObj();

            return $this->view('index', $data);
        }

        $data['menu'] = $this->get_menu($cat);
        $data['sehir'] = $this->site->il_select($il = $_GET['il'], '- Tüm Şehirler -');
        $data['ilce'] = $il ? $this->site->ilce_select($il, $ilce = $_GET['ilce'], '- Tüm İlçeler -') : '<select name="ilce"><option value="0">- Tüm İlçeler -</option></select>';

        $il = $il ? "AND i.il='$il'" : '';
        $ilce = $ilce ? "AND i.ilce='$ilce'" : '';
        $yakit = $_GET['p_' . site::P_YAKIT] ? ' and i.yakit=' . $_GET['p_' . site::P_YAKIT] : '';
        $vites = $_GET['p_' . site::P_VITES] ? ' and i.vites=' . $_GET['p_' . site::P_VITES] : '';
        $renk = $_GET['p_' . site::P_RENK] ? ' and i.renk=' . $_GET['p_' . site::P_RENK] : '';
        $kasa = $_GET['p_' . site::P_KASA] ? ' and i.kasa=' . $_GET['p_' . site::P_KASA] : '';
        $motor_hacmi = $_GET['p_' . site::P_MOTOR_HACMI] ? ' and i.motor_hacmi=' . $_GET['p_' . site::P_MOTOR_HACMI] : '';
        $motor_gucu = $_GET['p_' . site::P_MOTOR_GUCU] ? ' and i.motor_gucu=' . $_GET['p_' . site::P_MOTOR_GUCU] : '';
        $cekis = $_GET['p_' . site::P_CEKIS] ? ' and i.cekis=' . $_GET['p_' . site::P_CEKIS] : '';
        $garanti = $_GET['garanti'] ? ' and i.garanti=' . $_GET['garanti'] : '';
        $plaka = $_GET['p_plaka'] ? ' and i.plaka=' . $_GET['p_plaka'] : '';
        $kimden = $_GET['kimden'] ? ' and i.kimden=' . $_GET['kimden'] : '';
        $durumu = $_GET['durumu'] ? ' and i.durumu=' . $_GET['durumu'] : '';
        $vitrin = $vitrin ? ' and i.doping_manset' . ($cat ? '2' : '') . '=1' : '';
        $aravitrin = $aravitrin ? ' and i.doping_ara=1' : '';

        $fiyat1 = fi($_REQUEST['fiyat_alt']);
        $fiyat2 = fi($_REQUEST['fiyat_ust']);
        $fiyat = $fiyat1 && $fiyat2 ? ' and i.fiyat between ' . $fiyat1 . ' and ' . $fiyat2 : ($fiyat1 ? ' and i.fiyat>' . $fiyat1 : ($fiyat2 ? ' and i.fiyat<' . $fiyat2 : ''));

        $yil1 = fi($_REQUEST['yil1']);
        $yil2 = fi($_REQUEST['yil2']);
        $yil = $yil1 && $yil2 ? ' and i.yil between ' . $yil1 . ' and ' . $yil2 : ($yil1 ? ' and i.yil>' . $yil1 : ($yil2 ? ' and i.yil<' . $yil2 : ''));

        $km1 = fi($_REQUEST['km1']);
        $km2 = fi($_REQUEST['km2']);
        $km = $km1 && $km2 ? ' and i.km between ' . $km1 . ' and ' . $km2 : ($km1 ? ' and i.km>' . $km1 : ($km2 ? ' and i.km<' . $km2 : ''));

        $sayi = $this->db->sorgu($b = "SELECT count(i.ilan_id) FROM ilan i WHERE i.yayin_durum=1 $anahtar $doping $kategori $il $ilce $fiyat $yil $yakit $vites $km $renk $kasa $motor_gucu $motor_hacmi $cekis $garanti $plaka $kimden $durumu $vitrin $magazaw $aravitrin")->sonuc(0) | 0;

        $order = $_GET['order'] && self::$siralama_tipleri[$_GET['order']] ? $_GET['order'] : '';
        $orderby = $order ? ' order by ' . self::$siralama_tipleri[$_GET['order']] : '';
        $lpp = $_GET['lpp'] && in_array($_GET['lpp'], array(20, 50)) ? $_GET['lpp'] : 20;
        $link = '?b=ilan' . ($cat ? '&cat=' . $cat : '') . ($_GET['anahtar'] ? '&anahtar=' . $_GET['anahtar'] : '') . ($_GET['il'] ? '&il=' . $_GET['il'] : '') . ($_GET['ilce'] ? '&ilce=' . $_GET['ilce'] : '') . ($fiyat1 ? '&fiyat_alt=' . $fiyat1 : '') . ($fiyat2 ? '&fiyat_ust=' . $fiyat2 : '') . ($yil1 ? '&yil1=' . $yil1 : '') . ($yil2 ? '&yil2=' . $yil2 : '') . ($yakit ? '&p_yakit=' . $_GET['p_yakit'] : '') . ($vites ? '&p_vites=' . $_GET['p_vites'] : '') . ($km1 ? '&km1=' . $km1 : '') . ($km2 ? '&km2=' . $km2 : '') . ($renk ? '&p_renk=' . $_GET['p_renk'] : '') . ($kasa ? '&p_kasa=' . $_GET['p_kasa'] : '') . ($motor_hacmi ? '&p_motor_hacmi=' . $_GET['p_motor_hacmi'] : '') . ($motor_gucu ? '&p_motor_gucu=' . $_GET['p_motor_gucu'] : '') . ($cekis ? '&p_cekis=' . $_GET['p_cekis'] : '') . ($garanti ? '&garanti=' . $_GET['garanti'] : '') . ($plaka ? '&p_plaka=' . $_GET['p_plaka'] : '') . ($kimden ? '&kimden=' . $_GET['kimden'] : '') . ($durumu ? '&durumu=' . $_GET['durumu'] : '') . (isset($_GET['acil']) ? '&acil' : '') . (isset($_GET['fiyatidusenler']) ? '&fiyatidusenler' : '') . ($_GET['vitrin'] ? '&vitrin=1' : '') . ($_GET['aravitrin'] ? '&aravitrin=1' : '') . ($_GET['list'] ? '&list=' . $_GET['list'] : '') . ($_GET['uye_id'] ? '&uye_id=' . $_GET['uye_id'] : '');

        $pager = new pager($sayi, $lpp, 50);
        $pager->setLink($link . ($order ? '&order=' . $order : '') . ($lpp ? '&lpp=' . $lpp : ''));
        $liste = $this->db->sorgu($a = "SELECT i.*, if(d.id,concat(d.id,'.',d.uzanti),'noimage.jpg') as foto FROM ilan i left outer join dosya d on(d.ref_id=i.ilan_id and d.ref_name='ilan' and d.sira=1) WHERE i.yayin_durum=1 $anahtar $kategori $il $ilce $fiyat $yil $yakit $vites $km $renk $kasa $motor_gucu $motor_hacmi $cekis $garanti $plaka $kimden $durumu $vitrin $doping $magazaw $aravitrin GROUP BY i.ilan_id $orderby " . $pager->get_sql_limit())->listeObj();
        $data['link'] = $link;
        $data['liste'] = $liste;
        $data['pager'] = $pager->get_pager();
        $data['sayi'] = $sayi;
        $data['lpp'] = $lpp;
        $data['order'] = $order;
        $data['magaza'] = $magaza;

        return $this->view('liste', $data);

    }

    private function kategori_agac($id) {
        do {
            $cat = $this->db->sorgu("select * from params where id=%d", $id)->satirObj();
            $tree[] = $cat;
            $id = $cat->ust_id;
        } while ($id);

        return array_reverse($tree);
    }

    function detay() {

        if (!($id = fi($_GET['id']))) return $this->create_message('Böyle bir ilan yoktur.', 'error');

        $dosyalar = factory::get('dosyalar');
        $e = $this->db->sorgu("select * from ilan where ilan_id=%d", $id)->satirObj();
        $this->db->inc('ilan', 'hit', $id, 'ilan_id', 1);
        $e->agac = $this->kategori_agac($e->kategori);
        $cat = $this->site->get_param($e->kategori2)->ust_id;

        $favori = $_SESSION['uye'] && $this->db->sorgu("select * from favori where ilan_id=%d and takipci_id=%d", $e->ilan_id, $_SESSION['uye']['id'])->sayi() ? '- Favorilerden Çıkar' : '+ Favorilerime Ekle';
        $takip = $_SESSION['uye'] && $this->db->sorgu("select * from favori where uye_id=%d and takipci_id=%d", $e->uye_id, $_SESSION['uye']['id'])->sayi() ? 'Üye Takibini Sonlandır' : 'Üyeyi Takip Et';

        foreach ($e->agac as $a) {
            $this->add_navi($a->val, '/index.php?b=ilan&cat=' . $a->id);
            $this->site->add_title($a->val);
        }

        $this->site->add_title($e->baslik);

        $imgs = $dosyalar->getFiles('ilan', $id);
        $uye = $this->site->get_uye($e->uye_id);

        if ($uye->magaza_id) {
            $magaza = '<br><div class="magaza">
        				<div class="logo2"><a href="/index.php?b=ilan&magaza_id=' . $uye->magaza_id . '"><img src="/user/magaza/' . $uye->magaza_id . '.jpg"></a></div>
        				<div class="info2"><strong>' . $uye->magaza_adi . '</strong><p>' . $uye->aciklama . '</p></div>
        			</div>';
        }

        $reklam = $this->db->sorgu("select * from blog where tip='reklam' and kategori='6' order by id desc limit 1")->satirObj();

        if (count($imgs) > 1) {
            foreach ($imgs as $img) $diger .= '<div class="ufak"><img src="/user/files/thumb_' . $img->id . '.' . $img->uzanti . '"></div>';
            $diger = '<div class="diger">' . $diger . '</div>';
            $diger .= "<script type=\"text/javascript\">
                $('document').ready(function(){
                    $('div.diger img').click(function(){
                        $('.foto .big img').attr('src',$(this).attr('src').replace(/thumb_/,''));
                    });
                    $('.foto .big img').click(function(){
                        var a = $(this).attr('src').replace(/files\//,'files/thumb_');
                        var b = $('img',$('div.diger img[src=\''+a+'\']').parent().next());
                        if(b.size()) b.click();
                        else $('div.diger img:eq(0)').click();
                        
                    });
                });
            </script>";
        }

        $diger_ilanlar_sayi = $this->db->sorgu("select count(*) from ilan where uye_id=%d", $e->uye_id)->sonuc(0);

        if ($diger_ilanlar_sayi > 1) {
            $diger_ilanlar_out = '<a href="/?b=ilan&uye_id=' . $e->uye_id . '">Diğer İlanları</a>';
        }

        $this->site->get_ozellik_ul('guvenlik', $e->guvenlik);
        $this->site->get_ozellik_ul('ic_donanim', $e->ic_donanim);
        $this->site->get_ozellik_ul('dis_donanim', $e->dis_donanim);
        $this->site->get_ozellik_ul('multimedia', $e->multimedia);
        $this->site->get_ozellik_ul('boyali_parca', $e->boya);
        $this->site->get_ozellik_ul('degisen_parca', $e->degisen);

        $this->site->get_ozellik_ul('motor_guvenlik', $e->motor_guvenlik);
        $this->site->get_ozellik_ul('motor_aksesuar', $e->motor_aksesuar);

        $this->site->add_relimg('/user/files/' . $imgs[0]->id . '.' . $imgs[0]->uzanti, $e->baslik, strip_tags($e->icerik));

        if ($e->uye_id == $_SESSION['uye']['id']) {
            $admin = '<div class="ilan-yonet">
        				<ul>
        					<li><a href="/index.php?b=uye/ilan/duzenle&id=' . $e->ilan_id . '"><i class="icon-edit"></i> İlanı Düzenle</a></li>
        					<li><a href="/index.php?b=uye/ilan/doping&id=' . $e->ilan_id . '"><i class="icon-flag"></i> Doping Yap</a></li>
        					<li><a href="/index.php?b=uye/ilan/yayindankaldir&id=' . $e->ilan_id . '"><i class="icon-certificate"></i> Yayından Kaldır</a></li>
        					<li><a href="/index.php?b=uye/ilan/yayindankaldir&id=' . $e->ilan_id . '"><i class="icon-remove"></i> İlanı Sil</a></li>
        				</ul>
        			</div>';
        }

        if ($e->konum) {
            $harita = '
                 <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCSuQbUYdn4RjMYo-3kKPgl8kIKNYW7ak4&sensor=true"></script>
                 <div id="map_canvas" style="width:725px; height:450px; position:absolute; top:-33px; left:0px;"></div><br>
                 <script type="text/javascript">
                    var geocoder;
                    var map;
                    var drag;
                    var marker;
                    
                    function initialize() {
                        geocoder = new google.maps.Geocoder();
                        var latlng = new google.maps.LatLng(' . $e->konum . ');
                        var mapOptions = { zoom: 13, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP }
                        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
                        
                        marker = new google.maps.Marker({
                                map: map,
                                position: latlng
                				
                            });
                    }

    
                    $(document).ready(function(){
                        initialize();
                    });
                
                   
                </script>
                
            ';
        }

        $out .= '
            <div class="ilan">
        		<div class="span12">' . $this->get_navi() . '</div>' . ($magaza ? $magaza : '<br><br>') . '
                <div class="detay left span9">
                    <div class="menu5">
                        <ul>
                            <li class="aktif"><a href="#">İlan Detayları</a></li>
                            ' . ($e->konum ? '<li><a href="#">Harita</a></li>' : '') . '
                        </ul>
                        <b>İlan no #' . $e->ilan_id . '</b>
                    </div>
                    <div class="ayrim">
                        <div class="tab">
                            <h1 class="baslik">' . $e->baslik . '</h1>
                            <div class="foto left">
                                <div class="big"><img src="/user/files/' . ($imgs[0]->id ? $imgs[0]->id . '.' . $imgs[0]->uzanti : 'noimage.jpg') . '"></div>
                                ' . $diger . '
                            </div>
                            <div class="metin">
                                <table>
                                    <tr><td colspan=2><span class="fiyat">' . number_format($e->fiyat, 0, '.', '.') . ' ' . $e->para_birimi . '</span><br><br>' . $e->il . ' / ' . $e->ilce . ' ' . ($e->semt ? ' / ' . $e->semt : '') . '</td></tr>
                                    <tr><th>İlan Tarihi</th><td>' . towebdate($e->tarih) . '</td></tr>
                                    ' . ($e->agac[2]->val ? '<tr><th>' . ($cat == 20000 ? 'Marka' : 'Kategori') . '</th><td>' . $e->agac[2]->val . '</td></tr>' : '') . '
                                    ' . ($e->agac[3]->val ? '<tr><th>' . ($cat == 20000 ? 'Seri' : 'Kategori') . '</th><td>' . $e->agac[3]->val . '</td></tr>' : '') . '
                                    ' . ($e->agac[4]->val ? '<tr><th>' . ($cat == 20000 ? 'Model' : 'Kategori') . '</th><td>' . $e->agac[4]->val . ($e->agac[5] ? ' - ' . $e->agac[5]->val : '') . '</td></tr>' : '') . '
                                    ' . ($e->yil ? '<tr><th>Yıl</th><td>' . $e->yil . '</td></tr>' : '') . '
                                    ' . ($e->yakit ? '<tr><th>Yakıt</th><td>' . ilan::$dparams[$e->yakit] . '</td></tr>' : '') . '
                                    ' . ($e->vites ? '<tr><th>Vites</th><td>' . ilan::$dparams[$e->vites] . '</td></tr>' : '') . '
                                    ' . ($e->km ? '<tr><th>Km</th><td>' . $e->km . '</td></tr>' : '') . '
                                    ' . ($e->renk ? '<tr><th>Renk</th><td>' . ilan::$dparams[$e->renk] . '</td></tr>' : '') . '
                                    ' . ($e->kasa ? '<tr><th>Kasa Tipi</th><td>' . ilan::$dparams[$e->kasa] . '</td></tr>' : '') . '
                                    ' . ($e->motor_hacmi ? '<tr><th>Motor Hacmi</th><td>' . ilan::$dparams[$e->motor_hacmi] . '</td></tr>' : '') . '
                                    ' . ($e->motor_gucu ? '<tr><th>Motor Gücü</th><td>' . ilan::$dparams[$e->motor_gucu] . '</td></tr>' : '') . '
                                    ' . ($e->motor_motor_hacmi ? '<tr><th>Motor Hacmi</th><td>' . ilan::$dparams[$e->motor_motor_hacmi] . '</td></tr>' : '') . '
                                    ' . ($e->motor_motor_gucu ? '<tr><th>Motor Gücü</th><td>' . ilan::$dparams[$e->motor_motor_gucu] . '</td></tr>' : '') . '
                                    ' . ($e->silindir_sayisi ? '<tr><th>Silindir Sayısı</th><td>' . ilan::$dparams[$e->silindir_sayisi] . '</td></tr>' : '') . '
                                    ' . ($e->kapi ? '<tr><th>Kapı </th><td>' . ilan::$dparams[$e->kapi] . '</td></tr>' : '') . '
                                    ' . ($e->arac_cinsi ? '<tr><th>Araç Cinsi</th><td>' . ilan::$dparams[$e->arac_cinsi] . '</td></tr>' : '') . '
                                    ' . ($e->van_kasa ? '<tr><th>Kasa Tipi</th><td>' . ilan::$dparams[$e->van_kasa] . '</td></tr>' : '') . '
                                    ' . ($e->cekis ? '<tr><th>Çekiş</th><td>' . ilan::$dparams[$e->cekis] . '</td></tr>' : '') . '
                                    ' . ($e->garanti ? '<tr><th>Garanti</th><td>' . site::$garanti[$e->garanti] . '</td></tr>' : '') . '
                                    ' . ($e->plaka ? '<tr><th>Plaka</th><td>' . ilan::$dparams[$e->plaka] . '</td></tr>' : '') . '
                                    ' . ($e->kimden ? '<tr><th>Kimden</th><td>' . site::$kimden[$e->kimden] . '</td></tr>' : '') . '
                                    ' . ($e->takas ? '<tr><th>Takas</th><td>' . site::$takas[$e->takas] . '</td></tr>' : '') . '
                                    ' . ($e->tip ? '<tr><th>Emlak Tipi</th><td>' . ilan::$dparams[$e->tip] . '</td></tr>' : '') . '
                                    ' . ($e->oda ? '<tr><th>Oda Sayısı</th><td>' . ilan::$dparams[$e->oda] . '</td></tr>' : '') . '
                                    ' . ($e->m2 ? '<tr><th>M²</th><td>' . $e->m2 . '</td></tr>' : '') . '
                                    ' . ($e->bina_yasi ? '<tr><th>Bina Yaşı</th><td>' . $e->bina_yasi . '</td></tr>' : '') . '
                                    ' . ($e->bina_kat ? '<tr><th>Kat Sayısı</th><td>' . $e->bina_kat . '</td></tr>' : '') . '
                                    ' . ($e->kat ? '<tr><th>Bulunduğu Kat</th><td>' . $e->kat . '</td></tr>' : '') . '
                                    ' . ($e->cephe ? '<tr><th>Cephe</th><td>' . $e->cephe . '</td></tr>' : '') . '
                                    ' . ($e->isitma ? '<tr><th>Isıtma</th><td>' . ilan::$dparams[$e->isitma] . '</td></tr>' : '') . '
                                    ' . ($e->depozito ? '<tr><th>Depozito</th><td>' . $e->depozito . '</td></tr>' : '') . '
                                </table>
                            </div>
                        </div>
                        <div class="tab" style="position:relative;height:500px;visibility: hidden;">' . $harita . '</div>
                    </div>
                </div>
                <div class="iletisim span3">
                        <div class="sosyal">
                        	<div class="addthis_toolbox addthis_default_style addthis_16x16_style btn">
								<a class="addthis_button_facebook"></a>
								<a class="addthis_button_twitter"></a>
								<a class="addthis_button_google_plusone_share"></a>
								<a class="addthis_button_pinterest_share"></a>
							</div>
							<a href="#" class="btn btn-small favori">' . $favori . '</a>
                        	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
                        	<script>
                        		$(document).ready(function(){
    								$("a.favori").click(function(){
                        				var a = $(this);
    									$.post("/index.php?a=ilan/favori",{ilan_id:' . $e->ilan_id . '},function(b){
											if(b=="1") a.html("- Favorilerden Çıkar");
    										else if(b=="0") a.html("+ Favorilerime Ekle");
    										else { alert("Öncelikle oturum açmalısınız.");location.href="/index.php?b=uye/login";}
    									});
    								});
    								$("a.takip").click(function(){
                        				var c = $(this);
    									$.post("/index.php?a=ilan/favori",{uye_id:' . $e->uye_id . '},function(b){
											if(b=="1") c.html("Üye Takibini Sonlandır");
    										else if(b=="0") c.html("Üyeyi Takip Et");
    										else { alert("Öncelikle oturum açmalısınız.");location.href="/index.php?b=uye/login";}
    									});
    								});
    							});	
                        	</script>
                        </div>
                    <div class="menu6">
                        ' . $admin . '
                        <h4>İletişim Bilgileri</h4>
                        <div>
                            <b>' . $uye->ad . '</b><br>
                            Kayıt Tarihi : ' . lifos::to_web_date($uye->kayit_tarihi) . '<br>
                        </div>
                        <h5 class="cep"><span>Cep Tel</span> ' . $uye->tel . '</h5>
                        ' . ($uye->tel2 ? '<h5 class="is"><span>Ev Tel</span> ' . $uye->tel2 . '</h5>' : '') . '
                        ' . ($uye->tel3 ? '<h5 class="is"><span>İş Tel</span> ' . $uye->tel3 . '</h5>' : '') . '

                        ' . ($e->uye_id != $_SESSION['uye']['id'] ? '<div class="uyehareket"><ul>
                           <li class="mesajgonder"><a href="/index.php?b=uye/mesaj/gonder&to=' . $e->uye_id . '&id=' . $e->ilan_id . '">Mesaj Gönder</a></li>
                           <li class="hataliilan"><a href="/index.php?b=uye/sikayet/yeni&id=' . $e->ilan_id . '">Hatalı İlan Bildir</a></li>
                           <li class="takipet"><a href="#" class="takip">' . $takip . '</a></li>
						   <li class="digerilanlar"> ' . $diger_ilanlar_out . '</li></ul>
                        </div>' : '') . '
                    </div>
                    ' . ($reklam ? $reklam->icerik : '') . '
					<div class="yeni_ikinciel_reklam">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
					 style="display:inline-block;width:200px;height:200px"
					 data-ad-client="ca-pub-1034370367466687"
					 data-ad-slot="3149573504"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
				</div>
                </div>
				
				
            
    
            </div>
            
        ' . ($e->icerik ? '<div class="menu6"> <h4>Açıklama</h4> <div>' . $e->icerik . '</div> </div><br><br><br>' : '') . '
		' . ($e->guvenlik || $e->ic_donanim || $e->dis_donanim || $e->multimedia || $e->boya || $e->degisen || $e->motor_guvenlik || $e->motor_aksesuar ? '
        <div class="menu6"> 
        	<h4>Özellikler</h4> 
        	<div>
	            <table class="ozellikler-diger wa">
						<tr><td>
	        				' . ($e->kategori2 == 2 || $e->kategori2 == 4 || $e->kategori2 == 5 ? '
	        						<b>Güvenlik</b>' . $e->guvenlik . '
	        						<b>İç Donanim</b>' . $e->ic_donanim . '
	        						<b>Dış Donanim</b>' . $e->dis_donanim . '
	        						<b>Multimedia</b>' . $e->multimedia . '
									<b>Boyalı Parça</b>' . $e->boya . '
									<b>Değişen Parça</b>' . $e->degisen : '') . '
							' . ($e->kategori2 == 3 ? '
									<b>Güvenlik</b>' . $e->motor_guvenlik . '
									<b>Aksesuar</b>' . $e->motor_aksesuar : '') . '
						</td></tr>
				</table>
        	</div> 
		</div>' : '') . '
		<br>
		<br>
        <center>' . sayac($e->hit) . '<br>kez ziyaret edildi</center>
        ';

        $out .= "
        <script type=\"text/javascript\">
            $('document').ready(function(){
                $('.menu5 li').click(function(){
                    $('li',$(this).parent()).removeClass('aktif');
                    $(this).addClass('aktif');
                    $('div.tab',$(this).parent().parent().parent()).css('visibility','hidden');
                    $('div.tab:eq('+$(this).index()+')',$(this).parent().parent().parent()).css('visibility','visible');
                    return false;
                });
                
               
            });
        </script>";

        return $out;
    }

    function ajax_favori() {
        if ($_SESSION['uye']) {
            if ($ilan_id = $_POST['ilan_id']) {
                if (!$this->db->sorgu("select * from favori where ilan_id=%d and takipci_id=%d", $ilan_id, $_SESSION['uye']['id'])->sayi()) {
                    $this->db->add('favori', array('takipci_id' => $_SESSION['uye']['id'], 'ilan_id' => $ilan_id));
                    echo 1;
                    exit();
                } else {
                    $this->db->sorgu("delete from favori where ilan_id=%d and takipci_id=%d", $ilan_id, $_SESSION['uye']['id']);
                    echo 0;
                    exit();
                }
            } else if ($uye_id = $_POST['uye_id']) {
                if (!$this->db->sorgu("select * from favori where uye_id=%d and takipci_id=%d", $uye_id, $_SESSION['uye']['id'])->sayi()) {
                    $this->db->add('favori', array('takipci_id' => $_SESSION['uye']['id'], 'uye_id' => $uye_id));
                    echo 1;
                    exit();
                } else {
                    $this->db->sorgu("delete from favori where uye_id=%d and takipci_id=%d", $uye_id, $_SESSION['uye']['id']);
                    echo 0;
                    exit();
                }
            }
        }
        echo 2;
        exit();
    }

    function add_navi($title, $link) {
        $this->_navi[] = '<a href="' . $link . '">' . $title . '</a>';
    }

    function get_navi() {
        return '<div class="navi"><a href="/">Ana Sayfa</a> → ' . implode(' → ', $this->_navi) . '</div>';
    }

    function arama($request = array()) {
        global $site;

        $out .= '<br>' . $this->get_message() . '
    			 <div class="tabs">
					<a href="/index.php?b=ilan/arama" ' . ($request[0] ? '' : 'class="sel"') . '>İlan Ara</a>
					<a href="/index.php?b=ilan/arama/kullanici" ' . ($request[0] == 'kullanici' ? 'class="sel"' : '') . '>Kullanıcı Ara</a>
					<a href="/index.php?b=ilan/arama/magaza" ' . ($request[0] == 'magaza' ? 'class="sel"' : '') . '>Mağaza Ara</a>
    				<a href="/index.php?b=blog/arama">Haber Ara</a>
    			 </div><br>';

        if ($request[0] == 'kullanici') {
            if ($_POST['btnAra'] && ($ad = fi($_POST['ad'])) && (strlen(str_replace('%', '', $ad)) > 3)) {
                $ad = fi($_POST['ad']);
                if ($liste = $this->db->sorgu("select * from uye where ad like '%" . $ad . "%'")->listeObj()) {
                    $out2 .= '<thead><tr><th>Adı Soyadı</th><th>Kayıt Tarihi</th><th>İl</th><th></th></tr></thead>';

                    foreach ($liste as $a) {
                        $out2 .= '<tr><td>' . $a->ad . '</td><td>' . lifos::db_data($a->kayit_tarihi) . '</td><td>' . $a->sehir . '</td><td><a href="/index.php?b=ilan&uye_id=' . $a->id . '">İlanlara Git</a></td></tr>';
                    }

                    $out .= '<table class="table">' . $out2 . '</table>';
                    return $out;
                } else $this->add_message('Hiç sonuç bulunamadı.');
            }

            $out .= $this->get_message();
            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa form" style="width:100%">
	    					<tr><td width="150px"><b>Kullanıcının Adı</b></td><td><input type="text" name="ad" class="input"></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnAra" value="Arama" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

            return $out;
        } elseif ($request[0] == 'magaza') {
            if ($_POST['btnAra'] && ($ad = fi($_POST['ad'])) && (strlen(str_replace('%', '', $ad)) > 3)) {
                $ad = fi($_POST['ad']);

                if ($liste = $this->db->sorgu("select * from magaza where magaza_adi like '%" . $ad . "%'")->listeObj()) {
                    $out .= '<h5>Mağaza Arama Sonuçları</h5><br>';

                    foreach ($liste as $a) {
                        $out .= '<div><h5><a href="/index.php?b=ilan&magaza_id=' . $a->id . '">' . $a->magaza_adi . '</a></h5>' . $a->aciklama . '</div><hr>';
                    }

                    return $out;
                } else $this->add_message('Hiç sonuç bulunamadı.');
            }

            $out .= $this->get_message();
            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa form" style="width:100%">
	    					<tr><td width="150px"><b>Mağaza Adı</b></td><td><input type="text" name="ad" class="input"></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnAra" value="Arama" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

            return $out;
        }

        $out .= '<form method="get" enctype="multipart/form-data">
    					<table class="wa form" style="width:100%">
	    					<tr><td width="150px"><b>Kategori</b></td><td><div id="kategori">' . $site->kategori_select(site::P_KATEGORI, 0, 0) . '<input type="hidden" name="cat"><input type="hidden" name="cat2"></div></td></tr>
	    					<tr><td><b>Başlık*</b></td><td><input type="text" name="baslik" class="input-xxlarge" value="' . $p->baslik . '"></td></tr>
	    					<tr><td><b>Fiyat*</b></td><td><input type="text" name="fiyat" value="' . $p->fiyat . '" class="numeric">' . html::selecta(array('TL' => 'TL', '$' => '$', '€' => '€'), 'para_birimi', false, '', 'input-small') . '</td></tr>
	    				</table>
						<div class="ilanform"></div>
	    				<table class="wa form" style="width:100%">
	    					<tr><td width="150px"><b>Adres</b></td><td><div id="adres">' . $site->il_select() . '</div></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnAra" value="Arama" class="btn btn-success"></td></tr>
    					</table>
	    				<input type="hidden" value="ilan" name="b">
    				</form><br><br>';

        $out .= factory::get('js')->ready()->add("
    			$('#kategori select').live('change',function(){ 
					var a = $(this); 
					$.post('/index.php?a=ilan/kategori_select',{id:$(this).val(),l:$(this).index()},function(b){
    					$('#kategori select:gt('+a.index()+')').remove();
						a.after(b);
						$('input[name=cat]').val(a.val());
						$('input[name=cat2]').val($('#kategori select:eq(1)').val());
    				}); 

    				if($(this).index()==1) {
    					var alt = $('option:selected',$(this)).attr('alt_id');
    					$.post('/index.php?a=uye/ilan_form',{cat: alt ? alt : $(this).val()},function(a){
    						$('div.ilanform').html(a);
    					});
    				}
    			});
    			
				$('#adres select').live('change',function(){
					if($(this).attr('name')=='il'){
						var a = $(this);
						$.post('/index.php?a=ilan/ilce_select',{il:$(this).val()},function(b){
	    					$('#adres select:gt('+a.index()+')').remove();
							a.after(b);
	    				});
    				}
    			});
    	
    		")->getAll();

        if ($dopingler = $this->db->sorgu("select i.*,concat(d.id,'.',d.uzanti) as foto from ilan i,dosya d where i.doping_ara=1 and i.ilan_id=d.ref_id and d.ref_name='ilan' and d.sira=1 order by rand() limit 20")->listeObj()) {
            foreach ($dopingler as $ilan) {
                $dopdiv .= '<div class="span6">
    							<div class="foto"><a href="/ilan/' . $ilan->link . '-' . $ilan->ilan_id . '"><img src="/user/files/thumb_' . $ilan->foto . '"></a></div>
    							<div class="info"><small><a href="/ilan/' . $ilan->link . '-' . $ilan->ilan_id . '">' . lifos::substr($ilan->baslik, 10, '...') . '</a></small></div>
    						</div>';
            }

            $dopdiv = '<div class="row-fluid vitrin-ilanlar">' . $dopdiv . '</div>';
        }

        return '<div class="ara-menu span9">' . $out . '</div><div class="ara-vitrin"><h4>Vitrin<a href="/index.php?b=ilan&aravitrin=1">Tümü →</a></h4>' . $dopdiv . '</div>';
    }

    function ajax_kategori_select() {
        if ($id = fi($_POST['id'])) {
            $cat = $this->db->sorgu("select * from params where id=%d", $id)->satirObj();
            $cid = $cat->alt_id ? 2 : $id;

            echo $this->site->kategori_select($cat->cat, 0, $cid);
            exit();
        } else exit();
    }

    function ajax_ilce_select() {
        global $site;

        $il = fi($_POST['il']);
        echo $site->ilce_select($il);
        exit();
    }

    function ajax_belde_select() {
        global $site;

        $il = fi($_POST['il']);
        $ilce = fi($_POST['ilce']);

        echo $site->belde_select($il, $ilce);
        exit();
    }

}