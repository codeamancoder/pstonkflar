<?php
/*
 * 
 * basvuru.net admin controller class
 * 
 * 
 */

require DR . '/controller/main.php';

class blog extends controller {
    static $tipler = array(1 => 'Kariyer Rehberi', 2 => 'İçerik', 3 => 'Hakkımızda', 4 => 'Yardım');

    function index() {
        if ($blog_sayi = $this->db->sorgu("select count(*) from blog where tip=1")->sonuc(0)) {
            $pager = new pager($blog_sayi, 2);

            $liste = $this->db->sorgu("select * from blog where tip=1 order by tarih_yayin desc %s", $pager->get_sql_limit())->listeObj();

            $data['blogs'] = $liste;
            $data['pager'] = $pager->get_pager();
            return $this->view('blog', $data);
        }

    }

    function yardim() {
        $this->add_navi('Yardım', '#');
        $main = new main();

        if ($_POST['btnGonder']) {
            if ($_POST['ad'] && $_POST['tel'] && $_POST['mesaj'] && $_POST['eposta'] && $_POST['code']) {
                if ($_POST['code'] == $_SESSION['captcha']) {
                    factory::get('mailer')->fast_send('info@pistonkafalar.com', 'Piston Kafalar', 'Yardım Formu : ' . $_POST['konu'], 'Gönderen : ' . $_POST['ad'] . '<br>Tel : ' . $_POST['tel'] . '<br>Eposta Adresi : ' . $_POST['eposta'] . '<br>Mesaj : ' . $_POST['mesaj'] . '<br><br>Bu mesaj yardım formu aracılığı ile gönderildi.');
                    $this->add_message('Mesajınız başarıyla gönderilmiştir.. ', 'success');

                    $out .= $this->get_navi() . '<br>';
                    $out .= $this->create_message('Mesajınız başarı ile gönderilmiştir. ', 'success');

                    return $out;
                } else $this->add_message('Doğrulama kodu yanlış.', 'error');
            } else $this->add_message('Lütfen tüm bilgileri doldurunuz.', 'error');
        }

        $data['sag_menu'] = $main->sag_menu();
        $data['sag_menu_2'] = $main->sag_menu2();
        $data['message'] = $this->get_message();
        $data['navi'] = $this->get_navi();

        return $this->view('yardim', $data);
    }

