<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (!$this->hasLogin()) {
			redirect('site/login');
		}

		$this->fragment['js'] = [ 
			base_url('assets/vendor/jquery-form/jquery.form.min.js'),
			base_url('assets/js/pages/attendance.js') 
		];

		$this->fragment['pagename'] = 'pages/attendance_page.php';
		$this->load->view('layout/main-site', $this->fragment);
	}

	public function login()
	{
		if( $this->hasLogin() ) redirect();
		$location = $this->sitemodel->view('location', '*');
		$this->fragment['location'] = $location;
		$this->load->view('login_page', $this->fragment);
	}

	public function signin()
	{
		// echo json_encode($this->input->post());die;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('location','Location','required');
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if ($this->form_validation->run() == false) {
			$this->response['msg'] = validation_errors();
			echo json_encode($this->response);
			exit;
		}

		$location = $this->input->post('location');
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));

		$check = $this->sitemodel->view('view_user', '*', ['username'=>$username]);
		if (!$check) {$this->response['msg'] = "No user found.";echo json_encode($this->response);exit;}

		if ( $password != $check[0]->password ) {
			$this->response['msg'] = "Invalid username or password.";
			echo json_encode($this->response);
			exit;					
		}

		$data_sess = [
			'log_user'		=> $check[0]->id,
			'log_username'	=> $check[0]->username,
			'log_name'		=> $check[0]->name,
			'log_location'  => $location,
			'log_role'		=> $check[0]->roleID
		];

		$this->session->set_userdata(SESS, (object)$data_sess);
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully login.";
		echo json_encode($this->response);
	}

	public function change_password()
	{
		// echo json_encode($this->input->post());die;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('oldpassword','Password','required');
		$this->form_validation->set_rules('newpassword','Password','required');

		if ($this->form_validation->run() == false) {
			$this->response['msg'] = validation_errors();
			echo json_encode($this->response);
			exit;
		}

		$new_password = $this->input->post('newpassword');

		$check = $this->sitemodel->view('user', '*', ['id'=>$this->log_user]);
		if (!$check) {$this->response['msg'] = "No user found.";echo json_encode($this->response);exit;}

		$data = [
			'password'	=> md5($new_password)
		];

		$this->sitemodel->update('user', $data, ['id'=>$this->log_user]);

		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully change password.";
		echo json_encode($this->response);
	}

	public function signout()
	{
		$this->session->sess_destroy();
		redirect ( base_url() );
	}
}
