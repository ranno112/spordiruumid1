<div class="container">




	<div class="d-flex pt-4" id="widthToggle">
		<form class="d-flex flex-row col-md-11 col-lg-10 p-0" action="fullcalendar" method="get">

			<?php if ($this->session->userdata('roleID') != '2' && $this->session->userdata('roleID') != '3') : ?>
				<div class="form-label-group col-md-3 col-lg-2 p-0 mr-2">

					<label for="region">Piirkond</label>
					<input id="region" list="regions" class="form-control arrow" type="text" value="<?php echo $rooms['regionName']; ?>">
					<datalist id="regions">
						<?php foreach ($regions as $row) {
							echo '<option  data-value="' . $row->regionID . '" value="' . $row->regionName . '"></option>';
						}
						?>
					</datalist>
					<input type="hidden" id="roomId" name="roomId" value="roomId" />
				</div>

				<div class="form-label-group col-md-3 col-lg-2 p-0 mr-2">
					<label for="sport_facility">Asutus</label>
					<input id="sport_facility" list="asutus" class="form-control arrow" value="<?php echo $rooms['name']; ?> ">
					<datalist id="asutus">
						<?php foreach ($sportPlaces as $each) {
							if ($rooms['regionID'] == $each->regionID) {
								echo '<option data-value="' . $each->id . '" value="' . $each->name . '"></option>';
							}
						}
						?>
					</datalist>
					<input type="hidden" id="roomId" name="roomId" value="roomId" />
				</div>
			<?php endif; ?>


			<div class="form-label-group col-md-3 col-lg-2 p-0 mr-2">
				<label for="room">Ruum</label>
				<input id="room" list="saal" class="form-control arrow" value="<?php echo $rooms['roomName']; ?>">
				<datalist id="saal">
					<?php foreach ($sportPlacesToChoose as $each) {
						if ($this->session->userdata('roleID') == '2' or $this->session->userdata('roleID') == '3') {
							if ($this->session->userdata('building') == $each->buildingID) {
								echo '<option data-value="' . $each->id . '" value="' . $each->roomName . '"></option>';
							}
						} elseif ($rooms['id'] == $each->buildingID) {
							echo '<option data-value="' . $each->id . '" value="' . $each->roomName . '"></option>';
						}
					}
					?>
				</datalist>
				<input type="hidden" id="roomId" name="roomId" value="roomId" />
			</div>

			<div class="form-label-group col-2 p-0">
				<label for="datepicker">Kuupäev</label>
				<input id="datepicker" class="datePicker form-control" data-toggle="datepicker" name="date" autocomplete="off" />
			</div>
		</form>


		<?php if ($this->session->userdata('roleID') === '2' || $this->session->userdata('roleID') === '3') { ?>
			<div class="col-2 mr-auto p-0">
				<a class="btn btn-custom text-white text-center py-2 px-sm-2 px-lg-5 px-md-4 float-right pluss" href="<?php echo base_url(); ?>booking/create/<?php echo ($this->input->get('roomId')); ?>">
					<p class="m-0 txt-lg txt-strong text-center">Uus broneering</p>
				</a>
				<a id="allCalenderLink" class="text-center py-2 px-sm-2 px-lg-5 px-md-4 float-right pluss" href="<?php echo base_url(); ?>/allbookings/weekview/?date=">Kõik ruumid</a>
			<?php  } elseif ($this->session->userdata('session_id') === TRUE) { ?>
				<div class="col-2 mr-auto p-0">
					<a class="btn btn-custom text-white text-center py-2 px-sm-2 px-lg-5 px-md-4 float-right pluss" href="<?php echo base_url(); ?>booking/create/<?php echo ($this->input->get('roomId')); ?>">
						<p class="m-0 txt-lg txt-strong text-center">Esita päring</p>
					</a>
				<?php }; ?>

				<?php if (!$this->session->userdata('session_id')) { ?>
					<div class="col-2 p-0 bg-blue info-label text-white px-3 py-2">
						<p class="txt-strong">Broneerimiseks helista või kirjuta:</p>
						<p><?php echo $rooms['notify_email']; ?></p>
						<p><?php echo $rooms['phone']; ?></p>
					<?php }; ?>
					</div>


				</div>
				<!-- KALENDER CONTAINERIS START -->
				<div id="calendar-container">
					<div id='calendar'></div>
				</div>
				<br />

				<!-- KALENDER CONTAINERIS END -->
			</div>
			<!-- ****************** MODAL START ****************** -->

			<?php if ($this->session->userdata('roleID') === '2' || $this->session->userdata('roleID') === '3') : ?>
				<!-- Modal -->
				<div class="modal left" id="lefty" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">

							<div id="modal-header" class="modal-header d-flex justify-content-between pl-4 py-0 m-0 bg-grey border-bottom">
								<div>
									<h4 class="modal-title text-darkblue txt-xl m-0 py-3" id="myModalLabel">
										<input type="text" class="d-none" name="c_name" value="" id="c_name">
									</h4>
								</div>
								<div>
									<p class="modal-time text-darkblue txt-xl m-0 py-3"></p>
								</div>
								<div>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
							</div>



							<div class="modal-body m-0 p-0">
								<?php echo form_open(site_url("calendar/edit_event"), array("class" => "form-horizontal")) ?>
								<div class="d-flex pl-4 py-2 bg-grey border-bottom">
									<p class="pr-2 m-0 text-darkblue">Päring:</p>
									<p class="m-0 text-darkblue" id="time"></p>
									<input type="text" class="form-control d-none m-0" name="created_at" id="created_at">
								</div>
								<div class="accordion px-4">
									<div class="accordion-item">
										<a class="txt-xl text-darkblue active py-2">Broneeringu info</a>
										<div id="contact" class="content active p-0 m-0">
											<div class="remove">
												<p class="pt-2 txt-regular">Kontakt</p>
												<div class="d-flex justify-content-between p-0 m-0  remove">
													<div class="col-6 p-0 m-0">
														<p>Klubi nimi</p>
													</div>
													<div class="col-6 p-0 m-0">
														<p id="clubname"></p>
														<input type="text" class="d-none" name="clubname" id="clubname">
													</div>
												</div>
												<div class="d-flex justify-content-between p-0 m-0 remove">
													<div class="col-6 p-0 m-0">
														<p>Kontaktisik</p>
													</div>
													<div class="col-6 p-0 m-0">
														<p id="c_name"></p>
														<input type="text" class="d-none" name="c_name" id="c_name">
													</div>
												</div>
												<div class="d-flex justify-content-between p-0 m-0 remove">
													<div class="col-6 p-0 m-0">
														<p>Telefoni number</p>
													</div>
													<div class="col-6 p-0 m-0">
														<p id="phone"></p>
														<input type="text" class="d-none" name="phone" id="phone">
													</div>
												</div>
												<div class="d-flex justify-content-between remove">
													<div class="col-6 p-0 m-0">
														<p>Email</p>
													</div>
													<div class="col-6 p-0 m-0">
														<p id="email"></p>
														<input type="text" class="d-none" name="email" id="email">
													</div>
												</div>
											</div>

											<p id="saal" class="pt-3 txt-regular">Asukoht ja sündmus / treeningu tüüp</p>
											<div class="remove">
												<div class="d-flex justify-content-between remove2">
													<div class="col-6 p-0 m-0">
														<p>Asutus</p>
													</div>
													<div class="col-6 p-0 m-0">
														<p id="building"></p>
														<input type="text" class="d-none" name="building" id="building">
													</div>
												</div>
											</div>
											<div class="d-flex justify-content-between">
												<div class="col-6 p-0 m-0">
													<p>Ruum</p>
												</div>
												<div class="col-6 p-0 m-0">
													<p id="selectedroom"></p>
													<input type="text" class="d-none" name="selectedroom" id="selectedroom">
												</div>
											</div>
											<div class="remove">
												<div class="d-flex">
													<div class="col-6 p-0 m-0">
														<p>Sündmus / Treeningu tüüp</p>
													</div>
													<div class="col-6 p-0 m-0">
														<p id="workout"></p>
														<input type="text" class="d-none" name="workout" id="workout">
													</div>
												</div>
											</div>

											<div id="ajad">
												<p class="pt-3 txt-regular">Kuupäev ja kellaajad</p>
												<div class="d-flex justify-content-between">
													<div class="col-6 p-0 m-0">
														<p>Periood</p>
													</div>
													<div class="col-6 p-0 m-0 d-flex">
														<p id="event_in"></p>
														<input type="text" class="d-none" name="event_in" id="event_in">
														<p>–</p>
														<p id="event_out"></p>
														<input type="text" class="d-none" name="event_out" id="event_out">
													</div>
												</div>
											</div>

											<p id="info" class="pt-3 txt-regular">Lisainfo</p>
											<p id="comment" class="pb-4"></p>
											<input type="text" class="d-none" name="comment" id="comment">

										</div>
									</div>
								</div>

								<div class="accordion px-4">
									<div class="accordion-item">
										<a id="countNr" class="txt-xl text-darkblue active py-2">Kõik ajad</a>
										<div id="contact" class="content active p-0 m-0">
											<br>
											<label><input type="checkbox" name="selectAll" id="selectAll" value="1"><span></span></label> VALI KÕIK
											<hr>
											<table id="myTable">
												<tbody>
													<tr class="myTable"></tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<?php echo form_close() ?>
								<input type="hidden" name="eventid" id="event_id" value="0" />
							</div>

							<div class="modal-footer d-block m-0 py-2 text-center">

								<form id="approveCheck" class="m-0">

									<input type="submit" class="btn btn-custom text-white txt-strong btn-width-lg example1" value="Kinnita">
								</form>

								<form id="change" method="post" action="<?php echo base_url(); ?>edit/update" class="m-0 pt-2">
									<input type="hidden" id="dontShow" name="dontShow" value="1">
									<input type="hidden" id="BookingID" name="BookingID" value="">
									<input type="hidden" id="isPeriodic" name="isPeriodic" value="0">
									<input type="submit" id="changeTimes" class="btn btn-info text-white txt-strong btn-width-lg" value="Muuda valitud">
									<input type="submit" id="changePeriodTimes" class="btn btn-info text-white txt-strong btn-width-lg" value="Muuda hooajaliselt">
								</form>

								<form id="delete" class="m-0 pt-2">
									<input type="submit" class="btn btn-delete text-white txt-strong btn-width-lg" value="Kustuta" id="deleteChecked" name="deleteChecked">
								</form>

								<form id="takesPlaceCheck" class="m-0 pt-2">
									<input type="submit" class="btn btn-second text-white txt-strong btn-width-lg" value="Ei toimunud">
								</form>
							</div>






							<br> <br>
							<!-- </div> -->



						</div>
					</div>


				</div>
				
				
				<?php endif; ?>
			</div><!-- container -->
