<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->select 		= '*';
		$this->from   		= 'location';
		$this->order_by   	= ['id'=>'DESC'];
		$this->order 		= ['id', 'name'];
		$this->search 		= ['id', 'name'];
	}

	public function index()
	{
		if (!$this->hasLogin()) {
			redirect('site/login');
		}

		$this->fragment['js'] = [ 
			base_url('assets/vendor/jquery-form/jquery.form.min.js'),
			base_url('assets/js/pages/location.js') 
		];

		$this->fragment['pagename'] = 'pages/location_page.php';
		$this->load->view('layout/main-site', $this->fragment);
	}

	public function view()
	{
		$data = array();
		$res = $this->sitemodel->get_datatable($this->select, $this->from, $this->order_by, $this->search, $this->order);
		$q = $this->db->last_query();

		foreach ($res as $row) {
			$col = array();
			$col[] = $row->name;
			$col[] = '
				<button id="btn-editloc" class="btn btn-success btn-circle btn-sm" data-id="'.$row->id.'"><i class="fa fa-pencil-alt"></i></button> 
				<button id="btn-deleteloc" class="btn btn-danger btn-circle btn-sm" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
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

	public function find(){
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
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	public function save()
	{
		// echo json_encode($this->input->post());die;
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		// PARAMS
		$name 			= $this->input->post('location_name');
		$type 			= $this->input->post('type');
		$id 			= $this->input->post('id');

		$type = ($type == 'update') ? 'update' : 'new';

		$data = [
			'name'		=> $name,
			'updateAt'	=>  date('Y-m-d H:i:s'),
		];

		if ($type == 'new') {
			$data['createdAt']	= date('Y-m-d H:i:s');
		}

		if ($type == 'update') {
			$this->sitemodel->update($this->from, $data, ['id'=>$id]);
		}else{
			$id = $this->sitemodel->insert($this->from, $data);
		}

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = ($type == "update") ? "Berhasil mengubah data." : "Berhasil menambahkan data.";
		echo json_encode($this->response);
		exit;
	}

	public function delete(){
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
		$this->sitemodel->delete($this->from, ['id'=>$key]);
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Berhasil menghapus data.";
		echo json_encode($this->response);
		exit;
	}

}
