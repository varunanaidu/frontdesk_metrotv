<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
ini_set('error_reporting', E_ALL);
require_once APPPATH."/third_party/phpqrcode-master/qrlib.php";

class Phpqrcode {

	function generate($string){
		QRcode::png($string, false, QR_ECLEVEL_L, 4);
	}
} 