<!-- ****************** MODAL END ****************** -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker.js"></script>
<script>
	var counter = 0;
	$(document).ready(function() {
		var days = ['P', 'E', 'T', 'K', 'N', 'R', 'L'];
		var displayOrNot = '<?php echo $this->session->userdata('roleID') ?>';

		var monthNamesForModal = ['Jaanuar', 'Veebruar', 'Märts', 'Aprill', 'Mai', 'Juuni', 'Juuli', 'August', 'September', 'Oktoober', 'November', 'Detsember'];

		//lehe üleval pisike input kalender
		$(".datePicker").datepicker({
			language: "et-EE",
			autoHide: true,
			date: new Date(),
			autoPick: true
		});


		$("#selectAll").click(function() {
			var c = this.checked;
			$(':checkbox').prop('checked', c);
			$('#countNr').text('Kõik ajad (' +$('.abc:checked').length + '/'+ $('#myTable tr:has(td)').length + ')');
		});



		var calendar = $('#calendar').fullCalendar({
		
			header: {
				left: '',
				center: 'prev, title, next',
				right: ''
			},
			height: 'parent',
			// contentHeight: 600,
			// aspectRatio: 2.2,
			allDaySlot: false,
			firstDay: 1,

			dayNames: ['Pühapäev', 'Esmaspäev', 'Teisipäev', 'Kolmapäev', 'Neljapäev', 'Reede', 'Laupäev'],
			dayNamesShort: ['P', 'E', 'T', 'K', 'N', 'R', 'L'],
			monthNames: ['jaanuar', 'veebruar', 'märts', 'aprill', 'mai', 'juuni', 'juuli', 'august', 'september', 'oktoober', 'november', 'detsember'],
			monthNamesShort: ['jaan', 'veebr', 'märts', 'apr', 'mai', 'juuni', 'juuli', 'aug', 'sept', 'okt', 'nov', 'dets'],
			views: {
				week: { // name of view
					titleFormat: 'D. MMMM YYYY',
					columnFormat: "dddd, D. MMM"
					// other view-specific options here
				}

			},

			defaultView: 'agendaWeek',
			weekNumbers: true,
			slotLabelFormat: 'H:mm',
			timeFormat: 'H:mm',
			slotDuration: '00:30:00',
			minTime: '08:00:00',
			maxTime: '22:00:00',

			//contentHeight:"auto",

			rendering: 'background',
			eventSources: [

				// your event source
				{
					url: "<?php echo base_url(); ?>fullcalendar/load/<?php echo ($this->input->get('roomId')); ?>" // use the `url` property

					// rendering : 'background'
				},
			

			],
			selectable:  (displayOrNot == 2 || displayOrNot == 3) ? true:false,
			selectHelper: true,
			eventRender: function(event, element) {


				if (event.description) {
					element.find('.fc-title').prepend('<span style="font-weight:550">' + event.description + "<br/>" + '</span>');
				} else {
					element.find('.fc-title').prepend(event.description);

				}

				if ((displayOrNot == 2 || displayOrNot == 3) && (event.typeID == 1 || event.typeID == 2)) {
					element.find('.fc-time').before("<span class='timequery'>Päring: " + moment(event.created_at).format("DD.MM.YYYY HH:mm") + "</span>"); // Päringu kirje broneeringu lahtris
				}
				element.css('border-top', '1px solid #DDD');
				element.css('border-right', '1px solid #DDD');
				element.css('border-bottom', '1px solid #DDD');
				if (event.approved == true) {
					element.css('border', '1px solid #DDD');
					element.css('border-left', '7px solid #1A7AB7');

				} else {

					element.find('.fc-content').after('<span class="notice notice-error">Kinnitamata</span>');
					element.css({
						'background': 'repeating-linear-gradient(-45deg, rgba(255, 255, 255, 1), rgba(255, 255, 255, 1) 10px, rgba(245, 245, 245, 1) 10px, rgba(245, 245, 245, 1) 20px)'
					});
					if (isOverlapping(event)) {
						element.css('border-left', '7px solid lightsalmon');
						//  element.find('.fc-content').after('<span class="notice notice-error">Konflikt</span>')

					}

				}


				if (event.takesPlace == false) {
					element.find('.fc-content').after('<span class="notice notice-error">Ei toimunud</span>');
				}
				//kui on suletud
				if (event.typeID == 4) {
					element.find('.fc-time').addClass('d-none');
					element.find('.fc-title').text('Suletud');
					element.css({
						'background': 'repeating-linear-gradient(45deg, rgba(0, 0, 0, 0.05), rgba(0, 0, 0, 0.05) 55px, rgba(0, 0, 0, 0.07) 55px, rgba(0, 0, 0, 0.07) 110px)',
						'border-left': 'none'
					});
					element.find('.fc-content').css({
						'text-align': 'center'
					});
				}

			},

			select: function(start, end, allDay) {
				if ( (displayOrNot == 2 || displayOrNot == 3) ){
				var startDate = $.fullCalendar.formatDate(start, "DD.MM.YYYY");
				var start = $.fullCalendar.formatDate(start, "HH:mm");
				var end = $.fullCalendar.formatDate(end, "HH:mm");

				window.location.href = '<?php echo base_url(); ?>booking/create/<?php echo ($this->input->get('roomId')) . "?startDate="; ?>' + startDate + '&start=' + start + '&end=' + end;
			}
			

			},
			editable: (displayOrNot == 2 || displayOrNot == 3) ? true:false,
			eventResize: function(event) {
			
				calendar.fullCalendar('refetchEvents');
				alert("Muutsid hetkeks trenni aega, see läheb tagasi oma kohale peale OK nupule vajutamist");
			},
			eventDrop: function(event) {
				
				calendar.fullCalendar('refetchEvents');
				alert("Tõstsid korraks trenni eest ära, see läheb tagasi oma kohale peale OK nupule vajutamist");
			},
		

			eventClick: function(event) {
				counter = 0;
				$(':checkbox[name=selectAll]').prop('checked', false);

				// $("#successModal").modal("show");
				// $("#successModal .modal-body p").text(event.title);
				$('#myTable tbody').empty();
				$('#lefty').modal('show');
				$("#lefty .modal-header h4").text(event.title);
				$("#lefty .modal-header p").text(moment(event.start).format('DD.MM.YYYY'));
				$("#lefty #time").text(moment(event.created_at).format('DD.MM.YYYY HH:mm:ss'));
				//  $('.modal-dialog').draggable();
				$('#c_name').val(event.title);
				if (event.typeID == 4) {
					$('p#saal').text("Asukoht");
					$('.remove').each(function() {
						$(this).hide();
					});
				} else {
					$('.remove').each(function() {
						$(this).show();
					});
				}

				$('#clubname').val(event.title);
				$("#clubname").text(event.title);
				$("#c_name").text(event.clubname);
				$('#event_in').val(event.event_in);
				if (!$('#event_in').val()) {
					$("#ajad").addClass("d-none");
				} else {
					$("#ajad").removeClass("d-none");
					$("#contact #event_in").text(moment(event.event_in).format('DD.MM.YYYY'));
				}
				$('#event_out').val(event.event_out);
				if (!$('#event_out').val()) {
					$("#ajad").addClass("d-none");
				} else {
					$("#ajad").removeClass("d-none");
					$("#contact #event_out").text(moment(event.event_out).format('DD.MM.YYYY'));
				}
				// if ($('#event_out').is(':empty')){
				// $('#event_out').val('Pole hooajaline broneering');}
				// else{
				//     $('#event_out').val(moment(event.event_out).format('DD/MM/YYYY HH:mm'));
				// }
			
				var id = event.id;
			
				var events = $('#calendar').fullCalendar('clientEvents');
				$('tbody').attr('id', id);

				var eventToCheck=[];
				var startDateTime = [];
				var endDateTime = [];
				var arrayOfIDs = [];
				var arrayOfTitles = [];
				var monthCheckbox = '';

				for (var i = 0; i < events.length; i++) {
					var Bid = events[i].bookingID;
			
					if (events[i].start != null && events[i].end != null) {
						startDateTime.push(events[i].start._i.substring(0, 16));
						arrayOfIDs.push(events[i].timeID);
						endDateTime.push(events[i].end._i.substring(0, 16));
						arrayOfTitles.push(events[i].title);
						
					}
					if (event.id == Bid) {
						eventToCheck.push(events[i]);

					}
					
				}
			
		
				for ( i = 0; i < eventToCheck.length; i++) {
					
				var approved = eventToCheck[i].approved;
					if (approved == 1) {
						approved = "Kinnitatud";
					} else if (approved == 0) {
						approved = "Kinnitamata";
					}

				var takesPlace = eventToCheck[i].takesPlace;
					if (takesPlace == 1) {
						takesPlace = "";
					} else if (takesPlace == 0) {
						takesPlace = "XXX";
					}

				var nameOfWeek=days[moment(eventToCheck[i].start._i).day()];
				var start_date = new Date(eventToCheck[i].start._i);
				var st_monthIndex = start_date.getUTCMonth() + 1;

				if (monthCheckbox != st_monthIndex) {

				$('#myTable > tbody:last-child').append('<tr id="monthRow' + start_date.getUTCMonth() + '"><th><label><input type="checkbox"  id="selectMonth[' + start_date.getUTCMonth() + ']" value="1"></label> ' + monthNamesForModal[start_date.getUTCMonth()] + ' </th></tr>');
				}
				monthCheckbox = st_monthIndex;
				var isSelected=false;
				if (event.timeID == eventToCheck[i].timeID) {
					isSelected='checked';
				
				}
				else {
					isSelected='';	
				}

				$('#myTable > tbody:last-child').append(' <tr class="red' + i + '">  <td><label><input type="checkbox" class="abc brdr" name="choices" id="' + eventToCheck[i].timeID + '"'+isSelected+' ><span></span></label> ' +  nameOfWeek + ', ' + moment(eventToCheck[i].start._i).format('DD.MM.YYYY') + ' <br></td>  <td>&nbsp;&nbsp; ' + moment(eventToCheck[i].start._i).format('HH:mm') +  '-' + moment(eventToCheck[i].end._i).format('HH:mm') + '</td>   <td>&nbsp;&nbsp;&nbsp;' + approved + ' </td> <td>&nbsp;' + takesPlace + ' </td>   </tr>');
				
				var checkingConflicts=isOverlapping2(eventToCheck[i], events);
			
				if	(checkingConflicts){
					$(".red" + i).css("color", "red");
						if ($("table").find(".red" + i + ":first td").length < 5) {
							checkingConflicts.title.length > 10 ? checkingConflicts.title = checkingConflicts.title.substring(0, 10) + "...": checkingConflicts.title = checkingConflicts.title;
						
							$(".red" + i).append('<td> &nbsp;' + checkingConflicts.title + '</td>');
						}
					
					}

				}
				
				

				$('#phone').val(event.phone);
				$("#contact #phone").text(event.phone);
				$('#selectedroom').val(event.selectedroom);
				$('#email').val(event.email);
				$("#contact #email").text(event.email);
				$('#created_at').val(event.created_at);
				$('#workout').val(event.workout);
				$("#contact #workout").text(event.workout);

				$('#start').val(event.start);
				$('#building').val(event.building);
				$("#contact #building").text(event.building);
				$('#selectedroom').val(event.roomName);
				$("#contact #selectedroom").text(event.roomName);
				$('#comment').val(event.comment);
				$("#contact #comment").text(event.comment);
				$('#editModal').modal();



				$("input[id*='selectMonth']").each(function(i, el) {
					$(this).parent().parent().css("text-decoration", "underline");

				});


			}




		});

		$("#delete").submit(function(event) {
			if ($('.abc:checked').length == $('.abc').length) {
				if (confirm("Oled kindel kustutada KÕIK ajad?")) {
					event.preventDefault();
				} else {
					return false;
				}
				var id = $('input:checkbox:checked').parents("tbody").attr('id');
			
				$.ajax({
					url: "<?php echo base_url(); ?>fullcalendar/deleteAllConnectedBookings",
					type: "POST",
					data: {
						bookingID: id
					},
					success: function() {
						calendar.fullCalendar('refetchEvents');

						jQuery('input:checkbox:checked').parents("tr").remove();
						$("#lefty").modal("hide");
						$('#calendar-container').css({
							'margin-left': '0'
						});
						$('#widthToggle').css({
							'margin-left': '0'
						});
						//  alert('Event Removed');
					},
					error: function(returnval) {
						$(".message").text(returnval + " failure");
						$(".message").fadeIn("slow");
						$(".message").delay(2000).fadeOut(1000);
					}
				});



			} else if ($('.abc:checked').length < $('.abc').length && $('.abc:checked').length > 0) {
				if (confirm("Oled kindel, et soovid kustutada?" + $('.abc:checked'))) {
				
					event.preventDefault();
				} else {
					return false;
				}
				var countTimes=$('#myTable tr:has(td)').length-$('.abc:checked').length;
				$('#countNr').text('Kõik ajad (' +countTimes + ')');

				$("input:checkbox").each(function() {
					var $this = $(this);

					if ($this.is(":checked")) {
						var id = $this.attr("id");
					


						$.ajax({
							url: "<?php echo base_url(); ?>fullcalendar/delete",
							type: "POST",
							data: {
								timeID: id
							},
							success: function() {
							
								calendar.fullCalendar('refetchEvents');
								jQuery('input:checkbox:checked').parents("tr").remove();

							},
							error: function(returnval) {
								$(".message").text(returnval + " failure");
								$(".message").fadeIn("slow");
								$(".message").delay(2000).fadeOut(1000);
							}
						});
					}
				});
			} else {
				alert("Sa ei valinud midagi mida kustutada");
				event.preventDefault();
			}



		});


		$("#approveCheck").click(function(event) {
			if ($('.abc:checked').length <= $('.abc').length && $('.abc:checked').length > 0) {
				if (confirm("Kinnatan valitud?")) {
					event.preventDefault();
				} else {
					return false;
				}

				$("input:checkbox").each(function() {
					var $this = $(this);

					if ($this.is(":checked")) {
						var id = $this.attr("id");
					
						var approvedOrNot = $this.parents("tr").children("td:nth-child(3)");
					
						var approvedOrNotToDB;
						if ($.trim(approvedOrNot.text()) == "Kinnitatud") {
							approvedOrNotToDB = 0;
						} else {
							approvedOrNotToDB = 1;
						}



						$.ajax({
							url: "<?php echo base_url(); ?>fullcalendar/approveEvents",
							type: "POST",
							data: {
								timeID: id,
								approved: approvedOrNotToDB

							},
							success: function() {
								calendar.fullCalendar('refetchEvents');
								//siia tule teha panna kinnitatud olekuks modalis  
								if (approvedOrNotToDB == 1) {
									jQuery('input:checkbox:checked').parents("tr").children("td:nth-child(3)").html("&nbsp;&nbsp;&nbsp;Kinnitatud");
								} else {
									jQuery('input:checkbox:checked').parents("tr").children("td:nth-child(3)").html("&nbsp;&nbsp;&nbsp;Kinnitamata");
								}

								// alert('Kinnitatud');
							},
							error: function(returnval) {
								$(".message").text(returnval + " failure");
								$(".message").fadeIn("slow");
								$(".message").delay(2000).fadeOut(1000);
							}
						});
					}
				});
			} else {
				swal("Sa ei valinud midagi mida kinnitada");
				event.preventDefault();
			}



		});

		$("#takesPlaceCheck").submit(function(event) {
			if ($('.abc:checked').length <= $('.abc').length && $('.abc:checked').length > 0) {
				if (confirm("Valitud trennid ei toimunud?")) {
					event.preventDefault();
				} else {
					return false;
				}

				$("input:checkbox").each(function() {
					var $this = $(this);

					var approvedOrNot = $this.parents("tr").children("td:nth-child(4)");
				console.log(approvedOrNot.text());
					var approvedOrNotToDB;
					if ($.trim(approvedOrNot.text()) == "XXX") {
						approvedOrNotToDB = 1;
					} else {
						approvedOrNotToDB = 0;
					}

					if ($this.is(":checked")) {
						var id = $this.attr("id");
						$.ajax({
							url: "<?php echo base_url(); ?>fullcalendar/takesPlace",
							type: "POST",
							data: {
								timeID: id,
								takesPlace: approvedOrNotToDB

							},
							success: function() {
								calendar.fullCalendar('refetchEvents');
								if (approvedOrNotToDB == 0) {
									jQuery('input:checkbox:checked').parents("tr").children("td:nth-child(4)").html("&nbsp;Ei toimunud");
								} else {
									jQuery('input:checkbox:checked').parents("tr").children("td:nth-child(4)").html("&nbsp;&nbsp;&nbsp;");
								}
								//  $('input:checkbox:checked').parents("tr").children("td:contains('Ei toimunud')").html("");
								//alert('Ei toimunud');
							},
							error: function(returnval) {
								alert('Midagi läks valesti');
								$(".message").text(returnval + " failure");
								$(".message").fadeIn("slow");
								$(".message").delay(2000).fadeOut(1000);
							}
						});
					}
				});
			} else {
				alert("Sa ei märgistanud ühtegi ruutu");
				event.preventDefault();
			}



		});


		$("#changeTimes").on('click', function(event) {
			if ($('.abc:checked').length <= $('.abc').length && $('.abc:checked').length > 0) {
				var timesIdArray = [];
				var id = '';

				$("input:checkbox").each(function() {
					var $this = $(this);

					if ($this.is(":checked")) {
						id = $('input:checkbox:checked').parents("tbody").attr('id');
						var timesId = $this.attr("id");
						timesIdArray.push(timesId);
					}

				});
				var myForm = document.getElementById('change');
				timesIdArray.forEach(function(value) {
					if (!isNaN(value)) {
						var hiddenInput = document.createElement('input');
						hiddenInput.type = 'hidden';
						hiddenInput.name = 'timesIdArray[]';
						hiddenInput.value = value;

						myForm.appendChild(hiddenInput);
					}

				});
				document.getElementById("BookingID").value = id;
			
				$('#change').submit();


			} else {
				alert("Sa ei märgistanud ühtegi ruutu");
				event.preventDefault();
			}
		});
	
	

		$("#changePeriodTimes").on('click', function(event) {
			if ($('.abc:checked').length <2) {
				var timesIdArray = [];
				var id = '';

				$("input:checkbox").each(function() {
					var $this = $(this);

					if ($this.is(":checked")) {
						id = $('input:checkbox:checked').parents("tbody").attr('id');
						var timesId = $this.attr("id");
						timesIdArray.push(timesId);
					}

				});
				var myForm = document.getElementById('change');
				timesIdArray.forEach(function(value) {
					if (!isNaN(value)) {
						var hiddenInput = document.createElement('input');
						hiddenInput.type = 'hidden';
						hiddenInput.name = 'timesIdArray[]';
						hiddenInput.value = value;

						myForm.appendChild(hiddenInput);
					}

				});
				document.getElementById("isPeriodic").value = 1;
				document.getElementById("BookingID").value = id;
				$('#change').submit();


			} else {
				alert("Palun vali ainult üks nädalapäev mida muuta soovid");
				event.preventDefault();
			}
		});



		var calHeight = $(".fc-body").height();
		var calRows = $(".fc-slats tr").length;
		var rowHeightRaw = calHeight / calRows;
		var rowHeight = rowHeightRaw.toString().match(/^-?\d+(?:\.\d{0,1})?/)[0];
		$('.fc-slats tr').css('height', rowHeight + 'px');
		$(window).trigger('resize');
		$(".fc-body").trigger('reload');

	

		$('input[id=region]').focusin(function() {

			$('input[id=region]').val('');

		});

		$('input[id=sport_facility]').focusin(function() {
			$('input[id=sport_facility]').val('');
		});

		$('input[id=room]').focusin(function() {
			$('input[id=room]').val('');
		});

		$("#region").on('change keydown input paste', function(e) {

			var $input = $(this),
				val = $input.val();
			list = $input.attr('list'),
				match = $('#' + list + ' option').filter(function() {
					return ($(this).val() === val);
				});
			if (match.length > 0) {
		
				var value = $('#region').val();
				var country_id = $('#regions [value="' + value + '"]').data('value');
				$.ajax({
					url: "<?php echo base_url(); ?>home/fetch_city",
					method: "POST",
					data: {
						country_id: country_id
					},
					success: function(data) {
				
						$("#asutus").empty();
						$("#room").empty();
						$('#asutus').html(data).appendTo("#asutus");
					}
				});
			} else {
			
				$('#room').val('');
				$('#sport_facility').val('');

			}
		});
		$("#sport_facility").on('load change keydown input paste', function(e) {
			var $input = $(this),
				val = $input.val();
			list = $input.attr('list'),
				match = $('#' + list + ' option').filter(function() {
					return ($(this).val() === val);
				});
			if (match.length > 0) {
			
				var value = $('#sport_facility').val();
				var state_id = $('#asutus [value="' + value + '"]').data('value');
			
				$.ajax({
					url: "<?php echo base_url(); ?>home/fetch_building",
					method: "POST",
					data: {
						state_id: state_id	
					},
					success: function(data) {
					
						$('#room').val('');
						$("#saal").empty();

						//	$('#saal').html('<option value="">Vali asutus</option>');
						$('#saal').html(data).appendTo("#saal");
					}
				});
			} else {
				
				$('#room').val('');
			}
		});
	
		$("#room").on('change keydown input paste', function(e) {
			var $input = $(this),
				val = $input.val();
			list = $input.attr('list'),
				match = $('#' + list + ' option').filter(function() {
					return ($(this).val() === val);
				});
		

			if (match.length > 0 && val.length > 0) {
				val = $('#room').val();
				var xyz = $('#saal   option').filter(function() {
					return this.value == val;
				}).data('value');

				window.location.href = '<?php echo base_url(); ?>fullcalendar?roomId=' + xyz + '&date=' + $('#calendar').fullCalendar('getDate').format('DD.MM.YYYY');
			} else {
		
			}
		});

		$('#calendar').fullCalendar({
			dayClick: function(date, jsEvent, view) {
				$(".fc-state-highlight").removeClass("fc-state-highlight");
				$("td[data-date=" + date.format('YYYY-MM-DD') + "]").addClass("fc-state-highlight");
			}
		});


		$("#datepicker").val('<?php echo ($this->input->get("date")); ?>');
		if ('<?php echo ($this->input->get("date")); ?>') {
		
			date = moment('<?php echo ($this->input->get("date")); ?>', "DD.MM.YYYY");
			$("#calendar").fullCalendar('gotoDate', date);
			$('.fc-slats tr').css('height', rowHeight + 'px');
			$(window).trigger('resize');
			$(".fc-body").trigger('reload');
		}


		$('#datepicker').datepicker()
			.on("input change", function(e) {
				date = moment(e.target.value, "DD.MM.YYYY");
				$("#calendar").fullCalendar('gotoDate', date);
			
				// $('#calendar').fullCalendar( 'gotoDate', e.target.value )
				//  window.location.href = '<?php echo site_url(''); ?>fullcalendar?roomId=<?php echo ($this->input->get('roomId')); ?>&date='+ e.target.value;
				window.history.replaceState("", "", "fullcalendar?roomId=<?php echo ($this->input->get('roomId')); ?>&date=" + e.target.value);
				$('.fc-slats tr').css('height', rowHeight + 'px');
				$(window).trigger('resize');
				$(".fc-body").trigger('reload');
			});


		$('body').on('click', 'button.fc-prev-button', function() {
			window.history.replaceState("", "", "fullcalendar?roomId=<?php echo ($this->input->get('roomId')); ?>&date=" + $('#calendar').fullCalendar('getDate').format('DD.MM.YYYY'));
			//kas alumist on vaja? see muudab input datepickeri väärtust vastavalt kuupäevadele
			//    $('#datepicker').val($('#calendar').fullCalendar('getDate').format('DD.MM.YYYY'));

			$('.fc-slats tr').css('height', rowHeight + 'px');
			$(window).trigger('resize');
		});

		$('body').on('click', 'button.fc-next-button', function() {
			window.history.replaceState("", "", "fullcalendar?roomId=<?php echo ($this->input->get('roomId')); ?>&date=" + $('#calendar').fullCalendar('getDate').format('DD.MM.YYYY'));

			$('.fc-slats tr').css('height', rowHeight + 'px');
			$(window).trigger('resize');
			//$('#datepicker').val($('#calendar').fullCalendar('getDate').format('DD.MM.YYYY'));

		});

		$(window).on('load', function() {
			$('.fc-slats tr').css('height', rowHeight + 'px');
			$(window).trigger('resize');
		});

		date = moment('<?php echo ($this->input->get("date")); ?>', "DD-MM-YYYY");

		if ('<?php echo ($this->input->get("date")); ?>') {
			$("#calendar").fullCalendar('gotoDate', date);
		}



	function toggleAccordion() {
		this.classList.toggle('active');
		this.nextElementSibling.classList.toggle('active');
	}



	$('.accordion a').bind("click", toggleAccordion);
	

	$('#calendar').click(function() {
		$('#countNr').text('Kõik ajad (' +$('.abc:checked').length + '/'+ $('#myTable tr:has(td)').length + ')');
	});

	$(document).on('click', '.abc', function() { 
		$('#countNr').text('Kõik ajad (' +$('.abc:checked').length + '/'+ $('#myTable tr:has(td)').length + ')');

	});

	//Kui modalit lahti tehakse, siis kalender läheb väiksemaks. Ja vastupidi
	$(window).on('click', function(event) {

		if ($('body').hasClass('modal-open')) {
			$('#calendar-container').css({
				'margin-left': '350px'
			});
			$('#widthToggle').css({
				'margin-left': '350px'
			});
		} else {
			$('#calendar-container').css({
				'margin-left': '0'
			});
			$('#widthToggle').css({
				'margin-left': '0'
			});
		}
	});

	function isOverlapping(event) {
		var array = $('#calendar').fullCalendar('clientEvents');
		for (var i in array) {
			if (array[i].id != event.id && array[i].start != null && array[i].end != null && event.start != null && event.end != null) {
				if (array[i].start.isBefore(event.end) && array[i].end.isAfter(event.start)) {
					return true;
				}
			}
		}
		return false;
	}

	function isOverlapping2(event, events) {
	//	var events = $('#calendar').fullCalendar('clientEvents');
		
		for (var i in events) {
		
			if (events[i].timeID != event.timeID && events[i].start != null && events[i].end != null && event.start != null && event.end != null) {
			
				if (events[i].start.isBefore(event.end) && events[i].end.isAfter(event.start) && events[i].end> moment().subtract(7, "days")) {
			
					return events[i];
				}
			}
		}
		return false;
	}
		

	$('#allCalenderLink').click( function(e) { 
		e.preventDefault();
	
		window.location.href = '<?php echo base_url(); ?>allbookings/weekview/?date='+	moment($('#calendar').fullCalendar('getDate')).format("DD.MM.YYYY");
		} );

	
	});


</script>
