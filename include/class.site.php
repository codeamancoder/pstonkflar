<?php

class site {
    public $db = null;
    public $title = '';
    public $html = '';
    public $relimg = '';
    public $menu;
    public $menu_login;
    public $ana_sayfa;
    public $files;
    public $template = '/tpl.index.php';
    public $bo_connect = '';

    const KAT_HABER = 0;
    const KAT_YENILIK = 1;
    const KAT_TEST = 2;
    const KAT_LIFESTYLE = 3;
    const KAT_KAMPANYA = 4;
    const KAT_MOTOR = 5;
    const KAT_MODIFIYE = 6;
    const KAT_DIE = 7;
    const KAT_CEVRECI = 8;
    const KAT_DUYURU = 9;
    const KAT_MAKALE = 10;
    const KAT_SEKTOREL = 11;

    const REKLAM_SAG_UST = 0;
    const REKLAM_SAG_ORTA_UST = 5;
    const REKLAM_ANA_ORTA = 1;
    const REKLAM_IKINCI_EL_BANNER = 2;
    const REKLAM_ANA_UST = 3;
    const REKLAM_MANSET_UST = 4;
    const REKLAM_IKINCI_EL_SOL = 6;

    const U_UYE = 0;
    const U_YAZAR = 1;
    const U_ADMIN = 2;
    const U_KURUM = 3;

    const P_KATEGORI = 'kategori';
    const P_YAKIT = 'yakit';
    const P_VITES = 'vites';
    const P_RENK = 'renk';
    const P_KASA = 'kasa';
    const P_MOTOR_HACMI = 'motor_hacmi';
    const P_MOTOR_GUCU = 'motor_gucu';
    const P_CEKIS = 'cekis';
    const P_PLAKA = 'plaka';
    const P_GUVENLIK = 'guvenlik';
    const P_IC_DONANIM = 'ic_donanim';
    const P_DIS_DONANIM = 'dis_donanim';
    const P_MULTIMEDIA = 'multimedia';
    const P_BOYALI_PARCA = 'boyali_parca';
    const P_DEGISEN_PARCA = 'degisen_parca';

    const P_MOTOR_MOTOR_HACMI = 'motor_motor_hacmi';
    const P_MOTOR_MOTOR_GUCU = 'motor_motor_gucu';
    const P_SILINDIR_SAYISI = 'silindir_sayisi';
    const P_MOTOR_GUVENLIK = 'motor_guvenlik';
    const P_MOTOR_AKSESUAR = 'motor_aksesuar';

    const P_KAPI = 'kapi';
    const P_ARAC_CINSI = 'arac_cinsi';
    const P_VAN_KASA = 'van_kasa';

    static $public_functions = array('uye/login', 'uye/unuttum', 'uye/yeni', 'uye/fotograf/save', 'uye/aktivasyon', 'uye/eposta', 'uye/ilan_form');

    static $fiyatlar = array(
        20000 => array(
            'yayin' => array('İlan Yayınlama Ücreti', 17.47),
            'vitrin_ana' => array('Anasayfa Vitrini', 149),
            'vitrin_kategori' => array('Kategori Vitrini', 59),
            'dusen' => array('Fiyatı Düşenler', 19),
            'vitrin_ara' => array('Detaylı Arama Vitrini', 29),
            'acil' => array('Acil Acil', 29)),
        20001 => array(
            'vitrin_ana' => array('Anasayfa Vitrini', 79),
            'vitrin_kategori' => array('Kategori Vitrini', 29),
            'dusen' => array('Fiyatı Düşenler', 19),
            'vitrin_ara' => array('Detaylı Arama Vitrini', 4.99),
            'acil' => array('Acil Acil', 29)),
        20002 => array(
            'vitrin_ana' => array('Anasayfa Vitrini', 79),
            'vitrin_kategori' => array('Kategori Vitrini', 29),
            'dusen' => array('Fiyatı Düşenler', 19),
            'vitrin_ara' => array('Detaylı Arama Vitrini', 4.99),
            'acil' => array('Acil Acil', 29)),
        1 => array(
            'magaza1' => array('6 Aylık Mağaza', 499),
            'magaza2' => array('12 Aylık Mağaza', 799))
    );

    static $kategoriler = array(
        site::KAT_HABER => 'Haberler',
        site::KAT_SEKTOREL => 'Sektörel',

        site::KAT_YENILIK => 'Yenilikler',
        site::KAT_TEST => 'Test',
        site::KAT_LIFESTYLE => 'Life Style',
        site::KAT_KAMPANYA => 'Kampanyalar',
        site::KAT_MOTOR => 'Motorsporları',
        site::KAT_MODIFIYE => 'Modifiye',
        site::KAT_DIE => 'Model Otomobiller',
        site::KAT_CEVRECI => 'Çevreci Otomobiller',
        site::KAT_DUYURU => 'Duyurular',
        site::KAT_MAKALE => 'Makaleler'
    );

