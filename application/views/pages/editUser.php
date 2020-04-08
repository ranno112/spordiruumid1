<div class="container text-darkblue">
	<?php echo form_open('users/update', array('id' => 'change','class' => 'mt-5 container-md')); ?>
        <div class="form-bg">
		<?php print_r($buildings);?>
            <div class="mx-auto" style="width: 44%;">
                
                <h4 class="mt-5 txt-xl">Konto info</h4>
                <div class="form-label-group mt-4">
                    <label for="publicInfo">E-mail</label>
               	<input name="email" type="text"  class="form-control arrow" disabled value="<?php echo $post['email']; ?>">
                </div>

                <div class="form-label-group mt-3">
                    <label for="status">Staatus</label>
                    <select id="status" name="status" class="form-control arrow">
                        <option value="1" <?php if ($post['status']==1) echo ' selected'?>>Aktiivne</option>
                        <option value="0" <?php if ($post['status']==0) echo ' selected'?>>Mitteaktiivne</option>
                    </select>
                </div>
			
				
				<div class="row">
                    <div class="col">
                        <label for="building">Asutus</label>
                           
						<?php if($this->session->userdata('roleID')==='2' && $post['roleID']!=1):?>
                                <select id="buildingID" name="buildingID" class="form-control arrow">
								<option value="<?php echo $post['buildingID'];?>" <?php if ($post['buildingID']!=0) echo ' selected'?>><?php echo $post['name']; ?></option>
                                    </select>
                             <?php endif;?>
    
                            <?php if($this->session->userdata('roleID')=='1'):?>
                                <select id="buildingID" name="buildingID" class="form-control arrow">
								   <option value="0" <?php if ($post['buildingID']==0) echo ' selected'?>>Vali asutus</option>
								   <?php foreach($buildings as $each){ ?>
									   <option value="<?php echo $each['id'];?>" <?php if ($post['buildingID']==$each['id']) echo ' selected'?>><?php echo $each['name']; ?></option>
								   <?php }?>

                                </select>
                            <?php endif;?>
                            
						


					</div>
					
                     <div class="col">
                        <label for="role">Roll</label>
                      
                      
                        <input type="text" class="d-none" name="role" id="role" value="<?php echo $post['roleID']; ?>">
                        
                       
						<select id="roleID" name="roleID" class="form-control arrow">
                            <?php if($this->session->userdata('roleID')==='2' && $post['roleID']!='1'):?>
                                    <option value="2" <?php if ($post['roleID']==2) echo ' selected'?>>Juht</option>
                                    <option value="3" <?php if ($post['roleID']==3) echo ' selected'?>>Haldur</option>
                                    <option value="4" <?php if ($post['roleID']==4) echo ' selected'?>> <?php if ($post['roleID']==4) {echo $post['role'];}else echo 'Võta õigused ära' ?></option>
							<?php endif;?>

                            <?php if($this->session->userdata('roleID')=='1'):?>
                                <option value="1" <?php if ($post['roleID']==1) echo ' selected'?>>Admin</option>
                                <option value="2" <?php if ($post['roleID']==2) echo ' selected'?>>Juht</option>
                                <option value="3" <?php if ($post['roleID']==3) echo ' selected'?>>Haldur</option>
								<option value="4" <?php if ($post['roleID']==4) echo ' selected'?>> <?php if ($post['roleID']==4)  {echo $post['role'];}else echo 'Võta õigused ära' ?></option>
							<?php endif;?>
							

						</select>
    
                            
                            
                     
                      
                        <?php if($post['roleID']==1 && $this->session->userdata('roleID')!=='1'):?>
                        <p id="role" class="txt-strong"><?php echo $post['role']; ?></p>
                        <?php endif;?>




                    </div>
                </div>

			<br/>
                <div class="d-flex justify-content-end mt-4 mb-5">
                    <a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="<?php echo base_url(); ?>manageUsers">Katkesta</a>
                    <button type="submit" class="btn btn-custom text-white txt-xl">Salvesta muudatused</button>
                </div>

                <div class="d-none" id="change"></div>
                <input class="d-none" type="hidden" name="id" value="<?php echo $post['userID']; ?>">
                

            </div>
        </div>
		<?php echo form_close(); ?>
</div>
