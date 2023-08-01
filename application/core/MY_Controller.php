<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

	protected $select 	 = '';
	protected $from 	 = '';
	protected $order_by  = [];
	protected $search    = [];
	protected $order     = [];

	protected $fragment  = [];
	protected $response  = [];

	protected $log_user  	= '';
	protected $log_username = '';
	protected $log_name  	= '';
	protected $log_location = '';
	protected $log_role		= '';
	
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
		if ($this->hasLogin()) {
			$this->log_user  = $this->session->userdata(SESS)->log_user;
			$this->log_username = $this->session->userdata(SESS)->log_username;
			$this->log_name  = $this->session->userdata(SESS)->log_name;
			$this->log_location = $this->session->userdata(SESS)->log_location;
			$this->log_role = $this->session->userdata(SESS)->log_role;

			$this->fragment['log_user']  = $this->log_user;
			$this->fragment['log_username'] = $this->log_username;
			$this->fragment['log_name']  = $this->log_name;
			$this->fragment['log_location'] = $this->log_location;
			$this->fragment['log_role'] = $this->log_role;

			$location_name = $this->sitemodel->view('location', '*', ['id'=>$this->log_location]);
			$role_name = $this->sitemodel->view('userRole', '*', ['id'=>$this->log_role]);
			$this->fragment['location_name'] = $location_name[0]->name;
			$this->fragment['role_name'] = $role_name[0]->role_name;
			// echo json_encode($this->fragment);die;
		}
	}
	
	function hasLogin() {
		return $this->session->userdata(SESS);
	}

	function compress_image($source_url, $destination_url, $quality) {
		$info = getimagesize($source_url);

		if ($info['mime'] == 'image/jpeg')
			$image = imagecreatefromjpeg($source_url);
		elseif ($info['mime'] == 'image/gif')
			$image = imagecreatefromgif($source_url);
		elseif ($info['mime'] == 'image/png')
			$image = imagecreatefrompng($source_url);
		imagejpeg($image, $destination_url, $quality);

		return true;
	}
}