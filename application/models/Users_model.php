<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {
	 public $tablename;
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->tablename='tr_tb_user';
		}
	
	  public function checkAuthentication($array)
	{
		$where = '(email_id="'.$array['user_name'].'" or u.mobile = "'.$array['user_name'].'")';
		$this->db->select('u.id,verification_at,email_id,u.mobile,u.is_active,u.first_name,u.last_name,u.subscription_id,u.user_uid,u.role_id');
		$this->db->from($this->tablename.' as u');
		$this->db->where($where);
		$this->db->where('password',md5($array['password']));
		$this->db->where(array('u.is_delete' => 0,'u.role_id' => 3));
		$query = $this->db->get();//echo $this->db->last_query();exit;
		$data=$query->row_array();
		
		if($query->num_rows() == 1)
		{
			if($data['is_active']==1)
			{
			   if($data['verification_at']!='')
				{
				   return array('status' => true, 'message' => 'Logged in successfully.', 'user' => $data);
				}
				else
				{
					return array('status' => false, 'message' => 'Please verify the details.');				
				}
			}
			else
			{
				return array('status' => false, 'message' => 'You are in inactive state. Please contact admin.');				
			}
		}
		else
		{
			return array('status' => false, 'message' => 'Invalid username or password.');				
		}
	}
	public function getCommonData()
		{
		  
		     $totalUsers= $this->db->query('SELECT count(*) as totalUsers from tr_tb_user WHERE is_active =1 AND is_delete=0 AND varification_code = ""  AND verification_at <> ""')->row_array();
		    $totalQuestions = $this->db->query('SELECT count(*) as  totalQuestions from rt_tb_question WHERE is_approved =1 AND is_delete=0 AND is_active =1')->row_array();
		    $result= array('totalUsers' => $totalUsers['totalUsers'],'totalQuestions' => $totalQuestions['totalQuestions']);
			return $result;
		}
		
		public function getWinnersData()
		{
		  
		     $results= $this->db->query('SELECT qcw.*,qu.first_name as winnername,qu.pic as user_pic,qc.comment from rt_tb_comment_bid_winners as qcw inner join tr_tb_user as qu on qcw.user_id=qu.id inner join rt_tb_question_comment as qc on qc.id=qcw.comment_id group by qcw.id order by qcw.id,qcw.winning_position Desc
')->result_array();
             $result_arr=array();
             foreach($results as $result)
			 {
		  	 $result_arr['data'][$result['comment_id']][]=$result;
			 $result_arr['comments'][$result['comment_id']]=$result['comment'];
			 }
			 return $result_arr;
		}
	public function getBestAnsweredWinners()
	{
	 $results= $this->db->query('SELECT qbw.`user_id`,qbw.`winning_amount`,qbw.`winning_position`,qu.pic as user_pic,qu.first_name,qu.created_at FROM `rt_tb_comment_bid_winners` qbw inner join tr_tb_user qu on qu.id=qbw.user_id WHERE `winner_type`="comment" group by question_id order by qbw.winning_amount desc')->result_array();
	 return $results;
	}
    public function getSettings()
	{
		$results=array();
		$settings=$this->db->get('settings')->result_array();
		foreach($settings as $setting)
		{
			$results[$setting['key']]= $setting['value'];
		}
		return $results;
	}
	
		public function getTestmonials($array = array())
	   {
		$cond_array = array('l.is_delete' => 0);
		$this->db->select('l.*,u.first_name,,u.pic as user_pic');
		$this->db->from('rt_tb_testmonials AS l');
		$this->db->join('tr_tb_user as u', 'u.id = l.user_id', 'inner');
		$this->db->where($cond_array);
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['is_approve']) && !empty($array['is_approve']))
		$this->db->where('l.is_approve', $array['is_approve']);
		$query = $this->db->get();	
		return $query->result_array();
	}
		
	
	  public function createUser($post)
	{

		$data = array('first_name' => $post['name'],'last_name' => $post['name'],'role_id' => 3,'email_id' => $post['email'],'alternate_email' => $post['email'],'password'=>md5($post['password']),'mobile'=>$post['mobile'],'is_active' => 1,'updated_at' => date('Y-m-d H:i:s'),'varification_code' =>$post['email_verify_code']); 
		$query=$this->db->insert($this->tablename, $data);
		if($query)
		{
		$user_id=$this->db->insert_id();
		$user_uid='TR-'.str_pad($user_id, 5, '0', STR_PAD_LEFT);
		$this->db->update($this->tablename,array('user_uid'=> $user_uid),array('id'=> $user_id));
		return $user_id;
		}
		else
			return false;

	}
	
	   
	public function getAllUsersCount($array = array())
	   {
		$cond_array = array('l.is_delete' => 0);
		$this->db->select('l.*,c.name as Countryname,s.name as statename,ct.name as cityname');
		$this->db->from($this->tablename .' AS l');
		$this->db->join('rt_tb_countries as c', 'l.country = c.id', 'left');
		$this->db->join('rt_tb_states as s', 'l.state = s.id', 'left');
		$this->db->join('rt_tb_cities as ct', 'l.city = ct.id', 'left');
		$this->db->where($cond_array);
		$this->db->where(array('role_id !=' =>1));
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['username']) && !empty($array['username']))
		$this->db->where('l.email_id', $array['username']);
		if(isset($array['mobile']) && !empty($array['mobile']))
		$this->db->where('l.mobile', $array['mobile']);
		if(isset($array['city']) && !empty($array['city']))
		$this->db->like('l.city', $array['city']);
		if(isset($array['zipcode']) && !empty($array['zipcode']))
		$this->db->like('l.pin_code', $array['zipcode']);
		if(isset($array['is_active']) && !empty($array['is_active']))
		$this->db->where('l.is_active', $array['is_active']);
		//$this->db->group_by('l.locationID' );

		$query = $this->db->get();	
		return $query->num_rows();
	}
	
	public function getAllUsers($array = array())
	{
		$cond_array = array('l.is_delete' => 0);
		$this->db->select('l.*,c.name as Countryname,s.name as statename,ct.name as cityname');
		$this->db->from($this->tablename .' AS l');
	     $this->db->join('rt_tb_countries as c', 'l.country = c.id', 'left');
		$this->db->join('rt_tb_states as s', 'l.state = s.id', 'left');
		$this->db->join('rt_tb_cities as ct', 'l.city = ct.id', 'left');
		$this->db->where($cond_array);
		$this->db->where(array('role_id !=' =>1));
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['username']) && !empty($array['username']))
		$this->db->where('l.email_id', $array['username']);
		if(isset($array['mobile']) && !empty($array['mobile']))
		$this->db->where('l.mobile', $array['mobile']);
		if(isset($array['city']) && !empty($array['city']))
		$this->db->like('l.city', $array['city']);
		if(isset($array['zipcode']) && !empty($array['zipcode']))
		$this->db->like('l.pin_code', $array['zipcode']);
		if(isset($array['is_active']) && !empty($array['is_active']))
		$this->db->where('l.is_active', $array['is_active']);
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
	
	

	
    public function updateQuestion($post)
	{

		$data = array('user_id' => $post['user_id'],'category_id' => $post['segment'],'question' => $post['question'],'description' => $post['description'],'tags' => $post['tags'],'type' => $post['qtype'],'comments_closed_at' => date('Y-m-d H:i:s'),'bidding_closed_at'=>date('Y-m-d H:i:s'),'is_trending'=>0,'is_approved' => 0,'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1); 
		$query=$this->db->insert('rt_tb_question', $data);
		if($query)
		{
		$question_id=$this->db->insert_id();
		$question_uid='TRQ-'.str_pad($question_id, 5, '0', STR_PAD_LEFT);
		$this->db->update('rt_tb_question',array('question_uid'=> $question_uid),array('id'=> $question_id));
		return $question_id;
		}
		else
			return false;

	}


    public function updateComment($post)
	{
		 $data = array('user_id' => $post['user_id'],'qusetion_id' => $post['question_id'],'ip_address' => $_SERVER['REMOTE_ADDR'],'comment' => $post['description'],'bidding_closed_at' => date('Y-m-d H:i:s'),'is_closed' => 0,'is_biddable' => 1,'is_approved' => 0,'bidding_closed_at'=>date('Y-m-d H:i:s'),'is_delete'=>0,'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1); 
		$query=$this->db->insert('rt_tb_question_comment', $data);
		$comment_id=$this->db->insert_id();
		$transdata=array('txn_uid' =>rand(1,999999999),'user_id' =>$post['user_id'],'user_type' =>'talker','amount' =>5,'txn_type' =>'debit','is_refunded' =>'No','refund_txn_id'=>'','refunded_txn_id'=>'','comment'=>$comment_id,'status'=>'SUCCESS');
		$query=$this->db->insert('rt_tb_transactions', $transdata);
		return $comment_id;

	}
	
	
	public function getAllTransactionsCount($array = array())
	 {
		$this->db->select('l.*,u.email_id');
		$this->db->from('rt_tb_transactions AS l');
		$this->db->join($this->tablename.' as u', 'l.user_id = u.id', 'inner');
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['user_id']) && !empty($array['user_id']))
		$this->db->where('l.user_id', $array['user_id']);
		if(isset($array['status']) && !empty($array['status']))
		$this->db->where('l.status', $array['status']);
		$query = $this->db->get();	
		return $query->num_rows();
	}	
	public function getAllTransactions($array = array())
	{
		$this->db->select('l.*,u.email_id');
		$this->db->from('rt_tb_transactions AS l');
		$this->db->join($this->tablename.' as u', 'l.user_id = u.id', 'inner');
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['user_id']) && !empty($array['user_id']))
		$this->db->where('l.user_id', $array['user_id']);
		if(isset($array['status']) && !empty($array['status']))
		$this->db->where('l.status', $array['status']);
		if(isset($array['orderby']) && isset($array['ordertype']))
		$this->db->order_by($array['orderby'], $array['ordertype']);
		if(isset($array['recordsperpage']) && isset($array['limit']))
		$this->db->limit($array['recordsperpage'], $array['limit']);
		
		$query = $this->db->get(); //echo $this->db->last_query();exit;
		
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
	
	public function getAllWithdrawals($array = array())
	{
		$this->db->select('l.*,u.email_id');
		$this->db->from('rt_tb_withdraw AS l');
		$this->db->join($this->tablename.' as u', 'l.user_id = u.id', 'inner');
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['user_id']) && !empty($array['user_id']))
		$this->db->where('l.user_id', $array['user_id']);
		if(isset($array['status']) && !empty($array['status']))
		$this->db->where('l.status', $array['status']);
		if(isset($array['orderby']) && isset($array['ordertype']))
		$this->db->order_by($array['orderby'], $array['ordertype']);
		if(isset($array['recordsperpage']) && isset($array['limit']))
		$this->db->limit($array['recordsperpage'], $array['limit']);
		
		$query = $this->db->get(); //echo $this->db->last_query();exit;
		
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
	
	public function getAllWithdrawalscount($array = array())
	{
		$this->db->select('l.*,u.email_id');
		$this->db->from('rt_tb_withdraw AS l');
		$this->db->join($this->tablename.' as u', 'l.user_id = u.id', 'inner');
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['user_id']) && !empty($array['user_id']))
		$this->db->where('l.user_id', $array['user_id']);
		if(isset($array['status']) && !empty($array['status']))
		$this->db->like('l.created_at', date('Y-m'));
		//$this->db->where(MONTH('l.created_at') = MONTH(CURRENT_DATE()));
		
		if(isset($array['orderby']) && isset($array['ordertype']))
		$this->db->order_by($array['orderby'], $array['ordertype']);
		if(isset($array['recordsperpage']) && isset($array['limit']))
		$this->db->limit($array['recordsperpage'], $array['limit']);
		$query = $this->db->get(); //echo $this->db->last_query();exit;
		return $query->num_rows();
	}
	



	
}



?>