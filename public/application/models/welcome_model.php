<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function get_student_by_cardid($cardid)
	{
		$this->db->select('*');
		$this->db->from('students s');
		
		$this->db->where("s.cardid",$cardid);

		$q = $this->db->get();
		
		return $q;
	}
	
	function get_checkins($classid)
	{
		$this->db->select('*');
		$this->db->from('checkins c');
		$this->db->join('students s','s.id = c.stu_id');
		
		$this->db->where("c.class_id",$classid);
		$this->db->order_by("c.time",'desc');

		$q = $this->db->get();
		
		return $q;
	}
	
	function get_guests()
	{
		$this->db->select('*');
		$this->db->from('guest_checkin g');
		
		$this->db->order_by("g.intime",'desc');

		$q = $this->db->get();
		
		return $q;
	}
	
	function get_class_info($classid)
	{
		$this->db->select('*');
		$this->db->from('classes c');
		$this->db->join('staff s','s.staff_id = c.staff_id');
		
		$this->db->where("c.class_id",$classid);

		$q = $this->db->get();
		
		return $q->row();
	}
	
	function checkin_student($stuid,$classid)
	{
		$data = array(
			'class_id' => $classid,
			'stu_id' => $stuid
		);
		
		return $this->db->insert('checkins', $data);
	}
	
	function checkin_guest($name,$image)
	{
		$data = array(
			'name' => $name,
			'picture' => $image
		);
		
		return $this->db->insert('guest_checkin', $data);
	}
}