    static $reklamlar = array(
        site::REKLAM_SAG_UST => 'Sağ Üst - 340x285',
        site::REKLAM_SAG_ORTA_UST => 'Sağ Orta Üst - 340x285',
        site::REKLAM_ANA_ORTA => 'Orta Blok Geniş - 732x92',
        site::REKLAM_IKINCI_EL_BANNER => '2.El Vitrin Üstü - 730x250',
        site::REKLAM_ANA_UST => 'Üst Reklam - 450x75',
        site::REKLAM_MANSET_UST => 'Manşet Üstü - 990x95',
        site::REKLAM_IKINCI_EL_SOL => 'İkinci El Sol - 230x200'
    );

    static $yayin_durum = array(0 => 'Bekliyor', 1 => 'Yayında', '2' => 'Süresi Sona Erdi', '10' => 'Satıldı', '11' => 'Satıştan Vazgeçildi', '12' => 'Satıldı');

    static $kimden = array(1 => 'Sahibinden', 2 => 'Galeriden');
    static $takas = array(1 => 'Evet', 2 => 'Hayır');
    static $garanti = array(1 => 'Var', 2 => 'Yok');

    public $reklam_ust;

    public $_top_links = array(
        'herkes' => array('ana' => 'Ana Sayfa', 'blog/haberler' => 'Haberler', 'blog/sektorel' => 'Sektörel', 'blog/yenilikler' => 'Yenilikler', 'blog/test' => 'Test', 'blog/motorspor' => 'Motorsporları', 'blog/modifiye' => 'Modifiye', 'blog/lifestyle' => 'Life Style', 'blog/diecast' => 'Model Otomobiller', 'blog/galeriler' => 'Galeri', 'blog/videolar' => 'Video')
    );

    // Sanal Magazayı Kapattık Kodu Aşağıda
    // 'magaza'=>'Sanal Mağaza'

    function site() {
        global $db;

        $this->db = $db;
    }

    function add_title($title) {
        $this->title .= ' - ' . $title;
    }

    function add_relimg($src = '', $title = '', $aciklama = '') {
        $this->relimg = '<link rel="image_src" type="image/jpeg" href="https://www.pistonkafalar.com' . $src . '"/>
                         <meta property="og:title" content="' . $title . '" />
                         <meta property="og:description" content="' . $aciklama . '" />
                         <meta property="og:image" content="http://www.pistonkafalar.com' . $src . '" />
                         <meta property="og:image:secure_url" content="https://www.pistonkafalar.com' . $src . '" />';
    }

    function get_ozellik_ul($n, &$p) {
        $o = '';
        $vals = $this->db->sorgu("select * from params where cat='%s' order by val", $n)->listeObj();
        $oz = explode(',', $p);
        $oz[] = 0;

        foreach ($vals as $a) {
            $o .= array_search($a->id, $oz) !== false ? '<li><i class="icon-ok"></i> ' . $a->val . '</li>' : '<li class="muted">' . $a->val . '</li>';
        }

        $p = '<ul>' . $o . '</ul>';
    }

    function get_param($id) {
        return $this->db->sorgu("select * from params where id=%d", $id)->satirObj();
    }

    function get_uye($id) {
        return $this->db->sorgu("select uye.*,magaza.magaza_adi,magaza.aciklama,magaza.id as magaza_id from uye left outer join magaza on(uye.magaza_id=magaza.id) where uye.id=%d", $id)->satirObj();
    }

    function has_gallery() {
        return $this->db->sorgu("select count(*) from blog where uye_id=%d and tip='galeri'", $_SESSION['uye']['id'])->sonuc(0);
    }

    function init_menu($b = '') {
        $b = $b ? $b : 'ana';

        foreach ($this->_top_links['herkes'] as $k => $v) {
            $link = $k == 'magaza' ? 'https://magaza.pistonkafalar.com/' : '/index.php?b=' . $k;
            $li[] = '<li ' . ($k == $b ? ' class="active"' : '') . '><a href="' . $link . '">' . $v . '</a></li>';
        }

        $this->ana_sayfa = !$b || $b == 'ana' ? true : false;
        $this->menu = '<ul>' . implode('', $li) . '</ul>';
        //$this->bo_connect = !empty($_SESSION['bo']) ? '<div class="admin-connect"><a href="?b=bo">Yönetim</a> / <a href="?b=bo/logout">Çıkış</a></div>' : '';

        $this->duyuru = $this->db->sorgu("select * from blog where tip='blog' and kategori=%d order by id desc limit 4", site::KAT_DUYURU)->listeObj();

        if ($d = $this->db->sorgu("select * from blog where tip='reklam' and kategori='%d' order by id desc limit 1", self::REKLAM_ANA_UST)->satirObj()) {
            $this->reklam_ust = $d->icerik;
        }

    }

