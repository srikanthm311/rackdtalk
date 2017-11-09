<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



require_once(APPPATH.'controllers/Superadmin.php');

class Superadmincategory extends Superadmin {

	

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

						

			if(isset($post['name']) && !empty($post['name']))

			$condition_array['name'] = $post['name'];	

				

			if(isset($post['recordPerPage']) && !empty($post['recordPerPage']))

			$this->recordsperpage = $post['recordPerPage'];

		}

		$condition_array['limit'] = $currentPage;

		$condition_array['recordsperpage'] = $this->recordsperpage;

		

		$this->load->model('Category_model');

		$this->data['CategoriesCount'] = $this->Category_model->getAllCategoriesCount($condition_array);

		$this->data['Categories'] = $this->Category_model->getAllCategories($condition_array);

		$this->data['recordsperpage'] = $this->recordsperpage;

		

		$this->load->library('pagination');

		$config['base_url'] = base_url('superadmincategory/index/');

		$config['total_rows'] = $this->data['CategoriesCount'];

		$config['per_page'] = $this->recordsperpage; 	

		$this->pagination->initialize($config); 		

		$this->data['paginationLinks'] = $this->pagination->create_links();

				

		$this->load->view('superAdmin/header', $this->data);

		$this->load->view($this->folder.'/side-bar');

		 $this->load->view('superAdmin/category/index',$data);

		$this->load->view('superAdmin/footer', $this->data);

	}

	

	public function add_category($cat_id = '')

	{

		$this->is_logged_in();

		$this->load->helper('form');

		$this->load->model('Category_model');	
		$this->load->model('Common_model');

		$this->load->library('common');

		if($this->input->post())

		{
			
			$post = $this->input->post();
			//echo "<pre>"; print_r($post); exit;
			if($_FILES['cat_image']['tmp_name']!= ''){
				//echo 'file';
				//echo "<pre>"; print_r($post); exit;
				$imageFileType = pathinfo($_FILES['cat_image']['name'],PATHINFO_EXTENSION);
				if(($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif")|| $_FILES["cat_image"]["size"] > 26214400) 
				{
				 $this->session->set_flashdata('message', '<span style="color:red">Invalid File Extension/Size for Question Gif.</span>');
				 redirect(base_url('superadmin/add_category'));exit;
				}
				
				$hsourcePath = $_FILES['cat_image']['tmp_name'];
				$htargetPath = "uploaded/category/".$this->superadminID.'-'.time().'.'.$imageFileType; 
				move_uploaded_file($hsourcePath,$htargetPath) ;
				$post['cat_image_soure']=$htargetPath;
				}

			if($post['id'])

			{
				if($post['cat_image_soure'] =='')
				$data = array('category_name' => $post['name'],'category_name_hi' => $post['name_hi'],'is_active' => $post['status'],'updated_at' => date('Y-m-d H:i:s'));
				else{
					$data = array('category_name' => $post['name'],'category_name_hi' => $post['name_hi'],'image'=>$post['cat_image_soure'],'is_active' => $post['status'],'updated_at' => date('Y-m-d H:i:s'),'created_by' => $this->superadminID);
					}
					//echo "<pre>"; print_r($data); exit;
				$this->Common_model->update_table('rt_tb_category',$data,array('id' => $post['id']));

			}

			else

			{

				$this->Category_model->insertCategory($post);

			}

			redirect('superadmincategory'); 

			exit;

		}

		

		if(!empty($cat_id))

			$this->data['category'] = array_shift($this->Category_model->getAllCategories(array('id' => $cat_id)));

		else if($this->input->post())

			$this->data['category'] = $this->input->post();

		else

			$this->data['category'] = array();

		

		$this->load->view('superAdmin/header', $this->data);

		$this->load->view($this->folder.'/side-bar');

		$this->load->view('superAdmin/category/addcategory', $this->data);

		$this->load->view('superAdmin/footer', $this->data);

	}

	

	public function deletecategory($cat_id = '')

	{

		$this->is_logged_in();

		if(!empty($cat_id))

		$this->Common_model->update_table('rt_tb_category',array('is_delete' => 1),array('id' => $cat_id));

		redirect('superadmincategory'); 

		exit;

	}

	

	function updateMenuStatus()

	{

			$this->load->helper('form');

			if($this->input->post())

			{

				$post = $this->input->post();

				if( isset($post['catID']) && !empty($post['catID']) )

				{

		            $this->Common_model->update_table('rt_tb_category',array('is_active' => $post['status']),array('id' => $post['catID']));

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

	



}

