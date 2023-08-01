<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class LocationModel extends CI_Model {
	public $table 			= 'location';
	public $select_column 	= array('id', 'createdAt', 'updateAt', 'name');
	public $order_column 	= array('id', 'createdAt', 'updateAt', 'name');

	public function add_location($input)
	{
		$this->db->select('id');
		$this->db->where($input);
		$query = $this->db->get('location');

		foreach ($query->result() as $row) {
			$data = array(
				'id' => $row->id
			);

			$this->db->insert('location', $data);
		}

	}

	public function make_query()
	{
		$this->db->select($this->select_column);  
		$this->db->from($this->table);
		if(isset($_POST["search"]["value"]))  
		{
			$this->db->like('createdAt', $_POST['search']['value']);
			$this->db->or_like('updateAt', $_POST['search']['value']);
			$this->db->or_like('name', $_POST['search']['value']);
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

	public function get_single_data($idLocation)
	{
		$this->db->select('*');
		$this->db->from('location');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function check_validation($dataValidation)
	{
		$this->db->where($dataValidation);
		$query = $this->db->get('location');
		return $query;
	}
	
}
