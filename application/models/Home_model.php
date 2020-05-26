<?php


class Home_model extends CI_Model
{


    function getAllRegions()
    {
        // ennem tegin nagu allpool (allikas: https://stackoverflow.com/questions/19922143/display-data-from-database-to-dropdown-codeigniter)
        // $query = $this->db->query('SELECT name FROM regions');
        // return $query->result();


        $this->db->order_by('regionID');
        $query = $this->db->get('regions');
        return $query->result();
    }

    function getAllBuildings()
    {
		$this->db->select("name, buildings.id");
		$this->db->distinct();
		$this->db->join('rooms', 'buildings.id  = rooms.buildingID' , 'left');
		$this->db->where('roomActive','1');
		$query = $this->db->get('buildings');
	    return $query->result();
    }

    function fetch_city($country_id)
    {
		$this->db->where('regionID', $country_id);
        $this->db->order_by('id', 'ASC');
        $this->db->select("name, buildings.id");
		$this->db->distinct();
		$this->db->join('rooms', 'buildings.id  = rooms.buildingID' , 'left');
		if (empty($this->session->userdata('roleID'))  || $this->session->userdata('roleID')==='4'){
			$this->db->where('roomActive','1');
			}
        $query = $this->db->get('buildings');
        $output = '<option value="">Select Asutus</option>';
        foreach ($query->result() as $row) {
            $output .= '<option  data-value="' . $row->id . '" value="' . $row->name . '">'.$row->name.'</option>';
        }
        return $output;
    }

    function getAllRooms()
    {
		if (empty($this->session->userdata('roleID'))  || $this->session->userdata('roleID')==='4'){
		$this->db->where('roomActive','1');
		}
		$query = $this->db->get('rooms');
        return $query->result();
	}
	
	function getRoomsFromRegion($country_id)
    {
		$this->db->select("rooms.id, rooms.roomName,roomActive");
        $this->db->where('buildings.regionID', $country_id);
	//	$this->db->order_by('id', 'ASC');
		$this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
		$this->db->join('regions', 'buildings.id = regions.regionID' , 'left');
		if (empty($this->session->userdata('roleID'))  || $this->session->userdata('roleID')==='4'){
			$this->db->where('roomActive','1');
			}
        $query = $this->db->get('rooms');
        $output = '<option value="">Select Asutus</option>';
        foreach ($query->result() as $row) {
			if($row->roomActive==0){
				$output .= '<option  data-value="' . $row->id . '" value="' . $row->roomName . ' (peidetud)"></option>';
			}
			else{
				$output .= '<option  data-value="' . $row->id . '" value="' . $row->roomName . '">'.$row->roomName.'</option>';
			}
		}
	    return $output;
    }


    function fetch_building($state_id)
    {
		if (empty($this->session->userdata('roleID'))  || $this->session->userdata('roleID')==='4'){
			$this->db->where('roomActive','1');
			}
        $this->db->where('buildingID', $state_id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('rooms');
        $output = '<option value="">Select room</option>';
        foreach ($query->result() as $row) {
			if($row->roomActive==0){
				$output .= '<option  data-value="' . $row->id . '" value="' . $row->roomName . ' (peidetud)"></option>';
			}
			else{
				$output .= '<option  data-value="' . $row->id . '" value="' . $row->roomName . '">'.$row->roomName.'</option>';
			}
		}
        return $output;
	}
	
	

	function chech_if_has_request($email){
		$this->db->select("requestFromBuilding");
		$this->db->where('email',$email );
		$query = $this->db->get('users');
		return $query->row_array();
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

