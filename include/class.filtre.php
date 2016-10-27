<?php

class filtre {
    public $x;
    public $p;
    private $v;
    private $query = "SELECT %s FROM ilan %s WHERE %s ";
    private $query_cols;
    private $query_order = 'tarih_yayin DESC';
    private $query_where;
    private $query_outer;
    private $query_group;
    private $anahtar;

    static $tarihler = array('s1' => 'Son 1 Saat', 's8' => 'Son 8 Saat', 'g1' => 'Bugünün İlanları', 'g3' => 'Son 3 Gün', 'g7' => 'Son 1 Hafta', 'g14' => 'Son 2 Hafta', 'g30' => 'Son 1 Ay');

    function filtre() {
        if (($this->x = $_GET['x']) && ($this->p = $_SESSION['ara'][$this->x])) {
            if ($_GET['page']) $this->p->page = $_GET['page'];
            if ($_GET['order']) $this->p->order = $_GET['order'];
        } elseif ($_POST || isset($_GET['hemenara'])) {
            $_SESSION['ara'] = null;
            $this->x = time();
            $_SESSION['ara'][$this->x] = (object)$_REQUEST;
            $this->p = (object)$_REQUEST;
        }
    }

    function get($i) {
        return $this->p->$i;
    }

    static function get_last_x() {
        return $_SESSION['ara'] ? @end(@array_keys($_SESSION['ara'])) : 0;
    }

    private function _order_by() {
        $orders = array('tarih' => 'tarih_olusturma', 'tarih_d' => 'tarih_olusturma desc', 'pozisyon' => 'pozisyon_adi', 'pozisyon_d' => 'pozisyon_adi desc', 'firma' => 'firma_adi', 'firma_d' => 'firma_adi desc');

        if (($order = $this->get('order')) && $orders[$order]) {
            $this->query_order = $orders[$order];
        }
    }

