<?php
	class AllBookings_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function get_bookings($slug = FALSE){
		
			$this->db->distinct();
			$query = $this->db->get('bookings');
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

		function fetch_all_rooms($buildingID){
			$this->db->order_by('roomName');
			$this->db->where('buildingID', $buildingID);
			return $this->db->get('rooms');
		}

		function fetch_all_rooms_for_checkbox($buildingID){
			$this->db->order_by('roomName');
			$this->db->where('buildingID', $buildingID);
			$query =  $this->db->get('rooms');
			return $query->result_array();
		}


		var $table = "bookingTimes";  
		var $select_column = array("created_at", "roomName", "startTime", "endTime","approved","public_info", "workout", "comment","c_name","c_phone","c_email","takes_place","timeID","roomID",);  
		//järgmisel real kirjeldan ära millste lahtritega saab sorteerida
		var $order_column = array("created_at", "roomID",  null, "startTime", null, null,  null,"approved","public_info", "workout", "comment","c_name","c_phone","c_email","takes_place");   
		function make_query()  
		{  
			 $this->db->select($this->select_column);  
			
			 $this->db->join('bookings', 'bookingTimes.bookingID = bookings.id' , 'left');
			 $this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
			
			 $this->db->join('buildings', 'rooms.buildingID = buildings.id' , 'left');
			 $this->db->where('buildingID',  $this->session->userdata('building'));
			 $this->db->from($this->table);
			 if(isset($_POST["is_date_search"])){
			
				$this->db->where('DATE(startTime) >=', date('Y-m-d H:i:s',strtotime($_POST["start_date"])));
				$this->db->where('DATE(startTime) <=', date('Y-m-d H:i:s',strtotime($_POST["end_date"])));
				
			//	print_r( $this->db->get("bookingTimes"));
			 }
			
			 if(isset($_POST["search"]["value"]))  
			 {  
				 
				 $this->db->group_start();
				 $this->db->like("startTime", $_POST["search"]["value"]);  
				  $this->db->or_like("LOWER(roomName)", $_POST["search"]["value"]);  
				  $this->db->or_like("LOWER(public_info)", $_POST["search"]["value"]);  
				  $this->db->or_like("LOWER(workout)", $_POST["search"]["value"]);  
				  $this->db->or_like("created_at", $_POST["search"]["value"]);  
				  $this->db->or_like("LOWER(comment)", $_POST["search"]["value"]);  
				  $this->db->or_like("LOWER(c_name)", $_POST["search"]["value"]);  
				  $this->db->or_like("LOWER(c_phone)", $_POST["search"]["value"]);  
				  $this->db->or_like("LOWER(c_email)", $_POST["search"]["value"]);  
				  $this->db->group_end();
				//  $this->db->order_by('startTime', 'ASC');  
				
			 }  
			
			 
			 if(isset($_POST["order"]))  
			 {  
				  $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
			 }  
			 else  
			 {  
				if(isset($_POST["orderBy"]))  
				{  
				   $this->db->order_by('timeID', 'DESC');    
				} 
				else{
				  $this->db->order_by('startTime', 'ASC');  }
				  
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

			
			$this->make_query(); 
		
			if(isset($_POST["is_date_search"])){
			
				$this->db->where('DATE(startTime) >=', date('Y-m-d H:i:s',strtotime($_POST["start_date"])));
				$this->db->where('DATE(startTime) <=', date('Y-m-d H:i:s',strtotime($_POST["end_date"])));
				
			
			 }
		//	 $this->db->from($this->table); 
			
			 return $this->db->count_all_results();  
		}  

	
		function getUnapprovedBookings($buildingID , $roomID)
		{
			$this->db->select("roomID, approved, startTime, id, buildingID");
			$this->db->where('DATE(startTime) >=', date('Y-m-d'));
			$this->db->join('rooms', 'bookingTimes.roomID = '. $roomID , 'left');
			$this->db->where('rooms.buildingID', $buildingID);
			$this->db->where('rooms.id',$roomID );
			$this->db->where('approved !=', 1);
			$query = $this->db->count_all_results('bookingTimes');
			
	
			return $query;
		}



	}
