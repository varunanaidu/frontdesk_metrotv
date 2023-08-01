<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AttendanceModel extends CI_Model {
	public $table 			= 'guest';
	public $select_column 	= array('id', 'createdAt', 'updateAt', 'name', 'address', 'identityNo', 'phone', 'identityPhoto', 'photo', 'purpose', 'total_guest');
	public $order_column 	= array('id', 'createdAt', 'updateAt', 'name', 'address', 'identityNo', 'phone', 'identityPhoto', 'photo', 'purpose', 'total_guest');

	public function add_form($input)
	{
		$this->db->insert('id', $input);
		$this->attendance($input);
	}

	public function attendance($input)
	{
		$this->db->select('id');
		$this->db->where($input);
		$query = $this->db->get('id');

		foreach ($query->result() as $row) {
			$data = array(
				'id' => $row->id
			);

			$this->db->insert('attendance', $data);
		}

	}

	public function make_query()
	{
		$this->db->select($this->select_column);  
		$this->db->from($this->table);
		$this->db->join('location', 'location.id = attendance.locationID');
		$this->db->join('user', 'user.id = attendance.userID');
		if(isset($_POST["search"]["value"]))  
		{
			$this->db->like('createdAt', $_POST['search']['value']);
			$this->db->or_like('updateAt', $_POST['search']['value']);
			$this->db->or_like('name', $_POST['search']['value']);
			$this->db->or_like('address', $_POST['search']['value']);
			$this->db->or_like('identityNo', $_POST['search']['value']);
			$this->db->or_like('phone', $_POST['search']['value']);
			$this->db->or_like('identityPhoto', $_POST['search']['value']);
			$this->db->or_like('photo', $_POST['search']['value']);
			$this->db->or_like('purpose', $_POST['search']['value']);
			$this->db->or_like('total_guest', $_POST['search']['value']);
		}  
		if(isset($_POST["order"]))  
		{  
			$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		}  
		else  
		{  
			$this->db->order_by('id', 'DESC');  
		} 
	}

	public function make_datatables()
	{
		$this->make_query();

		if($_POST["length"] != -1)  
		{  
			$this->db->limit($_POST['length'], $_POST['start']);  
		}

		$query = $this->db->get();  
		return $query->result();
	}  

	public function get_filtered_data()
	{  
		$this->make_query();  
		$query = $this->db->get();  
		return $query->num_rows();  
	}

	public function get_all_data()  
	{  
		$this->make_query();  
		$query = $this->db->get();  
		return $query->num_rows(); 
	}

	public function get_single_data($id)
	{
		$this->db->select('*');
		$this->db->from('guest');
		$this->db->join('location', 'location.id = attendance.locationID');
		$this->db->join('user', 'user.id = attendance.userID');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function edit_form($input, $id)
	{
		$this->db->set($input);
		$this->db->where('id', $id);
		$query = $this->db->update('guest');
	}

	public function check_validation($dataValidation)
	{
		$this->db->where($dataValidation);
		$query = $this->db->get('id');
		return $query;
	}

	public function get_Location()
	{
		$query = $this->db->get('location');
		return $query->result();
	}
	
	public function get_User()
	{
		$query = $this->db->get('user');
		return $query->result();
	}
}
