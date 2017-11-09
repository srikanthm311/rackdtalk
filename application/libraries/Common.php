<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 



class Common {



	public function random_generator($digits){

		

		srand ((double) microtime() * 10000000);

		//Array of alphabets

		$input = array ("A", "B", "C", "D", "E","F","G","H","I","J","K","L","M","N","O","P","Q",

		"R","S","T","U","V","W","X","Y","Z");

		

		$random_generator="";// Initialize the string to store random numbers

		for($i=1;$i<$digits+1;$i++){ // Loop the number of times of required digits

		

		if(rand(1,2) == 1){// to decide the digit should be numeric or alphabet

		// Add one random alphabet

		$rand_index = array_rand($input);

		$random_generator .=$input[$rand_index]; // One char is added

		

		}else{

		

		// Add one numeric digit between 1 and 10

		$random_generator .=rand(1,10); // one number is added

		} // end of if else

		

		} // end of for loop

		return $random_generator;

	} // end of function

	

	public function objectsIntoArray($arrObjData, $arrSkipIndices = array())

	{

		$arrData = array();

		// if input is object, convert into array

		if (is_object($arrObjData)) {

		  $arrObjData = get_object_vars($arrObjData);

		}

	   

		if (is_array($arrObjData)) {

			foreach ($arrObjData as $index => $value) {

				if (is_object($value) || is_array($value)) {

					$value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call

				}

				if (in_array($index, $arrSkipIndices)) {

					continue;

				}

				$arrData[$index] = $value;

			}

		}

		return $arrData;

	}

	

	/*A function which accepts two parameters one is array and other is a key with respect to which array is to be reordered*/

	function getarraywithspecifickey($input,$key){

		$output = array();

		foreach($input as $val){

			$output[$val[$key]] = $val;

		}

		return $output;

	}

	

	




	function getEmailText($data,$filename,$language_type=''){

		$this->ci =& get_instance();

		$language_type = $language_type ? $language_type : 'english';

		$emailFolder  = $this->ci->config->item('emailTemplateFolder').'/'.$language_type;

		$this->ci->load->helper('file');

		$file_data = read_file($emailFolder.'/'.$filename);

		$body = '';

		//Extract the subject (first line) and the body (third to end lines)

        if($file_data){

            $file_data = explode("\n", $file_data);

            foreach($file_data as $line=>$text){

                switch($line){

                    case 0:

                        $subject = $text;

                        break;

                    case 1:

                        break;

                    default:

                        $body.=$text."\n";

                }

            }

        }

		

		if(!preg_match("/<br[^>]*>/i",$body)){

            $file_data = str_replace("\n","<br/>",$body);

        }

        //Just in case of old mail content

        $file_data = str_replace("\r","",$body);

		$keys = array_keys($data); $values = array_values($data);

		$file_data = str_replace($keys,$values,$file_data);

		return array($subject,$file_data);	

	}

       public function sendSMSMessage($array)
	{ 
     $url="login.bulksmsgateway.in/sendmessage.php?user=".urlencode('yursts')."&password=".urlencode('123456')."&mobile=".urlencode($array['mobile'])."&message=".urlencode($array['message'])."&sender=".urlencode('ANUBTC')."&type=".urlencode('3');
	 
	// echo $url;exit;
     $ch = curl_init($url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     $curl_scraped_page = curl_exec($ch);
     curl_close($ch);
	}

	public function createDir($path)
		{  
			 if(!file_exists($path)) {
			  $old_mask = umask(0);
			  mkdir($path, 0777, TRUE);
			  umask($old_mask);
			 }
		}

     public function createThumb($path1, $path2, $file_type, $new_w, $new_h, $squareSize = '')
     {
		 /* read the source image */
		 $source_image = FALSE;
		 
		 if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
		  $source_image = imagecreatefromjpeg($path1);
		 }
		 elseif (preg_match("/png|PNG/", $file_type)) {
		  
		  if (!$source_image = @imagecreatefrompng($path1)) {
		   $source_image = imagecreatefromjpeg($path1);
		  }
		 }
		 elseif (preg_match("/gif|GIF/", $file_type)) {
		  $source_image = imagecreatefromgif($path1);
		 }  
		 if ($source_image == FALSE) {
		  $source_image = imagecreatefromjpeg($path1);
		 }
		
		 $orig_w = imageSX($source_image);
		 $orig_h = imageSY($source_image);
		 
		 if ($orig_w < $new_w && $orig_h < $new_h) {
		  $desired_width = $orig_w;
		  $desired_height = $orig_h;
		 } else {
		  $scale = min($new_w / $orig_w, $new_h / $orig_h);
		  $desired_width = ceil($scale * $orig_w);
		  $desired_height = ceil($scale * $orig_h);
		 }
		   
		 if ($squareSize != '') {
		  $desired_width = $desired_height = $squareSize;
		 }
		
		 /* create a new, "virtual" image */
		 $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		 // for PNG background white----------->
		 $kek = imagecolorallocate($virtual_image, 255, 255, 255);
		 imagefill($virtual_image, 0, 0, $kek);
		 
		 if ($squareSize == '') {
		  /* copy source image at a resized size */
		  imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $orig_w, $orig_h);
		 } else {
		  $wm = $orig_w / $squareSize;
		  $hm = $orig_h / $squareSize;
		  $h_height = $squareSize / 2;
		  $w_height = $squareSize / 2;
		  
		  if ($orig_w > $orig_h) {
		   $adjusted_width = $orig_w / $hm;
		   $half_width = $adjusted_width / 2;
		   $int_width = $half_width - $w_height;
		   imagecopyresampled($virtual_image, $source_image, -$int_width, 0, 0, 0, $adjusted_width, $squareSize, $orig_w, $orig_h);
		  }
		
		  elseif (($orig_w <= $orig_h)) {
		   $adjusted_height = $orig_h / $wm;
		   $half_height = $adjusted_height / 2;
		   imagecopyresampled($virtual_image, $source_image, 0,0, 0, 0, $squareSize, $adjusted_height, $orig_w, $orig_h);
		  } else {
		   imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $squareSize, $squareSize, $orig_w, $orig_h);
		  }
		 }
		 
		 if (@imagejpeg($virtual_image, $path2, 90)) {
		  imagedestroy($virtual_image);
		  imagedestroy($source_image);
		  return TRUE;
		 } else {
		  return FALSE;
		 }
		 
   } 


	

}





/* End of file Common.php */

