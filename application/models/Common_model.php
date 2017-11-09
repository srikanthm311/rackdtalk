<?php if (!defined('BASEPATH')) exit('No direct script access allowed');







class Common_model extends CI_Model {

	

	public function __construct()

	{



		parent::__construct();



		$this->load->database();



	}

	

	

	

	public function query($sql)

	{		

		if($sql!='')

		{

			$query = $this->db->query($sql);

			return $query->result();

		}

	}	

	
	public function query_array($sql)

	{		

		if($sql!='')

		{

			$query = $this->db->query($sql);

			return $query->result_array();

		}

	}	
	

	

	public function get_table_row($table_name='', $where='', $columns='', $order_column='', $order_by='asc', $limit='')
	{

		if(!empty($columns)) 

		{
			$tbl_columns = implode(',', $columns);



			$this->db->select($tbl_columns);



		}



		if(!empty($where)) $this->db->where($where);

		if(!empty($order_column)) $this->db->order_by($order_column, $order_by); 

		if(!empty($limit)) $this->db->limit($limit); 

		$query = $this->db->get($table_name);

		if($columns=='test') { echo $this->db->last_query(); exit; }

		//echo $this->db->last_query();

		return $query->row_array();



	}



	



	public function get_table($table_name='', $where='', $columns='', $order_column='', $order_by='asc', $limit='', $offset='')

	{



		if(!empty($columns)) 



		{



			$tbl_columns = implode(',', $columns);



			$this->db->select($tbl_columns);



		}



		if(!empty($where)) $this->db->where($where);



		if(!empty($order_column)) $this->db->order_by($order_column, $order_by); 



		if(!empty($limit) && !empty($offset)) $this->db->limit($limit, $offset); 

		else if(!empty($limit)) $this->db->limit($limit); 



		$query = $this->db->get($table_name);

		

		//echo $this->db->last_query(); exit;



		//if($columns=='test') { echo $this->db->last_query(); exit; }



		//echo $this->db->last_query();



		return $query->result_array();



	}



	



	public function insert_table($table_name='', $array='', $insert_id ='', $batch=false)

	{



		if(!empty($array) && !empty($table_name))



		{



			if($batch)



			{



				$this->db->insert_batch($table_name, $array);



			}



			else {$this->db->insert($table_name, $array);}



			



			//if(!empty($insert_id)) return $this->db->insert_id();



			return $this->db->insert_id();



		}



	}



	







	



	public function update_table($table_name='', $array='', $where='', $test=0)



	{		



		if(!empty($array) && !empty($table_name) && !empty($where))



		{



			$this->db->where($where);



			$this->db->update($table_name, $array);



			



		}



		//if($test) echo $this->db->last_query(); exit;



	}	

	

	public function delete_rows($table_name='', $where='')



	{



		if(!empty($table_name) && !empty($where))



		{



			$this->db->where($where);



			$this->db->delete($table_name);



		}



		//echo $this->db->last_query(); exit;



	}

	

	public function thumbnail($src, $dist, $dis_width = 100 )

    {

 

	$img = '';

	$extension = strtolower(strrchr($src, '.'));

	switch($extension)

	{

		case '.jpg':

		case '.jpeg':

			$img = @imagecreatefromjpeg($src);

			break;

		case '.gif':

			$img = @imagecreatefromgif($src);

			break;

		case '.png':

			$img = @imagecreatefrompng($src);

			break;

	}

	$width = imagesx($img);

	$height = imagesy($img);



	$dis_height = $dis_width * ($height / $width);



	$new_image = imagecreatetruecolor($dis_width, $dis_height);

	imagecopyresampled($new_image, $img, 0, 0, 0, 0, $dis_width, $dis_height, $width, $height);



	$imageQuality = 100;



	switch($extension)

	{

		case '.jpg':

		case '.jpeg':

			if (imagetypes() & IMG_JPG) {

				imagejpeg($new_image, $dist, $imageQuality);

			}

			break;



		case '.gif':

			if (imagetypes() & IMG_GIF) {

				imagegif($new_image, $dist);

			}

			break;



		case '.png':

			$scaleQuality = round(($imageQuality/100) * 9);

			$invertScaleQuality = 9 - $scaleQuality;



			if (imagetypes() & IMG_PNG) {

				imagepng($new_image, $dist, $invertScaleQuality);

			}

			break;

	}

	imagedestroy($new_image);

}

	

}