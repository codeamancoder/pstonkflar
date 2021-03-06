<?php
/*
 * Fotoğraf düzenleme sınıfı
 *
 * @version		php-5.2.13
 * @author		Can Ünlü
 * @edit		21/05/2010
 */
define('IMAGE_TYPE_PNG','png');
define('IMAGE_TYPE_JPG','jpg');
define('IMAGE_TYPE_GIF','gif');

define('IMAGE_SCALE_NORMAL',0);
define('IMAGE_SCALE_ZORLA',1);
define('IMAGE_SCALE_OLMAZSAKAYDET',2);


class foto{

	const NORMAL = 0;
	const ZORLA = 1;
	const HATA_VERME = 2;
	
	
	//yüklenen fotoğraf
	public $image;

	//genişlik
	public $width;

	//yükseklik
	public $height;

	//tipi
	public $type;

	//desteklenen tipler
	public $types;

	//en fazla boyut
	public $size;

	//sonuç
	private $result;

	//hedefe yazılacak içerik
	private $_target;

	//küçültme oranı
	private $_bozulma_orani = 0.66;

	//kaynak
	private $source;


	public function foto()
	{
		$this->types = array('image/png','image/jpeg','image/jpg','image/gif','image/x-png','image/pjpeg');		
	}

	/*
	 * fotoğraf nesnesi kurucu fonksiyon
	 *
	 * @param	Image	$image	yüklenen fotoğraf
	 * @param	int		$size	en fazla boyut
	 */
	public function load($image,$size=2048000)
	{
		$this->image = $image;
		$this->size = $this->image['size'];

		if(!$image)
			throw new Exception('Hata : Fotoğraf Yüklenemedi.');

		if($this->image['size'] > $size)
			throw new Exception('Hata : Fotoğraf çok büyük.');

		if( ($this->image['error'] != 0) || (!is_uploaded_file($this->image['tmp_name'])) )
			throw new Exception('Hata : Fotoğrafda hata var.');
			
		list($this->width,$this->height) = getimagesize($this->image['tmp_name']);

		if(!in_array($this->image['type'],$this->types))
			throw new Exception('Bu Tür Desteklenmiyor');

		$this->type = $this->getImageType($this->image['type']);

		switch($this->type){
			case IMAGE_TYPE_PNG: $this->source  = imagecreatefrompng($this->image['tmp_name']); break;
			case IMAGE_TYPE_JPG: $this->source  = imagecreatefromjpeg($this->image['tmp_name']); break;
			case IMAGE_TYPE_GIF: $this->source  = imagecreatefromgif($this->image['tmp_name']); break;
		}

	}


	
	function scaleToHeight($h,$zorla=0)
	{
		if(!$zorla && ($this->height < $h) && ($this->height < $h * $this->_bozulma_orani ) )  return $this;
			
		$w = ceil($this->width * ($h / $this->height));	
		return $this->_process($this->source,0,0,0,0,$w,$h,$this->width,$this->height);
	}


	
	function scaleToWidth($width,$zorla=0)
	{
		if(!$zorla && ($this->width < $width) && ($this->width < $width * $this->_bozulma_orani ) )  return $this;
			
		$height = ceil($this->height * ($width / $this->width));	
		return $this->_process($this->source,0,0,0,0,$width,$height,$this->width,$this->height);
	}


	function scaleTo($w,$h=0)
	{
		if(!$h) $h = $w;
		
		$th = ceil(($w /$this->width)*$this->height);
		$tw = ceil(($h /$this->height)*$this->width);
		
		if( $th > $h ) 
			return $this->scaleToHeight($h);
		else 
			return $this->scaleToWidth($w);
		
		//return $this->_process($this->source,0,0,0,0,$w,$h,$this->width,$this->height);
	}
	
	/*
	 * fotoğrafı aynı kaynaktan yeniden yükle
	 */
	public function reload()
	{
		parent::__construct($this->image);
	}




