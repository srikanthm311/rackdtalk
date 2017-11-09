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
			if(isset($post['city_title']) && !empty($post['city_title']))
				$cdn_arr['city_name'] = trim($post['city_title']);
			if(isset($post['country_id']) && !empty($post['country_id']))
				$cdn_arr['country_id'] = trim($post['country_id']);
			if(isset($post['state_id']) && !empty($post['state_id']))
				$cdn_arr['state_id'] = trim($post['state_id']);
			if(isset($post['identity']) && !empty($post['identity']))
				$cdn_arr['search_identity'] = $post['identity'];
		}
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		$this->data['questions'] = $this->Superadmin_model->getQuestions('rt_tb_question',$cdn_arr,$condition_array);
		//echo "<pre>"; print_r($this->data['questions']); exit;
		$this->data['questions_counts'] = $this->Superadmin_model->getQuestions_count('rt_tb_question',$cdn_arr,$condition_array);
		$this->data['recordsperpage'] =  $this->recordsperpage;
		$this->load->library('pagination');
		$config['base_url'] = base_url('adminquestions/questions');
		$config['total_rows'] = $this->data['questions_counts'];
		$config['per_page'] = $this->recordsperpage;	
		$this->pagination->initialize($config);	
		if(!isset($cdn_arr['search_identity']))
		$this->data['paginationLinks'] = $this->pagination->create_links();
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
			if($this->input->post('is_trending') != '')$post['trending'] = 1;else $post['trending'] = 0;
			if($this->input->post('qid')){
			if($post['qtype'] == 2){
				if($_FILES['question']['tmp_name']!=''){
					$imageFileType = pathinfo($_FILES['question']['name'],PATHINFO_EXTENSION);
					if(($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif")|| $_FILES["image"]["size"] > 26214400) 
					{
					 $this->session->set_flashdata('message', '<span style="color:red">Invalid File Extension/Size for Question Gif.</span>');
					 redirect(base_url('superadmin/post-your-question'));exit;
					}
					
					$hsourcePath = $_FILES['question']['tmp_name'];
					$htargetPath = "uploaded/question/".$this->userID.'-'.time().'.'.$imageFileType; 
					move_uploaded_file($hsourcePath,$htargetPath) ;
					$post['question']=$htargetPath;
					$data = array('category_id' => $post['segment'],'question' => $post['question'],'description' => $post['description'],'tags' => $post['tags'],'type' => $post['qtype'],'comments_closed_at' => date('Y-m-d H:i:s'),'bidding_closed_at'=>date('Y-m-d H:i:s'),'is_trending'=>$post['trending'],'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1,'is_approved' =>1,'bidding_closed_at'=>$post['bidding_closed_at'],'comments_closed_at'=>$post['comment_closed_at']);
						}
				else{
					$data = array('category_id' => $post['segment'],'description' => $post['description'],'tags' => $post['tags'],'type' => $post['qtype'],'comments_closed_at' => date('Y-m-d H:i:s'),'bidding_closed_at'=>date('Y-m-d H:i:s'),'is_trending'=>$post['trending'],'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1,'is_approved' =>1,'bidding_closed_at'=>$post['bidding_closed_at'],'comments_closed_at'=>$post['comment_closed_at']);
							}
					}
			else{
				if($post['user_role'] == 3){
				$data = array('is_trending'=>$post['trending'],'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1,'is_approved' =>1,'bidding_closed_at'=>$post['bidding_closed_at'],'comments_closed_at'=>$post['comment_closed_at']);
				//echo '<pre>';print_r($data);exit;
				}
				else{
				$data = array('category_id' => $post['segment'],'question' => $post['question'],'description' => $post['description'],'tags' => $post['tags'],'type' => $post['qtype'],'comments_closed_at' => date('Y-m-d H:i:s'),'bidding_closed_at'=>date('Y-m-d H:i:s'),'is_trending'=>$post['trending'],'updated_at' => date('Y-m-d H:i:s'),'is_active' =>1,'is_approved' =>1,'bidding_closed_at'=>$post['bidding_closed_at'],'comments_closed_at'=>$post['comment_closed_at']);
				}
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
			if($_FILES['question']['tmp_name']!='')
			{
				$imageFileType = pathinfo($_FILES['question']['name'],PATHINFO_EXTENSION);
				if(($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif")|| $_FILES["image"]["size"] > 26214400) 
				{
					
				 $this->session->set_flashdata('message', '<span style="color:red">Invalid File Extension/Size for Question Gif.</span>');
				 redirect(base_url('superadmin/post-your-question'));exit;
				}
				
				$hsourcePath = $_FILES['question']['tmp_name'];
				$htargetPath = "uploaded/question/".$this->userID.'-'.time().'.'.$imageFileType; 
				move_uploaded_file($hsourcePath,$htargetPath) ;
			    $post['question']=$htargetPath;
			}
			$this->Superadmin_model->updateQuestion($post);
			$this->session->set_flashdata('message', '<span style="color:green">Question Submited Successfully.</span>');
			redirect(base_url('superadmin/post-your-question'));exit;
		}
		}
		if(!empty($question_id)){

			$cdn_arr['id'] = $question_id;
			$this->data['question_detials'] = array_shift($this->Superadmin_model->getQuestions('rt_tb_question',$cdn_arr,''));
			$this->data['AllCommentsList'] = $this->Superadmin_model->getCommentsByQuestion($question_id);
			
			if($this->data['question_detials']['bidding_closed_at'] < date('Y-m-d H:i:s')){
			$this->data['CommentsList']=array_shift($this->Superadmin_model->getCommentsByQuestion($question_id));
			$cnd_arry['comment_id'] = $this->data['CommentsList']['id'];
			$this->data['bids'] = $this->Superadmin_model->getBids($cnd_arry);
			if($cnd_arry['comment_id'] != ''){
			$bid_winners = $this->Common_model->get_table('rt_tb_comment_bid_winners',$cnd_arry);
			foreach($bid_winners as $bid_win)
			{
				$this->data['bid_winners'][$bid_win['user_id']] = $bid_win;
				}
			$this->data['totalBidAmt'] = $this->Superadmin_model->getTotlaBidAmountByComment($cnd_arry['comment_id']);
			}
		}
		}

		else if($this->input->post())

			$this->data['question_detials'] = $this->input->post();

		else

		$this->data['question_detials'] = array();
		
		$this->data['categoryList']=$this->Common_model->get_table('rt_tb_category',array('is_active' => 1,'is_delete' => 0),array('category_name','id'));
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/post-your-question',$this->data);
		$this->load->view($this->folder.'/footer');
		
	}
	public function deleteQuestion($id = '')

	{

		$this->is_logged_in();

		if(!empty($id))

			 $this->Common_model->update_table('rt_tb_question',array('is_delete' => 1),array('id' => $id));

		redirect('adminquestions/questions');

		exit;

	}
	
	//home end
}
