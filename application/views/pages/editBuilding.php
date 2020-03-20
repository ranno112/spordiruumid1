<?php if($this->session->userdata('roleID')==='2'||$this->session->userdata('roleID')==='3'||$this->session->userdata('roleID')==='1'){?>
 <div class="container">
	<div class="container-md mx-auto mt-5">
		<div class="form-bg">

            <div class="d-flex mb-5">
                <ul class="nav nav-tabs nav-justified col-12 bg-grey p-0">
                    <li class="nav-item p-0"><a class="nav-link link txt-lg single-tab active pl-5" data-toggle="tab"><?php foreach ($editBuildings as $value) {echo $value['name'];break;}?> sätted</a></li>
                    <li class="nav-item p-0"></li><li class="nav-item p-0"></li>
                </ul>
            </div>

            <form id="change" method="post" action="<?php echo base_url(); ?>building/update">
            <input class="d-none" type="hidden" name="id" value="<?php echo $this->uri->segment(3);?>">
					
								<h4 class="pt-2 txt-xl px-5 mx-5">Asutuse info</h4>

								<div class="d-flex p-0 mt-4 px-5 mx-5">
                    <div class="form-label-group col-6 py-0 pl-0 pr-5">
										<label for="status">Piirkond</label>
                    <select id="place" name="place" class="form-control arrow">
										<?php foreach($regions as $region) {?>
												<option value="<?php echo $region['regionID'];?>" <?php if ($editBuildings[0]['regionID']==$region['regionID']){echo 'selected';}?>><?php echo $region['regionName'];?></option>
										<?php }?>
                    </select>
                    </div>
                </div>
                <div class="d-flex p-0 mt-4 px-5 mx-5">
                    <div class="form-label-group col-6 py-0 pl-0 pr-5">
                        <label>Kontakt email*</label>
                        <input class="form-control" id="contact_email" type="email" name="email" value="<?php foreach ($editBuildings as $value) {echo $value['contact_email'];break;}?>">
                    </div>
                    <div class="form-label-group col-6 p-0 pl-5">
                        <label>Päringute email*</label>
                        <input class="form-control" id="notify_email" type="email" name="notifyEmail" value="<?php foreach ($editBuildings as $value) {echo $value['notify_email'];break;}?>">
                    </div>
                </div>

                <div class="d-flex p-0 mt-4 px-5 mx-5">
                    <div class="form-label-group col-6 py-0 pl-0 pr-5">
                        <label>Telefoni number*</label>
                        <input class="form-control" id="phone" type="number" name="phone" value="<?php foreach ($editBuildings as $value) {echo $value['phone'];break;}?>">
                    </div>
                    <div class="form-label-group col-6 p-0 pl-5">
                        <label>Hinnakirja link (url)</label>
                        <input class="form-control" id="price_url" type="text" name="price_url" value="<?php foreach ($editBuildings as $value) {echo $value['price_url'];break;}?>">
                    </div>
                </div>

                <h4 class="mt-5 txt-xl px-5 mx-5 pb-3">Ruumid</h4>
                <div class="form-label-group py-0 px-5 mx-5" id="saalid">
                    <label class="txt-regular txt-lg">Aktiivsed ruumid</label>
                    <?php foreach ($editBuildings as $value) { 
									
                      if ($value['roomActive'] == 1) { 
												echo('<div class="d-flex mb-3 p-0 justify-content-between"> 
												<input class="d-none" type="hidden" name="roomID[]" value="'.$value['id'].'"> 
												<input class="form-control col-6" id="activeRoom[]" type="text" name="room[]" value="' . $value['roomName'] .'">
												<input name="color[]" type="color" value="'. $value["roomColor"] .'">
												<input type="button" id="active'.$value['id'].'" data-id="'.$value['id'].'" class="btn btn-custom btn-width-md text-white text-center py-1 px-2 txt-strong" value="Aktiivne"> 

												<input data-id="'.$value['id'].'" class="btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong"  type="button" value="Kustuta">
												</div>'); 
                      }}; ?>
                </div>
                <div class="form-label-group py-0 px-5 mx-5">
                    <label class="txt-regular txt-lg">Mitteaktiivsed ruumid</label>
                    <?php foreach ($editBuildings as $key => $value) { 
                      if ($value['roomActive'] == '0') { 
												echo('<div class="d-flex mb-3 p-0 justify-content-between">
												<input class="d-none" type="hidden" name="roomID[]" value="'.$value['id'].'"> 
												<input class="form-control col-6" id="inactiveRoom[]" type="text" name="room[]" value="' . $value['roomName'] .'">
												<input name="color[]" type="color" value="'. $value["roomColor"] .'">
												<input type="button" id="active' . $value['id']. '" data-id="'.$value['id'].'" class="btn btn-inactive btn-width-md text-white text-center py-1 px-2 txt-strong" value="Mitteaktiivne">
												<input data-id="'.$value['id'].'" class="btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong"  type="button" value="Kustuta">
												 </div>');
                      }}; ?>
                </div>

                <div class="flex mx-5 px-5 mt-5">
                    <a id="lisaSaal" class="btn btn-custom text-white text-center py-2 px-4 pluss"><p class="m-0 px-0 txt-lg txt-strong text-center align-items-center">Lisa saal</p></a>
                </div>

                <div class="d-flex justify-content-end my-5 px-5 mx-5">
                  <a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="<?php echo base_url(); ?>building/view/<?php  print_r($this->session->userdata['building']);?>">Katkesta</a>
                    <button type="submit" class="btn btn-custom col-5 text-white txt-xl">Salvesta muudatused</button>
                </div>
            </form>

        </div>
    </div>
</div>
                    <?php } else { redirect(''); }?>


                             
<script>

$( document ).ready(function() {
	var counter=1;
   $('#lisaSaal').on('click', function() {
    $('#saalid').append('<div class="d-flex mb-3 p-0 justify-content-between"><input class="form-control col-6" id="activeRoom[]" type="text" name="additionalRoom[]" value=""><input name="colorForNewRoom[]" type="color" value="#cbe9fe"><input type="button" id="active<?php echo($value["id"]); ?>" class="btn btn-custom btn-width-md text-white text-center py-1 px-2 txt-strong" value="Aktiivne">	<input data-id="<?php echo $value['id']; ?>" id="additionalRoom'+counter+'" class="abc btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong"  type="button" value="Kustuta"></div>');
	counter++;
  });

  $(document).on('click', '.abc', function() { 
	
	  $(this).parent().remove(); 
	  });


  $(".btn-delete").on("click", function() {
	console.log($(this).data("id"));
	var elementToDelete=$(this);
    $.ajax({
	  url: "<?php echo base_url(); ?>building/deleteRoom",
      method: "POST", // use "GET" if server does not handle DELETE
      data: { "roomID": $(this).data("id") },
      dataType: "html"
    }).done(function( msg ) {

			if(msg=='""'){  
				elementToDelete.parent().remove(); 
			}
			else{
			$( "#textMessageToUser" ).append('<p class="alert alert-danger text-center">'+msg+'</p>');
		window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
			}, 4000);}
	
    }).fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    }); 
  });

 
  


  $('input[id^="active"]').on("click", function() {
	console.log($(this).data("id"));
	console.log($(this).val());
	var roomStatus=1;
	if($(this).val()=="Aktiivne"){
		$(this).val("Mitteaktiivne");
		$(this).removeClass("btn-custom");
		$(this).addClass("btn-inactive");
		roomStatus=0;
		
	} 
	else{
		$(this).val("Aktiivne");
		$(this).removeClass("btn-inactive");
		$(this).addClass("btn-custom");
		roomStatus=1;
	}
	
	var elementToDelete=$(this);
    $.ajax({
	  url: "<?php echo base_url(); ?>building/roomStatus",
      method: "POST", // use "GET" if server does not handle DELETE
      data: { 
		"roomID": $(this).data("id"),
	    "roomStatus": roomStatus
		 },
      dataType: "html"
    }).done(function( msg ) {

	
    }).fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    }); 
  });



});



</script>
