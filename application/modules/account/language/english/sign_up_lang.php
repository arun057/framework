<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();

/*
|--------------------------------------------------------------------------
| Sign Up
|--------------------------------------------------------------------------
*/
$lang['sign_up_page_name']			= 'Sign Up';
$lang['sign_up_heading'] 			= 'Or, create your ' . $CI->config->item('site_name') . ' Account';
$lang['sign_up_third_party_heading']		= 'Sign up with your account from';
$lang['sign_up_with']				= 'Sign Up with %s';
$lang['sign_up_username']			= 'Username';
$lang['sign_up_password']			= 'Password';
$lang['sign_up_firstname']			= 'First Name';
$lang['sign_up_lastname']			= 'Last Name';
$lang['sign_up_email']				= 'Email';
$lang['sign_up_create_my_account']		= 'Create my account';
$lang['sign_up_sign_in_now']			= 'Sign in now';
$lang['sign_up_already_have_account']		= 'Already have an account?';
$lang['sign_up_recaptcha_required']		= 'The captcha test is required';
$lang['sign_up_recaptcha_incorrect']		= 'The captcha test is incorrect.';
$lang['sign_up_username_taken'] 		= 'This Username is already taken. <br /><br />If this is your username, try connecting with your <a href="/account/connect_facebook">FB</a> or <a href="/account/connect_twitter">Twitter</a> account, <br />or <a href=\'javascript:account_submit("/account/sign_in?ajax=1", "")\'>Login</a> using this username. <br /><br />';
$lang['sign_up_email_exist']			= 'Can not create this account,  <br/>this Email is already registered.' . (isset($_POST['sign_up_email']) ? '<br /><br />If you are: ' . $_POST['sign_up_email'] . ' <br />try connecting with your <a href="/account/connect_facebook">FB</a> or <a href="/account/connect_twitter">Twitter</a> account, <br />or <a href=\'javascript:account_submit("/account/sign_in?ajax=1", "")\'>Login</a> using this email. <br /><br />' : '');
$lang['sign_up_forgot_your_password'] 		= 'Forgot your password?';


/* End of file sign_up_lang.php */
/* Location: ./application/modules/account/language/english/sign_up_lang.php */