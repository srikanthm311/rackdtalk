<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(0);
require_once(APPPATH.'controllers/Admin.php');
class Adminquestions extends Admin {
    public $folder = 'admin';
	public $data = array();
	private $recordsperpage;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Superadmin_model');
	}
    public function index($currentPage = 0)
	{
		
		
		$settings  = $this->Common_model->get_table('settings');
        foreach($settings as $settingKey=> $val)
        $this->data['settings'][$val['key']]=$val['value'];			
		
		$this->is_logged_in();
		if($this->input->post())
		{
			$post = $this->input->post();
			//echo "<pre>"; print_r($post); exit;
			if(isset($post['city_title']) && !empty($post['city_title']))
				$cdn_arr['city_name'] = trim($post['city_title']);
			if(isset($post['country_id']) && !empty($post['country_id']))
				$cdn_arr['country_id'] = trim($post['country_id']);
			if(isset($post['state_id']) && !empty($post['state_id']))
				$cdn_arr['state_id'] = trim($post['state_id']);
			if(isset($post['identity']) && !empty($post['identity']))
				$cdn_arr['search_identity'] = $post['identity'];
			if(isset($post['from']) && !empty($post['from']))
				$cdn_arr['from'] = $post['from'];
			if(isset($post['to']) && !empty($post['to']))
				$cdn_arr['to'] = $post['to'];
		}
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		$this->data['questions'] = $this->Superadmin_model->getQuestions('rt_tb_question',$cdn_arr,$condition_array);
		//echo "<pre>"; print_r($this->data['questions']); exit;
		$this->data['questions_counts'] = $this->Superadmin_model->getQuestions_count('rt_tb_question',$cdn_arr,$condition_array);
		$this->data['recordsperpage'] =  $this->recordsperpage;
		$this->load->library('pagination');
		$config['base_url'] = base_url('adminquestions');
		$config['total_rows'] = $this->data['questions_counts'];
		$config['per_page'] = $this->recordsperpage;	
		$this->pagination->initialize($config);	
		if(!isset($cdn_arr['search_identity']))
		$this->data['paginationLinks'] = $this->pagination->create_links();
		$this->data['post']=$post;
		//echo "<pre>"; print_r($this->data['questions']); exit;
        $this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/question_list',$this->data);
		$this->load->view($this->folder.'/footer');
	}

	public function post_your_question($question_id = '')
	{
		$this->is_logged_in();
		if($this->input->post())
		{
			//echo '<pre>';print_r($this->input->post());exit;
			$post=$this->input->post();
			//image upload start 
			if($_FILES['question']['tmp_name']!=''){
					$imageFileType = pathinfo($_FILES['question']['name'],PATHINFO_EXTENSION);
					if(($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif")|| $_FILES["image"]["size"] > 26214400) 
					{
					 $this->session->set_flashdata('message', '<span style="color:red">Invalid File Extension/Size for Question Gif.</span>');
					 redirect(base_url('adminquestions/post-your-question'));exit;
					}
					$hsourcePath = $_FILES['question']['tmp_name'];
					$htargetPath = "uploaded/question/".$this->userID.'-'.time().'.'.$imageFileType; 
					move_uploaded_file($hsourcePath,$htargetPath) ;
					$post['question']=$htargetPath;
				if($_FILES['question_hi']['tmp_name']!=''){
					$imageFileType = pathinfo($_FILES['question']['name'],PATHINFO_EXTENSION);
					if(($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif")|| $_FILES["image"]["size"] > 26214400) 
					{
					 $this->session->set_flashdata('message', '<span style="color:red">Invalid File Extension/Size for Question Gif.</span>');
					 redirect(base_url('adminquestions/post-your-question'));exit;
					}
					$hsourcePath = $_FILES['question']['tmp_name'];
					$htargetPath = "uploaded/question/".$this->userID.'hindi-'.time().'.'.$imageFileType; 
					move_uploaded_file($hsourcePath,$htargetPath) ;
					$post['question_hi']=$htargetPath;
				}
			}
						//image upload ending
						//echo '<pre>';print_r($post);
			if($this->input->post('is_trending') != '')$post['trending'] = 1;else $post['trending'] = 0;
			if($this->input->post('is_closed') != '')$post['is_closed'] = 1;else $post['is_closed'] = 0;
			if($this->input->post('qid')){
			if($post['qtype'] != 2){
				$data = array('category_id' => $post['segment'],'question' => $post['question'],'description' => $post['description'],'tags' => $post['tags'],'type' => $post['qtype'],'comments_closed_at' => date('Y-m-d H:i:s'),'bidding_closed_at'=>date('Y-m-d H:i:s'),'is_trending'=>$post['trending'],'is_closed'=>$post['is_closed'],'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1,'is_approved' =>1,'bidding_closed_at'=>$post['bidding_closed_at'],'comments_closed_at'=>$post['comment_closed_at']);
			}
		elseif($post['question'] != ''){
				$data = array('category_id' => $post['segment'],'question' => $post['question'],'description' => $post['description'],'tags' => $post['tags'],'type' => $post['qtype'],'comments_closed_at' => date('Y-m-d H:i:s'),'bidding_closed_at'=>date('Y-m-d H:i:s'),'is_trending'=>$post['trending'],'is_closed'=>$post['is_closed'],'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1,'is_approved' =>1,'bidding_closed_at'=>$post['bidding_closed_at'],'comments_closed_at'=>$post['comment_closed_at']);
				}
		else{
			$data = array('category_id' => $post['segment'],'description' => $post['description'],'tags' => $post['tags'],'type' => $post['qtype'],'comments_closed_at' => date('Y-m-d H:i:s'),'bidding_closed_at'=>date('Y-m-d H:i:s'),'is_trending'=>$post['trending'],'is_closed'=>$post['is_closed'],'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1,'is_approved' =>1,'bidding_closed_at'=>$post['bidding_closed_at'],'comments_closed_at'=>$post['comment_closed_at']);
			}
			if($post['user_role'] == 3){
				$data = array('is_trending'=>$post['trending'],'is_closed'=>$post['is_closed'],'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1,'is_approved' =>1,'bidding_closed_at'=>$post['bidding_closed_at'],'comments_closed_at'=>$post['comment_closed_at']);
			}
				//echo '<pre>';print_r($data);exit;
				$this->Common_model->update_table('rt_tb_question',$data,array('id' => $post['qid']));
				$this->Common_model->insert_table('rt_tb_notifications',array('message'=> 'The Question "'.$post['question'].'" is Updated'));
				if($post['trending'])
				{
				$this->Common_model->insert_table('rt_tb_notifications',array('message'=> 'The Question "'.$post['question'].'" is Turned to Trending Question'));	
				}
				$this->session->set_flashdata('message', '<span style="color:green">Question Submited Successfully.</span>');
			}
		else{
			$post['admin'] = $this->adminID;
			$this->Superadmin_model->updateQuestion($post);
			$this->session->set_flashdata('message', '<span style="color:green">Question Submited Successfully.</span>');
			redirect(base_url('adminquestions/post-your-question'));exit;
		}
		}
		if(!empty($question_id)){

			$cdn_arr['id'] = $question_id;
			$this->data['question_detials'] = array_shift($this->Superadmin_model->getQuestions('rt_tb_question',$cdn_arr,''));
			$this->data['AllCommentsList'] = $this->Superadmin_model->getCommentsByQuestion($question_id);
			
			if($this->data['question_detials']['bidding_closed_at'] < date('Y-m-d H:i:s')){
			$this->data['CommentsList'] = $this->Superadmin_model->getCommentsByQuestion($question_id);
			$this->data['Comments_count'] = $this->Superadmin_model->getCommentsByQuestionCounts($question_id);
			$comment_winners = $this->Common_model->get_table('rt_tb_comment_bid_winners',array('question_id'=>$question_id,'winner_type'=>'comment'));
			if($comment_winners != ''){
			foreach($comment_winners as $comment_win)
				{
				$this->data['comment_winners'][$comment_win['comment_id']] = $comment_win;
				}}
			
		}
		}

		else if($this->input->post())

			$this->data['question_detials'] = $this->input->post();

		else

		$this->data['question_detials'] = array();
		//echo '<pre>';print_r($this->data);exit;
		$this->data['categoryList']=$this->Common_model->get_table('rt_tb_category',array('is_active' => 1,'is_delete' => 0),array('category_name','id'));
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/post-your-question',$this->data);
		$this->load->view($this->folder.'/footer');
		
	}
	
	public function questionDetails($id = '')
	{
		if($this->isAjaxRequest())

		{
		$qid = $this->input->post('ID');
		$this->data['question_detials'] = $this->Common_model->get_table_row('rt_vw_question',array('id' => $qid));
		//echo '<pre>';print_r($this->data['question_detials']);exit;
		$details = $this->load->view('admin/_questionDetails', $this->data, TRUE);
		echo $details; exit;
		}
	}
	public function deleteQuestion($id = '')

	{

		$this->is_logged_in();

		if(!empty($id))

			 $this->Common_model->update_table('rt_tb_question',array('is_delete' => 1),array('id' => $id));

		redirect('adminquestions');

		exit;

	}
	
	function activate_flag()
	{
			$this->load->helper('form');
			if($this->input->post())
			{
				$post = $this->input->post();
				if( isset($post['ID']) && !empty($post['ID']) )
				{
		            $this->Common_model->update_table('rt_tb_question_comment',array('is_flag' => 0),array('id' => $post['ID']));
					echo 1;
				}
				else
					echo false;
			}
			else
			{
				echo false;
			}
		

	}
	
	function getCommentDetails()
	{
			$this->load->helper('form');
			if($this->input->post())
			{
				$post = $this->input->post();
				if( isset($post['ID']) && !empty($post['ID']) )
				{
		           $this->data['bids'] = $this->Superadmin_model->getBids($post);
					$details = $this->load->view($this->folder.'/_commentDetails', $this->data, TRUE);
					echo $details; exit;
				}
				else
					echo "<p> No details found. </p>"; exit;
			}
			else
			{
				echo "<p> No details found. </p>"; exit;
			}
	}
	
	function getbids()
	{
			$this->load->helper('form');
			if($this->input->post())
			{
				
				$post = $this->input->post();
				$cdn_arr['id'] = $post['question_id'];
				//echo "<pre>"; print_r($post); exit;
				if( isset($post['comment_id']) && !empty($post['comment_id']) )
				{
		           $this->data['bids'] = $this->Superadmin_model->getBids($post);
				   $this->data['bids_count'] = $this->Superadmin_model->getBidsCount($post);
					$bid_winners = $this->Common_model->get_table('rt_tb_comment_bid_winners',array('comment_id'=>$post['comment_id'],'winner_type'=>'bid'));
					$this->data['question_detials'] = array_shift($this->Superadmin_model->getQuestions('rt_tb_question',$cdn_arr,''));
					
					if($bid_winners != ''){
					foreach($bid_winners as $bid_win)
						{
						$this->data['bid_winners'][$bid_win['user_id']] = $bid_win;
						}}
					$this->data['totalBidAmt'] = $this->Superadmin_model->getTotlaBidAmountByComment($post['comment_id']);
					$this->data['comment_id'] = $post['comment_id'];
					$this->data['question_id'] = $post['question_id'];
					//echo "<pre>"; print_r($this->data); exit;
					$details = $this->load->view($this->folder.'/_bidsForHighestComment', $this->data, TRUE);
					echo $details; exit;
				}
				else
					echo "<p> No details found. </p>"; exit;
			}
			else
			{
				echo "<p> No details found. </p>"; exit;
			}
	}
	
	public function bidding_update()
	{
		$this->is_logged_in();
		
		$post = $this->input->post();
		//echo "<pre>"; print_r($post); exit;
		$total_bid_amt = 0;
		foreach($post['user_id'] as $key => $biding){
			if($biding['position'] != ''){
			$total_bid_amt = $total_bid_amt + $biding['wng_amt']; // total prize by super admin
		}}
		$totalBidAmt_db = $this->Superadmin_model->getTotlaBidAmountByComment($post['comment_id']);
		if($total_bid_amt <= $totalBidAmt_db){
		foreach($post['user_id'] as $key => $biding){
			if($biding['position'] != ''){
			$data = array('user_id' => $biding['user_id'], 'comment_id'=>$post['comment_id'],'winning_position'=>$biding['position'],'winning_amount'=>$biding['wng_amt'],'winner_type'=>'bid','created_at'=>date('Y-m-d H:i:s'));		
			$biding['txn_uid'] = rand(1,9999999999999);
			$data_transaction = array('user_id' => $biding['user_id'], 'comment'=>$post['comment_id'],'user_type'=>'rocker','txn_uid' =>$biding['txn_uid'],'amount'=>$biding['wng_amt'],'type'=>'win','txn_type'=>'credit','is_refunded'=>'NO','status'=>'SUCCESS','created_at'=>date('Y-m-d H:i:s'));
			//echo "<pre>"; print_r($data_transaction); 
			//echo "<pre>"; print_r($data);
			$this->Common_model->update_table('rt_tb_question',array('is_closed' => 1),array('id' => $post['qid']));
			$this->Common_model->insert_table('rt_tb_comment_bid_winners',$data); 
			$this->Common_model->insert_table('rt_tb_transactions',$data_transaction);
			
			$this->session->set_flashdata('message_bid', '<span style="color:green">Bidding submitted successfully...<span>');
			}
		}
			}
		else{
				$this->session->set_flashdata('message_bid', '<span style="color:green">Total Prize Amount Should Not Be More Then Total Bidding Amount.<span>');
			}	
		redirect('adminquestions/post_your_question/'.$post['qid']);
			
	}
	
	
	function questionApprove()
	{
			$this->load->helper('form');
			if($this->input->post())
			{
				$post = $this->input->post();
				if( isset($post['ID']) && !empty($post['ID']) )
				{
		            $this->Common_model->update_table('rt_tb_question',array('is_approved' => 1,'approved_at' => date('Y-m-d H:i:s'),'comments_closed_at'=>$post['comment_closed_at'],'bidding_closed_at'=>$post['bidding_closed_at']),array('id' => $post['ID']));
					echo 1;
				}
				else
					echo false;
			}
			else
			{
				echo false;
			}
	}
	
public function announce_prize($id = '')

	{
		if($this->input->post())
			{
				//echo "<pre>"; print_r($this->input->post()); exit;
				$post = $this->input->post();
				
				foreach($post['commentPrize'] as $comment_id => $value){
					$query = 'select user_id from rt_tb_question_comment where 	id='.$comment_id;
					$result = array_shift($this->Common_model->query_array($query));
					//echo "<pre>"; print_r($result); exit;
				$data = array('user_id' => $value['user_id'], 'comment_id'=>$comment_id,'winning_position'=>$value['posiotion'], 'question_id'=>$post['question_id'],'winning_amount'=>$value['amt'],'winner_type'=>'comment','created_at'=>date('Y-m-d H:i:s'));
				$value['txn_uid'] = rand(1,9999999999999);
				$data_transaction = array('user_id' => $value['user_id'], 'comment'=>$comment_id,'user_type'=>'talker','txn_uid' =>$value['txn_uid'],'amount'=>$value['amt'],'type'=>'win','txn_type'=>'credit','is_refunded'=>'NO','status'=>'SUCCESS','created_at'=>date('Y-m-d H:i:s'));
				//echo "<pre>"; print_r($data); exit;
				$this->Common_model->insert_table('rt_tb_comment_bid_winners',$data);
				$this->Common_model->insert_table('rt_tb_transactions',$data_transaction);
				}
				$this->session->set_flashdata('message_bid', '<span style="color:green">Comment Prizes Announced successfully...<span>');
				redirect('adminquestions/post_your_question/'.$post['question_id']);
				}
	}
	
	public function deleteComment($id = '',$qid = '')

	{

		$this->is_logged_in();

		if(!empty($id))

			 $this->Common_model->update_table('rt_tb_question_comment',array('is_delete' => 1),array('id' => $id));

		redirect('adminquestions/post_your_question/'.$qid);

		exit;

	}
	//home end
}