	/*
	 * fotoğraf tipini al
	 *
	 * @param	string	$type fotoğran ham tipi
	 */
	function getImageType($type)
	{
		switch($type){
			case 'image/png':
			case 'image/x-png':
				return IMAGE_TYPE_PNG;

			case 'image/gif':
				return IMAGE_TYPE_GIF;

			case 'image/jpeg':
			case 'image/jpg':
			case 'image/pjpeg':
				return IMAGE_TYPE_JPG;

			default :
				throw new Exception('Dosya tipi desteklenmiyor.');
				break;
		}
	}


	/*
	 * calcrate setter
	 *
	 * @param	float	$rate	yeni oran
	 */
	public function setRate($rate)
	{
		$this->_caulRate = $rate;
	}





	/*
	 * fotoğraf işleme fonksiyonu
	 *
	 * @param	Image	$image	işlenecek foto
	 * @param	int		$tx		hedef x
	 * @param	int		$ty		hedef y
	 * @param	int		$sx		kaynak x
	 * @param	int		$sy		kaynak y
	 * @param	int		$tw		hedef genişlik
	 * @param	int		$th		hedef yükseklik
	 * @param	int		$sw		kaynak genişlik
	 * @param	int		$sh		kaynak yükseklik
	 */
	private function _process($image,$tx = 0,$ty = 0,$sx = 0,$sy = 0,$tw = 0,$th = 0,$sw = 0,$sh = 0)
	{
		$this->_target = imagecreatetruecolor($tw, $th);

		switch($this->type){
			case IMAGE_TYPE_PNG:
				imagealphablending($this->_target, false);
				imagecopyresampled($this->_target, $image, $tx,$ty,$sx,$sy,$tw,$th,$sw,$sh);
				imagesavealpha($this->_target, true);
				break;


			case IMAGE_TYPE_GIF:
				imagealphablending($this->_target, false);
				imagecopyresampled($this->_target, $image, $tx,$ty,$sx,$sy,$tw,$th,$sw,$sh);
				imagesavealpha($this->_target, true);
				break;

			case IMAGE_TYPE_JPG:
				imagecopyresampled($this->_target, $image, $tx,$ty,$sx,$sy,$tw,$th,$sw,$sh);
				break;
		}


		$this->source = $this->_target;
		$this->width = $tw;
		$this->height = $th;

		return $this;
	}



	/*
	 * orantısal olarak küçült
	 *
	 * @param	float	$oran		küçültme oranı
	 */
	public function scale($oran)
	{
		$target_x = ceil($this->x*$oran);
		$target_y = ceil($this->y*$oran);

		if( $this->x < ($this->_caulRate * $target_x * 0.5))
			throw new Exception('Fotoğraf yüksekliği çok az.');

		elseif( ($this->x <(($this->_caulRate * $target_x)))){
			if($this->y > ($target_y * ($this->_caulRate/3+1)))
				throw new Exception('Fotoğraf genişliği çok az ve fotoğraf genişlik yükseklik oranı kabul edilebilir sınırın üzerinde');
			elseif($this->y < $target_y)
				throw new Exception('Fotoğraf genişliği çok az');
		}
		if( $this->y < ($this->_caulRate * $target_y * 0.5))
			throw new Exception('Fotoğraf genişliği çok az.');

		elseif( ($this->y <(($this->_caulRate * $target_y)))){
		    if(($this->x > $target_x) &&
		       ($this->x < ($target_x * ($this->_caulRate/3+1))) )
			throw new Exception('Fotoğraf genişliği çok az ve fotoğraf genişlik yükseklik oranı kabul edilebilir sınırın üzerinde');

			else throw new Exception('Fotoğraf genişliği çok az');
		}

		return $this->_process($this->source,0,0,0,0,$target_x,$target_y,$this->x,$this->y);
	}




