<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blogs_model extends CI_Model {
	
	private $tablename = '';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tablename = 'tbl_blogs';
	}
	
		
	
	
	public function getAllBlogsCount($array = array())
	{
		$cond_array = array('l.is_deleted' => 0);
		$this->db->select('l.*,count(bc.id) as comments');
		$this->db->from($this->tablename .' AS l');
		$this->db->join('tbl_blog_comments AS bc','bc.blog_id = l.id','left');
		$this->db->where($cond_array);
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['title']) && !empty($array['title']))
		$this->db->like('l.title', $array['title']);
		if(isset($array['short_description']) && !empty($array['short_description']))
		$this->db->like('l.short_description', $array['short_description']);
		if(isset($array['is_active']) && !empty($array['is_active']))
		$this->db->where('l.is_active', $array['is_active']);
		//$this->db->group_by('l.locationID' );

		$query = $this->db->get();	
		return $query->num_rows();
	}
	
	public function getAllBlogs($array = array())
	{
		$cond_array = array('l.is_deleted' => 0);
		$this->db->select('l.*,count(bc.id) as comments');
		$this->db->from($this->tablename .' AS l');
		$this->db->join('tbl_blog_comments AS bc','bc.blog_id = l.id','left');
		$this->db->where($cond_array);
        if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['title']) && !empty($array['title']))
		$this->db->like('l.title', $array['title']);
		if(isset($array['short_description']) && !empty($array['short_description']))
		$this->db->like('l.short_description', $array['short_description']);
		if(isset($array['is_active']) && !empty($array['is_active']))
		$this->db->where('l.is_active', $array['is_active']);
		$this->db->group_by('l.id' );
		$this->db->order_by("l.id", "DESC");
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
	
	
	
	public function insertBlog($array)
	{
		if(!empty($array['title']))
		{
			$insert_array = array('title' => $array['title'],'short_description' =>  $array['short_description'],'description' =>  $array['description'], 'is_active' =>  $array['status'],'image' =>$array['applimagepath'],'created_at' => date('Y-m-d H:i:s'));
			$this->db->insert($this->tablename, $insert_array);
			$id = $this->db->insert_id();
			return $id;
		}
		else
			return false;
	}
	
	public function updateBlog($array)
	{
		if(!empty($array['title']) && !empty($array['id']))
		{
			$insert_array = array('title' => $array['title'],'short_description' =>  $array['short_description'],'description' =>  $array['description'], 'is_active' =>  $array['status'],'image' =>$array['applimagepath'], 'is_active' => $array['status']);
			$cond_array = array('id' => $array['id']);
			$this->db->update($this->tablename, $insert_array, $cond_array);
			$locationID =  $array['id'];
			
			return $locationID;
		}
		else
			return false;
	}
        public function getBlogComments($blogID='') 
	{

		$filters=array();
		$this->db->select('vc.*,vu.first_name as user,vu.pic');
		$this->db->from('tbl_blog_comments AS vc');
		$this->db->join('tbl_customer AS vu', 'vu.customer_id = vc.customer_id', 'inner');
		$this->db->where(array('vc.parent_id' => 0));
		if(!empty($blogID))
		$this->db->where_in('vc.blog_id' , $blogID);
		$query = $this->db->get();//echo $this->db->last_query();exit;
		$filters=$query->result_array();

		foreach($filters as $key=>$filter)
		{
			$filters[$key]['id']=$filter['id'];
			$filters[$key]['user']=$filter['user'];
			$filters[$key]['pic']=$filter['pic'];
			$filters[$key]['comment']=$filter['comment'];
			$filters[$key]['childs']=$this->getBlogSubComments($filter['id'],$selIDs);
		}
		$filters=$this->changekeysmultilevel($filters,'id','childs');
		return $filters;
	}



        public function getBlogSubComments($id,$selIDs='') 
	{	

	    $childs=array();
		$this->db->select('vc.*,vu.first_name as user,vu.pic');
		$this->db->from('tbl_blog_comments AS vc');
		$this->db->join('tbl_customer AS vu', 'vu.customer_id = vc.customer_id', 'inner');
		$this->db->where(array('vc.parent_id' => $id));
		if(!empty($selIDs))
		$this->db->where_in('id',$selIDs);
		$query = $this->db->get();
		$childs=$query->result_array();

		if(count($childs)>0)
		{
			foreach($childs as $ckey=>$child){
				$childs[$ckey]['childs']= $this->getBlogSubComments($child['id'],$selIDs);
				//$childs[$ckey]['childsCount'] = count($this->getBlogSubComments($child['id'],$selIDs));
			}
		}
		return $childs;
	}
        public function changekeysmultilevel($sarray,$skey,$lkey)
 	{	
	    $result=array();
		foreach($sarray as $key=>$val)
		{
			$result[$val[$skey]]=$val;
			if(count($val[$lkey])>0)
				$result[$val[$skey]][$lkey]=$this->changekeysmultilevel($val[$lkey],$skey,$lkey);
		}
		return $result;
	}	
	

}
?>