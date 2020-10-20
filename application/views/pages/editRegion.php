<?php echo validation_errors(); ?>

<div class="container">
	<div class="container-md mx-auto mt-5">
		<div class="form-bg">

            <div class="d-flex mb-5">
                <ul class="nav nav-tabs nav-justified col-12 bg-grey p-0">
                    <li class="nav-item p-0 col-12 col-md-4"><a class="nav-link link txt-lg single-tab active pl-5" data-toggle="tab">Piirkonna muutmine</a></li>
					<li class="nav-item p-0"></li>
				
                </ul>
            </div>

            <?php echo form_open('region/update'); ?>

				<h4 class="pt-2 txt-xl px-md-5  mx-md-5 mx-3">Piikonna nimetus</h4>
		        <div class="row d-flex p-0 mt-4 px-md-5 mx-md-5 mx-3">
                    <div class="form-label-group col-12 col-md-6 py-0 pl-0 pr-md-5">
						<input type="number" hidden class="form-control" name="regionID" value="<?php echo $region[0]['regionID']; ?>"> 
                        <input type="text" class="form-control" name="region" value="<?php echo $region[0]['regionName']; ?>">
                    </div>
                  
                </div>

				<div class="row d-flex justify-content-end mt-5 mb-5 mx-md-5 mx-3 pr-md-5">
						<a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2 col-md-3 col-sm-5 col-12" href="<?php echo base_url(); ?>region/view">Katkesta</a>
						<button type="submit" class="btn btn-custom col-md-3 col-sm-5 col-12 text-white txt-xl">Muuda</button>
					</div>
            </form>

        </div>
    </div>
</div>
