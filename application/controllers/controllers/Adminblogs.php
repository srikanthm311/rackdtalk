<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Admin.php');
class Adminblogs extends Admin {
	
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
				
				
			if(isset($post['price']) && !empty($post['price']))
			$condition_array['price'] = $post['price'];
				
			if(isset($post['recordPerPage']) && !empty($post['recordPerPage']))
			$this->recordsperpage = $post['recordPerPage'];
		}
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		
		$this->load->model('Blogs_model');
		$this->data['blogsCount'] = $this->Blogs_model->getAllBlogsCount($condition_array);
		$this->data['blogs'] = $this->Blogs_model->getAllBlogs($condition_array);
		$this->data['recordsperpage'] = $this->recordsperpage;
		
		$this->load->library('pagination');
		$config['base_url'] = base_url('adminblogs/index/');
		$config['total_rows'] = $this->data['blogsCount'];
		$config['per_page'] = $this->recordsperpage; 	
		$this->pagination->initialize($config); 		
		$this->data['paginationLinks'] = $this->pagination->create_links();
				
		$this->load->view('admin/header', $this->data);
		$this->load->view($this->folder.'/side-bar');
		 $this->load->view('admin/blogs/index',$data);
		$this->load->view('admin/footer', $this->data);
	}
	
	public function add_blog($store_id = '')
	{
		$this->is_logged_in();
		$this->load->helper('form');
		$this->load->model('Blogs_model');	
		if($this->input->post())
		{
			if($this->input->post('id'))
			{
				$this->Blogs_model->updateBlog($this->input->post());
			}
			else
			{
				$this->Blogs_model->insertBlog($this->input->post());
			}
			redirect('adminblogs'); 
			exit;
		}
		
		if(!empty($store_id))
			$this->data['blog'] = array_shift($this->Blogs_model->getAllBlogs(array('id' => $store_id)));
		else if($this->input->post())
			$this->data['blog'] = $this->input->post();
		else
			$this->data['blog'] = array();
		$this->load->view('admin/header', $this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view('admin/blogs/addblog', $this->data);
		$this->load->view('admin/footer', $this->data);
	}
	
	public function deleteblog($id = '')
	{
		$this->is_logged_in();
		if(!empty($id))
			 $this->Common_model->update_table('tbl_blogs',array('is_deleted' => 1),array('id' => $id));
		redirect('adminblogs'); 
		exit;
	}
	
	
	function updateBlogStatus()
	{
			$this->load->helper('form');
			if($this->input->post())
			{
				$post = $this->input->post();
				if( isset($post['ID']) && !empty($post['ID']) )
				{
		            $this->Common_model->update_table('tbl_blogs',array('is_active' => $post['status']),array('id' => $post['ID']));
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
