<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question_model extends CI_Model {
	 public $tablename;
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->tablename='rt_vw_question';
		}
		
		
		public function HomePage($cnd_arr)
		{
		   $result= array();
		   $result['trending'] = $this->getAllQuestions(array('is_approved' =>1,'is_trending' =>1,'recordsperpage'=>4,'limit'=>0));
		   $result['latest'] = $this->getAllQuestions(array('is_approved' =>1,'orderby' =>'id','ordertype' =>'DESC','recordsperpage'=>4,'limit'=>0));
		   $result['topbidding']=$this->getTopBiddingQuestions($cnd_arr);
		   return $result;
		}
		
		public function getTopBiddingQuestionsCount($cnd_arr)
		{
		  return $this->db->query('SELECT distinct q.*,SUM(qcb.amount) as bidamountTotal,qu.first_name,qu.pic as user_pic from rt_vw_question as q inner join rt_tb_question_comment as qc ON qc.qusetion_id=q.id inner join rt_tb_comment_bid as qcb ON qc.id=qcb.comment_id inner join tr_tb_user as qu ON qu.id=qc.user_id where q.is_active=1 AND q.is_closed=0 AND q.is_delete=0 AND q.is_approved=1 AND qc.is_approved=1 AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 AND DATE(q.`bidding_closed_at`) >= DATE(NOW()) group by q.id,q.user_id order by SUM(qcb.amount) Desc')->num_rows();
		}
		
		
		public function getTopBiddingQuestions($cnd_arr)
		{
		  return $this->db->query('SELECT distinct q.*,SUM(qcb.amount) as bidamountTotal,qu.first_name,qu.pic as user_pic from rt_vw_question as q inner join rt_tb_question_comment as qc ON qc.qusetion_id=q.id inner join rt_tb_comment_bid as qcb ON qc.id=qcb.comment_id inner join tr_tb_user as qu ON qu.id=qc.user_id where q.is_active=1  AND q.is_closed=0 AND q.is_delete=0 AND q.is_approved=1 AND qc.is_approved=1 AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 AND DATE(q.`bidding_closed_at`) >= DATE(NOW()) group by q.id,q.user_id order by SUM(qcb.amount) Desc limit '.$cnd_arr['limit'].','.$cnd_arr['recordsperpage'].'')->result_array();
		}
		
		public function getQuestionsByMyCommentsCount($cnd_arr)
		{
		  return $this->db->query('SELECT distinct q.*,qc.user_id as commentby,SUM(qcb.amount) as bidamountTotal,qu.first_name from rt_vw_question as q inner join rt_tb_question_comment as qc ON qc.qusetion_id=q.id left join rt_tb_comment_bid as qcb ON qc.id=qcb.comment_id inner join tr_tb_user as qu ON qu.id=qc.user_id where q.is_active=1  AND q.is_closed=0 AND q.is_delete=0 AND q.is_approved=1 AND qc.user_id='.$cnd_arr['user_id'].' AND qc.is_approved=1 AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 group by q.id order by SUM(qcb.amount) Desc')->num_rows();
		}
		
		
		public function getQuestionsByMyComments($cnd_arr)
		{
		 
		  return $this->db->query('SELECT distinct q.*,qc.user_id as commentby,SUM(qcb.amount) as bidamountTotal,qu.first_name from rt_vw_question as q inner join rt_tb_question_comment as qc ON qc.qusetion_id=q.id left join rt_tb_comment_bid as qcb ON qc.id=qcb.comment_id inner join tr_tb_user as qu ON qu.id=qc.user_id where q.is_active=1  AND q.is_closed=0 AND q.is_delete=0 AND q.is_approved=1 AND qc.user_id='.$cnd_arr['user_id'].' AND qc.is_approved=1 AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 group by q.id order by SUM(qcb.amount) Desc limit '.$cnd_arr['limit'].','.$cnd_arr['recordsperpage'].'')->result_array();
		}
		
		
		public function getQuestionsByMyBidCount($cnd_arr)
		{
		  return $this->db->query('SELECT distinct q.*,SUM(qcb.amount) as bidamountTotal,qu.first_name as bidder_first_name,qu.pic as user_pic from rt_vw_question as q inner join rt_tb_question_comment as qc ON qc.qusetion_id=q.id inner join rt_tb_comment_bid as qcb ON qc.id=qcb.comment_id inner join tr_tb_user as qu ON qu.id=qcb.user_id where q.is_active=1  AND q.is_delete=0 AND q.is_approved=1 AND qc.is_approved=1 AND qcb.user_id='.$cnd_arr['user_id'].' AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 group by q.id order by SUM(qcb.amount) Desc')->num_rows();
		}
		public function getQuestionsByMyBid($cnd_arr)
		{
		  return $this->db->query('SELECT distinct q.*,SUM(qcb.amount) as bidamountTotal,qu.first_name as bidder_first_name,qu.pic as user_pic from rt_vw_question as q inner join rt_tb_question_comment as qc ON qc.qusetion_id=q.id inner join rt_tb_comment_bid as qcb ON qc.id=qcb.comment_id inner join tr_tb_user as qu ON qu.id=qcb.user_id where q.is_active=1   AND q.is_delete=0 AND q.is_approved=1 AND qc.is_approved=1 AND qcb.user_id='.$cnd_arr['user_id'].' AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 group by q.id order by SUM(qcb.amount) Desc')->result_array();
		}
		   
	   	public function getAllQuestionsCount($array = array())
	   {
		$cond_array = array('l.is_delete' => 0,'l.is_closed'=> 0);
		$this->db->select('l.*,qu.first_name,qu.pic as user_pic');
		$this->db->from($this->tablename.' AS l');
		$this->db->join('tr_tb_user as qu', 'qu.id = l.user_id', 'inner');
	   	$this->db->where($cond_array);
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['category_id']) && !empty($array['category_id']))
		$this->db->where('l.category_id', $array['category_id']);
		if(isset($array['user_id']) && !empty($array['user_id']))
		$this->db->where('l.user_id', $array['user_id']);
		if(isset($array['question']) && !empty($array['question']))
		$this->db->like('l.question', $array['question']);
		if(isset($array['is_approved']) && !empty($array['is_approved']))
		$this->db->where('l.is_approved', $array['is_approved']);
		if(isset($array['is_trending']) && !empty($array['is_trending']))
		$this->db->where('l.is_trending', $array['is_trending']);
		if(isset($array['bidding_closed_at']) && !empty($array['bidding_closed_at']))
		$this->db->where('l.bidding_closed_at', $array['bidding_closed_at']);
		if(isset($array['is_active']) && !empty($array['is_active']))
		$this->db->where('l.is_active', $array['is_active']);
		$this->db->where("DATE(`bidding_closed_at`) >= DATE(NOW())", NULL, FALSE);
		$query = $this->db->get();	
		return $query->num_rows();
	}	
	public function getAllQuestions($array = array())
	{
		$cond_array = array('l.is_delete' => 0,'l.is_closed'=> 0);
		$this->db->select('l.*,qu.first_name,qu.pic as user_pic');
		$this->db->from($this->tablename.' AS l');
		$this->db->join('tr_tb_user as qu', 'qu.id = l.user_id', 'inner');
	   	$this->db->where($cond_array);
		if(isset($array['id']) && !empty($array['id']))
		$this->db->where('l.id', $array['id']);
		if(isset($array['category_id']) && !empty($array['category_id']))
		$this->db->where('l.category_id', $array['category_id']);
		if(isset($array['user_id']) && !empty($array['user_id']))
		$this->db->where('l.user_id', $array['user_id']);
		if(isset($array['question']) && !empty($array['question']))
		$this->db->like('l.question', $array['question']);
		if(isset($array['is_approved']) && !empty($array['is_approved']))
		$this->db->where('l.is_approved', $array['is_approved']);
		if(isset($array['is_trending']) && !empty($array['is_trending']))
		$this->db->where('l.is_trending', $array['is_trending']);
		if(isset($array['bidding_closed_at']) && !empty($array['bidding_closed_at']))
		$this->db->where('l.bidding_closed_at', $array['bidding_closed_at']);
		if(isset($array['is_active']) && !empty($array['is_active']))
		$this->db->where('l.is_active', $array['is_active']);
		$this->db->where("DATE(`bidding_closed_at`) >= DATE(NOW())", NULL, FALSE);
		if(isset($array['orderby']) && isset($array['ordertype']))
		$this->db->order_by($array['orderby'], $array['ordertype']);
		if(isset($array['recordsperpage']) && isset($array['limit']))
		$this->db->limit($array['recordsperpage'], $array['limit']);
		
		$query = $this->db->get(); //echo $this->db->last_query();exit;//echo '<pre>';print_r($query->result_array());exit;		
		
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
	
	public function getCommentsByQuestion($id,$user='')
	{
		 
		 if($user!='') $where=' AND user_id='.$user;
		/* return $this->db->query('SELECT distinct qc.*,MAX(qcb.amount) as bidamountTotal,qu.first_name,qu.pic as user_pic,count(qcld.id) as comment_likes_count from rt_tb_question_comment as qc left join rt_tb_comment_bid as qcb ON qc.id=qcb.comment_id inner join tr_tb_user as qu ON qu.id=qc.user_id left join rt_tb_comments_likes_dislikes qcld ON qcld.comment_id=qc.id where qc.qusetion_id='.$id.' AND qc.is_approved=1 '.$where.' AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 group by qc.id,qc.user_id order by MAX(qcb.amount) Desc')->result_array();*/
		 
		  return $this->db->query('SELECT * from rt_vw_comment where question_id='.$id.' AND is_active=1 AND is_delete=0 '.$where.' AND comment_is_closed=0 order by highestBidAmount Desc')->result_array();
		 
		 
		 
		 
		
	}
	public function getCommentsBySingleQuestion($id,$user='')
	{
		
		 if($user!='') $where=' AND qc.user_id='.$user;
		 $query = $this->db->query('SELECT distinct qc.*,q.question,q.description,q.type,q.bidding_closed_at,q.approved_at,q.question_comment_count,q.user_pic,MAX(qcb.amount) as bidamountTotal,qu.first_name,qu.pic as upic,count(qcld.id) as comment_likes_count from rt_tb_question_comment as qc inner join rt_vw_question as q ON q.id=qc.qusetion_id left join rt_tb_comment_bid as qcb ON qc.id=qcb.comment_id inner join tr_tb_user as qu ON qu.id=qc.user_id left join rt_tb_comments_likes_dislikes qcld ON qcld.comment_id=qc.id where qc.qusetion_id='.$id.' AND qc.is_approved=1 '.$where.' AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 group by qc.id,qc.user_id order by MAX(qcb.amount) Desc');
		 
		if($query->num_rows() > 0)
		{
			$return_Comments = array();
			$Comments = $query->result_array();
			foreach($Comments as $Comment)
			{
				$return_Comments['comments'][$Comment['qusetion_id']][$Comment['id']] = $Comment;
				$return_Comments['data'][$Comment['qusetion_id']]['question'] = $Comment['question'];
				$return_Comments['data'][$Comment['qusetion_id']]['description'] = $Comment['description'];
				$return_Comments['data'][$Comment['qusetion_id']]['type'] = $Comment['type'];
				$return_Comments['data'][$Comment['qusetion_id']]['bidamountTotal'] = $Comment['bidamountTotal'];
				$return_Comments['data'][$Comment['qusetion_id']]['approved_at'] = $Comment['approved_at'];
				$return_Comments['data'][$Comment['qusetion_id']]['bidding_closed_at'] = $Comment['bidding_closed_at'];
				$return_Comments['data'][$Comment['qusetion_id']]['question_comment_count'] = $Comment['question_comment_count'];
				$return_Comments['data'][$Comment['qusetion_id']]['user_pic'] = $Comment['upic'];
				
			}
			return $return_Comments;
		}
		else
			return false;
		 
		 
		
	}		
		
		
		
	public function isCommentsAllowed($id)
	{
		 $result = $this->db->query('SELECT id,user_id from rt_tb_question WHERE id ='.$id.' AND is_approved=1 AND is_active=1 AND is_delete=0 AND DATE(`comments_closed_at`) >= DATE(NOW()) ')->row_array();
		 return $result;
	}
	
	public function isBiddingAllowed($cid)
	{
		 $result = $this->db->query('SELECT qc.id from rt_tb_question_comment as qc inner join rt_tb_question as q ON qc.id=q.question WHERE qc.id ='.$cid.' AND qc.is_approved=1 AND qc.is_active=1 AND qc.is_delete=0 AND qc.is_closed=0 AND DATE(q.`bidding_closed_at`) >= DATE(NOW()) ')->row_array();
		 return $result;
	}
		
	public function getHighestBidAmountByComment($cid)
	{	
	  $result = $this->db->query('SELECT SUM(amount) as highestBid,user_id from rt_tb_comment_bid where comment_id='.$cid.' group by user_id order by SUM(amount) Desc Limit 1')->row_array();
	  $lastHighestBid = ($result['highestBid'])?$result['highestBid']:0;
	  return $lastHighestBid;
	}
	
    public function updateQuestion($post)
	{

		
	/*	 $result = $this->db->query('SELECT `key`,`value` from settings')->result_array();
		 
		 foreach($result as $res)
		 {
			$settings[$res['key']]=$res['value']; 
		 }
		 
		 $QuestionCommentExpiryTime=date('Y-m-d H:i:s', strtotime("+".$settings['QuestionCommentExpiryTime']." days"));
		 $QuestionCommentBiddingExpiryTime=date('Y-m-d H:i:s', strtotime("+".$settings['QuestionCommentBiddingExpiryTime']." days"));
		 */
		 $data = array('user_id' => $post['user_id'],'category_id' => $post['segment'],'question' => $post['question'],'description' => $post['description'],'tags' => $post['tags'],'type' => $post['qtype']/*,'comments_closed_at' => $QuestionCommentExpiryTime,'bidding_closed_at'=>$QuestionCommentBiddingExpiryTime*/,'is_trending'=>0,'is_approved' => 0,'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1); 
		 
		// echo '<pre>';print_r($data);exit;
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
	
}



?>