    function detay() {
        if ($id = fi($_GET['id'])) {
            $blog = $this->db->sorgu("select * from blog where id=%d", $id)->satirObj();
            $main = new main();

            $_SESSION['html_id'] = 'blog-detail';
            $this->site->title = isset($blog->baslik) ? $blog->baslik : '';
            /*
             * yorum detaylarını görüntüle
             */
            if (isset($_GET['yorumlar'])) {
                $this->add_navi(site::$kategoriler[$blog->kategori], 'index.php?b=blog/' . lifos::clean_string_for_link(site::$kategoriler[$blog->kategori]));
                $this->add_navi(lifos::substr($blog->baslik, 40, '..'), $blog->link . '-' . $blog->id);
                $this->add_navi('Tüm Yorumlar', $blog->link . '-' . $blog->id . '?yorumlar');

                $sayi = $this->db->sorgu("SELECT count(*) from blog_yorum b,uye u where b.blog_id=%d and b.onay=1 and b.uye_id=u.id", $id)->sonuc(0) | 0;
                $pager = new pager($sayi, 2);
                $pager->setLink($blog->link . '-' . $blog->id . '?yorumlar');

                $data['navi'] = $this->get_navi();
                $data['blog'] = $blog;
                $data['yorumlar'] = $this->db->sorgu("select b.*,u.ad from blog_yorum b, uye u where b.blog_id=%d and b.onay=1 and b.uye_id=u.id order by b.id desc %s", $id, $pager->get_sql_limit())->listeObj();
                $data['pager'] = $pager->get_pager();

                return $this->view('yorum_detay', $data);
            } /*
    		 * blog görüntüle
    		 */
            elseif ($blog->tip == 'blog') {
                $this->db->inc('blog', 'hit', $blog->id, 'id', true);
                $this->add_navi(site::$kategoriler[$blog->kategori], 'index.php?b=blog/' . preg_replace('/-/', '', lifos::clean_string_for_link(site::$kategoriler[$blog->kategori])));
                $this->add_navi($blog->baslik, $blog->link . '-' . $blog->id);

                $data['baslik'] = site::$kategoriler[$blog->kategori];
                $data['yorumlar'] = $this->son_yorumlar($id);
                $data['digerleri'] = $blog->kategori == site::KAT_MAKALE ? $this->son_makaleler_diger($id) : $this->son_haberler_diger($id, 8);
                $data['navi'] = $this->get_navi();
                $data['blog'] = $blog;
                $data['uye'] = $_SESSION['uye'];
                $data['duyuru'] = $main->duyuru();
                $data['etiketler'] = $this->db->sorgu("select * from etiket where blog_id=%d", $blog->id)->listeObj();
                $blog->fotolar = factory::get('dosyalar')->getFiles('haber', $blog->id);
                $blog->manset = factory::get('dosyalar')->getFiles('manset', $blog->id);

                $data['foto'] = $blog->manset ? $blog->manset[0] : ($blog->fotolar ? $blog->fotolar[0] : null);

                $data['sag_menu'] = $main->sag_menu();
                $data['sag_menu_2'] = $main->sag_menu2();
                $this->site->add_relimg('/user/files/' . $data['foto']->id . '.' . $data['foto']->uzanti, $blog->baslik, $blog->ozet);

                return $this->view('haber_detay', $data);
            } /*
    		 * video görüntüle
    		 */
            elseif ($blog->tip == 'video') {
                $this->add_navi('Videolar', 'index.php?b=blog/videolar');
                $this->add_navi($blog->baslik, $blog->link . '-' . $blog->id);

                $data['baslik'] = 'Videolar';
                $data['yorumlar'] = $this->son_yorumlar($id);
                $data['digerleri'] = $this->son_haberler_diger($id, 8);
                $data['navi'] = $this->get_navi();
                $data['video'] = $blog;
                $data['uye'] = $_SESSION['uye'];
                $data['sag_menu'] = $main->sag_menu();
                $data['sag_menu_2'] = $main->sag_menu2();
                $data['duyuru'] = $main->duyuru();

                return $this->view('video_detay', $data);
            } /*
    		 * galeri görüntüle
    		 */
            elseif ($blog->tip == 'galeri') {
                $this->add_navi('Galeriler', 'index.php?b=blog/galeriler');
                $this->add_navi($blog->baslik, $blog->link . '-' . $blog->id);

                $blog->fotolar = factory::get('dosyalar')->getFiles('galeri', $blog->id);
                $data['baslik'] = $blog->baslik;
                $data['yorumlar'] = $this->son_yorumlar($id);
                $data['digerleri'] = $this->son_haberler_diger($id, 8);
                $data['navi'] = $this->get_navi();
                $data['blog'] = $blog;
                $data['uye'] = $_SESSION['uye'];
                $data['sag_menu'] = $main->sag_menu();
                $data['sag_menu_2'] = $main->sag_menu2();
                $data['duyuru'] = $main->duyuru();

                return $this->view('galeri_detay', $data);
            } /*
    		 * anket görüntüle
    		 */
            elseif ($blog->tip == 'anket') {
                $this->add_navi('Anketler', 'index.php?b=blog/anketler');
                $this->add_navi($blog->baslik, $blog->link . '-' . $blog->id);

                $blog->icerik = unserialize($blog->icerik);

                if ($_POST['btnOyKullan']) {
                    if (!isset($_SESSION['anket_oy'][$id]) && !isset($_COOKIE['anket_' . $id]) && isset($_POST['oy'])) {
                        $i = $_POST['oy'];
                        $blog->icerik[$i][1]++;
                        $this->db->sorgu("update blog set icerik='%s' where id=%d", serialize($blog->icerik), $blog->id);
                        @$_SESSION['anket_oy'][$id] = true;
                        setcookie('anket_' . $id, 1, time() + 24 * 60 * 60);
                        $data['message'] = $this->create_message('Oyunuz kaydedildi.', 'success');
                    } else $data['message'] = $this->create_message('Daha önce oy kullandınız.', 'error');
                }

                $data['baslik'] = $blog->baslik;
                $data['digerleri'] = $this->son_haberler_diger($id);
                $data['navi'] = $this->get_navi();
                $data['sag_menu'] = $main->sag_menu();

                foreach ($blog->icerik as $o) {
                    $sum += $o[1];
                }

                $sum = $sum ? $sum : 1;

                foreach ($blog->icerik as &$o) {
                    $o[2] = ceil(($o[1] / $sum) * 100);
                }

                $blog->toplam = $sum;
                $data['blog'] = $blog;

                return $this->view('anket_detay', $data);
            } /*
    		 * anket görüntüle
    		 */
            elseif ($blog->tip == 'sayfa') {
                $this->add_navi($blog->baslik, $blog->link . '-' . $blog->id);

                $data['navi'] = $this->get_navi();
                $data['sag_menu'] = $main->sag_menu();
                $data['sag_menu_2'] = $main->sag_menu2();
                $data['blog'] = $blog;

                return $this->view('sayfa_detay', $data);
            }
        }
    }

