<?php if($this->session->userdata('roleID')==='2'||$this->session->userdata('roleID')==='3'||$this->session->userdata('roleID')==='1'){?>
 <div class="container">
	<div class="container-md mx-auto mt-5">
		<div class="bg-white form-bg">

            <div class="d-flex mb-5">
                <ul class="nav nav-tabs nav-justified col-12 bg-grey p-0">
                    <li class="nav-item p-0"><a class="nav-link link txt-lg single-tab active pl-5"  href="#asutus" data-toggle="tab"><?php foreach ($editBuildings as $value) {echo $value['name'];break;}?> sätted</a></li>
						<li class="nav-item p-0"><a class="nav-link link txt-lg" href="#broneering" data-toggle="tab">Broneerimisvormi sätted</a></li>
						<li class="nav-item p-0"></li>
				</ul>
            </div>

						<div class="tab-content ">
							<div id="asutus" class="tab-pane center  <?php if(!isset($data['type'])){ echo 'active';}else if($data['type']==1){echo 'active';}; ?>">
							<?php echo form_open('building/update', array('id' => 'change')); ?>
							<input class="d-none" type="hidden" name="id" value="<?php echo $this->uri->segment(3);?>">
						
									<h4 class="pt-2 txt-xl px-5 mx-5 mt-4">Asutuse info</h4>

									<div class="row d-flex p-0 mt-4 px-md-5 mx-5">
											<div class="form-label-group col-12 col-md-6 py-0 pl-0 pr-5">
											<label for="status">Piirkond</label>
											<select id="place" name="place" class="form-control arrow">
												<option value="0" >Vali piirkond</option>
											<?php foreach($regions as $region) {?>
													<option value="<?php echo $region['regionID'];?>" <?php if ($editBuildings[0]['regionID']==$region['regionID']){echo 'selected';}?>><?php echo $region['regionName'];?></option>
											<?php }?>
											</select>
											</div>
									</div>
									<div class="row d-flex p-0 mt-4 px-md-5 mx-5">
											<div class="form-label-group col-12 col-md-6 py-0 pl-0 pr-5">
													<label>Kontakt email*</label>
													<input class="form-control" id="contact_email" type="email" name="email" value="<?php foreach ($editBuildings as $value) {echo $value['contact_email'];break;}?>">
											</div>
											<div class="form-label-group col-12 col-md-6 p-0 pl-0 pl-md-5  pr-5 pr-md-0">
													<label>Teavituste email</label>
													<input class="form-control" id="notify_email" type="email" name="notifyEmail" value="<?php foreach ($editBuildings as $value) {echo $value['notify_email'];break;}?>">
											</div>
									</div>

									<div class="row d-flex p-0 mt-4 px-md-5 mx-5">
											<div class="form-label-group col-12 col-md-6 py-0 pl-0 pr-5">
													<label>Telefoni number*</label>
													<input class="form-control" id="phone" type="number" name="phone" value="<?php foreach ($editBuildings as $value) {echo $value['phone'];break;}?>">
											</div>
											<div class="form-label-group col-12 col-md-6 p-0 pl-0 pl-md-5  pr-5 pr-md-0">
													<label>Hinnakirja link (url) <b data-tooltip="Aadress peab olema kujul: https://koduleht.ee "><img id="tool" class="mr-5" src="<?php echo base_url(); ?>assets/img/icon-info.svg" width="6%"></b></label>
													<input class="form-control" id="price_url" type="text" name="price_url" value="<?php foreach ($editBuildings as $value) {echo $value['price_url'];break;}?>">
											</div>
									</div>

									<h4 class="mt-5 txt-xl px-5 mx-5 pb-3">Ruumid</h4>
									<div class="form-label-group py-0 px-5 mx-5" id="saalid">
											<label class="txt-regular txt-lg">Nähtavad ruumid <b data-tooltip="Kõik kasutajad näevad"><img id="tool" class="mr-5" src="<?php echo base_url(); ?>assets/img/icon-info.svg" width="3%"></b></label>
											<?php foreach ($editBuildings as $value) { 
										
												if ($value['roomActive'] == 1) { 
													echo('<div class="row d-flex mb-3 p-0 justify-content-between"> 
													<input class="d-none" type="hidden" name="roomID[]" value="'.$value['id'].'"> 
													<input class="form-control col-6" id="activeRoom[]" type="text" name="room[]" value="' . $value['roomName'] .'">
													<input name="color[]" type="color" value="'. $value["roomColor"] .'">
													<input type="button" id="activeOrPassive'.$value['id'].'" data-id="'.$value['id'].'" class="btn btn-custom btn-width-92 text-white text-center py-1 px-2 txt-strong" value="Nähtav"> 

													<input data-id="'.$value['id'].'" class="btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong"  type="button" value="Kustuta">
													</div>'); 
												}}; ?>
									</div>
									<div class="form-label-group py-0 px-5 mx-5">
											<label class="txt-regular txt-lg">Peidetud ruumid <b data-tooltip="Nähtavad ainult asutuse kasutajatele"><img id="tool" class="mr-5" src="<?php echo base_url(); ?>assets/img/icon-info.svg" width="3%"></b></label>
											<?php foreach ($editBuildings as $key => $value) { 
												if ($value['roomActive'] == '0') { 
													echo('<div class="row d-flex mb-3 p-0 justify-content-between">
													<input class="d-none" type="hidden" name="roomID[]" value="'.$value['id'].'"> 
													<input class="form-control col-6" id="inactiveRoom[]" type="text" name="room[]" value="' . $value['roomName'] .'">
													<input name="color[]" type="color" value="'. $value["roomColor"] .'">
													<input type="button" id="activeOrPassive' . $value['id']. '" data-id="'.$value['id'].'" class="btn btn-inactive btn-width-92 text-white text-center py-1 px-2 txt-strong" value="Peidus">
													<input data-id="'.$value['id'].'" class="btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong"  type="button" value="Kustuta">
													</div>');
												}}; ?>
									</div>

									<div class="flex mx-5 px-5 mt-5">
											<a id="lisaSaal" class="btn btn-custom text-white text-center py-2 px-4 pluss"><p class="m-0 px-0 txt-lg txt-strong text-center align-items-center">Lisa ruum</p></a>
									</div>

									<div class="d-flex justify-content-end my-5 px-5 mx-5">
										<a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="<?php echo base_url(); ?>building/view/<?php  print_r($this->session->userdata['building']);?>">Katkesta</a>
											<button type="submit" class="btn btn-custom col-md-5 text-white txt-xl">Salvesta muudatused</button>
									</div>
							</form>
							
							</div>  
							<div id="broneering" class="tab-pane center">   
							<?php echo form_open('building/updateBookingSettings', array('id' => 'changebookingSettings')); ?>
								<h4 class="pt-2 txt-xl px-5 mx-5 mt-4">Administraatori broneeringuvormi vaikeseaded</h4>
							
								<p class="pt-3 txt-lg px-5 mx-5">Kohustuslikud väljad administraatorile: </p>
								<div class="col-sm-12 w-auto mx-5 px-5 ">
										
										<table class="table table-sm  table-hover" style="border-top: hidden">
									<tbody>
									<tr>
															<th ></td>
															<th class="p-1">
														 <span data-tooltip="Kohustuslik"><img  src="<?php echo base_url(); ?>assets/img/mark.png" width="70%"></span>
															</th>
														
														</tr>
									<tr class="m-5" >
									<td class="col-10">
									
									Klubi nimi  &nbsp;&nbsp;	
							
									</td>
										<td class="col-1"><label><input type="checkbox" <?php if($bookingformdata['clubname_admin']){echo 'checked';}?>  name="clubname_admin" value="<?php echo $bookingformdata['clubname_admin'] ?>"><span></span></label></td>
									</tr>
									<tr>
									<td class="col-10">
									
									Kontaktisik  &nbsp;&nbsp;	
							
							
									</td>
										<td class="col-1"><label><input type="checkbox" <?php if($bookingformdata['contactname_admin']){echo 'checked';}?> name="contact_admin" value="<?php echo $bookingformdata['contactname_admin'] ?>"><span></span></label></td>
									</tr>

									<tr>
									<td class="col-10">
									Telefon  &nbsp;&nbsp;	
									</td>
										<td class="col-1"><label><input type="checkbox" <?php if($bookingformdata['phone_admin']){echo 'checked';}?> name="phone_admin" value="<?php echo $bookingformdata['phone_admin'] ?>"><span></span></label></td>
									</tr>
									<tr>
									<td class="col-10">
									E-mail &nbsp;&nbsp;
									</td>
										<td class="col-1">	<label><input type="checkbox" <?php if($bookingformdata['email_admin']){echo 'checked';}?> name="email_admin" value="<?php echo $bookingformdata['email_admin'] ?>"><span></span></label></td>
									</tr>
									<tr>
									<td class="col-10">
									Sündmus / Treeningu tüüp  &nbsp;&nbsp;	
									</td>
										<td class="col-1"><label><input type="checkbox" <?php if($bookingformdata['type_admin']){echo 'checked';}?> name="type_admin" value="<?php echo $bookingformdata['type_admin'] ?>"><span></span></label></td>
									</tr>
									</tbody>
								</table>
								</div>
							
							
								
							
								
								<div class="row d-flex p-0 m-4 px-md-5 mx-5">
									Broneeringu kinnitus vaikimisi sees  &nbsp;&nbsp;	<label><input type="checkbox" <?php if($bookingformdata['approved_admin']){echo 'checked';} ?> name="approveNow" id="approveNow" value="<?php echo $bookingformdata['approved_admin'] ?>"><span></span></label>
								</div>
								
								
								
							
								
								<div class="row d-flex p-0 mt-4 px-md-5 mx-5">
								
									<p class="txt-lg">	Vaikevärvid: </p>
									&nbsp;&nbsp; <input type="color" id="favcolor" name="favcolor1" value="<?php echo $bookingformdata['color1'];?>">
									&nbsp;&nbsp; <input type="color" id="favcolor" name="favcolor2" value="<?php echo $bookingformdata['color2'];?>">
									&nbsp;&nbsp; <input type="color" id="favcolor" name="favcolor3" value="<?php echo $bookingformdata['color3'];?>">
									&nbsp;&nbsp; <input type="color" id="favcolor" name="favcolor4" value="<?php echo $bookingformdata['color4'];?>">
									&nbsp;&nbsp; <input type="color" id="favcolor" name="favcolor5" value="<?php echo $bookingformdata['color5'];?>">
									&nbsp;&nbsp; <input type="color" id="favcolor" name="favcolor6" value="<?php echo $bookingformdata['color6'];?>">
									&nbsp;&nbsp; <input type="color" id="favcolor" name="favcolor7" value="<?php echo $bookingformdata['color7'];?>">
									&nbsp;&nbsp; <input type="color" id="favcolor" name="favcolor8" value="<?php echo $bookingformdata['color8'];?>">
								</div>
								<div class="row d-flex p-0 mt-4 px-md-5 mx-5">
								</div>
								<div id="üldsätted" style="background-color:#F8F8F8" class="pt-2 txt-xl py-4">
									<h4 class="pt-2 txt-xl px-5 mx-5 mt-4">Tavakasutaja päringuvormi üldsätted <b data-tooltip="Tavakasutajate broneering veel ei tööta ja see osa on arendamisel"><img id="tool" class="mr-5" src="<?php echo base_url(); ?>assets/img/icon-info.svg" width="3%"></b></h4>	
									<div class="row d-flex p-0 m-4 px-md-5 mx-5">	
										<p class="txt-lg ">	Luba kasutajatele päringute esitamine  &nbsp;&nbsp;	<label><input type="checkbox" id="allowUserBooking" <?php if($bookingformdata['allow_booking']){echo 'checked';} ?> name="allowBooking" value="<?php echo $bookingformdata['allow_booking'] ?>"><span></span></label></p>
									</div>
									<div id="showOrHide">
										<div class="row d-flex p-0 m-4 px-md-5 mx-5">	
									
											<p class="txt-lg ">	Näita kliendi edastatud ühekordse treeningu päring avalikust kalendrist  &nbsp;&nbsp;	<label><input type="checkbox" <?php if($getBookingformDataDetailsOnce['showtopublicuser']){echo 'checked';} ?> name="showtopublicuseronce" value="<?php echo $getBookingformDataDetailsOnce['showtopublicuser'] ?>"><span></span></label></p>
											<p class="txt-lg ">	Näita kliendi edastatud hooajalise treeningu päringu avalikust kalendrist  &nbsp;&nbsp;	<label><input type="checkbox" <?php if($getBookingformDataDetailsPeriod['showtopublicuser']){echo 'checked';} ?> name="showtopublicuserperiod" value="<?php echo $getBookingformDataDetailsPeriod['showtopublicuser'] ?>"><span></span></label></p>
											<p class="txt-lg ">	Näita kliendi edastatud sündmuse päring avalikust kalendrist  &nbsp;&nbsp;	<label><input type="checkbox" <?php if($getBookingformDataDetailsEvent['showtopublicuser']){echo 'checked';}  ?> name="showtopublicuserevent" value="<?php echo $getBookingformDataDetailsEvent['showtopublicuser'] ?>"><span></span></label></p>
										</div>
										<p class="pt-1 txt-lg px-5 mx-5">Kohustuslikud väljad tavakasutajatele: </p>
										
										<div class="col-sm-12 w-auto mx-5 px-5 ">
										
									<table class="table table-sm  table-hover" style="border-top: hidden">
								<tbody>
								<tr>
														<th class="pb-5"></td>
														<th class="p-1">
													 <span data-tooltip="Kohustuslik"><img  src="<?php echo base_url(); ?>assets/img/mark.png" width="70%"></span>
														</th>
													
													</tr>
								<tr>
								<td class="col-10">
									Klubi nimi  &nbsp;&nbsp;	
								</td>
									<td class="col-1"><label><input type="checkbox"  <?php if($bookingformdata['clubname_user']){echo 'checked';} ?> name="clubname_user" value="<?php echo $bookingformdata['clubname_user'] ?>"><span></span></label></td>
								</tr>
								
								<tr>
								<td class="col-10"> 	
									Kontaktisik  &nbsp;&nbsp;	
							</td>
									<td class="col-1"><label><input type="checkbox"  <?php if($bookingformdata['contactname_user']){echo 'checked';} ?> name="name_user" value="<?php echo $bookingformdata['contactname_user'] ?>"><span></span></label>
								</td>
								</tr>
							<tr>
							<td class="col-10"> 	
									Telefon  &nbsp;&nbsp;	
								</td>
								<td class="col-1"><label><input type="checkbox"  <?php if($bookingformdata['phone_user']){echo 'checked';} ?> name="phone_user" value="<?php echo $bookingformdata['phone_user'] ?>"><span></span></label></td>
							</tr>
							<tr>
								<td class="col-10">
									E-mail &nbsp;&nbsp;	
								</td>
								<td class="col-1"><label><input type="checkbox"  <?php if($bookingformdata['email_user']){echo 'checked';} ?> name="email_user" value="<?php echo $bookingformdata['email_user'] ?>"><span></span></label></td>
								</tr>
								<tr>
								<td class="col-10">
								Ruumi kasutamise eesmärk   &nbsp;&nbsp;	
								</td>
								<td class="col-1"><label><input type="checkbox"  <?php if($bookingformdata['type_user']){echo 'checked';} ?> name="type_user" value="<?php echo $bookingformdata['type_user'] ?>"><span></span></label></td>
								</tr>
								<tr>
								<td class="col-10">
														
								</td>
								<td class="col-1"></td>
								</tr>
							</tbody>
								</table>
							
								<!-- <p class="txt-lg mb-2">Kasutustingimused: </p>
								<div class="row d-flex p-0">	
										<p class=" mb-2">	Soovin, et klient peab nõustuma kasutustingimustega  &nbsp;&nbsp;	<label><input type="checkbox" id="allowUserBooking" <?php if($bookingformdata['allow_booking']){echo 'checked';} ?> name="allowBooking" value="<?php echo $bookingformdata['allow_booking'] ?>"><span></span></label></p>
									</div>
									<p class="mb-1">Sisesta siia oma asutuse kasutustingimused: </p>
									<div class="input-group  mb-4">
										<textarea class="form-control" placeholder="kui kaua aega ette võib päringut esitada, millal päring üle vaadatakse ja kinnitatakse. Ruumi kasutamise reeglid jne"></textarea>
									</div> -->
								</div>


							 <div class="py-2 bg-white" id="uhekordse satted">
							
									<h4 class="pt-2 txt-xl px-5 mx-5 mt-4">1. Ühekordse treeningu vormil tavakasutajalt küsitakse:</h4>
									<input type="hidden" name="typeIDonce" value="1">
										<div class="col-sm-12 w-auto mx-5 px-5 ">
											<table class="table table-sm  table-hover" style="border-top: hidden">
												<tbody>
													<tr class="mb-2">
													<td class="p-0"></td>
											<td class="p-0">
											<h4> <span data-tooltip="Nähtav"><img id="tool" src="<?php echo base_url(); ?>assets/img/eye2.png" width="80%"></span></h4>	
											</td>
											
											<td class="p-1">
											<b data-tooltip="Kohustuslik"><img id="tool" src="<?php echo base_url(); ?>assets/img/mark.png" width="70%"></b>
											</td>
													
													</tr>
										
											
											<tr>
											<td class="col-10">Inimeste arvu</td>	
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['maxpeaplenumbersee']){echo 'checked';} ?> name="maxpeaplenumberseeonce" value="<?php echo $getBookingformDataDetailsOnce['maxpeaplenumbersee'] ?>"><span></span></label></td> 
												<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['maxpeaplenumberrequired']){echo 'checked';} ?> name="maxpeaplenumberrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['maxpeaplenumberrequired'] ?>"><span></span></label></td>
												
											</tr>
											
											<tr>
											<td class="col-10">Vanusegruppi</td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['groupsee']){echo 'checked';} ?> name="groupseeonce" value="<?php echo $getBookingformDataDetailsOnce['groupsee'] ?>"><span></span></label></td> 
												<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['grouprequired']){echo 'checked';} ?> name="grouprequiredonce" value="<?php echo $getBookingformDataDetailsOnce['grouprequired'] ?>"><span></span></label></td>
												
											</tr>
											<tr class="col-5"> 
											<td class="col-10">Treeningu olekut <b data-tooltip="Klient peab märkima, kas sündmus on avalik või privaatne"><img id="tool" class="mr-5" src="<?php echo base_url(); ?>assets/img/icon-info.svg" width="3%"></b></td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['publicsee']){echo 'checked';} ?> name="publicseeonce" value="<?php echo $getBookingformDataDetailsOnce['publicsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['publicrequired']){echo 'checked';} ?> name="publicrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['publicrequired'] ?>"><span></span></label></td>
											</tr>
											<tr class="col-5"> 
											<td class="col-10">Treeningu ettevalmistus aega</td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['prepsee']){echo 'checked';} ?> name="prepseeonce" value="<?php echo $getBookingformDataDetailsOnce['prepsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['preprequired']){echo 'checked';} ?> name="preprequiredonce" value="<?php echo $getBookingformDataDetailsOnce['preprequired'] ?>"><span></span></label></td>
											</tr>
											<tr class="col-5"> 
											<td class="col-10">Treeningujärgne koristus aega</td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['cleansee']){echo 'checked';} ?> name="cleanseeonce" value="<?php echo $getBookingformDataDetailsOnce['cleansee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['cleanrequired']){echo 'checked';} ?> name="cleanrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['cleanrequired'] ?>"><span></span></label></td>
											</tr>
											
											<tr>
												<td class="col-10">Lepingu soovimist</td>	
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementsee']){echo 'checked';} ?> name="agreementseeonce" value="<?php echo $getBookingformDataDetailsOnce['agreementsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementrequired']){echo 'checked';} ?> name="agreementrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['agreementrequired'] ?>"><span></span></label></td>
												
											</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Ettevõtte- või eraisiku nime</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementnamesee']){echo 'checked';} ?> name="agreementnameseeonce" value="<?php echo $getBookingformDataDetailsOnce['agreementnamesee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementnamerequired']){echo 'checked';} ?> name="agreementnamerequiredonce" value="<?php echo $getBookingformDataDetailsOnce['agreementnamerequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Registrikoodi/isikukoodi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementcodesee']){echo 'checked';} ?> name="agreementcodeseeonce" value="<?php echo $getBookingformDataDetailsOnce['agreementcodesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementcoderequired']){echo 'checked';} ?> name="agreementcoderequiredonce" value="<?php echo $getBookingformDataDetailsOnce['agreementcoderequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Aadressi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementaddresssee']){echo 'checked';} ?> name="agreementaddressseeonce" value="<?php echo $getBookingformDataDetailsOnce['agreementaddresssee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementaddressrequired']){echo 'checked';} ?> name="agreementaddressrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['agreementaddressrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Kontaktisikut</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementcontactsee']){echo 'checked';} ?> name="agreementcontactseeonce" value="<?php echo $getBookingformDataDetailsOnce['agreementcontactsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementcontactrequired']){echo 'checked';} ?> name="agreementcontactrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['agreementcontactrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - E-maili</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementemailsee']){echo 'checked';} ?> name="agreementemailseeonce" value="<?php echo $getBookingformDataDetailsOnce['agreementemailsee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementemailrequired']){echo 'checked';} ?> name="agreementemailrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['agreementemailrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Telefoni</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementphonesee']){echo 'checked';} ?> name="agreementphoneseeonce" value="<?php echo $getBookingformDataDetailsOnce['agreementphonesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['agreementphonerequired']){echo 'checked';} ?> name="agreementphonerequiredonce" value="<?php echo $getBookingformDataDetailsOnce['agreementphonerequired'] ?>"><span></span></label></td>
												</tr>
											
											
											
												<tr>
													<td>Maksmisviisi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['methodofpaymentsee']){echo 'checked';} ?> name="methodofpaymentseeonce" value="<?php echo $getBookingformDataDetailsOnce['methodofpaymentsee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['methodofpaymentrequired']){echo 'checked';} ?> name="methodofpaymentrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['methodofpaymentrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Sularahas kohapeal tasudes</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['methodofpaymentcash']){echo 'checked';} ?> name="methodofpaymentcashonce" value="<?php echo $getBookingformDataDetailsOnce['methodofpaymentcash'] ?>"><span></span></label></td> 
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Pangakaart kohapeal tasudes</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['methodofpaymentcard']){echo 'checked';} ?> name="methodofpaymentcardonce" value="<?php echo $getBookingformDataDetailsOnce['methodofpaymentcard'] ?>"><span></span></label></td>
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Arvega</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['methodofpaymentbill']){echo 'checked';} ?> name="methodofpaymentbillonce" value="<?php echo $getBookingformDataDetailsOnce['methodofpaymentbill'] ?>"><span></span></label></td>
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Ettemaks</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['methodofpaymentprepayment']){echo 'checked';} ?> name="methodofpaymentprepaymentonce" value="<?php echo $getBookingformDataDetailsOnce['methodofpaymentprepayment'] ?>"><span></span></label></td> 
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Muu</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['methodofpaymentother']){echo 'checked';} ?> name="methodofpaymentotheronce" value="<?php echo $getBookingformDataDetailsOnce['methodofpaymentother'] ?>"><span></span></label></td>
													</tr>
												
												<tr>
													<td>Arve soovimist</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoicesee']){echo 'checked';} ?> name="invoiceseeonce" value="<?php echo $getBookingformDataDetailsOnce['invoicesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoicerequired']){echo 'checked';} ?> name="invoicerequiredonce" value="<?php echo $getBookingformDataDetailsOnce['invoicerequired'] ?>"><span></span></label></td>
												</tr>
											<tr class="col-5"> 
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Ettevõtte- või eraisiku nime</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoicenamesee']){echo 'checked';} ?> name="invoicenameseeonce" value="<?php echo $getBookingformDataDetailsOnce['invoicenamesee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoicenamerequired']){echo 'checked';} ?> name="invoicenamerequiredonce" value="<?php echo $getBookingformDataDetailsOnce['invoicenamerequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Registrikoodi/isikukoodi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoicecodesee']){echo 'checked';} ?> name="invoicecodeseeonce" value="<?php echo $getBookingformDataDetailsOnce['invoicecodesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoicecoderequired']){echo 'checked';} ?> name="invoicecoderequiredonce" value="<?php echo $getBookingformDataDetailsOnce['invoicecoderequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Aadressi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoiceaddresssee']){echo 'checked';} ?> name="invoiceaddressseeonce" value="<?php echo $getBookingformDataDetailsOnce['invoiceaddresssee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoiceaddressrequired']){echo 'checked';} ?> name="invoiceaddressrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['invoiceaddressrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Kontaktisikut</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoicecontact']){echo 'checked';} ?> name="invoicecontactonce" value="<?php echo $getBookingformDataDetailsOnce['invoicecontact'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoicecontactrequired']){echo 'checked';} ?> name="invoicecontactrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['invoicecontactrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - E-maili</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoiceemailsee']){echo 'checked';} ?> name="invoiceemailseeonce" value="<?php echo $getBookingformDataDetailsOnce['invoiceemailsee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoiceemailrequired']){echo 'checked';} ?> name="invoiceemailrequiredonce" value="<?php echo $getBookingformDataDetailsOnce['invoiceemailrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Telefoni</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoicephonesee']){echo 'checked';} ?> name="invoicephoneseeonce" value="<?php echo $getBookingformDataDetailsOnce['invoicephonesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsOnce['invoicephonerequired']){echo 'checked';} ?> name="invoicephonerequiredonce" value="<?php echo $getBookingformDataDetailsOnce['invoicephonerequired'] ?>"><span></span></label></td>
												</tr>
											
											
										
										
										
												</tbody>
											</table>
										</div>

									
										<p class="txt-lg pt-3 px-5 mx-5">Lisainfo ühekordse treeningu vormil: </p>
										
										<p class="pt-3 px-5 mx-5">Sisesta siia kliendi jaoks üldinfo, mida kuvatakse päringuvormil: </p>
										
										<div class="form-label-group mt-2 pb-2 px-5 mx-5">
											<div class="input-group">
												<textarea class="form-control"  name="introonce"  placeholder="saali mahutavus, tribüüni kohtade arv, olemasolev varustus, ruumi hind, kui kaua aega ette võib päringut esitada, millal päring üle vaadatakse ja kinnitatakse jne"><?php echo $getBookingformDataDetailsOnce['intro']?></textarea>
											</div>
										</div>

										<p class="pt-3 px-5 mx-5">Sisesta siia kinnitusmeili lisatekst: </p> 
										
										<div class="form-label-group mt-2 pb-2 px-5 mx-5">
											<div class="input-group">
												<textarea class="form-control" name="additionalemailtextonce" placeholder="Võib lisada info taotluste esitamiste, kuupäevade vms kohta. nt Teiega võetakse ühendust 3 tööpäeva jooksul telefoni teel."><?php echo $getBookingformDataDetailsOnce['emailtext']?></textarea>
											</div>
										</div>
										

									 

									 <div class="py-2" id="hooajalise satted" style="background-color:#F8F8F8">

									
									
								
									 <h4 class="pt-2 txt-xl px-5 mx-5 mt-4">2. Hooajalise treeningu vormil tavakasutajalt tavakasutajalt küsitakse:</h4>
									 <input type="hidden" name="typeIDperiod" value="2">
										<div class="col-sm-12 w-auto mx-5 px-5 ">
										<table class="table table-sm  table-hover" style="border-top: hidden">
											<tbody>
										<tr>
											<td class="p-0"></td>
											<td class="p-0">
											<h4> <span data-tooltip="Nähtav"><img id="tool" src="<?php echo base_url(); ?>assets/img/eye2.png" width="80%"></span></h4>	
											</td>
											
											<td class="p-1">
											<b data-tooltip="Kohustuslik"><img id="tool" src="<?php echo base_url(); ?>assets/img/mark.png" width="70%"></b>
											</td>
										</tr>
											<tr class="col-5"> 
											<tr>
											<td class="col-10">Inimeste arvu</td>	
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['maxpeaplenumbersee']){echo 'checked';} ?> name="maxpeaplenumberseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['maxpeaplenumbersee'] ?>"><span></span></label></td> 
												<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['maxpeaplenumberrequired']){echo 'checked';} ?> name="maxpeaplenumberrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['maxpeaplenumberrequired'] ?>"><span></span></label></td>
												
											</tr>
											
											<tr>
											<td class="col-10">Vanusegruppi</td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['groupsee']){echo 'checked';} ?> name="groupseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['groupsee'] ?>"><span></span></label></td> 
												<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['grouprequired']){echo 'checked';} ?> name="grouprequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['grouprequired'] ?>"><span></span></label></td>
												
											</tr>
											<tr class="col-5"> 
											<td class="col-10">Treeningu olekut <b data-tooltip="Klient peab märkima, kas sündmus on avalik või privaatne"><img id="tool" class="mr-5" src="<?php echo base_url(); ?>assets/img/icon-info.svg" width="3%"></b></td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['publicsee']){echo 'checked';} ?> name="publicseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['publicsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['publicrequired']){echo 'checked';} ?> name="publicrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['publicrequired'] ?>"><span></span></label></td>
											</tr>
											<tr class="col-5"> 
											<td class="col-10">Treeningu ettevalmistus aega</td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['prepsee']){echo 'checked';} ?> name="prepseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['prepsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['preprequired']){echo 'checked';} ?> name="preprequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['preprequired'] ?>"><span></span></label></td>
											</tr>
											<tr class="col-5"> 
											<td class="col-10">Treeningujärgne koristus aega</td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['cleansee']){echo 'checked';} ?> name="cleanseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['cleansee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['cleanrequired']){echo 'checked';} ?> name="cleanrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['cleanrequired'] ?>"><span></span></label></td>
											</tr>
											
											<tr>
												<td class="col-10">Lepingu soovimist</td>	
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementsee']){echo 'checked';} ?> name="agreementseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementrequired']){echo 'checked';} ?> name="agreementrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementrequired'] ?>"><span></span></label></td>
												
											</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Ettevõtte- või eraisiku nime</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementnamesee']){echo 'checked';} ?> name="agreementnameseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementnamesee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementnamerequired']){echo 'checked';} ?> name="agreementnamerequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementnamerequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Registrikoodi/isikukoodi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementcodesee']){echo 'checked';} ?> name="agreementcodeseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementcodesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementcoderequired']){echo 'checked';} ?> name="agreementcoderequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementcoderequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Aadressi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementaddresssee']){echo 'checked';} ?> name="agreementaddressseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementaddresssee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementaddressrequired']){echo 'checked';} ?> name="agreementaddressrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementaddressrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Kontaktisikut</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementcontactsee']){echo 'checked';} ?> name="agreementcontactseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementcontactsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementcontactrequired']){echo 'checked';} ?> name="agreementcontactrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementcontactrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - E-maili</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementemailsee']){echo 'checked';} ?> name="agreementemailseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementemailsee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementemailrequired']){echo 'checked';} ?> name="agreementemailrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementemailrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Telefoni</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementphonesee']){echo 'checked';} ?> name="agreementphoneseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementphonesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['agreementphonerequired']){echo 'checked';} ?> name="agreementphonerequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['agreementphonerequired'] ?>"><span></span></label></td>
												</tr>
											
											
											
												<tr>
													<td>Maksmisviisi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['methodofpaymentsee']){echo 'checked';} ?> name="methodofpaymentseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['methodofpaymentsee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['methodofpaymentrequired']){echo 'checked';} ?> name="methodofpaymentrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['methodofpaymentrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Sularahas kohapeal tasudes</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['methodofpaymentcash']){echo 'checked';} ?> name="methodofpaymentcashperiod" value="<?php echo $getBookingformDataDetailsPeriod['methodofpaymentcash'] ?>"><span></span></label></td> 
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Pangakaart kohapeal tasudes</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['methodofpaymentcard']){echo 'checked';} ?> name="methodofpaymentcardperiod" value="<?php echo $getBookingformDataDetailsPeriod['methodofpaymentcard'] ?>"><span></span></label></td>
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Arvega</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['methodofpaymentbill']){echo 'checked';} ?> name="methodofpaymentbillperiod" value="<?php echo $getBookingformDataDetailsPeriod['methodofpaymentbill'] ?>"><span></span></label></td>
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Ettemaks</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['methodofpaymentprepayment']){echo 'checked';} ?> name="methodofpaymentprepaymentperiod" value="<?php echo $getBookingformDataDetailsPeriod['methodofpaymentprepayment'] ?>"><span></span></label></td> 
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Muu</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['methodofpaymentother']){echo 'checked';} ?> name="methodofpaymentotherperiod" value="<?php echo $getBookingformDataDetailsPeriod['methodofpaymentother'] ?>"><span></span></label></td>
													</tr>
												
												<tr>
													<td>Arve soovimist</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoicesee']){echo 'checked';} ?> name="invoiceseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoicesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoicerequired']){echo 'checked';} ?> name="invoicerequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoicerequired'] ?>"><span></span></label></td>
												</tr>
											<tr class="col-5"> 
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Ettevõtte- või eraisiku nime</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoicenamesee']){echo 'checked';} ?> name="invoicenameseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoicenamesee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoicenamerequired']){echo 'checked';} ?> name="invoicenamerequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoicenamerequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Registrikoodi/isikukoodi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoicecodesee']){echo 'checked';} ?> name="invoicecodeseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoicecodesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoicecoderequired']){echo 'checked';} ?> name="invoicecoderequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoicecoderequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Aadressi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoiceaddresssee']){echo 'checked';} ?> name="invoiceaddressseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoiceaddresssee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoiceaddressrequired']){echo 'checked';} ?> name="invoiceaddressrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoiceaddressrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Kontaktisikut</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoicecontact']){echo 'checked';} ?> name="invoicecontactperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoicecontact'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoicecontactrequired']){echo 'checked';} ?> name="invoicecontactrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoicecontactrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - E-maili</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoiceemailsee']){echo 'checked';} ?> name="invoiceemailseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoiceemailsee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoiceemailrequired']){echo 'checked';} ?> name="invoiceemailrequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoiceemailrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Telefoni</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoicephonesee']){echo 'checked';} ?> name="invoicephoneseeperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoicephonesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsPeriod['invoicephonerequired']){echo 'checked';} ?> name="invoicephonerequiredperiod" value="<?php echo $getBookingformDataDetailsPeriod['invoicephonerequired'] ?>"><span></span></label></td>
												</tr>
										
										</tbody>
										</table>
										</div>
										
										<p class="txt-lg pt-3 px-5 mx-5">Lisainfo hooajalise treeningu vormil: </p>
										
										<p class="pt-3 px-5 mx-5">Sisesta siia üldinfo tekst: </p>
										
										<div class="form-label-group mt-2 pb-2 px-5 mx-5">
											<div class="input-group">
											<textarea class="form-control" name="introperiod" placeholder="nt saali mahutavus, tribüüni kohtade arv, olemasolev varustus"><?php echo $getBookingformDataDetailsPeriod['intro']?></textarea>
											</div>
										</div>

										<p class="pt-3 px-5 mx-5">Sisesta siia kinnitusmeili lisatekst: </p> 
										
										<div class="form-label-group mt-2 pb-2 px-5 mx-5">
											<div class="input-group">
											<textarea class="form-control" name="additionalemailtextperiod" placeholder="nt info taotluste esitamiste, kuupäevade jne kohta"><?php echo $getBookingformDataDetailsPeriod['emailtext']?></textarea>
											</div>
										</div>
										
										
										

									 </div>
									 <div class="py-2 bg-white" id="sundmuse satted">

									
									
								
									 <h4 class="pt-2 txt-xl px-5 mx-5 mt-4">3. Sündmuse vormil tavakasutajalt küsitakse:</h4>
									 <input type="hidden" name="typeIDevent" value="3">
										<div class="col-sm-12 w-auto mx-5 px-5 ">
											<table class="table table-sm  table-hover" style="border-top: hidden">
												<tbody>
											<tr>
												<td class="p-0"></td>
												<td class="p-0">
												<h4> <span data-tooltip="Nähtav"><img id="tool" src="<?php echo base_url(); ?>assets/img/eye2.png" width="80%"></span></h4>	
												</td>
												
												<td class="p-1">
												<b data-tooltip="Kohustuslik"><img id="tool" src="<?php echo base_url(); ?>assets/img/mark.png" width="70%"></b>
												</td>
											</tr>
											<tr>
											<td class="col-10">Inimeste arvu</td>	
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['maxpeaplenumbersee']){echo 'checked';} ?> name="maxpeaplenumberseeevent" value="<?php echo $getBookingformDataDetailsEvent['maxpeaplenumbersee'] ?>"><span></span></label></td> 
												<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['maxpeaplenumberrequired']){echo 'checked';} ?> name="maxpeaplenumberrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['maxpeaplenumberrequired'] ?>"><span></span></label></td>
												
											</tr>
											
											<tr>
											<td class="col-10">Vanusegruppi</td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['groupsee']){echo 'checked';} ?> name="groupseeevent" value="<?php echo $getBookingformDataDetailsEvent['groupsee'] ?>"><span></span></label></td> 
												<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['grouprequired']){echo 'checked';} ?> name="grouprequiredevent" value="<?php echo $getBookingformDataDetailsEvent['grouprequired'] ?>"><span></span></label></td>
												
											</tr>
											<tr class="col-5"> 
											<td class="col-10">Sündmuse olekut <b data-tooltip="Klient peab märkima, kas sündmus on avalik või privaatne"><img id="tool" class="mr-5" src="<?php echo base_url(); ?>assets/img/icon-info.svg" width="3%"></b></td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['publicsee']){echo 'checked';} ?> name="publicseeevent" value="<?php echo $getBookingformDataDetailsEvent['publicsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['publicrequired']){echo 'checked';} ?> name="publicrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['publicrequired'] ?>"><span></span></label></td>
											</tr>
											<tr class="col-5"> 
											<td class="col-10">Sündmuse ettevalmistus aega</td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['prepsee']){echo 'checked';} ?> name="prepseeevent" value="<?php echo $getBookingformDataDetailsEvent['prepsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['preprequired']){echo 'checked';} ?> name="preprequiredevent" value="<?php echo $getBookingformDataDetailsEvent['preprequired'] ?>"><span></span></label></td>
											</tr>
											<tr class="col-5"> 
											<td class="col-10">Sündmusejärgne  koristus aega</td>
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['cleansee']){echo 'checked';} ?> name="cleanseeevent" value="<?php echo $getBookingformDataDetailsEvent['cleansee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['cleanrequired']){echo 'checked';} ?> name="cleanrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['cleanrequired'] ?>"><span></span></label></td>
											</tr>
											
											<tr>
												<td class="col-10">Lepingu soovimist</td>	
												<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementsee']){echo 'checked';} ?> name="agreementseeevent" value="<?php echo $getBookingformDataDetailsEvent['agreementsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementrequired']){echo 'checked';} ?> name="agreementrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['agreementrequired'] ?>"><span></span></label></td>
												
											</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Ettevõtte- või eraisiku nime</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementnamesee']){echo 'checked';} ?> name="agreementnameseeevent" value="<?php echo $getBookingformDataDetailsEvent['agreementnamesee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementnamerequired']){echo 'checked';} ?> name="agreementnamerequiredevent" value="<?php echo $getBookingformDataDetailsEvent['agreementnamerequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Registrikoodi/isikukoodi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementcodesee']){echo 'checked';} ?> name="agreementcodeseeevent" value="<?php echo $getBookingformDataDetailsEvent['agreementcodesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementcoderequired']){echo 'checked';} ?> name="agreementcoderequiredevent" value="<?php echo $getBookingformDataDetailsEvent['agreementcoderequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Aadressi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementaddresssee']){echo 'checked';} ?> name="agreementaddressseeevent" value="<?php echo $getBookingformDataDetailsEvent['agreementaddresssee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementaddressrequired']){echo 'checked';} ?> name="agreementaddressrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['agreementaddressrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Kontaktisikut</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementcontactsee']){echo 'checked';} ?> name="agreementcontactseeevent" value="<?php echo $getBookingformDataDetailsEvent['agreementcontactsee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementcontactrequired']){echo 'checked';} ?> name="agreementcontactrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['agreementcontactrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - E-maili</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementemailsee']){echo 'checked';} ?> name="agreementemailseeevent" value="<?php echo $getBookingformDataDetailsEvent['agreementemailsee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementemailrequired']){echo 'checked';} ?> name="agreementemailrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['agreementemailrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Telefoni</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementphonesee']){echo 'checked';} ?> name="agreementphoneseeevent" value="<?php echo $getBookingformDataDetailsEvent['agreementphonesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['agreementphonerequired']){echo 'checked';} ?> name="agreementphonerequiredevent" value="<?php echo $getBookingformDataDetailsEvent['agreementphonerequired'] ?>"><span></span></label></td>
												</tr>
											
											
											
												<tr>
													<td>Maksmisviisi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['methodofpaymentsee']){echo 'checked';} ?> name="methodofpaymentseeevent" value="<?php echo $getBookingformDataDetailsEvent['methodofpaymentsee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['methodofpaymentrequired']){echo 'checked';} ?> name="methodofpaymentrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['methodofpaymentrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Sularahas kohapeal tasudes</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['methodofpaymentcash']){echo 'checked';} ?> name="methodofpaymentcashevent" value="<?php echo $getBookingformDataDetailsEvent['methodofpaymentcash'] ?>"><span></span></label></td> 
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Pangakaart kohapeal tasudes</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['methodofpaymentcard']){echo 'checked';} ?> name="methodofpaymentcardevent" value="<?php echo $getBookingformDataDetailsEvent['methodofpaymentcard'] ?>"><span></span></label></td>
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Arvega</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['methodofpaymentbill']){echo 'checked';} ?> name="methodofpaymentbillevent" value="<?php echo $getBookingformDataDetailsEvent['methodofpaymentbill'] ?>"><span></span></label></td>
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Ettemaks</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['methodofpaymentprepayment']){echo 'checked';} ?> name="methodofpaymentprepaymentevent" value="<?php echo $getBookingformDataDetailsEvent['methodofpaymentprepayment'] ?>"><span></span></label></td> 
													</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Muu</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['methodofpaymentother']){echo 'checked';} ?> name="methodofpaymentotherevent" value="<?php echo $getBookingformDataDetailsEvent['methodofpaymentother'] ?>"><span></span></label></td>
													</tr>
												
												<tr>
													<td>Arve soovimist</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoicesee']){echo 'checked';} ?> name="invoiceseeevent" value="<?php echo $getBookingformDataDetailsEvent['invoicesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoicerequired']){echo 'checked';} ?> name="invoicerequiredevent" value="<?php echo $getBookingformDataDetailsEvent['invoicerequired'] ?>"><span></span></label></td>
												</tr>
											<tr class="col-5"> 
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Ettevõtte- või eraisiku nime</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoicenamesee']){echo 'checked';} ?> name="invoicenameseeevent" value="<?php echo $getBookingformDataDetailsEvent['invoicenamesee'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoicenamerequired']){echo 'checked';} ?> name="invoicenamerequiredevent" value="<?php echo $getBookingformDataDetailsEvent['invoicenamerequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Registrikoodi/isikukoodi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoicecodesee']){echo 'checked';} ?> name="invoicecodeseeevent" value="<?php echo $getBookingformDataDetailsEvent['invoicecodesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoicecoderequired']){echo 'checked';} ?> name="invoicecoderequiredevent" value="<?php echo $getBookingformDataDetailsEvent['invoicecoderequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Aadressi</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoiceaddresssee']){echo 'checked';} ?> name="invoiceaddressseeevent" value="<?php echo $getBookingformDataDetailsEvent['invoiceaddresssee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoiceaddressrequired']){echo 'checked';} ?> name="invoiceaddressrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['invoiceaddressrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Kontaktisikut</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoicecontact']){echo 'checked';} ?> name="invoicecontactevent" value="<?php echo $getBookingformDataDetailsEvent['invoicecontact'] ?>"><span></span></label></td> 
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoicecontactrequired']){echo 'checked';} ?> name="invoicecontactrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['invoicecontactrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - E-maili</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoiceemailsee']){echo 'checked';} ?> name="invoiceemailseeevent" value="<?php echo $getBookingformDataDetailsEvent['invoiceemailsee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoiceemailrequired']){echo 'checked';} ?> name="invoiceemailrequiredevent" value="<?php echo $getBookingformDataDetailsEvent['invoiceemailrequired'] ?>"><span></span></label></td>
												</tr>
												<tr>
													<td> &nbsp;&nbsp;&nbsp;&nbsp; - Telefoni</td>
													<td class="col-md-1"><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoicephonesee']){echo 'checked';} ?> name="invoicephoneseeevent" value="<?php echo $getBookingformDataDetailsEvent['invoicephonesee'] ?>"><span></span></label></td>
													<td><label><input type="checkbox" class="form-check-input" <?php if($getBookingformDataDetailsEvent['invoicephonerequired']){echo 'checked';} ?> name="invoicephonerequiredevent" value="<?php echo $getBookingformDataDetailsEvent['invoicephonerequired'] ?>"><span></span></label></td>
												</tr>
										
											</tbody>
											</table>
											</div>
										
											
											<p class="txt-lg pt-3 px-5 mx-5">Lisainfo sündmuse vormil: </p>
										
										<p class="pt-3 px-5 mx-5">Sisesta siia üldinfo tekst: </p>
										
										<div class="form-label-group mt-2 pb-2 px-5 mx-5">
											<div class="input-group">
											<textarea class="form-control" name="introevent" placeholder="nt saali mahutavus, tribüüni kohtade arv, olemasolev varustus"><?php echo $getBookingformDataDetailsEvent['intro']?></textarea>
											</div>
										</div>

										<p class="pt-3 px-5 mx-5">Sisesta siia kinnitusmeili lisatekst: </p> 
										
										<div class="form-label-group mt-2 pb-2 px-5 mx-5">
											<div class="input-group">
											<textarea class="form-control" name="additionalemailtextevent" placeholder="nt info taotluste esitamiste, kuupäevade jne kohta"><?php echo $getBookingformDataDetailsEvent['emailtext']?></textarea>
											</div>
										</div>
										
										</div>
									</div>	



									</div>	

								
							</div>
						
							<div class="row d-flex p-0 mt-4 px-md-5 mx-5">	
							</div>
							
							<div class="d-flex justify-content-end my-5 px-5 mx-5">
								<a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="<?php echo base_url(); ?>building/view/<?php  print_r($this->session->userdata['building']);?>">Katkesta</a>
								<button type="submit" class="btn btn-custom col-md-5 text-white txt-xl">Salvesta muudatused</button>
							</div>
						</form>
					</div>
					</div>
					 </div>

        </div>
    </div>
