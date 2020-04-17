<?php echo validation_errors(); ?>


<div class="container text-darkblue mb-3">
    <div class="mt-5 container-md">
        <div class="form-bg">
            <div class="mx-auto">
				<div class="d-flex mb-5">
					<ul class="nav nav-tabs nav-justified col-12 bg-grey">
						<li class="nav-item"><a  class="nav-link link txt-lg single-tab active" data-toggle="tab">Profiil</a></li>
						<li class="nav-item"></li><li class="nav-item"></li>
					</ul>
				</div>

			
				<?php if ($editProfile[0]['requestFromBuilding']==1){?>
				<?php echo form_open('profile/acceptTheRequest'); ?>
				<h4 class="pt-2 txt-xl px-5 mx-5">Teile on antud <?php if($this->session->userdata['roleID']=='2'){echo "peaadministraatori";}else{echo 'administraatori';};?> õigused asutuses <?php echo $editProfile[0]['name'];?>. Õiguste nõustumisega annate juurdepääsu teiste asutuse kasutajatele teie nimele ja telefoni numbrile.
				</h4>
				
				<div class="d-flex p-0 mt-4 px-5 mx-5">
					<div class="form-label-group col-6 py-0 pl-0 pr-5">
						<label>Tee valik</label>
					
						<select id="giveaccess" name="giveaccess" class="form-control arrow" >
                                    <option value="0"> Võtan <?php if($this->session->userdata['roleID']=='2'){echo "peaadministraatori";}else{echo 'administraatori';};?> õigused vastu</option>
                                    <option value="1" >Lükkan pakkumise tagasi</option>
                         </select>
					
						
					</div>
				</div>
				<div class="d-flex p-0 mt-4 px-5 mx-5">
					<button type="submit" class="btn btn-success txt-xl">Salvesta</button>	
				</div>
				<br/>
				<hr>
				<br/>
				</form>
				<?php }?>
				
				<?php echo form_open('profile/updateProfile', array('id' => 'change')); ?>
				<?php foreach ($editProfile as $value) {?>
					<h4 class="pt-2 txt-xl px-5 mx-5">Konto info</h4>

					<div class="d-flex p-0 mt-4 px-5 mx-5">
						<div class="form-label-group col-6 py-0 pl-0 pr-5">
							<label>E-mail*</label>
							<input type="email" class="form-control" name="email" value="<?php echo $value['email'];?>" disabled>
						</div>
						<div class="form-label-group col-6 p-0 pl-5">
							<label>Asutus</label>
							<input type="text" class="form-control" name="buildingID" id="buildingID" value="<?php echo $value['name'];?>" disabled>
						</div>
					</div>

					<?php if($value['roleID']=='2' || $value['roleID']=='3'  || $value['roleID']=='1'):?>
					<div class="d-flex p-0 mt-4 px-5 mx-5">
						<div class="form-label-group col-6 py-0 pl-0 pr-5">
								<label>Roll*</label>
									<select id="roleID" name="roleID" class="form-control arrow" disabled>
										<option value="2" <?php if ($value['roleID']==1) echo ' selected'?>>Linnavalitsuse administraator</option>
										<option value="3" <?php if ($value['roleID']==2) echo ' selected'?>>Peaadministraator</option>
										<option value="4" <?php if ($value['roleID']==3) echo ' selected'?>>Administraator</option>
									</select>
						</div>
						<div class="form-label-group col-6 p-0 pl-5">
							
								<label>Staatus*</label>
								<select id="status" name="status" class="form-control arrow" disabled>
                                    <option value="1" <?php if ($value['status']==1) echo ' selected'?>>Aktiivne</option>
                                    <option value="0" <?php if ($value['status']==0) echo ' selected'?>>Mitteaktiivne</option>
                                </select>
							</div>
						</div>
						<?php endif;?>

					<h4 class="mt-5 txt-xl px-5 mx-5">Kasutaja info</h4>
					<div class="d-flex p-0 mt-4 px-5 mx-5">
						<div class="form-label-group col-6 py-0 pl-0 pr-5">
							<label>Nimi*</label>
							<input type="text" class="form-control" name="name" value="<?php echo $value['userName'];?>" disabled>
						</div>
						<div class="form-label-group col-6 p-0 pl-5">
							<label>Telefoni number*</label>
							<input type="text" class="form-control" name="phone" value="<?php echo $value['userPhone'];?>" disabled>
						</div>
					</div>

					<!-- <h4 class="mt-5 txt-xl px-5 mx-5">Parool</h4>
					<div class="d-flex p-0 mt-4 px-5 mx-5">
						<div class="form-label-group col-6 py-0 pl-0 pr-5">
							<label>Parool*</label>
							<input id="pw" type="password" class="form-control" name="password" placeholder="Salasõna">
						</div>
						<div class="form-label-group col-6 p-0 pl-5">
							<label>Parool uuesti*</label>
							<input type="password" class="form-control" name="password2" placeholder="Korda salasõna">
						</div>
					</div> -->
					<div class="d-flex justify-content-end px-5 mx-5 my-5">
						<?php if ($editProfile[0]['requestFromBuilding']!=1){?>
                        <a class="btn btn-custom col-5 text-white txt-xl" href="<?php echo base_url(); ?>profile/edit/<?php echo $this->session->userdata['userID']?>">Redigeeri</a>
						<?php }?>
					</div>
				
					<?php }?>
				</form>
			</div>
		</div>
	</div>
</div>
