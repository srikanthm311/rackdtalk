<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



require_once(APPPATH.'controllers/Superadmin.php');

class Superadminusers extends Superadmin {

	

	public function __construct()

	{

		parent::__construct();

	}

	

	public function index()

	{

		$this->is_logged_in();

		$condition_array = array();

		if($this->input->post())

		{

			$post = $this->input->post();

						

			if(isset($post['first_name']) && !empty($post['first_name']))

			$condition_array['first_name'] = $post['first_name'];

						

			if(isset($post['last_name']) && !empty($post['last_name']))

			$condition_array['last_name'] = $post['last_name'];	

			

			if(isset($post['username']) && !empty($post['username']))

			$condition_array['username'] = $post['username'];	

			

			if(isset($post['mobile']) && !empty($post['mobile']))

			$condition_array['mobile'] = $post['mobile'];	

			

			if(isset($post['address']) && !empty($post['address']))

			$condition_array['address'] = $post['address'];	

				

			if(isset($post['recordPerPage']) && !empty($post['recordPerPage']))

			$this->recordsperpage = $post['recordPerPage'];

		}

		$condition_array['limit'] = $currentPage;

		$condition_array['recordsperpage'] = $this->recordsperpage;

		

		$this->load->model('Users_model');

		$this->data['usersCount'] = $this->Users_model->getAllUsersCount($condition_array);

		$this->data['users'] = $this->Users_model->getAllUsers($condition_array);

		$this->data['recordsperpage'] = $this->recordsperpage;

		

		$this->load->library('pagination');

		$config['base_url'] = base_url('superAdminusers/index/');

		$config['total_rows'] = $this->data['usersCount'];

		$config['per_page'] = $this->recordsperpage; 	

		$this->pagination->initialize($config); 		

		$this->data['paginationLinks'] = $this->pagination->create_links();

				
		//echo '<pre>';print_r($this->data['users']);exit;
		$this->load->view('superAdmin/header', $this->data);

		$this->load->view($this->folder.'/side-bar');

		 $this->load->view('superAdmin/users/index',$data);

		$this->load->view('superAdmin/footer', $this->data);

	}

	

	public function add_user($user_id = '')