</div>
                    <?php } else { redirect(''); }?>


                             
<script>

$( document ).ready(function() {

	if(!$('#allowUserBooking').is(":checked")){
			$( "#showOrHide" ).hide();
		}

	$(':checkbox').click(function() {
   		value = +$(this).is( ':checked' );
		   $(this).val(value);
		
		if($('#allowUserBooking').is(":checked")){
			console.log(value);
			$( "#showOrHide" ).show();
		}else{
			$( "#showOrHide" ).hide();
		}
	});


	var counter=1;
   $('#lisaSaal').on('click', function() {
    $('#saalid').append('<div class="d-flex mb-3 p-0 justify-content-between"><input class="form-control col-6" id="activeRoom[]" type="text" name="additionalRoom[]" value=""><input name="colorForNewRoom[]" type="color" value="#cbe9fe"><input type="button" id="activeOrPassive<?php echo($value["id"]); ?>" class="addedRoom btn btn-custom btn-width-92 text-white text-center py-1 px-2 txt-strong" value="Nähtav">	<input class="d-none" type="hidden" name="newRoomStatus[]" value="1"> 	<input data-id="<?php echo $value['id']; ?>" id="additionalRoom'+counter+'" class="abc btn btn-delete btn-width-92 text-white text-center py-1 px-2 txt-strong"  type="button" value="Kustuta"></div>');
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

 
  
  $(document).on('click', '.addedRoom', function() { 


		var newRoomStatus=1;
	if($(this).val()=="Nähtav"){
		$(this).val("Peidus");
		$(this).next().val('0');
		$(this).removeClass("btn-custom");
		$(this).addClass("btn-inactive");
		newRoomStatus=0;
		
	} 
	else{
		$(this).val("Nähtav");
		$(this).next().val('1');
		$(this).removeClass("btn-inactive");
		$(this).addClass("btn-custom");
		newRoomStatus=1;
	}
	});

  $('input[id^="activeOrPassive"]').on("click", function() {
	// console.log($(this).data("id"));
	// console.log($(this).val());
	var roomStatus=1;
	if($(this).val()=="Nähtav"){
		$(this).val("Peidus");
		$(this).removeClass("btn-custom");
		$(this).addClass("btn-inactive");
		roomStatus=0;
		
	} 
	else{
		$(this).val("Nähtav");
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
			if(msg=='"Sa ei saa muuta teiste ruumide staatust. Andmeid ei salvestatud!"'){
				alert( msg );
				location.reload();
			}
    }).fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    }); 
  });



});



</script>