    function prepare($form = false) {
        $p = &$this->p;

        $this->query_order = "tarih_yayin DESC";
        $this->query_cols = "ilan.id,ilan.pozisyon_adi, ilan.firma_adi, ilan.tarih_yayin, if(ilan.calisma_yeri,gsg('sehir',ilan.calisma_yeri),'Tüm Türkiye') calisma_yeri_ad, ilan.calisma_yeri, position(',' in ilan.calisma_yeri) as sehir_sayi";
        $this->_order_by();

        if (isset($_SESSION['aday'])) {
            $this->query_outer = ' left outer join takip ti on(ilan.id=ti.ref_id and ti.aday_id=' . $_SESSION['aday']['id'] . ' and ti.tip=' . site::I_ILAN_TAKIP . ') ';
            $this->query_outer .= ' left outer join takip tf on(ilan.firma_id=tf.ref_id and tf.aday_id=' . $_SESSION['aday']['id'] . ' and tf.tip=' . site::I_ISVEREN_TAKIP . ') ';
            $this->query_cols .= ',ti.id as takipteki_ilan,tf.id as takipteki_firma';
        }

        if ($p->hanahtar) $p->anahtar[] = $p->hanahtar;
        if ($p->hsehir) $p->sehir[] = $p->hsehir;

        if ($p->anahtar) {
            $anahtar = implode(' ', $p->anahtar);
            $baslikta_ara = $p->anahtar_baslikta == 'on' ? '' : ',nitelik,is_tanimi';
            $query_where[] = "MATCH(pozisyon_adi" . $baslikta_ara . ") AGAINST ('*" . $anahtar . "*' in boolean mode)";
            $this->query_cols .= ", MATCH(pozisyon_adi" . $baslikta_ara . ") AGAINST ('*" . $anahtar . "*' in boolean mode) as score";
            $this->query_order = "score DESC, " . $this->query_order;
        }

        if ($p->ilanno) {
            $query_where[] = 'id in(' . implode(',', $p->ilanno) . ')';
        }

        if ($p->tarih) {
            $p->tarih = is_array($p->tarih) ? $p->tarih[0] : $p->tarih;

            $query_where[] = $p->tarih == 'g0' ? "tarih_yayin>'" . $_SESSION['aday']['tarih_son_oturum'] . "'" :
                'tarih_yayin>now() - interval ' . substr($p->tarih, 1, strlen($p->tarih)) . ' ' . ($p->tarih[0] == 'g' ? 'day' : 'hour');

        }

        if ($p->sehir || $p->ulke) {
            $yer = $p->sehir && $p->ulke ? array_merge($p->sehir, $p->ulke) : $p->sehir ? $p->sehir : $p->ulke;
            if (!($p->diger && in_array('yerel', $p->diger))) $yer[] = 0;
            $query_where[] = "(find_in_set(" . implode(",calisma_yeri) OR find_in_set(", $yer) . ",calisma_yeri))";
        } elseif (($p->diger && in_array('yerel', $p->diger))) {
            $yerel_arama = true;
        }

        if ($p->sektor) {
            $query_where[] = "(find_in_set(" . implode(",sektor) OR find_in_set(", $p->sektor) . ",sektor))";

        }

        if ($p->pozisyon) {
            $query_where[] = "(find_in_set(" . implode(",pozisyon) OR find_in_set(", $p->pozisyon) . ",pozisyon))";
        }

        if ($p->isalani) {
            $query_where[] = "(find_in_set(" . implode(",is_alani) OR find_in_set(", $p->isalani) . ",is_alani))";
        }

        if ($p->pozisyon_tip_id) $query_where[] = " pozisyon_tipi in('" . implode("','", $p->pozisyon_tip_id) . "')";
        if ($p->pozisyon_seviye_id) $query_where[] = " pozisyon_seviyesi in('" . implode("','", $p->pozisyon_seviye_id) . "')";
        if ($p->egitim) $query_where[] = "(find_in_set(" . implode(",egitim_seviyesi) OR find_in_set(", $p->egitim_id) . ",egitim_seviyesi))";
        if ($p->tecrube) $query_where[] = " tecrube=" . $p->tecrube[0];
        if ($p->cinsiyet) $query_where[] = " cinsiyet=" . $p->cinsiyet[0];
        if ($p->ucret) $query_where[] = " ucret>=" . $p->ucret;
        if ($p->firma_adi) $query_where[] = "MATCH(firma_adi) AGAINST ('*" . $p->firma_adi . "*' in boolean mode)";

        $this->query_where = ($query_where ? implode(' AND ', $query_where) : ' 1=1 ');

        if ($p->diger) {
            foreach ($p->diger as $a) {
                if ($a == site::I_ILAN_TAKIP) {
                    $this->query_where = ' 1=1 having takipteki_ilan is not null';
                } elseif ($a == site::I_ISVEREN_TAKIP) {
                    $this->query_where = ' 1=1 having takipteki_firma is not null';
                } elseif ($a == site::I_ILAN_INCELENEN) {
                    $this->query_outer .= ' left outer join incelenen_ilan ii on(ilan.id=ii.ilan_id and ';
                    $this->query_outer .= $_SESSION['aday']['id'] ? ' ii.aday_id=' . $_SESSION['aday']['id'] . ')' : " ii.session_id='" . session_id() . "')";
                    $this->query_cols .= ',ii.id as inceledim';
                    $this->query_where = ' 1=1 group by ilan.id having inceledim is not null';
                }
                $p->diger_baslik[] = site::$secenek_diger[$a];
            }

        }

        if ($form) $this->prepare_form();
    }

