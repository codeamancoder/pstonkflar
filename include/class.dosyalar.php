<?php

class dosyalar {
    private $_file_type = '*.jpg;*.png';
    private $_max_file_size = '*.jpg;*.png';
    private $_multiple_select = 1;
    private $_title = true;
    private $_post_params;
    private $_temp = '/user/temp/';

    //resize ı aktif eder
    private $_resizer_max_width;
    private $_resizer_max_height;

    //croplamayı aktif eder
    private $_croper_target_width;
    private $_croper_target_height;
    private $_loader_container;

    private $_container = array();
    private $_php_loader_dir = '/index.php?a=uye/fotograf';
    private $_uid;
    private $_conf;
    public $button_width = '180';

    static $active_file_number = 0;

    private $_allowed_files_types = array('image' => 'jpg,png,gif', 'file' => 'doc,docx,pdf,txt,zip,rar,avi,xls,xlsx,ppt,pptx,rtf,mp3,avi', 'flash' => 'swf');

    static $uploader_id;
    private $db;
    private $name;

    function dosyalar($param = array()) {
        global $db;

        $this->db = $db;

        $this->name = 'dosyalar';
        $this->_uid = $_SESSION['user']->admin_id;
        $this->files['css'] = 'dosyalar.css';
        //$this->files['lib'][]  	= get_system_jquery();
        //$this->files['lib'][]  	= 'jquery.colorbox-min.js';
        //$this->files['tpl']  	= 'dosyalar.tpl.php';
        //parent::__construct();

        if (count($param)) {
            $this->configure($param);
        }
    }

    function configure($p = array()) {
        $this->_conf = $p;
        $this->_conf['title'] = isset($p['title']) ? $p['title'] : 'Dosya Seçin';
        $this->_conf['name'] = isset($p['name']) ? $p['name'] : 'name1';

        isset($p['ref']) ? $this->_post['ref'] = $p['ref'] : '';
        isset($p['ref_id']) ? $this->_post['ref_id'] = $p['ref_id'] : '';
        isset($p['param']) ? $this->_post['ref'] = $p['param'] : '';
        isset($p['water']) ? $this->_post['water'] = $p['water'] : '';
        isset($p['menu_id']) ? $this->_post['ref_id'] = $p['menu_id'] : '';
        isset($p['type']) ? '' : $this->_conf['type'] = 'image';

        $this->crop($p['crop']);
        $this->resize($p['resize']);
        $this->thumb(isset($p['thumb']) ? $p['thumb'] : '160,120');

        $this->_post['multiple_files'] = $this->_conf['multiple_files'] = (isset($p['multiple_files']) ? $p['multiple_files'] : 1);

        $this->_loader_container = 'ikobi_uploader_' . $this->_conf['ref'];

        return $this;
    }

    function set_max_file_size($size) {
        $this->_max_file_size = $size;
    }

    function set_multi_select($mi) {
        $this->_multiple_select = $mi;
    }

    function param($k, $v) {
        $this->_post[] = sprintf("'%s':'%s'", $k, $v);

        return $this;
    }

    function getYanHTML() {
        if ($files = $this->getFiles($this->_conf['param'], $this->_conf['menu_id'], 7)) {
            $this->tpl->ata('files', $files);
            $this->params = 'yan';
            return $this->createBlock($this->getHTML('yan'), 'menu');
        }
    }

    /*
     * set thumb width height
     */
    function thumb($size) {
        $this->_post['thumb'] = $size;
        list($this->_conf['thumb_w'], $this->_conf['thumb_h']) = preg_split('/\,/', $size);
    }

    /*
     * set resizer width height
     */
    function resize($size) {
        $this->_post['resize'] = $size;
        list($this->_conf['resize_w'], $this->_conf['resize_h']) = preg_split('/\,/', $size);
    }

    /*
     * set crop width height
     */
    function crop($size) {
        $this->_post['crop'] = $size;
        list($this->_conf['crop_w'], $this->_conf['crop_h']) = preg_split('/\,/', $size);
    }

    public static function get_instance($k) {
        return $_SESSION['uploader'][$k];
    }

    public function clean() {
        $pref = DR . '/_temp/' . $this->_conf['ref'] . '_' . $_SESSION['user']->admin_id . '_*';

        foreach (glob($pref) as $a) {
            @unlink($a);
        }
    }

