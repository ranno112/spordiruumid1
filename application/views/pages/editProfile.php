<?php echo validation_errors(); ?>

<div class="container text-darkblue mb-3">
    <div class="mt-5 container-md">
        <div class="form-bg">
            <div class="mx-auto">
				<div class="d-flex mb-5">
					<ul class="nav nav-tabs nav-justified col-12 bg-grey">
						<li class="nav-item"><a  class="nav-link link txt-lg single-tab active" data-toggle="tab">Muuda profiili</a></li>
						<li class="nav-item"></li><li class="nav-item"></li>
					</ul>
				</div>
				<form id="change" method="post" action="<?php echo base_url(); ?>profile/updateProfile">
				<?php foreach ($editProfile as $value) {?>
					<h4 class="pt-2 txt-xl px-5 mx-5">Konto info</h4>

					<div class="d-flex p-0 mt-4 px-5 mx-5">
						<div class="form-label-group col-6 py-0 pl-0 pr-5">
							<label>E-mail*</label>
							<input type="email" class="form-control"  value="<?php echo $value['email'];?>" disabled>
						</div>
						<div class="form-label-group col-6 p-0 pl-5">
							<label>Asutus</label>
							<input type="text" class="form-control"  id="buildingName" value="<?php echo $value['name'];?>" disabled>
						</div>
					</div>

					<div class="d-flex p-0 mt-4 px-5 mx-5">
						<div class="form-label-group col-6 py-0 pl-0 pr-5">
							<?php if($value['roleID']=='2' || $value['roleID']=='3'  || $value['roleID']=='1'):?>
							<label>Roll*</label>
                                <select id="roleID" name="roleID" class="form-control arrow" disabled>
                                    <option value="2" <?php if ($value['roleID']==1) echo ' selected'?>>Admin</option>
                                    <option value="3" <?php if ($value['roleID']==2) echo ' selected'?>>Juht</option>
                                    <option value="4" <?php if ($value['roleID']==3) echo ' selected'?>>Haldur</option>
                                    </select>
                             <?php endif;?>


						</div>
						<div class="form-label-group col-6 p-0 pl-5">
						
						
							<?php if($value['roleID']=='2' || $value['roleID']=='3'  || $value['roleID']=='1'):?>
								<label>Staatus*</label>
								<select id="status" name="status" class="form-control arrow" disabled>
                                    <option value="1" <?php if ($value['status']==1) echo ' selected'?>>Aktiivne</option>
                                    <option value="0" <?php if ($value['status']==0) echo ' selected'?>>Mitteaktiivne</option>
                                   
                                    </select>
                             <?php endif;?>


						</div>
					</div>

					<h4 class="mt-5 txt-xl px-5 mx-5">Kasutaja info</h4>
					<div class="d-flex p-0 mt-4 px-5 mx-5">
						<div class="form-label-group col-6 py-0 pl-0 pr-5">
							<label>Nimi*</label>
							<input type="text" class="form-control" name="name" value="<?php echo $value['userName'];?>">
						</div>
						<div class="form-label-group col-6 p-0 pl-5">
							<label>Telefoni number*</label>
							<input type="number" class="form-control" name="phone" value="<?php echo $value['userPhone'];?>">
						</div>
					</div>

					<h4 class="mt-5 txt-xl px-5 mx-5">Muuda parooli</h4>
					<div class="d-flex p-0 mt-4 px-5 mx-5">
						<div class="form-label-group col-6 py-0 pl-0 pr-5">
							<label>Parool*</label>
							<input id="pw" type="password" class="form-control" name="password" placeholder="Salasõna">
						</div>
						<div class="form-label-group col-6 p-0 pl-5">
							<label>Parool uuesti*</label>
							<input type="password" class="form-control" name="password2" placeholder="Korda salasõna">
						</div>
					</div>

					<div class="d-flex justify-content-end my-5 px-5 mx-5">
                        <a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="<?php echo base_url(); ?>profile">Katkesta</a>
                        <button type="submit" class="btn btn-custom col-5 text-white txt-xl">Salvesta muudatused</button>
                    </div>
					<?php }?>
				</form>
			</div>
		</div>
	</div>
</div>