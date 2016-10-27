<?php

require DR . '/controller/main.php';

class uye extends controller implements usermanager {

    /*
     * aday ana sayfası
     * 
     * @return string
     */
    function index() {
        $data['uye'] = $_SESSION['uye'];
        $data['message'] = $this->get_message();

        return $this->view('index', $data);
    }

    function ajax_fotograf($req) {
        echo factory::get('dosyalar')->ajax($req[0]);
        exit();
    }

    private function add_etiket($id, $etiket) {
        if ($etiket) {
            foreach (preg_split('/\,/', $_POST['etiket']) as $k) {
                $line[] = sprintf("(%d,'%s')", $id, trim($k));
            }

            $this->db->sorgu("delete from etiket where blog_id=%d", $id);
            $this->db->sorgu("insert into etiket(blog_id,tag) values%s", implode(',', $line));
        }
    }

    function blog($requests = '') {
        if (site::is_uye()) return $this->create_message('Bu sayfaya erişim yetkiniz yoktur.', 'error');

        $tip = $requests[0];
        $tips = array(1 => 'Blog', 3 => 'Sayfa', 4 => 'Yardım');

        if ($requests[0] == 'yeni') {
            $uploader = factory::get('dosyalar', array('ref' => 'manset'));
            $uploader2 = factory::get('dosyalar', array('ref' => 'haber'));

            if ($_POST['btnKaydet']) {
                $id = $this->db->add('blog', array('baslik' => $_POST['baslik'], 'ozet' => $_POST['ozet'], 'icerik' => $_POST['icerik'], 'tarih_yayin' => lifos::db_data_time(), 'link' => lifos::clean_string_for_link($_POST['baslik']), 'kategori' => $_POST['kategori'], 'uye_id' => $_SESSION['uye']['id'], 'tip' => 'blog', 'video' => $_POST['video'] ? $_POST['video'] : ''));
                if ($_POST['etiket']) $this->add_etiket($id, $_POST['etiket']);
                if ($_POST['kategori'] == 2) {
                    $_POST['test']['rating'] = $_POST['rating'];
                    $this->db->set('blog', $id, array('test' => serialize($_POST['test'])));
                }
                $this->add_message('Kaydedildi.', 'success');
                $uploader->configure(array('ref' => 'manset'));
                $uploader->setFileRefId($id);
                $uploader2->configure(array('ref' => 'haber'));
                $uploader2->setFileRefId($id);
                $_REQUEST = null;
                return $this->blog();
            }

            $this->add_navi('Haber Yönetimi', '?b=uye/blog');
            $this->add_navi('Yeni', '#');
            $out .= $this->get_navi();

            $uploader->configure(array('title' => 'Manşet Fotoğrafı Eklemek İçin Tıklayınız', 'type' => 'image', 'ref' => 'manset', 'editable' => 0, 'deletable' => 1, 'sortable' => 0, 'multiple_files' => 0, 'resize' => '640,640', 'crop' => '640,330', 'thumb' => '100,65', 'max_file_size' => '8MB'));
            $uploader2->configure(array('title' => 'Haber Fotoğrafı Eklemek İçin Tıklayınız', 'type' => 'image', 'ref' => 'haber', 'editable' => 0, 'deletable' => 1, 'sortable' => 1, 'multiple_files' => 1, 'resize' => '800,800', 'thumb' => '100,100', 'max_file_size' => '8MB'));
            $uploader->button_width = 360;
            $uploader2->button_width = 360;

            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
    						<tr><td width="100px"><b>Kategori</b></td><td>' . $this->get_kategori_check() . '</td></tr>
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge"></td></tr>
	    					<tr><td><b>Özet</b></td><td> <textarea name="ozet" style="width:98%"></textarea></td></tr>
	    					<tr><td><b>İçerik</b></td><td> <textarea name="icerik" class="ckeditor"></textarea><br></td></tr>
	    					<tr><td><b>Etiket</b></td><td><input type="text" name="etiket" class="input-xxlarge"></td></tr>
	    					<tr><td><b>Video</b></td><td><input type="text" name="video" class="input-small"></td></tr>
	    					<tr><td><b>Fotoğraf</b></td><td>' . $uploader->get_form() . '</td></tr>
    						<tr><td><b></b></td><td>' . $uploader2->get_form() . '</td></tr>
    					</table>
    					<table class="wa test gizli" style="width:100%">
    						<tr><td colspan=2><h3>Test Bilgileri</h3></td></tr>
	    					<tr><td width="100px"><b>Model</b></td><td><input type="text" name="test[model]"></td></tr>
	    					<tr><td><b>Motor</b></td><td><input type="text" name="test[motor]"></td></tr>
	    					<tr><td><b>Şanzıman</b></td><td><input type="text" name="test[sanziman]"></td></tr>
	    					<tr><td><b>Güç</b></td><td><input type="text" name="test[guc]"></td></tr>
	    					<tr><td><b>Tork</b></td><td><input type="text" name="test[tork]"></td></tr>
	    					<tr><td><b>0-100</b></td><td><input type="text" name="test[100]"></td></tr>
	    					<tr><td><b>Max.Hız</b></td><td><input type="text" name="test[hiz]"></td></tr>
	    					<tr><td><b>Ortalama Tük.</b></td><td><input type="text" name="test[ort]"></td></tr>
	    					<tr><td><b>Bagaj Hacmi</b></td><td><input type="text" name="test[bagaj]"></td></tr>
	    					<tr><td><b>Ağırlık</b></td><td><input type="text" name="test[agirlik]"></td></tr>
	    					<tr><td><b>Artıları</b></td><td><input type="text" name="test[arti]"></td></tr>
	    					<tr><td><b>Eksileri</b></td><td><input type="text" name="test[eksi]"></td></tr>
	    					<tr><td><b>Puan</b></td><td>' . lifos::star_rating() . '</td></tr>
    					</table>
    					<table class="wa" style="width:100%">
	    					<tr><td width="100px"></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            $out .= '<script>
    				$(document).ready(function(){
    					$("select[name=kategori]").change(function(){
							if($(this).val()==2) $("table.test").show();
    						else $("table.test").hide();
    					});
    				});
    				</script>';
            return '<div class="span12">' . $out . '</div>';

        } elseif ($requests[0] == 'duzenle') {
            $id = $_REQUEST['id'];
            $uploader = factory::get('dosyalar', array('ref' => 'manset'));
            $uploader2 = factory::get('dosyalar', array('ref' => 'haber'));

            if ($_POST['btnKaydet']) {
                $this->db->set('blog', $id, array('baslik' => $_POST['baslik'], 'ozet' => $_POST['ozet'], 'icerik' => $_POST['icerik'], 'link' => lifos::clean_string_for_link($_POST['baslik']), 'kategori' => $_POST['kategori'], 'video' => $_POST['video'] ? $_POST['video'] : ''));
                if ($_POST['etiket']) $this->add_etiket($id, $_POST['etiket']);
                if ($_POST['kategori'] == 2) {
                    $_POST['test']['rating'] = $_POST['rating'];
                    $this->db->set('blog', $id, array('test' => serialize($_POST['test'])));
                }
                $this->add_message('Kaydedildi.', 'success');
                $uploader->configure(array('ref' => 'manset', 'ref_id' => $id));
                $uploader->setFileRefId($id);
                $uploader2->configure(array('ref' => 'haber'));
                //$uploader2->setFileRefId($id);
                $_REQUEST = null;
                return $this->blog();
            }

            $uploader->configure(array('title' => 'Manşet Fotoğrafı Eklemek İçin Tıklayınız', 'type' => 'image', 'ref' => 'manset', 'ref_id' => $id, 'editable' => 0, 'deletable' => 1, 'sortable' => 0, 'multiple_files' => 0, 'resize' => '730,730', 'crop' => '730,370', 'thumb' => '100,65', 'max_file_size' => '8MB'));
            $uploader2->configure(array('title' => 'Haber Fotoğrafı Eklemek İçin Tıklayınız', 'type' => 'image', 'ref' => 'haber', 'ref_id' => $id, 'editable' => 0, 'deletable' => 1, 'sortable' => 1, 'multiple_files' => 1, 'resize' => '800,800', 'thumb' => '100,100', 'max_file_size' => '8MB'));
            $uploader->button_width = 360;
            $uploader2->button_width = 360;

            $this->add_navi('Haber Yönetimi', '?b=uye/blog');
            $this->add_navi('Düzenle', '#');

            $blog = $this->db->sorgu("select * from blog where id=%d", $id)->satirObj();
            $test = $blog->kategori == 2 ? unserialize($blog->test) : array();

            $etiketler = $this->db->sorgu("select tag from etiket where blog_id=%d", $id)->sozluk('tag', 'tag');
            $out .= $this->get_navi();
            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
    						<tr><td width="100px"><b>Kategori</b></td><td>' . $this->get_kategori_check($blog->kategori) . '</td></tr>
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge" value="' . $blog->baslik . '"></td></tr>
	    					<tr><td><b>Özet</b></td><td> <textarea name="ozet" style="width:98%">' . $blog->ozet . '</textarea></td></tr>
	    					<tr><td><b>İçerik</b></td><td> <textarea name="icerik" class="ckeditor">' . $blog->icerik . '</textarea><br></td></tr>
	    					<tr><td><b>Etiket</b></td><td><input type="text" name="etiket" class="input-xxlarge" value="' . ($etiketler ? implode(',', $etiketler) : '') . '"></td></tr>
	    					<tr><td><b>Video</b></td><td><input type="text" name="video" class="input-small" value="' . $blog->video . '"></td></tr>
	    					<tr><td><b>Fotoğraf</b></td><td>' . $uploader->get_form() . '</td></tr>
	    					<tr><td><b></b></td><td>' . $uploader2->get_form() . '</td></tr>
    					</table>';

            $out .= '<table class="wa test ' . ($blog->kategori == 2 ? '' : 'gizli') . '" style="width:100%">
	    				<tr><td colspan=2><h3>Test Bilgileri</h3></td></tr>
		    			<tr><td width="100px"><b>Model</b></td><td><input type="text" name="test[model]" value="' . $test['model'] . '"></td></tr>
		    			<tr><td><b>Motor</b></td><td><input type="text" name="test[motor]" value="' . $test['motor'] . '"></td></tr>
		    			<tr><td><b>Şanzıman</b></td><td><input type="text" name="test[sanziman]" value="' . $test['sanziman'] . '"></td></tr>
		    			<tr><td><b>Güç</b></td><td><input type="text" name="test[guc]" value="' . $test['guc'] . '"></td></tr>
		    			<tr><td><b>Tork</b></td><td><input type="text" name="test[tork]" value="' . $test['tork'] . '"></td></tr>
		    			<tr><td><b>0-100</b></td><td><input type="text" name="test[100]" value="' . $test['100'] . '"></td></tr>
		    			<tr><td><b>Max.Hız</b></td><td><input type="text" name="test[hiz]" value="' . $test['hiz'] . '"></td></tr>
		    			<tr><td><b>Ortalama Tük.</b></td><td><input type="text" name="test[ort]" value="' . $test['ort'] . '"></td></tr>
		    			<tr><td><b>Bagaj Hacmi</b></td><td><input type="text" name="test[bagaj]" value="' . $test['bagaj'] . '"></td></tr>
		    			<tr><td><b>Ağırlık</b></td><td><input type="text" name="test[agirlik]" value="' . $test['agirlik'] . '"></td></tr>
		    			<tr><td><b>Artıları</b></td><td><input type="text" name="test[arti]" value="' . $test['arti'] . '"></td></tr>
		    			<tr><td><b>Eksileri</b></td><td><input type="text" name="test[eksi]" value="' . $test['eksi'] . '"></td></tr>
		    			<tr><td><b>Puan</b></td><td>' . lifos::star_rating($test['rating']) . '</td></tr>
	    			</table>';

            $out .= '<table class="wa" style="width:100%">
	    					<tr><td width="100px"></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
	    				<input type="hidden" name="id" value="' . $blog->id . '">
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            $out .= '<script>
    				$(document).ready(function(){
    					$("select[name=kategori]").change(function(){
							if($(this).val()==2) $("table.test").show();
    						else $("table.test").hide();
    					});
    				});
    				</script>';
            return '<div class="span12">' . $out . '</div>';

        } elseif (($requests[0] == 'sil') && !site::is_uye()) {
            $this->db->del('blog', $_GET['id']);
            factory::add('dosyalar');
            dosyalar::deleteByRef('manset', $_GET['id']);
            dosyalar::deleteByRef('haber', $_GET['id']);
            $this->add_message('İçerik silindi.', 'success');
            $_REQUEST = null;
        }

        $this->add_navi('Haber Yönetimi', '?b=uye/blog');

        if ($_SESSION['uye']['tip'] == site::U_YAZAR) {
            $where = ' and uye_id=' . $_SESSION['uye']['id'];
        }

        $grid = factory::get('grid');

        $query = "SELECT * FROM blog where tip='blog' $where {filter}";

        $grid->setLink('?b=uye/blog');
        $grid->search->add(array('type' => 'equal', 'name' => 'id', 'title' => 'ID', 'class' => 'w1'));
        $grid->search->add(array('type' => 'listbox', 'name' => 'kategori', 'title' => 'Haber Tipi', 'component' => $this->get_kategori_check($grid->search->get('kategori'), '-- Seçiniz --')));
        $grid->search->add(array('type' => 'like', 'name' => 'baslik', 'title' => 'Başlık'));
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'ID', 'sort' => true, 'width' => '90px', 'search' => true, 'width' => '60'));
        $grid->addCol(array('type' => 'array', 'name' => 'kategori', 'title' => 'Kategori', 'array' => site::$kategoriler, 'sort' => true));
        $grid->addCol(array('type' => 'string', 'name' => 'baslik', 'title' => 'Başlık', 'sort' => true, 'search' => 1, 'width' => '500px'));
        $grid->addCol(array('type' => 'icon', 'name' => 'duz', 'title' => 'Düzenle', 'class' => 'icon-edit', 'link' => '?b=uye/blog/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/blog/sil&id={id}', 'confirm' => 'İçerik silinecek, emin misiniz?'));
        $grid->ifEmpty('Henüz haber yayınlamadınız.');
        $grid->addButton('Yeni Yazı', '?b=uye/blog/yeni');
        $grid->query($query, 'id', 'd');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        $out .= factory::get('js')->ready()->add("
        	$('.icon a[class*=mod-1]').click(function(){
        		var nv = $(this).hasClass('mod-10') ? 1 : 0;
    			$(this).attr('class','mod-1'+nv);
        		$.post('?a=bo/firma_durum',{id:$(this).parent().siblings(':eq(0)').html(),v:nv});
        		return false;
    		});
		")->getAll();

        return '<div class="span12">' . $out . '</div>';
    }

    function sayfa($requests = '') {
        if (!site::is_admin()) return $this->create_message('Bu sayfaya erişim yetkiniz yoktur.', 'error');

        if ($requests[0] == 'yeni') {
            if ($_POST['btnKaydet']) {
                $id = $this->db->add('blog', array('baslik' => $_POST['baslik'], 'icerik' => $_POST['icerik'], 'tarih_yayin' => lifos::db_data_time(), 'link' => lifos::clean_string_for_link($_POST['baslik']), 'uye_id' => $_SESSION['uye']['id'], 'tip' => 'sayfa'));
                $this->add_message('Kaydedildi.', 'success');
                return $this->sayfa();
            }

            $this->add_navi('Sayfa Yönetimi', '?b=uye/sayfa');
            $this->add_navi('Yeni', '#');
            $out .= $this->get_navi();

            $out .= '<br><br><form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge"></td></tr>
	    					<tr><td><b>İçerik</b></td><td> <textarea name="icerik" class="ckeditor"></textarea><br></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';

            return '<div class="span12">' . $out . '</div>';
        } elseif ($requests[0] == 'duzenle') {
            $id = $_REQUEST['id'];
            if ($_POST['btnKaydet']) {
                $this->db->set('blog', $id, array('baslik' => $_POST['baslik'], 'icerik' => $_POST['icerik'], 'tarih_yayin' => lifos::db_data_time(), 'link' => lifos::clean_string_for_link($_POST['baslik']), 'uye_id' => $_SESSION['uye']['id']));
                $this->add_message('Kaydedildi.', 'success');
                $_REQUEST = null;
                return $this->sayfa();
            }

            $this->add_navi('Sayfa Yönetimi', '?b=uye/sayfa');
            $this->add_navi('Düzenle', '#');

            $blog = $this->db->sorgu("select * from blog where id=%d", $id)->satirObj();
            $out .= $this->get_navi();
            $out .= '<br><br><form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge" value="' . $blog->baslik . '"></td></tr>
	    					<tr><td><b>İçerik</b></td><td> <textarea name="icerik" class="ckeditor">' . $blog->icerik . '</textarea><br></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
	    				<input type="hidden" name="id" value="' . $blog->id . '">
    				</form><br><br>';
            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            return '<div class="span12">' . $out . '</div>';

        } elseif ($requests[0] == 'sil') {
            $this->db->del('blog', $_GET['id']);
            $this->add_message('İçerik silindi.', 'success');
            $_REQUEST = null;
        }

        $this->add_navi('Sayfa Yönetimi', '?b=uye/sayfa');

        $grid = factory::get('grid');

        $query = "SELECT * FROM blog where tip='sayfa'";

        $grid->setLink('?b=uye/sayfa');
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'ID', 'sort' => true, 'width' => '90px', 'search' => true, 'width' => '60'));
        $grid->addCol(array('type' => 'string', 'name' => 'baslik', 'title' => 'Başlık', 'sort' => true, 'search' => 1, 'width' => '500px'));
        $grid->addCol(array('type' => 'icon', 'name' => 'duz', 'title' => 'Düzenle', 'class' => 'icon-edit', 'link' => '?b=uye/sayfa/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/sayfa/sil&id={id}', 'confirm' => 'İçerik silinecek, emin misiniz?'));
        $grid->addButton('Yeni Sayfa', '?b=uye/sayfa/yeni');
        $grid->query($query, 'id', 'd');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        return '<div class="span12">' . $out . '</div>';
    }

    function parametre($requests = '') {
        if (!site::is_admin()) return $this->create_message('Bu sayfaya erişim yetkiniz yoktur.', 'error');

        $cat = $_REQUEST['cat'] ? $_REQUEST['cat'] : 0;
        $ust_id = $_REQUEST['ust_id'] ? $_REQUEST['ust_id'] : 0;

        if ($requests[0] == 'yeni') {
            if ($_POST['btnKaydet']) {
                $id = $this->db->add('params', array('val' => $_POST['baslik'], 'cat' => $_POST['cat'] ? $_POST['cat'] : 0, 'ust_id' => $_POST['ust_id'] ? $_POST['ust_id'] : 0, 'sira' => $_POST['sira']));
                $this->add_message('Kaydedildi.', 'success');
                return $this->parametre();
            }

            $this->add_navi('Parametre Yönetimi', '?b=uye/parametre');

            if ($ust_id) {
                $ust = $this->site->get_param($ust_id);
                $cats = $this->kategori_agac_list($ust_id);
                foreach ($cats as $c) $this->add_navi($c->val, '?b=uye/parametre&cat=' . $c->cat . '&ust_id=' . $c->id);
            }

            $out .= $this->get_navi();

            $out .= '<br><br><form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
    						<tr ' . ($cat ? 'style="display:none;"' : '') . '><td><b>Kategori</b></td><td>' . ($cat ? '<input type="hidden" name="cat" value="' . $cat . '">' : html::select($this->db->sorgu('SELECT distinct cat from params order by cat')->liste(), 'cat', 0, 'cat', 'cat')) . '</td></tr>
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge"></td></tr>
	    					<tr><td><b>Sıra</b></td><td><input type="text" name="sira" value="10"></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    					<input type="hidden" name="ust_id" value="' . $ust_id . '">
    				</form><br><br>';

            return '<div class="span12">' . $out . '</div>';
        } elseif ($requests[0] == 'duzenle') {
            $id = $_REQUEST['id'];
            if ($_POST['btnKaydet']) {
                $id = $this->db->set('params', $_REQUEST['id'], array('val' => $_POST['baslik'], 'cat' => $_POST['cat'] ? $_POST['cat'] : 0, 'ust_id' => $_POST['ust_id'] ? $_POST['ust_id'] : 0, 'sira' => $_POST['sira']));
                $this->add_message('Kaydedildi.', 'success');
                return $this->parametre();
            }

            $this->add_navi('Parametre Yönetimi', '?b=uye/parametre');

            $duz = $this->site->get_param($_GET['id']);
            if ($ust_id) {
                $ust = $this->site->get_param($ust_id);
                $cats = $this->kategori_agac_list($ust_id);
                foreach ($cats as $c) $this->add_navi($c->val, '?b=uye/parametre&cat=' . $c->cat . '&ust_id=' . $c->id);
            }

            $out .= $this->get_navi();

            $out .= '<br><br><form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
    						<tr ' . ($cat ? 'style="display:none;"' : '') . '><td><b>Kategori</b></td><td>' . ($cat ? '<input type="hidden" name="cat" value="' . $cat . '">' : html::select($this->db->sorgu('SELECT distinct cat from params order by cat')->liste(), 'cat', 0, 'cat', 'cat')) . '</td></tr>
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge" value="' . $duz->val . '"></td></tr>
	    					<tr><td><b>Sıra</b></td><td><input type="text" name="sira" value="' . $duz->sira . '"></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    					<input type="hidden" name="ust_id" value="' . $ust_id . '">
    					<input type="hidden" name="id" value="' . $_GET['id'] . '">
    				</form><br><br>';

            return '<div class="span12">' . $out . '</div>';

        } elseif ($requests[0] == 'sil') {
            $this->db->del('params', $_GET['id']);
            $this->add_message('Parametre silindi.', 'success');
            $_REQUEST = null;
        }

        $this->add_navi('Parametre Yönetimi', '?b=uye/parametre');

        $grid = factory::get('grid');

        if ($ust_id) {
            $cats = $this->kategori_agac_list($ust_id);
            foreach ($cats as $c) $this->add_navi($c->val, '?b=uye/parametre&cat=' . $c->cat . '&ust_id=' . $c->id);
        }

        $select = html::select($this->db->sorgu('SELECT distinct cat from params order by cat')->liste(), 'cat', $grid->search->get('cat'), 'cat', 'cat', 0, '-- Seçiniz --');

        $query = "SELECT * FROM params where ust_id=" . $ust_id . " " . ($cat ? " and cat='" . $cat . "'" : '') . ' {filter}';

        $grid->setLink('?b=uye/parametre' . ($_GET['ust_id'] ? '&ust_id=' . $_GET['ust_id'] : ''));
        $grid->search->add(array('type' => 'listbox', 'name' => 'kategori', 'title' => 'Haber Tipi', 'component' => $select));
        $grid->search->add(array('type' => 'like', 'name' => 'val', 'title' => 'Başlık'));
        $grid->addCol(array('type' => 'int', 'name' => 'sira', 'title' => 'Sıra', 'sort' => true, 'width' => '60px'));
        $grid->addCol(array('type' => 'link', 'name' => 'val', 'title' => 'Başlık', 'link' => '?b=uye/parametre&ust_id={id}&cat={cat}', 'sort' => true, 'search' => 1, 'width' => '500px'));
        $grid->addCol(array('type' => 'string', 'name' => 'cat', 'title' => 'Kategori', 'sort' => true, 'search' => 1, 'width' => '500px'));
        $grid->addCol(array('type' => 'icon', 'name' => 'duz', 'title' => 'Düzenle', 'class' => 'icon-edit', 'link' => '?b=uye/parametre/duzenle&id={id}&ust_id={ust_id}&cat={cat}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/parametre/sil&id={id}&ust_id={ust_id}&cat={cat}', 'confirm' => 'Parametre ve ona bağlı tüm parametreler silinecek, emin misiniz?'));
        $grid->addButton('Yeni Parametre', '?b=uye/parametre/yeni' . ($cat ? '&cat=' . $cat : '') . ($ust_id ? '&ust_id=' . $ust_id : ''));
        $grid->query($query, 'val');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        return '<div class="span12">' . $out . '</div>';
    }

    function reklam($requests = '') {
        if (!site::is_admin()) return $this->create_message('Bu sayfaya erişim yetkiniz yoktur.', 'error');

        if ($requests[0] == 'yeni') {
            if ($_POST['btnKaydet']) {
                $id = $this->db->add('blog', array('baslik' => $_POST['baslik'], 'icerik' => $_POST['icerik'], 'tarih_yayin' => lifos::db_data_time(), 'tip' => 'reklam', 'kategori' => $_POST['tip'], 'onay' => $_POST['kategori'] ? $_POST['kategori'] : 0));
                $this->add_message('Kaydedildi.', 'success');
                return $this->reklam();
            }

            $this->add_navi('Reklam Yönetimi', '?b=uye/reklam');
            $this->add_navi('Yeni', '#');
            $out .= $this->get_navi();

            $out .= '<br><br><form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" ></td></tr>
	    					<tr><td><b>Tip</b></td><td>' . $this->_get_reklam_tip_select() . '</td></tr>
	    					<tr class="gizli"><td><b>Kategori</b></td><td>' . $this->_get_reklam_kategori_select() . '</td></tr>
	    					<tr><td><b>İçerik</b></td><td> <textarea class="ckeditor" name="icerik"></textarea><br></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';
            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            $out .= factory::get('js')->ready()->add("
					$('select[name=tip]').change(function(){
    					if($(this).val()==2) $(this).parent().parent().next().removeClass('gizli');
    					else $(this).parent().parent().next().addClass('gizli');
    				});
    				")->getAll();

            return '<div class="span12">' . $out . '</div>';
        } elseif ($requests[0] == 'duzenle') {
            $id = $_REQUEST['id'];
            if ($_POST['btnKaydet']) {
                $this->db->set('blog', $id, array('baslik' => $_POST['baslik'], 'icerik' => $_POST['icerik'], 'tarih_yayin' => lifos::db_data_time(), 'kategori' => $_POST['tip'], 'onay' => $_POST['kategori'] ? $_POST['kategori'] : 0));
                $this->add_message('Kaydedildi.', 'success');
                $_REQUEST = null;
                return $this->reklam();
            }

            $this->add_navi('Reklam Yönetimi', '?b=uye/reklam');
            $this->add_navi('Düzenle', '#');

            $blog = $this->db->sorgu("select * from blog where id=%d", $id)->satirObj();
            $blog_detay = unserialize($blog->ozet);

            $out .= $this->get_navi();
            $out .= '<br><br><form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" value="' . $blog->baslik . '" ></td></tr>
	    					<tr><td><b>Tip</b></td><td>' . $this->_get_reklam_tip_select($blog->kategori) . '</td></tr>
    						<tr class="' . ($blog->kategori == 2 ? '' : 'gizli') . '"><td><b>Kategori</b></td><td>' . $this->_get_reklam_kategori_select($blog->onay) . '</td></tr>
	    					<tr><td><b>İçerik</b></td><td> <textarea class="ckeditor" name="icerik">' . $blog->icerik . '</textarea><br></td></tr>
    						<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
	    				<input type="hidden" name="id" value="' . $blog->id . '">
    				</form><br><br>';
            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            return '<div class="span12">' . $out . '</div>';

        } elseif ($requests[0] == 'sil') {
            $this->db->del('blog', $_GET['id']);
            $this->add_message('İçerik silindi.', 'success');
            $_REQUEST = null;
        }

        $this->add_navi('Reklam Yönetimi', '?b=uye/reklam');

        $grid = factory::get('grid');

        $query = "SELECT b.*,p.val FROM blog b left outer join params p on(b.onay=p.id) where b.tip='reklam' {filter}";

        $grid->setLink('?b=uye/reklam');
        $grid->search->add(array('type' => 'equal', 'name' => 'id', 'title' => 'ID', 'prefix' => 'isveren', 'class' => 'w1'));
        $grid->search->add(array('type' => 'equal', 'name' => 'firma_ad', 'title' => 'Firma Adı', 'prefix' => 'isveren'));
        $grid->search->add(array('type' => 'equal', 'name' => 'sehir', 'title' => 'Şehir', 'prefix' => 'isveren'));
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'ID', 'sort' => true, 'width' => '90px', 'search' => true, 'width' => '60'));
        $grid->addCol(array('type' => 'array', 'name' => 'kategori', 'title' => 'Tip', 'width' => '120px', 'array' => site::$reklamlar));
        $grid->addCol(array('type' => 'string', 'name' => 'baslik', 'title' => 'Başlık', 'sort' => true, 'search' => 1, 'width' => '500px'));
        $grid->addCol(array('type' => 'string', 'name' => 'val', 'title' => 'Kategori', 'sort' => true, 'search' => 1));
        $grid->addCol(array('type' => 'icon', 'name' => 'duz', 'title' => 'Düzenle', 'class' => 'icon-edit', 'link' => '?b=uye/reklam/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/reklam/sil&id={id}', 'confirm' => 'İçerik silinecek, emin misiniz?'));
        $grid->addButton('Yeni Reklam', '?b=uye/reklam/yeni');
        $grid->query($query, 'id', 'd');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        return '<div class="span12">' . $out . '</div>';
    }

    function ayar($requests = '') {
        if (!site::is_admin()) return $this->create_message('Bu sayfaya erişim yetkiniz yoktur.', 'error');

        $this->add_navi('Ayarlar', '?b=uye/ayar');

        if ($_POST['btnKaydet']) {
            foreach ($_POST['fr'] as $k => $v) {
                $this->site->set_ayar($k, $v);
            }
            $this->add_message('Ayarlar Kaydedildi.', 'success');
            //return $this->reklam();
        }

        $out .= $this->get_navi();

        $out .= '<br>' . $this->get_message() . '<br><form method="post">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Sağ Üst Galeri ID </b></td><td><input type="text" name="fr[ana_sayfa_galeri]" value="' . $this->site->get_ayar('ana_sayfa_galeri') . '"></td></tr>
	    					<tr><td><b>Sağ Orta Galeri ID </b></td><td><input type="text" name="fr[ana_sayfa_galeri2]" value="' . $this->site->get_ayar('ana_sayfa_galeri2') . '"></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';
        return '<div class="span12">' . $out . '</div>';
    }

    private function _get_reklam_tip_select($id = null) {
        foreach (site::$reklamlar as $i => $r) {
            $opt .= '<option value="' . $i . '" ' . ($id == $i ? 'selected' : '') . '>' . $r . '</option>';
        }
        return '<select name="tip">' . $opt . '</select>';
    }

    private function _get_reklam_kategori_select($id = null) {
        factory::get('ilan', '', '/controller');

        foreach (ilan::$vitrinler as $i) {
            $opt .= '<option value="' . $i . '" ' . ($id == $i ? 'selected' : '') . '>' . $this->site->get_param($i)->val . '</option>';
        }
        return '<select name="kategori"><option value="0">Ana Vitrin</option>' . $opt . '</select>';
    }

    function hesabim($requests = '') {
        if ($_POST['btnKaydet']) {

            $this->db->set('uye', $_SESSION['uye']['id'], array('ad' => $_POST['ad'], 'tel' => $_POST['tel'], 'sehir' => $_POST['sehir'], 'cinsiyet' => $_POST['cinsiyet'], 'tel2' => $_POST['tel2'], 'tel3' => $_POST['tel3']));
            $this->add_message('Üyelik bilgileriniz güncellendi.', 'success');

            if ($_POST['sifre1']) {
                if ($_POST['sifre1'] == $_POST['sifre2']) {
                    if (strlen($_POST['sifre1']) > 5) {
                        $this->db->set('uye', $_SESSION['uye']['id'], array('sifre' => md5($_POST['sifre1'])));
                        $this->add_message('Şifreniz değiştirildi.', 'success');
                    } else $this->add_message('Şifreniz değiştirildi.', 'error');
                } else $this->add_message('Şifreniz uyuşmuyor.', 'error');
            }
        }

        $this->add_navi('Hesabım', '#');
        $out .= $this->get_navi();
        $sehirler = $this->db->sorgu('SELECT il FROM yerler group by il order by il')->liste();
        $uye = $this->db->sorgu("select * from uye where id=%d", $_SESSION['uye']['id'])->satirObj();

        $out .= '<form method="post">
    					<div class="form2 connect " style="padding:10px;">
    					' . $this->get_message() . '
				        <div>
				            <label for="tadi">Adınız ve Soyadınız*</label>
				            <input type="text" name="ad" valid="text" class="intext" value="' . $uye->ad . '">
				        </div>
			
				        <div>
				            <label for="teposta">E-Posta Adresiniz*</label>
				            <input id="teposta" type="text" name="eposta" valid="email" class="intext" value="' . $uye->eposta . '" disabled>
				        </div>
				        <div>
				            <label for="tsifre1">Şifreniz*</label>
				            <input id="tsifre1" type="password" name="sifre1" valid="text" class="intext">
				        </div>
				        <div>
				            <label for="tsifre2">Şifreniz Tekrar*</label>
				            <input id="tsifre2" type="password" name="sifre2" valid="text" class="intext">
				        </div>
				        <div>
				            <label for="ttel">Cep Telefonu</label>
				            <input id="ttel" type="text" name="tel" class="intext tel" value="' . $uye->tel . '">
				        </div>
				        <div>
				            <label for="ttel2">Ev Telefonu</label>
				            <input id="ttel2" type="text" name="tel2" class="intext tel" value="' . $uye->tel2 . '">
				        </div>
				        <div>
				            <label for="ttel3">İş Telefonu</label>
				            <input id="ttel3" type="text" name="tel3" class="intext tel" value="' . $uye->tel3 . '">
				        </div>
				        <div>
				            <label for="tsehir">Şehir</label>
				            ' . html::select($sehirler, 'sehir', $uye->sehir, 'il', 'il', 0, '- Seçiniz -') . '
				        </div>
			
				        <div>
				            <label for="ttel">Cinsiyet</label>
				            <input type="radio" name="cinsiyet" value="0" ' . ($uye->cinsiyet == 0 ? 'checked' : '') . '> Kadın
				            <input type="radio" name="cinsiyet" value="1" ' . ($uye->cinsiyet == 1 ? 'checked' : '') . '> Erkek
				        </div><br>
				        <div style="clear:both;">
				            <input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"> 
				        </div>
				    </div>
    				</form><br><br>';

        $out .= '<script type="text/javascript" src="/static/' . THEME . '/js/jquery.mask.min.js"></script>
    				<script>
    				$(document).ready(function(){
    					$(".tel").mask("9 (999) 999 99 99");
    				});
    				</script>';

        return '<div class="span12">' . $out . '</div>';

    }

    function video($requests = '') {
        if (!site::is_admin()) return $this->create_message('Bu sayfaya erişim yetkiniz yoktur.', 'error');

        $tip = $requests[0];

        if ($requests[0] == 'yeni') {
            $uploader2 = factory::get('dosyalar', array('ref' => 'manset'));

            if ($_POST['btnKaydet']) {
                $id = $this->db->add('blog', array('baslik' => $_POST['baslik'], 'ozet' => $_POST['src'], 'icerik' => $_POST['icerik'], 'tarih_yayin' => lifos::db_data_time(), 'link' => lifos::clean_string_for_link($_POST['baslik']), 'uye_id' => $_SESSION['uye']['id'], 'tip' => 'video'));
                $this->add_message('Kaydedildi.', 'success');
                $uploader2->configure(array('ref' => 'manset'));
                $uploader2->setFileRefId($id);

                return $this->video();
            }

            $uploader2->configure(array('title' => 'Manşet Fotoğrafı Eklemek İçin Tıklayınız', 'type' => 'image', 'ref' => 'manset', 'editable' => 0, 'deletable' => 1, 'sortable' => 0, 'multiple_files' => 0, 'resize' => '640,640', 'crop' => '640,330', 'thumb' => '100,65', 'max_file_size' => '8MB'));
            $uploader2->button_width = 360;

            $this->add_navi('Video Yönetimi', '?b=uye/video');
            $this->add_navi('Yeni', '#');
            $out .= $this->get_navi();

            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge"></td></tr>
	    					<tr><td><b>Video Kodu</b></td><td><input type="text" name="src"></td></tr>
	    					<tr><td><b></b></td><td class="video">Youtube kodunu yükleyiniz</td></tr>
    						<tr><td><b>Ek İçerik</b></td><td> <textarea name="icerik" class="ckeditor"></textarea><br></td></tr>
    						<tr><td><b>Manşet</b></td><td>' . $uploader2->get_form() . '</td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            //$out .= factory::get('js')->ready()->add(" $('input[name=src]').keyup(function(){ $('td.video').html('<img src=\"http://img.youtube.com/vi/'+$(this).val()+'/hqdefault.jpg\">'); }); ")->getAll();

            return '<div class="span12">' . $out . '</div>';

        } /*
    	 * video düzenle
    	 */
        elseif ($requests[0] == 'duzenle') {
            $id = $_REQUEST['id'];

            $uploader2 = factory::get('dosyalar', array('ref' => 'manset'));
            $uploader2->configure(array('title' => 'Manşet Fotoğrafı Eklemek İçin Tıklayınız', 'type' => 'image', 'ref' => 'manset', 'ref_id' => $id, 'editable' => 0, 'deletable' => 1, 'sortable' => 0, 'multiple_files' => 0, 'resize' => '640,640', 'crop' => '640,330', 'thumb' => '100,65', 'max_file_size' => '8MB'));
            $uploader2->button_width = 360;

            if ($_POST['btnKaydet']) {
                $this->db->set('blog', $id, array('baslik' => $_POST['baslik'], 'ozet' => $_POST['src'], 'icerik' => $_POST['icerik'], 'tarih_yayin' => lifos::db_data_time(), 'link' => lifos::clean_string_for_link($_POST['baslik'])));
                $this->add_message('Kaydedildi.', 'success');
                $uploader2->configure(array('ref' => 'manset'));
                $uploader2->setFileRefId($id);

                $_REQUEST = null;
                return $this->video();
            }

            $this->add_navi('Video Yönetimi', '?b=uye/video');
            $this->add_navi('Düzenle', '#');

            $blog = $this->db->sorgu("select * from blog where id=%d", $id)->satirObj();
            $out .= $this->get_navi();
            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge" value="' . $blog->baslik . '"></td></tr>
	    					<tr><td><b>Video Kodu</b></td><td><input type="text" name="src" value="' . $blog->ozet . '"></td></tr>
	    					<tr><td><b>Ek İçerik</b></td><td> <textarea name="icerik" class="ckeditor">' . $blog->icerik . '</textarea><br></td></tr>
    						<tr><td><b>Manşet</b></td><td>' . $uploader2->get_form() . '</td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
	    				<input type="hidden" name="id" value="' . $blog->id . '">
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            //$out.= factory::get('js')->ready()->add(" $('input[name=src]').keyup(function(){ $('td.video').html('<img src=\"http://img.youtube.com/vi/'+$(this).val()+'/hqdefault.jpg\">'); }); ")->getAll();

            return '<div class="span12">' . $out . '</div>';

        } /*
    	 * video sil
    	 */
        elseif ($requests[0] == 'sil') {
            $this->db->del('blog', $_GET['id']);
            $this->add_message('Video silindi.', 'success');
            $_REQUEST = null;
        }

        /*
    	 * video listesi
    	 */
        $this->add_navi('Video Yönetimi', '?b=uye/video');

        $grid = factory::get('grid');

        $query = "SELECT * FROM blog where tip='video'";

        $grid->setLink('?b=uye/video');
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'ID', 'sort' => true, 'width' => '90px', 'search' => true, 'width' => '60'));
        $grid->addCol(array('type' => 'string', 'name' => 'baslik', 'title' => 'Başlık', 'sort' => true, 'search' => 1, 'width' => '500px'));
        $grid->addCol(array('type' => 'icon', 'name' => 'duz', 'title' => 'Düzenle', 'class' => 'icon-edit', 'link' => '?b=uye/video/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/video/sil&id={id}', 'confirm' => 'Video silinecek, emin misiniz?'));
        $grid->addButton('Yeni Video', '?b=uye/video/yeni');
        $grid->query($query, 'id', 'd');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        return '<div class="span12">' . $out . '</div>';
    }

    function yorum($requests = '') {
        if (!site::is_admin()) return $this->create_message('Bu sayfaya erişim yetkiniz yoktur.', 'error');

        $tip = $requests[0];

        if ($requests[0] == 'yeni') {
            if ($_POST['btnKaydet']) {
                $id = $this->db->add('blog', array('baslik' => $_POST['baslik'], 'ozet' => $_POST['src'], 'icerik' => $_POST['icerik'], 'tarih_yayin' => lifos::db_data_time(), 'link' => lifos::clean_string_for_link($_POST['baslik']), 'uye_id' => $_SESSION['uye']['id'], 'tip' => 'video'));
                $this->add_message('Kaydedildi.', 'success');

                return $this->video();
            }

            $this->add_navi('Video Yönetimi', '?b=uye/video');
            $this->add_navi('Yeni', '#');
            $out .= $this->get_navi();

            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge"></td></tr>
	    					<tr><td><b>Video Kodu</b></td><td><input type="text" name="src"></td></tr>
	    					<tr><td><b></b></td><td class="video">Youtube kodunu yükleyiniz</td></tr>
    						<tr><td><b>Ek İçerik</b></td><td> <textarea name="icerik" class="ckeditor"></textarea><br></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            $out .= factory::get('js')->ready()->add(" $('input[name=src]').keyup(function(){ $('td.video').html('<img src=\"http://img.youtube.com/vi/'+$(this).val()+'/hqdefault.jpg\">'); }); ")->getAll();

            return '<div class="span12">' . $out . '</div>';

        } /*
    	 * video düzenle
    	*/
        elseif ($requests[0] == 'duzenle') {
            $id = $_REQUEST['id'];

            if ($_POST['btnKaydet']) {
                $id = $this->db->set('blog', $id, array('baslik' => $_POST['baslik'], 'ozet' => $_POST['src'], 'icerik' => $_POST['icerik'], 'tarih_yayin' => lifos::db_data_time(), 'link' => lifos::clean_string_for_link($_POST['baslik'])));
                $this->add_message('Kaydedildi.', 'success');

                $_REQUEST = null;
                return $this->video();
            }

            $this->add_navi('Video Yönetimi', '?b=uye/video');
            $this->add_navi('Düzenle', '#');

            $blog = $this->db->sorgu("select * from blog where id=%d", $id)->satirObj();
            $out .= $this->get_navi();
            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge" value="' . $blog->baslik . '"></td></tr>
	    					<tr><td><b>Video Kodu</b></td><td><input type="text" name="src" value="' . $blog->ozet . '"></td></tr>
	    					<tr><td><b></b></td><td class="video"><img src="http://img.youtube.com/vi/' . $blog->ozet . '/hqdefault.jpg"></td></tr>
	    					<tr><td><b>Ek İçerik</b></td><td> <textarea name="icerik" class="ckeditor">' . $blog->icerik . '</textarea><br></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
	    				<input type="hidden" name="id" value="' . $blog->id . '">
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            $out .= factory::get('js')->ready()->add(" $('input[name=src]').keyup(function(){ $('td.video').html('<img src=\"http://img.youtube.com/vi/'+$(this).val()+'/hqdefault.jpg\">'); }); ")->getAll();

            return '<div class="span12">' . $out . '</div>';

        } /*
    	 * video sil
    	*/
        elseif ($requests[0] == 'sil') {
            $this->db->del('blog_yorum', $_GET['id']);
            $this->add_message('Yorum silindi.', 'success');
            $_REQUEST = null;
        }

        /*
    	 * yorum listesi
    	*/
        $this->add_navi('Yorumlar', '?b=uye/yorum');
        if ($requests[0] == 'bekleyen') {
            $this->add_navi('Onay Bekleyen', '#');
            $where = 'and onay=0';
        }

        $grid = factory::get('grid');

        $query = "SELECT bb.*,b.baslik FROM blog_yorum bb, blog b where bb.blog_id = b.id " . $where;

        $grid->setLink('?b=uye/yorum');
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'ID', 'sort' => true, 'width' => '90px', 'search' => true, 'width' => '60'));
        $grid->addCol(array('type' => 'multi', 'name' => 'baslik', 'title' => 'Yorum', 'value' => '{baslik}<br><small>{yorum}</small>', 'sort' => true, 'search' => 1, 'width' => '500px'));
        $grid->addCol(array('type' => 'icon', 'name' => 'onay', 'title' => 'Onay', 'class' => 'icon-ok', 'ifClass' => function (&$v, $db) {
            $v['class'] = $db['onay'] ? 'icon-star' : 'icon-star-empty';
        }, 'link' => '?b=uye/video/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'duz', 'title' => 'Düzenle', 'class' => 'icon-edit', 'link' => '?b=uye/video/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/video/sil&id={id}', 'confirm' => 'Yorum silinecek, emin misiniz?'));
        $grid->query($query, 'bb.id', 'd');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        $out .= factory::get('js')->ready()->add("
        	$('.icon a[class*=icon-star]').click(function(){
        		var nv = $(this).hasClass('icon-star') ? 0 : 1;
    			$(this).attr('class','icon-star'+(nv?'':'-empty'));
        		$.post('?a=uye/yorum_durum',{id:$(this).parent().siblings(':eq(0)').html(),v:nv});
        		return false;
    		});
		")->getAll();

        return '<div class="span12">' . $out . '</div>';
    }

    private function ilan_form($cat, $p = null) {
        global $site;

        //otomobil ise
        if ($cat == 2) {
            $out = '<table class="wa form" style="width:100%">
    					<tr><td width="150px"><b>Yıl*</b></td><td><input type="text" name="yil" value="' . $p->yil . '" class="numeric" maxlength="4"></td></tr>
    					<tr><td><b>Yakıt*</b></td><td>' . $site->get_param_select(site::P_YAKIT, $p->yakit, 0) . '</td></tr>
    					<tr><td><b>Vites*</b></td><td>' . $site->get_param_select(site::P_VITES, $p->vites, 0) . '</td></tr>
    					<tr><td><b>Kilometre*</b></td><td><input type="text" name="km" class="numeric" value="' . $p->km . '"></td></tr>
    					<tr><td><b>Renk*</b></td><td>' . $site->get_param_select(site::P_RENK, $p->renk, 0) . '</td></tr>
    					<tr><td><b>Kasa Tipi*</b></td><td>' . $site->get_param_select(site::P_KASA, $p->kasa, 0) . '</td></tr>
    					<tr><td><b>Motor Hacmi*</b></td><td>' . $site->get_param_select(site::P_MOTOR_HACMI, $p->motor_hacmi, 0) . '</td></tr>
    					<tr><td><b>Motor Gücü*</b></td><td>' . $site->get_param_select(site::P_MOTOR_GUCU, $p->motor_gucu, 0) . '</td></tr>
    					<tr><td><b>Çekiş</b></td><td>' . $site->get_param_select(site::P_CEKIS, $p->cekis, 0) . '</td></tr>
    					<tr><td><b>Garanti</b></td><td>' . html::selecta(array(1 => 'Evet', 2 => 'Hayır'), 'garanti', $p->garanti, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Plaka</b></td><td>' . $site->get_param_select(site::P_PLAKA, $p->plaka, 0) . '</td></tr>
    					<tr><td><b>Kimden</b></td><td>' . html::selecta(array(1 => 'Sahibinden', 2 => 'Galeriden'), 'kimden', $p->kimden, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Takas</b></td><td>' . html::selecta(array(1 => 'Evet', 2 => 'Hayır'), 'takas', $p->takas, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Durumu</b></td><td>' . html::selecta(array(1 => 'Sıfır', 2 => 'İkinci El'), 'durum', $p->durumu, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Güvenlik</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_GUVENLIK, $p->guvenlik) . '</div></td></tr>
    					<tr><td><b>İç Donanım</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_IC_DONANIM, $p->ic_donanim) . '</div></td></tr>
    					<tr><td><b>Dış Donanım</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_DIS_DONANIM, $p->dis_donanim) . '</div></td></tr>
    					<tr><td><b>Multimedia</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_MULTIMEDIA, $p->multimedia) . '</div></td></tr>
    					<tr><td><b>Boyalı Parça</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_BOYALI_PARCA, $p->boya) . '</div></td></tr>
    					<tr><td><b>Değişen Parça</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_DEGISEN_PARCA, $p->degisen) . '</div></td></tr>
    				</table>';
        } //motor ise
        elseif ($cat == 3) {
            $out = '<table class="wa form" style="width:100%">
    					<tr><td width="150px"><b>Yıl*</b></td><td><input type="text" name="yil" value="' . $p->yil . '" class="numeric" maxlength="4"></td></tr>
    					<tr><td><b>Kilometre*</b></td><td><input type="text" name="km" class="numeric" value="' . $p->km . '"></td></tr>
    					<tr><td><b>Motor Hacmi*</b></td><td>' . $site->get_param_select(site::P_MOTOR_MOTOR_HACMI, $p->motor_motor_hacmi, 0) . '</td></tr>
    					<tr><td><b>Motor Gücü*</b></td><td>' . $site->get_param_select(site::P_MOTOR_MOTOR_GUCU, $p->motor_motor_gucu, 0) . '</td></tr>
    					<tr><td><b>Silindir Sayısı*</b></td><td>' . $site->get_param_select(site::P_SILINDIR_SAYISI, $p->silindir_sayisi, 0) . '</td></tr>
    					<tr><td><b>Vites*</b></td><td>' . $site->get_param_select(site::P_VITES, $p->vites, 0) . '</td></tr>
    					<tr><td><b>Renk*</b></td><td>' . $site->get_param_select(site::P_RENK, $p->renk, 0) . '</td></tr>
    					<tr><td><b>Kimden</b></td><td>' . html::selecta(array(1 => 'Sahibinden', 2 => 'Galeriden'), 'kimden', $p->kimden, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Takas</b></td><td>' . html::selecta(array(1 => 'Evet', 2 => 'Hayır'), 'takas', $p->takas, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Durumu</b></td><td>' . html::selecta(array(1 => 'Sıfır', 2 => 'İkinci El'), 'durum', $p->durumu, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Güvenlik</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_MOTOR_GUVENLIK, $p->motor_guvenlik) . '</div></td></tr>
    					<tr><td><b>Aksesuar</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_MOTOR_AKSESUAR, $p->motor_aksesuar) . '</div></td></tr>
    				</table>';
        } elseif ($cat == 4) {
            $out = '<table class="wa form" style="width:100%">
    					<tr><td width="150px"><b>Yıl*</b></td><td><input type="text" name="yil" value="' . $p->yil . '" class="numeric" maxlength="4"></td></tr>
    					<tr><td><b>Kilometre*</b></td><td><input type="text" name="km" class="numeric" value="' . $p->km . '"></td></tr>
    					<tr><td><b>Renk*</b></td><td>' . $site->get_param_select(site::P_RENK, $p->renk, 0) . '</td></tr>
    					<tr><td><b>Motor Hacmi*</b></td><td>' . $site->get_param_select(site::P_MOTOR_HACMI, $p->motor_hacmi, 0) . '</td></tr>
    					<tr><td><b>Motor Gücü*</b></td><td>' . $site->get_param_select(site::P_MOTOR_GUCU, $p->motor_gucu, 0) . '</td></tr>
    					<tr><td><b>Yakıt*</b></td><td>' . $site->get_param_select(site::P_YAKIT, $p->yakit, 0) . '</td></tr>
    					<tr><td><b>Vites*</b></td><td>' . $site->get_param_select(site::P_VITES, $p->vites, 0) . '</td></tr>
    					<tr><td><b>Kapı*</b></td><td>' . $site->get_param_select(site::P_KAPI, $p->kapi, 0) . '</td></tr>
    					<tr><td><b>Çekiş*</b></td><td>' . $site->get_param_select(site::P_CEKIS, $p->cekis, 0) . '</td></tr>
    					<tr><td><b>Garanti</b></td><td>' . html::selecta(array(1 => 'Evet', 2 => 'Hayır'), 'garanti', $p->garanti, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Plaka</b></td><td>' . $site->get_param_select(site::P_PLAKA, $p->plaka, 0) . '</td></tr>
    					<tr><td><b>Kimden</b></td><td>' . html::selecta(array(1 => 'Sahibinden', 2 => 'Galeriden'), 'kimden', $p->kimden, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Takas</b></td><td>' . html::selecta(array(1 => 'Evet', 2 => 'Hayır'), 'takas', $p->takas, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Durumu</b></td><td>' . html::selecta(array(1 => 'Sıfır', 2 => 'İkinci El'), 'durum', $p->durumu, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Güvenlik</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_GUVENLIK, $p->guvenlik) . '</div></td></tr>
    					<tr><td><b>İç Donanım</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_IC_DONANIM, $p->ic_donanim) . '</div></td></tr>
    					<tr><td><b>Dış Donanım</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_DIS_DONANIM, $p->dis_donanim) . '</div></td></tr>
    					<tr><td><b>Multimedia</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_MULTIMEDIA, $p->multimedia) . '</div></td></tr>
    					<tr><td><b>Boyalı Parça</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_BOYALI_PARCA, $p->boya) . '</div></td></tr>
    					<tr><td><b>Değişen Parça</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_DEGISEN_PARCA, $p->degisen) . '</div></td></tr>
    				</table>';
        } elseif ($cat == 5) {
            $out = '<table class="wa form" style="width:100%">
    					<tr><td width="150px"><b>Yıl*</b></td><td><input type="text" name="yil" value="' . $p->yil . '" class="numeric" maxlength="4"></td></tr>
    					<tr><td><b>Kilometre*</b></td><td><input type="text" name="km" class="numeric" value="' . $p->km . '"></td></tr>
    					<tr><td><b>Motor Hacmi*</b></td><td>' . $site->get_param_select(site::P_MOTOR_HACMI, $p->motor_hacmi, 0) . '</td></tr>
    					<tr><td><b>Motor Gücü*</b></td><td>' . $site->get_param_select(site::P_MOTOR_GUCU, $p->motor_gucu, 0) . '</td></tr>
    					<tr><td><b>Araç Cinsi*</b></td><td>' . $site->get_param_select(site::P_ARAC_CINSI, $p->arac_cinsi, 0) . '</td></tr>
    					<tr><td><b>Kasa Tipi*</b></td><td>' . $site->get_param_select(site::P_VAN_KASA, $p->van_kasa, 0) . '</td></tr>
    					<tr><td><b>Renk*</b></td><td>' . $site->get_param_select(site::P_RENK, $p->renk, 0) . '</td></tr>
    					<tr><td><b>Vites*</b></td><td>' . $site->get_param_select(site::P_VITES, $p->vites, 0) . '</td></tr>
    					<tr><td><b>Yakıt*</b></td><td>' . $site->get_param_select(site::P_YAKIT, $p->yakit, 0) . '</td></tr>
    					<tr><td><b>Kimden</b></td><td>' . html::selecta(array(1 => 'Sahibinden', 2 => 'Galeriden'), 'kimden', $p->kimden, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Takas</b></td><td>' . html::selecta(array(1 => 'Evet', 2 => 'Hayır'), 'takas', $p->takas, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Durumu</b></td><td>' . html::selecta(array(1 => 'Sıfır', 2 => 'İkinci El'), 'durum', $p->durumu, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Güvenlik</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_GUVENLIK, $p->guvenlik) . '</div></td></tr>
    					<tr><td><b>İç Donanım</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_IC_DONANIM, $p->ic_donanim) . '</div></td></tr>
    					<tr><td><b>Dış Donanım</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_DIS_DONANIM, $p->dis_donanim) . '</div></td></tr>
    					<tr><td><b>Multimedia</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_MULTIMEDIA, $p->multimedia) . '</div></td></tr>
    					<tr><td><b>Boyalı Parça</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_BOYALI_PARCA, $p->boya) . '</div></td></tr>
    					<tr><td><b>Değişen Parça</b></td><td><div class="row">' . $this->site->get_ozellik_cb(site::P_DEGISEN_PARCA, $p->degisen) . '</div></td></tr>
    				</table>';
        } elseif ($cat == 2495) {
            $out = '<table class="wa form" style="width:100%">
   					    <tr><td width="150px"><b>Yıl*</b></td><td><input type="text" name="yil" value="' . $p->yil . '" class="numeric" maxlength="4"></td></tr>
    					<tr><td><b>Yakıt*</b></td><td>' . $site->get_param_select(site::P_YAKIT, $p->yakit, 0) . '</td></tr>
    					<tr><td><b>Vites*</b></td><td>' . $site->get_param_select(site::P_VITES, $p->vites, 0) . '</td></tr>
    					<tr><td><b>Kilometre*</b></td><td><input type="text" name="km" class="numeric" value="' . $p->km . '"></td></tr>
    					<tr><td><b>Renk*</b></td><td>' . $site->get_param_select(site::P_RENK, $p->renk, 0) . '</td></tr>
    					<tr><td><b>Kasa Tipi*</b></td><td>' . $site->get_param_select(site::P_KASA, $p->kasa, 0) . '</td></tr>
    					<tr><td><b>Motor Hacmi*</b></td><td>' . $site->get_param_select(site::P_MOTOR_HACMI, $p->motor_hacmi, 0) . '</td></tr>
    					<tr><td><b>Motor Gücü*</b></td><td>' . $site->get_param_select(site::P_MOTOR_GUCU, $p->motor_gucu, 0) . '</td></tr>
    					<tr><td><b>Çekiş</b></td><td>' . $site->get_param_select(site::P_CEKIS, $p->cekis, 0) . '</td></tr>
    					<tr><td><b>Garanti</b></td><td>' . html::selecta(array(1 => 'Evet', 2 => 'Hayır'), 'garanti', $p->garanti, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Plaka</b></td><td>' . $site->get_param_select(site::P_PLAKA, $p->plaka, 0) . '</td></tr>
    					<tr><td><b>Kimden</b></td><td>' . html::selecta(array(1 => 'Sahibinden', 2 => 'Galeriden'), 'kimden', $p->kimden, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Takas</b></td><td>' . html::selecta(array(1 => 'Evet', 2 => 'Hayır'), 'takas', $p->takas, '- Seçiniz -') . '</td></tr>
    					<tr><td><b>Durumu</b></td><td>' . html::selecta(array(1 => 'Sıfır', 2 => 'İkinci El'), 'durum', $p->durumu, '- Seçiniz -') . '</td></tr>
    				</table>';
        }

        return $out;
    }

    function ajax_ilan_form($p = null) {
        echo $this->ilan_form($_POST['cat'], $p);
        exit();
    }

    function ilan($requests = '') {
        if (($_SERVER['REMOTE_ADDR'] != '127.0.0.1') && !isset($_SERVER['HTTPS'])) {
            header("Location:https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            exit();
        }

        $tip = $requests[0];
        $this->add_navi('İlanlar', '?b=uye/ilan', 1);

        if ($requests[0] == 'yeni') {
            $uploader = factory::get('dosyalar')->configure(array('ref' => 'ilan'));

            if ($_POST['btnKaydet']) {
                $p = (object)$_POST;

                if (!$p->baslik) $err[] = 'Başlık giriniz';
                if (!$p->fiyat) $err[] = 'Fiyat giriniz';
                if (!$p->cat) $err[] = 'Kategori seçiniz';
                if (!$p->il) $err[] = 'İl Seçiniz';
                if (!$p->ilce) $err[] = 'İlçe Seçiniz';
                $guzel_kategori = $this->kategori_agac($p->cat);

                $guvenlik = is_array($p->p_guvenlik) ? implode(',', array_values($p->p_guvenlik)) : '';
                $ic = is_array($p->p_ic_donanim) ? implode(',', array_values($p->p_ic_donanim)) : '';
                $dis = is_array($p->p_dis_donanim) ? implode(',', array_values($p->p_dis_donanim)) : '';
                $multi = is_array($p->p_multimedia) ? implode(',', array_values($p->p_multimedia)) : '';
                $boya = is_array($p->p_boyali_parca) ? implode(',', array_values($p->p_boyali_parca)) : '';
                $degisen = is_array($p->p_degisen_parca) ? implode(',', array_values($p->p_degisen_parca)) : '';
                $motor_guvenlik = is_array($p->p_motor_guvenlik) ? implode(',', array_values($p->p_motor_guvenlik)) : '';
                $motor_aksesuar = is_array($p->p_motor_aksesuar) ? implode(',', array_values($p->p_motor_aksesuar)) : '';

                if ($err) {
                    $this->add_messages($err, 'error');
                } else {

                    $id = $this->db->add('ilan', array('baslik' => $p->baslik, 'icerik' => $p->icerik, 'fiyat' => $p->fiyat, 'yil' => $p->yil, 'yakit' => $p->p_yakit | 0, 'vites' => $p->p_vites | 0, 'km' => $p->km, 'renk' => $p->p_renk | 0, 'kasa' => $p->p_kasa | 0, 'motor_hacmi' => $p->p_motor_hacmi | 0, 'motor_gucu' => $p->p_motor_gucu | 0, 'cekis' => $p->p_cekis | 0, 'garanti' => $p->garanti | 0, 'plaka' => $p->p_plaka | 0, 'kimden' => $p->kimden | 0, 'durumu' => $p->durum | 0, 'guvenlik' => $guvenlik, 'ic_donanim' => $ic, 'dis_donanim' => $dis, 'multimedia' => $multi, 'boya' => $boya, 'degisen' => $degisen, 'uye_id' => $_SESSION['uye']['id'], 'il' => $p->il, 'ilce' => $p->ilce, 'para_birimi' => $p->para_birimi, 'tarih' => lifos::db_data_time(), 'guzel_kategori' => $guzel_kategori, 'link' => lifos::clean_string_for_link($p->baslik), 'kategori' => $p->cat, 'kategori2' => $p->cat2, 'motor_guvenlik' => $motor_guvenlik, 'motor_aksesuar' => $motor_aksesuar, 'motor_motor_hacmi' => $p->p_motor_motor_hacmi | 0, 'motor_motor_gucu' => $p->p_motor_motor_gucu | 0, 'silindir_sayisi' => $p->p_silindir_sayisi | 0, 'kapi' => $p->p_kapi | 0, 'arac_cinsi' => $p->p_arac_cinsi | 0, 'van_kasa' => $p->p_van_kasa | 0, 'takas' => $p->takas | 0));

                    $anahtarlar = $p->cat . ',' . $p->p_yakit . ',' . $p->p_vites . ',' . $p->p_renk . ',' . $p->p_kasa . ',' . $p->p_motor_hacmi . ',' . $p->p_motor_gucu . ',' . $p->p_cekis . ',' . $p->p_plaka . ($guvenlik ? ',' . $guvenlik : '') . ($ic ? ',' . $ic : '') . ($dis ? ',' . $dis : '') . ($multi ? ',' . $multi : '') . ($boya ? ',' . $boya : '') . ($degisen ? ',' . $degisen : '');
                    $anahtar = $id . ' ' . $this->db->sorgu("select group_concat(val SEPARATOR ' ') from params where id in(%s)", $anahtarlar)->sonuc(0) . ' ' . $baslik . ' ' . $p->il . ' ' . $p->ilce;
                    $this->db->set('ilan', $id, array('anahtar' => $anahtar), 'ilan_id');
                    $cat = $this->site->get_param($p->cat2)->ust_id;

                    /***if($_SESSION['uye']['magaza_id'] || ($cat!=20000))
                     * {
                     * $this->db->set('ilan',$id,array('doping_yayin'=>1,'yayin_durum'=>1),'ilan_id');
                     * $this->add_message('İlanınız kaydedildi. İlanınıza doping yaparak daha fazla görüntülenmesini sağlayabilirsiniz.','success');
                     * }
                     * else
                     * {
                     * $this->add_message('İlanınız kaydedildi. İlanınızın yayına girebilmesi için ilan yayınlama ücretini ödemeniz gerekmektir. İlanınızın daha çok görüntülenebilmesi için aşağıdaki doping seçeneklerinden sepetinize ekleyebilirsiniz.','success');
                     * }
                     *
                     * $uploader->setFileRefId($id);
                     * header('Location:/index.php?b=uye/ilan/doping&id='.$id);
                     * exit();
                     */

                    $this->db->set('ilan', $id, array('doping_yayin' => 1, 'yayin_durum' => 1), 'ilan_id');
                    $this->add_message('İlanınız kaydedildi.', 'success');
                    $uploader->setFileRefId($id);
                    if ($_SESSION['uye']['id'] == 1)
                        header('Location:/index.php?b=uye/ilan/doping&id=' . $id);
                    else
                        header('Location:/index.php?b=uye/ilan');

                    exit();
                }
            }

            $uploader->configure(array('title' => 'İlana Fotoğraf veya Fotoğraflar Ekleyin', 'type' => 'image', 'ref' => 'ilan', 'deletable' => 1, 'sortable' => 1, 'multiple_files' => 1, 'resize' => '480,360', 'thumb' => '88,66', 'max_file_size' => '8MB', 'water' => '/static/' . THEME . '/img/watermark.png', 'max_file_number' => 10));
            $uploader->button_width = 360;

            $this->add_navi('Yeni', '#');
            $out .= $this->get_navi();

            global $site;

            $out .= '<br>' . $this->get_message() . '<form method="post" enctype="multipart/form-data">
    					<table class="wa form" style="width:100%">
	    					<tr><td width="150px"><b>Kategori</b></td><td><div id="kategori">' . $site->kategori_select(site::P_KATEGORI, 0, 0) . '<input type="hidden" name="cat"><input type="hidden" name="cat2"></div></td></tr>
	    					<tr><td><b>Başlık*</b></td><td><input type="text" name="baslik" class="input-xxlarge" value="' . $p->baslik . '"></td></tr>
    						<tr><td><b>İlan Detayı*</b></td><td><textarea name="icerik" class="ckeditor">' . $p->icerik . '</textarea><br></td></tr>
	    					<tr><td><b>Fiyat*</b></td><td><input type="text" name="fiyat" value="' . $p->fiyat . '" class="numeric">' . html::selecta(array('TL' => 'TL', '$' => '$', '€' => '€'), 'para_birimi', false, '', 'input-small') . '</td></tr>
	    				</table>
						<div class="ilanform"></div>
	    				<table class="wa form" style="width:100%">
	    					<tr><td><b>Adres</b></td><td><div id="adres">' . $site->il_select() . '</div></td></tr>
	    					<tr><td width="150px"><b>Fotoğraflar</b></td><td>' . $uploader->get_form() . '</td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            $out .= '<script type="text/javascript" src="/static/' . THEME . '/js/jquery.alphanumeric.js"></script>';
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
    			
    			$('.numeric').numeric();
    			
    			$('input[name=btnKaydet]').live('click',function(){
    				var e='';

    				$('#kategori select').each(function(i,a){
    				    if($(a).val() == 0 || $(a).val() == '0') {
    				        e+='- Kategori seçimini tamamlamadınız.\\n';
    				        return false;
    				    }
    				});

    				if( !$('input[name=cat]').val() ) e+='- Kategori seçiniz.\\n';
    				if( !$('input[name=baslik]').val() ) e+='- Başlık giriniz.\\n';
    				if( !$('input[name=fiyat]').val() ) e+='- Fiyat giriniz.\\n';
    				if( $('input[name=yil]').size() && !$('input[name=yil]').val() ) e+='- Yıl giriniz.\\n';
    				if( $('select[name=p_yakit]').size() && !$('select[name=p_yakit]').val() ) e+='- Yakıt tipi seçmediniz.\\n';
    				if( $('select[name=p_vites]').size() && !$('select[name=p_vites]').val() ) e+='- Vites seçmediniz.\\n';
    				if( $('select[name=p_silindir_sayisi]').size() && !$('select[name=p_silindir_sayisi]').val() ) e+='- Silindir sayısını seçmediniz.\\n';
    				if( $('input[name=km]').size() && !$('input[name=km]').val() ) e+='- Km giriniz.\\n';
    				if( $('select[name=p_renk]').size() && !$('select[name=p_renk]').val() ) e+='- Renk seçmediniz.\\n';
    				if( $('select[name=p_kasa]').size() && !$('select[name=p_kasa]').val() ) e+='- Kasa tipi seçmediniz.\\n';
    				if( $('select[name=p_van_kasa]').size() && !$('select[name=p_van_kasa]').val() ) e+='- Kasa tipi seçmediniz.\\n';
    				if( $('select[name=p_motor_hacmi]').size() && !$('select[name=p_motor_hacmi]').val() ) e+='- Motor hacmi seçmediniz.\\n';
    				if( $('select[name=p_motor_motor_hacmi]').size() && !$('select[name=p_motor_motor_hacmi]').val() ) e+='- Motor hacmi seçmediniz.\\n';
    				if( $('select[name=p_motor_gucu]').size() && !$('select[name=p_motor_gucu]').val() ) e+='- Motor gücü seçmediniz.\\n';
    				if( $('select[name=p_motor_motor_gucu]').size() && !$('select[name=p_motor_motor_gucu]').val() ) e+='- Motor gücü seçmediniz.\\n';
    				if( $('select[name=p_kapi]').size() && !$('select[name=p_kapi]').val() ) e+='- Kapı sayısını seçmediniz.\\n';
    				if( $('select[name=p_arac_cinsi]').size() && !$('select[name=p_arac_cinsi]').val() ) e+='- Araç cinsini seçmediniz.\\n';
    				if( $('select[name=p_cekis]').size() && !$('select[name=p_cekis]').val() ) e+='- Çekiş tipi seçmediniz.\\n';
    				if( $('select[name=garanti]').size() && !$('select[name=garanti]').val() ) e+='- Garanti seçmediniz.\\n';
    				if( $('select[name=p_plaka]').size() && !$('select[name=p_plaka]').val() ) e+='- Plaka seçmediniz.\\n';
    				if( $('select[name=kimden]').size() && !$('select[name=kimden]').val() ) e+='- Kimden seçmediniz.\\n';
    				if( $('select[name=durum]').size() && !$('select[name=durum]').val() ) e+='- Durumu seçmediniz.\\n';
    				
    				if( !$('select[name=il]').val() || $('select[name=il]').val()==0) e+='- İl seçmediniz.\\n';
    				if( !$('select[name=ilce]').val() || $('select[name=ilce]').val()=='0' ) e+='- İlçe seçmediniz.\\n';



    				if(e){
    					alert(e);
    					return false;
    				}
    			});

    		")->getAll();

            return '<div class="span12">' . $out . '</div>';
        } /*
    	 * ilan düzenle
    	 */
        elseif ($requests[0] == 'duzenle') {
            $id = $_REQUEST['id'];
            $uploader = factory::get('dosyalar')->configure(array('ref' => 'ilan', 'ref_id' => $id));

            if ($_POST['btnKaydet']) {
                $p = (object)$_POST;

                if (!$p->baslik) $err[] = 'Başlık giriniz';
                if (!$p->fiyat) $err[] = 'Fiyat giriniz';
                if (!$p->cat) $err[] = 'Kategori seçiniz';
                if (!$p->il) $err[] = 'İl Seçiniz';
                if (!$p->ilce) $err[] = 'İlçe Seçiniz';
                $guzel_kategori = $this->kategori_agac($p->cat);

                $guvenlik = is_array($p->p_guvenlik) ? implode(',', array_values($p->p_guvenlik)) : '';
                $ic = is_array($p->p_ic_donanim) ? implode(',', array_values($p->p_ic_donanim)) : '';
                $dis = is_array($p->p_dis_donanim) ? implode(',', array_values($p->p_dis_donanim)) : '';
                $multi = is_array($p->p_multimedia) ? implode(',', array_values($p->p_multimedia)) : '';
                $boya = is_array($p->p_boyali_parca) ? implode(',', array_values($p->p_boyali_parca)) : '';
                $degisen = is_array($p->p_degisen_parca) ? implode(',', array_values($p->p_degisen_parca)) : '';
                $motor_guvenlik = is_array($p->p_motor_guvenlik) ? implode(',', array_values($p->p_motor_guvenlik)) : '';
                $motor_aksesuar = is_array($p->p_motor_aksesuar) ? implode(',', array_values($p->p_motor_aksesuar)) : '';

                if ($err) {
                    $this->add_messages($err, 'error');
                } else {
                    $this->db->set('ilan', $id, array('baslik' => $p->baslik, 'icerik' => $p->icerik, 'fiyat' => $p->fiyat, 'yil' => $p->yil, 'yakit' => $p->p_yakit | 0, 'vites' => $p->p_vites | 0, 'km' => $p->km, 'renk' => $p->p_renk | 0, 'kasa' => $p->p_kasa | 0, 'motor_hacmi' => $p->p_motor_hacmi | 0, 'motor_gucu' => $p->p_motor_gucu | 0, 'cekis' => $p->p_cekis | 0, 'garanti' => $p->garanti | 0, 'plaka' => $p->p_plaka | 0, 'kimden' => $p->kimden | 0, 'durumu' => $p->durum | 0, 'guvenlik' => $guvenlik, 'ic_donanim' => $ic, 'dis_donanim' => $dis, 'multimedia' => $multi, 'boya' => $boya, 'degisen' => $degisen, 'il' => $p->il, 'ilce' => $p->ilce, 'para_birimi' => $p->para_birimi, 'guzel_kategori' => $guzel_kategori, 'link' => lifos::clean_string_for_link($p->baslik), 'kategori' => $p->cat, 'kategori2' => $p->cat2, 'motor_guvenlik' => $motor_guvenlik, 'motor_aksesuar' => $motor_aksesuar, 'motor_motor_hacmi' => $p->p_motor_motor_hacmi | 0, 'motor_motor_gucu' => $p->p_motor_motor_gucu | 0, 'silindir_sayisi' => $p->p_silindir_sayisi | 0, 'kapi' => $p->p_kapi | 0, 'arac_cinsi' => $p->p_arac_cinsi | 0, 'van_kasa' => $p->p_van_kasa | 0, 'takas' => $p->takas | 0), 'ilan_id');

                    $hata = $this->db->hata();
                    //$uploader->setFileRefId($id);

                    header('Location:/index.php?b=uye/ilan');

                    ///header('Location:/index.php?b=uye/ilan/doping&id='.$id);
                }
            }

            $uploader->configure(array('title' => 'İlana Fotoğraf veya Fotoğraflar Ekleyin', 'type' => 'image', 'ref' => 'ilan', 'ref_id' => $id, 'deletable' => 1, 'sortable' => 1, 'multiple_files' => 1, 'resize' => '480,360', 'thumb' => '88,66', 'max_file_size' => '8MB', 'water' => '/static/img/watermark.png', 'max_file_number' => 10));
            $uploader->button_width = 360;

            $this->add_navi('Düzenle', '#');
            $out .= $this->get_navi();

            global $site;

            $ilan = $site->get_ilan_for_edit($id);

            $out .= '<br>' . $this->get_message() . '<form method="post" enctype="multipart/form-data">
    					<table class="wa form" style="width:100%">
	    					<tr><td width="150px"><b>Kategori</b></td><td><div id="kategori">' . $site->kategori_pre_select($ilan->kategori, $ilan->kategori2) . '<input type="hidden" name="cat" value="' . $ilan->kategori . '"><input type="hidden" name="cat2" value="' . $ilan->kategori2 . '"></div></td></tr>
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" class="input-xxlarge" value="' . $ilan->baslik . '"></td></tr>
    						<tr><td><b>İlan Detayı</b></td><td><textarea name="icerik" class="ckeditor">' . $ilan->icerik . '</textarea><br></td></tr>
	    					<tr><td><b>Fiyat*</b></td><td><input type="text" name="fiyat" value="' . $ilan->fiyat . '" class="numeric">' . html::selecta(array('TL' => 'TL', '$' => '$', '€' => '€'), 'para_birimi', $ilan->para_birimi, '', 'input-small') . '</td></tr>
	    				</table>
    					<div class="ilanform">
	    					' . $this->ilan_form($ilan->kategori2, $ilan) . '			
	    				</div>	
    					<table class="wa form" style="width:100%">
	    					<tr><td width="150px"><b>Adres</b></td><td><div id="adres">' . $site->il_select($ilan->il) . $site->ilce_select($ilan->il, $ilan->ilce) . '</div></td></tr>
	    					<tr><td><b>Fotoğraflar</b></td><td>' . $uploader->get_form() . '</td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
	    				<input type="hidden" name="id" value="' . $id . '">
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            $out .= '<script type="text/javascript" src="/static/' . THEME . '/js/jquery.alphanumeric.js"></script>';
            $out .= factory::get('js')->ready()->add(" 
				$('#kategori select').live('change',function(){ 
					var a = $(this); 
    				if($(this).index()==1) {
	    				alert('Araç tipinde değişiklik yapamazsınız.');
    					return false;
    				}
					$.post('/index.php?a=ilan/kategori_select',{id:$(this).val(),l:$(this).index()},function(b){
    					$('#kategori select:gt('+a.index()+')').remove();
						a.after(b);
						$('input[name=cat]').val(a.val());
    					$('input[name=cat2]').val($('#kategori select:eq(1)').val());
    				}); 
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
    				$('.numeric').numeric();
    			$('input[name=btnKaydet]').live('click',function(){
    				var e='';

    				$('#kategori select').each(function(i,a){
    				    if($(a).val() == 0 || $(a).val() == '0') {
    				        e+='- Kategori seçimini tamamlamadınız.\\n';
    				        return false;
    				    }
    				});

    				if( !$('input[name=cat]').val() ) e+='- Kategori seçiniz.\\n';
    				if( !$('input[name=baslik]').val() ) e+='- Başlık giriniz.\\n';
    				if( !$('input[name=fiyat]').val() ) e+='- Fiyat giriniz.\\n';
    				if( $('input[name=yil]').size() && !$('input[name=yil]').val() ) e+='- Yıl giriniz.\\n';
    				if( $('select[name=p_yakit]').size() && !$('select[name=p_yakit]').val() ) e+='- Yakıt tipi seçmediniz.\\n';
    				if( $('select[name=p_vites]').size() && !$('select[name=p_vites]').val() ) e+='- Vites seçmediniz.\\n';
    				if( $('select[name=p_silindir_sayisi]').size() && !$('select[name=p_silindir_sayisi]').val() ) e+='- Silindir sayısını seçmediniz.\\n';
    				if( $('input[name=km]').size() && !$('input[name=km]').val() ) e+='- Km giriniz.\\n';
    				if( $('select[name=p_renk]').size() && !$('select[name=p_renk]').val() ) e+='- Renk seçmediniz.\\n';
    				if( $('select[name=p_kasa]').size() && !$('select[name=p_kasa]').val() ) e+='- Kasa tipi seçmediniz.\\n';
    				if( $('select[name=p_van_kasa]').size() && !$('select[name=p_van_kasa]').val() ) e+='- Kasa tipi seçmediniz.\\n';
    				if( $('select[name=p_motor_hacmi]').size() && !$('select[name=p_motor_hacmi]').val() ) e+='- Motor hacmi seçmediniz.\\n';
    				if( $('select[name=p_motor_motor_hacmi]').size() && !$('select[name=p_motor_motor_hacmi]').val() ) e+='- Motor hacmi seçmediniz.\\n';
    				if( $('select[name=p_motor_gucu]').size() && !$('select[name=p_motor_gucu]').val() ) e+='- Motor gücü seçmediniz.\\n';
    				if( $('select[name=p_motor_motor_gucu]').size() && !$('select[name=p_motor_motor_gucu]').val() ) e+='- Motor gücü seçmediniz.\\n';
    				if( $('select[name=p_kapi]').size() && !$('select[name=p_kapi]').val() ) e+='- Kapı sayısını seçmediniz.\\n';
    				if( $('select[name=p_arac_cinsi]').size() && !$('select[name=p_arac_cinsi]').val() ) e+='- Araç cinsini seçmediniz.\\n';
    				if( $('select[name=p_cekis]').size() && !$('select[name=p_cekis]').val() ) e+='- Çekiş tipi seçmediniz.\\n';
    				if( $('select[name=garanti]').size() && !$('select[name=garanti]').val() ) e+='- Garanti seçmediniz.\\n';
    				if( $('select[name=p_plaka]').size() && !$('select[name=p_plaka]').val() ) e+='- Plaka seçmediniz.\\n';
    				if( $('select[name=kimden]').size() && !$('select[name=kimden]').val() ) e+='- Kimden seçmediniz.\\n';
    				if( $('select[name=durum]').size() && !$('select[name=durum]').val() ) e+='- Durumu seçmediniz.\\n';
    				
    				if( !$('select[name=il]').val() || $('select[name=il]').val()==0) e+='- İl seçmediniz.\\n';
    				if( !$('select[name=ilce]').val() || $('select[name=ilce]').val()=='0' ) e+='- İlçe seçmediniz.\\n';
    				
    				if(e){
    					alert(e);
    					return false;
    				}
    				});

    		")->getAll();

            return '<div class="span12">' . $out . '</div>';
        } /*
    	 * ilan sil
    	*/
        elseif ($requests[0] == 'yayindankaldir') {
            $this->add_navi('Yayından Kaldır', '#');
            $ilan = $this->db->sorgu("select * from ilan where ilan_id=%d", fi($_GET['id']))->satirObj();

            $out .= $this->get_navi();
            $out .= '<h4>Yayından kaldırmak istediğiniz ilan</h4>
				    <b>' . $ilan->baslik . ' (' . $ilan->ilan_id . ')</b><br>Bu ilan ile birlikte yayınlanmakta olan dopingleriniz yayından kaldırılacak ve tekrar yayınlanmayacaktır.<br><br>
				    <b>Erken Bitirme Sebebiniz</b> <br>
				    <select name="sebep"><option value="10">Piston Kafalar aracılığı ile sattım/kiraladım</option><option value="11">Satmaktan/kiralamaktan vazgeçtim</option><option value="12">Piston Kafalar harici bir kurumla sattım/kiraladım</option></select>
				    <br><input type="checkbox" name="sil" value=1> İlanı yayından kaldırdıktan sonra sil.<br><br>
				    <input type="submit" name="btnSil" value="Yayından Kaldır" class="btn btn-success"><br><br>
				    		<input type="hidden" name="id" value="' . $_GET['id'] . '">
					';

            /*
    		
    		$this->db->del('ilan',$_GET['id'],'ilan_id');
    		factory::get('dosyalar')->deleteByRef('ilan',$_GET['id']);
    		$this->add_message('İlan silindi.','success');
    		$_REQUEST = null;
    		
    		*/

            return '<form name="sil" method="post" action="/index.php?b=uye/ilan/sil">' . $out . '</form>';
        } elseif ($requests[0] == 'sil') {
            $ilan = $this->db->sorgu("select * from ilan where ilan_id=%d", fi($_POST['id']))->satirObj();

            if (($ilan->uye_id == $_SESSION['uye']['id']) || site::is_admin()) {
                $this->db->set("ilan", fi($_POST['id']), array('yayin_durum' => $_POST['sebep'], 'doping_yayin' => 0, 'doping_manset' => 0, 'doping_manset2' => 0, 'doping_acil' => 0, 'doping_ara' => 0), 'ilan_id');
                $this->add_message('İlanınızın yayın durumu değiştirilmiştir.', 'success');

                if ($_POST['sil']) {
                    $this->db->del('ilan', $_POST['id'], 'ilan_id');
                    $this->add_message('İlanınız yayından kaldırıldıktan sonra silinmiştir.', 'success');
                    factory::get('dosyalar')->deleteByRef('ilan', $_POST['id']);
                }
            }

            $_REQUEST = null;
            return $this->ilan();
        } elseif ($requests[0] == 'dopingduzenle') {
            $data['ilan'] = $this->db->sorgu("select * from ilan where ilan_id=%d", fi($_GET['id']))->satirObj();
            exit($this->view('dialog_dopingduzenle', $data));
        } elseif ($requests[0] == 'doping') {
            $this->add_navi('Doping', '#');
            $ilan = $this->db->sorgu("select * from ilan where ilan_id=%d", fi($_GET['id']))->satirObj();
            $cat = $this->site->get_param($ilan->kategori2)->ust_id;

            if (!(($cat != 20000) || ($ilan->doping_yayin == 1) || ($_SESSION['uye']['magaza_id']))) $out .= '<div class="dd"><input type="checkbox" checked disabled><b>Piston Kafalar İlan yayınlama ücreti</b><p>İlanınız anında yayına girer!</p><input type="hidden" name="s[yayin]" value="1"><span>17.47 TL</span><input type="hidden" value="1" name="yayin"></div>';
            $out .= '<div class="dd"><input type="checkbox" name="s[vitrin_ana]" value="1"><strong>Ana Sayfa Vitrini</strong><p>İlanınız PistonKafalar.com 2.el ana sayfasında yer alsın istiyorsanız hemen bu seçeneği  alın !</p> <span>' . number_format(site::$fiyatlar[$cat]['vitrin_ana'][1], 2) . ' TL</span></div>';
            $out .= '<div class="dd"><input type="checkbox" name="s[vitrin_kategori]" value="1"><strong>Kategori Vitrini</strong><p>İlanınızın her gün ait olduğu kategori sayfasında görüntülensin istiyorsanız hemen bu seçeneği alın !</p> <span>' . number_format(site::$fiyatlar[$cat]['vitrin_kategori'][1], 2) . ' TL</span></div>';
            $out .= '<div class="dd"><input type="checkbox" name="s[vitrin_ara]" value="1"><strong>Detaylı Arama Vitrini</strong><p>Detaylı arama yapan kullanıcılara en kısa yoldan ulaşmak için hemen bu seçeneği alın !</p> <span>' . number_format(site::$fiyatlar[$cat]['vitrin_ara'][1], 2) . ' TL</span></div>';
            $out .= '<div class="dd"><input type="checkbox" name="s[acil]" value="1"><strong>Acil İlan</strong><p>“Çok çabuk satmam lazım” diyorsanız Acil Acil dopingini alın, ilanınız ana sayfa sol üst menüde yer alan Acil Acil kategorisinde yer alsın. </p><span>' . number_format(site::$fiyatlar[$cat]['acil'][1], 2) . ' TL</span></div>';
            $out .= '<div class="dd"><input type="checkbox" name="s[dusen]" value="1"><strong>Fiyatı Düşenler</strong><p>İlanınıza fiyatı düşenler bölümüne dahil ederek daha fazla görüntülenmesini sağlayabilirsiniz.</p> <span>' . number_format(site::$fiyatlar[$cat]['dusen'][1], 2) . ' TL</span></div>';
            $out .= '<h6>Alınan her doping ait olduğu ilan numarası için geçerli olup 2 hafta yayınlanma süresi vardır.</h6><hr> <input type="submit" name="btnOlustur" value="Devam Et →" class="btn btn-success"><input type="hidden" name="id" value="' . $_GET['id'] . '"> ';
            $out = $this->get_navi() . '<form method="post" action="/index.php?b=uye/ilan/odeme"><div class="doping">' . $this->get_message() . '<h3>Doping Yapın</h3>' . $out . '</div><input type="hidden" name="id" value="' . $_REQUEST['id'] . '"></form>';
            return $out;
        } elseif ($requests[0] == 'odeme') {
            $ilan = $this->db->sorgu("select * from ilan where ilan_id=%d", fi($_REQUEST['id']))->satirObj();
            $cat = $this->site->get_param($ilan->kategori2)->ust_id;

            if (!$_POST['s']) {
                if ($_SESSION['uye']['magaza_id'] || $ilan->doping_yayin) {
                    $this->db->set('ilan', $ilan->ilan_id, array('yayin_durum' => 1), 'ilan_id');
                    $this->add_message('İlanınız yayına alınmıştır.', 'success');
                    $_REQUEST = null;
                    return $this->ilan();
                } else {
                    $this->add_message('Hiçbir seçeneği seçmediniz. İlanınızın yayına girmesi için en azından ilan yayınlama ücretini ödemelisiniz. ', 'error');
                    header('Location: index.php?b=uye/ilan/doping&id=' . $_REQUEST['id']);
                }
            }

            if ($_POST['btnOde']) {
                $id = $_POST['id'];

                foreach ($_POST['s'] as $i => $j) {
                    $toplam += site::$fiyatlar[$cat][$i][1];
                }

                if ($_SESSION['uye']['magaza_id']) $toplam *= 0.85;

                if ($_POST['s']['yayin']) $data['yayin_durum'] = $data['doping_yayin'] = 1;
                if ($_POST['s']['vitrin_ana']) $data['doping_manset'] = 1;
                if ($_POST['s']['vitrin_kategori']) $data['doping_manset2'] = 1;
                if ($_POST['s']['vitrin_ara']) $data['doping_ara'] = 1;
                if ($_POST['s']['acil']) $data['doping_acil'] = 1;
                if ($_POST['s']['dusen']) $data['doping_fiyat'] = 1;

                if ($data) {
                    $this->db->set('ilan', $id, $data, 'ilan_id');
                    $this->db->add('odeme', array('ilan_id' => $_POST['id'], 'uye_id' => $_SESSION['uye']['id'], 'tarih' => lifos::db_data_time(), 'toplam' => $toplam, 'aciklama' => serialize($_POST['s']), 'magaza' => $_SESSION['uye']['magaza_id'] ? $_SESSION['uye']['magaza_id'] : 0, 'kategori' => $cat));
                    $this->add_message('Ödeme işlemleriniz başarı ile gerçekleştirilmiştir.', 'success');
                    $this->add_message('İlanınıza istediğiniz dopingler uygulanmıştır.', 'success');

                    $msg = 'Sayın, ' . $_SESSION['uye']['ad'] . ',<br><br>#' . $id . ' numaralı ilana ait ' . number_format($toplam, 2) . ' TL tutarında ki ödeme işleminiz gerçekleştirilmiştir. ';
                    $msg .= $data['yayin_durum'] ? (count($_POST['s']) > 1 ? 'İlanınız 2 ay, dopingleriniz ise 2 hafta boyunca yayında kalacaktır.' : 'İlanınız 2 ay boyunca yayında kalacaktır') : 'Dopingleriniz 2 hafta boyunca yayında kalacaktır.';
                    $msg .= '<br><br>Saygılarımızla,<br><br>PistonKafalar.com';

                    factory::get('mailer')->fast_send($_SESSION['uye']['eposta'], $_SESSION['uye']['ad'], 'Ödemeniz Alındı', $msg);

                    $this->add_navi('Ödeme Sonucu', '#');

                    $_REQUEST = null;
                    return $this->ilan();
                }
            }

            $this->add_navi('Doping', '/index.php?b=uye/ilan/doping&id=' . $_REQUEST['id']);

            for ($i = date('Y'); $i < date('Y') + 15; $i++) {
                $yil .= '<option value="' . $i . '">' . $i . '</option>';
            }

            foreach ($_POST['s'] as $i => $j) {
                $lines .= '<tr><td>' . site::$fiyatlar[$cat][$i][0] . '<input type="hidden" name="s[' . $i . ']" value=1></td><td>' . ($i == 'yayin' ? '2 Ay' : '2 Hafta') . '</td><td style="text-align:right;">' . number_format(site::$fiyatlar[$cat][$i][1], 2) . ' TL</td></tr>';
                $toplam += site::$fiyatlar[$cat][$i][1];
            }

            if ($_SESSION['uye']['magaza_id']) {
                $foot .= '<tr><th></th><th style="text-align:right">Ara Toplam : </th><th style="text-align:right">' . number_format($toplam, 2) . ' TL</th></tr>';
                $foot .= '<tr><th></th><th style="text-align:right">Mağaza İndirimi : </th><th style="text-align:right">' . number_format($toplam * 0.15, 2) . ' TL</th></tr>';
                $foot .= '<tr><th></th><th style="text-align:right">Toplam : </th><th style="text-align:right">' . number_format($toplam * 0.85, 2) . ' TL</th></tr>';
            } else {
                $foot .= '<tr><th></th><th style="text-align:right">Toplam : </th><th style="text-align:right">' . number_format($toplam, 2) . ' TL</th></tr>';
            }

            $out .= '<div class="sepet">
						<table class="table">
    						<thead><tr><th>Hizmet Adı</th><th>Süre</th><th width="100px" style="text-align:right;">Fiyat</th></tr></thead>
    						' . $lines . '
    						<tfoot>' . $foot . '</foot>
    					</table> 
    					<input type="hidden" name="id" value="' . $_REQUEST['id'] . '">   				
    				</div>';
            $out .= '<hr>
    				
    				<table>
    						<tr><td width="150px"><h3>Ödeme</h3></td><td><img src="/static/img/visa_mastercard_4.gif"></td></tr>
    						<tr><td width="150px">Kart Numarası</td><td><input type="text" name="no"></td></tr>
    						<tr><td>Kart Tipi</td><td><select><option name="1">Visa</option><option name="1">Master Card</option></select></td></tr>
    						<tr><td>Son Kullanma Tarihi</td><td>
    							<select name="ay"> <option value="1">01</option> <option value="2">02</option> <option value="3">03</option> <option value="4">04</option> <option value="5">05</option> <option value="6">06</option> <option value="7">07</option> <option value="8">08</option> <option value="9">09</option> <option value="10">10</option> <option value="11">11</option> <option value="12">12</option> </select>
    							<select name="yil"> ' . $yil . '</select>
    						</td></tr>
    						<tr><td>CVC</td><td><input type="text" name="no"></td></tr>
    					</table><br><br>
    				<input type="submit" name="btnOde" value="Ödemeyi Tamamla" class="btn btn-success"> <a href="/index.php?b=uye/ilan/doping&id=' . $_REQUEST['id'] . '" class="btn">Geri Dön</a>';

            $out = $this->get_navi() . '<form method="post" action="/index.php?b=uye/ilan/odeme"><div class="doping">' . $this->get_message() . '<h3>Sepetiniz</h3>' . $out . '</div><input type="hidden" name="id" value="' . $_REQUEST['id'] . '"></form>';

            $out .= '<script>
    					$(window).load(function(){
    						function hesapla()
    						{
	    						var toplam = 0;
	    						$(".dd input:checked").each(function(){
	    							toplam += parseFloat($("span",$(this).parent()).html().split(" ")[0]);
	    						});
    				
    							$("td.toplam").html(toplam.toFixed(2)+" TL");
					    	}
    				
							hesapla();  

    						$(".dd input").change(function(){ hesapla(); });
    					});
    				</script>';

            return $out;
        }

        /*
    	 * ilan listesi
    	*/

        if ($requests[0] == 'yayindisi') {
            $this->add_navi('Yayında Olmayan İlanlar', '#');
            $where = ' and e.yayin_durum>=10';
        } else if ($requests[0] == 'tekraryayin') {
            header('Location: index.php?b=uye/ilan/doping&id=' . $_GET['id']);
            exit();
        } else $where = 'and e.yayin_durum<10';

        $grid = @factory::get('grid');

        if (site::is_uye() || site::is_yazar()) {
            $where .= ' AND e.uye_id=' . $_SESSION['uye']['id'];
        }

        $where .= $_GET['uye_id'] ? ' and u.id=' . $_GET['uye_id'] : '';
        $query = "SELECT e.*,u.id as uye_id,u.ad as uye_ad,u.ad,ifnull(concat(d.id,'.',d.uzanti),'noimage.jpg') as foto FROM ilan e left outer join uye u on(e.uye_id=u.id) left outer join dosya d on(d.ref_id=e.ilan_id and d.ref_name='ilan' and d.sira=1) where 1=1 $where {filter} group by e.ilan_id";

        $grid->setLink('?b=uye/ilan');
        $grid->search->add(array('type' => 'equal', 'name' => 'ilan_id', 'title' => 'NO', 'prefix' => 'e', 'class' => 'w1'));
        $grid->search->add(array('type' => 'like', 'name' => 'baslik', 'title' => 'İlan Başlığı', 'prefix' => 'e', 'class' => 'w1'));
        $grid->search->add(array('type' => 'like', 'name' => 'ad', 'title' => 'Üye Adı', 'prefix' => 'u', 'class' => 'w1'));
        //$grid -> search->add(array('type'=>'listbox','name'=>'onay','title'=>'Onay Durumu','component'=>html::selecta($ilan->param['yayin'],'onay',$durum,'-Tüm Durumlar-','issel'),'prefix'=>'e'));
        $grid->query($query, 'tarih', 'd');
        $grid->addCol(array('type' => 'foto', 'name' => 'foto', 'title' => '', 'width' => '70px', 'search' => true));
        $grid->addCol(array('type' => 'int', 'name' => 'ilan_id', 'title' => 'No', 'sort' => true, 'width' => '70px', 'search' => true));
        $grid->addCol(array('type' => 'emlak', 'name' => 'baslik', 'title' => 'İlan', 'sort' => true, 'search' => 1));
        $grid->addCol(array('type' => 'string', 'name' => 'uye_ad', 'title' => 'Üye', 'link' => '?b=admin/uye&id=uye_{id}'));
        $grid->addCol(array('type' => 'date', 'name' => 'tarih', 'title' => 'Kayıt', 'sort' => true, 'search' => 1));
        $grid->addCol(array('type' => 'array', 'name' => 'yayin_durum', 'title' => 'Yayın Durumu', 'array' => site::$yayin_durum));
        //if(site::is_uye() && $requests[0] != 'yayindisi') $grid -> addCol(array('type'=>'link','name'=>'doping','title'=>'','value'=>'Doping Yap','link'=>'/index.php?b=uye/ilan/doping&id={ilan_id}'));
        if (site::is_admin()) $grid->addCol(array('type' => 'icon', 'name' => 'yonet', 'class' => 'icon-star', 'title' => 'Doping Düzenle', 'value' => 'Ekstra', 'link' => '?b=uye/ilan/dopingduzenle&id={ilan_id}', 'extra' => 'data-toggle="modal"'));
        if ($requests[0] != 'yayindisi') $grid->addCol(array('type' => 'icon', 'name' => 'duzen', 'title' => 'Düzenle', 'link' => '?b=uye/ilan/duzenle&id={ilan_id}', 'class' => 'icon-edit '));
        if ($requests[0] != 'yayindisi') $grid->addCol(array('type' => 'icon', 'name' => 'sil', 'title' => 'Yayından Kaldır', 'link' => '?b=uye/ilan/yayindankaldir&id={ilan_id}', 'class' => 'icon-remove'));
        if ($requests[0] == 'yayindisi') $grid->addCol(array('type' => 'icon', 'name' => 'sil', 'title' => 'Tekrar Yayına Al', 'link' => '?b=uye/ilan/tekraryayin&id={ilan_id}', 'class' => 'icon-refresh', 'confirm' => 'İlanınız tekrar yayına alınacak, emin misiniz?'));
        $grid->ifEmpty('İlan Bulunamadı.');
        $grid->addButton('Yeni İlan', '?b=uye/ilan/yeni');
        $grid->setRow(' dbid="{id}"');
        $grid->addPager(50);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        return '<div class="span12">' . $out . '</div>';
    }

    function ajax_doping_duzenle() {
        $this->db->set('ilan', $_REQUEST['id'], array(
            'doping_manset' => $_POST['doping_manset'],
            'doping_manset2' => $_POST['doping_manset2'],
            'doping_acil' => $_POST['doping_acil'],
            'doping_ara' => $_POST['doping_ara'],
            'doping_fiyat' => $_POST['doping_fiyat']
        ), 'ilan_id');

        echo 1;
        exit();
    }

    function favori($request) {
        if ($request[0] == 'uye') {
            if ($request[1] == 'uyecikar') {
                $this->db->sorgu("delete from favori where uye_id=%d and takipci_id=%d", fi($_GET['id']), $_SESSION['uye']['id']);
                $this->add_message('Üye favorilerinizden çıkarıldı.', 'success');
            }

            $this->add_navi('Favori Üyelerim', '#');

            $grid = @factory::get('grid');

            $query = "select u.* from uye u, favori f where u.id=f.uye_id and f.takipci_id=" . $_SESSION['uye']['id'];

            $grid->setLink('?b=admin');
            $grid->query($query);
            $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'No', 'sort' => true, 'width' => '70px', 'search' => true));
            $grid->addCol(array('type' => 'string', 'name' => 'ad', 'title' => 'Üye Adı', 'sort' => true, 'search' => 1));
            $grid->addCol(array('type' => 'link', 'name' => 'detay', 'title' => '', 'value' => 'Üyenin İlanları', 'link' => '/index.php?b=ilan&uye_id={id}'));
            $grid->addCol(array('type' => 'icon', 'name' => 'sil', 'title' => 'Favorilerimden Çıkar', 'link' => '?b=uye/favori/uye/uyecikar&id={id}', 'class' => 'icon-remove', 'alert' => 'Uye favorilerinizden çıkarılıyor, emin misiniz?'));
            $grid->ifEmpty('Favori Üye Bulunamadı.');
            $grid->setRow(' dbid="{id}"');
            $grid->addPager(50);

            $out .= $this->get_navi();
            $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
            $out .= $this->get_message();
            $out .= $grid->getTop(1);
            $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

            return '<div class="span12">' . $out . '</div>';

        } else {
            if ($request[0] == 'ilancikar') {
                $this->db->sorgu("delete from favori where ilan_id=%d and takipci_id=%d", fi($_GET['id']), $_SESSION['uye']['id']);
                $this->add_message('İlan favorilerinizden çıkarıldı.', 'success');
            }

            $this->add_navi('Favori İlanlarım', '#');

            $grid = @factory::get('grid');

            $query = "SELECT e.*,u.id as uye_id,u.ad as uye_ad,u.ad,ifnull(concat(d.id,'.',d.uzanti),'noimage.jpg') as foto FROM ilan e left outer join uye u on(e.uye_id=u.id) left outer join dosya d on(d.ref_id=e.ilan_id and d.ref_name='ilan' and d.sira=1), favori f  where e.ilan_id=f.ilan_id and f.takipci_id=" . $_SESSION['uye']['id'] . "  $where group by e.ilan_id";

            $grid->setLink('?b=admin');
            $grid->query($query, 'tarih', 'd');
            $grid->addCol(array('type' => 'foto', 'name' => 'foto', 'title' => '', 'width' => '70px', 'search' => true));
            $grid->addCol(array('type' => 'int', 'name' => 'ilan_id', 'title' => 'No', 'sort' => true, 'width' => '70px', 'search' => true));
            $grid->addCol(array('type' => 'emlak', 'name' => 'baslik', 'title' => 'İlan', 'sort' => true, 'search' => 1));
            $grid->addCol(array('type' => 'string', 'name' => 'uye_ad', 'title' => 'Üye'));
            $grid->addCol(array('type' => 'link', 'name' => 'detay', 'title' => '', 'value' => 'İlan Detayı', 'link' => '/ilan/{link}-{ilan_id}'));
            $grid->addCol(array('type' => 'array', 'name' => 'yayin_durum', 'title' => '', 'array' => site::$yayin_durum));
            if ($requests[0] != 'yayindisi') $grid->addCol(array('type' => 'icon', 'name' => 'sil', 'title' => 'Favorilerimden Çıkar', 'link' => '?b=uye/favori/ilancikar&id={ilan_id}', 'class' => 'icon-remove', 'alert' => 'İlan favorilerinizden çıkarılıyor, emin misiniz?'));
            $grid->ifEmpty('Favori İlan Bulunamadı.');
            $grid->setRow(' dbid="{id}"');
            $grid->addPager(50);

            $out .= $this->get_navi();
            $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
            $out .= $this->get_message();
            $out .= $grid->getTop(1);
            $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

            return '<div class="span12">' . $out . '</div>';

        }
    }

    function odemeler($request = '') {
        $this->add_navi('Ödemeler', '#');

        if ($request[0] == 'sil' && site::is_admin()) {
            $this->db->sorgu("delete from odeme where id=%d", fi($_GET['id']));
            $this->add_message('Ödeme Silindi.', 'success');
        } elseif ($request[0] == 'detay') {
            if ($odeme = $this->db->sorgu("select * from odeme where id=%d %s", fi($_GET['id']), site::is_admin() ? '' : ' and uye_id=' . $_SESSION['uye']['id'])->satirObj()) {
                $odeme->aciklama = unserialize($odeme->aciklama);
                $cat = $odeme->kategori;
                foreach ($odeme->aciklama as $i => $j) {
                    $lines .= '<tr><td>' . site::$fiyatlar[$cat][$i][0] . '</td><td>' . ($i == 'yayin' ? '2 Ay' : '2 Hafta') . '</td><td style="text-align:right;">' . number_format(site::$fiyatlar[$cat][$i][1], 2) . ' TL</td></tr>';
                    $toplam += site::$fiyatlar[$cat][$i][1];
                }

                if ($odeme->magaza && ($odeme->kategori != 1)) {
                    $foot .= '<tr><th style="text-align:right">Ara Toplam : </th><th style="text-align:right">' . number_format($toplam, 2) . ' TL</th></tr>';
                    $foot .= '<tr><th style="text-align:right">Mağaza İndirimi : </th><th style="text-align:right">' . number_format($toplam * 0.15, 2) . ' TL</th></tr>';
                    $foot .= '<tr><th style="text-align:right">Toplam : </th><th style="text-align:right">' . number_format($toplam * 0.85, 2) . ' TL</th></tr>';
                } else {
                    $foot .= '<tr><th></th><th style="text-align:right">Toplam : </th><th style="text-align:right">' . number_format($toplam, 2) . ' TL</th></tr>';
                }

                $out .= '<div class="sepet">
	    					<h5 style="padding-left:7px;">Ödeme Detayı</h5>
							<table class="table">
	    						<thead><tr><th>Hizmet Adı</th><th>Süre</th><th width="100px" style="text-align:right;">Fiyat</th></tr></thead>
	    						' . $lines . '
	    						<tfoot>' . $foot . '</foot>
	    					</table>
	    				</div>';

                if ($odeme->kategori == 1) {
                    $magaza = $this->db->sorgu("select * from magaza where id=%d", $odeme->ilan_id)->satirObj();
                    $out .= ' <div style="padding-left:7px;"><h5>Ürün Detayı</h5><b>Magağaza Adı : </b> ' . $magaza->magaza_adi . '<br><a href="/index.php?b=ilan&magaza_id=' . $odeme->ilan_id . '">Mağaza Sayfası</a></div><br><br>';
                } else {
                    $ilan = $this->db->sorgu("select * from ilan where ilan_id=%d", $odeme->ilan_id)->satirObj();
                    $out .= '<div style="padding-left:7px;"><h5 >Ürün Detayı</h5><b>İlan No: </b> ' . $ilan->ilan_id . '<br><b>İlan Başlığı: </b> ' . $ilan->baslik . '<br><a href="/ilan/' . $ilan->link . '-' . $odeme->ilan_id . '">İlan Sayfası</a></div><br><br>';
                }

                echo $out . (site::is_admin() ? ' <br><hr> <a href="#" class="btn btn-small print" style="margin-left:10px;"><i class="icon-print"></i> Yazdır</a><br><br>' : '');
            } else {
                echo $this->create_message('Böyle bir ödeme bulunamadı!', 'error');
            }
            exit();

        }

        $grid = @factory::get('grid');

        $query = "SELECT o.*,u.ad FROM odeme o, uye u where o.uye_id=u.id " . (site::is_admin() ? '' : ' and uye_id=' . $_SESSION['uye']['id']);

        $grid->setLink('?b=uye/odemeler');
        $grid->query($query);
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'No', 'sort' => true, 'width' => '70px', 'search' => true));
        $grid->addCol(array('type' => 'string', 'name' => 'ad', 'title' => 'Üye Adı', 'sort' => true, 'search' => 1));
        $grid->addCol(array('type' => 'datetime', 'name' => 'tarih', 'title' => 'Tarih', 'sort' => true, 'search' => 1));
        $grid->addCol(array('type' => 'link', 'name' => 'detay', 'title' => '', 'value' => 'Ödeme Detayı', 'link' => '/index.php?b=uye/odemeler/detay&id={id}', 'extra' => ' data-toggle="modal"'));
        $grid->addCol(array('type' => 'money', 'name' => 'toplam', 'currency' => 'TL', 'title' => 'Tutar', 'sort' => true, 'search' => 1));
        if (site::is_admin()) $grid->addCol(array('type' => 'icon', 'name' => 'sil', 'title' => 'Ödemeyi Sil', 'link' => '?b=uye/odemeler/sil&id={id}', 'class' => 'icon-remove', 'confirm' => 'Ödeme silinecek , emin misiniz?'));
        $grid->ifEmpty('Ödeme Bulunamadı.');
        $grid->setRow(' dbid="{id}"');
        $grid->addPager(50);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        return '<div class="span12">' . $out . '</div>
    			<script src="/static/' . THEME . '/js/jquery.printElement.min.js"></script>
    			<script>
    				$(document).ready(function(){
    					$("a.print").live("click",function(){
    						$("#dialog").printElement({
            overrideElementCSS:[
		"style.css",
		{ href:"/static/css/style.css",media:"print"}]
            });
    					});
    				});
    			</script>
    			';
    }

    function uyeadmin($requests = '') {
        if (!site::is_admin()) return $this->create_message('Bu sayfaya erişim yetkiniz yoktur.', 'error');

        $tip = $requests[0];
        $this->add_navi('Üye Yönetimi', '?b=uye/uyeadmin');

        if ($requests[0] == 'duzenle') {
            $id = $_REQUEST['id'];

            if ($_POST['btnKaydet']) {
                $id = $this->db->set('uye', $id, array('ad' => $_POST['ad'], 'eposta' => $_POST['eposta'], 'tel' => $_POST['tel'], 'sehir' => $_POST['sehir'], 'ulke' => $_POST['ulke']));
                $this->add_message('Kaydedildi.', 'success');

                $_REQUEST = null;
                return $this->uyeadmin();
            }

            $this->add_navi('Düzenle', '#');

            $uye = $this->db->sorgu("select * from uye where id=%d", $id)->satirObj();
            $out .= $this->get_navi();
            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Ad Soyad</b></td><td><input type="text" name="ad" value="' . $uye->ad . '"></td></tr>
	    					<tr><td><b>Eposta</b></td><td><input type="text" name="eposta" value="' . $uye->eposta . '"></td></tr>
	    					<tr><td><b>Telefon</b></td><td><input type="text" name="tel" value="' . $uye->tel . '"></td></tr>
	    					<tr><td><b>Şehir</b></td><td><input type="text" name="sehir" value="' . $uye->sehir . '"></td></tr>
	    					<tr><td><b>Şehir</b></td><td><input type="text" name="ulke" value="' . $uye->ulke . '"></td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
	    				<input type="hidden" name="id" value="' . $uye->id . '">
    				</form><br><br>';

            return '<div class="span12">' . $out . '</div>';
        }

        if ($requests[0] == 'sil') {
            $this->db->del('uye', $_GET['id']);
            $this->add_message('Üye silindi.', 'success');
            $_REQUEST = null;
        }

        $grid = factory::get('grid');

        $query = "SELECT * FROM uye";

        $grid->setLink('?b=uye/uyeadmin');
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'ID', 'sort' => true, 'width' => '90px', 'search' => true, 'width' => '60'));
        $grid->addCol(array('type' => 'string', 'name' => 'ad', 'title' => 'Ad Soyad', 'width' => '200px'));
        $grid->addCol(array('type' => 'string', 'name' => 'eposta', 'title' => 'Eposta'));
        $grid->addCol(array('type' => 'string', 'name' => 'ulke', 'title' => 'Ülke'));
        $grid->addCol(array('type' => 'string', 'name' => 'sehir', 'title' => 'Şehir'));
        $grid->addCol(array('type' => 'datetime', 'name' => 'kayit_tarihi', 'title' => 'Kayıt'));
        $grid->addCol(array('type' => 'icon', 'name' => 'duz', 'title' => 'Düzenle', 'class' => 'icon-edit', 'link' => '?b=uye/uyeadmin/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/uyeadmin/sil&id={id}', 'confirm' => 'Üye silinecek, emin misiniz?'));
        $grid->query($query, 'id', 'd');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        return '<div class="span12">' . $out . '</div>';
    }

    function anket($requests = '') {
        if (!site::is_admin()) return $this->create_message('Bu sayfaya erişim yetkiniz yoktur.', 'error');

        $tip = $requests[0];
        $this->add_navi('Anket Yönetimi', '?b=uye/anket');

        if ($requests[0] == 'yeni') {
            if ($_POST['ekle']) {
                $a = $_POST;
                foreach ($a['v'] as $i => $b) if ($b) $meta[$i] = array($b, 0);
                $id = $this->db->add('blog', array('baslik' => $a['title'], 'tip' => 'anket', 'icerik' => serialize($meta), 'link' => lifos::clean_string_for_link($a['title']), 'tarih_yayin' => lifos::db_data_time()));
                $this->add_message('Kaydedildi.', 'success');

                $_REQUEST = null;
                return $this->anket();
            }

            $this->add_navi('Yeni', '#');

            $out .= $this->get_navi();
            $out .= '<form method="post" enctype="multipart/form-data"><br>
    					<table class="form wa">
						 	<tr><td width=150px>Anket Metni :</td><td><input type="text" name="title" class="istext" style="width:500px" title="Anketin konusu. En fazla 400 karakter iÃ§erebilir" maxlength="400"></td></tr>
						 	<tr><td>Seçenek 1:</td><td><input type="text" name="v[]" class="istext" title="En fazla 10, en az 2 seçenek."></td></tr>
						 	<tr><td>Seçenek 2:</td><td><input type="text" name="v[]" class="istext"></td></tr>
						 	<tr><td>Seçenek 3:</td><td><input type="text" name="v[]" class="istext"></td></tr>
						 	<tr><td>Seçenek 4:</td><td><input type="text" name="v[]" class="istext"></td></tr>
						 	<tr><td>Seçenek 5:</td><td><input type="text" name="v[]" class="istext"></td></tr>
						 	<tr><td>Seçenek 6:</td><td><input type="text" name="v[]" class="istext"></td></tr>
						 	<tr><td>Seçenek 7:</td><td><input type="text" name="v[]" class="istext"></td></tr>
						 	<tr><td>Seçenek 8:</td><td><input type="text" name="v[]" class="istext"></td></tr>
						 	<tr><td>Seçenek 9:</td><td><input type="text" name="v[]" class="istext"></td></tr>
						 	<tr><td>Seçenek 10:</td><td><input type="text" name="v[]" class="istext"></td></tr>
						 	<tr><td></td><td><input type="submit" name="ekle" value="Kaydet"></td></tr>
						 </table>
    				</form><br><br>';

            return '<div class="span12">' . $out . '</div>';
        } else if ($requests[0] == 'duzenle') {
            $id = $_GET['id'];

            if ($_POST['ekle']) {
                $a = $_POST;
                foreach ($a['v'] as $i => $b) if ($b) $meta[$i] = array($b, 0);
                $id = $this->db->set('blog', $id, array('baslik' => $a['title'], 'tip' => 'anket', 'icerik' => serialize($meta), 'link' => lifos::clean_string_for_link($a['title'])));
                $this->add_message('Kaydedildi.', 'success');

                $_REQUEST = null;
                return $this->anket();
            }

            $this->add_navi('Düzenle', '#');

            $anket = $this->db->sorgu("select * from blog where id=%d", $id)->satirObj();
            $detay = unserialize($anket->icerik);
            $out .= $this->get_navi();
            $out .= '<form method="post" enctype="multipart/form-data"><br>
    					<table class="form wa">
						 	<tr><td width=150px>Anket Metni :</td><td><input type="text" name="title" class="istext" style="width:500px" maxlength="400" value="' . $anket->baslik . '"></td></tr>';

            foreach ($detay as $i => $a) $out .= '<tr><td>Seçenek ' . ($i + 1) . ':</td><td><input type="text" name="v[]" value="' . $a[0] . '" class="istext"></td></tr>';
            for ($i++; $i < 10; ++$i) $out .= '<tr><td>Seçenek ' . ($i + 1) . ':</td><td><input type="text" name="v[]" class="istext"></td></tr>';

            $out .= '<tr><td></td><td><input type="submit" name="ekle" value="Kaydet"></td></tr> </table> </form><br><br>';

            return '<div class="span12">' . $out . '</div>';
        }

        if ($requests[0] == 'sil') {
            $this->db->del('blog', $_GET['id']);
            $this->add_message('Anket silindi.', 'success');
            $_REQUEST = null;
        }

        $grid = factory::get('grid');

        $query = "SELECT * FROM blog where tip='anket'";

        $grid->setLink('?b=uye/anket');
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'ID', 'sort' => true, 'width' => '90px', 'search' => true, 'width' => '60'));
        $grid->addCol(array('type' => 'string', 'name' => 'baslik', 'title' => 'Başlık'));
        $grid->addCol(array('type' => 'icon', 'name' => 'duz', 'title' => 'Düzenle', 'class' => 'icon-edit', 'link' => '?b=uye/anket/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/anket/sil&id={id}', 'confirm' => 'Anket silinecek, emin misiniz?'));
        $grid->addButton('Yeni Anket', '?b=uye/anket/yeni');
        $grid->query($query, 'id', 'd');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        return '<div class="span12">' . $out . '</div>';
    }

    function magaza($request = '') {
        $this->add_navi('Mağaza', '#');

        if ($_POST['btnOlustur']) {
            $p = (object)$_POST;

            $sure = $p->sure == 'magaza1' ? 6 : 12;

            if ($id = $this->db->add('magaza', array('magaza_adi' => $p->ad, 'aciklama' => $p->bilgi, 'olusturma_tarihi' => lifos::db_data(), 'aktif' => 1))) {
                $this->db->set('uye', $_SESSION['uye']['id'], array('magaza_id' => $id));
                $this->db->sorgu("update magaza set bitis_tarihi=olusturma_tarihi+interval %d month where id=%d", $sure, $id);
                $this->db->add('odeme', array('ilan_id' => $id, 'uye_id' => $_SESSION['uye']['id'], 'tarih' => lifos::db_data_time(), 'toplam' => site::$fiyatlar[1][$p->sure][1], 'aciklama' => serialize(array($p->sure => 1)), 'magaza' => $id, 'kategori' => 1));
                $this->add_message('Mağazanız oluşturuldu. Artık sınırsız ilan girebilirsiniz. ', 'success');

                if (!$_FILES['logo']['error']) {
                    factory::get('imedit')->load($_FILES['logo']['tmp_name'])->scaleTo(150, 80)->save(DR . '/user/magaza/', $id . '.jpg');
                }

                $_REQUEST = $_POST = null;
                $_SESSION['uye']['magaza_id'] = $id;
                return $this->magaza();
            } else $this->add_message('Mağazanız oluşturulamadı. ', 'error');
        } elseif ($_POST['btnDuzenle']) {
            $p = (object)$_POST;

            $this->db->set('magaza', $p->magaza_id, array('magaza_adi' => $p->ad, 'aciklama' => $p->bilgi));

            $this->add_message('Mağazanız düzenlendi.', 'success');
            if (!$_FILES['logo']['error']) {
                factory::get('imedit')->load($_FILES['logo']['tmp_name'])->scaleTo(150, 80)->save(DR . '/user/magaza/', $p->magaza_id . '.jpg');
            }
            $_REQUEST = $_POST = null;
            return $this->magaza();
        }

        if ($request[0] == 'yeni') {
            $this->add_navi('Oluştur', '#');

            $out .= $this->get_navi();

            for ($i = date('Y'); $i < date('Y') + 15; $i++) {
                $yil .= '<option value="' . $i . '">' . $i . '</option>';
            }

            $out .= '<div class="magaza-yeni form wa" style="padding:5px;">
    					' . $this->get_message() . '
    					<form method="post" enctype="multipart/form-data">
	    				<h3>Mağaza Oluştur</h3>
	    				<p>
	    				PistonKafalar.com Kurumsal Üyelik (Galeri) Avantajları<br>
						<ul>
							<li>Cazip Fiyat ve Kesintisiz Müşteri Memnuniyeti</li>
							<li>Portföyünüzde ki Tüm Otomobil / Ürün İçin Sınırsız Sayıda İlan Ekleme Özelliği</li>
							<li>7 Gün 24 Saat Kesintisiz Sanal Mağaza Hizmeti</li>
							<li>İlan Başına 15 Fotoğraf Ekleyebilme</li>
							<li>Onay Beklemeden Anında Yayın İmkanı</li>
							<li>Düşük Abonelik Bedeli İle Kusursuz Hizmet ve Anında Satış Olanağı</li>
							<li>Vitrin İlanı, Kategori İlanı ve Diğer Birçok Ekstra Seçenekte Kesintisiz, Limitsiz ve Süresiz <b>Net %15 İndirim</b> Hakkı</li>
							<li>Marka Bilinirliği ve Farkındalık Yaratma</li>
							<li>İlan Verdiğiniz Otomobil / Ürün Hakkında Güncel Bilgilere Ulaşabilme Olanağı (Haber Sayfamız En Güncel Konuları, Dinamik Yazarları ve Zengin İçeriği İle Hemen Yanı Başınızda)
						ve Daha Birçok Fırsat Sizleri Bekliyor.</li>		
						</ul>
	    				</p>
						<br>
    					<table>
    						<tr><td><b>Mağaza Bilgeri</b></td><td></td></tr>
    						<tr><td width="150px">Mağaza Süresi</td><td><input type="radio" value="magaza1" name="sure" checked> 6 Aylık Mağaza - 499.00 TL<br> <input type="radio" value="magaza2" name="sure"> 12 Aylık Mağaza - 799.00 TL</td></tr>
    						<tr><td width="150px"></td><td><br>Her İki Mağaza Seçeneğinde de Sınırsız İlan Ekleyebilme<br><br></td></tr>
    						<tr><td>Mağaza Adı</td><td><input type="text" name="ad"></td></tr>
    						<tr><td>Mağaza Açıklaması</td><td><textarea name="bilgi" style="width:600px;height:150px"></textarea></td></tr>
    						<tr><td>Mağaza Logosu</td><td><input type="file" name="logo"></td></tr>
    						<tr><td><br><br><b>Ödeme Bilgileri</b></td><td></td></tr>
    						<tr><td>Kart Numarası</td><td><input type="text" name="no"></td></tr>
    						<tr><td>Son Kullanma Tarihi</td><td>
    							<select name="ay"> <option value="1">01</option> <option value="2">02</option> <option value="3">03</option> <option value="4">04</option> <option value="5">05</option> <option value="6">06</option> <option value="7">07</option> <option value="8">08</option> <option value="9">09</option> <option value="10">10</option> <option value="11">11</option> <option value="12">12</option> </select>
    							<select name="yil"> ' . $yil . '</select>
    						</td></tr>
    						<tr><td>CVC</td><td><input type="text" name="no"></td></tr>
    						<tr><td></td><td><input type="submit" name="btnOlustur" value="Oluştur" class="btn btn-success"></td></tr>
    					</table>
    					</form>
    				</div><br><br>';
            return $out;
        }

        $out .= $this->get_navi();

        $magaza = $this->db->sorgu("select magaza.* from magaza, uye where uye.id=%d and uye.magaza_id=magaza.id", $_SESSION['uye']['id'])->satirObj();
        $foto = file_exists(DR . '/user/magaza/' . $magaza->id . '.jpg') ? '<img src="/user/magaza/' . $magaza->id . '.jpg">' : '';

        if (!$magaza) return $this->magaza(array('yeni'));

        $out .= '<div class="magaza-yeni form wa" style="padding:5px;">
    				' . $this->get_message() . '
    				<form method="post" enctype="multipart/form-data">
    				<h3>Mağazam</h3>
    				<p>
    				PistonKafalar.com Kurumsal Üyelik (Galeri) Avantajları<br>
					<ul>
						<li>Cazip Fiyat ve Kesintisiz Müşteri Memnuniyeti</li>
						<li>Portföyünüzde ki Tüm Otomobil / Ürün İçin Sınırsız Sayıda İlan Ekleme Özelliği</li>
						<li>7 Gün 24 Saat Kesintisiz Sanal Mağaza Hizmeti</li>
						<li>İlan Başına 15 Fotoğraf Ekleyebilme</li>
						<li>Onay Beklemeden Anında Yayın İmkanı</li>
						<li>Düşük Abonelik Bedeli İle Kusursuz Hizmet ve Anında Satış Olanağı</li>
						<li>Vitrin İlanı, Kategori İlanı ve Diğer Birçok Ekstra Seçenekte Kesintisiz, Limitsiz ve Süresiz <b>Net %15 İndirim</b> Hakkı</li>
						<li>Marka Bilinirliği ve Farkındalık Yaratma</li>
						<li>İlan Verdiğiniz Otomobil / Ürün Hakkında Güncel Bilgilere Ulaşabilme Olanağı (Haber Sayfamız En Güncel Konuları, Dinamik Yazarları ve Zengin İçeriği İle Hemen Yanı Başınızda)
					ve Daha Birçok Fırsat Sizleri Bekliyor.</li>		
					</ul>
    				</p>
					<br>
    				<table>
    					<tr><td><b>Mağaza Bilgeri</b></td><td></td></tr>
    					<tr><td width="250px">Mağaza Oluşturma Tarihi</td><td>' . lifos::to_web_date($magaza->olusturma_tarihi) . '</td></tr>
    					<tr><td>Mağaza Süresi Sonlanma Tarihi</td><td>' . lifos::to_web_date($magaza->bitis_tarihi) . '</td></tr>
    					<tr><td>Mağaza Adı</td><td><input type="text" name="ad" value="' . $magaza->magaza_adi . '"></td></tr>
    					<tr><td>Mağaza Açıklaması</td><td><textarea name="bilgi"  style="width:600px;height:150px">' . $magaza->aciklama . '</textarea></td></tr>
    					<tr><td>Mağaza Logosu</td><td>' . $foto . '<br><input type="file" name="logo"></td></tr>
    					<tr><td></td><td><input type="submit" name="btnDuzenle" value="Düzenle" class="btn btn-success"></td></tr>
    				</table>
    				<input type="hidden" value="' . $magaza->id . '" name="magaza_id">
    				</form>
    			</div><br><br>';
        return $out;
    }

    function magazalar($request = '') {
        if (!site::is_admin()) return $this->create_message('Bu sayfaya erişim yetkiniz yoktur.', 'error');

        if ($request[0] == 'sil') {
            $this->db->sorgu("delete from magaza where id=%d", $_GET['id']);
            $this->add_message('Magaza silindi', 'success');
        }

        $this->add_navi('Mağazalar', '#');

        $grid = factory::get('grid');

        $query = "SELECT * FROM magaza";

        $grid->setLink('?b=uye/magazalar');
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'ID', 'sort' => true, 'width' => '90px', 'search' => true, 'width' => '60'));
        $grid->addCol(array('type' => 'string', 'name' => 'magaza_adi', 'title' => 'Mağaza Adı'));
        $grid->addCol(array('type' => 'date', 'name' => 'olusturma_tarihi', 'title' => 'Oluşturma Tarihi'));
        $grid->addCol(array('type' => 'date', 'name' => 'bitis_tarihi', 'title' => 'Oluşturma Tarihi'));