	/*
	 * fotoğrafı istenilen genişlik ve yüksekliğe en uygun
	 * şekilde küçült
	 *
	 * @param	int		$width		genişlik
	 * @param	int		$height		yükseklik
	 */
	public function resize($width,$height)
	{
		if($width > 0 && $height > 0){
			$target_x = $width;
			$target_y = $height;
		}
		elseif($width > 0 && $height == 0 ){
			$target_x = $width;
			$target_y = ceil((($this->y)*($width/$this->x)));
		}
		elseif($width == 0 && $height > 0 ){
			$target_x = ceil((($this->x)*($height/$this->y)));
			$target_y = $height;
		}

		if( $this->x < ($this->_caulRate * $target_x * 0.5))
			throw new Exception('Fotoğraf yüksekliği çok az.');

		elseif( ($this->x <(($this->_caulRate * $target_x)))){
			if($this->y > ($target_y * ($this->_caulRate/3+1)))
				throw new Exception('Fotoğraf genişliği çok az ve fotoğraf genişlik yükseklik oranı kabul edilebilir sınırın üzerinde');
			elseif($this->y < $target_y)
				throw new Exception('Fotoğraf genişliği çok az');
		}
		if( $this->y < ($this->_caulRate * $target_y * 0.5))
			throw new Exception('Fotoğraf genişliği çok az.');

		elseif( ($this->y <(($this->_caulRate * $target_y)))){
		    if(($this->x > $target_x) &&
		       ($this->x < ($target_x * ($this->_caulRate/3+1))) )
			throw new Exception('Fotoğraf genişliği çok az ve fotoğraf genişlik yükseklik oranı kabul edilebilir sınırın üzerinde');

			else throw new Exception('Fotoğraf genişliği çok az');
		}

		return $this->_process($this->source,0,0,0,0,$target_x,$target_y,$this->x,$this->y);
	}





	/*
	 * kes
	 *
	 * @param	int		$width		genişlik
	 * @param	int		$height		yükseklik
	 * @param	int		$x			başlangıç x noktası
	 * @param	int		$y			başlangıç y noktası
	 */
	public function crop($width,$height,$x = 0,$y = 0)
	{
		return $this->_process($this->source,0,0,$x,$y,$width,$height,$width,$height);
	}





	/*
	 * resim oluştur
	 *
	 * @param	int		$x		genişlik
	 * @param	int		$y		yükseklik
	 * @param	string	$y		metin
	 */
	public static function create($text,$boyut=10,$renk=false,$arka=false)
	{
		
		$w = strlen($text)*$boyut*0.68;
		$h = $boyut+5;
		
		
		$im = imagecreate($w,$h);

		$arka = $arka ? imagecolorallocate($im, ($arka >> 16)&0xff, ($arka >> 8)&0xff, $arka &0xff) : imagecolorallocate($im, 255,255,255);
		$renk = $renk ? imagecolorallocate($im, ($renk >> 16)&0xff, ($renk >> 8)&0xff, $renk &0xff) : imagecolorallocate($im, 0,0,0);
		//imagefill($im, 0, 0, $arka);
		imagecolortransparent($im, $arka);//transparan yap
		imagettftext($im, $boyut, 0, 0, $boyut, $renk, DL.'/include/tahoma.ttf', $text);

		ob_start();
			imagepng($im);
			$img = ob_get_contents();
			imagedestroy($im);
		ob_end_clean();
		return  '<img src="data:image/png;base64,'.base64_encode($img).'">';
	}


	


	/*
	 * dosyayi diske yazar
	 *
	 * @param	string	dir		dosyayin yolu
	 */
	public function save($target,$file_name)
	{
		if(!$this->_target) return $this->copy($target,$file_name);
		
		$path = $this->_prepare_path($target, $file_name);  
		
		switch($this->type){
				case IMAGE_TYPE_PNG : imagepng($this->source, $path); break;
				case IMAGE_TYPE_JPG : imagejpeg($this->source, $path); break;
				case IMAGE_TYPE_GIF : imagegif($this->source,$path); break;
		}
		
		
		

	}
	
	function _prepare_path($target,$file_name)
	{
		$path = DR.'/dosya/'.$target;
		$name = $name ? $name : str_replace(array('\\','/',' ','\'','_'),'',tr2en($file_name));
		if(!is_dir($path)) mkdir($path);
		$path .= $file_name;
		
		return $path;
	}
	
	function copy($target,$file_name)
	{
		copy($this->image['tmp_name'], $this->_prepare_path($target, $file_name));
	}

	
	
	public function saveThumb($target,$file_name)
	{
		$this->save($target,'thumb_'.$file_name);
	}
}
?>