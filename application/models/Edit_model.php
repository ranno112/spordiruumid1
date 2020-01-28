<?php

class Edit_model extends CI_Model
{

   function fetch_all_event(){
	$this->db->select("*");
	$this->db->select("DATE_FORMAT(bookingTimes.startTime, '%Y-%m-%dT%H:%i') AS startTime", FALSE);
	$this->db->select("DATE_FORMAT(bookingTimes.endTime, '%Y-%m-%dT%H:%i') AS endTime", FALSE);
		$this->db->order_by('bookingTimes.startTime');
		$this->db->join('bookings', 'bookingTimes.bookingID = bookings.id' , 'left');
		$this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
		$this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
	//	$this->db->join('bookingTypes', 'bookings.typeID = bookingTypes.id' , 'left');
		return $this->db->get('bookingTimes');
	}


	function fetch_all_Booking_times(){
		$this->db->order_by('bookingTimes.timeID');
		$this->db->join('bookings', 'bookingTimes.bookingID = bookings.id' , 'left');
		return $this->db->get('bookingTimes');
		}


	function update_booking($data1, $id){


		$this->db->where('id', $id);
		$this->db->update('bookings', $data1);
	
	}
	
	function update_bookingTimes($insert_data, $id){
			
		//	$this->db->insert('bookingTimes', $data2);
		$this->db->where('timeID', $id);
		$this->db->update('bookingTimes', $insert_data);
	//	var_dump($insert_data);
		}


	function insert($insert_data, $id){
		
		$this->db->where('bookingID', $id);
		$this->db->insert('bookingTimes', $insert_data);
		return $this->db->insert_id();
		}
	


}

?>