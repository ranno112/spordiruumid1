<?php

class Fullcalendar_model extends CI_Model
{
	function fetch_all_event(){
		$this->db->order_by('bookingTimes.startTime');
		$this->db->join('bookings', 'bookingTimes.bookingID = bookings.id' , 'left');
		$this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
		$this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
		return $this->db->get('bookingTimes');
	}

	function getAllRooms($id)
    {
		$this->db->where('id', $id);
		$this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
		$this->db->join('regions', 'buildings.id = regions.regionID' , 'left');
		$query = $this->db->get('rooms');
		return $query->result();
      
	}
  

	function update_event($data, $id)
	{
		$this->db->where('timeID', $id);
		$this->db->update('bookingTimes', $data);
	}

	function delete_event($id)
	{
		$this->db->where('timeID', $id);
		$this->db->delete('bookingTimes');
	}

	function deleteTImesAndBooking($id)
	{
	
		$this->db->delete('bookingTimes', array('bookingID' => $id));
		$this->db->delete('bookings', array('id' => $id));

	}

	function fetch_city($country_id)
    {
        $this->db->where('regionID', $country_id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('buildings');
        $output = '<option value="">Select Asutus</option>';
        foreach ($query->result() as $row) {
            $output .= '<option  data-value="' . $row->id . '" value="' . $row->name . '">'.$row->name.'</option>';
        }
        return $output;
    }


    function fetch_building($state_id)
    {
        $this->db->where('buildingID', $state_id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('rooms');
        $output = '<option value="">Select room</option>';
        foreach ($query->result() as $row) {
            $output .= '<option  data-value="' . $row->id . '" value="' . $row->roomName . '">'.$row->roomName.'</option>';
        }
        return $output;
    }





}

?>
