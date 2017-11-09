<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Superadmin_model extends CI_Model {

	

	public function __construct()

	{

		parent::__construct();

		$this->load->database();

	}

	

	

	public function authenticate_user($post='')

	{

		//$this->db->select('id, userid, username');

		$this->db->where(array('email_id' => $post['username'], 'password' => md5($post['password']),'role_id' => 1));

		$query = $this->db->get('tr_tb_user');///echo $this->db->last_query();exit;

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
		
		public function getQuestions($thistablename,$condition,$array= array())
	 {
		 
		//echo "<pre>"; print_r($condition);
		//echo "<pre>"; print_r($array); exit;
			$this->db->select('l.* , c.category_name, u.email_id as useremail, u.role_id');
			$this->db->from($thistablename .' As l');
			$this->db->join('rt_tb_category As c', 'l.category_id = c.id', 'inner');
			$this->db->join('tr_tb_user As u', 'l.user_id = u.id', 'inner');
		
		if(isset($condition['id']) && !empty($condition['id']))
			$this->db->where('l.id', $condition['id']);
			
		if($condition['from']!='' && $condition['to'])
		{
			$this->db->where('l.created_at BETWEEN "'. date('Y-m-d', strtotime($condition['from'])). '" and "'. date('Y-m-d', strtotime($condition['to'])).'"');
		}
		
		$this->db->where('l.is_delete', 0);
		if(!isset($condition['search_identity'])){
		if(isset($array['recordsperpage']) && isset($array['limit']))
		$this->db->limit($array['recordsperpage'], $array['limit']);
		}
		
		$this->db->order_by('l.id', 'asc');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		//echo "<pre>"; print_r($query->result_array()); exit;
		if($query->num_rows() >= 1)
			return $query->result_array();
		else
			return false;
	 }
	 
	 public function getQuestions_count($thistablename,$condition,$array= array())
	 {
			$this->db->select('l.* , c.category_name, u.email_id as useremail');
			$this->db->from($thistablename .' As l');
			$this->db->join('rt_tb_category As c', 'l.category_id = c.id', 'inner');
			$this->db->join('tr_tb_user As u', 'l.user_id = u.id', 'inner');
		
		if($condition['from']!='' && $condition['to'])
		{
		$cwhere="AND DATE_FORMAT(created_by,'%m/%d/%Y')>='".$condition['from']."' AND DATE_FORMAT(created_at,'%m/%d/%Y')<='".$condition['to']."'";
		$bwhere="AND DATE_FORMAT(created_at,'%m/%d/%Y')>='".$condition['from']."' AND DATE_FORMAT(created_at,'%m/%d/%Y')<='".$condition['to']."'";
		$where="WHERE DATE_FORMAT(created_at,'%m/%d/%Y')>='".$condition['from']."' AND DATE_FORMAT(created_at,'%m/%d/%Y')<='".$condition['to']."'";
		}
		
		if(isset($condition['is_approved']) && !empty($condition['is_approved']))
			$this->db->like('l.is_approved', $condition['is_approved']);
		$this->db->where('l.is_delete', 0);
		$this->db->order_by('l.id', 'asc');
		$query = $this->db->get();
		return $query->num_rows();
	 }
	 
	  public function updateQuestion($post)
	{

		$data = array('user_id' => $post['admin'],'category_id' => $post['segment'],'question' => $post['question'],'question_hi' => $post['question_hi'],'description' => $post['description'],'description_hi' => $post['description_hi'],'tags' => $post['tags'],'type' => $post['qtype'],'comments_closed_at' => date('Y-m-d H:i:s'),'bidding_closed_at'=>date('Y-m-d H:i:s'),'is_trending'=>0,'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1,'is_approved' =>1,'is_trending'=>$post['trandding'],'bidding_closed_at'=>$post['bidding_closed_at'],'comments_closed_at'=>$post['comment_closed_at']); 
		$query=$this->db->insert('rt_tb_question', $data);
		if($query)
		{
		$question_id=$this->db->insert_id();
		$question_uid='TRQ-'.str_pad($question_id, 5, '0', STR_PAD_LEFT);
		$this->db->update('rt_tb_question',array('question_uid'=> $question_uid),array('id'=> $question_id));
		$this->db->insert('rt_tb_notifications',array('message'=> 'New Question "'.$post['question'].'" is Added'));
		return $question_id;
		}
		else
			return false;

	}
	
	public function getCommentsByQuestion($id,$user='')
	{
		 
		if($user!='') $where=' AND qc.user_id='.$user;
		 return $this->db->query('SELECT distinct qc.*,MAX(qcb.amount) as bidamountTotal,qu.first_name,qu.pic,count(qcld.id) as comment_likes_count from rt_tb_question_comment as qc left join rt_tb_comment_bid as qcb ON qc.id=qcb.comment_id inner join tr_tb_user as qu ON qu.id=qc.user_id left join rt_tb_comments_likes_dislikes qcld ON qcld.comment_id=qc.id where qc.qusetion_id='.$id.' AND qc.is_approved=1 '.$where.' AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 group by qc.id,qc.user_id order by MAX(qcb.amount) Desc')->result_array();
		
	}
	public function getCommentsByQuestionCounts($id,$user='')
	{
		 
		if($user!='') $where=' AND qc.user_id='.$user;
		 return $this->db->query('SELECT distinct qc.*,MAX(qcb.amount) as bidamountTotal,qu.first_name,qu.pic,count(qcld.id) as comment_likes_count from rt_tb_question_comment as qc left join rt_tb_comment_bid as qcb ON qc.id=qcb.comment_id inner join tr_tb_user as qu ON qu.id=qc.user_id left join rt_tb_comments_likes_dislikes qcld ON qcld.comment_id=qc.id where qc.qusetion_id='.$id.' AND qc.is_approved=1 '.$where.' AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 group by qc.id,qc.user_id order by MAX(qcb.amount) Desc')->num_rows();
		
	}

	public function getTotalCommentsAmt()
	{
		 
		if($user!='') $where=' AND qc.user_id='.$user;
		 return $this->db->query('select sum(amount) as totalAmount from rt_tb_transactions where user_type="talker" And txn_type="debit" AND status ="SUCCESS" AND type="direct" And comment in(select id from rt_tb_question_comment where qusetion_id=2 And is_delete=0 AND is_active=1)')->result_array();
		
	}
	public function getFrequentTakers($user='')
	{
		 
		if($user!='') $where=' AND qc.user_id='.$user;
		return $this->db->query('SELECT qu.*,count(qc.user_id) as c FROM tr_tb_user as qu inner join rt_tb_question_comment qc on qc.user_id=qu.id where qc.is_delete=0 AND qc.is_active=1 group by qu.id order by c desc')->result_array();
	}
	
	public function getTrendingTalkers($user='')
	{
		 
		if($user!='') $where=' AND qc.user_id='.$user;
		return $this->db->query('SELECT qu.*,count(qc.question_comment_count) as c FROM tr_tb_user as qu inner join rt_vw_question qc on qc.user_id=qu.id where qc.is_approved=1 AND qc.is_delete=0 AND qc.is_closed =0 group by qu.id order by c desc')->result_array();
	}
	
	
	public function userActivity($array)
	{
		$cwhere='';$bwhere='';
		if($array['from']!='' && $array['to'])
		{
		$cwhere="AND DATE_FORMAT(qc.created_at,'%m/%d/%Y')>='".$array['from']."' AND DATE_FORMAT(qc.created_at,'%m/%d/%Y')<='".$array['to']."'";
		$bwhere="AND DATE_FORMAT(qc.created_at,'%m/%d/%Y')>='".$array['from']."' AND DATE_FORMAT(qc.created_at,'%m/%d/%Y')<='".$array['to']."'";
		$where="AND DATE_FORMAT(created_at,'%m/%d/%Y')>='".$array['from']."' AND DATE_FORMAT(created_at,'%m/%d/%Y')<='".$array['to']."'";
		}
		
		$result['commentActivity']=$this->db->query('SELECT qc.comment,qc.`created_at`,q.question FROM rt_tb_question_comment as qc inner join rt_tb_question q on qc.`qusetion_id`=q.id where qc.`user_id`='.$array['user_id'].' '.$cwhere.' group by qc.id order by qc.`created_at` desc')->result_array();
		
		 
		$result['bidActivity']= $this->db->query('SELECT qcb.comment_id,qcb.amount,qcb.`created_at`,qc.comment,q.question FROM rt_tb_comment_bid as qcb inner join rt_tb_question_comment qc on qc.`id`=qcb.comment_id inner join rt_tb_question q on qc.`qusetion_id`=q.id where qcb.`user_id`='.$array['user_id'].' '.$bwhere.' group by qcb.id order by qc.`created_at` DESC')->result_array();
		
		$result['totalBiddedAmount']=$this->db->query('SELECT SUM(amount) as amount FROM `rt_tb_comment_bid` where user_id='.$array['user_id'].' '.$where)->row_array();
		$result['totalCommentedAmount']=$this->db->query('SELECT sum(amount) as amount FROM `rt_tb_transactions` WHERE `txn_type` ="debit" AND user_id='.$array['user_id'].' And user_type="talker" '.$where)->row_array();
		
		//$result['WinningAmount']=$this->db->query('SELECT sum(amount) as amount FROM `rt_tb_transactions` WHERE `txn_type` ="debit" AND user_id='.$array['user_id'].' And user_type="talker" '.$where)->row_array();
		
		
		return $result;
	}
	
	public function adminActivity($array)
	{
		if($array['from']!='' && $array['to'])
		$where="AND DATE_FORMAT(created_at,'%m/%d/%Y')>='".$array['from']."' AND DATE_FORMAT(created_at,'%m/%d/%Y')<='".$array['to']."'";
		$result['subscrptions'] = $this->db->query('SELECT count(*) as subCount from `rt_tb_subscription` WHERE `created_by` = '.$array['user_id'].' '.$where)->row_array();
		$result['questions']    = $this->db->query('SELECT count(*) as questionCount from `rt_tb_question` WHERE `user_id`   = '.$array['user_id'].' '.$where)->row_array();
		$result['categories'  ] = $this->db->query('SELECT count(*) as categoryCount from `rt_tb_category` WHERE `created_by`   = '.$array['user_id'].' '.$where)->row_array();
		$result['users']        = $this->db->query('SELECT count(*) as usersCount from `tr_tb_user` WHERE `created_by`   = '.$array['user_id'].' '.$where)->row_array();
		return $result;
	}
	
	public function getRevenue($array)
	{
		if($array['from']!='' && $array['to'])
		{
		$cwhere="AND DATE_FORMAT(created_by,'%m/%d/%Y')>='".$array['from']."' AND DATE_FORMAT(created_at,'%m/%d/%Y')<='".$array['to']."'";
		$bwhere="AND DATE_FORMAT(created_at,'%m/%d/%Y')>='".$array['from']."' AND DATE_FORMAT(created_at,'%m/%d/%Y')<='".$array['to']."'";
		$where="WHERE DATE_FORMAT(created_at,'%m/%d/%Y')>='".$array['from']."' AND DATE_FORMAT(created_at,'%m/%d/%Y')<='".$array['to']."'";
		}
	     $result['bidRevenue']=$this->db->query('select `bagitm60_rock`.`rt_tb_transactions`.`created_at`,sum((case when ((`bagitm60_rock`.`rt_tb_transactions`.`txn_type` = "debit") and (`bagitm60_rock`.`rt_tb_transactions`.`status` = "SUCCESS") and (`bagitm60_rock`.`rt_tb_transactions`.`user_type` = "rocker")) then `bagitm60_rock`.`rt_tb_transactions`.`amount` else 0 end)) AS `bid_revenue`,sum((case when ((`bagitm60_rock`.`rt_tb_transactions`.`txn_type` = "debit") and (`bagitm60_rock`.`rt_tb_transactions`.`status` = "SUCCESS") and (`bagitm60_rock`.`rt_tb_transactions`.`user_type` = "talker")) then `bagitm60_rock`.`rt_tb_transactions`.`amount` else 0 end)) AS `comment_revenue` from `bagitm60_rock`.`rt_tb_transactions` '.$where)->row_array();
		 $result['winnerRevenue']=$this->db->query('select `bagitm60_rock`.`rt_tb_comment_bid_winners`.`created_at`,sum((case when ((`bagitm60_rock`.`rt_tb_comment_bid_winners`.`winner_type` = "bid")) then `bagitm60_rock`.`rt_tb_comment_bid_winners`.`winning_amount` else 0 end)) AS `bid_winning_amount`,sum((case when ((`bagitm60_rock`.`rt_tb_comment_bid_winners`.`winner_type` = "comment")) then `bagitm60_rock`.`rt_tb_comment_bid_winners`.`winning_amount` else 0 end)) AS `comment_winning_amount` from `bagitm60_rock`.`rt_tb_comment_bid_winners` '.$where)->row_array();
		 
		 
		 
			return $result;
		
	}
	
	
	
	
	public function getTotlaBidAmountByComment($array = array())
	{	
	  $result = $this->db->query('SELECT SUM(amount) as highestBid from rt_tb_comment_bid where comment_id='.$array['comment_id'])->row_array();
	  $lastHighestBid = ($result['highestBid'])?$result['highestBid']:0;
	  //echo "<pre>"; print_r($lastHighestBid); exit;
	  return $lastHighestBid;
	}
	
	public function getBids($array= array())
	 {
		 
		// echo "<pre>"; print_r($array); exit;
			$this->db->select('l.* , c.id as commentid,c.comment, u.email_id as useremail, u.role_id');
			$this->db->from('rt_tb_comment_bid As l');
			$this->db->join('rt_tb_question_comment As c', 'c.id = l.comment_id', 'inner');
			$this->db->join('tr_tb_user As u', 'l.user_id = u.id', 'inner');
			if(isset($array['comment_id']) && !empty($array['comment_id']))
			$this->db->where('l.comment_id', $array['comment_id']);
			$this->db->order_by('l.amount', 'desc');
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			//echo "<pre>"; print_r($query->result_array()); exit;
			return $query->result_array();
			
	 }
	 
	 public function getBidsCount($array= array())
	 {
		 
		// echo "<pre>"; print_r($array); exit;
			$this->db->select('l.* , c.id as commentid,c.comment, u.email_id as useremail, u.role_id');
			$this->db->from('rt_tb_comment_bid As l');
			$this->db->join('rt_tb_question_comment As c', 'c.id = l.comment_id', 'inner');
			$this->db->join('tr_tb_user As u', 'l.user_id = u.id', 'inner');
			if(isset($array['comment_id']) && !empty($array['comment_id']))
			$this->db->where('l.comment_id', $array['comment_id']);
			$this->db->order_by('l.amount', 'desc');
			$query = $this->db->get();
			return $query->num_rows();
	 }
	 
	 public function get_transactions($array= array())
	 {
		 
		// echo "<pre>"; print_r($array); exit;
			$this->db->select('l.* , u.email_id as useremail, u.role_id');
			$this->db->from('rt_tb_transactions As l');
			$this->db->join('tr_tb_user As u', 'l.user_id = u.id', 'inner');
			$query = $this->db->get();
			return $query->result_array();
			
	 }
	 
	 public function getwithdraw($array= array())
	 {
			$this->db->select('l.* , u.email_id as useremail, u.role_id');
			$this->db->from('rt_tb_withdraw As l');
			$this->db->join('tr_tb_user As u', 'l.user_id = u.id', 'inner');
			if($condition['from']!='' && $condition['to'])
		{
			$this->db->where('l.created_at BETWEEN "'. date('Y-m-d', strtotime($condition['from'])). '" and "'. date('Y-m-d', strtotime($condition['to'])).'"');
		}
			if(isset($array['id']) && !empty($array['id']))
			$this->db->where('l.id', $array['id']);
			$query = $this->db->get();
			//echo '<pre>';print_r($query->result_array());exit;
			return $query->result_array();
			
	 }
		
	 public function createSubscription($post)
	{
		//echo "<pre>"; print_r($post); exit;
		$data = array('subscription_name' => $this->input->post('sub_name'),'subscription_price' => $this->input->post('sub_price'),'discount_type' => $this->input->post('discount_type'),'discount'=>$this->input->post('discount'),'time_period'=>$this->input->post('time_period'),'created_by' => $this->superadminID,'is_active' => 1,'is_delete' => 0); 
		$query=$this->db->insert('rt_tb_subscription', $data);
		if($query)
		{
		$subscription_id=$this->db->insert_id();
		$subscription_uid='SUB'.str_pad($subscription_id, 2, '0', STR_PAD_LEFT);
		$this->db->update('rt_tb_subscription',array('subscription_uid'=> $subscription_uid),array('id'=> $subscription_id));
		return $subscription_id;
		}
		else
			return false;

	}

	public function updateSubscription($post)
	{
		//$update_array = array('name'=>$post['cityname']);
		$cnd_arr = array('id' =>$post['id']);
		$this->db->update('rt_tb_subscription', $update_array, $cnd_arr);
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