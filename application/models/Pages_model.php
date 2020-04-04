<?php


class Pages_model extends CI_Model
{

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
	function getAllRooms($roomid)
    {
      
        $this->db->where('rooms.id', $roomid);
		$this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
		$this->db->join('regions', 'buildings.regionID = regions.regionID' , 'left');
		$query = $this->db->get('rooms');
		return $query->row_array();
      
    }
    function getAllBuildingRooms()
    {
		if (empty($this->session->userdata('roleID'))  || $this->session->userdata('roleID')==='4'){
			$this->db->where('roomActive','1');
		}
        $query = $this->db->get('rooms');
        return $query->result();
    }

    function getAllBuildings()
    {
        $query = $this->db->get('buildings');
        return $query->result();
    }

    function getAllRegions()
    {
      
        $this->db->order_by('regionID');
        $query = $this->db->get('regions');
        return $query->result();
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

