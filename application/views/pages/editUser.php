<div class="container text-darkblue">
    <form id="change" class="mt-5 container-md" method="post" action="<?php echo base_url(); ?>users/update">
        <div class="form-bg">
            <div class="mx-auto" style="width: 44%;">
                
                <h4 class="mt-5 txt-xl">Konto info</h4>
                <div class="form-label-group mt-4">
                    <label for="publicInfo">E-mail</label>
                    <p class="txt-strong" name="email"><?php echo $post['email']; ?></p>
                    <input name="email" type="text" class="d-none" value="<?php echo $post['email']; ?>">
                </div>

                <div class="form-label-group mt-3">
                    <label for="status">Staatus</label>
                    <select id="status" name="status" class="form-control arrow">
                        <option value="1" <?php if ($post['status']==1) echo ' selected'?>>Aktiivne</option>
                        <option value="0" <?php if ($post['status']==0) echo ' selected'?>>Mitteaktiivne</option>
                    </select>
                </div>
                
                <div class="d-flex justify-content-between p-0 m-0">
                    <div class="form-label-group mt-3 pr-5">
                        <label for="building">Asutus</label>
                        <p id="building" class="txt-strong"><?php echo $post['name']; ?></p>
                        <input type="text" class="d-none" name="building" value="<?php echo $post['buildingID']; ?>">
                    </div>
                    <div class="form-label-group mt-3 pl-5">
                        <label for="role">Roll</label>
                      
                       
                        <input type="text" class="d-none" name="role" id="role" value="<?php echo $post['roleID']; ?>">
                        
                       
                            <?php if($this->session->userdata('roleID')==='2' && $post['roleID']!=1):?>
                                <select id="roleID" name="roleID" class="form-control arrow">
                                    <option value="2" <?php if ($post['roleID']==2) echo ' selected'?>>Juht</option>
                                    <option value="3" <?php if ($post['roleID']==3) echo ' selected'?>>Haldur</option>
                                    <option value="4" <?php if ($post['roleID']==0) echo ' selected'?>>Tavakasutaja</option>
                                    </select>
                             <?php endif;?>
    
                            <?php if($post['roleID']==1 && $this->session->userdata('roleID')=='1'):?>
                                <select id="roleID" name="roleID" class="form-control arrow">
                                <option value="1" <?php if ($post['roleID']==1) echo ' selected'?>>Admin</option>
                                <option value="2" <?php if ($post['roleID']==2) echo ' selected'?>>Juht</option>
                                <option value="3" <?php if ($post['roleID']==3) echo ' selected'?>>Haldur</option>
                                <option value="4" <?php if ($post['roleID']==0) echo ' selected'?>>Tavakasutaja</option>
                                </select>
                            <?php endif;?>
                            
                     
                      
                        <?php if($post['roleID']==1&&$this->session->userdata('roleID')!=='1'):?>
                        <p id="role" class="txt-strong"><?php echo $post['role']; ?></p>
                        <?php endif;?>
















                    </div>
                </div>

                <h4 class="mt-4 txt-xl">Kasutaja info</h4>
                <div class="form-label-group mt-3">
                    <label for="name">Nimi</label>
                    <input id="name" name="name" type="text" class="form-control" value="<?php echo $post['userName']; ?>">
                </div>
                <div class="form-label-group mt-3">
                    <label for="phone">Telefon</label>
                    <input id="phone" name="phone" type="text" class="form-control" value="<?php echo $post['userPhone']; ?>">
                </div>

                <div class="d-flex justify-content-end mt-4 mb-5">
                    <a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="<?php echo base_url(); ?>manageUsers">Katkesta</a>
                    <button type="submit" class="btn btn-custom text-white txt-xl">Salvesta muudatused</button>
                </div>

                <div class="d-none" id="change"></div>
                <input class="d-none" type="hidden" name="id" value="<?php echo $post['userID']; ?>">
                

            </div>
        </div>
    </form>
</div>