    static function save_temp() {
        $prefix = $_POST['ref'];

        $name = uniqid($prefix . '_' . $id . '_') . '.jpg';
        move_uploaded_file($_FILES['Filedata']['tmp_name'], DR . '/_temp/' . $name);
        echo $name;
    }

    static function save_images() {
        $prefix = $_POST['ref'];

        $name = uniqid($prefix . '_' . $id . '_') . '.jpg';
        move_uploaded_file($_FILES['Filedata']['tmp_name'], DR . '/_temp/' . $name);
        echo $name;
    }

    function set_container($k, $v) {
        $this->_container[$k] = $v;
    }

    function count() {
        return ($_POST[$this->_loader_container . '_files'] ? substr_count($_POST[$this->_container . '_files'], ',') + 1 : 0);
    }

    private function _init_image_editor() {
        $out .= $this->_conf['deletable'] ? "
			$('#" . $this->_loader_container . " ." . $this->_conf['type'] . "_box li .icon-remove').live('click',function(){
				if( confirm('Dosya silinecek, emin misiniz?') ){ 
					var a=$(this);
					var b=a.parents('ul'); 
					$.get('" . $this->_php_loader_dir . "/sil&id='+$(this).parent().parent().attr('id').split('_')[1],function(r){
						if(r=='1') { 
							a.parent().parent().remove();
							b.next().val($('li',b).map(function(){
								return $(this).attr('id').split('_')[1];
							}).get().join(',')); 
						} 
						else alert('Dosya silinemedi.');
					}); 
				} 
				return false;
			});" : '';
        $out .= $this->_conf['editable'] ? "$('#" . $this->_loader_container . " ." . $this->_conf['type'] . "_box li input').change(function(){  $.post('" . $this->_php_loader_dir . "/info',{id:$(this).parent().attr('id').split('_')[1],info:$(this).val()}); });" : '';
        $out .= $this->_conf['sortable'] ? "$('#" . $this->_loader_container . " ." . $this->_conf['type'] . "_box').sortable({stop:function(){ var a = $('li',$(this)).map(function(){ return $(this).attr('id').split('_')[1];}).get().join(','); $.get('" . $this->_php_loader_dir . "/order&ref=" . $this->_conf['ref'] . "&ref_id=" . $this->_conf['ref_id'] . "&order='+a); },disable: true});" : '';
        $out .= $this->_conf['crop'] ? "$('i.icon-edit').live('click',function(){ window.open($('a',$(this)).attr('href'),'CropImage','status=1,width=700,height=700,scrollbars=1');  return false;}); $('.image_box textarea').live({ 'focusin':function(){ if($(this).val()=='Açıklamalar')$(this).val('');$(this).parents('li').addClass('active');}, 'focusout':function(){ $(this).parents('li').removeClass('active');}});" : '';
        return $out;
    }

    private function _init_resizer() {
        return $this->_conf['resize'] ? ',custom_settings : {thumbnail_height: ' . $this->_conf['resize_h'] . ',thumbnail_width: ' . $this->_conf['resize_w'] . ',thumbnail_quality: 100}' : '';
    }

    private function _get_allowed_types() {
        foreach (preg_split('/\,/', $this->_allowed_files_types[$this->_conf['type']]) as $a) {
            $b[] = '*.' . $a;
        }
        return implode(';', $b);
    }

