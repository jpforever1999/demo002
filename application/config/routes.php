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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
$route['page/(.*)'] = "/customer/page/index";
$route['post(.*)'] = "/customer/posts/index";
$route['shop'] = "/customer/product";
$route['product/detail/(.*)'] = "/customer/product/detail";
$route['taxonomy/(.*)'] = "/customer/Taxonomy";
$route['tags/(.*)'] = "/customer/Tags";
$route['cart'] = "/customer/cart/index";
$route['checkout'] = "/customer/checkout/index";
$route['thanks'] = "/customer/thanks/index";
/*
$route['customer'] = "/customer/index";
$route['driver'] = "/driver/index";
$route['company']  = "/company/index";

$route['article/(.*)'] = "article/index/$1";
$route['admin'] = "/admin/auth/login";

$route['about-us'] = "/welcome/about_us";
$route['contact-us'] = "/welcome/contact_us";
$route['about_us'] = "/welcome/about_us";
$route['contact_us'] = "/welcome/contact_us";

$route['testimonial'] = "/welcome/testimonial";
$route['services'] = "/welcome/services";
$route['login'] = "/welcome/login";
$route['logout'] = "/welcome/logout";
$route['licence-register'] = "/licence/licence_register";

$route['tracking'] = "/welcome/tracking";

$route['company/requirement/api-track'] = "company/requirement/track";
$route['customer/requirement/api-track'] = "customer/requirement/track";
*/
