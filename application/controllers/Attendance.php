<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."libraries/Libcurl.php";

class Attendance extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AttendanceModel');
		$this->load->library('guzzle');
		$this->select 		= '*';
		$this->from   		= 'view_detail_attendance';
		$this->order_by   	= ['id'=>'DESC'];
		$this->order 		= ['createdAt', 'location_name', 'user_name', 'emp_name', 'name', 'total_guest'];
		$this->search 		= ['createdAt', 'location_name', 'user_name', 'emp_name', 'name', 'total_guest'];
	}

	public function index()
	{
		return $this->load->view('attendance_page');
	}

	public function view()
	{
		$data = array();
		$res = $this->sitemodel->get_datatable($this->select, $this->from, $this->order_by, $this->search, $this->order);
		$q = $this->db->last_query();
		// echo $q;die;

		foreach ($res as $row) {
			
			$button = '
				<button id="btn-viewatt" class="btn btn-success btn-circle btn-sm" data-id="'.$row->id.'"><i class="fa fa-eye"></i></button> 
				<button id="btn-deleteatt" class="btn btn-danger btn-circle btn-sm" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>
				';

			$col = array();
			$col[] = date('d-m-Y H:i:s', strtotime($row->createdAt));
			$col[] = $row->location_name;
			$col[] = $row->user_name;
			$col[] = $row->emp_name;
			$col[] = $row->name;
			$col[] = $row->total_guest;
			$col[] = $button;
			
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->sitemodel->get_datatable_count_all($this->from),
			"recordsFiltered" 	=> $this->sitemodel->get_datatable_count_filtered($this->select, $this->from, $this->order_by, $this->search, $this->order),
			"data" 				=> $data,
			"q"					=> $q

		);
		echo json_encode($output);
		exit;
	}

	public function get_emp_name($nip)
	{
		$tempResult = $this->guzzle->search_HRIS('getEmpGlobal', ["src" => $nip]);
		$result = json_decode($tempResult);
		return $result[0]->emp_name;
	}

	public function get_emp_email($nip)
	{
		$tempResult = $this->guzzle->search_HRIS('getEmpGlobal', ["src" => $nip]);
		$result = json_decode($tempResult);
		return $result[0]->emp_email;
	}

	public function get_emp_department($nip)
	{
		$tempResult = $this->guzzle->search_HRIS('getEmpGlobal', ["src" => $nip]);
		$result = json_decode($tempResult);
		return $result[0]->emp_dept;
	}

	public function get_emp_ext($nip)
	{
		$tempResult = $this->guzzle->search_HRIS('getEmpGlobal', ["src" => $nip]);
		$result = json_decode($tempResult);
		$res = ($result[0]->emp_ext ? $result[0]->emp_ext : '');
		return $res;
	}

	public function search_emp()
	{
        if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		$term = $this->input->get("term");
		echo $this->guzzle->search_HRIS('getEmpGlobal', ["src" => strtoupper($term)]);
		exit;
	}

	public function search_guest()
	{
        if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		$term = $this->input->get("term");
		$res = [];
		$check = $this->sitemodel->custom_query(" SELECT * FROM guest WHERE name LIKE '%".$term."%' ");if($check){
			foreach ($check as $row) {
				$sub_res = [];
				$sub_res['id'] = $row->id;
				$sub_res['text'] = $row->name.' - '.$row->phone;
				$res[] = $sub_res;
			}
		}
		echo json_encode($res);
		exit;
	}

	public function save_guest()
	{
        if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}

        $name = $this->input->post('name');
        $address = $this->input->post('address');
        $identityNo = $this->input->post('identityNo');
        $phone = $this->input->post('phone');
        $identityPhoto = $_FILES['identityPhoto'];
        $photo = $_FILES['photo'];

        $data_guest = [
        	'name' => $name,
        	'address' => $address,
        	'identityNo' => $identityNo,
        	'phone' => $phone
        ];

        if ( $identityPhoto['name'] != '' ) {
        	$temp_name = $identityPhoto['name'];
        	$target_dir = 'assets/files/' . md5(date('Y-m-d').'identityPhoto') . '/';

			$ext = explode('.', $temp_name);
			$end = strtolower(end($ext));

			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
			}

			$attachment_name = $target_dir."identityPhoto.".$end;

			move_uploaded_file($identityPhoto['tmp_name'], $attachment_name);
			$data_guest['identityPhoto'] = $attachment_name;
        }

        if ( $photo['name'] != '' ) {
        	$temp_name2 = $photo['name'];
        	$target_dir2 = 'assets/files/' . md5(date('Y-m-d').'photo') . '/';

			$ext2 = explode('.', $temp_name2);
			$end2 = strtolower(end($ext2));

			if (!file_exists($target_dir2)) {
				mkdir($target_dir2, 0777, true);
			}

			$attachment_name2 = $target_dir2."photo.".$end2;

			move_uploaded_file($photo['tmp_name'], $attachment_name2);
			$data_guest['photo'] = $attachment_name2;
        }

        $guestID = $this->sitemodel->insert('guest', $data_guest);
		
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully created guest.";
		$this->response['guestID'] = $guestID;
		echo json_encode($this->response);
		exit;
	}

	public function save_attendance()
	{
        if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}

        // echo json_encode($this->input->post());die;

        $emp_name = $this->get_emp_name($this->input->post('emp_nip'));

        $data_attendance = [
        	'guestID' => $this->input->post('guestID'),
        	'locationID' => $this->log_location,
        	'userID' => $this->log_user,
        	'purpose' => $this->input->post('purpose'),
        	'total_guest' => $this->input->post('total_guest'),
        	'emp_nip' => $this->input->post('emp_nip'),
        	'emp_name' => $emp_name
        ];

        $results = $this->sitemodel->insert('attendance', $data_attendance);

        $this->send_email($this->input->post('emp_nip'), $results);
		
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully created attendance.";
		echo json_encode($this->response);
		exit;
	}

	public function send_email($emp_nip, $id)
	{
		$email_receiver = $this->get_emp_email($emp_nip);
		$subject = "Pemberitahuan Kedatangan Tamu";
		$data_email['email']['title'] = "Anda Kedatangan Tamu";
		$content = $this->sitemodel->view('view_detail_attendance', '*', ['id'=>$id]);
		$data_email['email']['content'] = $content[0];
		$data_email['page'] = 'email';
		$content = $this->load->view('email_page', $data_email, true);

		$isSent = sendEmail($email_receiver, $subject, $content, "Media Group");
		if (! $isSent) {
			$msg['msg'] = "Oops, we failed to send an email to." . $email_receiver;
			echo json_encode($msg);
			return;
		}
	}

	public function find()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$key = $this->input->post("key");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($key) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$check = $this->sitemodel->view($this->from, $this->select, ['id'=>$key]);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		//echo json_encode($check);die;
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		$this->response['emp_dept'] = $this->get_emp_department($check[0]->emp_nip);
		$this->response['emp_ext'] = '-';
		echo json_encode($this->response);
		exit;
	}

	public function delete()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$key = $this->input->post("key");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($key) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$check = $this->sitemodel->view($this->from, $this->select, ['id'=>$key]);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		// Delete 
		$this->sitemodel->delete('attendance', ['id'=>$key]);
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Berhasil menghapus data.";
		echo json_encode($this->response);
		exit;
	}

	public function addForm()
	{
		$input = array(
			'createdAt'					=> $this->session->userdata('name'),
			'updateAt'					=> htmlspecialchars($this->input->post('updateAt')),
			'name'						=> htmlspecialchars($this->input->post('name')),
			'address'					=> htmlspecialchars($this->input->post('address')),
			'identityNo'				=> htmlspecialchars($this->input->post('identityNo')),
			'phone'						=> htmlspecialchars($this->input->post('phone')),
			'identityPhoto'				=> htmlspecialchars($this->input->post('identityPhoto')),
			'photo'						=> htmlspecialchars($this->input->post('photo'))
		);

		$result = $this->AttendanceModel->add_form($input);

		$response = array(
			'status' 	=> 'Success',
			'message'	=> 'Data berhasil ditambahkan'
		);

		echo json_encode($response);
	}

	public function fetch_dataAtt()
	{
		$fetch_data = $this->AttendanceModel->make_datatables();

		$role 		= $this->session->userdata('role');

		$data 		= array();

		foreach ($fetch_data as $row) {
			$sub_array		= array();
			$sub_array[]	= $row->id;
			$sub_array[]	= $row->createdAt;
			$sub_array[]	= $row->location;
			$sub_array[]	= $row->user;
			$sub_array[]	= $row->employee;
			$sub_array[]	= $row->guest;
			$sub_array[]	= ($role == 1) ? '<button class="btn btn-success btn-circle btn-sm" title="View" name="viewBtn" id="'.$row->id.'"><i class="fas fa-check"></i></button><button class="btn btn-danger btn-circle btn-sm" title="Delete" name="deleteBtn" id="'.$row->id.'"><i class="fa fa-eye"></i></button>' : '<button class="btn btn-info btn-view" title="View" name="viewBtn" id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
			

			$data[]			= $sub_array;
		}

		$output = array(
			'draw'				=>	intval($_POST['draw']),
			'recordsTotal'		=>	$this->AttendanceModel->get_all_data(),
			'recordsFiltered'	=>	$this->AttendanceModel->get_filtered_data(),
			'data'				=>	$data
		);

		echo json_encode($output);
	}

	public function getSingleData()
	{
		$result = $this->AttendanceModel->get_single_data($this->input->post('id'));
		$data = array();

		foreach( $result as $row){
			$sub_array 		= array();
			$sub_array['guest_name']		= $row->guest_name;
			$sub_array['employee']		= $row->employee;
			$sub_array['purpose']		= $row->purpose;
			$sub_array['total_guest']		= $row->total_guest;
			$sub_array['phone']		= $row->phone;
			$sub_array['address']		= $row->address;
			$sub_array['photo']	= $row->photo;
			$sub_array['identityPhoto']		= $row->identityPhoto;
		}

		echo json_encode($sub_array);
	}

	// public function editForm()
	// {
	// 	$id = $this->input->post('id');

	// 	$input = array(
	// 			'departemen' 		=> htmlspecialchars($this->input->post('departemen')),
	// 			'operasional' 		=> htmlspecialchars($this->input->post('operasional')),
	// 			'nama_pengguna' 	=> htmlspecialchars($this->input->post('nama_pengguna')),
	// 			'user_login' 		=> htmlspecialchars($this->input->post('user_login')),
	// 			'hostname_pc' 		=> htmlspecialchars($this->input->post('hostname_pc')),
	// 			'barcode_pc' 		=> htmlspecialchars($this->input->post('barcode_pc')),
	// 			'serial_number_pc' 	=> htmlspecialchars($this->input->post('serial_number_pc')),
	// 			'jenisPC_id' 		=> htmlspecialchars($this->input->post('jenisPC_id')),
	// 			'os' 				=> htmlspecialchars($this->input->post('os')),
	// 			'mac_address' 		=> htmlspecialchars($this->input->post('mac_address')),
	// 			'mainboard' 		=> htmlspecialchars($this->input->post('mainboard')),
	// 			'processor' 		=> htmlspecialchars($this->input->post('processor')),
	// 			'ram' 				=> htmlspecialchars($this->input->post('ram')),
	// 			'vga' 				=> htmlspecialchars($this->input->post('vga')),
	// 			'hard_disk' 		=> htmlspecialchars($this->input->post('hard_disk')),
	// 			'barcode_monitor' 	=> htmlspecialchars($this->input->post('barcode_monitor')),
	// 			'serial_number' 	=> htmlspecialchars($this->input->post('serial_number')),
	// 			'merk' 				=> htmlspecialchars($this->input->post('merk')),
	// 			'intype' 			=> htmlspecialchars($this->input->post('intype')),
	// 			'ukuran' 			=> htmlspecialchars($this->input->post('ukuran')),
	// 			'antivirus' 		=> htmlspecialchars($this->input->post('antivirus')),
	// 			'ms_office' 		=> htmlspecialchars($this->input->post('ms_office')),
	// 			'email_outlock' 	=> htmlspecialchars($this->input->post('email_outlock')),
	// 			'aplikasi_tambahan' => htmlspecialchars($this->input->post('aplikasi_tambahan')),
	// 			'hardware_tambahan' => htmlspecialchars($this->input->post('hardware_tambahan')),
	// 			'keterangan' 		=> htmlspecialchars($this->input->post('keterangan')),
	// 			'edited_by' 		=> $this->session->userdata('name'),
	// 	);

	// 	$result = $this->PcModel->edit_form($input, $form_id);

	// 	$response = array(
	// 		'status' 	=> 'Success',
	// 		'message'	=> 'Data berhasil diubah'
	// 	);

	// 	echo json_encode($response);

	// }

	public function checkValidation()
	{
		$dataValidation = array(
			'guest_name'		=> htmlspecialchars($this->input->post('guest')),
			'identityNo'		=> htmlspecialchars($this->input->post('identityNo')),
		);

		$fetch_data = $this->AttendanceModel->check_validation($dataValidation);

		if ($fetch_data->num_rows() > 0) {

			$result = array(
				'message' => 'Data tamu sudah tersimpan sebelumnya',
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

	public function getLocation()
	{
		$fetch_data = $this->AttendanceModel->get_Location();
		$data = array();

		foreach($fetch_data as $row){
			$sub_array 		= array();
			$sub_array[]	= $row->id;
			$sub_array[]	= $row->location;
			$data[]			= $sub_array;
		}

		echo json_encode($data);
	}

	public function getUser()
	{
		$fetch_data = $this->AttendanceModel->get_User();
		$data = array();

		foreach($fetch_data as $row){
			$sub_array 		= array();
			$sub_array[]	= $row->id;
			$sub_array[]	= $row->name;
			$data[]			= $sub_array;
		}

		echo json_encode($data);
	}

}