    private function son_yorumlar($blog_id, $limit = 10) {
        return $this->db->sorgu("SELECT b.*,u.ad FROM blog_yorum b,uye u where b.uye_id=u.id and b.blog_id=%d and b.onay=1 order by id desc limit 10", $blog_id)->listeObj();
    }

    private function son_haberler_diger($blog_id, $limit = 15) {
        return $this->db->sorgu("select b2.id,b2.baslik,b2.link,b2.hit,b2.tarih_yayin,concat(d.id,'.',d.uzanti) as foto from blog b1,blog b2,dosya d where b1.id=%d and b2.id = d.ref_id and b1.kategori=b2.kategori and sira=1 and b1.tip=b2.tip and not b1.id=b2.id GROUP by b2.id order by b2.id desc limit %d", $blog_id, $limit)->listeObj();
    }

    private function son_makaleler_diger($blog_id, $limit = 15) {
        return $this->db->sorgu("select b2.id,b2.baslik,b2.link from blog b1,blog b2 where b1.id=%d and b1.kategori=b2.kategori and b1.tip=b2.tip and b1.uye_id=b2.uye_id and not b1.id=b2.id order by b2.id desc limit %d", $blog_id, $limit)->listeObj();
    }

    function haberler($title = 'Haberler', $kategori = 0) {

        if (!$title) {
            $title = 'Haberler';
        }
        $this->site->title = $title;

        $main = new main();
        $_SESSION['html_id'] = 'blog-version-2';
        if ($sayi = $this->db->sorgu("select blog.id from blog,dosya where blog.tip='blog' and kategori=%d and blog.id=dosya.ref_id and sira=1 group by blog.id ", $kategori)->sayi()) {
            $pager = new pager($sayi, 15);
            $pager->set_max_showing_page(6);
            $this->add_navi(site::$kategoriler[$kategori], 'index.php?b=blog/' . preg_replace('/-/', '', lifos::clean_string_for_link(site::$kategoriler[$kategori])));
            $data['baslik'] = site::$kategoriler[$kategori];
            $data['navi'] = $this->get_navi();
            $data['haberler'] = $this->db->sorgu("select blog.*, concat(dosya.id,'.',dosya.uzanti) as foto from blog,dosya where blog.tip='blog' and kategori=%d and blog.id=dosya.ref_id and sira=1 group by blog.id order by blog.id desc %s", $kategori, $pager->get_sql_limit())->listeObj();
            $data['pager'] = $pager->get_pager();
            $data['sag_menu'] = $main->sag_menu();
            $data['sag_menu_2'] = $main->sag_menu2();
            $data['duyuru'] = $main->duyuru();

            return $this->view('haber_liste', $data);
        } else {
            $this->add_navi(site::$kategoriler[$kategori], 'index.php?b=blog/' . preg_replace('/-/', '', lifos::clean_string_for_link(site::$kategoriler[$kategori])));
            $data['baslik'] = site::$kategoriler[$kategori];
            $data['navi'] = $this->get_navi();
            $data['message'] = $this->create_message('Bu bölüme henüz haber girilmedi.');
            $data['sag_menu'] = $main->sag_menu();
            $data['sag_menu_2'] = $main->sag_menu2();
            $data['duyuru'] = $main->duyuru();
            return $this->view('haber_liste', $data);
        }
    }

