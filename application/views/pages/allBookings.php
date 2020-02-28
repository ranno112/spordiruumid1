
 <head>  
  
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
     
      <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
      <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
   <style>  
         
      </style>  
 </head>  
 <body> 
 
      <div class="container box">  
	   
	 
<br>

	 <div class="form-row">
	
    <div class="col-md-2">
   
    <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo date('Y-m-01'); ?>" />
    </div>
    <div class="col-md-2">
   
    <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo date('Y-m-t'); ?>" />
    </div>
    <div>
  <div class="col-md-2">
	  
      <input type="button" name="search" id="search" value="Filtreeri" class="btn btn-info" />
	</div>	</div>
	</div>
         
    
	
                <br />  
                <table id="user_data" class="table  compact table-striped">  
				 
                     <thead>  
                          <tr>  

					 <th >Päringu aeg</th>  
                               <th >Ruumi nimi</th>  
							   <th>Nädalapäev</th>  
							   <th>Kuupäev</th>  
							   <th>Alates</th>  
                               <th>Kuni</th>  
                               <th>Kestus</th>  
					<th class="py-2 txt-strong text-darkblue" scope="col">Kinnitatud</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col">Klubi</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col">Trenn</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Kommentaar</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Kontaktisik</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Telefon</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">e-mail</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Jäi ära</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Muuda või kustuta</th>
					

                              
                          </tr>  
                     </thead>  
                </table>  
           </div>  
      </div>  
 </body>  

 <script type="text/javascript" language="javascript" >  
 $(document).ready(function(){  
      var dataTable = $('#user_data').DataTable({  
		
           "processing":true,  
           "serverSide":true,  
		
		 "compact":true,
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url() . 'allbookings/fetch_allbookings'; ?>",  
                type:"POST",  data:{
				orderBy:"orderBy"
			},
			
           },  
		
           "columnDefs":[  
                {  
                     "targets":[2, 4,5,6, 15],  
                     "orderable":false,  
                },  
           ],  
      });  

	

function fetch_data(is_date_search, start_date='', end_date='')
 {
  var dataTable = $('#user_data').DataTable({
   "processing" : true,
   "compact":true,
   "serverSide" : true,
   "order" : [],
   "ajax" : {
	url:"<?php echo base_url() . 'allbookings/fetch_allbookings'; ?>",  
    type:"POST",
    data:{
     is_date_search:is_date_search, start_date:start_date, end_date:end_date
    },
    
   },
   "columnDefs":[  
                {  
                     "targets":[2, 4,5,6, 15],  
                     "orderable":false,  
                },  
           ],  
  });
 }



$('#search').click(function(){
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();
  if(start_date != '' && end_date !='')
  {
   $('#user_data').DataTable().destroy();
   fetch_data('yes', start_date, end_date);
  }
  else
  {
   alert("Both Date is Required");
  }
 }); 
 });  
 </script>  
