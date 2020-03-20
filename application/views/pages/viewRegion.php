<?php if($this->session->userdata('roleID')==='1'):?>
<div class="container">
	<div class="row justify-content-center">
	
		<div class="col-3">
		<div class="table-container mt-3">
				<div class="mb-2 pb-5">
					<a class="btn btn-custom text-white text-center py-2 px-sm-2 px-lg-5 px-md-4 float-right pluss cursor-pointer" onclick="location.href='<?php echo base_url();?>createRegion'">
						<p class="m-0 txt-lg txt-strong text-center cursor-pointer">Lisa uus</p>
					</a>
				</div>
				<h4	>	Asutused</h4>
				<table class="table-borderless table-users mt-3">
					<thead class="bg-grey border-bottom ">
					<tr>
						<th class="pl-3 py-2 txt-strong text-darkblue" scope="col">Piirkonna nimetus</th>
			
						<th class="py-2 txt-strong text-darkblue" scope="col"></th>
					</tr>
					</thead>
					<tbody class="">
					<?php foreach($regions as $region) : 
				
					
						?>
						<tr>
							<td class="pl-3 p-1 text-darkblue border-bottom-light"><?php echo $region['regionName']; ?></td>
						
						
							<td class="d-flex justify-content-end p-1 pr-3">
								<form class="cat-delete" action="<?php echo base_url(); ?>region/edit/<?php echo $region['regionID']; ?>" method="POST">
									<button type="submit" class="btn btn-second btn-width text-white text-center py-1 px-2 txt-strong ">Muuda</button>
								</form>
								<form class="cat-delete pl-1" action="<?php echo base_url(); ?>region/delete" method="POST">
									<!-- <input type="submit" class="" value="Kustuta"> -->
									<input type="hidden" name="regionID" value="<?php echo $region['regionID']; ?>" />
									<button type="submit" class="btn btn-delete btn-width text-white text-center py-1 px-2 txt-strong ">Kustuta</button>
								</form>
							</td>
						</tr>                
					<?php endforeach; ?>
		</tbody>
				</table>
			</div>





		</div>
	</div>
  
</div>
<?php endif;?>
