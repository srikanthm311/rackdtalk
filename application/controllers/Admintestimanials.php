<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(0);
require_once(APPPATH.'controllers/Admin.php');
class Admintestimanials extends Admin {
    public $folder = 'admin';
	public $data = array();
	private $recordsperpage;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model');
	}
    public function index($currentPage = 0)
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

		redirect('admin/testimanials');

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
	//home end
}