    function init_menu_login($b = '') {
        //$b = $b ? $b : 'ana';

        if ($_SESSION['uye']) {
            if ($_SESSION['uye']) {
                $this->menu_login = 'Hoşgeldiniz, <a href="/index.php?b=uye" >' . $_SESSION['uye']['ad'] . '</a> | <a href="/index.php?b=uye/logout">Çıkış</a><br><br><a href="?b=uye/ilan/yeni" class="btn btn-warning">Hemen İlan Verin</a>';
                //                
            } else {
                $this->menu_login = '';
            }
            return;
        }

        $this->menu_login = '<a href="/index.php?b=uye/login" ><i class="icon-lock"></i> Giriş Yap</a> <a href="/index.php?b=uye/yeni"><i class="icon-user"></i> Üye Ol</a> <br><br><a href="?b=uye/ilan/yeni" class="btn btn-warning">Hemen İlan Verin</a>';

    }

    function create() {
        $site = $this;
        $prefix = '';

        if ($request = getRequest('a')) {
            $requests = getRequests('a');
            $prefix = 'ajax_';
        } else {
            $request = getRequest('b');
            $requests = getRequests('b');
        }

        $requests[0] = $requests[0] ? $requests[0] : 'main';

        $this->init_menu($request);
        $this->init_menu_login($requests);

        $dir = DR . '/controller/' . $requests[0] . '.php';
        if (file_exists($dir)) {
            require_once $dir;
            $controller = new $requests[0];
            $method = $prefix . $requests[1];

            /*
             * oturum açma gereksinimi var mı, yada kullanıcı zaten oturum mum açmaya çalışıyor
             */
            if (method_exists($controller, 'login') && (empty($_SESSION[$requests[0]]) && !in_array($request, self::$public_functions))) {
                $site->html = $controller->login();
            } /*
             * sayfa mı çağrılıyor 
             */
            elseif ($requests[1]) {
                if (method_exists($controller, $method)) {
                    $site->html = $controller->$method(array_slice($requests, 2));
                } else {
                    $site->html = $controller->not_found($method);
                }
            } /*
             * ana sayfa çağrısı
             */
            else {
                $site->html = $controller->index();
            }
        } else {
            $dir = DR . '/controller/main.php';
            require_once $dir;

            $controller = new main;
            $site->html = $controller->index();
        }

        // require DR.'/pages/'.$page.'.php';
        if (!$prefix) require DR . '/view/' . THEME . '/' . $this->template;
    }

    static function get_yetki_editor($yetki = null) {
        foreach (site::$kategoriler as $i => $k) {
            $line .= '<input type="checkbox" name="yetki[' . $i . ']" ' . (self::yetki($i, $yetki) ? 'checked' : '') . '> ' . $k . '<br>';
        }

        return $line;
    }

    static function yetki($islem, $yetki = null) {
        $yetki = $yetki ? $yetki : ($yetki === nul ? array() : $_SESSION['uye']);

        if ($yetki) {
            if ($yetki->tip == 2) return 1;
            else if ($yetki->tip == 1) {
                return in_array($islem, $a = preg_split('/\,/', $yetki->yetki));
            } else return 0;
        } else return 0;
    }

    function kategori_select($p, $sec = '', $ust_id = '', $ilk = '- Seçiniz -', $class = 'issel') {
        $o = '';

        $ust = $ust_id !== '' ? ' and ust_id=' . $ust_id : '';
        if ($liste = $this->db->sorgu("select * from params where cat='%s' $ust", $p)->listeObj()) {
            foreach ($liste as $v) {
                $o .= '<option value="' . $v->id . '" ' . ($sec != '' && ($sec == $v->id) ? 'selected' : '') . ($v->alt_id ? ' alt_id="' . $v->alt_id . '"' : '') . '>' . $v->val . '</option>';
            }

            return '<select class="' . $class . '">' . ($ilk ? '<option value="">' . $ilk . '</option>' : '') . $o . '</select>';

        }
    }

    function kategori_pre_select($sel_id, $cat2 = 0) {
        $out = '';
        while (($ust_id = $this->db->sorgu("select ust_id from params where id=%d", $sel_id)->sonuc(0))) {
            $out = $this->kategori_select(site::P_KATEGORI, $cat2 && $ust_id == 20000 ? $cat2 : $sel_id, $ust_id) . $out;
            $sel_id = $ust_id;
        }

        $out = $this->kategori_select(site::P_KATEGORI, $sel_id, 0) . $out;

        return $out;
    }

