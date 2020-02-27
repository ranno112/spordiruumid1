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

		var $table = "bookingTimes";  
		var $select_column = array("timeID", "startTime", "endTime", "roomID","public_info","workout");  
		var $order_column = array(null, "startTime", "startTime", "roomID","public_info", null);  
		function make_query()  
		{  
			 $this->db->select($this->select_column);  
			 $this->db->join('bookings', 'bookingTimes.bookingID = bookings.id' , 'left');
			 $this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
			 $this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
			 $this->db->from($this->table);  
			 if(isset($_POST["search"]["value"]))  
			 {  
				  $this->db->like("startTime", $_POST["search"]["value"]);  
				  $this->db->or_like("roomID", $_POST["search"]["value"]);  
				  $this->db->or_like("public_info", $_POST["search"]["value"]);  
			 }  
			 if(isset($_POST["order"]))  
			 {  
				  $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
			 }  
			 else  
			 {  
				  $this->db->order_by('timeID', 'DESC');  
			 }  
		}  
		function make_datatables(){  
			 $this->make_query();  
			 if($_POST["length"] != -1)  
			 {  
				  $this->db->limit($_POST['length'], $_POST['start']);  
			 }  
			 
			 $query = $this->db->get();  
			 return $query->result();  
		}  
		function get_filtered_data(){  
			
			 $this->make_query();  
			 $query = $this->db->get();  
			 return $query->num_rows();  
		}       
		function get_all_data()  
		{  
			 $this->db->select("*"); 
			 $this->db->join('bookings', 'bookingTimes.bookingID = bookings.id' , 'left');
			 $this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
			 $this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');  
			 $this->db->from($this->table);  
			 return $this->db->count_all_results();  
		}  


	}
