<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
	public $data=array();
	public $userID;
	public $recordsperpage;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_model');
	}

	public function updateIfBidClosed()
	{
	
    $bidclosedqns=$this->Common_model->query_array('select id from rt_tb_question where DATE(`bidding_closed_at`) < DATE(NOW()) AND is_approved=1 AND is_active=1 AND is_delete=0');
		foreach($bidclosedqns as $question)
		{
		$this->Common_model->update_table('rt_tb_question_comment',array('is_biddable'=> 0),array('qusetion_id' => $question['id']));
		}
	}
	
	
	
}