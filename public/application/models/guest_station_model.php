<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class guest_station_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function get_guests($date,$location,$checkedinonly=false)
	{
		$this->db->select('*');
		$this->db->from('guest_checkin g');
        $this->db->where('date(g.intime)',$date);
        $this->db->where('g.site',$location);
		
        $checkedinonly ? $this->db->where('g.outtime IS NULL') : false;
		
		$this->db->order_by("g.intime",'desc');

		$q = $this->db->get();
		
		return $q;
	}
	
	function get_guest_info($guestid)
	{
		$this->db->select('*');
		$this->db->from('guest_checkin g');
        $this->db->where('g.guestid',$guestid);
		
        // $checkedinonly ? $this->db->where('g.outtime IS NULL') : false;

		$q = $this->db->get();
		
		return $q->row();
	}
    
    function get_userinfo($uid)
	{
		$this->db->select('*');
		$this->db->from('users u');
        $this->db->join('user_details ud','u.id = ud.userid');
        
        $this->db->where('u.id',$uid);

		$q = $this->db->get();
		
		return $q->row();
	}
	
	function get_station_information($stationid)
	{
		$this->db->select('*');
		$this->db->from('guest_stations gs');
		$this->db->join('sites si','si.site_id = gs.site');
		$this->db->where('gs.stationid',$stationid);

		$q = $this->db->get();
		
		return $q->row();
	}
	
	function get_station_information_byip($ip)
	{
		$this->db->select('*');
		$this->db->from('guest_stations gs');
		$this->db->join('sites si','si.site_id = gs.site');
		$this->db->where('gs.ip',$ip);

		$q = $this->db->get();
		return $q;
	}
	
	function checkin_guest($name,$image,$stationid,$site,$location,$reason)
	{
		$data = array(
			'name' => $name,
			'picture' => $image,
			'stationid' => $stationid,
			'site' => $site,
			'location' => $location,
			'reason' => $reason
		);
		
		return $this->db->insert('guest_checkin', $data);
	}
	
	function checkout_guest($guestid,$image)
	{
		$data = array(
			'outtime' => date("Y-m-d H:i:s"),
			'outpicture' => $image
		);
		
		$this->db->where('guestid',$guestid);
		$this->db->update('guest_checkin', $data);
	}
}