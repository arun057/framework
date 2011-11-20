<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication {

	var $CI;

	
	/**
	 * Constructor
	 */
    function __construct()
    {
		// Obtain a reference to the ci super object
		$this->CI =& get_instance();
		
		$this->CI->load->library('session');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check user signin status
	 *
	 * @access public
	 * @return bool
	 */
	function is_signed_in()
	{
		return $this->CI->session->userdata('account_id') ? TRUE : FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Sign user in
	 *
	 * @access public
	 * @param int $account_id
	 * @param bool $remember
	 * @return void
	 *
	 * Modified by Fission (BM) to handle Moodle auto-login.
	 */
	function sign_in($account_id, $remember = FALSE)
	{
		// Log user in.
		$remember ? $this->CI->session->cookie_monster(TRUE) : $this->CI->session->cookie_monster(FALSE);
		$this->CI->session->set_userdata('account_id', $account_id);
		$this->CI->load->model('account/account_model');
		$this->CI->account_model->update_last_signed_in_datetime($account_id);

		// Determine the redirect.
		if ($redirect = $this->CI->session->userdata('sign_in_redirect'))
			$this->CI->session->unset_userdata('sign_in_redirect');
		else if (!($redirect = $this->CI->input->get('continue')))
			$redirect = '';

		// Autologin this account on Moodle
                $this->CI->load->helper("moodle");
                moodle_autologin($account_id);

		// Do the redirect
		redirect($redirect); 
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Sign user out
	 *
	 * @access public
	 * @return void
	 *
	 * Modified by Fission (BM) to handle Moodle auto-logout
	 */
	function sign_out()
	{
	     // Log user out.
		$this->CI->session->unset_userdata('account_id');
                $this->CI->load->helper("moodle");
                moodle_autologout();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check password validity
	 *
	 * @access public
	 * @param object $account
	 * @param string $password
	 * @return bool
	 *
	 * Changed by Fission (BM) to use hash function defined in this
	 * class.
	 */

	function check_password($password_hash, $password)
	{
	    return $this->hash($password)==$password_hash;
	}

	/*
	 * Added by Fission (BM) to have password-hashing in one place
	 * and to provide option of using phpass library's PasswordHash 
	 * (which supports salts) or just simple PHP md5 function for hashing.
	 * The latter is being used because of the md5-encrypted passwords imported
	 * from Moodle.
	 */

    private $use_phpass_library = false;

	function hash($password) 
	{
	    if ($this->use_phpass_library) {
		    $this->load->helper('account/phpass');
		    $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
		    return $hasher->HashPassword($password);
	    } else {
		    return md5($password);
	    }
	}
	
}


/* End of file Authentication.php */
/* Location: ./application/modules/account/libraries/Authentication.php */