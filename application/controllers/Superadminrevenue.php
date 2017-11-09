<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Superadmin.php');
class Superadminrevenue extends Superadmin {


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
		$this->data['revenueData'] = $this->Superadmin_model->getRevenue($condition_array);
		$this->data['post']=$post;
		//echo '<pre>';print_r($this->data['revenueData']);exit;
		$this->load->view('superAdmin/header', $this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view('superAdmin/revenue/index',$data);
		$this->load->view('superAdmin/footer', $this->data);
	}


}

