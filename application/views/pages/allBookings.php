<div class="container">
    <div class="table-container mt-3">
       
		
		Kõik Nädalavaade
		<?php // print_r($manageUsers);?>
        <table class="table-borderless table-users mt-3">
            <thead class="bg-grey border-bottom ">
                <tr>
					<th class="pl-3 py-2 txt-strong text-darkblue" scope="col">Ruum</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Nädalapäev</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Kuupäev</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Alates</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Kuni</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Trenni kestus minutites</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Kinnitatud</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col">Klubi</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col">Trenn</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Kommentaar</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Kontaktisik</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Telefon</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">e-mail</th>
					<th class="py-2 txt-strong text-darkblue" scope="col">Jäi ära</th>
                </tr>
            </thead>
            <tbody class="">
            <?php foreach($manageUsers as $singleUser) : ?>
                <tr>
                    <td class="pl-3 p-1 text-darkblue border-bottom-light"><?php echo $singleUser['roomName']; ?></td>
                    <td class="p-1 text-darkblue border-bottom-light"><?php echo $weekdays[idate('w', strtotime($singleUser['startTime']))]; ?></td>
                    <td class="p-1 text-darkblue border-bottom-light"><?php echo date('d.m.Y', strtotime($singleUser['startTime'])); ?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php echo date('H:i', strtotime($singleUser['startTime'])); ?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php echo date('H:i', strtotime($singleUser['endTime'])); ?></td>

					<!-- https://stackoverflow.com/questions/365191/how-to-get-time-difference-in-minutes-in-php -->
					<td class="p-1 text-darkblue border-bottom-light"><?php echo  round(abs( strtotime($singleUser['endTime']) -  strtotime($singleUser['startTime'])) / 60,2);  ?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php if( $singleUser['approved']==1){ echo "&#10003;";} else {echo "";} ?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php echo $singleUser['public_info']; ?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php echo $singleUser['workout']; ?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php echo $singleUser['comment']; ?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php echo $singleUser['c_name']; ?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php echo $singleUser['c_phone']; ?></td>
                    <td class="p-1 text-darkblue border-bottom-light"><?php echo $singleUser['c_email']; ?> &nbsp; &nbsp;</td>
					<td class="p-1 text-darkblue border-bottom-light"><?php if( $singleUser['takes_place']==1){ echo "";} else {echo "&#10003;";} ?></td>
                
                   
                </tr>                
            <?php endforeach; ?>
		</tbody>
        </table>
    </div>
</div>


