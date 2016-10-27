<?php
class js
{
	private $_code = '';
	private $_event = '';
	
	
	public static function onayla($msg)
	{
		return "onclick=\"return confirm('$msg')\"";
	}
	
	public function run($c='')
	{
		echo '<script language="javascript">'.$this->_code.$c.'</script>';
		$this->_code = '';
	}
	
	public function yonlendir($sayfa)
	{
		//exit("<script type=\"text/javascript\">location.href='".$sayfa."';</script>");
	}
	
	
	public function mesajGoster($msg)
	{
		$this->_code .= "alert('$msg');";
		return $this;
	}
	
	public function pencere($sayfa,$w,$h)
	{
		$this->_code .= "window.open('".$sayfa."','Kobi.Net','resizable=1,scrollbars=1,width=$w,height=$h')";
		return $this;		
	}
	
	public function get()
	{
		return $this->_code; 
	}
	
	function add($a)
	{
		$this->_code .= $a;
		return $this; 
	}

	
	function ready()
	{
		$this->_code = '$(document).ready(function(){'.$this->_code.'});';
		return $this; 
	}
	
	function getAll()
	{
		$a = $this->_code;
		$this->_code = '';
		return '<script language="javascript">'.$a.'</script>';
	}
}
?>