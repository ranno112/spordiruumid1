<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo validation_errors(); ?>
<?php $stack = array(); foreach ($allBookingInfo as $each) { 
    array_push($stack, $each['public_info'] );
 };?>
      
<div class="modal" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tuvastatud aegade kattuvus</h5>
 
      </div>
      <div class="modal-body">
		<h6>Soovitud broneering kattub allolevate broneeringutega. Sellist broneeringut automaatselt ei kinnitata. </h6>
	
		<table id="myTable" class="table">
		<thead>	<tr><th>Kuupäev</th><th>Kellaaeg</th><th>Treening</th><th>Klubi</th></tr>	
		</thead>
			<tbody>
		
			</tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" id="submitWithConflicts" class="btn btn-secondary">Salvesta sellegipoolest</button>
        <button type="button" class="btn btn-custom text-white " data-dismiss="modal">Muudan broneeringu</button>
      </div>
    </div>
  </div>
</div>                     

<div class="container">
    <div id="forms" class="container-md">
        <div id="nav-tabs" class="mt-5 pb-5 form-bg">
            <div class="d-flex mb-5">
                <ul class="nav nav-tabs nav-justified col-12 bg-grey">
                    <li class="nav-item"><a  class="nav-link link txt-lg  active" href="#mitmekordne" data-toggle="tab">Ühekordne broneering</a></li>
                    <li class="nav-item"><a  class="nav-link link txt-lg" href="#hooajaline" data-toggle="tab">Hooajaline broneering</a></li>
                    <?php if($this->session->userdata('roleID')==='2'||$this->session->userdata('roleID')==='3'):?>
                    <li class="nav-item"><a  class="nav-link link txt-lg" href="#suletud" data-toggle="tab">Suletud broneering</a></li>
                    <?php endif;?>
                </ul>
            </div>



            <div class="tab-content ">
                <div id="mitmekordne" class="tab-pane center active">
                    <?php echo form_open('booking/createOnce'); ?>

                        <h4 class="pt-2 txt-xl px-5 mx-5">Kontakt</h4>
                        <div class="d-flex p-0 mt-4 px-5 mx-5">
                            <div class="form-label-group col-6 py-0 pl-0 pr-5">
                                <label for="contact">Klubi nimi (avalik info)*</label>
                                <input class="form-control" id="clubname" type="text" name="clubname" required>
                            </div>
                            <input class="d-none" type="checkbox" id="type" name="type" value="1" checked>
                            <div class="form-label-group col-6 p-0 pl-5">
                                <label>Kontaktisik*</label>
                                <input class="form-control" id="contact" name="contactPerson" value="<?php if($this->session->userdata('roleID')!='2' && $this->session->userdata('roleID')!='3'){echo $this->session->userdata('userName');}; ?>" required>
                            </div>
                        </div>
                        <div class="d-flex mt-2 px-5 mx-5">
                            <div class="form-label-group col-6 py-0 pl-0 pr-5">
                                <label>Telefoni number</label>
                                <input class="form-control" id="phone" name="phone" value="<?php if($this->session->userdata('roleID')!='2' && $this->session->userdata('roleID')!='3'){echo $this->session->userdata('phone');}; ?>">
                            </div>

                            <div class="form-label-group col-6 p-0 pl-5">
                                <label>Email</label>
                                <input class="form-control" id="email" name="email" value="<?php if($this->session->userdata('roleID')!='2' && $this->session->userdata('roleID')!='3'){echo $this->session->userdata('email');}; ?>">
                            </div>
                        </div>

                        <h4 class="mt-5 txt-xl px-5 mx-5">Asukoht ja sündmus / treeningu tüüp</h4>
                        <div class="d-flex mt-4 px-5 mx-5">
                            <div class="form-label-group col-6 py-0 pl-0 pr-5">
                                <label for="sport_facility">Asutus</label>
                                <input id="sport_facility" class="form-control" list="asutus" id="building" disabled value="<?php $test = $this->session->userdata('building'); foreach ($buildings as $each) { $id = $each->id; $name = $each->name; if ($id == $test) {echo $each->name;}};?>">
                            </div>
                           <?php echo $this->input->get('roomId');?>
                            <div class="form-label-group col-6 p-0 pl-5">
                                <label for="room">Ruum*</label>
                                <select id="room" list="saal" name="sportrooms" class="form-control arrow" >
                                    <?php foreach ($rooms as $each) {
                                        echo $each->id;
                                               if( $this->uri->segment(3)== $each->id){
                                                    echo '<option selected value="' . $each->id . '">' . $each->roomName . '</option>';
                                                }else{
                                                echo '<option value="' . $each->id . '">' . $each->roomName . '</option>';}
                                            } ?>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex mt-2 px-5 mx-5">
                            <div class="form-label-group col-6 py-0 pl-0 pr-5">
                                <label>Sündmus / Treeningu tüüp (avalik info)</label>
                                <input class="form-control" id="type" name="workoutType" placeholder="nt iluvõimlemine">
                            </div>
                            <div class="form-label-group col-6 p-0 pl-5"></div>
                        </div>

                        <h4 class="mt-5 txt-xl px-5 mx-5">Kuupäev ja kellaaeg</h4>
                        <div class="mt-4 bg-grey py-2">
                            <div class="form-label-group px-5 mx-5" id="timestamp">
							
								
								<div class="d-flex justify-content-between m-0 px-0 pt-0 pb-1">
                                    <label class="col-5 m-0 p-0" for="sport_facility2">Kuupäev</label>
                                    <label class="d-hidden col-1 mr-1 p-0"></label>
                                    <label class="col-2 m-0 pl-3" for="from1">Alates</label>
                                    <label class="col-2 m-0 p-0" for="until1">Kuni</label>
                                </div>


                                <div id="InputsWrapper" class="mb-3 p-0">
                                    <div class="d-flex align-items-center mb-3 justify-content-between">
                                        <input class="datePicker col-5 form-control" id="datefield_1" data-toggle="datepicker" name="workoutDate[]">

                                        <a href="#" class="removeclass col-1 pl-1 pr-5"><span class="icon-cancel"></span></a>

                                        <div class="col-2 p-0 ml-5">
									
                                            <input type="input" class="clock form-control" name="begin[]" data-minimum="08:00" data-maximum="22:00" id="timestartfield_1" value="<?php echo $this->input->get('start') ? $this->input->get('start') : date('H:i');?>">
                                        </div>

                                        <div class="col-2 p-0">
                                            <input type="input" class="clock form-control" name="end[]" data-minimum="08:00" data-maximum="22:00" id="timeendfield_1" value="<?php echo $this->input->get('end') ? $this->input->get('end') :  date("H:i", strtotime('+90 minutes')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div id="AddMoreFileId" class="d-flex p-0">
                                    <a id="AddMoreFileBox" class="btn btn-custom text-white text-center py-2 pluss" style="width: 279px"><p class="m-0 px-0 txt-lg txt-strong text-center align-items-center">Lisa veel üks kuupäev</p></a>
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-5 txt-xl px-5 mx-5">Lisainfo (valikuline) </h4>
                        <div class="mt-4 px-5 mx-5">
                            <div class="form-label-group pb-2 px-0">
                                <label>Lisainfo</label>
								<textarea class="form-control" id="additional" name="additionalComment" rows="3" placeholder="nt palun võrkpalli trenni jaoks eelnevalt üles seada võrk"></textarea>
								
							</div>
							<label><input type="checkbox" checked name="approveNow" id="approveNow" value="1"><span></span></label> Kinnita kohe
						</div>
					

                        <div class="d-flex justify-content-end mt-5 px-5 mx-5">
                          	<a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="#" onClick="history.go(-1); return false;">Katkesta</a>
                            <input class="btn btn-custom col-3 text-white txt-xl" type="submit" value="Broneeri">
                        </div>
						<input type="hidden" name="current_url" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" />
                    </form>
                </div>

                <div id="hooajaline" class="tab-pane center">
                    <?php echo form_open('booking/createClosed', array('id' => 'myPeriodicForm')); ?>

                        <h4 class="pt-2 txt-xl px-5 mx-5">Kontakt</h4>
                        <div class="d-flex px-5 mx-5 mt-4">
                            <div class="form-label-group col-6 py-0 pl-0 pr-5">
                                <label for="contact">Klubi nimi (avalik info)*</label>
                                <input class="form-control" id="clubname" type="text" name="clubname" required>
                            </div>

                            <div class="form-label-group col-6 p-0 pl-5">
                                <label>Kontaktisik*</label>
                                <input class="form-control" id="contact" name="contactPerson" value="<?php if($this->session->userdata('roleID')!='2' && $this->session->userdata('roleID')!='3'){echo $this->session->userdata('userName');}; ?>" required>
                            </div>
                        </div>
                        <div class="d-flex mt-2 px-5 mx-5">
                            <div class="form-label-group col-6 py-0 pl-0 pr-5">
                                <label>Telefoni number</label>
                                <input class="form-control" id="phone" name="phone" value="<?php if($this->session->userdata('roleID')!='2' && $this->session->userdata('roleID')!='3'){echo $this->session->userdata('phone');}; ?>">
                            </div>

                            <div class="form-label-group col-6 p-0 pl-5">
                                <label>Email</label>
                                <input class="form-control" id="email" name="email" value="<?php if($this->session->userdata('roleID')!='2' && $this->session->userdata('roleID')!='3'){echo $this->session->userdata('email');}; ?>">
                            </div>
                        </div>


                        <h4 class="mt-5 txt-xl px-5 mx-5">Asukoht ja sündmus / treeningu tüüp</h4>
                        <div class="d-flex mt-4 px-5 mx-5">
                            <div class="form-label-group col-6 py-0 pl-0 pr-5">
                                <label for="sport_facility">Asutus</label>
                                <input id="sport_facility" class="form-control" list="asutus" id="building" value="<?php $test = $this->session->userdata('building'); foreach ($buildings as $each) { $id = $each->id; $name = $each->name; if ($id == $test) {echo $each->name;}};?>" disabled>
                            </div>

                            <div class="form-label-group col-6 p-0 pl-5">
                                <label for="room">Ruum*</label>
                                <select id="room" list="saal" name="sportrooms" class="form-control arrow" >
                                <?php foreach ($rooms as $each) {
                                        echo $each->id;
                                               if( $this->uri->segment(3)== $each->id){
                                                    echo '<option selected value="' . $each->id . '">' . $each->roomName . '</option>';
                                                }else{
                                                echo '<option value="' . $each->id . '">' . $each->roomName . '</option>';}
                                            } ?>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex mt-2 px-5 mx-5">
                            <div class="form-label-group col-6 py-0 pl-0 pr-5">
                                <label for="type">Sündmus / Treeningu tüüp (avalik info)</label>
                                <input class="form-control" id="type" name="workoutType" placeholder="nt iluvõimlemine">
                            </div>
                            <div class="form-label-group col-6 p-0 pl-5">
                                <input class="d-none" type="checkbox" name="type" value="2" checked>
                             
                            </div>
                        </div>                        
                           
                        <h4 class="mt-5 txt-xl px-5 mx-5">Kuupäev ja kellaaeg</h4>
                        <div class="mt-4 bg-grey py-2">
                            <div class="form-label-group px-5 mx-5"  id="InputsWrapper1">
                                <div class="d-flex justify-content-between m-0 px-0 pt-0 pb-1">
                                    <label class="col-5 m-0 p-0" for="sport_facility2">Nädalapäev</label>
                                    <label class="d-hidden col-1 mr-1 p-0"></label>
                                    <label class="col-2 m-0 pl-3" for="from1">Alates</label>
                                    <label class="col-2 m-0 p-0" for="until1">Kuni</label>
                                </div>
                                <div id="dateContainer">
                                    <div class="d-flex align-items-center mb-3 justify-content-between">
                                        <input class="form-control col-5 arrow" id="sport_facility2" list="weekdays" name="weekday[]" required>

                                            <datalist id="weekdays">
                                                <option data-value="1" value="Esmaspäev"></option>
                                                <option data-value="2" value="Teisipäev"></option>
                                                <option data-value="3" value="Kolmapäev"></option>
                                                <option data-value="4" value="Neljapäev"></option>
                                                <option data-value="5" value="Reede"></option>
                                                <option data-value="6" value="Laupäev"></option>
                                                <option data-value="7" value="Pühapäev"></option>       
                                            </datalist>

                                        <a href="#" class="removeclass1 col-1 pl-1 pr-5"><span class="icon-cancel"></span></a>

                                        <div class="col-2 p-0 ml-5">
                                            <input type="text" class="clock form-control" name="timesStart[]" data-minimum="08:00" data-maximum="22:00" id="from1" value="<?php echo $this->input->get('start') ? $this->input->get('start') : date('H:i'); ?>">
                                        </div>

                                        <div class="col-2 p-0">
                                            <input type="text" class="clock form-control" name="timeTo[]" data-minimum="08:00" data-maximum="22:00" id="until1" value="<?php echo $this->input->get('end') ? $this->input->get('end') :  date("H:i", strtotime('+90 minutes')); ?>">
                                        </div>                                    
                                    </div>
                                </div>

                                <div id="AddMoreFileId1" class="flex col-5 p-0">
                                    <a id="AddMoreFileBoxPeriod" class="btn btn-custom text-white text-center py-2 px-4 pluss"><p class="m-0 px-0 txt-lg txt-strong text-center align-items-center">Lisa veel üks päev</p></a>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex px-5 mx-5 mt-4">                        
                            <div class="form-label-group m-0 pl-0 pr-3 col-3">
                                <label>Periood</label>
                                <input class="datePicker form-control" id="periodStart" data-toggle="datepicker" name="startingFrom">
                            </div>
                            <div class="form-label-group m-0 pl-0 col-3">  
                                <label class="invisible">Periood</label> 
                                <input class="datepickerUntil form-control" id="periodEnd" data-toggle="datepickerUntil" name="Ending">
                            </div>
                        </div>

                        <h4 class="mt-5 txt-xl px-5 mx-5">Lisainfo (valikuline) </h4>
                        <div class="mt-4 px-5 mx-5">
                            <div class="form-label-group pb-2 px-0">
                                <label>Lisainfo</label>
                                <textarea class="form-control" id="comment2" name="comment2" rows="3" placeholder="nt palun võrkpalli trenni jaoks eelnevalt üles seada võrk"></textarea>
							</div>
							<label><input type="checkbox" checked name="approveNow" id="approvePeriodNow" value="1"><span></span></label> Kinnita kohe
                        </div>

                        <div class="d-flex justify-content-end mt-5 px-5 mx-5">
                            <a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="">Katkesta</a>
                            <input class="btn btn-custom col-3 text-white txt-xl" type="button" id="checkForConflicts" value="Broneeri">
                        </div>
						<input type="hidden" name="current_url" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" />
                    </form>
                </div>

                <div id="suletud" class="tab-pane center">
                <?php echo form_open('booking/createClosed'); ?>

                        <h4 class="mt-5 txt-xl px-5 mx-5">Ruum ja aeg</h4>
                        <div class="d-flex px-5 mx-5">
                            <div class="form-label-group col-6 pl-0">
                                <label for="contact">Ruum</label>
                                <select name="sportrooms"  class="form-control arrow" id="room2" >
                                <?php foreach ($rooms as $each) {
                                        echo $each->id;
                                               if( $this->uri->segment(3)== $each->id){
                                                    echo '<option selected value="' . $each->id . '">' . $each->roomName . '</option>';
                                                }else{
                                                echo '<option value="' . $each->id . '">' . $each->roomName . '</option>';}
                                            } ?>
                                </select>                                
                            </div>

                            <div class="d-flex mt-2 px-5 mx-5">
                                <input class="d-none" type="checkbox" name="type" value="4" checked> <!-- Suletud (See tuleb ära peita ehk panna hidden)<br> -->
                                <input class="d-none" type="checkbox" name="clubname" value="Suletud" checked> <!-- Suletud Title (See tuleb ära peita ehk panna hidden)<br> -->
                                <input class="d-none" type="checkbox" name="approveNow" value="1" checked>
                            </div>
                        </div>

                        <div class="mt-4 bg-grey py-2">
                            <div class="form-label-group px-5 mx-5"  id="InputsWrapper2">
                                <div class="d-flex justify-content-between m-0 px-0 pt-0 pb-1">
                            <!-- <div class="form-label-group col-6 pl-0"  id="InputsWrapper2"> -->
                                    <label class="col-5 m-0 p-0" for="sport_facility2">Nädalapäev</label>
                                    <label class="d-hidden col-1 mr-1 p-0"></label>
                                    <label class="col-2 m-0 pl-3" for="from1">Alates</label>
                                    <label class="col-2 m-0 p-0" for="until1">Kuni</label>
                                </div>
                                <div id="closeContainer">
                                    <div class="d-flex align-items-center mb-3 justify-content-between">
                                        <input class="form-control col-5 arrow" id="sport_facility2" list="weekdays" name="weekday[]" required>

                                            <datalist id="weekdays">
                                                <option data-value="1" value="Esmaspäev"></option>
                                                <option data-value="2" value="Teisipäev"></option>
                                                <option data-value="3" value="Kolmapäev"></option>
                                                <option data-value="4" value="Neljapäev"></option>
                                                <option data-value="5" value="Reede"></option>
                                                <option data-value="6" value="Laupäev"></option>
                                                <option data-value="7" value="Pühapäev"></option>
                                            </datalist>

                                        <a href="#" class="removeclass2 col-1 pl-1 pr-5"><span class="icon-cancel"></span></a>

                                        <div class="col-2 p-0 ml-5">
                                            <input type="text" class="clock form-control" data-minimum="08:00" data-maximum="22:00" name="timesStart[]" id="from1" value="08:00">
                                        </div>

                                        <div class="col-2 p-0">
                                            <input type="text" class="clock form-control" data-minimum="08:00" data-maximum="22:00" name="timeTo[]" id="until1" value="22:00">
                                        </div>
                                    </div>
                                </div>

                                <div id="AddMoreFileId2" class="flex">
                                    <a id="AddMoreFileBoxClosed" class="btn btn-custom text-white text-center py-2 px-4 pluss"><p class="m-0 px-0 txt-lg txt-strong text-center align-items-center">Lisa nädalapäev</p></a>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex px-5 mx-5 mt-4">                        
                            <div class="form-label-group m-0 pl-0 pr-3 col-3">
                                <label>Periood</label>
                                <input class="datePicker form-control" id="periodStart" data-toggle="datepicker" name="startingFrom">
                            </div>
                            <div class="form-label-group m-0 pl-0 col-3">  
                                <label class="invisible">Periood</label> 
                                <input class="datePicker form-control" id="periodEnd" data-toggle="datePicker" name="Ending">
                            </div>
                        </div>

                        <h4 class="mt-5 txt-xl px-5 mx-5">Lisainfo (valikuline) </h4>
                        <div class="mt-4 px-5 mx-5">
                            <div class="form-label-group pb-2 px-0">
                                <label>Lisainfo</label>
                                <textarea class="form-control" id="comment2" name="comment2" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5 px-5 mx-5">
                            <a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="">Katkesta</a>
                            <input class="btn btn-custom col-3 text-white txt-xl" type="submit" value="Broneeri">
                        </div>
						<input type="hidden" name="current_url" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" />
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<br/>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker.js"></script>
<script>


    $(document).ready(function() {

		$('#myModal').on('hidden.bs.modal', function (e) {
			$('#approvePeriodNow').prop('checked', true);
			$("#myTable").find("tr:gt(0)").remove();
		});
		var days=['Pühapäev', 'Esmaspäev', 'Teisipäev', 'Kolmapäev', 'Neljapäev', 'Reede', 'Laupäev'];
        var today=new Date();
		var endOfPeriond=new Date('05/31/'+ new Date().getFullYear()); 
		var dateFormat = moment('<?php echo ($this->input->get('startDate')); ?>', "DD-MM-YYYY");
		var selectedWeekDay = new Date(dateFormat);
		
		console.log(days[selectedWeekDay.getDay()]);
		if(days.includes(days[selectedWeekDay.getDay()])){
		var list = document.getElementsByClassName("form-control col-5 arrow");
			for (var i = 0; i < list.length; i++) {
			list[i].setAttribute("value", days[selectedWeekDay.getDay()]);
			}
	};
        var dateToShow='';
        if (today<endOfPeriond){
            dateToShow=endOfPeriond;

        }else{
            dateToShow=new Date(endOfPeriond.setFullYear(endOfPeriond.getFullYear() + 1));  ;
        };
       

        $(".datepickerUntil").datepicker({
            language: "et-EE",
            autoHide: true,
            date: dateToShow,
            autoPick: true,
        });

        $(".datePicker").datepicker({
            language: "et-EE",
            autoHide: true,
            date: '<?php echo $this->input->get('startDate') ? $this->input->get('startDate'):"new Date()";?>',
            autoPick: true,
        });

        $('.clock').clockTimePicker({
            duration: true,
            durationNegative: true,
            precision: 15,
            i18n: {
                cancelButton: 'Tühista'
            },
            onAdjust: function(newVal, oldVal) {
                //...
            }
        });

        var MaxInputs = 100; //maximum extra input boxes allowed
        var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
        var AddButton = $("#AddMoreFileBox"); //Add button ID

        var x = InputsWrapper.length; //initlal text box count
        var FieldCount = 1; //to keep track of text box added

        //on add input button click
        $(AddButton).click(function(e) {
            //max input box allowed
            if (x <= MaxInputs) {
                FieldCount++; //text box added ncrement
                //add input box
                $('#InputsWrapper').append('<div class="d-flex align-items-center mb-3 justify-content-between"><input class="datePicker col-5 form-control" id="datefield_' + FieldCount + '" data-toggle="datepicker" name="workoutDate[]"><a class="removeclass col-1 pl-1 pr-5"><span class="icon-cancel"></span></a><div class="col-2 p-0 ml-5"><input type="text" class="clock form-control" name="begin[]" data-minimum="08:00" data-maximum="22:00" id="timestartfield_' + FieldCount + '" value="<?php echo $this->input->get('start') ? $this->input->get('start') : date('H:i');?>"></div><div class="col-2 p-0"><input type="text" class="clock form-control" name="end[]" data-minimum="08:00" data-maximum="22:00" id="timeendfield_' + FieldCount + '" value="<?php echo $this->input->get('end') ? $this->input->get('end') :  date("H:i", strtotime('+90 minutes')); ?>"></div></div>');

                $(".datePicker").datepicker({
                    language: "et-EE", 
                    autoHide: true, 
                    date: new Date(), 
                    autoPick: true
                });

                $(".datepickerUntil").datepicker({
                    language: "et-EE",
                    autoHide: true,
                    date: dateToShow,
                    autoPick: true,
                });

                $('.clock').clockTimePicker({
                    duration: true,
                    durationNegative: true,
                    precision: 15,
                    i18n: {
                        cancelButton: 'Võta tagasi'
                    },
                    onAdjust: function(newVal, oldVal) {
                        //...
                    }
                });

                x++; //text box increment

                $("#AddMoreFileId").show();
                // $('AddMoreFileBox').html("Add field");

                // Delete the "add"-link if there is 3 fields.
                if (x == MaxInputs) {
                    $("#AddMoreFileId").hide();
                    $("#lineBreak").html("<br>");
                }
            }
            return false;
        });

        $("#timestamp").on("click", ".removeclass", function(e) { //user click on remove text
            if (x > 1) {
                $(this).parent('div').remove(); //remove text box
                x--; //decrement textbox
                $("#AddMoreFileId").show();
                console.log(x);
                return x;
            }
            return false;
        });
        
        var maxPeriod = 100;
        var InputsWrapper1 = $("#InputsWrapper1"); //Input boxes wrapper ID
        var AddButton1 = $("#AddMoreFileBoxPeriod"); //Add button ID

        var y = InputsWrapper1.length; //initlal text box count
        
        $("#AddMoreFileBoxPeriod").click(function(e) {
            //max input box allowed

            if (y <= maxPeriod) {
                FieldCount++; //text box added ncrement
                //add input box
                $('#dateContainer').append('<div class="d-flex align-items-center mb-3 justify-content-between"><input class="form-control col-5 arrow" id="sport_facility2" list="weekdays" name="weekday[]"><datalist id="weekdays"><option data-value="1" value="Esmaspäev"></option><option data-value="2" value="Teisipäev"></option><option data-value="3" value="Kolmapäev"></option><option data-value="4" value="Neljapäev"></option><option data-value="5" value="Reede"></option><option data-value="6" value="Laupäev"></option><option data-value="7" value="Pühapäev"></option></datalist><a href="#" class="removeclass1 col-1 pl-1 pr-5"><span class="icon-cancel"></span></a><div class="col-2 p-0 ml-5"><input type="text" class="clock form-control" name="timesStart[]" data-minimum="08:00" data-maximum="22:00" id="from' + FieldCount + '" value="<?php echo $this->input->get('start') ? $this->input->get('start') : date('H:i'); ?>"></div><div class="col-2 p-0"><input type="text" class="clock form-control" name="timeTo[]" data-minimum="08:00" data-maximum="22:00" id="until' + FieldCount + '" value="<?php echo $this->input->get('end') ? $this->input->get('end') :  date("H:i", strtotime('+90 minutes')); ?>"></div></div>');

                $('.clock').clockTimePicker({
                    duration: true,
                    durationNegative: true,
                    precision: 15,
                    i18n: {
                        cancelButton: 'Võta tagasi'
                    },
                    onAdjust: function(newVal, oldVal) {
                        //...
                    }
                });

                y++; //text box increment

                $("#AddMoreFileId1").show();

                // $('AddMoreFileBox').html("Add field");

                // Delete the "add"-link if there is 3 fields.
                if (y == maxPeriod) {
                    $("#AddMoreFileId1").hide();
                    $("#lineBreak").html("<br>");
                }
            }
            return false;
        });

        $("#dateContainer").on("click", ".removeclass1", function(e) { //user click on remove text
            if (y > 1) {
                $(this).parent('div').remove(); //remove text box
                y--; 
                $("#AddMoreFileId1").show();

               }
            return false;
        });


        var maxClosed = 100;
        var InputsWrapper2 = $("#InputsWrapper2"); //Input boxes wrapper ID
        var AddButton2 = $("#AddMoreFileBoxClosed"); //Add button ID

        var z = InputsWrapper2.length; //initlal text box count


        $("#AddMoreFileBoxClosed").click(function(e) {
            //max input box allowed

            if (z <= maxClosed) {
                FieldCount++; //text box added ncrement
                //add input box
                $('#closeContainer').append('<div class="d-flex align-items-center mb-3 justify-content-between"><input class="form-control col-5 arrow" id="sport_facility2" list="weekdays" name="weekday[]"><datalist id="weekdays"><option data-value="1" value="Esmaspäev"></option><option data-value="2" value="Teisipäev"></option><option data-value="3" value="Kolmapäev"></option><option data-value="4" value="Neljapäev"></option><option data-value="5" value="Reede"></option><option data-value="6" value="Laupäev"></option><option data-value="7" value="Pühapäev"></option></datalist><a href="#" class="removeclass2 col-1 pl-1 pr-5"><span class="icon-cancel"></span></a><div class="col-2 p-0 ml-5"><input type="text" class="clock form-control" name="timesStart[]" id="from' + FieldCount + '" value="08:00"></div><div class="col-2 p-0"><input type="text" class="clock form-control" name="timeTo[]" data-minimum="08:00" data-maximum="22:00" id="until' + FieldCount + '" value="22:00"></div></div>');

                $('.clock').clockTimePicker({
                    duration: true,
                    durationNegative: true,
                    precision: 15,
                    i18n: {
                        cancelButton: 'Võta tagasi'
                    },
                    onAdjust: function(newVal, oldVal) {
                        //...
                    }
                });

                z++; //text box increment

                $("#AddMoreFileId1").show();

                // $('AddMoreFileBox').html("Add field");

                // Delete the "add"-link if there is 3 fields.
                if (z == maxClosed) {
                    $("#AddMoreFileId2").hide();
                    $("#lineBreak").html("<br>");
                }
            }
            return false;
        });

        $('#closeContainer').on('click', '.removeclass2', function(e) { //user click on remove text
            if (z > 1) {
                $(this).parent('div').remove(); //remove text box
                z--; 
                $("#AddMoreFileId2").show();

               }
            return false;
        });





    $(".nav a").on("click", function() { // TAB'i active klassi toggle
        $(".nav a").removeClass("active");
        $(this).addClass("active");
    });






function isOverlapping(event, conflicts) {
	for (i in conflicts) {
	
			if (conflicts[i].start != null && conflicts[i].end != null && event.start != null && event.end != null) {
				if (moment(conflicts[i].start).isBefore(event.end) && moment(conflicts[i].end).isAfter(event.start)) {
					//console.log(event.start.substring(0, 16)+ "-"+ event.end.substring(11, 16) + " on konfliktis järgmise ajaga: "+ conflicts[i].start.substring(0, 16)+"-"+conflicts[i].end.substring(11, 16)+" "+conflicts[i].title+" "+conflicts[i].description);
						$('#myTable > tbody:last-child').append('<tr><td>'+conflicts[i].start.substring(0, 10)+'</td><td>'+ conflicts[i].start.substring(11, 16)+"-"+conflicts[i].end.substring(11, 16)+'</td><td>'+conflicts[i].description+'</td><td>'+conflicts[i].title+'</td></tr>');
						$('#myModal').modal('show')
					return true;
				}
			}
		}
		return false;
	}

	function toDate(str) {

var [yyyy, MM, dd, hh, mm] = str.split(/[- :]/g);
return new Date(`${MM}/${dd}/${yyyy} ${hh}:${mm}`);
};

    
	function getDates(startDate, stopDate) {
    var dateArray = [];
    var currentDate = moment(startDate);

    var stopDate = moment(stopDate);
	var val = $('#sport_facility2').val()
    var startingDate = $('#from1').val();
	if (isNaN(startingDate.substring(0, 2))) {
		startingDate = "0" + startingDate;
	};
    var endingDate = $('#until1').val();
	if (isNaN(endingDate.substring(11, 2) < 10)) {
		endingDate = "0" + endingDate;
};
	var weekDaySelected = $('#weekdays option').filter(function() {
				return this.value == val;
	}).data('value');

    while (currentDate <= stopDate) {
	
		if(weekDaySelected==7) weekDaySelected=0;
		 if(weekDaySelected	== new Date(moment(currentDate).format('YYYY-MM-DD')).getDay() ){

            var obj = {
			start : moment(currentDate).format('YYYY-MM-DD')+" "+startingDate+":00",
			end : moment(currentDate).format('YYYY-MM-DD')+" "+endingDate+":00"};
			dateArray.push( obj );
      	 };
		 currentDate = moment(currentDate).add(1, 'days');
	
    }

    return dateArray;
	}
	


    $( "#checkForConflicts" ).click(function() {
		var startingDate = $('#periodStart').val();
    	var startingDateConverted = moment(startingDate, "DD.MM.YYYY").format("YYYY-MM-DD");
		var endingDate = $('#periodEnd').val();
    	var endingDateConverted = moment(endingDate, "DD.MM.YYYY").format("YYYY-MM-DD");
	
	
	

//see on vaja konfliktide kontrollimiseks.

$.ajax({
	url: "<?php echo base_url(); ?>edit/loadAllRoomBookingTimes/<?php echo $this->uri->segment(3); ?>",
	dataType: 'json',
	success: function(json) {
		// Rates are in `json.rates`
		// Base currency (USD) is `json.base`
		// UNIX Timestamp when rates were collected is in `json.timestamp`   

		conflicts = json;
     
     //   console.log(dateArray);
	 var canSubmit=true;
	

		(getDates(startingDateConverted, endingDateConverted)).forEach(function(element){
		
			if(isOverlapping(element, conflicts)){
			$('#approvePeriodNow').prop('checked', false);

			canSubmit=false;
			console.log($('#approvePeriodNow'));
			}
		
		});
		//kui konflikte pole, siis salvesta
		if(canSubmit==true){
	
		
			$( "#myPeriodicForm" ).submit();
		};
		
	},
	error: function(jqXHR, textStatus, errorThrown) {
		//Error handling code
		console.log(errorThrown);
		alert('Oops there was an error');
	}
});

$( "#submitWithConflicts" ).click(function() {
  $( "#myPeriodicForm" ).submit();
});






	});

	
});
</script>
