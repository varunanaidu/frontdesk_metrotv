<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."libraries/Libcurl.php";

class Report extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ReportModel');
		$this->load->library('guzzle');
		$this->select 		= '*';
		$this->from   		= 'view_detail_attendance';
		$this->order_by   	= ['id'=>'DESC'];
		$this->order 		= ['createdAt', 'location_name', 'user_name', 'emp_name', 'name', 'total_guest'];
		$this->search 		= ['createdAt', 'location_name', 'user_name', 'emp_name', 'name', 'total_guest'];
	}

	public function index()
	{
		$this->fragment['js'] = [ 
			base_url('assets/vendor/jquery-form/jquery.form.min.js'),
			base_url('assets/js/pages/report.js') 
		];

		$this->fragment['location'] = $this->sitemodel->view('location', '*');
		$this->fragment['emp'] = $this->sitemodel->view('view_dropdown', '*');

		$this->fragment['pagename'] = 'pages/report_page.php';
		$this->load->view('layout/main-site', $this->fragment);
	}

	public function view_report()
	{
		// echo json_encode($this->input->post());die;
		$fromdate = $this->input->post('fDate') ? $this->input->post('fDate') : '';
		$enddate = $this->input->post('tDate') ? $this->input->post('tDate') : '';
		$location = $this->input->post('fLocation');
		$emp = $this->input->post('fEmp');

		$param = [
			'fromdate' 	=> $fromdate,
			'enddate'	=> $enddate,
			'location'	=> $location,
			'emp'		=> $emp
		];

		$data = array();
		$res = $this->sitemodel->get_datatable($this->select, $this->from, $this->order_by, $this->search, $this->order, $param);
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
			"recordsFiltered" 	=> $this->sitemodel->get_datatable_count_filtered($this->select, $this->from, $this->order_by, $this->search, $this->order, $param),
			"data" 				=> $data,
			"q"					=> $q

		);
		echo json_encode($output);
		exit;
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
		//$this->response['emp_dept'] = $this->get_emp_department($check[0]->emp_nip);
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
}