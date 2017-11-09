<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(0);
class Superadmin extends CI_Controller {
    public $folder = 'superAdmin';
	public $superadminID;
	public $data = array();
	private $recordsperpage;
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->model('Superadmin_model');
		$this->load->model('Common_model');
		$this->load->model('Question_model');
		$this->load->model('Admin_model');
		$this->load->model('Users_model');
		$this->recordsperpage = 20;
		$this->data['countries']=$this->Common_model->get_table('rt_tb_countries','','*','','','','');
		//$this->data['states']=$this->Common_model->get_table('rt_tb_states','','*','','','','');
		//$this->data['cities']=$this->Common_model->get_table('rt_tb_cities','','*','','','','');
		//echo '<pre>';print_r($this->input->post());exit;
		if($this->session->userdata('superadminID'))
		{
			$this->superadminID=$this->session->userdata('superadminID');
			//$this->data['notify']=$this->getNotifications(6);
			
		}
	}
	
	public function getNotifications($limit)
	{
		//$this->is_logged_in();
		$notifications=$this->Common_model->get_table('fhpl_notifications','','','notifyID','desc',$limit,0);
		$newdata=array();
		foreach($notifications as $notification)
		{
			switch($notification['category'])
			{
			 case 'News'	     : $subjectData  = $this->Common_model->get_table_row('fhpl_news',array('newsID' =>$notification['subjectID']),array('newsTitle as title'));break;
			 
			 case 'Health Camp'	 :$subjectData  = $this->Common_model->get_table_row('fhpl_health_camps',array('campID' =>$notification['subjectID']),array('uniqueCampID as title') );break;
			 
			 case 'News category':$subjectData  = $this->Common_model->get_table_row('fhpl_news_categories',array('ID' =>$notification['subjectID']),array('categoryName as title') );break;
			  case 'News Letters':$subjectData  = $this->Common_model->get_table_row('fhpl_news_letters',array('newsID' =>$notification['subjectID']),array('title') );break;
			 
			 case 'Health Tips'	: $subjectData  = $this->Common_model->get_table_row('fhpl_health_tips',array('campID' =>$notification['subjectID']),array('title') );break;
			 case 'News Letter'	: $subjectData  = $this->Common_model->get_table_row('fhpl_news_letters',array('newsID' =>$notification['subjectID']),array('title') );break;
			 case 'Events'	    : $subjectData  = $this->Common_model->get_table_row('fhpl_events',array('ID' =>$notification['subjectID']),array('title') );break;
			 case 'Testimonial' : $subjectData  = $this->Common_model->get_table_row('fhpl_testimonials',array('testID' =>$notification['subjectID']),array('company as title') );break;
			 case 'Clinics' : $subjectData  = $this->Common_model->get_table_row('fhpl_clinics',array('clinicID' =>$notification['subjectID']),array('name as title') );break;
			 case 'Dignostic centres' : $subjectData  = $this->Common_model->get_table_row('fhpl_diagncentres',array('dcID' =>$notification['subjectID']),array('location as title') );break;

			 default            :  $subjectData  = array();
			}
			$newdata[$notification['category']][]= '"'.$subjectData['title'].'" '.$notification['content'].' on '.$notification['createdDate'];
		}
		//echo '<pre>';print_r($newdata);exit;
		return $newdata;
	}
	
	
    public function index()
	{
		if($this->input->post())
		{
			//echo '<pre>';print_r($this->input->post());exit;
			$user = $this->Superadmin_model->authenticate_user($this->input->post());
			if(count($user)>0)
			{
				//echo '<pre>';print_r($user);exit;
				$array = array(
							'superadminID' => $user['id'],
							'superadminemail' => $user['email_id'],
							'superadminname' => $user['first_name'].' '.$user['last_name'],
							'loggedIN' => 'SUPERADMIN',
							);
				$this->session->set_userdata($array);
				redirect(base_url('superadmin/dashboard'));
			}
			else $this->msg = 'Invalid Username/Password';
		}
		
		$this->load->view($this->folder.'/index');
		
	}
	
	protected function is_logged_in()
    {
        if($this->session->userdata('superadminID')=='' ||  $this->session->userdata('superadminname') == '' ||  $this->session->userdata('superadminemail') == '' ) 
		{
			redirect(base_url('superadmin'));
		}
    }
	
	public function logout()
    {
      $array_items = array('superadminID' => '','superadminname' => '', 'role' => '');
      $this->session->unset_userdata($array_items);
      redirect(base_url('superadmin'));
    }
	
	public function dashboard()
	{
		$this->is_logged_in();
		$cnd_arr['is_approved'] = 1;
		$cnd_arr['is_active'] = 1;
		$this->data['questions_count'] = $this->Superadmin_model->getQuestions_count('rt_tb_question',$cdn_arr,'');
		$this->data['users_count'] = $this->Users_model->getAllUsersCount('tr_tb_user',$cdn_arr,'');
		//echo '<pre>';print_r($this->data['users_count']);exit;
        $this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/dashboard',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function countries($currentPage = 0)
	{
		$this->is_logged_in();
		if($this->input->post())
		{
			$post = $this->input->post();
			if(isset($post['country_title']) && !empty($post['country_title']))
				$cdn_arr['country_name'] = trim($post['country_title']);
			if(isset($post['identity']) && !empty($post['identity']))
				$cdn_arr['search_identity'] = $post['identity'];
		}
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		$this->data['countries'] = $this->Superadmin_model->getdata('rt_tb_countries',$cdn_arr,$condition_array);
		$this->data['countries_counts'] = $this->Superadmin_model->getdata_count('rt_tb_countries',$cdn_arr,$condition_array);
		$this->data['recordsperpage'] =  $this->recordsperpage;
		$this->load->library('pagination');
		$config['base_url'] = base_url('superadmin/countries/');
		$config['total_rows'] = $this->data['countries_counts'];
		$config['per_page'] = $this->recordsperpage;	
		$this->pagination->initialize($config);	
		if(!isset($cdn_arr['search_identity']))
		$this->data['paginationLinks'] = $this->pagination->create_links();
		//echo "<pre>"; print_r($this->data); exit;
        $this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/countries',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function edit_country($cid = '')

	{
		$this->is_logged_in();
		if($this->input->post())
		{
			//echo "<pre>"; print_r($this->input->post()); exit;
			$cid = $this->Superadmin_model->updateCountry($this->input->post());
			}
		$this->data['country_details']  = $this->Common_model->get_table_row('rt_tb_countries',array('id' => $cid),'*','','','');
		//echo "<pre>"; print_r($this->data['country_details']); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/edit_country',$this->data);
		$this->load->view($this->folder.'/footer');
			
	}
	
	public function states($currentPage = 0)
	{
		$this->is_logged_in();
		if($this->input->post())
		{
			$post = $this->input->post();
			if(isset($post['state_title']) && !empty($post['state_title']))
				$cdn_arr['state_name'] = trim($post['state_title']);
			if(isset($post['country_id']) && !empty($post['country_id']))
				$cdn_arr['country_id'] = trim($post['country_id']);
			if(isset($post['identity']) && !empty($post['identity']))
				$cdn_arr['search_identity'] = $post['identity'];
		}
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		$this->data['states'] = $this->Superadmin_model->getdata('rt_tb_states',$cdn_arr,$condition_array);
		$this->data['states_counts'] = $this->Superadmin_model->getdata_count('rt_tb_states',$cdn_arr,$condition_array);
		$this->data['recordsperpage'] =  $this->recordsperpage;
		$this->load->library('pagination');
		$config['base_url'] = base_url('superadmin/states/');
		$config['total_rows'] = $this->data['states_counts'];
		$config['per_page'] = $this->recordsperpage;	
		$this->pagination->initialize($config);	
		if(!isset($cdn_arr['search_identity']))
		$this->data['paginationLinks'] = $this->pagination->create_links();
        $this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/states_list',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function edit_state($sid = '')

	{
		$this->is_logged_in();
		if($this->input->post())
		{
			//echo "<pre>"; print_r($this->input->post()); exit;
			$sid = $this->Superadmin_model->updateState($this->input->post());
			}
		$this->data['state_details'] = $this->Common_model->get_table_row('rt_tb_states',array('id' => $sid),'*','','','');
		//echo "<pre>"; print_r($this->data['country_details']); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/edit_state',$this->data);
		$this->load->view($this->folder.'/footer');
			
	}
	public function cities($currentPage = 0)
	{
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
		$this->data['cities'] = $this->Superadmin_model->getdata('rt_tb_cities',$cdn_arr,$condition_array);
		$this->data['cities_counts'] = $this->Superadmin_model->getdata_count('rt_tb_cities',$cdn_arr,$condition_array);
		$this->data['recordsperpage'] =  $this->recordsperpage;
		$this->load->library('pagination');
		$config['base_url'] = base_url('superadmin/cities/');
		$config['total_rows'] = $this->data['cities_counts'];
		$config['per_page'] = $this->recordsperpage;	
		$this->pagination->initialize($config);	
		if(!isset($cdn_arr['search_identity']))
		$this->data['paginationLinks'] = $this->pagination->create_links();
        $this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/cities_list',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function getstates()
	{
		$cnd_arr['country_id'] = $this->input->post('id');
		$this->data['states']=$this->Common_model->get_table('rt_tb_states',$cnd_arr,'*','','','','');
		echo json_encode($this->data['states']); exit;
		}
		
	public function ajax_getcities()
	{
		$cnd_arr['state_id'] = $this->input->post('id');
		$this->data['cities']=$this->Common_model->get_table('rt_tb_cities',$cnd_arr,'*','','','','');
		echo json_encode($this->data['cities']); exit;
		}
	public function edit_city($cityid = '')

	{
		$this->is_logged_in();
		if($this->input->post())
		{
			//echo "<pre>"; print_r($this->input->post()); exit;
			$cityid = $this->Superadmin_model->updateCity($this->input->post());
			}
		$this->data['city_details'] = $this->Common_model->get_table_row('rt_tb_cities',array('id' => $cityid),'*','','','');
		//echo "<pre>"; print_r($this->data['city_details']); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/edit_city',$this->data);
		$this->load->view($this->folder.'/footer');
			
	}
	
       public function settings($currentPage = 0)
	{
		$this->is_logged_in();
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$condition_array = array();
		if($this->input->post())
		{
			$post = $this->input->post();	 
                        foreach($post as $postKey=> $postval)	
                        $this->Common_model->update_table('settings',array('value'=>$postval),array('key'=>$postKey));redirect('superadmin/settings'); 				
			//echo "<pre>"; print_r($post); exit;
		}
		$settings  = $this->Common_model->get_table('settings');
                foreach($settings as $settingKey=> $val)
                $this->data['settings'][$val['key']]=$val['value'];
               // echo "<pre>"; print_r($this->data['settings']); exit;
		$this->load->view($this->folder.'/settings',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function questions($currentPage = 0)
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
		$config['base_url'] = base_url('superadmin/questions');
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
			$post['admin'] = $this->superadminID;
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

		redirect('superadmin/questions');

		exit;

	}
	
	public function deleteComment($id = '',$qid = '')

	{

		$this->is_logged_in();

		if(!empty($id))

			 $this->Common_model->update_table('rt_tb_question_comment',array('is_delete' => 1),array('id' => $id));

		redirect('superadmin/post_your_question/'.$qid);

		exit;

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
	function commentApprove()
	{
			$this->load->helper('form');
			if($this->input->post())
			{
				$post = $this->input->post();
				if( isset($post['ID']) && !empty($post['ID']) )
				{
		            $this->Common_model->update_table('rt_tb_question_comment',array('is_approved' => 1,'approved_at' => date('Y-m-d H:i:s')),array('id' => $post['ID']));
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
	
	public function bidding_update()
	{
		$this->is_logged_in();
		
		$post = $this->input->post();
		$total_bid_amt = 0;
		foreach($post['user_id'] as $key => $biding){
			$total_bid_amt = $total_bid_amt + $biding['wng_amt']; // total prize by super admin
		}
		$totalBidAmt_db = $this->Superadmin_model->getTotlaBidAmountByComment($post['comment_id']);
		if($total_bid_amt <= $totalBidAmt_db){
		foreach($post['user_id'] as $key => $biding){
			$data = array('user_id' => $biding['user_id'], 'comment_id'=>$post['comment_id'],'winning_position'=>$biding['position'], 'winning_amount'=>$biding['wng_amt'],'winner_type'=>'bid','created_at'=>date('Y-m-d H:i:s'));
			$this->Common_model->update_table('rt_tb_question',array('is_closed' => 1),array('id' => $post['qid']));
			$this->Common_model->insert_table('rt_tb_comment_bid_winners',$data); 
			
			$this->session->set_flashdata('message_bid', '<span style="color:green">Bidding submitted successfully...<span>');
			}
			}
		else{
				$this->session->set_flashdata('message_bid', '<span style="color:green">Total Prize Amount Should Not Be More Then Total Bidding Amount.<span>');
			}	
		redirect('superadmin/post_your_question/'.$post['qid']);
			
	}
	
	
	public function transactions($currentPage = 0)
	{
		$this->is_logged_in();
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		$this->data['transactions'] = $this->Users_model->getAllTransactions($condition_array);
		$this->data['transactions_count'] = $this->Users_model->getAllTransactionsCount($condition_array);
		$this->data['recordsperpage'] =  $this->recordsperpage;
		$this->load->library('pagination');
		$config['base_url'] = base_url('superadmin/transactions');
		$config['total_rows'] = $this->data['transactions_count'];
		$config['per_page'] = $this->recordsperpage;	
		$this->pagination->initialize($config);	
		$this->data['paginationLinks'] = $this->pagination->create_links();
		//echo "<pre>"; print_r($this->data); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/transactions',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function subscriptions($currentPage = 0)
	{
		$this->is_logged_in();
		if($this->input->post())
		{
			//echo "<pre>"; print_r($this->input->post()); exit;
			$cid = $this->Superadmin_model->updateSubscription($this->input->post());
			}
		$this->data['subscriptions']  = $this->Common_model->get_table('rt_tb_subscription',array('is_delete'=> 0),'*','','','');
		//echo "<pre>"; print_r($this->data['subscriptions']); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/subscription_list',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function add_subscription($subscription_id = '')
	{

		$this->is_logged_in();

		$this->load->helper('form');
		$this->load->helper('string');
		$this->load->model('Users_model');
		$this->load->model('Common_model');	
		if($this->input->post())
		{
			if($this->input->post('id'))
			{
				//echo "<pre>"; print_r($this->input->post()); exit;
				 $data = array('subscription_name' => $this->input->post('sub_name'),'subscription_price' => $this->input->post('sub_price'),'discount_type' => $this->input->post('discount_type'),'discount'=>$this->input->post('discount'),'time_period'=>$this->input->post('time_period'),'is_active' => 1,'is_delete' => 0);
				 $this->Common_model->update_table('rt_tb_subscription',$data,array('id' => $this->input->post('id')));
			}
			else
			{
				 
				$subscription=$this->Superadmin_model->createSubscription($this->input->post());
			}
			redirect('superadmin/subscriptions');  exit;
		}

		if(!empty($subscription_id)){

			$this->data['subscriptions_detials'] = array_shift($this->Common_model->get_table('rt_tb_subscription',array('id'=>$subscription_id,'is_delete'=> 0),'*','','',''));
		}

		else if($this->input->post())

			$this->data['subscriptions_detials'] = $this->input->post();

		else

		$this->data['subscriptions_detials'] = array();
		//echo "<pre>"; print_r($this->data['subscriptions_detials']); exit;
		$this->load->view($this->folder.'/header', $this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/add_subscription', $this->data);
		$this->load->view($this->folder.'/footer', $this->data);

	}
	
	public function deleteSubscription($id = '')

	{

		$this->is_logged_in();

		if(!empty($id))

			 $this->Common_model->update_table('rt_tb_subscription',array('is_delete' => 1),array('id' => $id));

		redirect('superadmin/subscriptions');

		exit;

	}
	
	function updateSubscriptionStatus()
	{
			$this->load->helper('form');
			if($this->input->post())
			{
				$post = $this->input->post();
				if( isset($post['ID']) && !empty($post['ID']) )
				{
		            $this->Common_model->update_table('rt_tb_subscription',array('is_active' => $post['status']),array('id' => $post['ID']));
					echo $post['status'];
				}
				else
					echo false;
			}
			else
			{
				echo false;
			}
	}
	
	
	public function testimanials($currentPage = 0)
	{
		$this->is_logged_in();
		$this->data['testimanials']  = $this->Users_model->getTestmonials('rt_tb_testmonials','','*','','','');
		//echo "<pre>"; print_r($this->data['testimanials']); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/testimanials_list',$this->data);
		$this->load->view($this->folder.'/footer');
		
	}
	
	public function deleteTestimanial($id = '')

	{

		$this->is_logged_in();

		if(!empty($id))

			 $this->Common_model->update_table('rt_tb_testmonials',array('is_delete' => 1),array('id' => $id));

		redirect('superadmin/testimanials');

		exit;

	}
	
	function testimanialApprove()
	{
			$this->load->helper('form');
			if($this->input->post())
			{
				$post = $this->input->post();
				if( isset($post['ID']) && !empty($post['ID']) )
				{
		            $this->Common_model->update_table('rt_tb_testmonials',array('is_approve' => 1),array('id' => $post['ID']));
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
	
	
	public function notifications($currentPage = 0)
	{
		$this->is_logged_in();
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->model('superadmin_model');
		$condition_array = array();
		if($this->input->post())
		{
			$post = $this->input->post();
						
			if(isset($post['category']) && !empty($post['category']))
			$condition_array['category'] = trim($post['category']);
			if(isset($post['recordPerPage']) && !empty($post['recordPerPage']))
				$this->recordsperpage = $post['recordPerPage'];
		}	
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		//echo "<pre>"; print_r($condition_array); exit;
		$this->data['notificationsCount']  = $this->Superadmin_model->getAllNotificationsCount($condition_array);
		$this->data['notifications']       = $this->Superadmin_model->getAllNotifications($condition_array);
		$this->data['recordsperpage'] = $this->recordsperpage;
	
		
		$this->load->library('pagination');
		$config['base_url'] = base_url('superadmin/notifications/');
		$config['total_rows'] = $this->data['notificationsCount'];
		$config['per_page'] = $this->recordsperpage; 		
		$this->pagination->initialize($config); 		
		$this->data['paginationLinks'] = $this->pagination->create_links();
		$this->load->view($this->folder.'/notifications',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
    
	
	                                                       


	
	public function uploadImage(){
		
		require_once("SimpleImage.class.php");
		$path = "uploaded/".$_REQUEST['pathfolder'].'/';
		$allowTypes = array('xls','xlsx','pdf','csv', "bmp");
		$valid_formats = array("jpg", "png", "gif","jpeg","ico");
		list($id,$fieldname)=explode("_",$_REQUEST['page']);
		$str="";$imgpath = '';$error = "";$msg = "";
		
		$fileid		   = $_REQUEST['name'];
		$imgwidth		   = isset($_REQUEST['width']) ? $_REQUEST['width']: 546;
		$imgheight		   = isset($_REQUEST['height'])? $_REQUEST['height']: 410;
		$filename      = str_replace('-','_',$_REQUEST['name']);
		$savefolderpath= $_REQUEST['pathfolder'];
		$arr		   = explode('-',$fileid);	
		$imgsetpath	   = $arr[0].'-'.$arr[1].'-imgPath';
			
		$successmssgid = $fileid.'-success-mssg';
		$errormssgid   = $fileid."-error-mssg";
		
		if(!empty($_FILES[$filename]['error']))
		{
			switch($_FILES[$filename]['error'])
			{
		
				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;
		
				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error =  'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		}elseif(empty($_FILES[$filename]['tmp_name']) || $_FILES[$filename]['tmp_name'] == 'none')
		{
			$error ='No file was uploaded.'.implode(',',$_FILES[$filename]);
		}else 
		{
			$message = '';
			$extension 	 =	 end(explode(".", $_FILES[$filename]["name"]));
			
				if(getimagesize($_FILES[$filename]['tmp_name'])){
			
					$imgname 	 =	 'anu-image-'.time();	
						
					$img_path	 =	 $path.$imgname.'.'.$extension;
					$org_img_path =  $path.'original/'.$imgname.'.'.$extension;
					$temp_path	 = 	 $_FILES[$filename]['tmp_name'];
					
					$msg = 'Image Path:'.$img_path;
					
					//code for resizing image	
					$image = new SimpleImage();
			
					$image->load($temp_path);
					$image->save($org_img_path);
					
					/*$image->crop(210,210);
					$image->save($img_path);*/
					
					$image->save($img_path);
						$x ='0';  $height_sts = false;
						$y = '0'; $width_sts  = false;
						
						
						
						$upImgWidth=$image->getWidth(); $upImgHeight=$image->getHeight();
						//Thumbnail Image
						if(($upImgWidth  > $imgwidth) || ($upImgHeight > $imgheight)){
							if($upImgWidth  > $imgwidth)	{
								$image->resizeToWidth($imgwidth);
								$image->save($img_path);	
								$image->load($img_path);
							} 
							
							$upImgHeight = $image->getHeight();
							if($upImgHeight > $imgheight)	{
								$image->resizeToHeight($imgheight);	
								$image->save($img_path);
							}
							$image->load($img_path);
							$newheight = $image->getHeight(); $newwidth = $image->getWidth();
							$hdiff = $imgheight - $newheight; $wdiff = $imgwidth - $newwidth;
							echo '<script language="JavaScript" type="text/javascript">'."\n";	
							echo 'console.log("Height:'.$hdiff.'****Width:'.$wdiff.' New Height:'.$newheight.'**** New Width:'.$newwidth.'");';
							echo "\n".'</script>';
						}else{
							$image->save($img_path);
							$hdiff = $imgheight-$upImgHeight; $wdiff = $imgwidth-$upImgWidth;
						}
						echo '<script language="JavaScript" type="text/javascript">'."\n";	
						echo 'console.log("Height:'.$hdiff.'****Width:'.$wdiff.'");';
						echo "\n".'</script>';
						$y= $hdiff>0 ? round($hdiff/2) : 0; $x= $wdiff>0 ? round($wdiff/2) : 0;
						$style = 'margin-left : '.$x.'px; margin-top :  '.$y.'px; width : 300px; height : 200px;';
					
					//Thumbnail Image
					//$image->resize(150,150);
//			
//					$image->save($thumb_path);
				}else{
					$error = 'Please upload a valid image';
				}
			
		}	
		
		echo '<script language="JavaScript" type="text/javascript">'."\n";
		echo 'var parDoc = window.parent.document;';
		if(!empty($error)){
			echo "parDoc.getElementById('".$errormssgid."').innerHTML = '".$error."';";
		}else{
			
			echo "parDoc.getElementById('".$imgsetpath."').value = '".$img_path."';";
			
			echo  "parDoc.getElementById('".$imgsetpath."_img').src = '".base_url($img_path)."';";
			echo  "parDoc.getElementById('".$imgsetpath."_a').href = '".base_url($img_path)."';";
			
			echo  "parDoc.getElementById('".$imgsetpath."_img').setAttribute('style', '".$style."');";
			
			echo "parDoc.getElementById('".$errormssgid."').innerHTML = '';";
			
			if($_REQUEST['filetype']=='file'){
				//echo "parDoc.getElementById('".$successmssgid."').innerHTML = 'File uploaded successfully';";
			}else{
				//echo "parDoc.getElementById('".$successmssgid."').innerHTML = '<img src=\"".base_url($img_path)."\" width=\"50\" height=\"50\">';";
			}
		}
		echo "\n".'</script>';
		exit(); // do not go futher
	}
	public function uploadMultiImage()
	{
			$data = array();
			if( isset( $_POST['image_upload'] ) && !empty( $_FILES['images'] )){
			
				$image = $_FILES['images'];
				$allowedExts = array("gif", "jpeg", "jpg", "png");
			
				//$ip=getIPAddress();
				//create directory if not exists
				if (!file_exists('images')) {
					mkdir('images', 0777, true);
				}
				$image_name = $image['name'];
				
				//get image extension
				$ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
				
				//assign unique name to image
				$name = time().'.'.$ext;
				
				//$name = $image_name;
				//image size calcuation in KB
				$image_size = $image["size"] / 1024;
				$image_flag = true;
				
				//max image size
				$max_size = 512;
				if( in_array($ext, $allowedExts) && $image_size < $max_size ){
					$image_flag = true;
				} else {
					$image_flag = false;
					$data['error'] = 'Maybe '.$image_name. ' exceeds max '.$max_size.' KB size or incorrect file extension';
				} 
			
				if( $image["error"] > 0 ){
					$image_flag = false;
					$data['error'] = '';
					$data['error'].= '<br/> '.$image_name.' Image contains error - Error Code : '.$image["error"];
				}
			
				if($image_flag){
					move_uploaded_file($image["tmp_name"], "uploaded/healthcamps/".$name);
					$src  = "uploaded/healthcamps/".$name;
					$dist = "uploaded/healthcamps/thumbnail_".$name;
					$data['success'] = $thumbnail = 'thumbnail_'.$name;
					
					$this->Common_model->thumbnail($src, $dist, 200);
					$pid=$this->Common_model->insert_table('fhpl_health_camp_images',array('image'=> $name,'thumbImagePath'=>$thumbnail,'campID'=> $_POST['campID']));
					$data['imageID'] = $pid;
				}
				echo json_encode($data);
			
			} else {
				$data[] = 'No Image Selected..';
			}
	}
	
	public function uploadckimage()
	{
		$basePath=base_url();
		$baseUrl = "uploaded/";
		$CKEditor = $_GET['CKEditor'] ;
		$funcNum = $_GET['CKEditorFuncNum'] ;
		$langCode = $_GET['langCode'] ;
		$url = '' ;
		$message = '';
		if (isset($_FILES['upload'])) {
			  $name = $_FILES['upload']['name'];
			if(move_uploaded_file($_FILES["upload"]["tmp_name"], $baseUrl . $name)) {
			  $url = $basePath. $baseUrl . $name;
			  $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
			  $message = $img_name .' successfully uploaded';
			  $re = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message')";
			}
			else $re = 'alert("Unable to upload the file")';
		   echo "<script type='text/javascript'>$re;</script>"; 
		}
		else
		{
			$message = 'alert("No file has been sent")';
			echo "<script type='text/javascript'>$message;</script>"; 
		}
		exit;
	}
	
	public function seetable()
	{
	$this->data['allstores']=$this->Common_model->get_table('tr_tb_user',array(),array('*'),'','','','');
	//$this->data['rowsexample']=$this->Users_model->seetable('coupon_stores',array(),array('*'),'','');
	//$this->data['rowsexample']=$this->Users_model->seetable();
	echo '<pre>'; print_r($this->data['allstores']); exit;
	}
	
	//home end
}
