<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function index()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$this->load->view('welcome', $data);
		}
	}
	
	function add_user()
	{
		// $this->tank_auth->create_user("username","email@domain.org","password",false);
		// $this->tank_auth->set_password(2,"password");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */