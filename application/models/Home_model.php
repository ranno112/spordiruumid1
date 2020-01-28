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
        $query = $this->db->get('buildings');
        return $query->result();
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

    function getAllRooms()
    {
        $query = $this->db->get('rooms');
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

