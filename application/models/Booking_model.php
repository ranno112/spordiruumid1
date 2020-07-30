<?php

class Booking_model extends CI_Model
{

public function create_booking($data1){

	$this->db->trans_start();


	$this->db->insert('bookings', $data1);
	return $this->db->insert_id();

}

public function create_bookingTimes($insert_data){
		
	//	$this->db->insert('bookingTimes', $data2);
//	var_dump($insert_data);
	
		if (empty($insert_data)) {
			$this->db->trans_rollback();
	   }
	   else{
		$this->db->insert_batch('bookingTimes', $insert_data);
	
			$this->db->trans_complete();
			return $this->db->insert_id();
		}
	

	}



	public function get_conflictsDates($insert_data, $inserted_room){
		
			$this->db->select("created_at, startTime, endTime, public_info, workout, roomName");  
			$this->db->order_by('bookingTimes.startTime');
			$this->db->join('bookings', 'bookingTimes.bookingID = bookings.id' , 'left');
			$this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
			$this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
			$this->db->where('buildingID', $insert_data);
			$this->db->where('roomID',  $inserted_room);
			$this->db->where('DATE(startTime) >=', date('Y-m-d H:i:s',strtotime("-1 day")));
			$query=$this->db->get('bookingTimes');
			return  $query->result();
		
	
		}


	public function checkIfRoomIsBookable($roomID)
	{
		if($this->session->userdata('roleID')=='2' || $this->session->userdata('roleID')=='3'){
			$this->db->where('rooms.buildingID', $this->session->userdata('building'));
			$this->db->where('rooms.id',$roomID);
			$query = $this->db->get('rooms');
			return $query->result_array();
	
		}
	}
		


public function getAllRooms()
{
	if($this->session->userdata('roleID')=='2' || $this->session->userdata('roleID')=='3'){
		$this->db->order_by('id');
		$this->db->where('rooms.buildingID', $this->session->userdata('building'));
		$query = $this->db->get('rooms');
		return $query->result();

	}else{

	$this->db->order_by('id');
	$query = $this->db->get('rooms');
	return $query->result();}
}



public function getAllBuildings()
    {
        $query = $this->db->get('buildings');
        return $query->result();
	}


	var $table = "bookingTimes";  


    function getAllBookings()
    {
		//$this->db->distinct();
		$this->db->select("created_at, public_info, c_name, c_phone, c_email, count(c_name) AS counter");  
	
		$this->db->join('bookingTimes', ' bookings.id=bookingTimes.bookingID ' , 'left');
		$this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
		$this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
		$this->db->where('buildingID',  $this->session->userdata('building'));

		$this->db->where_not_in('public_info', "Suletud");
		$this->db->group_by('c_name');
		$this->db->order_by('counter','desc');
   	//	$query = $this->db->get('bookings');
		
		$this->db->limit(15);
        $query = $this->db->get('bookings');
        return $query->result_array();
    }

	function getUnapprovedBookings($buildingID )
	{
		$this->db->select("roomID, approved, startTime, id, buildingID");
		$this->db->where('DATE(startTime) >=', date('Y-m-d'));
		$this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
		$this->db->where('rooms.buildingID', $buildingID);
		$this->db->where('approved !=', 1);
		$query = $this->db->count_all_results('bookingTimes');

		return $query;
	}

}

?>
