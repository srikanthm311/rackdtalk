<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Admin_model extends CI_Model {

	

	public function __construct()

	{

		parent::__construct();

		$this->load->database();

	}

	

	

	public function authenticate_user($post='')

	{

		//$this->db->select('id, userid, username');

		$this->db->where(array('email_id' => $post['username'], 'password' => md5($post['password']),'role_id' => 2));

		$query = $this->db->get('tr_tb_user');//echo $this->db->last_query();exit;

		 return $query->row_array();

	}
	
	
	public function createUser($post)
	{
		$query=$this->db->insert('tr_tb_user', $post);
		if($query)
		{
		$user_id=$this->db->insert_id();
		$user_uid='TR-'.str_pad($user_id, 5, '0', STR_PAD_LEFT);
		$this->db->update('tr_tb_user',array('user_uid'=> $user_uid),array('id'=> $user_id));
		return $user_id;
		}
		else
			return false;

	}
	 public function getRights($uid)
	{
		$results=array();
		$rights=$this->db->where(array('user_id' => $uid))->get('rt_tb_rights')->result_array();
		foreach($rights as $right)
		{
			$results[$right['value']]= $right['value'];
		}
		return $results;
	}
	
	
	
	public function getdata($thistablename,$condition,$array= array())
	 {
		if($thistablename == 'rt_tb_states'){
			$this->db->select('l.* , c.name as country_name');
			$this->db->from($thistablename .' As l');
			$this->db->join('rt_tb_countries As c', 'l.country_id = c.id', 'inner');
			}
		elseif($thistablename == 'rt_tb_cities'){
			$this->db->select('l.* , c.name as country_name , c.id as country_id, s.name as state_name');
			$this->db->from($thistablename .' As l');
			$this->db->join('rt_tb_states As s', 's.id = l.state_id', 'inner');
			$this->db->join('rt_tb_countries As c', 's.country_id = c.id', 'inner');
			}
		else{
			$this->db->select('*');
			$this->db->from($thistablename .' As l');
			}
		
		if(isset($condition['country_name']) && !empty($condition['country_name']))
			$this->db->like('l.name', $condition['country_name']);
			
		if(isset($condition['country_id']) && !empty($condition['country_id']))
			$this->db->where('c.id', $condition['country_id']);
		
		if(isset($condition['state_name']) && !empty($condition['state_name']))
			$this->db->like('l.name', $condition['state_name']);
			
		if(isset($condition['state_id']) && !empty($condition['state_id']))
			$this->db->where('s.id', $condition['state_id']);
		
		if(isset($condition['city_name']) && !empty($condition['city_name']))
			$this->db->like('l.name', $condition['city_name']);
			
		if(!isset($condition['search_identity'])){
		if(isset($array['recordsperpage']) && isset($array['limit']))
		$this->db->limit($array['recordsperpage'], $array['limit']);
		}
		$this->db->order_by('l.name', 'asc');
		$query = $this->db->get();
		//echo "<pre>"; print_r($query->result_array()); exit;
		if($query->num_rows() >= 1)
			return $query->result_array();
		else
			return false;
	 }
	 
	 public function getdata_count2($thistablename,$condition,$array= array())
	 {
		$this->db->select('*');
		$this->db->from($thistablename);
		if(isset($condition['country_name']) && !empty($condition['country_name']))
		$this->db->like('name', $condition['country_name']);
		$query = $this->db->get();
		return $query->num_rows();

	 }
	 
	 public function getdata_count($thistablename,$condition,$array= array())
	 {
		if($thistablename == 'rt_tb_states'){
			$this->db->select('l.* , c.name as country_name');
			$this->db->from($thistablename .' As l');
			$this->db->join('rt_tb_countries As c', 'l.country_id = c.id', 'inner');
			}
		elseif($thistablename == 'rt_tb_cities'){
			$this->db->select('l.* , c.name as country_name , c.id as country_id, s.name as state_name');
			$this->db->from($thistablename .' As l');
			$this->db->join('rt_tb_states As s', 's.id = l.state_id', 'inner');
			$this->db->join('rt_tb_countries As c', 's.country_id = c.id', 'inner');
			}
		else{
			$this->db->select('*');
			$this->db->from($thistablename .' As l');
			}
		
		if(isset($condition['country_name']) && !empty($condition['country_name']))
			$this->db->like('l.name', $condition['country_name']);
			
		if(isset($condition['country_id']) && !empty($condition['country_id']))
			$this->db->where('c.id', $condition['country_id']);
		
		if(isset($condition['state_name']) && !empty($condition['state_name']))
			$this->db->like('l.name', $condition['state_name']);
			
		if(isset($condition['state_id']) && !empty($condition['state_id']))
			$this->db->where('s.id', $condition['state_id']);
		
		if(isset($condition['city_name']) && !empty($condition['city_name']))
			$this->db->like('l.name', $condition['city_name']);
		$query = $this->db->get();
		//echo $query->num_rows(); exit;
		return $query->num_rows();

	 }
	
	public function updateCountry($post)
	{
		$update_array = array('sortname'=>$post['ccode'],'name'=>$post['cname'],'phonecode'=>$post['cpcode']);
		$cnd_arr = array('id' =>$post['id']);
		$this->db->update('rt_tb_countries', $update_array, $cnd_arr);
		return $post['id'];
		
		}
		
	public function updateState($post)
	{
		$update_array = array('name'=>$post['sname']);
		$cnd_arr = array('id' =>$post['id']);
		$this->db->update('rt_tb_states', $update_array, $cnd_arr);
		return $post['id'];
		
		}

	public function updateCity($post)
	{
		$update_array = array('name'=>$post['cityname']);
		$cnd_arr = array('id' =>$post['id']);
		$this->db->update('rt_tb_cities', $update_array, $cnd_arr);
		return $post['id'];
		
		}

	

	public function getAllNotificationsCount($array = array())

	   {

		$this->db->select('fhpl_notifications.*');

		if(isset($array['category']) && !empty($array['category']))

		$this->db->like('category', $array['category']);

		$query = $this->db->get('fhpl_notifications');

		if($query->num_rows() > 0)

		{

			$return_services = array();

			$services = $query->result_array();

			foreach($services as $service)

			{

				$return_services[$service['notifyID']] = $service;

			}

			return count($return_services);

		}

		else

			return false;

	}

	

	public function getAllNotifications($array = array())

	{

		$this->db->select('fhpl_notifications.*');

		if(isset($array['category']) && !empty($array['category']))

		$this->db->like('category', $array['category']);

		if(isset($array['recordsperpage']) && isset($array['limit']))

		$this->db->limit($array['recordsperpage'], $array['limit']);

		$query = $this->db->get('fhpl_notifications');

		//echo $this->db->last_query();exit;

		if($query->num_rows() > 0)

		{

			$return_services = array();

			$services = $query->result_array();

			foreach($services as $service)

			{

				$return_services[$service['notifyID']] = $service;

			}

			return $return_services;

		}

		else

			return false;

	}

	

	

		   

		public function format_uri( $string, $separator = '-' )

		{

			$accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';

			$special_cases = array( '&' => 'and', "'" => '');

			$string = mb_strtolower( trim( $string ), 'UTF-8' );

			$string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );

			$string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );

			$string = preg_replace("/[^a-z0-9]/u", "$separator", $string);

			$string = preg_replace("/[$separator]+/u", "$separator", $string);

			return $string;

	   }

	

		  public function array_equal($a, $b)

		  {

		   return (is_array($a) && is_array($b) && array_diff($a, $b) === array_diff($b, $a))? 'true':'false';

		  }

}