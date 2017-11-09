<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(0);
class Admin extends CI_Controller {
    public $folder = 'admin';
	public $data = array();
	private $recordsperpage;
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->model('Admin_model');
		$this->load->model('Common_model');
		$this->load->model('Superadmin_model');
		$this->recordsperpage = 20;
		if($this->session->userdata('adminID'))
		{
			$this->adminID=$this->session->userdata('adminID');
			$this->data['rights'] = $this->Admin_model->getRights($this->adminID);
			
		}
		$this->data['countries']=$this->Common_model->get_table('rt_tb_countries','','*','','','','');
		$this->data['states']=$this->Common_model->get_table('rt_tb_states','','*','','','','');
		$this->data['cities']=$this->Common_model->get_table('rt_tb_cities','','*','','','','');
		
		//echo '<pre>';print_r($this->data['rights']);exit;
	}
	
	public function getNotifications($limit)
	{
		//$this->is_logged_in();
		$notifications=$this->Common_model->get_table('fhpl_notifications','','','notifyID','desc',$limit,0);
		$newdata=array();
		foreach($notifications as $notification)
		{
			switch($notification['category'])
			{
			 case 'News'	     : $subjectData  = $this->Common_model->get_table_row('fhpl_news',array('newsID' =>$notification['subjectID']),array('newsTitle as title'));break;
			 
			 case 'Health Camp'	 :$subjectData  = $this->Common_model->get_table_row('fhpl_health_camps',array('campID' =>$notification['subjectID']),array('uniqueCampID as title') );break;
			 
			 case 'News category':$subjectData  = $this->Common_model->get_table_row('fhpl_news_categories',array('ID' =>$notification['subjectID']),array('categoryName as title') );break;
			  case 'News Letters':$subjectData  = $this->Common_model->get_table_row('fhpl_news_letters',array('newsID' =>$notification['subjectID']),array('title') );break;
			 
			 case 'Health Tips'	: $subjectData  = $this->Common_model->get_table_row('fhpl_health_tips',array('campID' =>$notification['subjectID']),array('title') );break;
			 case 'News Letter'	: $subjectData  = $this->Common_model->get_table_row('fhpl_news_letters',array('newsID' =>$notification['subjectID']),array('title') );break;
			 case 'Events'	    : $subjectData  = $this->Common_model->get_table_row('fhpl_events',array('ID' =>$notification['subjectID']),array('title') );break;
			 case 'Testimonial' : $subjectData  = $this->Common_model->get_table_row('fhpl_testimonials',array('testID' =>$notification['subjectID']),array('company as title') );break;
			 case 'Clinics' : $subjectData  = $this->Common_model->get_table_row('fhpl_clinics',array('clinicID' =>$notification['subjectID']),array('name as title') );break;
			 case 'Dignostic centres' : $subjectData  = $this->Common_model->get_table_row('fhpl_diagncentres',array('dcID' =>$notification['subjectID']),array('location as title') );break;

			 default            :  $subjectData  = array();
			}
			$newdata[$notification['category']][]= '"'.$subjectData['title'].'" '.$notification['content'].' on '.$notification['createdDate'];
		}
		//echo '<pre>';print_r($newdata);exit;
		return $newdata;
	}
	protected function isAjaxRequest()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';
	}
	
    public function index()
	{
		if($this->input->post())
		{
			//echo '<pre>';print_r($this->input->post());exit;
			$user = $this->Admin_model->authenticate_user($this->input->post());
			if(count($user)>0)
			{
				$array = array(
							'adminID' => $user['id'],
							'adminemail' => $user['email_id'],
							'adminname' => $user['first_name'].' '.$user['last_name'],
							'loggedIN' => 'ADMIN',
							);
				$this->session->set_userdata($array);
				redirect(base_url('admin/dashboard'));
			}
			else $this->msg = 'Invalid Username/Password';
		}
		
		$this->load->view($this->folder.'/index');
		
	}
	
	protected function is_logged_in()
    {
        if($this->session->userdata('adminID')=='' ||  $this->session->userdata('adminname') == '' ||  $this->session->userdata('adminemail') == '' ) 
		{
			redirect(base_url('admin'));
		}
    }
	
	protected function varify_admin_rights()
    {
		
		$admin_id = $this->session->userdata('adminID');
       	$this->data['admin_rights'] = $this->Common_model->get_table('rt_tb_rights',array('user_id'=>$admin_id),array('value'),'','','','');
		$admin_url = $this->uri->segment(1);
		echo $admin_url;
		//echo "<pre>"; print_r($this->data['admin_rights']); exit;
		foreach($admin_rights as $right){
			if($right['value'] != $admin_url){
				redirect(base_url('admin/dashboard'));
			}
		}
   }
	
	public function logout()
    {
      $array_items = array('adminID' => '','adminname' => '', 'role' => '');
      $this->session->unset_userdata($array_items);
      redirect(base_url('admin'));
    }
	
	public function dashboard()
	{
		$this->is_logged_in();
		$cnd_arr['is_approved'] = 1;
		$cnd_arr['is_active'] = 1;
		$this->data['questions_count'] = $this->Superadmin_model->getQuestions_count('rt_tb_question',$cdn_arr,'');
		$this->data['users_count'] = array_shift($this->Common_model->query_array('select sum(case when `created_by` = 0 then 1 else 0 end) RegUsersCount, sum(case when created_by != 0 then 1 else 0 end) CreatedUsersCount from tr_tb_user where role_id=3'));
		//echo '<pre>';print_r($this->data['users_count']);exit;
        $this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/dashboard',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function countries($currentPage = 0)
	{
		$this->is_logged_in();
		if($this->input->post())
		{
			$post = $this->input->post();
			if(isset($post['country_title']) && !empty($post['country_title']))
				$cdn_arr['country_name'] = trim($post['country_title']);
			if(isset($post['identity']) && !empty($post['identity']))
				$cdn_arr['search_identity'] = $post['identity'];
		}
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		$this->data['countries'] = $this->Admin_model->getdata('rt_tb_countries',$cdn_arr,$condition_array);
		$this->data['countries_counts'] = $this->Admin_model->getdata_count('rt_tb_countries',$cdn_arr,$condition_array);
		$this->data['recordsperpage'] =  $this->recordsperpage;
		$this->load->library('pagination');
		$config['base_url'] = base_url('admin/countries/');
		$config['total_rows'] = $this->data['countries_counts'];
		$config['per_page'] = $this->recordsperpage;	
		$this->pagination->initialize($config);	
		$this->data['paginationLinks'] = $this->pagination->create_links();
		//echo "<pre>"; print_r($this->data); exit;
        $this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/countries',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function edit_country($cid = '')

	{
		$this->is_logged_in();
		if($this->input->post())
		{
			//echo "<pre>"; print_r($this->input->post()); exit;
			$cid = $this->Admin_model->updateCountry($this->input->post());
			}
		$this->data['country_details']  = $this->Common_model->get_table_row('rt_tb_countries',array('id' => $cid),'*','','','');
		//echo "<pre>"; print_r($this->data['country_details']); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/edit_country',$this->data);
		$this->load->view($this->folder.'/footer');
			
	}
	
	public function states($currentPage = 0)
	{
		$this->is_logged_in();
		if($this->input->post())
		{
			$post = $this->input->post();
			if(isset($post['state_title']) && !empty($post['state_title']))
				$cdn_arr['state_name'] = trim($post['state_title']);
			if(isset($post['country_id']) && !empty($post['country_id']))
				$cdn_arr['country_id'] = trim($post['country_id']);
			if(isset($post['identity']) && !empty($post['identity']))
				$cdn_arr['search_identity'] = $post['identity'];
		}
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		$this->data['states'] = $this->Admin_model->getdata('rt_tb_states',$cdn_arr,$condition_array);
		$this->data['states_counts'] = $this->Admin_model->getdata_count('rt_tb_states',$cdn_arr,$condition_array);
		$this->data['recordsperpage'] =  $this->recordsperpage;
		$this->load->library('pagination');
		$config['base_url'] = base_url('admin/states/');
		$config['total_rows'] = $this->data['states_counts'];
		$config['per_page'] = $this->recordsperpage;	
		$this->pagination->initialize($config);	
		$this->data['paginationLinks'] = $this->pagination->create_links();
        $this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/states_list',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function edit_state($sid = '')

	{
		$this->is_logged_in();
		if($this->input->post())
		{
			//echo "<pre>"; print_r($this->input->post()); exit;
			$sid = $this->Admin_model->updateState($this->input->post());
			}
		$this->data['state_details'] = $this->Common_model->get_table_row('rt_tb_states',array('id' => $sid),'*','','','');
		//echo "<pre>"; print_r($this->data['country_details']); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/edit_state',$this->data);
		$this->load->view($this->folder.'/footer');
			
	}
	public function cities($currentPage = 0)
	{
		$this->is_logged_in();
		if($this->input->post())
		{
			$post = $this->input->post();
			if(isset($post['city_title']) && !empty($post['city_title']))
				$cdn_arr['city_name'] = trim($post['city_title']);
			if(isset($post['country_id']) && !empty($post['country_id']))
				$cdn_arr['country_id'] = trim($post['country_id']);
			if(isset($post['state_id']) && !empty($post['state_id']))
				$cdn_arr['state_id'] = trim($post['state_id']);
			if(isset($post['identity']) && !empty($post['identity']))
				$cdn_arr['search_identity'] = $post['identity'];
		}
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		$this->data['cities'] = $this->Admin_model->getdata('rt_tb_cities',$cdn_arr,$condition_array);
		$this->data['cities_counts'] = $this->Admin_model->getdata_count('rt_tb_cities',$cdn_arr,$condition_array);
		$this->data['recordsperpage'] =  $this->recordsperpage;
		$this->load->library('pagination');
		$config['base_url'] = base_url('admin/cities/');
		$config['total_rows'] = $this->data['cities_counts'];
		$config['per_page'] = $this->recordsperpage;	
		$this->pagination->initialize($config);	
		if(!isset($cdn_arr['search_identity']))
		$this->data['paginationLinks'] = $this->pagination->create_links();
        $this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/cities_list',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function getstates()
	{
		$cnd_arr['country_id'] = $this->input->post('id');
		$this->data['states']=$this->Common_model->get_table('rt_tb_states',$cnd_arr,'*','','','','');
		echo json_encode($this->data['states']); exit;
		}
		
	public function ajax_getcities()
	{
		$cnd_arr['state_id'] = $this->input->post('id');
		$this->data['cities']=$this->Common_model->get_table('rt_tb_cities',$cnd_arr,'*','','','','');
		echo json_encode($this->data['cities']); exit;
		}
	public function edit_city($cityid = '')

	{
		$this->is_logged_in();
		if($this->input->post())
		{
			//echo "<pre>"; print_r($this->input->post()); exit;
			$cityid = $this->Admin_model->updateCity($this->input->post());
			}
		$this->data['city_details'] = $this->Common_model->get_table_row('rt_tb_cities',array('id' => $cityid),'*','','','');
		//echo "<pre>"; print_r($this->data['city_details']); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/edit_city',$this->data);
		$this->load->view($this->folder.'/footer');
	}
	
	public function  frequent_takers($currentPage = 0)
	{
		$this->is_logged_in();
		$this->data['frequent_takers']  = $this->Superadmin_model->getFrequentTakers();
		//echo "<pre>"; print_r($this->data['frequent_takers']); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/frequent_takers',$this->data);
		$this->load->view($this->folder.'/footer');
		
	}
	
	public function  trending_talkers($currentPage = 0)
	{
		$this->is_logged_in();
		$this->data['trendingt_takers']  = $this->Superadmin_model->getTrendingTalkers();
		//echo "<pre>"; print_r($this->data['trendingt_takers']); exit;
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		$this->load->view($this->folder.'/trending_talkers',$this->data);
		$this->load->view($this->folder.'/footer');
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
	
	public function notifications($currentPage = 0)
	{
		$this->is_logged_in();
		$this->load->view($this->folder.'/header',$this->data);
		$this->load->view($this->folder.'/side-bar');
		
		$condition_array = array();
		if($this->input->post())
		{
			$post = $this->input->post();
						
			if(isset($post['category']) && !empty($post['category']))
			$condition_array['category'] = trim($post['category']);
			if(isset($post['recordPerPage']) && !empty($post['recordPerPage']))
				$this->recordsperpage = $post['recordPerPage'];
		}	
		$condition_array['limit'] = $currentPage;
		$condition_array['recordsperpage'] = $this->recordsperpage;
		//echo "<pre>"; print_r($condition_array); exit;
		$this->data['notificationsCount']  = $this->Admin_model->getAllNotificationsCount($condition_array);
		$this->data['notifications']       = $this->Admin_model->getAllNotifications($condition_array);
		$this->data['recordsperpage'] = $this->recordsperpage;
	
		
		$this->load->library('pagination');
		$config['base_url'] = base_url('admin/notifications/');
		$config['total_rows'] = $this->data['notificationsCount'];
		$config['per_page'] = $this->recordsperpage; 		
		$this->pagination->initialize($config); 		
		$this->data['paginationLinks'] = $this->pagination->create_links();
		$this->load->view($this->folder.'/notifications',$this->data);
		$this->load->view($this->folder.'/footer');
	}

	public function uploadImage(){
		
		require_once("SimpleImage.class.php");
		$path = "uploaded/".$_REQUEST['pathfolder'].'/';
		$allowTypes = array('xls','xlsx','pdf','csv', "bmp");
		$valid_formats = array("jpg", "png", "gif","jpeg","ico");
		list($id,$fieldname)=explode("_",$_REQUEST['page']);
		$str="";$imgpath = '';$error = "";$msg = "";
		
		$fileid		   = $_REQUEST['name'];
		$imgwidth		   = isset($_REQUEST['width']) ? $_REQUEST['width']: 546;
		$imgheight		   = isset($_REQUEST['height'])? $_REQUEST['height']: 410;
		$filename      = str_replace('-','_',$_REQUEST['name']);
		$savefolderpath= $_REQUEST['pathfolder'];
		$arr		   = explode('-',$fileid);	
		$imgsetpath	   = $arr[0].'-'.$arr[1].'-imgPath';
			
		$successmssgid = $fileid.'-success-mssg';
		$errormssgid   = $fileid."-error-mssg";
		
		if(!empty($_FILES[$filename]['error']))
		{
			switch($_FILES[$filename]['error'])
			{
		
				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;
		
				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error =  'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		}elseif(empty($_FILES[$filename]['tmp_name']) || $_FILES[$filename]['tmp_name'] == 'none')
		{
			$error ='No file was uploaded.'.implode(',',$_FILES[$filename]);
		}else 
		{
			$message = '';
			$extension 	 =	 end(explode(".", $_FILES[$filename]["name"]));
			
				if(getimagesize($_FILES[$filename]['tmp_name'])){
			
					$imgname 	 =	 'anu-image-'.time();	
						
					$img_path	 =	 $path.$imgname.'.'.$extension;
					$org_img_path =  $path.'original/'.$imgname.'.'.$extension;
					$temp_path	 = 	 $_FILES[$filename]['tmp_name'];
					
					$msg = 'Image Path:'.$img_path;
					
					//code for resizing image	
					$image = new SimpleImage();
			
					$image->load($temp_path);
					$image->save($org_img_path);
					
					/*$image->crop(210,210);
					$image->save($img_path);*/
					
					$image->save($img_path);
						$x ='0';  $height_sts = false;
						$y = '0'; $width_sts  = false;
						
						
						
						$upImgWidth=$image->getWidth(); $upImgHeight=$image->getHeight();
						//Thumbnail Image
						if(($upImgWidth  > $imgwidth) || ($upImgHeight > $imgheight)){
							if($upImgWidth  > $imgwidth)	{
								$image->resizeToWidth($imgwidth);
								$image->save($img_path);	
								$image->load($img_path);
							} 
							
							$upImgHeight = $image->getHeight();
							if($upImgHeight > $imgheight)	{
								$image->resizeToHeight($imgheight);	
								$image->save($img_path);
							}
							$image->load($img_path);
							$newheight = $image->getHeight(); $newwidth = $image->getWidth();
							$hdiff = $imgheight - $newheight; $wdiff = $imgwidth - $newwidth;
							echo '<script language="JavaScript" type="text/javascript">'."\n";	
							echo 'console.log("Height:'.$hdiff.'****Width:'.$wdiff.' New Height:'.$newheight.'**** New Width:'.$newwidth.'");';
							echo "\n".'</script>';
						}else{
							$image->save($img_path);
							$hdiff = $imgheight-$upImgHeight; $wdiff = $imgwidth-$upImgWidth;
						}
						echo '<script language="JavaScript" type="text/javascript">'."\n";	
						echo 'console.log("Height:'.$hdiff.'****Width:'.$wdiff.'");';
						echo "\n".'</script>';
						$y= $hdiff>0 ? round($hdiff/2) : 0; $x= $wdiff>0 ? round($wdiff/2) : 0;
						$style = 'margin-left : '.$x.'px; margin-top :  '.$y.'px; width : 300px; height : 200px;';
					
					//Thumbnail Image
					//$image->resize(150,150);
//			
//					$image->save($thumb_path);
				}else{
					$error = 'Please upload a valid image';
				}
			
		}	
		
		echo '<script language="JavaScript" type="text/javascript">'."\n";
		echo 'var parDoc = window.parent.document;';
		if(!empty($error)){
			echo "parDoc.getElementById('".$errormssgid."').innerHTML = '".$error."';";
		}else{
			
			echo "parDoc.getElementById('".$imgsetpath."').value = '".$img_path."';";
			
			echo  "parDoc.getElementById('".$imgsetpath."_img').src = '".base_url($img_path)."';";
			echo  "parDoc.getElementById('".$imgsetpath."_a').href = '".base_url($img_path)."';";
			
			echo  "parDoc.getElementById('".$imgsetpath."_img').setAttribute('style', '".$style."');";
			
			echo "parDoc.getElementById('".$errormssgid."').innerHTML = '';";
			
			if($_REQUEST['filetype']=='file'){
				//echo "parDoc.getElementById('".$successmssgid."').innerHTML = 'File uploaded successfully';";
			}else{
				//echo "parDoc.getElementById('".$successmssgid."').innerHTML = '<img src=\"".base_url($img_path)."\" width=\"50\" height=\"50\">';";
			}
		}
		echo "\n".'</script>';
		exit(); // do not go futher
	}
	public function uploadMultiImage()
	{
			$data = array();
			if( isset( $_POST['image_upload'] ) && !empty( $_FILES['images'] )){
			
				$image = $_FILES['images'];
				$allowedExts = array("gif", "jpeg", "jpg", "png");
			
				//$ip=getIPAddress();
				//create directory if not exists
				if (!file_exists('images')) {
					mkdir('images', 0777, true);
				}
				$image_name = $image['name'];
				
				//get image extension
				$ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
				
				//assign unique name to image
				$name = time().'.'.$ext;
				
				//$name = $image_name;
				//image size calcuation in KB
				$image_size = $image["size"] / 1024;
				$image_flag = true;
				
				//max image size
				$max_size = 512;
				if( in_array($ext, $allowedExts) && $image_size < $max_size ){
					$image_flag = true;
				} else {
					$image_flag = false;
					$data['error'] = 'Maybe '.$image_name. ' exceeds max '.$max_size.' KB size or incorrect file extension';
				} 
			
				if( $image["error"] > 0 ){
					$image_flag = false;
					$data['error'] = '';
					$data['error'].= '<br/> '.$image_name.' Image contains error - Error Code : '.$image["error"];
				}
			
				if($image_flag){
					move_uploaded_file($image["tmp_name"], "uploaded/healthcamps/".$name);
					$src  = "uploaded/healthcamps/".$name;
					$dist = "uploaded/healthcamps/thumbnail_".$name;
					$data['success'] = $thumbnail = 'thumbnail_'.$name;
					
					$this->Common_model->thumbnail($src, $dist, 200);
					$pid=$this->Common_model->insert_table('fhpl_health_camp_images',array('image'=> $name,'thumbImagePath'=>$thumbnail,'campID'=> $_POST['campID']));
					$data['imageID'] = $pid;
				}
				echo json_encode($data);
			
			} else {
				$data[] = 'No Image Selected..';
			}
	}
	
	public function uploadckimage()
	{
		$basePath=base_url();
		$baseUrl = "uploaded/";
		$CKEditor = $_GET['CKEditor'] ;
		$funcNum = $_GET['CKEditorFuncNum'] ;
		$langCode = $_GET['langCode'] ;
		$url = '' ;
		$message = '';
		if (isset($_FILES['upload'])) {
			  $name = $_FILES['upload']['name'];
			if(move_uploaded_file($_FILES["upload"]["tmp_name"], $baseUrl . $name)) {
			  $url = $basePath. $baseUrl . $name;
			  $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
			  $message = $img_name .' successfully uploaded';
			  $re = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message')";
			}
			else $re = 'alert("Unable to upload the file")';
		   echo "<script type='text/javascript'>$re;</script>"; 
		}
		else
		{
			$message = 'alert("No file has been sent")';
			echo "<script type='text/javascript'>$message;</script>"; 
		}
		exit;
	}
	
	//home end
}
