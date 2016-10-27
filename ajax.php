<?php

/*
 * ajax controller
 */

class ajax extends controller {

    function ajax_not($command = array()) {
        if ($command[0] == 'yeni') {
            $id = $this->db->add('notlar', array(
                'yorum' => $_POST['val'],
                'not_tarihi' => lifos::db_date_time(),
                'olusturan_id' => $_SESSION['user']->personel_id,
                'ofis_id' => $_SESSION['user']->ofis_id
            ));

            baglanti_ekle($_GET['rel'], $_GET['rel_id'], 'Not', $id);

            $photo = $_SESSION['user']->photo ? '<div class="media-object img-circle" style="background:url(/user/profil_xs_' . $_SESSION['user']->photo . ') center no-repeat;"></div>' : ' <img src="/static/images/no-profile.png" class="img-circle">';

            echo '<div class="media">
                    <a class="pull-left" href="#">' . $photo . '</a>
                    <div class="media-body"><strong>' . $_SESSION['user']->personel_adi . '</strong><p>' . nl2br($_POST['val']) . '</p></div>
                </div>';

            exit();
        }
    }

    function ajax_para_kur() {
        $xml = @simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');
        foreach ($xml->Currency as $Currency) {
            $kur[(string)$Currency['Kod']] = (float)$Currency->ForexSelling;
        }

        echo json_encode($kur);
        exit();
    }

    function ajax_baglanti_ekle() {
        if ($_POST['ref_name'] && $_POST['ref_id'] && $_POST['des_name'] && $_POST['des_id']) {
            $this->db->add('baglanti', array(
                'ref_name' => $_POST['ref_name'],
                'ref_id' => $_POST['ref_id'],
                'des_id' => $_POST['des_id'],
                'des_name' => $_POST['des_name']
            ));

            $this->add_message($_POST['des_name'] . ' bağlantısı eklendi.');
            exit(1);
        }
    }

    function ajax_musteri_karti() {
        $q = $_GET['q'];

        $liste['query'] = $q;

        $liste['suggestions'] = $this->db->sorgu("

            SELECT
                m1.musteri_id AS data,
                m1.adsoyad as value,
                m1.ev_tel,
                m1.is_tel,
                m1.cep_tel,
                m1.musteri_tipi
            FROM
                musteri m1
            WHERE
              m1.adsoyad like '%s'
            $where
            limit 50", '%' . $q . '%')->liste();

        echo json_encode($liste);
        exit();
    }

    function ajax_baglanti() {
        $q = $_GET['q'];
        $tip = $_GET['tip'];

        $liste['query'] = $q;

        switch ($tip) {
            case 'Ürün' :
                $liste['suggestions'] = $this->db->sorgu("SELECT u.urun_adi as value,u.urun_id as data,u.urun_id FROM urun u WHERE u.urun_adi like '%s' limit 50", '%' . $q . '%')->liste();
                break;
            case 'Ürün Grubu' :
                $liste['suggestions'] = $this->db->sorgu("SELECT ug.grup_adi as value,ug.grup_id as data FROM urun_grubu ug WHERE ug.grup_adi like '%s' limit 50", '%' . $q . '%')->liste();
                break;
            case 'Teklif' :
                $liste['suggestions'] = $this->db->sorgu("SELECT teklif_baslik as value,teklif_id as data FROM teklif WHERE teklif_baslik like '%s' limit 50", '%' . $q . '%')->liste();
                break;
            case 'Görüşme' :
                $liste['suggestions'] = $this->db->sorgu('select concat("[",g.baglanti_tipi,"]",g.baglanti_baslik," - ",g.gorusme_tipi) as value,gorusme_id as data from gorusme g where g.baglanti_tipi like "%s" or g.baglanti_baslik like "%s" limit 50', '%' . $q . '%', '%' . $q . '%')->liste();
                break;
            case 'Müşteri' :
                $liste['suggestions'] = $this->db->sorgu("SELECT concat(m1.adsoyad,if(m2.musteri_id,concat(' - ',m2.adsoyad),'')) as value,m1.musteri_id as data FROM musteri m1 left outer join musteri m2 on(m1.firma_id=m2.musteri_id) WHERE m1.adsoyad like '%s' limit 50", '%' . $q . '%')->liste();
                break;
            case 'Fırsat' :
                $liste['suggestions'] = $this->db->sorgu("SELECT firsat_baslik as value,firsat_id as data FROM firsat WHERE firsat_baslik like '%s' limit 50", '%' . $q . '%')->liste();
                break;
            case 'Görev' :
                $liste['suggestions'] = $this->db->sorgu("SELECT gorev_baslik as value,gorev_id as data FROM gorev WHERE gorev_baslik like '%s' limit 50", '%' . $q . '%')->liste();
                break;
            case 'Sözleşme' :
                $liste['suggestions'] = $this->db->sorgu("SELECT sozlesme_baslik as value,sozlesme_id as data FROM sozlesme WHERE sozlesme_baslik like '%s' limit 50", '%' . $q . '%')->liste();
                break;
            case 'Satış' :
                $liste['suggestions'] = $this->db->sorgu(" SELECT * FROM (SELECT IF(m.musteri_id,concat(s.satis_baslik,'-',IF(m2.musteri_id,m2.adsoyad,m.adsoyad)),satis_baslik) as value,satis_id as data FROM satis s LEFT OUTER JOIN musteri m ON(s.musteri_id=m.musteri_id) LEFT OUTER JOIN musteri m2 ON(m.firma_id=m2.musteri_id) ) s where s.value like '%s' limit 50", '%' . $q . '%')->liste();
                break;
            case 'Proje' :
                $liste['suggestions'] = $this->db->sorgu("SELECT u.proje_baslik as value,u.proje_id as data FROM proje u WHERE u.proje_baslik like '%s' limit 50", '%' . $q . '%')->liste();
                break;
            case 'Destek' :
                $liste['suggestions'] = $this->db->sorgu("SELECT destek_baslik as value,destek_id as data FROM destek WHERE destek_baslik like '%s' limit 50", '%' . $q . '%')->liste();
                break;

            case 'İş Süreci' :
                $liste['suggestions'] = $this->db->sorgu("SELECT concat(m.adsoyad,' - ',pd.baslik,' ',it.kat) as value,proje_detay_id as data FROM proje_detay pd LEFT OUTER JOIN is_tipleri it ON(it.tip=pd.tip) LEFT OUTER JOIN proje p ON(p.proje_id=pd.proje_id) LEFT OUTER JOIN musteri m ON(p.musteri_id=m.musteri_id) WHERE (m.adsoyad like '%s' OR  pd.baslik like '%s' OR it.kat like '%s') limit 50", '%' . $q . '%', '%' . $q . '%', '%' . $q . '%')->liste();
                break;
            case 'İş' :
                $liste['suggestions'] = $this->db->sorgu("SELECT concat(m.adsoyad) as value,proje_id as data FROM proje p LEFT OUTER JOIN musteri m ON(p.musteri_id=m.musteri_id) WHERE (m.adsoyad like '%s') limit 50", '%' . $q . '%')->liste();
                break;
        }

        echo json_encode($liste);
        exit();
    }

}