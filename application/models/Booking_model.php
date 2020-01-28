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


public function getTheRoom($id)
{
	$this->db->where('rooms.id',$id);
	$this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
	$query = $this->db->get('rooms');
	return $query->result();
}

public function getAllBuildings()
    {
        $query = $this->db->get('buildings');
        return $query->result();
	}

    function getAllBookings()
    {
        $query = $this->db->get('bookings');
        return $query->result_array();
    }

}

?>