	{

		$this->is_logged_in();

		$this->load->helper('form');
		$this->load->helper('string');
		$this->load->model('Users_model');
		$this->load->model('Common_model');	

		//$this->load->model('Locations_model');	

		if($this->input->post())
		{
			
			if($this->input->post('is_delted') == 1)$is_delete = 1;else $is_delete = 0;
			if($this->input->post('is_active') != '')$is_active = 1;else $is_active = 0;
			if($this->input->post('id'))
			{
				 $data = array('role_id' => $this->input->post('role'),'user_uid' => $user_uid,'first_name'=>$this->input->post('first_name'),'last_name'=>$this->input->post('last_name'),'mobile'=>$this->input->post('mobile'),'street_address'=>$this->input->post('address'),'city'=>$this->input->post('city'),'country'=>$this->input->post('country'),'state'=>$this->input->post('state'),'pin_code'=>$this->input->post('zipcode'),'is_active' => $is_active,'is_delete' => $is_delete);
				 //echo '<pre>';print_r($data);exit;
				 $this->Common_model->update_table('tr_tb_user',$data,array('id' => $this->input->post('id')));
				 $this->Common_model->delete_rows('rt_tb_rights',array('user_id' => $this->input->post('id')));
					foreach($this->input->post('questionsRight') as $key => $value){
						$right = array('user_id'=>$this->input->post('id'),'value'=>$value);
						$this->Common_model->insert_table('rt_tb_rights',$right,'');
					}
			}
			else
			{
				$exists = $this->Common_model->get_table_row('tr_tb_user',array('email_id' => $this->input->post('email')),array('email_id'));
					   if(!empty($exists))
					   {
						$this->session->set_flashdata('message', '<span style="color:red; text-align:center; display: block;">'.$this->input->post('email'). ' is already exists</span>');
					   }
					   else{
				 $pwd=rand(99,99999);
				 $user_uid = random_string('alnum', 6);
				 $brcE     =  substr(rand(1,1000000),0,3); 
				 $brchrE  =   substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUXYVWZ"), 0, 3); 
				 $email_verify_code =  $brchrE.$brcE;
				 $data = array('role_id' => $this->input->post('role'),'user_uid' => $user_uid,'email_id' => $this->input->post('email'),'password'=>md5($pwd),'first_name'=>$this->input->post('first_name'),'last_name'=>$this->input->post('last_name'),'mobile'=>$this->input->post('mobile'),'street_address'=>$this->input->post('address'),'city'=>$this->input->post('city'),'country'=>$this->input->post('country'),'state'=>$this->input->post('state'),'pin_code'=>$this->input->post('zipcode'),'is_active' => $is_active,'is_delete' => $is_delete,'varification_code' => $email_verify_code);
				
				        $user=$this->Superadmin_model->createUser($data);
						
						foreach($this->input->post('questionsRight') as $key => $value){
						$right = array('user_id'=>$user,'value'=>$value);
						$this->Common_model->insert_table('rt_tb_rights',$right,'');
						}
					    if($user != '')
					    {
							   
							    $this->load->library('common');
					            $config['mailtype'] = 'html';
								$config['charset']  = 'utf-8';
					            $unique 		=	 urlencode(base64_encode($email_verify_code));
								$email_data = array('<#USERNAME#>'		=>	$this->input->post('email'),
													'<#PASSWORD#>'		=>	$pwd,
													'<#SITE#>'			=>	base_url(),
											     	'<#VERIFY#>'		=>	base_url('main/verifyaccount/'.$user.'-'.$email_verify_code),
													'<#BASEURL#>'		=>	base_url(),
												);
								$message  = $this->common->getEmailText($email_data,'account-creation.txt');
								$this->load->library('email');
								$this->email->initialize($config);
								$this->email->from($this->config->item('mail_from'), $this->config->item('from_name'));
								$this->email->to($this->input->post('email')); 
								$this->email->bcc('malyala@vnexgen.com');
								$this->email->subject($message[0]);
								$this->email->message($message[1]);
								$this->email->send();
						}
						
							redirect('superadminusers/index');  exit;
				}
			}
			
		}

		if(!empty($user_id)){

			$this->data['user'] = array_shift($this->Users_model->getAllUsers(array('id' => $user_id)));
			$this->data['rights'] = $this->Admin_model->getRights($user_id);
		}

		else if($this->input->post())
{
			$this->data['user'] = $this->input->post();
			
}
		else
		$this->data['user'] = array();
		$this->data['states']=$this->Common_model->get_table('rt_tb_states','','*','','','','');
		$this->data['cities']=$this->Common_model->get_table('rt_tb_cities','','*','','','','');
		//echo '<pre>';print_r($this->data['rights']);exit;
		$this->load->view('superAdmin/header', $this->data);

		$this->load->view($this->folder.'/side-bar');

		$this->load->view('superAdmin/users/adduser', $this->data);

		$this->load->view('superAdmin/footer', $this->data);

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

	public function deleteuser($id = '')

	{

		$this->is_logged_in();

		if(!empty($id))

			 $this->Common_model->update_table('tr_tb_user',array('is_delete' => 1),array('id' => $id));

		redirect('superadminusers'); 

		exit;

	}
	
	
	function userActivities($user_id,$roleId)
	{
		
		if($this->input->post())
		{
			$post = $this->input->post();
			if(isset($post['from']) && !empty($post['from']))
			$condition_array['from'] = $post['from'];
			if(isset($post['to']) && !empty($post['to']))
			$condition_array['to'] = $post['to'];	
			if(isset($post['recordPerPage']) && !empty($post['recordPerPage']))
			$this->recordsperpage = $post['recordPerPage'];
		}
		$condition_array['user_id'] = $user_id;	
		if($roleId==3)
		{
		$role='user';
		$this->data['useractivities']=$this->Superadmin_model->userActivity($condition_array);
		}
		else
		{
		$role='admin';
		$this->data['adminactivities']=$this->Superadmin_model->adminActivity($condition_array);	
		}
		$this->data['post']=$post;
		
		//echo '<pre>';print_r($this->data['useractivities']);
		$this->load->view('superAdmin/header', $this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view('superAdmin/users/'.$role.'activies', $this->data);
		$this->load->view('superAdmin/footer', $this->data);
		
	}


	function updateUserStatus()

	{

			$this->load->helper('form');

			if($this->input->post())

			{

				$post = $this->input->post();

				if( isset($post['ID']) && !empty($post['ID']) )

				{

		            $this->Common_model->update_table('tr_tb_user',array('is_active' => $post['status']),array('id' => $post['ID']));

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
	
	public function seetable()
	{
	$this->data['allstores']=$this->Common_model->get_table('rt_tb_rights',array(),array('*'),'','','','');
	//$this->data['rowsexample']=$this->Users_model->seetable('coupon_stores',array(),array('*'),'','');
	//$this->data['rowsexample']=$this->Users_model->seetable();
	echo '<pre>'; print_r($this->data['allstores']); exit;
	}

}

