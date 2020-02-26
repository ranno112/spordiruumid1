<?php
	class AllBookings_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function get_bookings($slug = FALSE){
			$this->db->order_by('rooms.id');
			$this->db->order_by('bookingTimes.startTime');
			$this->db->join('bookings', 'bookingTimes.bookingID = bookings.id' , 'left');
			$this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
			$this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
			$query = $this->db->get('bookingTimes');
			return $query->result_array();
		}

		function fetch_all_event($buildingID){
			$this->db->order_by('bookingTimes.startTime');
			$this->db->join('bookings', 'bookingTimes.bookingID = bookings.id' , 'left');
			$this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
			$this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
			$this->db->where('buildingID', $buildingID);
			return $this->db->get('bookingTimes');
		}

	



	}
