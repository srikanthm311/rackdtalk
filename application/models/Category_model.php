<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Category_model extends CI_Model {

	

	private $tablename = '';

	public function __construct()

	{

		parent::__construct();

		$this->load->database();

		$this->tablename = 'rt_tb_category';

	}

	

	public function getAllCategoriesCount($array = array())

	{

		$cond_array = array('l.is_delete' => 0);

		$this->db->select('l.*');

		$this->db->from($this->tablename .' AS l');

		if(isset($array['id']) && !empty($array['id']))

		$this->db->where('l.id', $array['id']);

		if(isset($array['name']) && !empty($array['name']))

		$this->db->like('l.category_name', $array['name']);

		if(isset($array['is_active']) && !empty($array['is_active']))

		$this->db->where('l.is_active', $array['is_active']);

		//$this->db->group_by('l.locationID' );



		$query = $this->db->get();	

		return $query->num_rows();

	}

	

	public function getAllCategories($array = array())

	{

		$cond_array = array('l.is_delete' => 0);

		$this->db->select('l.*');

		$this->db->from($this->tablename .' AS l');

		if(isset($array['id']) && !empty($array['id']))

		$this->db->where('l.id', $array['id']);

		if(isset($array['name']) && !empty($array['name']))

		$this->db->like('l.category_name', $array['name']);

		if(isset($array['is_active']) && !empty($array['is_active']))

		$this->db->where('l.is_active', $array['is_active']);

		$this->db->order_by("l.category_name", "ASC");

		if(isset($array['recordsperpage']) && isset($array['limit']))

		$this->db->limit($array['recordsperpage'], $array['limit']);

		

		$query = $this->db->get();

		

		if($query->num_rows() > 0)

		{

			$return_categories = array();

			$categories = $query->result_array();

			foreach($categories as $location)

			{

				$return_categories[$location['id']] = $location;

			}

			return $return_categories;

		}

		else

			return false;

	}

	

	public function insertCategory($array)

	{

		if(!empty($array['name']))

		{
			
			$category_uid=$this->common->random_generator(10);

			$insert_array = array('category_name' => $array['name'],'category_name_hi' => $post['name_hi'],'image'=>$array['cat_image_soure'],'category_uid' => $category_uid, 'is_active' =>  $array['status'] );

			$this->db->insert($this->tablename, $insert_array);

			$id = $this->db->insert_id();

			return $id;

		}

		else

			return false;

	}

	

	public function updateCategory($array)

	{

		if(!empty($array['name']) && !empty($array['id']))

		{

			

			$insert_array = array('category_name' => $array['name'],'is_active' => $array['status'],'updated_at' => date('Y-m-d H:i:s'));

			$cond_array = array('id' => $array['id']);

			$this->db->update($this->tablename, $insert_array, $cond_array);

			$locationID =  $array['id'];

			

			return $locationID;

		}

		else

			return false;

	}

	

	

	



}

?>