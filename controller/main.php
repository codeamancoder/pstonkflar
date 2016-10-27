<?php

/*
 * mail controller
 */

class main extends controller {
    /*
     * index sayfası giriş metodu
     */
    function index() {
        if (($_SERVER['REMOTE_ADDR'] != '127.0.0.1') && !isset($_SERVER['HTTPS'])) {
            header("Location:https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            exit();
        }

        $data['haber_manset'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where d.ref_name='manset' and d.sira=1 and ref_id=h.id and not h.kategori=3 group by h.id order by id desc limit 6")->listeObj();
        $data['haberler'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='manset' and d.sira=1 and ref_id=h.id  order by id desc limit 4", site::KAT_HABER)->listeObj();
        $data['testler'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='haber' and ref_id=h.id and d.sira=1 order by id desc limit 4", site::KAT_TEST)->listeObj();
        $data['yenilikler'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='manset' and ref_id=h.id and d.sira=1 order by id desc limit 4", site::KAT_YENILIK)->listeObj();
        $data['modifiye'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='manset' and ref_id=h.id and d.sira=1 order by id desc limit 4", site::KAT_MODIFIYE)->listeObj();
        $data['lifestyle'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='manset' and ref_id=h.id and d.sira=1 order by id desc limit 4", site::KAT_LIFESTYLE)->listeObj();
        $data['videolar'] = $this->db->sorgu("select h.* from blog h where h.tip='video' order by h.id desc limit 18")->listeObj();
        $data['kampanyalar'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='manset' and ref_id=h.id and d.sira=1 order by id desc limit 4", site::KAT_KAMPANYA)->listeObj();
        $data['motorspor'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='manset' and ref_id=h.id and d.sira=1 order by id desc limit 4", site::KAT_MOTOR)->listeObj();
        $data['sektorel'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='haber' and ref_id=h.id and d.sira=1 order by id desc limit 4", site::KAT_SEKTOREL)->listeObj();
        $data['cevreciler'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='manset' and d.sira=1 and ref_id=h.id  order by id desc limit 4", site::KAT_CEVRECI)->listeObj();
        $data['yazarlar'] = $this->db->sorgu("select u.*,b.baslik,b.link,b.id as blog_id from uye u left outer join (select * from blog order by id desc) b on(u.id=b.uye_id) where u.tip=1 group by u.id;")->listeObj();
        $data['manset_ustu'] = $this->db->sorgu("select * from blog where tip='reklam' and kategori='4' order by id desc limit 1")->satirObj();
        $data['sag_menu_1'] = $this->sag_menu1();
        $data['sag_menu_2'] = $this->sag_menu2();
        $data['duyuru'] = $this->duyuru();
        $data['html_id'] = 'home-version-2';
        $data['reklam_ana_orta'] = $this->db->sorgu("select * from blog where tip='reklam' and kategori='1' order by id desc limit 1")->satirObj();

        return $this->view('index', $data);
    }

    function duyuru() {
        return $this->view('duyuru', array());
    }

    function sag_menu() {
        return $this->sag_menu1() . $this->sag_menu2();
    }

    function sag_menu1() {
        if (!($data['reklam_ust_sag'] = $this->db->sorgu("select * from blog where tip='reklam' and kategori='0' order by id desc limit 1")->satirObj()) && ($galeri_id = $this->site->get_ayar('ana_sayfa_galeri'))) {
            $blog = new stdClass();
            $data['galeri'] = $this->db->sorgu("select * from blog where id=%d", $galeri_id)->satirObj();
            $data['galeri']->fotos = $blog->fotolar = factory::get('dosyalar')->getFiles('galeri', $galeri_id);
        }

        $data['yazarlar'] = $this->db->sorgu("select u.*,b.baslik,b.link,b.id as blog_id from uye u left outer join (select * from blog where tip='blog' and kategori=%d order by id desc) b on(u.id=b.uye_id) where u.tip=1 and u.gizli=0 group by u.id;", site::KAT_MAKALE)->listeObj();
        $data['cok']['haber'] = $this->db->sorgu("select baslik,id,link from blog where tip='blog' and kategori=%d order by hit desc limit 5", site::KAT_HABER)->listeObj();
        $data['cok']['test'] = $this->db->sorgu("select baslik,id,link from blog where tip='blog' and kategori=%d order by hit desc limit 5", site::KAT_TEST)->listeObj();
        $data['cok']['yenilik'] = $this->db->sorgu("select baslik,id,link from blog where tip='blog' and kategori=%d order by hit desc limit 5", site::KAT_YENILIK)->listeObj();
        $data['akin_son'] = $this->db->sorgu("select * from blog where tip='blog' and kategori=%d and uye_id=%d order by id desc limit 1", site::KAT_MAKALE, 1)->satirObj();

        return $this->view('sag_menu_1', $data);
    }

    function sag_menu2() {
        if (!($data['reklam_ust_sag2'] = $this->db->sorgu("select * from blog where tip='reklam' and kategori='5' order by id desc limit 1")->satirObj()) && ($galeri_id = $this->site->get_ayar('ana_sayfa_galeri2'))) {
            $blog = new stdClass();
            $data['galeri2'] = $this->db->sorgu("select * from blog where id=%d", $galeri_id)->satirObj();
            $data['galeri2']->fotos = $blog->fotolar = factory::get('dosyalar')->getFiles('galeri', $galeri_id);
        }

        // etiket
        $data['etiketler'] = $this->db->sorgu("select * from etiket WHERE tag != '' group by blog_id,tag order by id desc limit %d", 20)->listeObj();

        $data['galeriler']['bizden'] = $this->db->sorgu("SELECT b.baslik as blog_baslik,b.link,b.id as blog_id,d.* FROM blog b, dosya d,uye u where b.tip='galeri' and d.ref_name=b.tip and b.id=d.ref_id and d.sira=1 and b.uye_id=u.id and u.tip>0 order by b.id desc limit 6")->listeObj();
        $data['galeriler']['sizden'] = $this->db->sorgu("SELECT b.baslik as blog_baslik,b.link,b.id as blog_id,d.* FROM blog b, dosya d,uye u where b.tip='galeri' and d.ref_name=b.tip and b.id=d.ref_id and d.sira=1 and b.uye_id=u.id and u.tip=0 and b.onay=1 order by b.id desc limit 6")->listeObj();
        if ($data['anket'] = $this->db->sorgu("SELECT * FROM blog where tip='anket' order by id desc limit 1")->satirObj()) {
            $data['anket']->icerik = unserialize($data['anket']->icerik);
        }
        $data['ilanlar'] = $this->db->sorgu("select i.*, concat(d.id,'.',d.uzanti) as img from ilan i, dosya d where i.ilan_id=d.ref_id and d.ref_name='ilan' and d.sira=1 order by ilan_id desc limit 4")->listeObj();

        $data['cok']['haber'] =  $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='haber' and d.sira=1 and ref_id=h.id and d.sira=1 order by h.hit desc limit 4", site::KAT_HABER)->listeObj();
        $data['cok']['sektorel'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='haber' and d.sira=1 and ref_id=h.id and d.sira=1 order by h.hit desc limit 4", site::KAT_SEKTOREL)->listeObj();
        $data['cok']['yenilik'] = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog' and h.kategori=%d and d.ref_name='haber' and d.sira=1 and ref_id=h.id and d.sira=1 order by h.hit desc limit 4", site::KAT_YENILIK)->listeObj();
        $data['akin_son'] = $this->db->sorgu("select * from blog where tip='blog' and kategori=%d and uye_id=%d order by id desc limit 1", site::KAT_MAKALE, 1)->satirObj();
        return $this->view('sag_menu_2', $data);
    }

    function ajax_arkadasima_gonder() {

        $p = (object)$_POST;

        if ($p->ad && $p->eposta_sizin && $p->eposta_arkadas && $p->captcha) {
            if ($p->captcha == $_SESSION['captcha']) {
                $go = $this->db->sorgu("select * from blog where id=%d", $p->id)->satirObj();
                factory::get('mailer')->fast_send($p->eposta_arkadas, $p->eposta_arkadas, $p->ad . ' Gözatmanı Öneriyor', 'Merhaba,<br><br>Arkadaşın <b>' . $p->ad . '</b> pistonkafalar.com da yayınlanan <a href="http://www.pistonkafalar.com/' . $go->link . '-' . $go->id . '">' . $go->baslik . '</a> yazısını okumanı öneriyor. ' . ($p->mesaj ? '<br><br>Arkadaşının Mesajı:<br>' . $p->mesaj : '') . '<br><br>Piston Kafalar Ekibi');
                $_SESSION['captcha'] = null;
                echo json_encode(array('res' => 1, 'msg' => 'Mesajınız gönderildi.'));
            } else echo json_encode(array('res' => 0, 'msg' => 'Doğrulama kodu yanlış.'));
        } else echo json_encode(array('res' => 0, 'msg' => 'Lütfen tüm alanları doldurun.'));
        exit();
    }

    function ajax_yorum() {
        if (!$_SESSION['uye']) exit('Yorum yapabilmek için oturum açmalı yada üye olmalısınız.');
        $p = (object)$_POST;

        if ($p->rating && $p->mesaj && $p->captcha && $p->id) {
            if ($p->captcha == $_SESSION['captcha']) {
                $_SESSION['captcha'] = null;
                $this->db->add("blog_yorum", array('blog_id' => $p->id, 'yorum' => $p->mesaj, 'skor' => $p->rating, 'tarih' => lifos::db_data_time(), 'ip' => lifos::ip(), 'onay' => 0, 'uye_id' => $_SESSION['uye']['id']));
                echo json_encode(array('res' => 1, 'msg' => 'Yorumunuz kaydedildi. Yönetici onayından sonra yayına alınacaktır.'));
            } else echo json_encode(array('res' => 0, 'msg' => 'Doğrulama kodu yanlış.'));
        } else echo json_encode(array('res' => 0, 'msg' => 'Lütfen tüm alanları doldurun.'));
        exit();
    }

    function dialog_arkadasima_gonder() {
        exit($this->view('dialog_arkadasima_gonder'));
    }

    function dialog_yorum() {
        if (!$_SESSION['uye']) exit($this->create_message('Yorum yapabilmek için oturum açmalı yada üye olmalısınız.'));
        exit($this->view('dialog_yorum'));
    }

    function feed() {
        header("Content-Type: application/rss+xml");

        $domain = "www.pistonkafalar.com";

        $out = '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"
xmlns:content="http://purl.org/rss/1.0/modules/content/"
xmlns:wfw="http://wellformedweb.org/CommentAPI/"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:atom="http://www.w3.org/2005/Atom"
xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
		
<channel>
<title>Piston Kafalar Rss Feed</title>
<atom:link href="http://' . $domain . '/feed/" rel="self" type="application/rss+xml" />
<link>http://' . $domain . '</link>
<description>Türkiyenin en dinamik otomobil portalı</description>
<lastBuildDate>' . date('r') . '</lastBuildDate>
<language>tr</language>
<sy:updatePeriod>daily</sy:updatePeriod>
<sy:updateFrequency>1</sy:updateFrequency>
<xhtml:meta xmlns:xhtml="http://www.w3.org/1999/xhtml" name="robots" content="noindex" />';

        if ($links = $this->db->sorgu("select * from blog order by id desc limit 10")->liste()) {
            foreach ($links as $link) {
                $out .= '
        <item>
        <title>' . stripslashes($link['baslik']) . '</title>
        <link>http://' . $domain . '/' . $link['link'] . '-' . $link['id'] . '</link>
        <description>' . stripslashes($link['baslik']) . '</description>
        <pubDate>' . $link['tarih_yayin'] . '</pubDate>
		
        </item>';
            }
            //<category><![CDATA['.$this->veri['site']['name_short'].']]></category>
            //<category><![CDATA['.$this->veri['site']['keywords'].']]></category>
        }

        exit($out . '</channel></rss>');
    }

    function captcha() {
        require_once DR . '/include/lib/captcha/captcha.php';
        exit();
    }

    function rebuild_eticaret_connection() {
        if ($liste = $this->db->sorgu("select * from uye where eticaret_id is null or eticaret_id=0")->listeObj()) {
            foreach ($liste as $p) {
                $eticaret_id = file_get_contents('https://magaza.pistonkafalar.com/api.php?action=uye/yeni&isim=' . urlencode($p->ad) . '&eposta=' . $p->eposta . '&sifre_md5=' . $p->sifre);
                $this->db->sorgu("update uye set eticaret_id=%d where id=%d", $eticaret_id, $p->id);
            }

            echo count($liste) . ' kayit eticarete aktarildi.';
        }
    }
}
