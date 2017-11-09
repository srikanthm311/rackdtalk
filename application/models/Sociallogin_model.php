<?php



class Sociallogin_model extends CI_Model {


	function __construct(){
		 parent::__construct();

	}

	function ifUserExists($data)
	{
		if($this->db->get_where("tr_tb_user",array("email_id"=>$data["email"]))->num_rows()>0)
		{
			if($this->db->get_where("tr_tb_user",array("email_id"=>$data["email"], "is_active"=>1))->num_rows()>0)
				return 1;
			else
				return -1;
		}
		else
			return 0;
	}



	function Login($data)
	{
		$user = $this->db->get_where("tr_tb_user",array("email_id"=>$data["email"]))->result();
		if($user)
		{
			$array = array(
						'USER_ID'	 => $user[0]->id,
						'USER_EMAIL' 	 => $user[0]->email_id,
						'USER_NAME'	 => $user[0]->first_name.' '.$user[0]->last_name,
						'USER_MOBILE' 	 => $user[0]->mobile,
						'USER_SUB_ID' 	 => $user[0]->subscription_id,
					);
			$this->session->set_userdata($array);
			$userid = $user[0]->id;
			$data = array("fuser_loggedin"=>true,"fuser_id"=> $userid);
			$this->session->set_userdata($data);
		}
		redirect(base_url());
	}



	function RegisterUser($user,$type)
	{

		if($type=="google")
		{
		/*	$url = $user["picture"];
			$path="./uploaded/users/";
			$img = 'gplus-'.time().'.jpg';
			file_put_contents($path.$img, file_get_contents($url));
			$config['image_library'] = 'gd2';
			$config['source_image']	= $path.$img;
			$config['create_thumb'] = TRUE;
			$config['thumb_marker'] = '';
			//$config['new_image'] = $path.'original/'.$img;
			$config['maintain_ratio'] = TRUE;
			$config['width']	= 200;
			$config['height']	= 150;
			$this->load->library('image_lib', $config); 
			$this->image_lib->resize();*/
			$pwd= substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
			$this->db->insert('tr_tb_user',array(
												"email_id"=> $user["email"],
												"password"=>md5($pwd),
												"user_uid"=>$pwd,
												"role_id"=>3,
												"first_name"=> $user["name"],
												"verification_at"=> date('Y-m-d H:i:s'),
												/*"pic"=>"uploaded/user/".$img,*/
												"is_active"=>1,
												));

			$userid = $this->db->insert_id();
			$data = array("fuser_loggedin"=>true,"fuser_id"=> $userid			);
			$this->session->set_userdata($data);
			$array = array(
						'USER_ID'	 => $userid,
						'USER_EMAIL' 	 => $user['email'],
						'USER_NAME'	 => $user['name'],
						'USER_MOBILE' 	 => $user['mobile'],
						'USER_SUB_ID' 	 => $user['USER_SUB_ID'],
					);

					$this->session->set_userdata($array);
			        $this->load->library('common');		
					$config['mailtype'] = 'html';
					$config['charset']  = 'utf-8';
					$email_data = array('<#USERNAME#>'	=>	$user['email'],
													'<#PASSWORD#>'		=>	$pwd,
													'<#SITE#>'			=>	base_url(),
											     	'<#VERIFY#>'		=>	base_url('main/verifyaccount/'.$userid),
													'<#BASEURL#>'		=>	base_url(),
					);

					$message  = $this->common->getEmailText($email_data,'account-creation.txt');
                 	$this->load->library('email');
					$this->email->initialize($config);
					$this->email->from($this->config->item('mail_from'), $this->config->item('from_name'));
					$this->email->to($user['email']); 
					$this->email->bcc('sai@vnexgen.com');  
					$this->email->subject($message[0]);
					$this->email->message($message[1]);
					$this->email->send();
			        redirect(base_url());

		}
		else if($type=="facebook")
		{
			$url = "https://graph.facebook.com/".$user['id']."/picture?type=large";
			$path="./uploaded/user/small/";			$img = time().'.jpg';
			$pwd= substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
       	    file_put_contents($path.$img, file_get_contents($url));			file_put_contents($path."medium/".$img, file_get_contents($url));
			$this->db->insert('tr_tb_user',array(
												"email_id"=> $user["email"],
												"password"=>md5($pwd),
												"user_uid"=>$pwd,
												"role_id"=>3,
												"pic"=>  "uploaded/user/small/".$img,
												"first_name"=> $user["name"],
												"verification_at"=> date('Y-m-d H:i:s'),
												"is_active"=>1,
												));

			$userid = $this->db->insert_id();
			$data = array("fuser_loggedin"=>true,"fuser_id"=> $userid);

			$this->session->set_userdata($data);
			$usrarray = array('USER_ID'	 => $userid,'USER_EMAIL' => $user['email'],'USER_NAME'=> $user['name'],'USER_MOBILE' => $user['mobile'],'USER_SUB_ID' 	 => $user['USER_SUB_ID']);
		    $this->session->set_userdata($usrarray);

			                    $this->load->library('common');		
					            $config['mailtype'] = 'html';
								$config['charset']  = 'utf-8';
								$email_data = array('<#USERNAME#>'		=>	$user['email'],
													'<#PASSWORD#>'		=>	$pwd,
													'<#SITE#>'			=>	base_url(),
											     	'<#VERIFY#>'		=>	base_url('main/verifyaccount/'.$userid),
													'<#BASEURL#>'		=>	base_url(),
												);

								$message  = $this->common->getEmailText($email_data,'account-creation.txt');
								$this->load->library('email');
								$this->email->initialize($config);
								$this->email->from($this->config->item('mail_from'), $this->config->item('from_name'));
								$this->email->to($user['email']); 
								$this->email->bcc('sai@vnexgen.com');  
								$this->email->subject($message[0]);
								$this->email->message($message[1]);
								$this->email->send();
			       redirect(base_url());
		}
	}

}