<?php echo validation_errors(); ?>

<div class="container text-darkblue mb-5">
    <div class="mt-5 container-md">
        <div class="form-bg">
            <div class="mx-auto">
				<div class="d-flex mb-5">
					<ul class="nav nav-tabs nav-justified col-12 bg-grey">
						<li class="nav-item"><a  class="nav-link link txt-lg single-tab active" data-toggle="tab">Kasutajale õiguse lisamine</a></li>
						<li class="nav-item"></li>
					</ul>
				</div>
				<?php echo form_open('users/registerByAdmin'); ?>

					<h4 class="pt-2 txt-xl px-5 mx-5">Annan juurdepääsu</h4>
					<div class="row d-flex p-0 mt-4 px-5 mx-5">
						<div class="form-label-group col-12 col-md-6 py-0 pl-0 pr-md-5">
							<label>E-mail* <?php if($this->session->flashdata('emailIsNotCorrect')){  echo $this->session->flashdata('emailIsNotCorrect');} ?></label>
							<input id="valid" type="email" class="form-control" name="email" placeholder="E-mail" required value="<?php if($this->session->flashdata('email')){  echo $this->session->flashdata('email');} ?>">
						</div>
					
						<div class="form-label-group col-12 col-md-6 py-0 pl-0 pr-md-5">
							<label>Asutus</label>
							<?php if($this->session->userdata('roleID')==='2'):?>
                                <select id="buildingID" name="buildingID" class="form-control arrow">
								  <?php foreach($buildings as $each){
									  if($this->session->userdata('building')==$each['id']){ ?>
									   <option value="<?php echo $each['id'];?>"><?php echo $each['name']; ?></option>
								   <?php }}?>
                                    </select>
                             <?php endif;?>
    
                            <?php if($this->session->userdata('roleID')=='1'):?>
                                <select id="buildingID" name="buildingID" class="form-control arrow">
								   <option value="0">Vali asutus</option>
								   <?php foreach($buildings as $each){ ?>
									   <option value="<?php echo $each['id'];?>"><?php echo $each['name']; ?></option>
								   <?php }?>

                                </select>
                            <?php endif;?>
						</div>
					</div>

					<div class="row d-flex p-0 mt-4 px-5 mx-5">
						<div class="form-label-group col-12 col-md-6 py-0 pl-0 pr-md-5">
							<label>Roll*</label>
							<select id="role" name="role" class="form-control arrow">
							<?php if($this->session->userdata('roleID')==='1'):?>
								<option value="1">Linnavalitsuse administraator</option>
								<?php endif;?>
								<option value="2">Peaadministraator</option>
								<option value="3" selected>Administraator</option>
							</select>
						</div>
						<!-- <div class="form-label-group col-12 col-md-6 py-0 pl-0 pr-md-5">
							<label>Staatus*</label>
							<select id="status" name="status" class="form-control arrow" required>
								<option value="1" selected>Aktiivne</option>
								<option value="0">Mitteaktiivne</option>
							</select>
						</div> -->
					</div>

				
					<div class="row d-flex justify-content-end px-5 mx-5 my-5">
						<a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="<?php echo base_url(); ?>manageUsers">Katkesta</a>
						<button type="submit" class="btn btn-custom text-white txt-xl col-md-3">Lisa kasutaja</button>
					</div>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
