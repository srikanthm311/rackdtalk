<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Main/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;


$route['comment-form/(:any)'] = 'main/comment_form/$1';
$route['category.html/(:any)'] = 'main/category/$1';
$route['post-your-question.html'] = 'main/post_your_question';
$route['about-to-close-questions.html'] = 'main/about_to_close_questions';
$route['trending-questions.html'] = 'main/trending_questions';
$route['latest-questions.html'] = 'main/latest_questions';
$route['top-bidding-questions.html'] = 'main/top_bidding';

$route['my-questions.html'] = 'main/my_questions';
$route['my-commented-questions.html'] = 'main/my_comments';
$route['my-bidded-questions.html'] = 'main/my_bidding';
$route['my-transactions.html'] = 'main/my_transactions';
$route['my-wins.html'] = 'main/mywins';
$route['my-withdraw.html'] = 'main/my_withdraw';

$route['plans.html'] = 'main/plans';
$route['my-account.html'] = 'main/profile';
$route['my-information.html'] = 'main/myinformation';
$route['blog.html'] = 'main/blogs';
$route['blog.html/(:any)'] = 'main/blogs/$1';
$route['aboutus.html'] = 'main/aboutus';
$route['contact-us.html'] = 'main/contactus';