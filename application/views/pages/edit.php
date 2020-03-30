<div class="container">

	<div id="forms" class="container-md pb-5">
		<div id="nav-tabs" class="mt-5 pb-5 form-bg">
			<div class="d-flex mb-5">
				<ul class="nav nav-tabs nav-justified col-12 bg-grey">

				<?php if ($_POST['isPeriodic'] == 0):?>	
				<li class="nav-item"><a class="nav-link link txt-lg single-tab active" href="#mitmekordne" data-toggle="tab">Broneeringu muudatus</a></li>
			
				<?php endif;?>
				<?php if ($_POST['isPeriodic'] == 1):?>
				
					<li class="nav-item"><a class="nav-link link txt-lg  active" href="#hooajaline" data-toggle="tab">Hooajaline broneeringu muutmine</a></li>
					<?php endif;?>
					<li class="nav-item"></li>
				</ul>
			</div>

			<div class="tab-content ">
		
				<div id="mitmekordne" class="tab-pane center <?php if ($_POST['isPeriodic'] == 0) echo "active";?>">
					<form id="change" method="post" action="<?php echo base_url(); ?>edit/update">
						<h4 class="pt-2 txt-xl px-5 mx-5">Kontakt</h4>
						<div class="d-flex p-0 mt-4 px-5 mx-5">
							<div class="form-label-group col-6 py-0 pl-0 pr-5">
								<label for="contact">Klubi nimi (avalik info)*</label>
								<input type="text" class="form-control" name="publicInfo" value="<?php echo $bookingData['public_info'];?>" id="publicInfo" required>
							</div>
							<input class="d-none" type="checkbox" id="type" name="type" value="1" checked>
							<div class="form-label-group col-6 p-0 pl-5">
								<label>Kontaktisik</label>
								<input type="text" class="form-control" name="contactPerson" id="contactPerson" value="<?php echo $bookingData['c_name'];?>">
							</div>
						</div>
						<div class="d-flex mt-2 px-5 mx-5">
							<div class="form-label-group col-6 py-0 pl-0 pr-5">
								<label>Telefoni number</label>
								<input type="number" class="form-control" name="phone" id="phone" value="<?php echo $bookingData['c_phone'];?>">
							</div>

							<div class="form-label-group col-6 p-0 pl-5">
								<label>Email</label>
								<input type="email" class="form-control" name="email" id="email" value="<?php echo $bookingData['c_email'];?>">
							</div>
						</div>

						<h4 class="mt-5 txt-xl px-5 mx-5">Sündmus / Asukoht ja treeningu tüüp</h4>
						<div class="d-flex mt-4 px-5 mx-5">
							<div class="form-label-group col-6 py-0 pl-0 pr-5">
								<label for="sport_facility">Asutus</label>
								<input id="sport_facility" class="form-control" list="asutus" disabled value="">
								<!-- <datalist id="asutus">
                            <?php //foreach ($buildings as $each) {
							// echo '<option data-value="' . $each->id . '" value="' . $each->name . '"></option>';
							//}
							?>
                            </datalist> -->
							</div>

							<div class="form-label-group col-6 p-0 pl-5">
								<label for="room">Ruum</label>
								<input type="text" class="form-control" name="selectedroom" id="selectedroom" value="" disabled>
							</div>
						</div>

						<div class="d-flex mt-2 px-5 mx-5">
							<div class="form-label-group col-6 py-0 pl-0 pr-5">
								<label>Sündmus / Treeningu tüüp (avalik info)</label>
								<input type="text" class="form-control" name="workoutType" id="workoutType" value="<?php echo $bookingData['workout'];?>">
							</div>
							<div class="form-label-group col-6 p-0 pl-5"></div>
						</div>

						<h4 class="mt-5 txt-xl px-5 mx-5">Kuupäev ja kellaaeg</h4>
						<div class="mt-3 px-5 mx-5">
							<div class="form-label-group pb-2 px-0">
								<table id="myTable" class="table table-borderless">
									<thead>
										<tr>
											<th class="txt-regular txt-lg p-0" colspan="2">Broneeritud aeg</th>
											<th class="txt-regular txt-lg p-0">Uus aeg</th>
											<th class="p-0"></th>
											<th class="p-0"></th>
											<th class="p-0"></th>
										</tr>
									</thead>
									<tbody>
										<tr class="bg-blue mb-5">
											<td id="month" class="text-white txt-regular td-width-l p-1">Kuupäev</td>
											<td id="blank" class="text-white txt-regular td-width-m p-1">Vahemik</td>
											<td id="kp" class="text-white txt-regular td-width-s p-1 pl-3">Kuupäev</td>
											<td id="alates" class="text-white txt-regular td-width-s p-1 pl-3">Alates</td>
											<td id="kuni" class="text-white txt-regular td-width-s p-1 pl-3">Kuni</td>
											<td id="color" class="text-white txt-regular td-width-s p-1 pl-3">Värv</td>
										</tr><br />
										<!-- Genereerib automaatselt -->
									</tbody>
								</table>
								<!-- <div class="d-flex col-5 p-0">
                            <a id="addTimes" class="btn btn-custom text-white text-center py-2 px-4 pluss"><p class="m-0 px-0 txt-lg text-center align-items-center">Lisa veel üks kuupäev</p></a>
                        </div> -->

							</div>
						</div>

						

						<h4 class="mt-4 txt-xl px-5 mx-5">Lisainfo (valikuline) </h4>
						<div class="mt-4 px-5 mx-5">
							<div class="form-label-group pb-2 px-0">
								<label>Lisainfo</label>
								<textarea class="form-control" id="additional" name="additionalComment" rows="3"><?php echo $bookingData['comment'];?></textarea>
							</br>
								<label>Muutmise põhjus</label>
								<input class="form-control" id="reason" name="reason" rows="3"></input>
							</div>
						</div>
						<input class="d-none" type="hidden" name="BookingID" id="BookingID" value="<?php echo $_POST['BookingID']; ?>">
						<input class="d-none" type="hidden" name="isPeriodic" id="isPeriodic" value="<?php echo $_POST['isPeriodic']; ?>">
						<input class="d-none" type="hidden" name="roomID" id="roomID" value="<?php echo $bookingData['roomID'];?>"> 

						<div class="d-flex justify-content-end mt-5 px-5 mx-5">
							<a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="#" onClick="history.go(-1); return false;">Katkesta</a>
							<input type="submit" id="changeTimes" class="btn btn-custom col-4 text-white txt-xl" value="Salvesta muudatused">
						</div>

					</form>
				</div>

				 <div id="hooajaline" class="tab-pane center  <?php if ($_POST['isPeriodic'] == 1) echo "active";?>">
					<form id="changePeriod" method="post" action="<?php echo base_url(); ?>edit/updatePeriod">
						<h4 class="pt-2 txt-xl px-5 mx-5">Kontakt</h4>
						<div class="d-flex p-0 mt-4 px-5 mx-5">
							<div class="form-label-group col-6 py-0 pl-0 pr-5">
								<label for="contact">Klubi nimi (avalik info)* <?php if($this->session->flashdata('validationErrorMessageForClubname')){  echo $this->session->flashdata('validationErrorMessageForClubname');} ?></label>	
								<input type="text" class="form-control" name="publicInfoPeriod" value="<?php echo $bookingData['public_info'];?>" id="publicInfoPeriod" required>
							</div>
							<input class="d-none" type="checkbox" id="type" name="type" value="1" checked>
							<div class="form-label-group col-6 p-0 pl-5">
								<label>Kontaktisik <?php if($this->session->flashdata('validationErrorMessageContactPerson')){  echo $this->session->flashdata('validationErrorMessageContactPerson');} ?> </label>
								<input type="text" class="form-control" name="contactPersonPeriod" id="contactPersonPeriod"  value="<?php if(!empty($allPostData['contactPersonPeriod'])){echo $allPostData['contactPersonPeriod'];}else {echo $bookingData['c_name'];}?>">
							</div>
						</div>
						<div class="d-flex mt-2 px-5 mx-5">
							<div class="form-label-group col-6 py-0 pl-0 pr-5">
								<label>Telefon <?php if($this->session->flashdata('phoneIsNotCorrect')){  echo $this->session->flashdata('phoneIsNotCorrect');} ?></label>
								<input type="number" class="form-control" name="phonePeriod" id="phonePeriod" value="<?php echo $bookingData['c_phone'];?>">
							</div>

							<div class="form-label-group col-6 p-0 pl-5">
								<label>Email  <?php if($this->session->flashdata('emailIsNotCorrect')){  echo $this->session->flashdata('emailIsNotCorrect');} ?></label>
								<input type="email" class="form-control" name="emailPeriod" id="emailPeriod" value="<?php echo $bookingData['c_email'];?>">
							</div>
						</div>

						<h4 class="mt-5 txt-xl px-5 mx-5">Sündmus / Asukoht ja treeningu tüüp</h4>
						<div class="d-flex mt-4 px-5 mx-5">
							<div class="form-label-group col-6 py-0 pl-0 pr-5">
								<label for="sport_facilityPeriod">Asutus</label>
								<input id="sport_facilityPeriod" class="form-control" list="asutus" disabled value="">
								<!-- <datalist id="asutus">
                            <?php //foreach ($buildings as $each) {
							// echo '<option data-value="' . $each->id . '" value="' . $each->name . '"></option>';
							//}
							?>
                            </datalist> -->
							</div>

							<div class="form-label-group col-6 p-0 pl-5">
								<label for="room">Ruum</label>
								<input type="text" class="form-control" name="selectedroomPeriod" id="selectedroomPeriod" value="" disabled>
							</div>
						</div>

						<div class="d-flex mt-2 px-5 mx-5">
							<div class="form-label-group col-6 py-0 pl-0 pr-5">
								<label>Sündmus / Treeningu tüüp (avalik info)</label>
								<input type="text" class="form-control" name="workoutTypePeriod" id="workoutTypePeriod" value="<?php echo $bookingData['workout'];?>">
							</div>
							<div class="form-label-group col-6 p-0 pl-5"></div>
						</div>

						<h4 class="mt-5 txt-xl px-5 mx-5">Nädalapäev ja kellaaeg</h4>
						<div class="mt-4 bg-grey py-2">
                            <div class="form-label-group px-5 mx-5"  id="InputsWrapper1">
                                <div class="d-flex justify-content-between m-0 px-0 pt-0 pb-1">
                                    <label class="col-5 m-0 p-0" for="sport_facility2">Nädalapäev</label>
                                    <label class="d-hidden col-1 mr-1 p-0"></label>
                                    <label class="col-2 m-0 pl-3" for="from1">Alates</label>
									<label class="col-2 m-0 p-0" for="until1">Kuni</label>
									<label class="col-2 m-0 p-0" for="color">Värv</label>
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

                                     

                                        <div class="col-2 ml-5">
                                            <input type="text" class="clock form-control" name="timesStart" data-minimum="08:00" data-maximum="22:00" id="from1" value="">
                                        </div>

                                        <div class="col-2 ">
                                            <input type="text" class="clock form-control" name="timeTo" data-minimum="08:00" data-maximum="22:00" id="until1" value="">
										</div> 
										<div class="col-2">
                                            <input type="color" id="periodWorkoutColor" class="form-control" name="color" value="#ffffff" >
										</div>                                  
                                    </div>
                                </div>

                             
                            </div>
                        </div>

					
						<div class="mt-3 px-5 mx-5">
							<div class="form-label-group pb-2 px-0">
								<table id="myTablePeriod" class="table table-borderless">
									<thead>
										<tr>
											<th colspan="4" class="txt-regular txt-lg p-0">Korraga muudetakse kõiki alljärgnevaid aegu ja värve</th>
										
								
											<th class="p-0"></th>
											<th class="p-0"></th>
										</tr>
									</thead>
									<tbody>
										<tr class="bg-blue mb-5">
											<td id="month" class="text-white txt-regular td-width-l p-1">Kuupäev</td>
											<td id="blank" class="text-white txt-regular td-width-m p-1">Aeg</td>
											<td id="blank" class="text-white txt-regular td-width-m p-1">Värv</td>
											<td id="blank" colspan=3 class="text-white txt-regular td-width-m p-1"></td>
										
										</tr><br />
										<!-- Genereerib automaatselt -->
									</tbody>
								</table>
								<!-- <div class="d-flex col-5 p-0">
                            <a id="addTimes" class="btn btn-custom text-white text-center py-2 px-4 pluss"><p class="m-0 px-0 txt-lg text-center align-items-center">Lisa veel üks kuupäev</p></a>
                        </div> -->

							</div>
						</div>


						<h4 class="mt-4 txt-xl px-5 mx-5">Lisainfo (valikuline) </h4>
						<div class="mt-4 px-5 mx-5">
							<div class="form-label-group pb-2 px-0">
								<label>Lisainfo</label>
								<textarea class="form-control" id="additionalPeriod" name="additionalCommentPeriod" rows="3"><?php echo $bookingData['comment'];?></textarea>
								</br>
								<label>Muutmise põhjus</label>
								<input class="form-control" id="reason" name="reason" rows="3"></input>
							</div>
						</div>
						
						<input class="d-none" type="hidden" name="weekendNumber" id="weekendNumber" value="">
						<input class="d-none" type="hidden" name="BookingID" id="BookingID" value="<?php echo $_POST['BookingID']; ?>">
						<input class="d-none" type="hidden" name="isPeriodic" id="isPeriodic" value="<?php echo $_POST['isPeriodic']; ?>">
						<input class="d-none" type="hidden" name="roomID" id="roomIDPeriodic" value="<?php echo $bookingData['roomID'];?>">

						<div class="d-flex justify-content-end mt-5 px-5 mx-5">
							<a class="txt-xl link-deco align-self-center py-0 pr-5 mr-2" href="#" onClick="history.go(-1); return false;">Katkesta</a>
							<input type="submit" id="changePeriodTimes" class="btn btn-custom col-4 text-white txt-xl" value="Salvesta muudatused">
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $arr2 = array();
foreach ($_POST['timesIdArray'] as $key => $value) {
	$arr2[] = $value;
}; ?>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker.js"></script>
<script>
	$(document).ready(function() {
		var isPeriodic = '<?= $_POST['isPeriodic']; ?>';
		$('input[id=sport_facility2]').focusin(function() {
            $('input[id=sport_facility2]').val('');           
        });

		var FieldCount = $('#myTable tbody tr').length;
		FieldCount++;
		//  console.log(FieldCount);

		$('#addTimes').click(function(e) {
			//max input box allowed
			FieldCount++;
			//add input box
			$('#myTable > tbody').append('<tr> <td class="td-width-l"></td><td class="td-width-m"><span class="removeclass col-1 pl-1 pr-5"><span class="icon-cancel"></span></span></td><td class="td-width-s pl-3"><input class="datePicker form-control p" id="date_' + FieldCount + '" data-toggle="datepicker" name="additionalBookingDate[]"  value="<?php echo date("d.m.Y");?>"></td><td class="td-width-s pl-3"><input type="text" class="clock form-control" name="additionalBookingtimeStart[]" data-minimum="08:00" data-maximum="22:00" id="timestartfield_' + FieldCount + '"value="<?php echo date("H:i"); ?>"></td>  <td class="td-width-s pl-3"><input type="text" class="clock form-control" name="additionalBookingtimeEnd[]" data-minimum="08:00" data-maximum="22:00" id="timeendfield_' + FieldCount + '"value="<?php echo date("H:i", strtotime('+90 minutes')); ?>"></td></tr>');
			var once = false;
			$('.datePicker, .clock').focusin(function() {
				if (once == false) {
					$(".datePicker").datepicker({
						language: "et-EE",
						autoHide: true,
						date: new Date(),
						autoPick: true
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
				}
				once = true;
			});


		});
		$(document).on('click', '.removeclass', function(e) {


			$(this).parent().parent().remove(); //remove text box
		});




		var today = new Date();
		var endOfPeriond = new Date('05/31/' + new Date().getFullYear());

		var dateToShow = '';
		if (today < endOfPeriond) {
			dateToShow = endOfPeriond;

		} else {
			dateToShow = new Date(endOfPeriond.setFullYear(endOfPeriond.getFullYear() + 1));;
		};




		//   var eventToModificate = "<?php echo base_url(); ?>edit/load2/<?php echo $_POST['BookingID']; ?>";
		var resConflicts = [];
		var res2Conflicts = [];
		var ConflictID = [];
		var publicInfo = [];
		var counter = 0;

		// var urltoload =  "<?php echo base_url(); ?>fullcalendar/load/1";
		// console.log(urltoload+" konfliktid");
		var datafrom = ['<?= implode("', '", $arr2) ?>'];


		$.post("<?php echo base_url(); ?>edit/load2/<?php echo $allPostData['BookingID']; ?>",
			function(data) {
				var res = $.parseJSON(data);
				console.log(res);
			
				
				var days = ['P', 'E', 'T', 'K', 'N', 'R', 'L'];
				var weekDays= ['Pühapäev', 'Esmaspäev', 'Teisipäev', 'Kolmapäev', 'Neljapäev', 'Reede', 'Laupäev'];
				var conflicts = "";



				function isBetween(checkDateTime, startDateTime, endDateTime) {

					return (checkDateTime >= startDateTime && checkDateTime <= endDateTime);

				}

				function toDate(str) {

					var [yyyy, MM, dd, hh, mm] = str.split(/[- :]/g);
					return new Date(`${MM}/${dd}/${yyyy} ${hh}:${mm}`);
				};




				//   console.log(datafrom);
				for (var i = 0, l = res.length; i < l; i++) {
					var obj = res[i];
					// console.log(obj);
					//console.log(obj.start);


					//  $('#lefty').modal('show');
					//  $("#lefty .modal-header h4").text(obj.title);
					//  $("#lefty #time").text(obj.created_at);

				
				//	$('#publicInfo').val(obj.title);
			//		$('#publicInfoPeriod').val(obj.title);
					
				//	$('#contactPerson').val(obj.clubname);
				//	$('#contactPersonPeriod').val(obj.clubname);
				//	$('#organizer').val(obj.organizer);
				//	$('#organizerPeriod').val(obj.organizer);
					// if ($('#eventIn').is(':empty')){
					// $('#eventIn').val('Pole hooajaline broneering');}
					// else{
					//     $('#eventIn').val(moment(obj.event_in).format('DD/MM/YYYY HH:mm'));
					// }
					// if ($('#eventOut').is(':empty')){
					// $('#eventOut').val('Pole hooajaline broneering');}
					// else{
					//     $('#eventOut').val(moment(obj.event_out).format('DD/MM/YYYY HH:mm'));
					// }
				//	$('#phone').val(obj.phone);
				//	$('#phonePeriod').val(obj.phone);
				//	$('#additional').val(obj.comment);
				//	$('#additionalPeriod').val(obj.comment);

				//	$('#email').val(obj.email);
				//	$('#emailPeriod').val(obj.email);
					
				//	$('#created_at').val(obj.created_at);
				//	$('#workoutType').val(obj.workout);
				//	$('#workoutTypePeriod').val(obj.workout);
					$('#selectedroom').val(obj.roomName);
					$('#selectedroomPeriod').val(obj.roomName);
				//	document.getElementById("selectedroom").value = obj.roomName;
					//     document.getElementById("building").value = obj.roomName;
					$('#sport_facility').val(obj.building);
					$('#sport_facilityPeriod').val(obj.building);
				
				
					
				
				
					// 	if(weekDays.includes(	weekDays[new Date(start).getDay()])){
					// 	var list = document.getElementsByClassName("form-control col-5 arrow");
					// 		for (var i = 0; i < list.length; i++) {
					// 		list[i].setAttribute("value", 	weekDays[new Date(start).getDay()]);
					// 		}
					// };

					for (var property in obj) {
						//console.log(property + "=" + obj[property]);
					

					};
				//	document.getElementById("roomID").value = obj.roomID;
				//	document.getElementById("roomIDPeriodic").value = obj.roomID;
					// $('#start').val(obj.start);
					// $('#timestartfield').val(obj.start);
					//   $('#building').val(obj.building);

				
					//  $('#selectedroom').val(obj.roomID)

					var BTimesid = obj.timeID;

					var start = obj.start;
					var end = obj.end;
					//   console.log(start+' '+end);

					var eventColor=obj.color;
					console.log(eventColor);
					if(!eventColor){
						eventColor='#ffffff';
					}
				
				

					var n = datafrom.includes(BTimesid);
					

					//    console.log(BTimesid);
					if(isPeriodic==1){
						if(n){
							var weekDayToChange=new Date(obj.start).getDay();
							var startPeriodTime=moment(start).format("HH:mm");
							var endPeriodTime=moment(end).format("HH:mm");
							$('#sport_facility2').val(weekDays[weekDayToChange]);
							$('#weekendNumber').val(weekDayToChange);
							
							$('#from1').val(startPeriodTime);
							$('#until1').val(endPeriodTime);
							$('#periodWorkoutColor').val(eventColor);
							
					
						};
						if(weekDayToChange==new Date(obj.start).getDay()){
						
							//kui ajad klapivad, siis pane muutmisvaatesse
							if(startPeriodTime==moment(start).format("HH:mm")&&endPeriodTime==moment(end).format("HH:mm")){
							console.log("aeg klapib");

							$('#myTablePeriod > tbody').append(' <tr id="' + BTimesid + '"> <td class="td-width-l"><b>' + days[new Date(start).getDay()] + '</b>,&nbsp;' + moment(start).format("DD.MM.YYYY") + '</td><td class="td-width-s pl-3">&nbsp;&nbsp;' + moment(start).format("HH:mm") + '&#8209;' + moment(end).format("HH:mm") + '</td>'+
							'<td class="td-width-m"> <input type="color" id="periodWorkoutColor"  name="color" value="' + eventColor + '" disabled ></td><td class="td-width-s pl-3"></td><td class="td-width-s pl-3"><input class="d-none" type="hidden" name="timesIdArray[]"  value="' +BTimesid +'"></td>  <td class="td-width-s pl-3" >	<input class="d-none" type="hidden" name="bookingtimesFrom[' + counter + ']"  value="' + moment(start).format("DD.MM.YYYY") +'"></td></tr>');
								resConflicts.push(start.replace('T', ' ').substring(0, 16));
								res2Conflicts.push(end.replace('T', ' ').substring(0, 16));
								ConflictID.push(obj.timeID);
								publicInfo.push(obj.title);
								counter++;

							}
							//siia tuleb panna seda, millised päevade mustrid ei kattu
							else{
								
						
							}



						}

					
					}
					else if (n) {
						//     console.log(i);
						$('#myTable > tbody').append(' <tr id="' + BTimesid + '"> <td class="td-width-l"><b>' + days[new Date(start).getDay()] + '</b>,&nbsp;' + moment(start).format("DD.MM.YYYY") + '</td><td class="td-width-m">&nbsp;&nbsp;' + moment(start).format("HH:mm") + '&#8209;' + moment(end).format("HH:mm") + '</td><td class="td-width-s pl-3"><input class="datePicker form-control p" id="time_' + BTimesid + '" data-toggle="datepicker" name="bookingtimesFrom[' + counter + ']"  value="' + moment(start).format("DD.MM.YYYY") + '"></td><td class="td-width-s pl-3"><input type="text" class="clock form-control" name="timeStart[]" data-minimum="08:00" data-maximum="22:00" id="timestartfield' + i + '" value="' + moment(start).format("HH:mm") + '"></td>  <td class="td-width-s pl-3"><input type="text" class="clock form-control" name="timeEnd[]" data-minimum="08:00" data-maximum="22:00" id="timeendfield_' + i + '" value="' + moment(end).format("HH:mm") + '"></td><td class="pl-3"><input name="color[]" type="color" class="form-control" value="'+eventColor+'"></td></tr>'); 
						resConflicts.push(start.replace('T', ' ').substring(0, 16));
						res2Conflicts.push(end.replace('T', ' ').substring(0, 16));
						ConflictID.push(obj.timeID);
						publicInfo.push(obj.title);
						counter++;

					}


				}


				var conflictTimes=<?php echo $conflictTimes; ?>


				conflicts = conflictTimes;

				for (var i = 0, l = conflicts.length; i < l; i++) {
					var conflicts2 = conflicts[i];
					// console.log(conflicts2.start+" - "+conflicts2.end + " "+ i);

					var startDateTime = toDate(conflicts2.start.substring(0, 16)); //yyyy-mm-dd hh:tt
					var endDateTime = toDate(conflicts2.end.substring(0, 16));
					var timeIDofConflict = conflicts2.timeID;
					var titleIDofConflict = conflicts2.title;


					
				//	console.log(roomID);
					//   console.log(timeIDofConflict); 

					// iga selle aja kohta tuleb kontrollida ajaxi aega"
					for (var t = 0; t < resConflicts.length; t++) {

						var checkDateTime = toDate(resConflicts[t]); //magic date
						var checkDateTime2 = toDate(res2Conflicts[t]); //magic date

						if (ConflictID[t] !== timeIDofConflict) {
							if (isBetween(startDateTime, checkDateTime, checkDateTime2) || isBetween(endDateTime, checkDateTime, checkDateTime2) || isBetween(checkDateTime, startDateTime, endDateTime) || isBetween(checkDateTime2, startDateTime, endDateTime)) {
								//   console.log(checkDateTime +" - "+ checkDateTime2 + " nende vastu "+ startDateTime+ " " +endDateTime);// 
								//   console.log("tingumus on täidetud " + resConflicts[t] + " või "+res2Conflicts[t]);
								$('#myTable #' + ConflictID[t]).after("<tr class='m-0 p-0'><td colspan='5' class='conflict txt-regular'><img src='<?php echo base_url(); ?>assets/img/warning.svg'> Kattuv aeg: " + moment(conflicts2.start).format('HH:mm') /*conflicts2.start.substring(0, 16) */ + "–" + moment(conflicts2.end).format('HH:mm') + " " /*conflicts2.end.substring(0, 16)*/ + titleIDofConflict + "</td></tr>");
								//   console.log( ConflictID[t] +" ning " +timeIDofConflict);
								$('#myTablePeriod #' + ConflictID[t]).after("<tr class='m-0 p-0'><td colspan='5' class='conflict txt-regular'><img src='<?php echo base_url(); ?>assets/img/warning.svg'> Kattuv aeg: " + moment(conflicts[i].start).format('HH:mm') /*conflicts2.start.substring(0, 16) */ + "–" + moment(conflicts[i].end).format('HH:mm') + " " /*conflicts2.end.substring(0, 16)*/ + conflicts[i].title + "</td></tr>");
						
								$('#myTable #' + ConflictID[t]).find('.clock.form-control, .datePicker.form-control').css('border', '1px solid #9E3253')

							}
						}

					
					};


				}


				var once = false;
				$('.datePicker, .clock').focusin(function() {
					if (once == false) {
						$(".datePicker").datepicker({
							language: "et-EE",
							autoHide: true,
							date: new Date(),
							autoPick: false
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
					}
					once = true;

				});


				//alert(res.values());
				//  console.log(Object.prototype.toString.call(res));
			});



		$("#changeTimes").on('click', function(event) {
			var bookingID = '<?= $_POST['BookingID'] ?>';
			console.log(bookingID);
			var datafrom = ['<?= implode("', '", $arr2) ?>'];
			var myForm = document.getElementById('change');

			datafrom.forEach(function(value) {
				var hiddenInput = document.createElement('input');

				hiddenInput.type = 'hidden';
				hiddenInput.name = 'timesIdArray[]';
				hiddenInput.value = value;

				myForm.appendChild(hiddenInput);
			});

			var hiddenInput = document.createElement('input');
			hiddenInput.type = 'hidden';
			hiddenInput.name = 'BookingID';
			hiddenInput.value = bookingID;
			myForm.appendChild(hiddenInput);
			$("#changeTimes").on('click', function(event) {

				$('#change').submit();


			});

		});


		$("#changePeriodTimes").on('click', function(event) {
			var bookingID = '<?= $_POST['BookingID'] ?>';
			console.log(bookingID);
		
			var myForm = document.getElementById('changePeriod');
			var hiddenInput = document.createElement('input');
			hiddenInput.type = 'hidden';
			hiddenInput.name = 'BookingID';
			hiddenInput.value = bookingID;
			myForm.appendChild(hiddenInput);
			$("#changeTimes").on('click', function(event) {

			//	$('#change').submit();


			});

		});




	});

	$(".nav a").on("click", function() { // TAB'i active klassi toggle
        $(".nav a").removeClass("active");
        $(this).addClass("active");
	});
	
</script>
