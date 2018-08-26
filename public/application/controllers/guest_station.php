<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class guest_station extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('guest_station_model');
		
		// load tank auth check logged in
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		
		$is_logged_in = $this->tank_auth->is_logged_in();
		

		$ip = $_SERVER['REMOTE_ADDR'];
		$ip == "::1" ? $ip = "127.0.0.1" : false;
		// echo $ip;
		// die();
		$station = $this->guest_station_model->get_station_information_byip($ip);
		if($station->num_rows() > 0 || $ip == "127.0.0.1" || $ip == "::1")
		{
			$station_row = $station->row();
			$this->uid = $station_row->stationid;
		}
		elseif(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('/auth/login?redirect_page=guest_station');
		}
		else
		{
			$this->uid = $this->tank_auth->get_user_id();
		}
		
		// echo $this->uid;
			
	}

	public function index()
	{
		// $data['message'] = "";
		// if(isset($this->input->get('message')))
		$data['message'] = $this->input->get("message");
		
		$data['station_info'] = $this->guest_station_model->get_station_information($this->uid);
		
		$data['title'] = "Check-in";
		$data['main_content'] = "guest_station/index";
		$this->load->view('includes/template',$data);
	}
	
	public function checkout()
	{
		$data['station_info'] = $this->guest_station_model->get_station_information($this->uid);
		
		$data['date'] = date('Y-m-d');
		
        $userinfo = $this->guest_station_model->get_userinfo($this->uid);
		// echo $this->uid;
		// print_r($userinfo);
        
		$data['guests'] = $this->guest_station_model->get_guests($data['date'],$userinfo->location, true);
		
		$data['title'] = "Guests";
		$data['main_content'] = "guest_station/checkout";
		$this->load->view('includes/template',$data);
	}
	
	public function checkout_guest()
	{
		$img_base64 = $this->input->post('imguri');
		$img = addslashes(base64_decode( $img_base64));
		$guestid = $this->input->post('guestid');
		// $name = $this->input->post('fullname');
		$stationid = $this->input->post('stationid');
		// $site = $this->input->post('site');
		// $location = $this->input->post('location');
		// $reason = $this->input->post('reason');
		
		$guestinfo = $this->guest_station_model->get_guest_info($guestid);
		
		$this->guest_station_model->checkout_guest($guestid,$img_base64);
        
        $station_info = $this->guest_station_model->get_station_information($stationid);
		
		echo "Thank you for checking in " . $guestinfo->name;
		// echo $station_info->checked_message;
		// echo $this->input->post('site');
		// echo $img_base64;
	}
	
	public function list_guests()
	{
		$data['date'] = $this->input->get_post("date");
		
		if(empty($data['date']))
		{
			$data['date'] = date('Y-m-d');
		}
		
        $userinfo = $this->guest_station_model->get_userinfo($this->uid);
		
		// echo $this->uid;
		// print_r($userinfo);
		// die();
        
		$data['guests'] = $this->guest_station_model->get_guests($data['date'],$userinfo->location);
		
		$data['title'] = "Guests";
		$data['main_content'] = "guest_station/list_guests";
		$this->load->view('includes/template',$data);
	}
	
	public function checkin_guest()
	{
		$img_base64 = $this->input->post('imguri');
		$img = addslashes(base64_decode( $img_base64));
		$fname = $this->input->post('fullname');
		$lname = $this->input->post('lastname');
		$name = $fname . " " . $lname;
		$stationid = $this->input->post('stationid');
		$site = $this->input->post('site');
		$location = $this->input->post('location');
		$reason = $this->input->post('reason');
		
		$this->guest_station_model->checkin_guest($name,$img_base64,$stationid,$site,$location,$reason);
        
        $station_info = $this->guest_station_model->get_station_information($stationid);
		
		$this->print_label_new($station_info->printer, $station_info->site_name . " VISITOR", $fname, $lname, $reason);
		// echo $station_info->printer;
		// echo $station_info->site_name;
		// echo $fname;
		// echo $lname;
		// echo $reason;
		// die();
		
		// echo "Thank you " . $name . "<br />\n";
		echo $station_info->checked_message;
		// echo $this->input->post('site');
		// echo $img_base64;
	}
	
	private function print_label($printer_ip, $school, $name, $message)
	{
		return system('python C:\scripts\label-print\print-to-labeler.py "' . $printer_ip . '" "' . $school . '" "' . $name . '" "' . $message . '"', $retval);
	}
	
	private function print_label_new($printer_ip, $school, $fname, $lname, $message)
	{
		exec('python ' . BROTHER_SCRIPT_PATH . 'generate_label.py "' . $printer_ip . '" "' . $school . '" "' . $fname . '" "' . $lname . '" "' . $message . '" 2&1', $output);
		// print_r($output);
		return $output;
	}
	
}
