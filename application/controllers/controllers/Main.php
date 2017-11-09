<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public $data=array();
	public $userID;
	public $recordsperpage;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->library('session');
		$this->load->helper('common');
		
		if(isset($this->session->userdata['USER_ID']))
		{
		$this->userID=$this->session->userdata['USER_ID'];
		$this->data['userpic']          = $this->Common_model->get_table_row('tr_tb_user',array('id' =>$this->userID),array('pic'));
		$this->data['wallet']           = $this->Common_model->get_table_row('rt_vw_wallet',array('user_id' =>$this->userID));
		}
		$this->data['categoriesList']   = $this->Common_model->get_table('rt_tb_category',array('is_active' =>1,'is_delete' =>0),array('category_name','category_uid','id'));
		$this->data['settings']         = $this->Users_model->getSettings();
		$this->data['testmonials']      = $this->Users_model->getTestmonials(array('is_approve' =>1));
		$this->recordsperpage           = $this->data['settings']['QuestionsPerPage'];
		$this->data['commonData']       = $this->Users_model->getCommonData();
		$this->data['winners']          = $this->Users_model->getWinnersData();
	  //echo '<pre>';print_r($_SESSION);exit;
	  //echo '<pre>';print_r($this->data);exit;
	}

    public function isAjaxRequest()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';
	}
	
	 public function isLoggedIn()
	{
		if($this->session->userdata('USER_ID')=='' || $this->session->userdata('USER_EMAIL')==''|| $this->session->userdata('USER_NAME')=='' )
		{
			redirect(base_url()); exit;
		}
	}

	public function logout()
	{
	  $array_items = array('USER_ID' => '','USER_EMAIL' => '', 'USER_MOBILE' => '', 'USER_SUB_ID' => '');
	  $this->session->unset_userdata($array_items);
	  $this->session->sess_destroy();
	  redirect(base_url(''));
	  exit;
	}
	
	public function register()
	{
		if($this->isAjaxRequest())
		{
		
				   $post=$this->input->post();
				   if($this->session->userdata['otp'][$post['mobile']]!=trim($post['otp']))
				   {
						   echo json_encode(array('success' => false,'msg' => 'Invalid OTP'));exit;
				   }
				   else
				   {
					  
					   $exists = $this->Common_model->get_table_row('tr_tb_user',array('email_id' => $post['email']),array('email_id'));
					   if(!empty($exists))
					   {
					    echo json_encode(array('success' => false,'msg' => $post['email'].' is already exists'));exit;
					   }
					  
					    $brcE     =  substr(rand(1,1000000),0,3); 
						$brchrE  =   substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUXYVWZ"), 0, 3); 
						$email_verify_code =  $brchrE.$brcE;
						$post['email_verify_code'] =$email_verify_code;
					    if($user=$this->Users_model->createUser($post))
					    {
							   
							    $this->load->library('common');		
					            $config['mailtype'] = 'html';
								$config['charset']  = 'utf-8';
					            $unique 		=	 urlencode(base64_encode($email_verify_code));
								$email_data = array('<#USERNAME#>'		=>	$this->input->post('email'),
													'<#PASSWORD#>'		=>	$this->input->post('password'),
													'<#SITE#>'			=>	base_url(),
											     	'<#VERIFY#>'		=>	base_url('main/verifyaccount/'.$user.'-'.$email_verify_code),
													'<#BASEURL#>'		=>	base_url(),
												);
								$message  = $this->common->getEmailText($email_data,'account-creation.txt');
								$this->load->library('email');
								$this->email->initialize($config);
								$this->email->from($this->config->item('mail_from'), $this->config->item('from_name'));
								$this->email->to($this->input->post('email_id')); 
								$this->email->bcc($this->config->item('mail_bcc'));  
								$this->email->subject($message[0]);
								$this->email->message($message[1]);
								$this->email->send();
					    echo json_encode(array('success' => true,'message' => 'success','sucmessage' => 'Thank you for registered with us.Please check your inbox to verify.'));exit;
					}
					else
					{
					echo json_encode(array('success' => false,'message' => 'some failure occured in registeration'));exit;
					}
				   }
			
		}
	}
        
    public function sendotp()
	{

			if($this->isAjaxRequest())
			{   

				$otp_array['otp']=array();
				$mobile=trim($this->input->post('mobile'));
				$otp_array['otp'][$mobile]='1234';//$this->gen_random(4);
				$this->session->set_userdata($otp_array);
				$message="Dear Customer.Your one time password is ".$otp_array['otp'][$mobile].".Please do not share this otp with anyone.";
				//$this->common->sendSMSMessage($mobile,$message);
                                exit;
				//echo json_encode($otp_array);exit;
			}

	 }
        
    public function verifyaccount($ID)
	{
			$IdArr=explode('-',$ID);
			$this->Common_model->update_table('tr_tb_user',array('varification_code' => '','verification_at' => date('Y-m-d H:i:s')),array('varification_code' => $IdArr[1]));
			redirect(base_url(''));
	}
	

	public function checkuser()
	{	
		if($this->isAjaxRequest())
		{       
		        $data = array('user_name' => $this->input->post('user_name'),'password'=>$this->input->post('password'));
				$client=$this->Users_model->checkAuthentication($data);
				if($client['status'])
				{
					$array = array(
						'USER_ID'	 	 => $client['user']['id'],
						'USER_EMAIL' 	 => $client['user']['email_id'],
						'USER_MOBILE' 	 => $client['user']['mobile'],
						'USER_NAME' 	 => $client['user']['first_name'].' '.$client['user']['last_name'],
						'USER_SUB_ID'    => $client['user']['subscription_id'],
						
					);
					$this->session->set_userdata($array);
					echo json_encode(array('message' => 'success','url' => base_url('users/dashboard')));exit;
				}
				else
				{
					echo json_encode($client);exit;
				}
		}else redirect(base_url()); exit;
	} 
	
	 public function userexists()
	 {
			   if(isset($_POST))
			   {

						$this->load->model('Common_model');
						if(($_POST['flag'])==1)
						{
								  $check = $this->Common_model->get_table_row('tr_tb_user',array('email_id' => $_POST['value']),array('email_id'));
								  if($check['email_id']!='')
								  {
												echo '<STRONG>'.$_POST['value'].'</STRONG> is already in use.';exit;		
								  }
					    }
					   if(($_POST['flag'])==2)
						{
								  $check = $this->Common_model->get_table_row('tr_tb_user',array('mobile' => $_POST['value']),array('mobile'));
								  if($check['mobile']!='')
								  {
												echo '<STRONG>'.$_POST['value'].'</STRONG> is already in use.';exit;		
								  }
					   }
			   }
		}
		
	public function resetpassword()
	{
	
         $this->isLoggedIn();
	     if($this->input->post())
		 {
		   $post = $this->input->post();
		   //echo "<pre>"; print_r($post); exit;
		   $exists=$this->Common_model->get_table('tr_tb_user',array('id' =>  $this->userID,'password' => md5($post['corrent_pw']),'is_active' => '1'),array('id'));
		   if(!empty($exists))
		   {
		   $this->Common_model->update_table('tr_tb_user',array('password' =>md5($post['new_pw'])),array('id' =>$this->userID));
		   $this->session->set_flashdata('msg', '<b style="color:green">Password changed successfully</b>');
		   }else{
			$this->session->set_flashdata('msg', '<b style="color:red">Your current password is invalid</b>');
		   }
	       redirect(base_url('main/resetpassword')); exit;
		 }

		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/reset-password',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
		
	}
	
	public function index()
	{
	 
		if(!isset($_COOKIE['prelanding']))
		{  
		 setcookie('prelanding', true,  time()+86400); 
		 $this->load->view('frontend/index-p',$this->data);
		}
		else
		{
		$this->load->model('Question_model');$cnd_arr['recordsperpage']=$this->recordsperpage;$cnd_arr['limit']=0;
		//$cnd_arr['orderby']='bidding_closed_at';
		$this->data['questionsList']= $this->Question_model->HomePage($cnd_arr);//	echo '<pre>';print_r($this->data);exit;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/home',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
		}
	}
	public function about_to_close_questions()
	{   
		$this->load->model('Question_model');
		$this->data['pageHeading'] = 'About to Close Questions';
		$this->data['pageKey'] = 'about-to-close';
		$cnd_arr['recordsperpage']=$this->recordsperpage;$cnd_arr['limit']=0;$cnd_arr['is_approved']=1;
		$count =  $this->Question_model->getAllQuestionsCount($cnd_arr);
		$total_pages		 =	ceil($count / $this->recordsperpage);
		$this->data['total_pages'] =  $total_pages;
		$this->data['total_count']	= $count;
		
		
		$cnd_arr['orderby']='bidding_closed_at';$cnd_arr['ordertype']='ASC';
		//$this->data['questionsList']= $this->Question_model->getAllQuestions($cnd_arr);	//echo '<pre>';print_r($this->data);exit;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/index',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	}
	
	public function trending_questions()
	{
		$this->load->model('Question_model');
		$this->data['pageHeading'] = 'Trending Questions';
		$this->data['pageKey'] = 'trending';
		$cnd_arr['recordsperpage']=$this->recordsperpage;$cnd_arr['limit']=0;
		$cnd_arr['is_trending']=1;$cnd_arr['is_approved']=1;
		$count =  $this->Question_model->getAllQuestionsCount($cnd_arr);//echo $this->db->last_Goalltravel);exit;
		$total_pages		 =	ceil($count / $this->recordsperpage);
		$this->data['total_pages'] =  $total_pages;
		$this->data['total_count']	= $count;
		//$this->data['questionsList']= $this->Question_model->getAllQuestions($cnd_arr);	//echo '<pre>';print_r($this->data);exit;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/index',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
		
	}
	
	public function latest_questions()
	{
		$this->load->model('Question_model');
		$this->data['pageHeading'] = 'Latest Questions';
		$this->data['pageKey'] = 'latest';
		$cnd_arr['recordsperpage']=$this->recordsperpage;$cnd_arr['limit']=0;$cnd_arr['is_approved']=1;
		$count =  $this->Question_model->getAllQuestionsCount($cnd_arr);
		$total_pages		 =	ceil($count / $this->recordsperpage);
		$this->data['total_pages'] =  $total_pages;
		$this->data['total_count']	= $count;
		$cnd_arr['orderby']='id';$cnd_arr['ordertype']='DESC';
		//$this->data['questionsList']= $this->Question_model->getAllQuestions($cnd_arr);	//echo '<pre>';print_r($this->data);exit;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/index',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
		
	}
	
	public function top_bidding()
	{
		$this->load->model('Question_model');
		$this->data['pageHeading'] = 'Top Bidding Questions';
		$this->data['pageKey'] = 'top-bidding';
		$cnd_arr['recordsperpage']=$this->recordsperpage;$cnd_arr['limit']=0;$cnd_arr['is_approved']=1;
		$count =  $this->Question_model->getTopBiddingQuestionsCount();
		$total_pages		 =	ceil($count / $this->recordsperpage);
		$this->data['total_pages'] =  $total_pages;
		$this->data['total_count']	= $count;
		//$this->data['questionsList']= $this->Question_model->getTopBiddingQuestions($cnd_arr);	//echo '<pre>';print_r($this->data);exit;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/index',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
		
	}
	
	public function category($id)
	{
		$this->load->model('Question_model');
		$this->data['pageHeading'] = 'Category Questions';
		$this->data['pageKey'] = 'category';
		$cnd_arr['orderby']='bidding_closed_at';$cnd_arr['ordertype']='ASC';$cnd_arr['is_approved']=1;
		if($id!='')$cnd_arr['category_id']=$id;
		$cnd_arr['recordsperpage']=$this->recordsperpage;$cnd_arr['limit']=0;
		$count =  $this->Question_model->getAllQuestionsCount($cnd_arr);//echo $this->db->last_Goalltravel);exit;
		$total_pages		 =	ceil($count / $this->recordsperpage);
		$this->data['total_pages'] =  $total_pages;
		$this->data['total_count']	= $count;
		$this->data['category_id']=$id;
		//$this->data['questionsList']= $this->Question_model->getAllQuestions($cnd_arr);	//echo '<pre>';print_r($this->data);exit;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/index',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	}
	public function get_view_data()
	{
	if($this->isAjaxRequest())
	{
	$data['msg'] = '';
	$this->load->model('Question_model');
	$page 				= 	intval( $this->input->post('p') );
	$current_page		=	$page - 1;
	$start				=	$current_page * $this->recordsperpage;
	$cnd_arr['recordsperpage']=$this->recordsperpage;$cnd_arr['limit']=$start;
	$cnd_arr['is_approved']=1;	
	switch($this->input->post('param3'))
	{
	 case 'trending':$cnd_arr['is_trending']=1;$this->data['questionsList'] 	= $this->Question_model->getAllQuestions($cnd_arr); break;
	 case 'about-to-close':$cnd_arr['orderby']='bidding_closed_at';$cnd_arr['ordertype']='ASC';$this->data['questionsList']=$this->Question_model->getAllQuestions($cnd_arr); break;
	 case 'latest':$cnd_arr['orderby']='id';$cnd_arr['ordertype']='DESC';$this->data['questionsList']= $this->Question_model->getAllQuestions($cnd_arr); break;
	 case 'top-bidding':$this->data['questionsList'] = $this->Question_model->getTopBiddingQuestions($cnd_arr);break;	//echo '<pre>';print_r($this->data);exit;
	 case 'my':$cnd_arr['orderby']='bidding_closed_at';$cnd_arr['ordertype']='ASC';$cnd_arr['user_id']=$this->userID;$this->data['questionsList'] = $this->Question_model->getAllQuestions($cnd_arr);$this->data['pageKey']=$this->input->post('param3');break;
	 case 'myc':$cnd_arr['user_id']=$this->userID;$this->data['questionsList'] = $this->Question_model->getQuestionsByMyComments($cnd_arr);$this->data['pageKey']=$this->input->post('param3');break;
	 case 'myb':$cnd_arr['user_id']=$this->userID;$this->data['questionsList'] = $this->Question_model->getQuestionsByMyBid($cnd_arr);break;
	 default: $cnd_arr['orderby']='bidding_closed_at';$cnd_arr['ordertype']='ASC';if($this->input->post('param4')!='')$cnd_arr['category_id']=$this->input->post('param4');               $this->data['questionsList'] = $this->Question_model->getAllQuestions($cnd_arr);break;
	}
	//echo '<pre>';print_r($this->data['stores']);exit;
	$data['questionGridDivData'] = $this->load->view('frontend/_load_questions', $this->data, TRUE);//echo '<pre>';print_r($data);exit;		
	$data	=	array('html'=>$data['questionGridDivData']);
	echo json_encode($data);
	}
	}
	

	
	 public function profile()
	 {
		
		$this->isLoggedIn();
		$condition_array = array();
		if($this->input->post())
		{
			$post = $this->input->post();
            $this->Common_model->update_table('tr_tb_user',array('first_name'=> $post['fname'],'last_name'=> $post['lname'],'address'=> $post['address'],'state'=> $post['state'],'zipcode'=> $post['zipcode']),array('customer_id'=>$this->userID));				
		       
		}
		$this->data['profile']= $this->Common_model->get_table_row('tr_tb_user',array('id'=>$this->userID));
		
		$this->load->model('Question_model');
		$this->data['pageHeading'] = 'My Questions';
		$this->data['pageKey'] = 'my';
		$cnd_arr['user_id']=$this->userID;$cnd_arr['is_approved']=1;	
		$cnd_arr['recordsperpage']=$this->recordsperpage;$cnd_arr['limit']=0;
		$cnd_arr['orderby']='bidding_closed_at';$cnd_arr['ordertype']='ASC';
		$count =  $this->Question_model->getAllQuestionsCount($cnd_arr);
		$total_pages		 =	ceil($count / $this->recordsperpage);
		$this->data['total_pages'] =  $total_pages;
		$this->data['total_count']	= $count;
		//echo '<pre>';print_r($this->data);exit;
		//$this->data['questionsList']= $this->Question_model->getAllQuestions($cnd_arr);	//echo '<pre>';print_r($this->data);exit;
		$this->data['post'] = $post ;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/profile',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	}
	 public function myinformation()
	 {
		
		$this->isLoggedIn();
		$condition_array = array();
		if($this->input->post())
		{
			$post = $this->input->post();
			//echo "<pre>"; print_r($post); exit;
            $this->Common_model->update_table('tr_tb_user',array('first_name'=> $post['firstName'],'last_name'=> $post['lastName'],'mobile'=> $post['mobile'],'gender'=> $post['gender'],'alternate_email'=> $post['alternate_email'],'street_address'=> $post['address'],'country'=> $post['country'],'state'=> $post['state'],'city'=> $post['city'],'pin_code'=> $post['zipcode']),array('id'=>$post['user_id']));
		       
		}
		
		$this->data['profile']= $this->Common_model->get_table_row('tr_tb_user',array('id'=>$this->userID));
		$profile = $this->data['profile'];
		$this->data['countries']=$this->Common_model->get_table('rt_tb_countries','','*');
		if(isset($this->data['profile']['country']) && $this->data['profile']['country'] != 0)
		$conunrty['country_id'] = $this->data['profile']['country'];
		$this->data['states']=$this->Common_model->get_table('rt_tb_states',$conunrty,'*');
		if(isset($this->data['profile']['state']) && $this->data['profile']['state'] != 0)
		$state['state_id'] = $this->data['profile']['state'];
		$this->data['cities']=$this->Common_model->get_table('rt_tb_cities',$state,'*');
		$this->data['post'] = $post ;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/my-information',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	}
	
	public function my_comments()
	{
		$this->isLoggedIn();
		$this->load->model('Question_model');
		$this->data['pageHeading'] = 'My Commented Questions';
		$this->data['pageKey'] = 'myc';
		$cnd_arr['user_id']=$this->userID;
		$cnd_arr['recordsperpage']=$this->recordsperpage;$cnd_arr['limit']=0;
		$cnd_arr['orderby']='bidding_closed_at';$cnd_arr['ordertype']='ASC';
		$count =  $this->Question_model->getQuestionsByMyCommentsCount($cnd_arr);
		$total_pages		 =	ceil($count / $this->recordsperpage);
		$this->data['total_pages'] =  $total_pages;
		$this->data['total_count']	= $count;
		//echo '<pre>';print_r($count);exit;
		//$this->data['questionsList']= $this->Question_model->getAllQuestions($cnd_arr);	//echo '<pre>';print_r($this->data);exit;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/my-commented-questions',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	}
	
		public function my_bidding()
	{
		$this->isLoggedIn();
		$this->load->model('Question_model');
		$this->data['pageHeading'] = 'My Bidded Questions';
		$this->data['pageKey'] = 'myb';
		$cnd_arr['user_id']=$this->userID;
		$cnd_arr['recordsperpage']=$this->recordsperpage;$cnd_arr['limit']=0;
		$cnd_arr['orderby']='bidding_closed_at';$cnd_arr['ordertype']='ASC';
		$count =  $this->Question_model->getQuestionsByMyBidCount($cnd_arr);
		$total_pages		 =	ceil($count / $this->recordsperpage);
		$this->data['total_pages'] =  $total_pages;
		$this->data['total_count']	= $count;
		//echo '<pre>';print_r($count);exit;
		//$this->data['questionsList']= $this->Question_model->getAllQuestions($cnd_arr);	//echo '<pre>';print_r($this->data);exit;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/my-commented-questions',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	}
	public function my_transactions()
	{
		$this->isLoggedIn();
		$this->load->model('Question_model');
		$this->data['pageHeading'] = 'My Transactions';
		$this->data['pageKey'] = 'myt';
		$cnd_arr['user_id']=$this->userID;
		$this->data['transactionsList']= $this->Users_model->getAllTransactions($cnd_arr);	//echo '<pre>';print_r($this->data);exit;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/my-transactions',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	}
	
	public function getHighestBidAmountByComment()
	{
		if($this->isAjaxRequest())
		{ 
		$this->load->model('Question_model');  
		$commentID = $this->input->post('q');
		$lastHighestBid=$this->Question_model->getHighestBidAmountByComment($commentID);
		
		$nextHighestBid=$lastHighestBid+$this->data['settings']['MinimumBidValue'];
		echo json_encode(array('amount' =>$nextHighestBid )); exit;
		}
	}
	public function addBidonComment()
	{
		$this->isLoggedIn();
		if($this->isAjaxRequest())
		{ 
		    $this->load->model('Question_model');  
			$commentID = $this->input->post('comment_id');$amount= $this->input->post('amount');
		    $lastHighestBid=$this->Question_model->getHighestBidAmountByComment($commentID);
		    $nextHighestBid=$lastHighestBid+$this->data['settings']['MinimumBidValue'];
			if($amount>=$nextHighestBid)
			{
				$exists=$this->Common_model->get_table_row('rt_tb_comment_bid',array('comment_id'=>$commentID,'user_id' => $this->userID),array('id'));
				//$message=$exists['id'];echo json_encode(array('message' =>$message)); exit;
			    if(isset($exists['id']))
				$this->Common_model->update_table('rt_tb_comment_bid',array('amount' => $amount),array('comment_id'=>$commentID,'user_id' => $this->userID));
				else
			    $lastbid=$this->Common_model->insert_table('rt_tb_comment_bid',array('comment_id'=>$commentID,'user_id' => $this->userID,'amount' => $amount));
			
			    $deductedAmount=$this->Common_model->get_table_row('rt_tb_transactions',array('comment'=>$commentID,'user_id' => $this->userID,'user_type' => 'rocker'),array('sum(amount) as amount'));
				$deductedVal=($deductedAmount['amount'])?$deductedAmount['amount']:0;
				//echo '<pre>';print_r($deductedAmount);exit;
			    $this->Common_model->insert_table('rt_tb_transactions',array('txn_uid'=>rand(1,rand(1,999999999999)),'user_type'=>'rocker','user_id'=>$this->userID,'comment'=>$commentID,'amount'=>($amount-$deductedVal),'txn_type'=>'debit','is_refunded'=> 'No','refund_txn_id'=>0,'comment'=>$commentID,'status'=> 'SUCCESS','updated_at'=>date('Y-m-d H:i:s'),'refunded_txn_id'=>0)); 
			$message='Your Bid is successfully placed';
			}
			else
			{
				$message='<span style="color:red">Your Bid is not valid</span>';
			}
		    echo json_encode(array('message' =>$message)); exit;
		}
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
	
	
	public function comment_form($id)
	{
		$this->isLoggedIn();
		if($this->input->post())
		{
		$post= $this->input->post();$post['user_id']=$this->userID;
		$comment_id=$this->Users_model->updateComment($post);
		$this->session->set_flashdata('message', '<span style="color:red">Your Comment Is Successfully Posted</span>');
		redirect(base_url());exit;
		}
		$subscrptionPlan=$this->Common_model->get_table_row('tr_tb_user',array('id' =>$this->userID),array('subscription_id'));
		$this->data['question_id']=$id;
		if($subscrptionPlan['subscription_id'])
		$this->load->view('frontend/comment-form',$this->data);
		else{
		$this->data['plansList']=$this->Common_model->get_table('rt_tb_subscription',array('is_active' => 1,'is_delete' => 0));
		$this->load->view('frontend/_plans',$this->data);}
	}
	
	public function comment_page($qid,$cid='')
	{
		$this->load->model('Question_model');
		$this->data['commentInfo']=$this->Question_model->getCommentsBySingleQuestion($qid);
		
		$this->data['stitle']=$this->data['commentInfo']['data'][$qid]['question'];
		$this->data['sdesc']=$this->data['commentInfo']['comments'][$qid][$cid]['comment'];
		//echo '<pre>';print_r($this->data['sdesc']);exit;
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/comment-page',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	}
	
	public function post_your_question()
	{
		$this->isLoggedIn();
		if($this->input->post())
		{
			$this->load->model('Question_model');
			$post=$this->input->post();
			$post['user_id']=$this->userID;
			if($_FILES['question']['tmp_name']!='')
			{
				$imageFileType = pathinfo($_FILES['question']['name'],PATHINFO_EXTENSION);
				if(($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif")|| $_FILES["image"]["size"] > 26214400) 
				{
				 $this->session->set_flashdata('message', '<span style="color:red">Invalid File Extension/Size for Question Gif.</span>');
				 redirect(base_url('post-your-question.html'));exit;
				}
				
				$hsourcePath = $_FILES['question']['tmp_name']; 
				$htargetPath = "uploaded/question/".$this->userID.'-'.time().'.'.$imageFileType; 
				move_uploaded_file($hsourcePath,$htargetPath) ;
			    $post['question']=$htargetPath;
			}
			$this->Question_model->updateQuestion($post);
			$this->session->set_flashdata('message', '<span style="color:green">Question Submited Successfully.</span>');
			redirect(base_url('post-your-question.html'));exit;
		}
		$this->data['categoryList']=$this->Common_model->get_table('rt_tb_category',array('is_active' => 1,'is_delete' => 0),array('category_name','id'));
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/post-your-question',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
		
	}
	
	public function plans()
	{
		$this->isLoggedIn();
		if($this->input->post())
		{
			           
		                $subscrptionPlanDetails=$this->Common_model->get_table_row('rt_tb_subscription',array('id' =>$this->input->post('planId')),array('subscription_name','subscription_price','discount','discount_type'));
						
					     $planid=$this->Common_model->insert_table('rt_tb_transactions',array('txn_uid' =>'','user_id' =>$this->userID,'user_type' =>'talker','amount' =>$subscrptionPlanDetails['subscription_price'],'txn_type' =>'credit','is_refunded' =>'No','refund_txn_id'=>'','refunded_txn_id'=>'','comment'=>''));
						
					    $payment['order_id'] = "RDTAS1_" . $planid ;
						$amount= $subscrptionPlanDetails['subscription_price'];
				   	    $hash = hash ("sha512", 'gtKFFx|'.$payment['order_id'].'|'.$amount.'|'.$subscrptionPlanDetails['subscription_name'].'|'.$this->session->userdata['USER_NAME'].'|'.$this->session->userdata['USER_EMAIL'].'|'.$this->input->post('planId').'||||||||||eCwWELxi');
						$html  = '<div class="message-loading">Loading...</div>';
						$html .= '<form id="checkout-form" action="https://test.payu.in/_payment" method="post">';
						$html .= '<input type="hidden" name="firstname" value="'.$this->session->userdata['USER_NAME'].'" />';
						$html .= '<input type="hidden" name="lastname" value="'.$this->session->userdata['USER_NAME'].'" />';
						$html .= '<input type="hidden" name="surl" value="'.base_url('main/success').'" />';
						$html .= '<input type="hidden" name="phone" value="'.$this->session->userdata['USER_MOBILE'].'" />';
						//$html .= '<input type="hidden" name="key" value="UST0tW" />';
						$html .= '<input type="hidden" name="key" value="gtKFFx" />';
						$html .= '<input type="hidden" name="hash" value = "'.$hash.'" />';
						$html .= '<input type="hidden" name="curl" value="'.base_url('main/cancel').'" />';
						$html .= '<input type="hidden" name="furl" value="'.base_url('main/failure').'" />';
						$html .= '<input type="hidden" name="txnid" value="'.$payment['order_id'].'" />';
						$html .= '<input type="hidden" name="productinfo" value="'.$subscrptionPlanDetails['subscription_name'].'" />';
						$html .= '<input type="hidden" name="udf1" value="'.$this->input->post('planId').'" />';
						$html .= '<input type="hidden" name="amount" value="'.$amount.'" />';
						$html .= '<input type="hidden" name="email" value="'.$this->session->userdata['USER_EMAIL'].'" />';
						$html .= '</form><script type="text/javascript">document.getElementById("checkout-form").submit();</script>';
						echo $html; exit;
			//$this->Common_model->update_table('tr_tb_user',array('subscription_id'=> $this->input->post('planId')),array('id' =>$this->userID)); redirect(base_url());exit;
		}
		$this->data['plansList']=$this->Common_model->get_table('rt_tb_subscription',array('is_active' => 1,'is_delete' => 0));
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/plans',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
		
	}
	
	 public function addFunds($ID)
	{
			$this->isLoggedIn();
			if($this->input->post())
		    {
			           
						$amount= $this->input->post('amount');
					   
					     $tid=$this->Common_model->insert_table('rt_tb_transactions',array('txn_uid' =>'','user_id' =>$this->userID,'user_type' =>'rocker','amount' =>$amount,'txn_type' =>'credit','is_refunded' =>'No','refund_txn_id'=>'','refunded_txn_id'=>'','comment'=>''));
						
					    $payment['order_id'] = "RDTAS1_" . $tid ;
				   	    $hash = hash ("sha512", 'gtKFFx|'.$payment['order_id'].'|'.$amount.'|Add Money To Rocker Wallet|'.$this->session->userdata['USER_NAME'].'|'.$this->session->userdata['USER_EMAIL'].'|||||||||||eCwWELxi');
						$html  = '<div class="message-loading">Loading...</div>';
						$html .= '<form id="checkout-form" action="https://test.payu.in/_payment" method="post">';
						$html .= '<input type="hidden" name="firstname" value="'.$this->session->userdata['USER_NAME'].'" />';
						$html .= '<input type="hidden" name="lastname" value="'.$this->session->userdata['USER_NAME'].'" />';
						$html .= '<input type="hidden" name="surl" value="'.base_url('main/walletsuccess').'" />';
						$html .= '<input type="hidden" name="phone" value="'.$this->session->userdata['USER_MOBILE'].'" />';
						//$html .= '<input type="hidden" name="key" value="UST0tW" />';
						$html .= '<input type="hidden" name="key" value="gtKFFx" />';
						$html .= '<input type="hidden" name="hash" value = "'.$hash.'" />';
						$html .= '<input type="hidden" name="curl" value="'.base_url('main/cancel').'" />';
						$html .= '<input type="hidden" name="furl" value="'.base_url('main/failure').'" />';
						$html .= '<input type="hidden" name="txnid" value="'.$payment['order_id'].'" />';
						$html .= '<input type="hidden" name="productinfo" value="Add Money To Rocker Wallet" />';
						$html .= '<input type="hidden" name="amount" value="'.$amount.'" />';
						$html .= '<input type="hidden" name="email" value="'.$this->session->userdata['USER_EMAIL'].'" />';
						$html .= '</form><script type="text/javascript">document.getElementById("checkout-form").submit();</script>';
						echo $html; exit;
		  }
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/addFunds',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	}
	
	public function walletsuccess()
   {
		if($this->input->post())
		{
             $urifield='';
			 $post = $this->input->post();
             if(isset($post))
			 { 
				     $payment_id     = $post['mihpayid'];
			   	     $idDetails      = explode('_',$post['txnid']);
					 $this->Common_model->update_table('rt_tb_transactions',array('txn_uid'=>$post['mihpayid'],'status'=>'SUCCESS'),array('id' =>$idDetails[1])); 
					 $this->session->set_flashdata('message', '<span style="color:red">Payment Successful.You are now eligible for Bidding.</span>');
					 redirect(base_url()); exit;
			 }
			 else redirect(base_url('main/cancel')); exit;
		}
		redirect(base_url('main/cancel')); exit;
	}
	
	 public function insertComment()
	{
            $this->isLoggedIn();
			if($this->isAjaxRequest())
			{   
              $this->load->model('Question_model');$html='';
			  $post=$this->input->post();
			  $allowed=$this->Question_model->isCommentsAllowed($post['q']);
			  if($allowed)
			  {
				 $talkerBalance=$this->data['wallet']['talker_credit_amount']-$this->data['wallet']['talker_debit_amount'];
				 if($talkerBalance>=$this->data['settings']['perCommentDeduction'])
				 {
				  $txn_uid=rand(1,9999999999999);
				 //$QuestionBiddingExpiryTime=date('Y-m-d H:i:s', strtotime("+".$this->data['settings']['QuestionCommentExpiryTime']." days"));
				  $cid=$this->Common_model->insert_table('rt_tb_question_comment',array('qusetion_id'=>$post['q'],'ip_address'=>$_SERVER['REMOTE_ADDR'],'user_id'=>$this->userID,'comment'=>$post['text'],'is_closed'=>0,'is_active'=>1,'is_biddable'=>1,'is_approved'=>1,'updated_at'=>date('Y-m-d H:i:s'),'approved_at'=>date('Y-m-d H:i:s')));  
				   
				  $this->Common_model->insert_table('rt_tb_transactions',array('txn_uid'=>$txn_uid,'user_type'=>'talker','user_id'=>$this->userID,'comment'=>$post['text'],'amount'=>$this->data['settings']['perCommentDeduction'],'txn_type'=>'debit','is_refunded'=> 'No','refund_txn_id'=>0,'comment'=>$cid,'status'=> 'SUCCESS','updated_at'=>date('Y-m-d H:i:s'),'refunded_txn_id'=>0)); 
				  $pic=($this->data['userpic']['pic']!='')?base_url().$this->data['userpic']['pic']:base_url().'css/img/avatar.jpg';
				  $html='<div class="inner cover price comment_ques_bi"> <div class="img_var_come"><img src="'.$pic.'" width="30" height="30"> </div> <div class="comment_area_re"> <p><strong>You</strong></p> <p>'.$post['text'].'</p></div>
                     <div class="col-md-4">
                        <ul class="share share_one">
                            <li><i class="fa fa-share-alt" aria-hidden="true"></i> share</li>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u='.base_url().'main/comment_page/'.$post['q'].'/'.$cid.'" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://twitter.com/intent/tweet?text='.urlencode($post['text']).'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="https://plus.google.com/share?url='.base_url().'comment_page/'.$post['q'].'/'.$cid.'" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                     <div class="col-md-4">
                     <p class="bid_likes_comment"><a href="javascript:" class="newcomm" id="newcom-'.$cid.'" rel="'.$cid.'" rel1="likes">0 Likes</a> </p>
                  </div></div>';
				 
				  echo json_encode(array('success' => 'success','message' => 'Your Comment Posted Successfully','html'=> $html));exit;
				 }
				 else{
					 echo json_encode(array('success' => 'success','message' => 'You Have no sufficient funds To Post Comment','html'=> $html));exit; 
				 }
			  }
			  else
			 	echo json_encode(array('success' => 'failed','message' => 'Comment is Not allowed for this Question','html'=> $html));exit;
			}

	 }
	 
	 public function insertLike()
	{

			if($this->isAjaxRequest())
			{   
				$ip=$_SERVER['REMOTE_ADDR'];
				$ipexists=$this->Common_model->get_table('rt_tb_comments_likes_dislikes',array('comment_id' => $_POST['q'],'user_id' =>$this->userID,'type' =>$_POST['type']),array('id'));
				if(!empty($ipexists))
				{
				echo "-1";
				exit;
				}
				$this->Common_model->insert_table('rt_tb_comments_likes_dislikes',array('comment_id'=>$_POST['q'],'user_id'=>$this->userID,'ip_address' =>$ip,'type' =>$_POST['type']));		
				echo 1;
				exit;  
			}

	 }
	  public function getCommentsByQuestion()
	{

			if($this->isAjaxRequest())
			{   
              $this->load->model('Question_model');
			  $post=$this->input->post();
			  $this->data['pageKey']=$post['pageKey'];
			  $this->data['q']=$post['q'];
			//echo "<pre>"; print_r($this->data['CommentsList']); exit;
			/* switch($post['pageKey'])
	         {
	          case 'my'   :    $this->data['CommentsList']=$this->Question_model->getCommentsByQuestion($post['q']);$result = $this->load->view('frontend/_get_my_comments',$this->data,true);	break;
			  case 'myc'   :    $this->data['CommentsList']=$this->Question_model->getCommentsByQuestion($post['q'],$this->userID);$result = $this->load->view('frontend/_get_my_comments',$this->data,true);	break;
	          default     :    $this->data['CommentsList']=$this->Question_model->getCommentsByQuestion($post['q'],$post['user']);$result = $this->load->view('frontend/_get_comments',$this->data,true);
	         }*/
			  $this->data['CommentsList']=$this->Question_model->getCommentsByQuestion($post['q'],$post['user']);$result = $this->load->view('frontend/_get_comments',$this->data,true);
			// echo "<pre>"; print_r($this->data['CommentsList']); exit;
			  echo $result;exit;
			}

	 }
	
	
	public function success()
   {
		if($this->input->post())
		{
             $urifield='';
			 $post = $this->input->post();
             if(isset($post))
			 { 
				     $payment_id     = $post['mihpayid'];
			   	     $idDetails      = explode('_',$post['txnid']);
				     $this->Common_model->update_table('tr_tb_user',array('subscription_id'=>$post['udf1']),array('id' =>$this->userID)); 
					 $this->Common_model->update_table('rt_tb_transactions',array('txn_uid'=>$post['mihpayid'],'status'=>'SUCCESS'),array('id' =>$idDetails[1])); 
					 $this->data['session_details'] = $this->session->all_userdata();
					 $this->data['session_details']['USER_SUB_ID']=$post['udf1'];
					 $this->session->set_userdata($this->data['session_details']);
					 $this->session->set_flashdata('message', '<span style="color:green">Payment Successful.You are now eligible for commenting.</span>');
					 redirect(base_url()); exit;
			 }
			 else redirect(base_url('main/cancel')); exit;
		}
		redirect(base_url('main/cancel')); exit;
	}

       public function add_testimonial()
	  {
		$this->isLoggedIn();
		if($this->input->post())
		{	
		$post = $this->input->post();
		//echo "<pre>"; print_r($post); exit;
		$this->Common_model->insert_table('rt_tb_testmonials',array('user_id'=>$this->userID,'designation'=>$post['designation'],'message'=>$post['message']));
		$this->session->set_flashdata('message', '<span style="color:green">Testimonial Successfully Added.</span>');
		 redirect(base_url('main/add_testimonial')); exit;
		}
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/add-testimonial',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	}

	public function contact_us()
	{
	//	$this->data['menu']         =  $this->menu;
		
		if($this->input->post())
		{	
			$contact_data=$this->input->post();
			if($contact_data['fname']!='' && $contact_data['mobile']!='' && $contact_data['email']!='' && $contact_data['message']!='')
			{
			$config['mailtype'] = 'html';
			$config['charset']  = 'utf-8';
			$email_data = array('<#FNAME#>'			=>	$contact_data['fname'],
								'<#LNAME#>'			=>	$contact_data['lname'],
								'<#EMAIL#>'		    =>	$contact_data['email'],
								'<#MOBILE#>'		=>	$contact_data['mobile'],
								'<#MESSAGE#>'	    =>	$contact_data['message'],
							);
			$this->load->library('common');			
			$message  = $this->common->getEmailText($email_data,'contact.txt');
	
			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->from($this->config->item('mail_from'), $this->config->item('from_name'));
			$this->email->to('sai@vnexgen.com'); 
			$this->email->bcc('sai@vnexgen.com'); 
			$this->email->subject($message[0]);
			$this->email->message($message[1]);
			$this->email->send();
			echo json_encode(array('response' => 'success'));exit;
			}
			//echo $this->email->print_debugger();
	
		}
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/contact-us',$this->data);
		$this->load->view('frontend/includes/footer',$this->data['footerLinks']);
		
	}

    
     public function privacy_policy()
	 {
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/privacy_policy',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	 }
	 
	 public function terms_conditions()
	 {
		$this->load->view('frontend/includes/header',$this->data);
		$this->load->view('frontend/terms_conditions',$this->data);
		$this->load->view('frontend/includes/footer',$this->data);
	 }
	 
	 	public function profilePic()
	{
		$this->load->library('common');
		/*defined settings - start*/
		define('IMAGE_SMALL_DIR', 'uploaded/user/small/');
		define('IMAGE_SMALL_SIZE', 50);
		define('IMAGE_MEDIUM_DIR', 'uploaded/user/medium/');
		define('IMAGE_MEDIUM_SIZE', 250);
		/*defined settings - end*/
		
		if (isset($_FILES['image_upload_file'])) {
			$output['status'] = FALSE;
			set_time_limit(0);
			$allowedImageType = array(
				"image/gif",
				"image/jpeg",
				"image/pjpeg",
				"image/png",
				"image/x-png"
			);
			
			if ($_FILES['image_upload_file']["error"] > 0) {
				$output['error'] = "Error in File";
			} elseif (!in_array($_FILES['image_upload_file']["type"], $allowedImageType)) {
				$output['error'] = "You can only upload JPG, PNG and GIF file";
			} elseif (round($_FILES['image_upload_file']["size"] / 1024) > 4096) {
				$output['error'] = "You can upload file size up to 4 MB";
			} else {
				/*create directory with 777 permission if not exist - start*/
				$this->common->createDir(IMAGE_SMALL_DIR);
				$this->common->createDir(IMAGE_MEDIUM_DIR);
				/*create directory with 777 permission if not exist - end*/
				$path[0]     = $_FILES['image_upload_file']['tmp_name'];
				$file        = pathinfo($_FILES['image_upload_file']['name']);
				$fileType    = $file["extension"];
				$desiredExt  = 'jpg';
				$fileNameNew = rand(333, 999) . time() . ".$desiredExt";
				$path[1]     = IMAGE_MEDIUM_DIR . $fileNameNew;
				$path[2]     = IMAGE_SMALL_DIR . $fileNameNew;
				
				if ($this->common->createThumb($path[0], $path[1], $fileType, IMAGE_MEDIUM_SIZE, IMAGE_MEDIUM_SIZE, IMAGE_MEDIUM_SIZE)) {
					
					if ($this->common->createThumb($path[1], $path[2], "$desiredExt", IMAGE_SMALL_SIZE, IMAGE_SMALL_SIZE, IMAGE_SMALL_SIZE)) {
						$output['status']       = TRUE;
						$output['image_medium'] = $path[1];
						$output['image_small']  = $path[2];
					    $this->Common_model->update_table('tr_tb_user',array('pic' =>$path[1]),array('id' => $this->userID));
						$array = array(	'pic' 	     => $path[1]);
						$this->session->set_userdata($array);
					}
				}
			}
			echo json_encode($output);
		}	
	}
	
}
