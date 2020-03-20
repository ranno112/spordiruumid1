<?php echo validation_errors(); ?>

<div class="container">
	<div class="container-md mx-auto mt-5">
		<div class="form-bg">

            <div class="d-flex mb-5">
                <ul class="nav nav-tabs nav-justified col-12 bg-grey p-0">
                    <li class="nav-item p-0"><a class="nav-link link txt-lg single-tab active pl-5" data-toggle="tab">Piirkonna lisamine</a></li>
                    <li class="nav-item p-0"></li><li class="nav-item p-0"></li>
                </ul>
            </div>

            <?php echo form_open('region/register'); ?>

				<h4 class="pt-2 txt-xl px-5 mx-5">Piikonna nimetus</h4>
				
            

                <div class="d-flex p-0 mt-4 px-5 mx-5">
                    <div class="form-label-group col-6 py-0 pl-0 pr-5">
                    
                        <input type="text" class="form-control" name="region">
                    </div>
                  
                </div>

				<div class="d-flex justify-content-end mt-5 mb-5 mx-5 pr-5">
						<a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="<?php echo base_url(); ?>region/view/<?php  print_r($this->session->userdata['building']);  ?>">Katkesta</a>
						<button type="submit" class="btn btn-custom col-3 text-white txt-xl">Lisa piikond</button>
					</div>
            </form>

        </div>
    </div>
</div>
