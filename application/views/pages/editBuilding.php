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
												<input type="button" id="active' . $value['id']. '" class="btn btn-custom btn-width-md text-white text-center py-1 px-2 txt-strong" value="Aktiivne"> 
												<a class="btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong" href="' 
												. base_url() . 'building/deleteRoom/' . $value['id'] . '">Kustuta</a></div>'); 
                      }}; ?>
                </div>
                <div class="form-label-group py-0 px-5 mx-5">
                    <label class="txt-regular txt-lg">Mitteaktiivsed ruumid</label>
                    <?php foreach ($editBuildings as $key => &$value) { 
                      if ($value['roomActive'] == 0) { 
												echo('<div class="d-flex mb-3 p-0 justify-content-between">
												<input class="form-control col-8" id="inactiveRoom[]" type="text" name="room[]" value="' . $value['roomName'] .'">
												<input type="button" id="inactive' . $value['id']. '" class="btn btn-inactive btn-width-md text-white text-center py-1 px-2 txt-strong" value="Mitteaktiivne">
												<a class="btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong" href="' 
												 . base_url() . 'building/deleteRoom/' . $value['id'] . '">Kustuta</a></div>');
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

  $('#lisaSaal').on('click', function() {
    $('#saalid').append('<div class="d-flex mb-3 p-0 justify-content-between"><input class="form-control col-8" id="activeRoom[]" type="text" name="additionalRoom[]" value=""><input name="colorForNewRoom[]" type="color"><input type="button" id="active<?php echo($value["id"]); ?>" class="btn btn-second btn-width-md text-white text-center py-1 px-2 txt-strong" value="Aktiivne"><a class="btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong" href="<?php echo(base_url()); ?>building/deleteRoom/<?php echo($value["id"]); ?>">Kustuta</a></div>');
  });


</script>
