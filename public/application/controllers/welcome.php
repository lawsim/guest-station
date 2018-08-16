<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class welcome extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('welcome_model');
	}

	public function index()
	{
		$data['class'] = $this->input->get('class');
		
		$data['title'] = "Check-in student to class";
		$data['main_content'] = "welcome/index";
		$this->load->view('includes/template',$data);
	}
	
	public function guest_checkin()
	{
		$data['title'] = "Check-in";
		$data['main_content'] = "welcome/guest_checkin";
		$this->load->view('includes/template',$data);
	}
	
	public function list_guests()
	{
		$data['guests'] = $this->welcome_model->get_guests();
		
		$data['title'] = "Guests";
		$data['main_content'] = "welcome/list_guests";
		$this->load->view('includes/template',$data);
	}
	
	public function classinfo()
	{
		$classid = $this->input->get('class');
		$data['checkins'] = $this->welcome_model->get_checkins($classid);
		$data['class'] = $this->welcome_model->get_class_info($classid);
		
		$data['title'] = "Class Info";
		$data['main_content'] = "welcome/classinfo";
		$this->load->view('includes/template',$data);
	}
	
	// ajax functions below
	
	public function get_student_by_card()
	{
		$student_card_id = $this->input->post('stucard');
		$classid = $this->input->post('class');
		
		// echo $student_card_id;
		
		// card scan was blank
		if($student_card_id == "")
		{
			die("Card scan was blank");
		}
		
		$data['student'] = $this->welcome_model->get_student_by_cardid($student_card_id);
		$data['class'] = $this->welcome_model->get_class_info($classid);
		$stuid = $data['student']->row()->id;
		$data['checkin_stu'] = $this->welcome_model->checkin_student($stuid,$classid);
		
		$data['main_content'] = "welcome/index";
		$this->load->view('welcome/get_student_by_card',$data);
	}
	
	public function checkin_guest()
	{
		$img_base64 = $this->input->post('imguri');
		$img = addslashes(base64_decode( $img_base64));
		$name = $this->input->post('fullname');
		
		$this->welcome_model->checkin_guest($name,$img_base64);
		
		echo "Checked in!";
		// echo $img_base64;
	}
	
	
}