    function prepare_form() {
        $p = &$this->p;

        if ($p->anahtar) $this->_add2form('Anahtar', 'anahtar', 'anahtar[]', $p->anahtar, $p->anahtar);
        if ($p->pozisyon) $this->_add2form('Pozisyon', 'pozisyon', 'pozisyon[]', $p->pozisyon);
        if ($p->sehir) $this->_add2form('Şehir', 'sehir', 'sehir[]', $p->sehir);
        if ($p->sektor) $this->_add2form('Sektör', 'sektor', 'sektor[]', $p->sektor);
        if ($p->tarih) $this->_add2form('Tarih', 'tarih', 'tarih[]', $p->tarih, self::$tarihler[$p->tarih]);
        if ($p->egitim) $this->_add2form('Eğitim', 'egitim', 'egitim[]', $p->egitim);
        if ($p->tecrube) $this->_add2form('Tecrübe', 'tecrube', 'tecrube[]', $p->tecrube);
        if ($p->cinsiyet) $this->_add2form('Cinsiyet', 'cinsiyet', 'cinsiyet[]', $p->cinsiyet, site::$secenek_cinsiyet[$p->cinsiyet[0]]);
        if ($p->diger) $this->_add2form('Diğer', 'diger', 'diger[]', $p->diger, $p->diger_baslik);
    }

    function _add2form($title, $type, $name, $value, $baslik = '') {
        global $db;

        if ($value) {
            $value = is_array($value) ? $value : array($value);

            foreach ($value as $i => $v) {
                if ((is_array($baslik) && ($b = $baslik[$i])) || ($b = $baslik) || ($b = $db->sorgu("select gs('%s')", $v)->sonuc(0))) {
                    $this->_form[] = '<div title="' . $title . '" type="' . $type . '"><a id="sil">x</a> ' . $b . '<input type="hidden" value="' . $v . '" name="' . $type . '[]"></div>';
                } else {
                    echo "hata";
                }
            }
        }
    }

    public function get_query($limit = '') {
        return sprintf($this->query, $this->query_cols, $this->query_outer, $this->query_where . " ORDER BY " . $this->query_order . " " . $limit);
    }

    public function get_query_for_count() {
        return sprintf($this->query, 'count(ilan.id)', $this->query_outer, $this->query_where);
    }

    public function get_html() {
        global $site;

        if ($this->p->pozisyon_id) {
            $pozs = $site->db->sorgu("select * from secenek where tip='pozisyon' and id in('%s') order by ad", implode("','", $this->p->pozisyon_id))->liste();
            $pozisyonlar = imprintf($pozs, '<option value="{id}" selected>{ad}</option>');
        }

        return '
        <div id="arama" class="aramafitresi">
            <form id="frm_arama" >
                <div id="akilli_arama">
	                <div class="holder">
	                    <div id="filter">
	                        <span class="placeholder">Akıllı aramayı başlatmak için birkaç harf giriniz...</span>
	                        ' . ($this->_form ? implode('', $this->_form) : '') . '
	                        <input type="text" name="in">
	                    </div>  
                    </div>  
                    <input type="submit" class="btn2 right" value="İş Bul" id="ara" name="ara">
                    <div class="gelismis">
                        <div class="iconlar gizli">
                            <a class="tag" href="#">#tarih</a>
                            <a class="tag" href="#">#egitim</a>
                            <a class="tag" href="#">#tecrübe</a>
                            <a class="tag" href="#">#cinsiyet</a>
                            <a class="command" href="#" title="Takip Ettiğim İlanlar" value="' . site::I_ILAN_TAKIP . '" tip="diger">#ilantakip</a>
                            <a class="command" href="#" title="Takip Ettiğim Firmaların İlanları" value="' . site::I_ISVEREN_TAKIP . '" tip="diger">#firmatakip</a>
                            <a class="command" href="#" title="İncelediğim İlanlar" value="' . site::I_ILAN_INCELENEN . '" tip="diger">#incelediklerim</a>
                            <a class="command" href="#" title="Genel İlanları Gösterme" value="yerel" tip="diger">#yerel</a>
                        </div>
                        <a href="#" class="ipucu">Arama İpuçları</a>
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript" src="/static/filtre2.js"></script>';

    }
}