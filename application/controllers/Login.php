<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LoginModel');
	}

	public function index()
	{
		return $this->load->view('login_page');
	}

	public function login_process()
	{
		$username 	= htmlspecialchars($this->input->post('username'));
		$password 	= md5(htmlspecialchars($this->input->post('password')));

		$input 		= array(
			'username' 	=> $username,
			'password' 	=> $password
		);

		$fetch_data = $this->LoginModel->make_query($username, $password);

		if ($fetch_data->num_rows() > 0) {
			
			foreach ($fetch_data->result() as $row) {

				$data_session = array(
					'username' 		=> $row->username,
					'name' 			=> $row->name,
					'role'			=> $row->is_admin,
					'status' 		=> 'login'
				);

				$this->session->set_userdata($data_session);
				echo json_encode($data_session);
			}
		}else{
			$data_session = array(
				'status' 	=> 'not login',
				'message'	=> 'Username atau Password Salah'
			);

			echo json_encode($data_session);
		}
	}

	// public function change_P()
	// {
	// 	return $this->load->view('changePassword_page.php');
	// }

	// public function checkOldPassword()
	// {
	// 	$oldPassword = md5(htmlspecialchars($this->input->post('oldPassword')));

	// 	$fetch_data = $this->LoginModel->check_old_password($oldPassword);

	// 	if ($fetch_data->num_rows() > 0) {

	// 		$response = array(
	// 			'message' 	=> 'Success'
	// 		);

	// 		echo json_encode($response);

	// 	}else{

	// 		$response = array(
	// 			'message'	=> 'Password lama yang anda masukan salah'
	// 		);

	// 		echo json_encode($response);

	// 	}

	// }

	// public function changePassword()
	// {
	// 	$newPassword 	= md5(htmlspecialchars($this->input->post('newPassword')));
	// 	$username 		= htmlspecialchars($this->input->post('username'));

	// 	$fetch_data = $this->LoginModel->change_password($newPassword, $username);

	// 	$response = array(
	// 		'message' => 'Password berhasil diubah'
	// 	);

	// 	echo json_encode($response);

		
	// }

	// public function addUserPage()
	// {
	// 	return $this->load->view('addUser_page');
	// }

	public function checkUser()
	{
		$dataValidation = array(
			'username' => htmlspecialchars($this->input->post('username'))
		);

		$fetch_data = $this->LoginModel->check_user($dataValidation);

		if ($fetch_data->num_rows() > 0) {

			$result = array(
				'message' => 'User sudah terdaftar',
				'status'  => 'denied'
			);
			echo json_encode($result);

		}else{

			$result = array(
				'status'  => 'accept'
			);
			echo json_encode($result);
		}
	}

	public function addUser()
	{
		$input = array(
			'username'		=> htmlspecialchars($this->input->post('username')),
			'name'			=> htmlspecialchars($this->input->post('name')),
			'is_admin'		=> htmlspecialchars($this->input->post('is_admin')),
			'password'		=> md5(htmlspecialchars($this->input->post('password'))),
		);

		$fetch_data = $this->LoginModel->add_user($input);

		$response = array(
			'status' 	=> 'Success',
			'message'	=> 'User berhasil ditambahkan'
		);

		echo json_encode($response);
	}

	public function logout()
	{
		$this->session->unset_userdata('username'); 
		redirect(site_url('Login'));
	}

}