//    	$grid -> addCol(array('type'=>'icon','name'=>'duz','title'=>'Düzenle','class'=>'icon-edit','link'=>'?b=uye/anket/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/magazalar/sil&id={id}', 'confirm' => 'Mağaza silinecek, emin misiniz?'));
        $grid->query($query, 'id', 'd');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        return '<div class="span12">' . $out . '</div>';
    }

    private function kategori_agac($id) {
        global $site;

        $is = $site->get_param($id);
        do {
            $liste[] = $is->val;
            $id = $is->ust_id;
        } while ($is = $site->get_param($id));

        return implode(' > ', array_reverse($liste));
    }

    private function kategori_agac_list($id) {
        global $site;

        $is = $site->get_param($id);
        do {
            $liste[] = $is;
            $id = $is->ust_id;
        } while ($is = $site->get_param($id));

        return array_reverse($liste);
    }

    function yazar($requests = '') {
        $tip = $requests[0];

        if ($requests[0] == 'yeni') {
            $id = $_REQUEST['id'];

            if ($_POST['btnKaydet']) {
                $this->db->set('uye', $id, array('yetki' => implode(',', array_keys($_POST['yetki'])), 'tip' => 1, 'gizli' => $_POST['gizli'] ? 1 : 0));
                $this->add_message('Kaydedildi.', 'success');

                if (!$_FILES['file']['error']) {
                    factory::get('imedit')->load($_FILES['file']['tmp_name'])->scaleToWidth(50)->save(DR . '/user/yazar/', $id . '.jpg');
                }
                $_REQUEST = null;
                return $this->yazar();
            }

            $this->add_navi('Yazar Yönetimi', '?b=uye/yazar');
            $this->add_navi('Yeni', '#');

            $out .= $this->get_navi();
            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Yazar ID</b></td><td><input type="text" name="id"></td></tr>
	    					<tr><td><b>Fotoğraf (7x10)</b></td><td><input type="file" name="file"></td></tr>
	    					<tr><td><b>Yetki</b></td><td>' . site::get_yetki_editor(null) . '</td></tr>
	    					<tr><td><b>Gizli</b></td><td><input type="checkbox" name="gizli" value="1"> Yazarı listede gösterme</td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

            return '<div class="span12">' . $out . '</div>';
        }
        if ($requests[0] == 'duzenle') {
            $id = $_REQUEST['id'];

            if ($_POST['btnKaydet']) {
                $this->db->set('uye', $id, array('gizli' => $_POST['gizli'] ? 1 : 0, 'yetki' => implode(',', array_keys($_POST['yetki']))));
                $this->add_message('Kaydedildi.', 'success');

                if (!$_FILES['file']['error']) {
                    factory::get('imedit')->load($_FILES['file']['tmp_name'])->scaleToWidth(50)->save(DR . '/user/yazar/', $id . '.jpg');
                }
                $_REQUEST = null;
                return $this->yazar();
            }

            $uye = $this->db->sorgu("select * from uye where id=%d", $id)->satirObj();
            $this->add_navi('Yazar Yönetimi', '?b=uye/yazar');
            $this->add_navi('Düzenle', '#');

            if (file_exists(DR . '/user/yazar/' . $id . '.jpg')) {
                $file = '<img src="/user/yazar/' . $id . '.jpg"><br>';
            }

            $out .= $this->get_navi();
            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Yazar ID</b></td><td><input type="text" name="ad" value="' . $uye->ad . '" disabled></td></tr>
	    					<tr><td><b>Fotoğraf (7x10)</b></td><td>' . $file . '<input type="file" name="file"></td></tr>
	    					<tr><td><b>Yetki</b></td><td>' . site::get_yetki_editor($uye) . '</td></tr>
    						<tr><td><b>Gizli</b></td><td><input type="checkbox" name="gizli" value="1" ' . ($uye->gizli ? 'checked' : '') . '> Yazarı listede gösterme</td></tr>
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form>
    				<input type="hidden" name="id" value="' . $uye->id . '"><br><br>';

            return '<div class="span12">' . $out . '</div>';
        }

        if ($requests[0] == 'sil') {
            $this->db->set('uye', $_GET['id'], array('yetki' => '', 'tip' => 0));
            $this->add_message('Yazar üyeye çevirildi.', 'success');
            $_REQUEST = null;
        }

        $this->add_navi('Yazar Yönetimi', '?b=uye/yazar');

        $grid = factory::get('grid');

        $query = "SELECT * FROM uye where tip=1";

        $grid->setLink('?b=uye/yazar');
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'ID', 'sort' => true, 'width' => '90px', 'width' => '60'));
        $grid->addCol(array('type' => 'string', 'name' => 'ad', 'title' => 'Ad Soyad', 'width' => '200px'));
        $grid->addCol(array('type' => 'datetime', 'name' => 'kayit_tarihi', 'title' => 'Kayıt'));
        $grid->addCol(array('type' => 'link', 'name' => 'yazilar', 'title' => '', 'value' => 'Yazılar'));
        $grid->addCol(array('type' => 'icon', 'name' => 'duz', 'title' => 'Düzenle', 'class' => 'icon-edit', 'link' => '?b=uye/yazar/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/yazar/sil&id={id}', 'confirm' => 'Yazar silinecek, emin misiniz?'));
        $grid->addButton('Yeni Yazar', '?b=uye/yazar/yeni');
        $grid->query($query, 'id', 'd');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        return '<div class="span12">' . $out . '</div>';
    }

    function galeri($requests = '') {
        $tip = $requests[0];

        $this->add_navi('Galeri Yönetimi', '?b=uye/galeri');

        if ($requests[0] == 'yeni') {
            $id = $_REQUEST['id'];
            $uploader = factory::get('dosyalar', array('ref' => 'galeri'));

            if (!site::is_uye()) {
                $uploader2 = factory::get('dosyalar', array('ref' => 'manset'));
                $uploader2->configure(array('title' => 'Manşet Fotoğrafı Eklemek İçin Tıklayınız', 'type' => 'image', 'ref' => 'manset', 'editable' => 0, 'deletable' => 1, 'sortable' => 0, 'multiple_files' => 0, 'resize' => '640,640', 'crop' => '640,330', 'thumb' => '100,65', 'max_file_size' => '8MB'));
                $uploader2->button_width = 360;
            }

            if ($_POST['btnKaydet']) {
                $id = $this->db->add('blog', array('tip' => 'galeri', 'baslik' => $_POST['baslik'], 'uye_id' => $_SESSION['uye']['id'], 'icerik' => $_POST['icerik'], 'link' => lifos::clean_string_for_link($_POST['baslik']), 'tarih_yayin' => lifos::db_data_time(), 'video' => $_POST['video'], 'onay' => site::is_uye() ? 0 : 1));
                $gata = $this->db->hata();
                $this->add_message('Kaydedildi.', 'success');
                $uploader->configure(array('ref' => 'galeri'));
                $uploader->setFileRefId($id);

                if (!site::is_uye()) {
                    $uploader2->configure(array('ref' => 'manset'));
                    $uploader2->setFileRefId($id);
                }

                $_REQUEST = null;
                return $this->galeri();
            }

            $this->add_navi('Yeni', '#');

            $uploader->configure(array('title' => 'Galeriye Fotoğraf Eklemek İçin Tıklayınız', 'type' => 'image', 'ref' => 'galeri', 'editable' => 0, 'deletable' => 1, 'sortable' => 1, 'multiple_files' => 1, 'resize' => '800,800', 'thumb' => '100,100', 'max_file_size' => '8MB', 'max_file_number' => site::is_uye() ? 10 : 100));

            $out .= $this->get_navi();
            $out .= '<br><form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Başlık* </b></td><td><input type="text" name="baslik"></td></tr>
	    					<tr><td><b>Açıklama</b></td><td><textarea class="ckeditor" name="icerik"></textarea></td></tr>
    						' . (site::is_uye() ? '' : '<tr><td><b>Manşet</b></td><td>' . $uploader2->get_form() . '</td></tr>') . '
	    					<tr><td><b>Fotoğraflar</b></td><td>' . $uploader->get_form() . '</td></tr>
    						' . (site::is_uye() ? '' : '<tr><td><b>Video</b></td><td><input type="text" name="video"></td></tr>') . '
    						
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            $out .= '<script>
    					$(document).ready(function(){
    						$("input[name=btnKaydet]").click(function(){
    							
    							if(!$("input[name=baslik]").val()) {
    								alert("Lütfen başlık giriniz.");
    								return false;
    							}
    						});
    					});
    				</script>';

            return '<div class="span12">' . $out . '</div>';
        }
        if ($requests[0] == 'duzenle') {
            $id = $_REQUEST['id'];

            if (!site::is_uye()) {
                $uploader2 = factory::get('dosyalar', array('ref' => 'manset'));
                $uploader2->configure(array('title' => 'Manşet Fotoğrafı Eklemek İçin Tıklayınız', 'type' => 'image', 'ref' => 'manset', 'ref_id' => $id, 'editable' => 0, 'deletable' => 1, 'sortable' => 0, 'multiple_files' => 0, 'resize' => '640,640', 'crop' => '640,330', 'thumb' => '100,65', 'max_file_size' => '8MB'));
                $uploader2->button_width = 360;
            }
            $uploader = factory::get('dosyalar', array('ref' => 'galeri'));

            if ($_POST['btnKaydet']) {
                $this->db->set('blog', $id, array('baslik' => $_POST['baslik'], 'icerik' => $_POST['icerik'], 'link' => lifos::clean_string_for_link($_POST['baslik']), 'video' => $_POST['video']));
                $this->add_message('Kaydedildi.', 'success');
                $uploader->configure(array('ref' => 'galeri', 'ref_id' => $id));
                //$uploader->setFileRefId($id);
                if (!site::is_uye()) {
                    $uploader2->setFileRefId($id);
                }
                $_REQUEST = null;
                return $this->galeri();
            }

            $blog = $this->db->sorgu("select * from blog where id=%d", $id)->satirObj();
            $this->add_navi('Düzenle', '#');

            $uploader->configure(array('title' => 'Galeriye Fotoğraf Eklemek İçin Tıklayınız', 'type' => 'image', 'ref' => 'galeri', 'ref_id' => $blog->id, 'editable' => 0, 'deletable' => 1, 'sortable' => 1, 'multiple_files' => 1, 'resize' => '800,800', 'thumb' => '100,100', 'max_file_size' => '8MB', 'max_file_number' => site::is_uye() ? 10 : 100));

            $out .= $this->get_navi();
            $out .= '<form method="post" enctype="multipart/form-data">
    					<table class="wa" style="width:100%">
	    					<tr><td><b>Başlık</b></td><td><input type="text" name="baslik" value="' . $blog->baslik . '"></td></tr>
	    					<tr><td><b>Açıklama</b></td><td><textarea class="ckeditor" name="icerik">' . $blog->icerik . '</textarea></td></tr>
    						' . (site::is_uye() ? '' : '<tr><td><b>Manşet</b></td><td>' . $uploader2->get_form() . '</td></tr>') . '
	    					<tr><td><b>Fotoğraflar</b></td><td>' . $uploader->get_form() . '</td></tr>
	    					' . (site::is_uye() ? '' : '<tr><td><b>Video</b></td><td><input type="text" name="video" value="' . $blog->video . '"></td></tr>') . '
	    					<tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn btn-success"></td></tr>
    					</table>
    				</form><br><br>';

            $out .= '<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>';
            return '<div class="span12">' . $out . '</div>';
        }

        if ($requests[0] == 'sil') {
            $this->db->del('blog', $_GET['id']);
            factory::get('dosyalar')->deleteByRef('galeri', $_GET['id']);
            $this->add_message('Galeri silindi.', 'success');
            $_REQUEST = null;
        }

        if (site::is_uye() || site::is_yazar()) {
            $where = ' AND b.uye_id=' . $_SESSION['uye']['id'];
        }

        $grid = factory::get('grid');
        $query = "SELECT b.*,u.ad,u.id as uye_id,if(u.id=1,0,1) as kimden FROM blog b,uye u where b.tip='galeri' and b.uye_id=u.id $where";
        $grid->setLink('?b=uye/galeri');
        $grid->addCol(array('type' => 'int', 'name' => 'id', 'title' => 'ID', 'sort' => true, 'width' => '60'));
        $grid->addCol(array('type' => 'string', 'name' => 'baslik', 'title' => 'Galeri Adı'));
        $grid->addCol(array('type' => 'string', 'name' => 'ad', 'title' => 'Üye Adı'));
        if (site::is_admin()) $grid->addCol(array('type' => 'array', 'name' => 'kimden', 'title' => 'Tip', 'array' => array('Piston', 'Uye Galeri'), 'sort' => 1));
        $grid->addCol(array('type' => 'date', 'name' => 'tarih_yayin', 'title' => 'Kayıt'));
        if (site::is_admin()) $grid->addCol(array('type' => 'icon', 'name' => 'onay', 'title' => 'Onay', 'class' => 'icon-ok', 'ifClass' => function (&$v, $db) {
            $v['class'] = $db['onay'] ? 'icon-star' : 'icon-star-empty';
        }, 'link' => '#'));
        $grid->addCol(array('type' => 'icon', 'name' => 'duz', 'title' => 'Düzenle', 'class' => 'icon-edit', 'link' => '?b=uye/galeri/duzenle&id={id}'));
        $grid->addCol(array('type' => 'icon', 'name' => 'del', 'title' => 'Sil', 'class' => 'icon-remove', 'link' => '?b=uye/galeri/sil&id={id}', 'confirm' => 'Galeri silinecek, emin misiniz?'));
        $grid->addButton('Yeni Galeri', '?b=uye/galeri/yeni');
        $grid->ifEmpty('Henüz galeri yok!');
        $grid->query($query, 'id', 'd');
        $grid->addPager(25);

        $out .= $this->get_navi();
        $out .= '<form id="frmedit" name="frmedit" method="post" class="grid-arama">' . $grid->search->getBody() . '</form>';
        $out .= $this->get_message();
        $out .= $grid->getTop(1);
        $out .= '<div class="grid-holder">' . $grid->getBody() . '</div>';

        $out .= factory::get('js')->ready()->add("
        	$('.icon a[class*=icon-star]').click(function(){
        		var nv = $(this).hasClass('icon-star') ? 0 : 1;
    			$(this).attr('class','icon-star'+(nv?'':'-empty'));
        		$.post('?a=uye/blog_durum',{id:$(this).parent().siblings(':eq(0)').html(),v:nv});
        		return false;
    		});
		")->getAll();

        return '<div class="span12">' . $out . '</div>';
    }

    function ajax_yorum_durum() {
        if ($_POST['id']) {
            $this->db->set('blog_yorum', fi($_POST['id']), array('onay' => $_POST['v']));
        }
        exit();
    }

    function ajax_vitrin() {
        if ($_POST['id']) {
            $this->db->set('ilan', fi($_POST['id']), array('vitrin' => $_POST['v']), 'ilan_id');
        }
        exit();
    }

    function ajax_blog_durum() {
        if ($_POST['id']) {
            $this->db->set('blog', fi($_POST['id']), array('onay' => $_POST['v']));
        }
        exit();
    }

    private function get_kategori_check($sel = 0, $pre = '', $name = 'kategori') {
        foreach (site::$kategoriler as $k => $v) {
            if (($_SESSION['uye']['tip'] == site::U_YAZAR) && $_SESSION['uye']['yetki'] && !in_array($k, preg_split('/\,/', $_SESSION['uye']['yetki']))) continue;
            $opt .= '<option value="' . $k . '" ' . (isset($sel) && ($sel !== '') && ($sel == $k) ? 'selected' : '') . '>' . $v . '</option>';
        }

        return '<select name="' . $name . '">' . ($pre ? '<option value="">' . $pre . '</option>' : '') . $opt . '</select>';
    }

    function crop() {
        if (!($img = $_REQUEST['im'])) return;

        $uploader = factory::get('dosyalar');
        $file = $uploader->getFile($_REQUEST['im']);
        $maxDisplaySize = 730;

        if ($_GET['kaydet']) {
            $p = $_GET['n'];
            $r = $_GET['r'] > 1 ? $_GET['r'] : 1;

            factory::get('imedit')
                ->load(DR . '/user/files/' . $file->path)
                ->crop($p['x'] * $r, $p['y'] * $r, $p['w'] * $r, $p['h'] * $r, $_GET['tw'], $_GET['th'])
                ->save(DR . '/user/files/' . $file->path)
                ->wrapTo(350, 185)
                ->save(DR . '/user/files/wrap_' . $file->path);

            $uploader->setSize($file->id, $_GET['tw'], $_GET['th']);
            echo 1;
            exit();
        }

        $ii = getimagesize(DR . '/user/files/' . $file->path);

        $width = $file->width;
        $height = $file->height;
        $targetHeight = $_GET['th'];
        $targetWidth = $_GET['tw'];
        $targetAspectRatio = $targetWidth / $targetHeight;
        $aspectRatio = $width / $height;
        $displayRatio = $width >= $height ? ($width >= $maxDisplaySize ? $width / $maxDisplaySize : 1) : ($height >= $maxDisplaySize ? $height / $maxDisplaySize : 1);
        $displayWidth = $width / $displayRatio;
        $displayHeight = $height / $displayRatio;

        if ($targetAspectRatio >= $aspectRatio) {
            if ($displayWidth > $targetWidth) {
                $x1 = ($displayWidth - $targetWidth) / 2;
                $x2 = $displayWidth - $x1;
                $y1 = ($displayHeight - $targetHeight) / 2;
                $y2 = $displayHeight - $y1;
            } else {
                $x1 = 0;
                $x2 = $displayWidth;
                $temp = ($displayWidth / $targetWidth) * $targetHeight;
                $y1 = ($displayHeight - $temp) / 2;
                $y2 = $displayHeight - $y1;
            }
        } else {
            if ($height > $targetHeight) {
                $y1 = ($displayHeight - $targetHeight) / 2;
                $y2 = $displayHeight - $x1;
                $x1 = ($displayWidth - $targetWidth) / 2;
                $x2 = $displayWidth - $x1;
            } else {
                $y1 = 0;
                $y2 = $displayHeight;
                $temp = ($displayHeight / $targetHeight) * $targetWidth;
                $x1 = ($displayWidth - $temp) / 2;
                $x2 = $displayWidth - $x1;
            }
        }

        $minWidth = ceil($targetWidth * 0.66);
        $minHeight = ceil($targetHeight * 0.66);

        if ($minWidth > $width || $minHeight > $height) {
            $data['hata'] = $this->create_message('Bu fotoğraf kesmek istediğiniz boyutun çok altındadır. Daha büyük bir fotoğraf yükleyerek tekrar deneyiniz', 'error');
        }

        $ts = ceil($x1) . ',' . ceil($y1) . ',' . ceil($x2) . ',' . ceil($y2);

        $windowWidth = $width + 50 > $maxDisplaySize ? $width + 50 : $maxDisplaySize;
        $windowHeight = $height + 220 > $maxDisplaySize ? $height + 220 : $maxDisplaySize;

        $data['targetAspectRatio'] = ',aspectRatio:' . $targetAspectRatio;
        $data['windowWidth'] = $windowWidth;
        $data['windowHeight'] = $windowHeight;
        $data['minWidth'] = $minWidth;
        $data['minHeight'] = $minHeight;
        $data['ts'] = $ts;
        $data['img'] = $img;
        $data['targetWidth'] = $targetWidth;
        $data['targetHeight'] = $targetHeight;
        $data['displayRatio'] = $displayRatio;
        $data['file'] = $file;
        $data['maxDisplaySize'] = $maxDisplaySize;

        exit($this->view('crop', $data));
    }

    function editor_foto_yukle() {
        $name = uniqid() . 'jpg';
        factory::get('imedit')->load($_FILES['upload']['tmp_name'])->scaleTo(989, 989)->save(DR . '/user/editor/', $name);
        exit("<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(" . $_GET['CKEditorFuncNum'] . ",'/user/editor/" . $name . "')</script>");
    }

    function add_navi($title, $link, $remove = false) {
        if ($remove) $this->_navi = array();

        $this->_navi[] = '<a href="' . $link . '">' . $title . '</a>';
    }

    function get_navi() {
        return '<div class="uye-navi"><a href="?b=uye">Hesabım</a> → ' . @implode(' → ', $this->_navi) . '</div>';
    }

    /*
     * aday oturum açma sayfası
     * oturum açma eylemeninin gerçekleştirilmesi
     * 
     * @return string
     */
    function login() {
        $main = new main();
        if (($_SERVER['REMOTE_ADDR'] != '127.0.0.1') && !isset($_SERVER['HTTPS'])) {
            header("Location:https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            exit();
        }
        if ($_GET['ref'] == 'eticaret') $_SESSION['ref'] = $_GET['ref'];

        if ($_POST) {
            if (($eposta = $_POST['eposta']) && ($sifre = $_POST['sifre'])) {
                $this->_start_session($eposta, $sifre);
            } else {
                $this->add_message('Eposta adresinizi ve şifrenizi giriniz.', 'error');
            }
        }

        $data['sehirler'] = $this->db->sorgu('SELECT il FROM yerler group by il order by il')->liste();
        $data['ulkeler'] = $this->db->sorgu('SELECT ad FROM ulke order by ad')->liste();
        $this->add_navi('Üye Girişi', '#');
        $data['navi'] = $this->get_navi();
        $data['message'] = $this->get_message();
        $data['sag_menu_2'] = $main->sag_menu2();

        return $this->view('login', $data);
    }

    /*
     * aday şifre hatırlatma fonksiyonu
     */
    function unuttum() {
        $main = new main();
        if ($_POST['btnEpostaKontrol'] && $_POST['eposta']) {
            $aday = $this->db->sorgu("select * from uye where eposta='%s'", fi($_POST['eposta']))->satirObj();

            if ($aday) {
                $mail = factory::get('mailer');
                $sifre = substr(md5(rand(100000, 999999)), 0, 8);
                $this->db->set("uye", $aday->id, array('sifre' => md5($sifre)));
                $mail->fast_send($aday->eposta, $aday->ad . ' ' . $aday->soyad, 'PistonKafalar.com Şifreniz', 'Merhaba ' . $aday->ad . '<br><br>PistonKafalar.com şifreniz yenilenmiştir. Yeni giriş bilgileriniz şöyledir : <br><br>Eposta Adresi : ' . $aday->eposta . '<br>Şifre : ' . $sifre . '<br><br><b>PistonKafalar.com</b>');
            }

            $data['message'] = $this->create_message('Yeni şifreniz eposta adresinize gönderildi.') . '<br>';
        }

        $this->add_navi('Şifremi Unuttum', '#');
        $data['navi'] = $this->get_navi();
        $data['sag_menu_2'] = $main->sag_menu2();

        return $this->view('unuttum', $data);
    }

    /*
     * oturum kapatma işlemi
     */
    function logout() {
        unset($_SESSION['uye']);
        header('Location:index.php');
    }

    function mesaj($request) {
        $link = '/index.php?b=uye/mesaj';

        if ($request[0] == 'gonder') {
            if ($uye = $this->db->sorgu("select * from uye where id=%d", $_GET['to'])->satirObj()) {
                $baslik = $this->db->sorgu("select baslik from ilan where ilan_id=%d", $_GET['id'])->sonuc(0);

                //if($uye->tip == 2) $uye->ad = 'PitonKafalar.com';

                $this->add_navi('Mesaj Gönder', '#');

                $out = $this->get_navi() . '<form method="post" action="?b=uye/mesaj/giden">
                        <div class="msg" style="padding:5px;">
    						<h3>Mesaj Gönder</h3>
                            <b>Alıcı :<b> ' . $uye->ad . '<br><br>
                            <input name="baslik" type="text" style="width:300px;margin-bottom:10px" placeholder="Mesaj Konusu" value="' . ($baslik ? $baslik : '') . '"><br>
                            <textarea name="cevap" style="width:99%;height:100px;margin-bottom:10px" placeholder="Mesajınız en fazla 500 karakter olabilir"></textarea><br>
                            <input type="submit" name="btnGonder" value="Gönder" class="btn btn-success">
                            <input type="hidden" name="uye_id" value="' . $_GET['to'] . '">
                        </div>
                        </form>';

            } else {
                $out = 'Böyle bir alıcı yok.';
            }

            return $out;
        }

        if ($request[0] == 'gelen') {
            $this->add_navi('Gelen Mesajlar', $link . '/gelen');

            if ($request[1] == 'detay') {
                $m = $this->db->sorgu("SELECT e.*,u.id as uye_id, u.ad as uye_ad from mesaj e left outer join uye u on(e.uye_id=u.id) where e.id=%d", $_GET['id'])->satirObj();
                $this->add_navi($m->baslik, '#');

                $out = $this->get_navi() . '<br><form method="post" action="' . $link . '/giden">
                <div class="msg">
                <span>' . $m->tarih . '</span><b>' . $m->baslik . '</b> <p>' . $m->body . '</p><br>' . $m->uye_ad . '
                </div>
                <div class="msg">
                <input name="baslik" value="Cvp : ' . $m->baslik . '" type="text" style="width:300px;margin-bottom:10px"><br>
                <textarea name="cevap" style="width:99%;height:100px;margin-bottom:10px" placeholder="Cevaplayın"></textarea><br>
                <input type="submit" name="btnGonder" value="Gönder">
                <input type="hidden" name="uye_id" value="' . $m->uye_id . '">
                </div>
                </form>';

                return $out;
            } elseif ($request[1] == 'sil') {
                $this->db->sorgu("update mesaj set sil=sil^2 where id=%d and alici_id=%d", $_GET['id'], $_SESSION['uye']['id']);
                $msg = $this->create_message('Mesaj silindi.');
            }

            $grid = factory::get('grid');

            $query = "SELECT e.*,if(e.sil&2,1,0) as silindi,u.id as uye_id, u.ad as uye_ad from mesaj e left outer join uye u on(e.uye_id=u.id) where e.alici_id=" . $_SESSION['uye']['id'] . " having silindi=0";

            $grid->setLink($link);
            $grid->addCol(array('type' => 'string', 'name' => 'uye_ad', 'title' => 'Gönderen', 'sort' => true, 'search' => 1, 'width' => 150));
            $grid->addCol(array('type' => 'link', 'name' => 'baslik', 'title' => 'Başlık', 'link' => $link . '/gelen/detay&id={id}', 'sort' => true, 'search' => 1));
            $grid->addCol(array('type' => 'datetime', 'name' => 'tarih', 'title' => 'Tarih', 'sort' => true, 'search' => 1, 'width' => '150px'));
            $grid->addCol(array('type' => 'icon', 'name' => 'sil', 'link' => $link . '/gelen/sil&id={id}', 'class' => 'icon-remove', 'confirm' => 'Mesaj silinecek emin misiz?'));
            $grid->ifEmpty('Henüz gelen mesajınız yok.');
            $grid->query($query, 'e.tarih', 'd');
            $grid->addPager(50);
            $out .= '<form id="frmedit" name="frmedit" method="post">' . $grid->search->getBody() . '</form>';
            $out .= $grid->getTop();
            $out .= $grid->getBody();

            return $this->get_navi() . $msg . $out;

        } elseif ($request[0] == 'giden') {
            $this->add_navi('Giden Mesajlar', $link . '/giden');

            if ($request[1] == 'detay') {
                if ($m = $this->db->sorgu("SELECT e.*,u.id as uye_id, u.ad as uye_ad from mesaj e left outer join uye u on(e.alici_id=u.id) where e.id=%d and (e.alici_id=%d or e.uye_id=%d)", $_GET['id'], $_SESSION['uye']['id'], $_SESSION['uye']['id'])->satirObj()) {
                    $this->add_navi($m->baslik, '#');

                    $out = $this->get_navi();
                    $out .= '<form method="post" action="' . $link . '/giden"><br>
	                <div class="msg">
	                <span>' . $m->tarih . '</span><b>' . $m->baslik . '</b> <p>' . $m->body . '</p><br>' . $this->user->ad . '
	                </div>
	                <div class="msg">
	                <input name="baslik" value="Cvp : ' . $m->baslik . '" type="text" style="width:300px;margin-bottom:10px"><br>
	                <textarea name="cevap" style="width:99%;height:100px;margin-bottom:10px" placeholder="Cevaplayın"></textarea><br>
	                <input type="submit" name="btnGonder" value="Gönder">
	                <input type="hidden" name="uye_id" value="' . $m->uye_id . '">
	                </div>
	                </form>';
                } else {
                    $out = $this->create_message('Böyle bir mesaj yok!', 'error');
                }

                return $out;
            } elseif ($request[1] == 'sil') {
                $this->db->sorgu("update mesaj set sil=sil^1 where id=%d and uye_id=%d", $_GET['id'], $_SESSION['uye']['id']);
                $msg = $this->create_message('Mesaj silindi.');
            }

            if ($_POST['btnGonder']) {
                $id = $this->db->add("mesaj", array('baslik' => $_POST['baslik'], 'body' => $_POST['cevap'], 'tarih' => dbDateTime(), 'uye_id' => $_SESSION['uye']['id'], 'alici_id' => $_POST['uye_id']));
                $out .= $this->create_message('Mesajınız gönderildi.', 'success');
                $e = $this->db->sorgu("select u1.ad as gonderici,u2.ad as alici,u2.eposta from uye u1, uye u2 where u1.id=%d and u2.id=%d", $_SESSION['uye']['id'], $_POST['uye_id'])->satirObj();
                $mail = factory::get('mailer');
                $mail->fast_send($e->eposta, $e->ad, 'Mesajınız var!', 'Sayın <b>' . $e->alici . '</b><br><br><b>' . $e->gonderici . '</b> kullanıcımızdan "<b>' . fi($_POST['baslik']) . '</b>" başlıklı bir mesaj aldınız. Mesajınızı okumak için <a href="http://www.pistonkafalar.com/index.php?b=uye/mesaj/gelen/detay&id=' . $id . '">tıklayınız.</a><br><br>Piston Kafalar');
            }

            $grid = factory::get('grid');

            $query = "SELECT e.*,if(e.sil&1,1,0) as silindi,u.id as uye_id, u.ad as uye_ad from mesaj e left outer join uye u on(e.alici_id=u.id) where e.uye_id=" . $_SESSION['uye']['id'] . " having silindi=0";

            $grid->setLink($link);
            $grid->addCol(array('type' => 'string', 'name' => 'uye_ad', 'title' => 'Alıcı', 'sort' => true, 'search' => 1, 'width' => 150));
            $grid->addCol(array('type' => 'link', 'name' => 'baslik', 'title' => 'Başlık', 'link' => $link . '/giden/detay&id={id}', 'sort' => true, 'search' => 1));
            $grid->addCol(array('type' => 'datetime', 'name' => 'tarih', 'title' => 'Tarih', 'sort' => true, 'search' => 1, 'width' => '150px'));
            $grid->addCol(array('type' => 'icon', 'name' => 'sil', 'link' => $link . '/giden/sil&id={id}', 'class' => 'icon-remove', 'confirm' => 'Mesaj silinecek emin misiz?'));
            $grid->query($query, 'e.tarih', 'd');
            $grid->ifEmpty('Giden Mesaj Yok');
            $grid->addPager(50);
            $out .= '<form id="frmedit" name="frmedit" method="post">' . $grid->search->getBody() . '</form>';
            $out .= $grid->getTop();
            $out .= $grid->getBody();

            return $this->get_navi() . $msg . $out;

        }

    }

    function sikayet($requests = array()) {
        if ($requests[0] == 'yeni') {
            if ($_POST['btnGonder']) {
                $this->db->add("sikayet", array('baslik' => $_POST['baslik'], 'mesaj' => $_POST['cevap'], 'tarih' => dbDateTime(), 'uye_id' => $_SESSION['uye']['id']));
                $this->add_message('Şikayetiniz gönderildi.', 'success');
            }

            $baslik = $this->db->sorgu("select baslik from ilan where ilan_id=%d", $_REQUEST['id'])->sonuc(0);

            $this->add_navi('Hatalı İlan', '#');

            $out = $this->get_navi() . '<form method="post" action="?b=uye/sikayet/yeni">
	                        <div class="msg" style="padding:5px;">
	    						' . $this->get_message() . '
	    						<h3>Şikayet Formu</h3>
	                            <input name="baslik" type="text" style="width:300px;margin-bottom:10px" placeholder="Mesaj Konusu" value="Şikayet : ' . ($baslik ? $baslik : '') . '"><br>
	                            <textarea name="cevap" style="width:99%;height:100px;margin-bottom:10px" placeholder="Mesajınız en fazla 500 karakter olabilir">İlan No : ' . $_REQUEST['id'] . "\n" . '</textarea><br>
	                            <input type="submit" name="btnGonder" value="Gönder" class="btn btn-success">
	                            <input type="hidden" name="id" value="' . $_REQUEST['id'] . '">
	                        </div>
	                        </form>';

            return $out;
        } else if (site::is_admin()) {

            if ($requests[0] == 'detay') {
                $msg = $this->db->sorgu("select * from sikayet where id=%d", $_REQUEST['id'])->satirObj();
                echo '<div style="padding:14px;">' . $msg->baslik . '</strong><hr>adf asdf asf asfd asfdas fafd asfd asf asf asfd adf asfasdf asd sdgfhs dfgdsfg sdfg sfdg sdfg sdfgsdfg sdfg sdf gsdfgsdfgsdgf sdfgsd' . $msg->icerik . '</div><br>';
                exit();
            } elseif ($requests[0] == 'sil') {
                $this->db->sorgu("delete from sikayet where id=%d", $_REQUEST['id']);
                $this->add_message('Şikayet Silindi.', 'success');
            }

            $grid = factory::get('grid');
            $query = "SELECT e.*,u.id as uye_id, u.ad as uye_ad,u.eposta from sikayet e left outer join uye u on(e.uye_id=u.id)";

            $grid->setLink('/index.php?b=uye/sikayet');
            $grid->addCol(array('type' => 'string', 'name' => 'uye_ad', 'title' => 'Gönderen', 'sort' => true, 'search' => 1, 'width' => 90));
            $grid->addCol(array('type' => 'string', 'name' => 'eposta', 'title' => 'Eposta', 'sort' => true, 'search' => 1, 'width' => 150));
            $grid->addCol(array('type' => 'multi', 'name' => 'baslik', 'value' => '<b>{baslik}</b><br>{mesaj}', 'title' => 'Başlık', 'sort' => true, 'search' => 1, 'extra' => ' data-toggle="modal" title="Şikayet"'));
            $grid->addCol(array('type' => 'datetime', 'name' => 'tarih', 'title' => 'Tarih', 'sort' => true, 'search' => 1, 'width' => '150px'));
            $grid->addCol(array('type' => 'icon', 'name' => 'sil', 'link' => '/index.php?b=uye/sikayet/sil&id={id}', 'class' => 'icon-remove', 'confirm' => 'Şikayet silinecek emin misiz?'));
            $grid->query($query, 'e.tarih', 'd');
            $grid->ifEmpty('Şikayet Yok');
            $grid->addPager(50);

            $this->add_navi('Şikayetler', '#');
            $out .= $this->get_navi() . $this->get_message() . '<form id="frmedit" name="frmedit" method="post">' . $grid->search->getBody() . '</form>';
            $out .= $grid->getTop();
            $out .= $grid->getBody();

            return $out;
        }

    }

    /*
     * profil fotografı kırpma işlemini gerçekleştirir
     * 
     * @return string
     */
    function fotograf_kirp() {
        if (isset($_POST['btnKirp'])) {
            $img = factory::get('imedit');
            $img->load(DR . '/user/photo/' . $_POST['image']);
            $s = preg_split('/,/', $_POST['cord']);
            $img->crop($s[0], $s[1], $s[2], $s[3], 198, 198);
            $img->save(DR . '/user/photo/', $_POST['image']);
            $this->db->set('aday', $_SESSION['aday']['id'], array('foto' => $_POST['image']));
            $_SESSION['aday']['foto'] = $_POST['image'];
            $this->add_message('Fotoğrafınız kaydedildi.');
        }

        return preg_match('/aday\/cv/', $_SERVER['HTTP_REFERER']) ? $this->cv() : $this->index();
    }

    /*
     * dialog üzerinden oturum açma işlemini gerçekleştirir
     * 
     * @return string
     */
    public function ajax_login() {
        echo $this->_start_session($_POST['eposta'], $_POST['sifre'], false);
        exit();
    }

    /*
     * şehir ve ilçe listesini doldurmak için kullanılır
     * 
     * @return string
     */
    public function ajax_sehir_ilce() {

        if ($liste = $this->db->sorgu("SELECT s2.id, concat(s1.ad,' - ', s2.ad) as ad FROM secenek s1, secenek s2 where s1.id=s2.ust_id and s1.tip='sehir' having (ad like '%s') limit 100", '%' . $_POST['c'] . '%')->liste()) {

            echo json_encode($liste);
        } else echo 0;

        exit();
    }

    /*
     * ülke ve şehir listesini doldurmak için kullanılır
     * 
     * @return string
     */
    public function ajax_ulke_sehir() {
        if ($liste = $this->db->sorgu("select if(s2.id,s2.id,s1.id) as id,if(s2.ad is not null,concat(s1.ad,' - ',s2.ad),s1.ad) as ad from secenek s1 left outer join secenek s2 on(s1.id=s2.ust_id and s2.tip='sehir') where s1.tip='ulke' having ad like '%s' limit 100", '%' . $_POST['c'] . '%')->liste()) {
            echo json_encode($liste);
        } else echo 0;

        exit();
    }

    /*
     * yeni kayıt sırasında adayın eposta adresi 
     * daha önce sistemde kayıtlı mı kontrolü
     * 
     * @return bool
     */
    public function ajax_eposta() {
        echo @$this->db->sorgu("select count(*) from uye where eposta='%s'", fi($_GET['d']))->sonuc(0);

        exit();
    }

    /*
     * eğer bilgileri doğru ise oturum başlat
     * 
     * @params string $eposta
     * @params string $sifre
     * @params bool $locate
     */
    function _start_session($eposta, $sifre, $locate = 1, $ilk = 0) {
        if ($uye = $this->db->sorgu("select id,ad,eposta,cinsiyet,son_oturum_tarihi,tip,ticket,yetki,magaza_id,eticaret_id from uye where eposta='%s' and sifre='%s' limit 1", fi($eposta), md5($sifre))->satir()) {
            if ($uye['ticket'] != 1 && (!$ilk)) {
                $this->add_message('Eposta adresinizi doğrulayıp tekrar deneyiniz.', 'error');
                return 0;
            }

            $_SESSION['uye'] = $uye;

            /*
             * eticaret login
             * */
            $_SESSION['uye']['isim'] = $uye['ad'];
            $_SESSION['uye']['uye_id'] = $uye['eticaret_id'];
            $_SESSION['uye']['aktif'] = 1;
            $_SESSION['uye']['silindi'] = 0;

            $this->db->set('uye', $uye['id'], array('son_oturum_tarihi' => dbDateTime()));

            if ($_SESSION['ref'] == 'eticaret') {
                unset($_SESSION['ref']);
                header('Location:https://magaza.pistonkafalar.com');
                exit();
            }

            if ($locate) {
                header('Location:index.php?b=uye');
                exit();
            }

            return 1;
        } else $this->add_message('Eposta adresiniz ve/veya şifreniz yanlış.', 'error');

        return 0;
    }

    function aktivasyon() {
        if (($ticket = fi($_GET['ticket'])) && ($id = fi($_GET['id']))) {
            if ($uye = $this->db->sorgu("select * from uye where id=%d and ticket=%d", $id, $ticket)->satirObj()) {
                $this->db->set('uye', $id, array('ticket' => 1));
                $this->add_message('Üyeliğiniz aktif edilmiştir.', 'success');

                if ($_SESSION['uye']) return $this->index();
                else $this->login();
            } else $this->add_message('Böyle bir üye bulunamadı.', 'error');
        } else $this->add_message('Ticket ve ID değerleri yok!', 'error');

        return $this->get_message();
    }

    function yeni() {

        $main = new main();
        if ($_POST['btnYeniUye']) {
            $p = (object)$_POST;

            if ($p->code != lifos::captcha_code()) $err[] = 'Onay kodunuz yanlış.';
            if (!$p->ad) $err[] = 'Adınızı giriniz.';
            if (!$p->eposta) $err[] = 'Eposta adresinizi giriniz.';
            if ($this->db->sorgu("select count(*) from uye where eposta='%s'", $p->eposta)->sonuc(0)) $err[] = 'Bu eposta ile zaten bir üyemiz var';

            if (!$p->sifre1 || !$p->sifre2) $err[] = 'Şifrenizi adresinizi giriniz.';
            elseif ($p->sifre1 != $p->sifre2) $err[] = 'Şifreleriniz uyuşmuyor.';
            elseif (strlen($p->sifre1) < 6) $err[] = 'Şifreniz en az 6 karakter olmalıdır.';

            if (!$p->sozlesme) $err[] = 'Hizmet sözleşmesini onaylamadınız.';
            $ticket = uniqid();

            $dogum_tarihi = $p->gun && $p->ay && $p->yil ? sprintf("%d-%02d-%02d", $p->yil, $p->ay, $p->gun) : '';

            if (!$err) {
                $eticaret_id = 0;//file_get_contents('https://magaza.pistonkafalar.com/api.php?action=uye/yeni&isim=' . urlencode($p->ad) . '&eposta=' . $p->eposta . '&sifre=' . $p->sifre1);
                if ($id = $this->db->add('uye', array('ad' => $p->ad, 'eposta' => $p->eposta, 'sifre' => md5($p->sifre1), 'tel' => $p->tel ? $p->tel : '', 'sehir' => $p->sehir ? $p->sehir : '', 'kayit_tarihi' => lifos::db_data_time(), 'son_oturum_tarihi' => lifos::db_data_time(), 'tip' => 0, 'ticket' => $ticket, 'cinsiyet' => $p->cinsiyet ? $p->cinsiyet : 0, 'dogum' => $dogum_tarihi, 'ulke' => $p->ulke ? $p->ulke : '', 'eticaret_id' => $eticaret_id))) {
                    lifos::captcha_clean();
                    factory::get('mailer')->fast_send($p->eposta, $p->ad, 'Üyelik Kaydınız Tamamlandı', 'Sayın, ' . $p->ad . '<br><br>  PistonKafalar.com\'a üye olduğunuz için teşekkürler!<br><br> Lütfen üyeliğinizi aşağıdaki linke tıklayarak AKTİVE ediniz.<br>  <a href="https://www.pistonkafalar.com/index.php?b=uye/aktivasyon&ticket=' . $ticket . '&id=' . $id . '">https://www.pistonkafalar.com/index.php?b=uye/aktivasyon&ticket=' . $ticket . '&id=' . $id . '</a><br><br> Üyelik Bilgileriniz:<br> E-mail: ' . $p->eposta . '<br> Şifre: ' . $p->sifre1 . '<br><br> Yukarıda verilen e-mail ve şifrenizle sitemize giriş yapabilirsiniz. <br><br> Saygılarımızla <a href="https://www.pistonkafalar.com">PistonKafalar.com</a>');
                    $this->add_message('Kaydınız başarı ile oluşturuldu. Lütfen mail adresinizi doğrulayınız.', 'success');
                    $this->_start_session($p->eposta, $p->sifre1, 1, 1);
                    exit();
                }
                $this->add_message('Kayıt oluşturulamadı.', 'error');
                echo $this->db->hata();
            } else {
                $this->add_messages($err, 'error');
            }
        }

        $data['message'] = $this->get_message();
        $data['sag_menu_2'] = $main->sag_menu2();
        $data['sehirler'] = $this->db->sorgu('SELECT il FROM yerler group by il order by il')->liste();
        $data['ulkeler'] = $this->db->sorgu('SELECT ad FROM ulke order by ad')->liste();
        //factory::get('mailer')->fast_send('can@lifos.net','can ünlü','Üyelik Kaydınız Tamamlandı','Sayın, <br><br>  PistonKafalar.com\'a üye olduğunuz için teşekkürler!<br><br> Lütfen üyeliğinizi aşağıdaki linke tıklayarak AKTİVE ediniz.<br>  <a href="http://www.pistonkafalar.com/index.php?b=uye/aktivasyon&ticket='.$ticket.'&id='.$id.'">http://www.pistonkafalar.com/index.php?b=uye/aktivasyon&ticket='.$ticket.'&id='.$id.'</a><br><br> Üyelik Bilgileriniz:<br><br><br> Yukarıda verilen e-mail ve şifrenizle sitemize giriş yapabilirsiniz. <br><br> Saygılarımızla <a href="http://www.pistonkafalar.com">PistonKafalar.com</a>');
        if ($_GET['ref'] == 'eticaret') $_SESSION['ref'] = $_GET['ref'];
        return $this->view('yeni', $data);
    }
}