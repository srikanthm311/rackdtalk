<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sociallogin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
		$this->load->model("Sociallogin_model");
		ob_start();
	}

	public function facebook()
	{
	  require_once APPPATH.'third_party/facebook-sdk-v5/autoload.php';
	  $fb = new Facebook\Facebook([  'app_id' => '1704886966482352',   'app_secret' => 'f464be14cfd428109027178b67e0c756',  'default_graph_version' => 'v2.2',  ]);
	  $helper = $fb->getRedirectLoginHelper();
	  $permissions = ['email']; // Optional permissions
	  $loginUrl = $helper->getLoginUrl(base_url('sociallogin/handle_facebook_login'), $permissions);
	  redirect($loginUrl);
	}

	public function handle_facebook_login()
	{
		require_once APPPATH.'third_party/facebook-sdk-v5/autoload.php';
		$fb = new Facebook\Facebook([  'app_id' => '1704886966482352',   'app_secret' => 'f464be14cfd428109027178b67e0c756',  'default_graph_version' => 'v2.2',  ]);
		$helper = $fb->getRedirectLoginHelper();
		try { $accessToken = $helper->getAccessToken();}
		catch(Facebook\Exceptions\FacebookResponseException $e) {	  echo 'Graph returned an error: ' . $e->getMessage();		  exit;		} 
		catch(Facebook\Exceptions\FacebookSDKException $e) {	  echo 'Facebook SDK returned an error: ' . $e->getMessage();		  exit;		}
		
		if (! isset($accessToken)) {
		  if ($helper->getError()) {
			header('HTTP/1.0 401 Unauthorized');
			echo "Error: " . $helper->getError() . "\n";
			echo "Error Code: " . $helper->getErrorCode() . "\n";
			echo "Error Reason: " . $helper->getErrorReason() . "\n";
			echo "Error Description: " . $helper->getErrorDescription() . "\n";
		  } else {
			header('HTTP/1.0 400 Bad Request');
			echo 'Bad request';
		  }
		  exit;
		}
		
		try {  $response = $fb->get('/me?fields=id,name,email', $accessToken->getValue());}
		catch(\Facebook\Exceptions\FacebookResponseException $e)  {		  echo 'Graph returned an error: ' . $e->getMessage();		  exit;		} 
		catch(\Facebook\Exceptions\FacebookSDKException $e) {		  echo 'Facebook SDK returned an error: ' . $e->getMessage();		  exit;		}

        $facebook_user = $response->getGraphUser();
		//echo '<pre>';print_r($facebook_user);exit;
		if($facebook_user)
		{
			switch($this->Sociallogin_model->ifUserExists($facebook_user))
			{
				case 0:
			     $userInfo=$this->Sociallogin_model->RegisterUser($facebook_user,"facebook");break;

				case -1:
						die("Disabled user");break;

				case 1:
						$this->Sociallogin_model->Login($facebook_user);break;

			}
			//echo 'registered'; exit;
			redirect(base_url());
		}

	}

	

	public function handle_google_login()
	{
     
         require_once APPPATH.'third_party/google/autoload.php';
		 $client_id = '589616706842-uc7o0167hi9fb5vfajjc1spp30do0o09.apps.googleusercontent.com'; 
		 $client_secret = '7r2g2rDD-08enkY9hZFGng5T';
		 $redirect_uri = base_url('sociallogin/handle_google_login');
           //AIzaSyC7iylETGFKk2IoRXCCT1Vkw0xZiov3knY
		 if(isset($_GET['logout'])){ unset($_SESSION['access_token']);}


		$client = new Google_Client();
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->addScope("email");
		$client->addScope("profile");

        $service = new Google_Service_Oauth2($client);
  
		if (isset($_GET['code'])) {
		  $client->authenticate($_GET['code']);
		  $_SESSION['access_token'] = $client->getAccessToken();
		  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		  exit;
		}

		/************************************************
		  If we have an access token, we can make
		  requests, else we generate an authentication URL.
		 ************************************************/
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) 
		{
		  $client->setAccessToken($_SESSION['access_token']);
		} else {
		  $authUrl = $client->createAuthUrl();
		}

		if(isset($authUrl)){ 		  redirect($authUrl);exit;		} 
		else
		{
			    $gUser = (array)$service->userinfo->get(); //echo '<pre>';print_r($gUser);exit;
			    switch($this->Sociallogin_model->ifUserExists($gUser))
				{
					case 0:
							$this->Sociallogin_model->RegisterUser($gUser,"google");
							break;

					case -1:
							echo "Disabled user";
							break;

					case 1:
							$this->Sociallogin_model->Login($gUser);
							break;
				}
		}
		
	}


}