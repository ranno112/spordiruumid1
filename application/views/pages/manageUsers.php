<div class="container">
    <div class="table-container mt-3">
        <div class="mb-2 pb-5">
            <a class="btn btn-custom text-white text-center py-2 px-sm-2 px-lg-5 px-md-4 float-right pluss cursor-pointer" onclick="location.href='<?php echo base_url(); ?>createUser';">
                <p class="m-0 txt-lg txt-strong text-center cursor-pointer">Lisa uus</p>
            </a>
        </div>

        <table class="table-borderless table-users mt-3">
            <thead class="bg-grey border-bottom ">
                <tr>
                    <th class="pl-3 py-2 txt-strong text-darkblue" scope="col">Nimi</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col">Email</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col">Telefon</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col">Asutus</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col">Roll</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col">Staatus</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col"></th>
                </tr>
            </thead>
            <tbody class="">
            <?php foreach($manageUsers as $singleUser) : ?>
                <tr>
                    <td class="pl-3 p-1 text-darkblue border-bottom-light"><?php echo $singleUser['userName']; ?></td>
                    <td class="p-1 text-darkblue border-bottom-light"><?php echo $singleUser['email']; ?></td>
                    <td class="p-1 text-darkblue border-bottom-light"><?php echo $singleUser['userPhone']; ?></td>
                    <td class="p-1 text-darkblue border-bottom-light"><?php echo $singleUser['name']; ?></td>
                    <td class="p-1 text-darkblue border-bottom-light"><?php echo $singleUser['role']; ?> &nbsp; &nbsp;</td>
                    <td class="p-1 text-darkblue border-bottom-light"><?php if( $singleUser['status']==1){ echo "Aktiivne";} else {echo "Mitteakviivne";} ?></td>
                    <td class="d-flex justify-content-end p-1 pr-3">
                        <form class="cat-delete" action="users/edit/<?php echo $singleUser['userID']; ?>" method="POST">
                            <button type="submit" class="btn btn-second btn-width text-white text-center py-1 px-2 txt-strong ">Muuda</button>
                        </form>
                        <?php if($this->session->userdata('roleID')==='1'):?>
                        <form class="cat-delete pl-1" action="users/delete/<?php echo $singleUser['userID']; ?>" method="POST">
                            <button type="submit" class="btn btn-delete btn-width text-white text-center py-1 px-2 txt-strong ">Kustuta</button>
                        </form>
                        <?php endif;?>
                    </td>
                </tr>                
            <?php endforeach; ?>
</tbody>
        </table>
    </div>
</div>