    function anketler() {
        $main = new main();

        $this->add_navi('Anketler', 'index.php?b=blog/anketler');
        $data['baslik'] = 'Anketler';
        $data['navi'] = $this->get_navi();
        $data['anketler'] = $this->db->sorgu("select * from blog where tip='anket' order by id desc")->listeObj();
        $data['sag_menu'] = $main->sag_menu();
        return $this->view('anket_liste', $data);
    }

    function hizmetsozlesmesi2() {
        $hizmet = $this->db->sorgu("select * from blog where tip='sayfa' and link='uyelik-sozlesmesi'")->satirObj();

        exit('<!doctype html>
<html>
<head>
    <title>Piston Kafalar</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    			</head>
    			<body>' . $hizmet->icerik . '</body></html>');
    }

    function yazar() {
        $id = fi($_GET['id']);
        $main = new main();

        if ($yazar = $this->db->sorgu("select * from uye where id=%d and tip>0", $id)->satirObj()) {
            if ($sayi = $this->db->sorgu("select blog.id from blog,dosya where uye_id=%d and blog.id=dosya.ref_id and sira=1 group by blog.id ", $id)->sayi()) {
                $pager = new pager($sayi, 10);
                $this->add_navi($yazar->ad . ' Yazıları', 'index.php?b=blog/yazar&id=' . $yazar->id);
                $data['baslik'] = $yazar->ad . ' Yazıları';
                $data['navi'] = $this->get_navi();
                $data['haberler'] = $this->db->sorgu("select blog.*, concat(dosya.id,'.',dosya.uzanti) as foto from blog,dosya where uye_id=%d and blog.id=dosya.ref_id and sira=1 group by blog.id order by blog.id desc %s", $id, $pager->get_sql_limit())->listeObj();
                $data['pager'] = $pager->get_pager();
                $data['sag_menu'] = $main->sag_menu();

                return $this->view('haber_liste', $data);
            } else {
            }

        }

        $this->add_navi(site::$kategoriler[$kategori], 'index.php?b=blog/' . lifos::clean_string_for_link(site::$kategoriler[$kategori]));
        $data['baslik'] = site::$kategoriler[$kategori];
        $data['navi'] = $this->get_navi();
        $data['message'] = $this->create_message('Bu bölüme henüz haber girilmedi.');
        $data['sag_menu'] = $main->sag_menu();

        return $this->view('haber_liste', $data);
    }

    function arama() {
        $main = new main();

        if ($_POST['btnAra'] || $_REQUEST['q']) {
            $this->add_navi('Arama Sonuçları', '#');

            $q = fi(ucfirst($_REQUEST['q']));
            $this->site->title = 'Arama Sonuçları - ' . $q;

            if (strlen($q) < 3) {
                $data['message'] = $this->create_message('En az 3 karakter girmelisiniz.', 'error');
            } else {
                if ($sayi = $this->db->sorgu("select count(id) from blog where MATCH (baslik,ozet,icerik) AGAINST ('*\"%s\"*' IN BOOLEAN MODE)", $q)->sonuc(0)) {
                    $data['sayi'] = $sayi;
                    $pager = new pager($sayi, 20);
                    $pager->set_max_showing_page(6);
                    $pager->setLink('q=honda&b=blog/arama');
                    $data['pager'] = $pager->get_pager();
                    $data['sonuclar'] = $this->db->sorgu("select baslik,id,link from blog where MATCH (baslik,ozet,icerik) AGAINST ('*\"%s\"*' IN BOOLEAN MODE) order by id desc %s", $q, $pager->get_sql_limit())->listeObj();
                } else {
                    $data['message'] = $this->create_message('Hiç sonuç bulunamadı.', 'error');
                }

            }

            $data['navi'] = $this->get_navi();
            $data['sag_menu'] = $main->sag_menu();
            $data['sag_menu_2'] = $main->sag_menu2();
            $data['duyuru'] = $main->duyuru();
            $data['aranan'] = $q;

            return $this->view('arama', $data);
        }

        $out .= '<br>' . $this->get_message() . '
    			 <div class="tabs">
					<a href="/index.php?b=ilan/arama">İlan Ara</a>
					<a href="/index.php?b=ilan/arama/kullanici">Kullanıcı Ara</a>
					<a href="/index.php?b=ilan/arama/magaza">Mağaza Ara</a>
    				<a href="/index.php?b=blog/arama" class="sel">Haber Ara</a>
    			 </div><br>';

        $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa form" style="width:100%">
	    					<tr><td width="150px"><b>Anahtar Kelime</b></td><td><input type="text" name="q" class="input"></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnAra" value="Arama" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

        if ($haberler = $this->db->sorgu("select h.*,concat(d.id,'.',d.uzanti) as foto from blog h, dosya d where h.tip='blog'  and d.ref_name='haber' and d.sira=1 and ref_id=h.id  order by tarih desc limit 10")->listeObj()) {
            foreach ($haberler as $ilan) {
                $dopdiv .= '<div class="haber" style="height:100px;">
                                <div class="foto"><a href="/' . $ilan->link . '-' . $ilan->id . '"><img src="/user/files/wrap_' . $ilan->foto . '"></a></div>
                                <div class="baslik">
                                    <strong><a href="/' . $ilan->link . '-' . $ilan->id . '">' . lifos::substr($ilan->baslik, 45, '...') . '</a></strong>
                                    <p class="muted"><small>' . lifos::substr($ilan->ozet, 60, '..') . '</small></p>
                                </div>
                            </div>';
            }

            $dopdiv = '<div class="row-fluid vitrin-ilanlar haberler">' . $dopdiv . '</div>';
        }

        return '<div class="ara-menu span8">' . $out . '</div><div class="ara-vitrin"><h4>Son Eklenen Haberler</h4>' . $dopdiv . '</div>';

    }

    function videolar() {
        $main = new main();
        $this->add_navi('Videolar', 'index.php?b=blog/videolar');
        $this->site->title = $data['baslik'] = 'Videolar';

        if ($sayi = $this->db->sorgu("select count(*) from blog where tip='video'")->sonuc(0)) {
            $pager = new pager($sayi, 15);
            $data['videolar'] = $this->db->sorgu("select * from blog where tip='video' order by id desc %s", $pager->get_sql_limit())->listeObj();
            $data['pager'] = $pager->get_pager();
            $data['sag_menu'] = $main->sag_menu();
            $data['sag_menu_2'] = $main->sag_menu2();
            $data['duyuru'] = $main->duyuru();
            $data['navi'] = $this->get_navi();

            return $this->view('video_liste', $data);
        } else {
            $data['message'] = $this->create_message('Bu bölüme henüz video girilmedi.');
        }

        $data['navi'] = $this->get_navi();
        $data['sag_menu'] = $main->sag_menu();
        return $this->view('video_liste', $data);
    }

    function reklam() {
        $this->add_navi('Reklam', '#');
        $main = new main();
        $data['sag_menu'] = $main->sag_menu();
        $data['sag_menu_2'] = $main->sag_menu2();
        $data['navi'] = $this->get_navi();

        return $this->view('reklam', $data);
    }

    function galeriler($requests) {
        $main = new main();
        $this->add_navi('Galeriler', 'index.php?b=blog/galeriler');
        $this->site->title = $data['baslik'] = 'Galeriler';

        $where = !$requests[0] ? ' and uye_id=1' : ($requests[0] == 'piston' ? ' and uye_id=1' : ' and uye_id>1');

        if ($sayi = $this->db->sorgu("select count(*) from blog where tip='galeri' and onay=1 $where")->sonuc(0)) {
            $pager = new pager($sayi, 20);
            $data['galeriler'] = $this->db->sorgu("select b.*,concat(d.id,'.',d.uzanti) as kapak from blog b,dosya d where b.tip='galeri' and b.tip=d.ref_name and d.sira=1 and b.onay=1 and d.ref_id=b.id $where order by b.id desc %s", $pager->get_sql_limit())->listeObj();
            $data['pager'] = $pager->get_pager();
            $data['sag_menu'] = $main->sag_menu();
            $data['sag_menu_2'] = $main->sag_menu2();
            $data['duyuru'] = $main->duyuru();
            $data['navi'] = $this->get_navi();

            return $this->view('galeri_liste', $data);
        } else {
            $data['message'] = $this->create_message('Bu bölüme henüz galeri girilmedi.');
        }

        $data['navi'] = $this->get_navi();
        return $this->view('galeri_liste', $data);
    }

    function etiket() {
        $etiket = fi($_GET['tag']);

        $this->add_navi('Etiketler : ' . $_GET['tag'], '/etiket/' . $_GET['tag']);
        $main = new main();

        if ($sayi = $this->db->sorgu("select blog.id from etiket,blog  where tag = '%s' and etiket.blog_id=blog.id group by blog_id order by blog.tarih_yayin desc", $etiket)->sayi()) {
            $pager = new pager($sayi, 20);
            $data['navi'] = $this->get_navi();
            $data['etiketler'] = $this->db->sorgu("select blog.* from etiket,blog  where tag = '%s' and etiket.blog_id=blog.id group by blog_id order by blog.tarih_yayin desc %s", $etiket, $pager->get_sql_limit())->listeObj();
            $data['pager'] = $pager->get_pager();

        } else {
            $data['navi'] = $this->get_navi();
            $data['message'] = $this->create_message('Bu etiket ile ilgili hiçbirşey bulunamadı.');
        }
        $data['sag_menu'] = $main->sag_menu();
        $data['sag_menu_2'] = $main->sag_menu2();
        $data['duyuru'] = $main->duyuru();

        return $this->view('etiket_liste', $data);

    }

    function yenilikler() {
        return $this->haberler(site::$kategoriler[site::KAT_YENILIK], site::KAT_YENILIK);
    }

    function sektorel() {
        return $this->haberler(site::$kategoriler[site::KAT_SEKTOREL], site::KAT_SEKTOREL);
    }

    function test() {
        return $this->haberler(site::$kategoriler[site::KAT_TEST], site::KAT_TEST);
    }

    function motorspor() {
        return $this->haberler(site::$kategoriler[site::KAT_MOTOR], site::KAT_MOTOR);
    }

    function modifiye() {
        return $this->haberler(site::$kategoriler[site::KAT_MODIFIYE], site::KAT_MODIFIYE);
    }

    function lifestyle() {
        return $this->haberler(site::$kategoriler[site::KAT_LIFESTYLE], site::KAT_LIFESTYLE);
    }

    function kampanyalar() {
        return $this->haberler(site::$kategoriler[site::KAT_KAMPANYA], site::KAT_KAMPANYA);
    }

    function cevreciotomobiller() {
        return $this->haberler(site::$kategoriler[site::KAT_CEVRECI], site::KAT_CEVRECI);
    }

    function diecast() {
        return $this->haberler(site::$kategoriler[site::KAT_DIE], site::KAT_DIE);
    }

    function makaleler() {
        return $this->haberler(site::$kategoriler[site::KAT_MAKALE], site::KAT_MAKALE);
    }

    function add_navi($title, $link) {
        $this->_navi[] = '<a href="' . $link . '">' . $title . '</a>';
    }

    function get_navi() {
        return '<div class="navi"><a href="/">Piston Kafalar</a> → ' . implode(' → ', $this->_navi) . '</div>';
    }

    function not_found($name) {

    }

}