    function il_select($il = '', $pre = '- Seçiniz -') {
        if ($liste = $this->db->sorgu("select * from yerler where 1=1 group by il")->liste()) {
            return html::select($liste, 'il', $il, 'il', 'il', '', $pre);
        }
    }

    function ilce_select($il, $ilce = '', $pre = '- Seçiniz -') {
        if ($liste = $this->db->sorgu("select * from yerler where il='%s' group by ilce", $il)->liste()) {
            return html::select($liste, 'ilce', $ilce, 'ilce', 'ilce', '', $pre);
        }
    }

    function set_ayar($key, $val) {
        $this->db->sorgu("insert into ayar(`key`,`val`) values('%s','%s') on duplicate key update `val`='%s'", $key, $val, $val);
    }

    function get_ayar($key) {
        return $this->db->sorgu("select val from ayar where `key`='%s'", $key)->sonuc(0);
    }

    function get_sub_cat_ids($id) {
        static $res;

        $liste = $this->db->sorgu("select p1.* ,p2.id as alt_id from params p1 left outer join params p2 on(p1.id=p2.ust_id) where p1.ust_id=%d group by p1.id", $id)->sozluk('id');

        if ($liste) {
            foreach ($liste as $v) {
                $res[] = $v['id'];

                if ($v['alt_id']) $this->get_sub_cat_ids($v['id']);
            }
        }

        return $res;
    }

    function belde_select($il, $ilce, $belde = '') {
        if ($liste = $this->db->sorgu("select * from yerler where il='%s' and ilce='%s' group by ilce", $il, $ilce)->liste()) {
            return html::select($liste, 'belde', $belde, 'belde', 'belde', '', '- Seçiniz -');
        }
    }

    function get_ilan_for_edit($id) {
        return $this->db->sorgu("select * from ilan where ilan_id=%d %s", $id, $_SESSION['uye']['tip'] == 2 ? '' : ' and uye_id=' . $_SESSION['uye']['id'])->satirObj();
    }

    function get_param_select($p, $sec = '', $ust_id = '', $ilk = '- Seçiniz -', $class = 'issel') {
        $o = '';

        $ust = $ust_id !== '' ? ' and ust_id=' . $ust_id : '';
        $liste = $this->db->sorgu("select * from params where cat='%s' $ust", $p)->listeObj();

        foreach ($liste as $v) {
            $o .= '<option value="' . $v->id . '" ' . ($sec != '' && ($sec == $v->id) ? 'selected' : '') . '>' . $v->val . '</option>';
        }

        return '<select name="p_' . $p . '" class="' . $class . '">' . ($ilk ? '<option value="">' . $ilk . '</option>' : '') . $o . '</select>';
    }

    function get_ozellik_cb($p, $s = '', $ust_id = '') {
        $ust = $ust_id !== '' ? ' and ust_id=' . $ust_id : '';
        $liste = $this->db->sorgu("select * from params where cat='%s' $ust", $p)->listeObj();

        $sec = explode(',', $s);

        foreach ($liste as $i => $v) {
            $c = $s && in_array($v->id, $sec) ? 'checked' : '';
            $o .= '<div class="span3"><label><input type="checkbox" name="p_' . $p . '[]" value="' . $v->id . '" ' . $c . ' id="in_' . $i . '"><small>' . $v->val . '</small></label></div>';
        }

        return $o;
    }

    function get_secenek_multiselect($tip, $secili = '', $max = 0, $filter = 1, $order = 'ad') {
        $liste = $this->db->sorgu("select * from secenek where tip='%s' order by %s", $tip, $order)->liste();
        return html::multiselect($liste, $tip . '_id[]', $secili ? (is_array($secili) ? $secili : preg_split('/,/', $secili)) : null, 'id', 'ad', $filter, false, $max);
    }

    function get_secenek_multiselect_zorunlu($tip, $secili = '', $max = 0, $filter = 1, $order = 'ad') {
        $liste = $this->db->sorgu("select * from secenek where tip='%s' order by %s", $tip, $order)->liste();
        return html::multiselect($liste, $tip . '_id[]', $secili ? (is_array($secili) ? $secili : preg_split('/,/', $secili)) : null, 'id', 'ad', true, false, $max, 'secim');
    }

    static function is_yazar() {
        return ($_SESSION['uye']['tip'] == self::U_YAZAR);
    }

    static function is_admin() {
        return ($_SESSION['uye']['tip'] == self::U_ADMIN);
    }

    static function is_kurum() {
        return ($_SESSION['uye']['tip'] == self::U_KURUM);
    }

    static function is_birey() {
        return ($_SESSION['uye']['tip'] == self::U_UYE);
    }

    static function is_uye() {
        return (($_SESSION['uye']['tip'] == self::U_UYE) || ($_SESSION['uye']['tip'] == self::U_KURUM));
    }
}