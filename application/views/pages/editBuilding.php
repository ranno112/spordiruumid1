<?php if($this->session->userdata('roleID')==='2'||$this->session->userdata('roleID')==='3'||$this->session->userdata('roleID')==='1'){?>
 <div class="container">
	<div class="container-md mx-auto mt-5">
		<div class="form-bg">

            <div class="d-flex mb-5">
                <ul class="nav nav-tabs nav-justified col-12 bg-grey p-0">
                    <li class="nav-item p-0"><a class="nav-link link txt-lg single-tab active pl-5" data-toggle="tab">Asutuse sätted</a></li>
                    <li class="nav-item p-0"></li><li class="nav-item p-0"></li>
                </ul>
            </div>

            <form id="change" method="post" action="<?php echo base_url(); ?>building/update">
            <input class="d-none" type="hidden" name="id" value="<?php echo $this->uri->segment(3);?>">

                <h4 class="pt-2 txt-xl px-5 mx-5">Asutuse info</h4>
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

                <h4 class="mt-5 txt-xl px-5 mx-5 pb-3">Saalid</h4>
                <div class="form-label-group py-0 px-5 mx-5" id="saalid">
                    <label class="txt-regular txt-lg">Aktiivsed saalid</label>
                    <?php foreach ($editBuildings as $value) { 
                      if ($value['roomActive'] == 1) { 
                        echo('<div class="d-flex mb-3 p-0 justify-content-between"> <input class="d-none" type="hidden" name="roomID" value="'.$value['id'].'"> <input class="form-control col-8" id="activeRoom[]" type="text" name="room[]" value="' . $value['roomName'] .'"><input type="button" id="active' . $value['id']. '" class="btn btn-custom btn-width-md text-white text-center py-1 px-2 txt-strong" value="Aktiivne"><a class="btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong" href="' . base_url() . 'building/deleteRoom/' . $value['id'] . '">Kustuta</a></div>'); 
                      }}; ?>
                </div>
                <div class="form-label-group py-0 px-5 mx-5">
                    <label class="txt-regular txt-lg">Mitteaktiivsed saalid</label>
                    <?php foreach ($editBuildings as $key => &$value) { 
                      if ($value['roomActive'] == 0) { 
                        echo('<div class="d-flex mb-3 p-0 justify-content-between"><input class="form-control col-8" id="inactiveRoom[]" type="text" name="room[]" value="' . $value['roomName'] .'"><input type="button" id="inactive' . $value['id']. '" class="btn btn-inactive btn-width-md text-white text-center py-1 px-2 txt-strong" value="Mitteaktiivne"><a class="btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong" href="' . base_url() . 'building/deleteRoom/' . $value['id'] . '">Kustuta</a></div>');
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
 <!-- seda modalit siin oleks vaja selleks, et kujundada alerti juhul, kui saali kustutamisel peaks olema aktiivseid broneeringuid. Kahjuks ma ei saanud seda tööle :(  ) -->
 <!-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<div class="text-center">
  <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm">Launch
    Modal Login Form</a>
</div> -->

<!-- <input type="text" class="btn btn-outline-secondary" name="addRoomForm" id="addRoomForm" value=""/>

<input type="button" class="btn btn-success" name="openModal" id="openModal"  value="+ Lisa saal"> -->

                             
<script>

  $('#lisaSaal').on('click', function() {
    $('#saalid').append('<div class="d-flex mb-3 p-0 justify-content-between"><input class="form-control col-8" id="activeRoom[]" type="text" name="additionalRoom[]" value=""><input type="button" id="active<?php echo($value["id"]); ?>" class="btn btn-second btn-width-md text-white text-center py-1 px-2 txt-strong" value="Aktiivne"><a class="btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong" href="<?php echo(base_url()); ?>building/deleteRoom/<?php echo($value["id"]); ?>">Kustuta</a></div>');
  });

// $( "#openModal" ).click(function(e) {
//   e.preventDefault();
//   // $(this).data('clicked', true);
//   // $( this ).fadeOut( 100 );
//   // $( this ).fadeIn( 500 );
//   console.log( 'tere <?php foreach ($editBuildings as $value) {echo $value['buildingID'];break;}?>  '+$("#addRoomForm").val() );
//   if($("#addRoomForm").val() ){

//   $.ajax({
//         type: "POST",
//         url: "<?php echo base_url(); ?>building/createRoom",
//         data: { 
//             id: '<?php echo $this->uri->segment(3);?>',
//             roomName: $("#addRoomForm").val(),
//             status: 1  
//         },
//         success: function(result) {
//           $("#addRoomForm").before('<input type="button" class="btn btn-outline-secondary" value="'+ $("#addRoomForm").val() +'" /> ');
//           $('#addRoomForm').val('');
//            // alert('ok');
         
//         },
//         error: function(result) {
//             alert('error');
//         }
//     });
//   }else{
//     $('#addRoomForm').focus();

//   }
   // $( this ).parent().append('<input type="text" class="btn btn-outline-secondary" name="addRoomForm" id="addRoomForm" value="" /> ');

// });




</script>