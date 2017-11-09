<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Superadmin.php');
class Superadminwithdraw extends Superadmin {


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
			if(isset($post['from']) && !empty($post['from']))
			$condition_array['from'] = $post['from'];
			if(isset($post['to']) && !empty($post['to']))
			$condition_array['to'] = $post['to'];	
			if(isset($post['recordPerPage']) && !empty($post['recordPerPage']))
			$this->recordsperpage = $post['recordPerPage'];
		}
		$this->load->model('Superadmin_model');
		$this->data['withdrawData'] = $this->Superadmin_model->getwithdraw($condition_array);
		$this->data['post']=$post;
		//echo '<pre>';print_r($this->data['withdrawData']);exit;
		$this->load->view('superAdmin/header', $this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view('superAdmin/withdraw/index',$data);
		$this->load->view('superAdmin/footer', $this->data);
	}
	
	function approve_withdraw()
	{
			$this->load->helper('form');
			if($this->input->post())
			{
				$post = $this->input->post();
				$condition_array['id'] = $post['ID'];
				if( isset($post['ID']) && !empty($post['ID']) )
				{
					$withdraw = array_shift($this->Superadmin_model->getwithdraw($condition_array));
					$withdraw['txn_uid'] = rand(1,9999999999999);
		            $this->Common_model->update_table('rt_tb_withdraw',array('status' => 'SUCCESS','approved_at'=>date('Y-m-d H:i:s')),array('id' => $post['ID']));
					$data_transaction = array('user_id' => $withdraw['user_id'], 'comment'=>0,'user_type'=>$withdraw['type'],'txn_uid' =>$withdraw['txn_uid'],'amount'=>$withdraw['amount'],'type'=>'withdraw','txn_type'=>'debit','is_refunded'=>'NO','status'=>'SUCCESS','created_at'=>date('Y-m-d H:i:s'));
					//echo '<pre>';print_r($data_transaction);exit;
					$this->Common_model->insert_table('rt_tb_transactions',$data_transaction);
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
	


}

