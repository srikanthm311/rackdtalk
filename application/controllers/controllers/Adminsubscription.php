<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(0);
require_once(APPPATH.'controllers/Admin.php');
class Adminsubscription extends Admin {
    public $folder = 'admin';
	public $data = array();
	private $recordsperpage;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Superadmin_model');
	}
    public function index()
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
			redirect('adminsubscription');  exit;
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

		redirect('adminsubscription');

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
                        $this->Common_model->update_table('settings',array('value'=>$postval),array('key'=>$postKey));redirect('admin/settings'); 				
			//echo "<pre>"; print_r($post); exit;
		}
		$settings  = $this->Common_model->get_table('settings');
                foreach($settings as $settingKey=> $val)
                $this->data['settings'][$val['key']]=$val['value'];
               // echo "<pre>"; print_r($this->data['settings']); exit;
		$this->load->view($this->folder.'/settings',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	//home end
}
