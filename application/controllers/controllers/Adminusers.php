<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



require_once(APPPATH.'controllers/Admin.php');

class Adminusers extends Admin {

	

	public function __construct()

	{

		parent::__construct();
		if(!isset($this->data['rights'][$this->router->fetch_class()]))
        redirect('admin/dashboard'); 
		

	}

	

	public function index()

	{

		$this->is_logged_in();
		$this->varify_admin_rights();
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

		$config['base_url'] = base_url('Adminusers/index/');

		$config['total_rows'] = $this->data['usersCount'];

		$config['per_page'] = $this->recordsperpage; 	

		$this->pagination->initialize($config); 		

		$this->data['paginationLinks'] = $this->pagination->create_links();

				

		$this->load->view($this->folder.'/header', $this->data);

		$this->load->view($this->folder.'/side-bar');

		 $this->load->view($this->folder.'/users/index',$data);

		$this->load->view($this->folder.'/footer', $this->data);

	}

	

	public function add_user($user_id = '')

	{

		$this->is_logged_in();
		$this->varify_admin_rights();

		$this->load->helper('form');
		$this->load->helper('string');
		$this->load->model('Users_model');
		$this->load->model('Admin_model');
		$this->load->model('Common_model');	

		//$this->load->model('Locations_model');	

		if($this->input->post())
		{
			//echo '<pre>';print_r($this->input->post());exit;
			
			if($this->input->post('is_delted') == 1)$is_delete = 1;else $is_delete = 0;
			if($this->input->post('is_active') != '')$is_active = 1;else $is_active = 0;
			if($this->input->post('id'))
			{
				 $data = array('role_id' => $this->input->post('role'),'user_uid' => $user_uid,'first_name'=>$this->input->post('first_name'),'last_name'=>$this->input->post('last_name'),'mobile'=>$this->input->post('mobile'),'street_address'=>$this->input->post('address'),'city'=>$this->input->post('city'),'country'=>$this->input->post('country'),'state'=>$this->input->post('state'),'pin_code'=>$this->input->post('zipcode'),'is_active' => $is_active,'is_delete' => $is_delete);
				 //echo '<pre>';print_r($data);exit;
				 $this->Common_model->update_table('tr_tb_user',$data,array('id' => $this->input->post('id')));
			}
			else
			{
				 $pwd=rand(99,99999);
				 $user_uid = random_string('alnum', 6);
				 $data = array('role_id' => $this->input->post('role'),'user_uid' => $user_uid,'email_id' => $this->input->post('email'),'password'=>md5($pwd),'first_name'=>$this->input->post('first_name'),'last_name'=>$this->input->post('last_name'),'mobile'=>$this->input->post('mobile'),'street_address'=>$this->input->post('address'),'city'=>$this->input->post('city'),'country'=>$this->input->post('country'),'state'=>$this->input->post('state'),'pin_code'=>$this->input->post('zipcode'),'is_active' => $is_active,'is_delete' => $is_delete);
				//echo '<pre>';print_r($data);exit;
				$user=$this->Admin_model->createUser($data);

				
				
				                $this->load->library('common');
								$config['mailtype'] = 'html';
								$config['charset']  = 'utf-8';
								$unique 		=	 urlencode(base64_encode($user));
				                $email_data =         array('<#USERNAME#>'		=>	$this->input->post('userName'),
													'<#PASSWORD#>'		=>	$pwd,
													'<#SITE#>'			=>	base_url(),
											     	'<#VERIFY#>'		=>	base_url('main/verifyaccount/'.$unique),
												);
								$message  = $this->common->getEmailText($email_data,'account-creation.txt');

								$this->load->library('email');
								$this->email->initialize($config);
								$this->email->from($this->config->item('mail_from'), $this->config->item('from_name'));
								$this->email->to($this->input->post('user_name')); 
								$this->email->bcc('malyala@vnexgen.com');
								$this->email->subject($message[0]);
								$this->email->message($message[1]);
								$this->email->send();
				
				
			}
			redirect('adminusers/index');  exit;
		}

		if(!empty($user_id)){

			$this->data['user'] = array_shift($this->Users_model->getAllUsers(array('id' => $user_id)));
		}

		else if($this->input->post())

			$this->data['user'] = $this->input->post();

		else

			$this->data['user'] = array();
//echo '<pre>';print_r($this->data['user']);exit;
		$this->load->view($this->folder.'/header', $this->data);

		$this->load->view($this->folder.'/side-bar');

		 $this->load->view($this->folder.'/users/adduser',$data);

		$this->load->view($this->folder.'/footer', $this->data);

	}

	

	public function deleteuser($id = '')

	{

		$this->is_logged_in();

		if(!empty($id))

			 $this->Common_model->update_table('tr_tb_user',array('is_delete' => 1),array('id' => $id));

		redirect('adminusers'); 

		exit;

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
	$this->data['allstores']=$this->Common_model->get_table('tr_tb_user',array(),array('*'),'','','','');
	//$this->data['rowsexample']=$this->Users_model->seetable('coupon_stores',array(),array('*'),'','');
	//$this->data['rowsexample']=$this->Users_model->seetable();
	echo '<pre>'; print_r($this->data['allstores']); exit;
	}

}

