<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

     public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_model');
	}
	public function index()
	{
		$this->load->view('welcome/index');
	}
	
	public function getCategories()
	{
		 
		 $this->load->model('Categories_model');
	 	 $data['mainLinks']=$this->Categories_model->getCategories(array('isActive' => 1,'parent_id' =>0));
		 $this->load->view('welcome/categories',$data);
	}
	
	public function insertCategories($msg='')
	{
		 
		 $this->load->model('Categories_model');
		 if($this->input->post())
		 {
			$Insert=$this->Categories_model->InsertCategory($this->input->post()); 
			$msg=($Insert) ? 'successsfully inserted':'Name already exists';
			redirect('welcome/insertCategories/'.$msg);
		 }
		 $data['mainLinks']=$this->Categories_model->getCategories(array('isActive' => 1,'parent_id' =>0));
		 //echo '<pre>';print_r($data);
		 $this->load->view('welcome/insertcategories',$data);
	}
	
	public function editCategory($id,$msg='')
	{
		 
		  $this->load->model('Categories_model');
		  $this->load->model('Users_model');
			 if($this->input->post())
			 {
				//echo '<pre>';print_r($this->input->post());exit;
				$Insert=$this->Categories_model->InsertCategory($this->input->post()); 
				$msg=($Insert) ? 'successsfully Updated':'Some error occured';
				redirect('welcome/editCategory/'.$id);
			 }
		  $data['mainLinks']    =   $this->Categories_model->getCategories(array('isActive' => 1,'parent_id' =>0));
		  $data['categoryInfo'] =   $this->Common_model->get_table_row('fhpl_menus',array('isActive' => 1,'ID' => $id));
		  $data['subdata']      =   $this->Common_model->get_table('fhpl_menu_topic_data',array('pageID' => $id));
		  $data['subtopics']    =   $this->Common_model->get_table('fhpl_topics');
		 
		  $r=$this->Users_model->getCategories($id);
		  $data['html']=$this->buildHtml($r);
		  $this->load->view('welcome/editcategories',$data);
	}
	
	public function editCategoryNew($id,$msg='')
	{
		 
		  $this->load->model('Categories_model');
		  $this->load->model('Users_model');
			 if($this->input->post())
			 {
				echo '<pre>';print_r($this->input->post());exit;
				$Insert=$this->Categories_model->InsertCategory($this->input->post()); 
				$msg=($Insert) ? 'successsfully Updated':'Some error occured';
				redirect('welcome/editCategory/'.$id);
			 }
		  $data['mainLinks']    =   $this->Categories_model->getCategories(array('isActive' => 1,'parent_id' =>0));
		  $data['categoryInfo'] =   $this->Common_model->get_table_row('fhpl_menus',array('isActive' => 1,'ID' => $id));
		  $data['subdata']      =   $this->Common_model->get_table('fhpl_menu_topic_data',array('pageID' => $id));
		  $data['subtopics']    =   $this->Common_model->get_table('fhpl_topics');
		 
		  $r=$this->Users_model->getCategories($id);
		  $data['html']=$this->buildHtml($r);
		  $this->load->view('welcome/editcategories1',$data);
	}
	
	public function viewSubCategories($catID)
	{
		 
		     $this->load->model('Categories_model');
			 $cndarr=array('isActive' => 1,'parent_id' =>$catID);
		     $data['mainLinks']    =   $this->Common_model->get_table('fhpl_menus',$cndarr,array('ID','name','slug','image','parent_id'));
			 $this->load->view('welcome/subcategories',$data);
		
	}
	
	public function editSubCategory($catID,$id,$msg='')
	{
		  $this->load->model('Categories_model');
		  $this->load->model('Users_model');
			 if($this->input->post())
			 {
				//echo '<pre>';print_r($this->input->post());exit;
				$Insert=$this->Categories_model->InsertCategory($this->input->post()); 
				$msg=($Insert) ? 'successsfully Updated':'Some error occured';
				redirect('welcome/editSubCategory/'.$catID.'/'.$id);
			 }
		  $data['categoryInfo'] =   $this->Common_model->get_table_row('fhpl_menus',array('isActive' => 1,'ID' => $id));
		  $data['subdata']      =   $this->Common_model->get_table('fhpl_menu_topic_data',array('pageID' => $id));
		  $data['subtopics']    =   $this->Common_model->get_table('fhpl_topics');
		  
		  $isFirstLevel         =   $this->Common_model->get_table_row('fhpl_menus',array('ID' => $catID),array('parent_id'));
		  $data['isFirstLevel'] =   (!$isFirstLevel['parent_id'])?1:0;
		  $r=$this->Users_model->getCategories();
		  //echo '<pre>';print_r($r);exit;
		  $data['html']=$this->buildHtml($r,$catID);
		  $this->load->view('welcome/editsubcategory',$data);
	}
	
	public function getSubCategories()
	{
		 
		     $this->load->model('Categories_model');
			 $cndarr=array('isActive' => 1,'parent_id' =>$_POST['ID']);
			 $subcategories=$this->Categories_model->getCategories($cndarr); 
			 if(!empty($subcategories))
			 {
				 $html=' <select name="subitem" id="subitem" >  <option value="">--select--</option>';
				 foreach($subcategories as $sub)
				 {
				 $html.=	 '<option value="'.$sub['ID'].'">'.$sub['name'].'</option>';
				 }
				 $html.=' </select>';
			 }else{
				 $html= ' <select name="subitem" id="subitem" >  <option value="">--select--</option></select>'; 
			 }
			 echo $html;
		
	}
	
	public function getSubtopics()
	{
		 
			 $subcategories=$this->Categories_model->getCategories('fhpl_topics'); 
			 if(!empty($subcategories))
			 {
				 $html=' <select name="subitem" id="subitem" >  <option value="">--select--</option>';
				 foreach($subcategories as $sub)
				 {
				 $html.=	 '<option value="'.$sub['ID'].'">'.$sub['name'].'</option>';
				 }
				 $html.=' </select>';
			 }else{
				 $html= ' <select name="subitem" id="subitem" >  <option value="">--select--</option></select>'; 
			 }
			 echo $html;
		
	}
	
	public function buildHtml($filters,$selectd='')
	{
		$html='<div><input type="radio" value="-1" name="User[parent_id]"><lable class="treelable">Parent Category</lable></div>';
		$count=0;
		$phead="";
		if(count($filters)>0) {
			foreach($filters as $fkey=>$filter){
				$html.='<div id="tree_'.$fkey.'" class="tree tree-plus-minus">';
				$headname="";//getField('name','mw_filters_names','id='.$filter['pid']);
				if($phead="" || $phead!=$headname)
					$html.='<div class="tree tree-plus-minus"><h4>'.$headname.'</h4></div>';
				$phead=$headname;
				$html.=$this->buildChildHtml($filter,'tree_'.$fkey,10,'',$selectd);
				$html.='</div>';
				$count++;
			}
		}
		return $html;
	}
	
	public function buildChildHtml($arr,$pid,$margin=10,$class="",$selectd="")
	{
		$html="";
		$html.='<div  style="margin-left:'.$margin.'px;" class="sh_'.$pid.'">';
		if(count($arr['childs'])>0){
			$html.='<i class="glyphicon glyphicon-minus" style="margin-right:5px;" onclick="showorhide(this,'.$arr['ID'].')"></i>';
		}
			$html.='<input '.((count($arr['childs'])==0)?'style="margin-left:18px;" ':'').' type="radio" name="parent_id" id="check_'.$arr['ID'].'" class=" treecheck '.$class.' '.$pid.'" value="'.$arr['ID'].'" '.((!empty($selectd) && $selectd==$arr['ID'])?'checked="checked"':'').' ><lable class="treelable">'.$arr['name'].'</lable>';
		//if($selectd!=$arr['ID']) {
			foreach($arr['childs'] as $c){
				$html.=$this->buildChildHtml($c,'check_'.$arr['ID'],$margin+10,$class.' '.$pid,$selectd);
			}
		//}
		$html.="</div>";
		return $html;
	}

   public function uploadImage()
	{
		
		require_once("SimpleImage.class.php");
		$path = "uploaded/images/";
		$allowTypes = array('xls','xlsx','pdf','csv', "bmp");
		$valid_formats = array("jpg", "png", "gif","jpeg","ico");
		list($id,$fieldname)=explode("_",$_REQUEST['page']);
		$str="";$imgpath = '';$error = "";$msg = "";
		
		$fileid		   = $_REQUEST['name'];
		$filename      = str_replace('-','_',$_REQUEST['name']);
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
			
					$imgname 	 =	 'fhpl-image-'.time();	
						
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
						
						$imgwidth = 390; $imgheight = 250;
						
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
						$style = 'margin-left : '.$x.'px; margin-top :  '.$y.'px';
					
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
	
	
	public function NewuploadImage()
	{

		require_once("SimpleImage.class.php");
		$path = "uploaded/images/";
		//echo '<pre>'; print_r($_POST);exit;

		$allowTypes = array('xls','xlsx','pdf','csv');
		$valid_formats = array("jpg", "png", "gif","jpeg");
		list($id,$fieldname)=explode("_",$_REQUEST['page']);
		$str="";$imgpath = '';$error = "";$msg = "";
		$fileid		   = $_REQUEST['name'];	
		$filename      = str_replace('-','_',$_REQUEST['name']);
		$arr		   = explode('-',$fileid);	
		$imgsetpath    = $arr[0].'-'.$arr[1].'-imgPath';
		//$imgsourcepath    = $arr[0].'-'.$arr[1].'-dispimage';
		$imgwidth=$_REQUEST['imgwidth'];$imgheight=$_REQUEST['imgheight'];	
		$successmssgid	 = $fileid.'-success-mssg';
		$errormssgid 	   = $fileid."-error-mssg";
		$errormssgdispid   = $fileid."-error-disp";
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
					$error = 'Failed to write file to disk';
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
			$error = 'No file was uploaded..'.implode(',',$_FILES[$filename]);
		}else 
		{
			$message = '';
			$extension 	 =	 end(explode(".", $_FILES[$filename]["name"]));
			if($_REQUEST['filetype']=='file'){
				if(in_array($extension,$allowTypes)){
					$imgname 	 =	 'fhpl-image-subtopic-'.$_REQUEST['adminid'].'-'.time();	
					$img_path	 =	 $path.$imgname.'.'.$extension;
					$temp_path	 = 	 $_FILES[$filename]['tmp_name'];
					chmod($img_path,0777);

					if(move_uploaded_file($temp_path,$img_path)){
						$mssg = '<p style="color:#00F;">file uploaded succesfully</p>';
					}

					chmod($img_path,0755);

				}else{
					$error = '<p style="color:#F00;">Invalid file</p>';
				}

			}else{
				if(getimagesize($_FILES[$filename]['tmp_name'])){
					if(in_array($extension,$valid_formats)){

						$imgname 	 =	 'fhpl-image-subtopic-'.$arr[0].'-'.time();
						$img_path	 =	 $path.$imgname.'.'.$extension;//$product_img_path.$imgname.$img_extension; $thumb_path = $product_thumb_path.$imgname.$img_extension;
						$temp_path	 = 	 $_FILES[$filename]['tmp_name'];
						$msg = 'Image Path:'.$img_path;

						//code for resizing image	
						$image = new SimpleImage();				
						$image->load($temp_path);	
						$x ='0';  $height_sts = false;
						$y = '0'; $width_sts  = false;	
						if($arr[1]=='logo'){
						$imgwidth = 250; $imgheight = 250;
						}elseif($arr[1]=='header'){
							$imgwidth = 250; $imgheight = 250;
						}
						elseif(isset($imgwidth) || isset($imgheight)){
							$imgwidth = $imgwidth; $imgheight = $imgheight;
						}else{
							$imgwidth = 390; $imgheight = 250;
						}

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

						$y= $hdiff>0 ? round($hdiff/2) : 0; $x= $wdiff>0 ? round($wdiff/2) : 0;
						$style = 'style = "margin-left : '.$x.'px; margin-top :  '.$y.'px"';
						$style_dimensions = ' margin-left : '.$x.'px; margin-top :  '.$y.'px';
					}else{
						$error = str_replace('<#FORMATS#>',implode(',',$valid_formats),'Invalid file fromat');
					}
				}else{
					$error ='upload valid image';
				}
			}
		}	

		echo '<script language="JavaScript" type="text/javascript">'."\n";
		echo 'var parDoc = window.parent.document,parenthtml = "";';
		if(!empty($error)){
			echo "parent.$('#".$errormssgdispid."').show();";
			echo "parDoc.getElementById('".$errormssgdispid."').innerHTML = '".$error."';";
		}else{
			echo 'console.log("'.$img_path.'");';

			echo "parDoc.getElementById('".$imgsetpath."').value = '".$img_path."';";
			echo "parent.$('#".$imgsetpath."').change();";
			echo "parent.$('#".$errormssgdispid."').hide();";

			if($_REQUEST['filetype']=='file'){
				echo "parDoc.getElementById('".$successmssgid."').innerHTML = 'file uploaded successfully';";
			}else{

				$targetid = '#'.$fileid; $spantext = '';
				echo "parent.$('#".$arr[0].'-'.$arr[1]."-delete').remove();";

				if($arr[0].'-'.$arr[1]=='upload-logo'){
				 echo "parent.$('.change-img').html('change');";
				 $spantext = "<span class=\"img-delete-big\" id=\"".$arr[0].'-'.$arr[1]."-delete\" onclick=\"removeImage(\'".$arr[0].'-'.$arr[1]."\');$(\'.change-img\').html(\'\');\"></span>";
				 echo "parDoc.getElementById('".$errormssgid."').innerHTML = '<img src=\"".base_url($img_path)."\" onclick=\"$(\'".$targetid."\').click();\">' '".$style."'; ";				
				}
				else{

					 echo "parent.$('#".$arr[0].'-'.$arr[1]."-smalltxt').html('changepic');";
					 echo "parent.$('.change-img').html('changepic');";
					 echo "parent.$('.edimg').html('changepic');";
					// echo 'console.log("errormssgid:'.$errormssgid.'");';

					$spantext = "<span class=\"img-delete\" id=\"".$arr[0].'-'.$arr[1]."-delete\" onclick=\"removeImage(\'".$arr[0].'-'.$arr[1]."\',\'".$imgwidth."\',\'".$imgheight."\');$(\'.change-img\').html(\'\');\"></span>";
					echo "parDoc.getElementById('".$errormssgid."').innerHTML = '<img src=\"".base_url($img_path)."\"  ".$style."  onclick=\"$(\'".$targetid."\').click();\">';";
				}
				echo "parent.$('#".$arr[0].'-'.$arr[1]."-editDelete').append('".$spantext."');";
			}
		}

		echo "parDoc.getElementById('".$imgsetpath."-loading').style.display='none';";
		echo "\n".'</script>';
		exit(); // do not go futher
	}
	
	public function gets()
	{ exit;
	$this->load->model('Categories_model');
	$data=$this->Categories_model->getCategoriesContent();
	
	$result=array();
	foreach($data as $d)
	{
		$result = preg_replace('/<head\b[^>]*>(.*?)<\/head>/is', "",preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $d['content']));
		$this->Common_model->update_table('fhpl_menus',array('content' =>$result ),array('ID' =>$d['ID'] ));
	}
	}

    function delete_all_between($beginning, $end, $string)
    {
	  $beginningPos = strpos($string, $beginning);
	  $endPos = strpos($string, $end);
	  if (!$beginningPos || !$endPos) {
		return $string;
	  }
	
	  $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
	
	  return str_replace($textToDelete, '', $string);
	  
    }
	
	 function display()
     {
		   $x= array("&#39;","'");
		   $s='INSERT INTO  [Wellness].[dbo].[fhpl_menu_topic_data1] ';$r='';
		   $list=$this->Common_model->get_table('fhpl_menu_topic_data');
		   foreach($list as $data)
		   {
		   $content=str_replace($x, "''", $data['content']);
	       $topicTitle=str_replace($x, "''", $data['topicTitle']);
		   $metaTitle=str_replace($x, "''", $data['metaTitle']);
		   $metaDescription=str_replace($x, "''", $data['metaDescription']);
	       $metaKeywords=str_replace($x, "''", $data['metaKeywords']);
$r.=" SELECT ".$data['mapID'].",".$data['topicID'].",".$data['pageID'].",'".$topicTitle."','".$metaTitle."','".$metaDescription."','".$metaKeywords."','".$data['slug']."','".$content."','".$data['image']."' UNION ";
		   }
		 $d=$s.$r;
		 echo $d;
    }
	
	
}