    function get_form() {
        static $swfid;

        $swfid = !$swfid ? 1 : ++$swfid;
        $this->_post['xid'] = session_id();

        foreach ($this->_post as $k => $v) $pp[] = sprintf("'%s':'%s'", $k, $v);
        $post = 'post_params:{' . implode(',', $pp) . '},';

        $events = "
			file_queued_handler 			: function(a){ if(this.getSetting('button_action')==SWFUpload.BUTTON_ACTION.SELECT_FILE){ $('#" . $this->_loader_container . " #loading_box_0 div').remove();} a.size = a.size/1024;a.size = a.size>1024 ? Math.floor(a.size/1024)+' MB': Math.floor(a.size) + ' KB'; $('#" . $this->_loader_container . " .loading_box').append('<div id=\"'+a.id+'\" class=\"loading\"><b>'+a.name+' ('+a.size+')</b><div class=\"progress\"><div></div></div></div>');},
			upload_start_handler			: function(){
	
			},
			file_dialog_complete_handler	: function(numFilesSelected, numFilesQueued){ 
					if(swf.customSettings['max_file_number'])
					{
						var max = swf.customSettings['max_file_number'];
						var sayi = $('#" . $this->_loader_container . " #image_box_0 li:visible').size();
								
						if(sayi+numFilesSelected>max){
							$('#" . $this->_loader_container . " #loading_box_0 div').remove();
							alert('En fazla '+max+' fotograf ekleyebilirsiniz. ');
							for(var i=0;i<numFilesSelected;i++) swf.cancelUpload();
							return false;
						}
					}
					if(numFilesQueued>0){this.startUpload(this.getFile(0).ID);}},
			upload_complete_handler			: function(a,b){ 
				
					if (this.getStats().files_queued > 0) {
						this.startUpload(this.getFile(0).ID);
					}
					else{ 
					//	$('#" . $this->_loader_container . " #loading_box_0 div').delay(4000).fadeOut();
						var c = $('#" . $this->_loader_container . " li').map(function(){return $(this).attr('id').split('_')[1];}).get().join(',');
						$('#" . $this->_loader_container . "_files').val(c);
					}
				},
			upload_progress_handler			: function(a,b){try {var p = Math.ceil((b / a.size) * 100);	$('#" . $this->_loader_container . " #'+a.id+' .progress div').css('width',p+'%');} catch (ex) {alert(ex);}},
			swfupload_preload_handler		: function(){if (!this.support.loading || !this.support.imageResize) {alert('Dosya yükleyicinin çalışması için Flash Player 10 yükleyiniz.');window.open('http://get.adobe.com/flashplayer/');return false;}},
			swfupload_load_failed_handler	: function(){ alert('Dosya yüklenirken bir hata oluştu. Hatanın devam etmesi halinde lütfen destek@lifos.net adresine konuyla ilgili bilgi veriniz.');},
			file_queue_error_handler		: function(){ alert('Dosya kuyruk hatasi.');},
			upload_success_handler			: function(a,b,c){
					b = b.replace(/^\﻿*/, \"\");
					if(this.getSetting('button_action')==SWFUpload.BUTTON_ACTION.SELECT_FILE) {
						$('#" . $this->_loader_container . " #image_box_0 li').remove();
		
					}
					if(b=='error'){alert('Yükleme sırasında bir hata oluştu. Yüklediğiniz dosya desteklenmiyor yada boyutu çok büyük.'); return 0;}
					b=b.split(':');
					$('.bos').remove();

					if(b[0]=='image') $('#" . $this->_loader_container . " #image_box_0').append('<li id=\"img_'+b[2]+'\"><div class=foto style=\"background-image:url(/user/files/wrap_'+b[2]+'.'+b[1]+')\"></div>" . (!empty($this->_conf['showname']) ? "<span>'+b[3]+'</span>" : "") . (!empty($this->_conf['editable']) ? '<input type=text placeholder=\"Açıklama Ekleyin\">' : '') . "<div class=icons><i class=icon-remove></i> " . (isset($this->_conf['crop']) ? "<i class=icon-edit><a href=\"/index.php?b=uye/crop&im='+b[2]+'&tw=" . $this->_conf['crop_w'] . "&th=" . $this->_conf['crop_h'] . "\" class=\"crop\" title=\"Fotoğrafın Kırp\"></a></i>" : '') . "</div></li>');
					else if(b[0]=='file') $('#" . $this->_loader_container . " #file_box_0').append('<li id=\"file_'+b[2]+'\"><img src=\"/static/img/u_'+b[1]+'.png\"><br/><span>'+b[3]+'</span><div class=\"icons\"><a href=# class=sil title=\"Dosyayı Sil\"></a></div></li>');
					else if(b[0]=='flash') $('#" . $this->_loader_container . " #flash_box_0').append('<li id=\"flash_'+b[2]+'\"><embed id=\"'+b[2]+'.swf\" height=\"120px\" width=\"'+b[4]+'px\" allowscriptaccess=\"always\" wmode=\"transparent\" quality=\"high\" src=\"/user/files/'+b[3]+'.swf\" type=\"application/x-shockwave-flash\"><br/><span>'+b[3]+'</span><div class=\"icons\"><a href=# class=sil title=\"Dosyayı Sil\"></a></div></li>');
	
					$('#" . $this->_loader_container . " #'+a.id).delay(2000).fadeOut();
				},";

        $out = $swfid == 1 ? '<script type="text/javascript" src="/include/lib/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" src="/include/lib/swfupload.js"></script>' : '';

        $out .= empty($this->_conf['hide_uploader']) ? '
			
			<!--[if lt IE 8]><link href="/include/lib/ie7.css" type="text/css" rel="stylesheet"><![endif]-->
			<script type="text/javascript">
				var swf;

				$(window).load(function(){
					swf = new SWFUpload({
						upload_url:"' . $this->_php_loader_dir . '/save",' . $post . '
						file_size_limit:"8 MB",
						file_types:"' . $this->_get_allowed_types() . '",
						file_upload_limit:0,
						' . $events . '
						button_action : ' . ($this->_conf['multiple_files'] ? 'SWFUpload.BUTTON_ACTION.SELECT_FILES' : 'SWFUpload.BUTTON_ACTION.SELECT_FILE') . ',
						button_image_url : "/include/lib/uploader.png",
						button_placeholder_id : "btn_' . $this->_loader_container . '",
						button_width: 280,
						button_height: 18,
						button_text : "<span class=\"button\">' . $this->_conf['title'] . '</span>",
						button_text_style : ".button { font-family: Tahoma; font-size: 12pt; text-decoration:underline;} .buttonSmall { font-size: 10pt; }",
						button_text_top_padding: 0,
						button_text_left_padding: 18,
						button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
						button_cursor: SWFUpload.CURSOR.HAND,
						custom_settings : { max_file_number : ' . ($this->_conf['max_file_number'] ? $this->_conf['max_file_number'] : 0) . '},
						flash_url : "/include/lib/swfupload_fp9.swf",
						flash9_url : "/include/lib/swfupload_fp9.swf"
					});
				' . $this->_init_image_editor() . ' $("#btn1").click(function(){this.swf.selectFiles();});
				});		
			</script>' : '';

        $out .= '
			<div class="ikobi_uploader" id="' . $this->_loader_container . '">
					' . (empty($this->_conf['hide_uploader']) ? '<div style="width: 180px; height: 18px; padding: 2px;"><span id="btn_' . $this->_loader_container . '"></span></div><div id="loading_box_0" class="loading_box"></div>' : '')
            . $this->load_files($this->_conf['type']) . '
					<input type="hidden" name="' . $this->_loader_container . '_files" id="' . $this->_loader_container . '_files" value="' . $this->_preloaded_ids . '"/>
				</div>';

        return $out;
    }

    private function load_files($type) {
        if ($type == 'image') {
            if ($this->_conf['preload']) {
                $img = isset($this->_conf['preload_path']) ? $this->_conf['preload_path'] . $this->_conf['ref_id'] . '.jpg' : '/dosya/' . $this->_conf['ref'] . '/' . $this->_conf['ref_id'] . '.jpg';
                $out = '<li><div class="foto"><span></span><img src="' . $img . '?a=' . rand() . '" class="old"></div><div class="icons">' . (isset($this->_conf['crop']) ? '<i class="icon-edit"><a href="/modules/dosyalar/imcrop.php?im=' . $img . '&tw=' . $this->_conf['crop_w'] . '&th=' . $this->_conf['crop_h'] . '" class="crop"></a></i>' : '') . '</div></li>';
            } else {
                $ref = ($this->_conf['ref'] ? ' and ref_name=\'' . $this->_conf['ref'] . '\'' : '') . ($this->_conf['ref_id'] !== '*' ? ' and ref_id=' . $this->_conf['ref_id'] : '');
                if ($ids = $this->db->sorgu("select id,isim,uzanti,tip,bilgi,width,height from dosya where 1=1 %s and tip='image' order by sira", $ref)->sozluk('id')) {
                    if ($this->_conf['show_original']) foreach ($ids as $id) $out .= '<li id="img_' . $id['id'] . '" style="width:' . ($id['width'] / 2 + 10) . 'px;height:' . ($id['height'] / 2 + 10) . 'px"><div class="foto"><img src="/user/files/' . $id['id'] . '.' . $id['uzanti'] . '" style="width:' . ($id['width'] / 2) . 'px;height:' . ($id['height'] / 2) . 'px"></div>' . (!empty($this->_conf['showname']) ? '<span>' . $id['isim'] . '</span>' : '') . '' . (!empty($this->_conf['editable']) ? '<input type="text" placeholder="Açıklama Ekleyin" value="' . $id['bilgi'] . '">' : '') . '<div class="icons">' . ($this->_conf['deletable'] ? '<i class="icon-remove"></i>' : '') . '' . (isset($this->_conf['crop']) ? '<i class="icon-edit"><a href="/index.php?b=uye/crop&im' . $id['id'] . '&tw=' . $this->_conf['crop_w'] . '&th=' . $this->_conf['crop_h'] . '" class="crop" title="Fotoğrafın Kırp"></a></i>' : '') . '</div></li>';
                    else foreach ($ids as $id) $out .= '<li id="img_' . $id['id'] . '"><div class="foto" style="background-image:url(/user/files/wrap_' . $id['id'] . '.' . $id['uzanti'] . ')"></div>' . (!empty($this->_conf['showname']) ? '<span>' . $id['isim'] . '</span>' : '') . '' . (!empty($this->_conf['editable']) ? '<input type="text" placeholder="Açıklama Ekleyin" value="' . $id['bilgi'] . '">' : '') . '<div class="icons">' . ($this->_conf['deletable'] ? '<i class="icon-remove"></i>' : '') . '' . (isset($this->_conf['crop']) ? '<i class="icon-edit"><a href="/index.php?b=uye/crop&im=' . $id['id'] . '&tw=' . $this->_conf['crop_w'] . '&th=' . $this->_conf['crop_h'] . '" class="crop" title="Fotoğrafın Kırp"></a></i>' : '') . '</div></li>';

                    $this->_preloaded_ids = implode(',', array_keys($ids));
                } else $out = !empty($this->_conf['nofile']) ? '<div class="bos">' . $this->_conf['nofile'] . '</div>' : '';

            }
            return '<ul id="image_box_0" class="image_box ' . ($this->_conf['sortable'] ? 'move' : '') . '">' . $out . '</ul>';
        } elseif ($type == 'file') {
            if ($this->_conf['ref']) {
                if ($ids = $this->db->sorgu("select id,isim,bilgi,tip,uzanti from dosya where ref_name='%s' and ref_id=%d and tip='file'", $this->_conf['ref'], $this->_conf['ref_id'])->liste()) {
                    foreach ($ids as $id) {
                        $out .= '<li id="file_' . $id['id'] . '">
									<img src="/static/img/u_' . $id['uzanti'] . '.png"><br/>
									<span>' . wordwrap($id['isim'], 12, '<br>', 1) . '.' . $id['uzanti'] . '</span>
									<div class="icons">
										<a href="#" class="sil" title="Dosyayı Sil"></a>
									</div>
								 </li>';
                    }

                } else $out = !empty($this->_conf['nofile']) ? '<div class="bos">' . $this->_conf['nofile'] . '</div>' : '';

            }
            return '<ul id="file_box_0" class="file_box ' . ($this->_conf['sortable'] ? 'move' : '') . '">' . $out . '</ul>';
        } elseif ($type == 'flash') {
            if ($this->_conf['ref']) {
                if ($ids = $this->db->sorgu("select id,isim,bilgi,height,width from dosya where  ref_name='%s' and ref_id=%d and tip='flash'", $this->_conf['ref'], $this->_conf['ref_id'])->liste()) {
                    foreach ($ids as $id) {
                        $out .= '<li id="file_' . $id['id'] . '">
									<img src="/static/img/u_swf.png"><br/>
									<span>' . wordwrap($id['isim'], 12, '<br>', 1) . '.swf</span>
									<div class="icons">
										<a href="#" class="sil" title="Dosyayı Sil"></a>
									</div>
								 </li>';
                    }

                } else $out = !empty($this->_conf['nofile']) ? '<div class="bos">' . $this->_conf['nofile'] . '</div>' : '';

            }
            return '<ul id="flash_box_0" class="flash_box ' . ($this->_conf['sortable'] ? 'move' : '') . '">' . $out . '</ul>';
        }
    }

    static function sil($file) {
        if ($file) {
            global $db;

            if ($db->sorgu("delete from dosya WHERE  id=%d;", $file->id)->sayi() > 0) {
                if ($file->tip == 'image') {
                    @unlink(DR . '/user/files/' . $file->id . '.' . $file->uzanti);
                    @unlink(DR . '/user/files/wrap_' . $file->id . '.' . $file->uzanti);
                    @unlink(DR . '/user/files/thumb_' . $file->id . '.' . $file->uzanti);
                    //self::data_changed('Fotoğraf silindi : '.$file->isim.'.'.$file->uzanti);
                } else if ($file->tip == 'file' || $file->tip == 'flash') {
                    @unlink(DR . '/user/files/' . $file->isim . '.' . $file->uzanti);
                    //self::data_changed('Dosya silindi : '.$file->isim.'.'.$file->uzanti);
                }
                return 1;
            }
        }
        return 0;
    }

    function cleanFileCache($ref_id = 0, $dontdelete = 0) {
        if ($files = $this->getFiles($this->_conf['ref'], $ref_id)) {
            foreach ($files as $file) {
                if ($dontdelete == $file->id) continue;
                $this->sil($file);
            }
        }
    }

    function admin() {
        global $admin;

        $admin->addToNavi('Dosyalar');
        $admin->addTopLink('Fotoğraflar', '?p=components&com=dosyalar');
        $admin->addTopLink('Flash Dosyaları', '?p=components&com=dosyalar&v=flash');
        $admin->addTopLink('Diğer Dosyalar', '?p=components&com=dosyalar&v=diger');

        if (($v = $_GET['v']) == 'flash') {
            $admin->selTopLink('Flash Dosyaları');

            $this->configure(array(
                    'title' => 'Yeni Flash Dosyaları Yükleyin',
                    'type' => 'flash',
                    'ref' => 'arsiv',
                    'ref_id' => '*',
                    'deletable' => 1,
                    'showname' => 1,
                    'multiple_files' => 1,
                    'max_file_size' => '8MB')
            );

            $this->button_width = 460;

            return '<div class="w">' . $this->get_form() . '</div>';

        } elseif (($v = $_GET['v']) == 'diger') {
            $admin->selTopLink('Diğer Dosyalar');

            $this->configure(array(
                    'title' => 'Yeni Dosya Yükleyin',
                    'type' => 'file',
                    'ref' => 'arsiv',
                    'ref_id' => '*',
                    'deletable' => 1,
                    'showname' => 1,
                    'multiple_files' => 1,
                    'max_file_size' => '8MB')
            );

            $this->button_width = 460;

            return '<div class="w">' . $this->get_form() . '</div>';

        } else {
            $admin->selTopLink('Fotoğraflar');

            $this->configure(array(
                    'title' => 'Yeni Fotoğraf veya Fotoğraflar Yükleyin',
                    'type' => 'image',
                    'ref' => 'arsiv',
                    'ref_id' => '*',
                    'deletable' => 1,
                    'editable' => 1,
                    'showname' => 1,
                    'multiple_files' => 1,
                    'resize' => '800,800',
                    'max_file_size' => '8MB')
            );

            $this->button_width = 460;

            return '<div class="w">' . $this->get_form() . '</div>';
        }
    }

    function getFile($id) {
        return $this->db->sorgu("select *,concat(id,'.',uzanti) as path from dosya where  id=%d", $id)->satirObj();
    }

    function ajax($c) {
        if ($c == 'crop') {
            $s = getimagesize(DR . '/_temp/' . $_GET['id'] . '.jpg');

            $o .= "<img src=\"/_temp/" . $_GET['id'] . ".jpg\">";

            echo $o;
        } elseif ($c == 'order') {

            $ref = $_GET['ref'];
            $ref_id = $_GET['ref_id'];
            $order = $_GET['order'];
            $this->db->sorgu("UPDATE dosya SET sira=find_in_set(id,'%s') where  ref_name='%s' and ref_id=%d and id in(%s);", $order, $ref, $ref_id, $order);
        } elseif ($c == 'sil') {
            echo $this->sil($this->getFile($_GET['id']));
        } elseif ($c == 'info') {
            $id = $_POST['id'];
            $info = $_POST['info'];
            $file = $this->getFile($id);

            $ninfo = lang_set($file->bilgi, $info);
            $this->db->sorgu("UPDATE dosya SET bilgi='%s' WHERE  id=%d;", $ninfo, $id);
        } elseif ($c == 'save') {
            $this->configure($_POST);
            echo $this->save($_FILES['Filedata'], $_POST['ref'], $_POST['ref_id'], $this->_conf['resize_w'], $this->_conf['resize_h'], $this->_conf['thumb_w'], $this->_conf['thumb_h']);
        }
    }

    function _getFileType($ext) {
        $ext = strtolower($ext);
        if (strpos($this->_allowed_files_types['image'], $ext) !== false) return 'image';
        elseif (strpos($this->_allowed_files_types['file'], $ext) !== false) return 'file';
        elseif (strpos($this->_allowed_files_types['flash'], $ext) !== false) return 'flash';
        else return 'unknown';
    }

    private function _cleanString($str) {
        return strtolower(strtr(trim($str), array(' ' => '-', '\'' => '', '�' => '', ':' => '', '’' => '', '^' => '', 'Č' => 'c', 'č' => 'c', 'Ğ' => 'g', 'Ğ' => 'g', 'ğ' => 'g', 'Ş' => 's', 'ş' => 's', 'Ö' => 'o', 'ö' => 'o', 'Ü' => 'u', 'ü' => 'u', '"' => '', 'ğ' => 'g', 'Ş' => 's', 'ş' => 's', 'İ' => 'i', 'ı' => 'i', 'Ç' => 'c', 'ç' => 'c', 'Ü' => 'u', 'ü' => 'u', 'Ö' => 'o', 'ö' => 'o', 'ı' => 'i', 'İ' => 'i', 'é' => 'i', 'â' => 'a', 'Ê' => 'e', 'Â' => 'a', '?' => '', '*' => '', '.' => '', ',' => '', ';' => '', ')' => '', '(' => '', '{' => '', '}' => '', '[' => '', ']' => '', '!' => '', '+' => '', '"' => '', '%' => '', '&' => '', '#' => '', '$' => '', '=' => '', 'ê' => 'e', '"' => '', '…' => '', '“' => '', '”' => '')));
    }

    function save($file, $ref = 'arsiv', $ref_id = 0, $resize_w = 0, $resize_h = 0, $thumb_w = 0, $thumb_h = 0, $bilgi = '', $eski_id = 0) {
        $ref = $ref ? $ref : 'arsiv';
        $info = pathinfo($file['name']);
        $name = $this->_cleanString($info['filename']);
        $tip = $this->_getFileType($info['extension']);
        $sira = $ref_id ? $this->db->sorgu("SELECT ifnull(max(sira),0)+1 FROM dosya where ref_name='%s' and ref_id=%d", $ref, $ref_id)->sonuc(0) : 0;
        $id = $this->db->sorgu("insert into dosya(isim,tip,ref_id,ref_name,boyut,uzanti,eski_id,tarih,bilgi,sira) values('%s','%s','%d','%s',%d,'%s',%d,'%s','%s','%d')", $name, $tip, $_POST['multiple_files'] ? $ref_id : 0, $ref, $file['size'], $info['extension'], $eski_id, date('Y-m-d H:i:s'), $bilgi, $sira)->id();
        if (($tip == 'image')) {
            $newname = $id . '.' . $info['extension'];
            copy($file['tmp_name'], $dir = DR . '/user/files/' . $newname);
            $image = factory::get('imedit')->load($dir);
            if ($this->_post['water']) {
                //file_put_contents(DR.'/1.txt', 'yaziyorum',FILE_APPEND);
                $image->watermark(DR . '/' . $this->_post['water']);
            }

            if ($resize_w || $resize_h) {
                $image->scaleTo($resize_w, $resize_h)->save(DR . '/user/files/', $newname);
                $size = $image->getSize();
                $this->db->set('dosya', $id, array('width' => $size['width'], 'height' => $size['height']));
            }

            $image->wrapTo(350, 185)->save(DR . '/user/files/', 'wrap_' . $newname);
            if ($thumb_w || $thumb_h) $image->scaleTo($thumb_w, $thumb_h)->save(DR . '/user/files/', 'thumb_' . $newname);

            //$this->data_changed('Fotoğraf kaydedildi : '.$name.'.'.$info['extension']);
            return "image:{$info['extension']}:$id:{$name}";
        } elseif ($tip == 'file') {
            $newname = $name . '.' . $info['extension'];
            while (file_exists(DR . '/user/files/' . $newname) && ($i++ < 5)) {
                $newname = $name . '-' . rand(100, 999) . '.' . $info['extension'];
                $this->db->set('dosya', $id, array('isim' => $name = array_val(pathinfo($newname), 'filename')), 1);
            }
            move_uploaded_file($file['tmp_name'], DR . '/user/files/' . $newname);
            //$this->data_changed('Dosya kaydedildi : '.$newname);
            return "file:{$info['extension']}:$id:" . wordwrap($name, 12, '<br>', 1);
        } elseif ($tip == 'flash') {
            $newname = $name . '.' . $info['extension'];
            while (file_exists(DR . '/user/files/' . $newname) && ($i++ < 5)) {
                $newname = $name . '-' . rand(100, 999) . '.' . $info['extension'];
                $this->db->set('dosya', $id, array('isim' => $name = array_val(pathinfo($newname), 'filename')), 1);
            }
            move_uploaded_file($file['tmp_name'], $dir = DR . '/user/files/' . $newname);
            $size = factory::get('imedit')->load($dir)->getSize();
            $this->db->set('dosya', $id, array('width' => $size['width'], 'height' => $size['height']), 1);
            //$this->data_changed('Flash kaydedildi : '.$name.'.swf');
            return "flash:{$info['extension']}:$id:" . $name . ':' . ceil($size['width'] * (120 / $size['height']));
        } else {
            $this->db->del('dosya', $id, 1);
            throw new Exception('Bu dosya tipi desteklenmiyor...');
        }
    }

    function isFileWaiting() {
        return empty($_POST[$this->_loader_container . '_files']) ? 0 : 1;
    }

    function setFileRefId($id) {
        if (!empty($_POST[$this->_loader_container . '_files'])) {
            if (!$this->_conf['multiple_files']) $this->cleanFileCache($id, $_POST[$this->_loader_container . '_files']);

            $this->db->sorgu("update dosya set ref_id=%d,sira=find_in_set(id,'%s') where id in(%s)", $id, $_POST[$this->_loader_container . '_files'], $_POST[$this->_loader_container . '_files']);
        }

    }

    static function getFiles($ref_name, $ref_id, $limit = 0, $ob = 'sira') {
        global $db;

        return $db->sorgu("select *,concat(id,'.',uzanti) as path from dosya where  ref_name='%s' and ref_id='%d' order by $ob %s", $ref_name, $ref_id, $limit ? 'limit 0,' . $limit : '')->listeObj();
    }

    static function deleteByRef($ref, $ref_id = 0) {
        if ($files = self::getFiles($ref, $ref_id)) {
            foreach ($files as $file) {
                self::sil($file);
            }
        }
    }

    static function getGallery($ids, $showone = 1, $title = '') {
        if (!is_array($ids)) {
            global $db;
            if ($imgs = $db->sorgu("select *,find_in_set(id,'%s') as pos from dosya where  id in(%s) order by pos", $ids, $ids)->listeObj()) {
                foreach ($imgs as $img) {
                    $out .= '<dt><a title="' . lang($img->bilgi) . '" rel="lightbox[hw]" href="/user/files/' . $img->id . '.' . $img->uzanti . '" class="cboxElement"><img src="/user/files/thumb_' . $img->id . '.' . $img->uzanti . '" title="' . lang($img->bilgi) . '"></a></dt>';
                }
                return '<div class="mod-dosyalar small">' . ($title ? '<h2>' . $title . '</h2>' : '') . '<dl>' . $out . '</dl></div>';
            }
        } elseif ((count($ids) > 1) || ($showone && count($ids))) {
            foreach ($ids as $id) {
                $out .= '<dt><a title="" rel="lightbox[hw]" href="/user/files/' . $id->id . '.' . $id->uzanti . '" class="cboxElement"> <img src="/user/files/thumb_' . $id->id . '.' . $id->uzanti . '"></a></dt>';
            }
            return '<div class="mod-dosyalar small"><h2>' . $title . '</h2><dl>' . $out . '</dl></div>';
        }
    }

    function setSize($id, $w, $h) {
        $this->db->sorgu("update dosya set width=%d,height=%d where  id=%d", $w, $h, $id);
    }

    static function getAdminGalleryByIds($ids) {
        global $db;

        if ($ids && ($imgs = $db->sorgu("select *,find_in_set(id,'%s') as pos from dosya where id in(%s) order by pos", $ids, $ids)->liste())) {
            return imprintf($imgs, '<div class="img" id="img_{id}" style="background-image:url(/user/files/wrap_{id}.{uzanti})"><div class="icons"><a href="#" class="sil" title="Fotoğrafı Sil"></a></div></div>', '');
        }
    }
}