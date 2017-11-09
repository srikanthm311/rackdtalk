<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model {
	
	private $tablename = '';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tablename = 'tbl_customer';
	}
	
	
	public function getAllCustomersCount($array = array())
	{
		$cond_array = array('l.is_deleted' => 0);
		$this->db->select('l.*,c.name as cityname,s.name as statename');
		$this->db->from($this->tablename .' AS l');
		$this->db->join('tbl_locations as c', 'l.city = c.locationID', 'left');
		$this->db->join('tbl_locations as s', 'l.state = s.locationID', 'left');
		$this->db->where($cond_array);
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.customer_id', $array['id']);
		if(isset($array['username']) && !empty($array['username']))
		$this->db->where('l.username', $array['username']);
		if(isset($array['mobile']) && !empty($array['mobile']))
		$this->db->where('l.mobile', $array['mobile']);
		if(isset($array['city']) && !empty($array['city']))
		$this->db->like('l.city', $array['city']);
		if(isset($array['zipcode']) && !empty($array['zipcode']))
		$this->db->like('p.zipcode', $array['zipcode']);
		if(isset($array['is_active']) && !empty($array['is_active']))
		$this->db->where('l.is_active', $array['is_active']);
		//$this->db->group_by('l.locationID' );

		$query = $this->db->get();	
		return $query->num_rows();
	}
	
	public function getAllCustomers($array = array())
	{
		$cond_array = array('l.is_deleted' => 0);
		$this->db->select('l.*,c.name as cityname,s.name as statename');
		$this->db->from($this->tablename .' AS l');
		$this->db->join('tbl_locations as c', 'l.city = c.locationID', 'left');
		$this->db->join('tbl_locations as s', 'l.state = s.locationID', 'left');
		$this->db->where($cond_array);
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.customer_id', $array['id']);
		if(isset($array['username']) && !empty($array['username']))
		$this->db->where('l.username', $array['username']);
		if(isset($array['mobile']) && !empty($array['mobile']))
		$this->db->where('l.mobile', $array['mobile']);
		if(isset($array['city']) && !empty($array['city']))
		$this->db->like('l.city', $array['city']);
		if(isset($array['zipcode']) && !empty($array['zipcode']))
		$this->db->like('p.zipcode', $array['zipcode']);
		if(isset($array['is_active']) && !empty($array['is_active']))
		$this->db->where('l.is_active', $array['is_active']);
		$this->db->order_by("l.customer_id", "DESC");
		if(isset($array['recordsperpage']) && isset($array['limit']))
		$this->db->limit($array['recordsperpage'], $array['limit']);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$return_categories = array();
			$categories = $query->result_array();
			foreach($categories as $location)
			{
				$return_categories[$location['customer_id']] = $location;
			}
			return $return_categories;
		}
		else
			return false;
	}
	
	
	
	public function insertCustomer($array)
	{
		if(!empty($array['first_name']))
		{
			$insert_array = array('first_name' => $array['first_name'],'last_name' => $array['last_name'], 'username' => $array['username'], 'is_active' =>  $array['status'],'image' =>$array['applimagepath'],'mobile' => $array['mobile'],'address' => $array['address'],'city' => $array['city'],'state' => $array['state'],'zipcode' => $array['zipcode'],'created_at' => date('Y-m-d H:i:s'));
			$this->db->insert($this->tablename, $insert_array);
			$id = $this->db->insert_id();
			return $id;
		}
		else
			return false;
	}
	
	public function updateCustomer($array)
	{
		if(!empty($array['first_name']) && !empty($array['id']))
		{
			$insert_array = array('first_name' => $array['first_name'],'last_name' => $array['last_name'], 'username' => $array['username'], 'is_active' =>  $array['status'],'image' =>$array['applimagepath'],'mobile' => $array['mobile'],'address' => $array['address'],'city' => $array['city'],'state' => $array['state'],'zipcode' => $array['zipcode']);
			$cond_array = array('customer_id' => $array['id']);
			$this->db->update($this->tablename, $insert_array, $cond_array);
			$CustomerID =  $array['id'];
			
			return $CustomerID;
		}
		else
			return false;
	}
	
}
?>