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


	


				</div>
				<!-- KALENDER CONTAINERIS START -->
				<div id="calendar-container">
					<div id='calendar'></div>
				</div>
				<br />

				<!-- KALENDER CONTAINERIS END -->
			</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker.js"></script>
<script>
	var counter = 0;
	$(document).ready(function() {
		var days = ['P', 'E', 'T', 'K', 'N', 'R', 'L'];
		var displayOrNot = '<?php echo $this->session->userdata('roleID') ?>';

		var monthNamesForModal = ['Jaanuar', 'Veebruar', 'Märts', 'Aprill', 'Mai', 'Juuni', 'Juuli', 'August', 'September', 'Oktoober', 'November', 'Detsember'];

		//lehe üleval pisike input kalender
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
				}
			

			],
			selectable: true,
			selectHelper: true,
	
		
			
		



		});

	

	items.forEach(item => item.addEventListener('click', toggleAccordion));


	$('#calendar').click(function() {

	//	var length = $('#myTable tr').length;
		$('#countNr').text('Kõik ajad (' + counter + ')');
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
				//	 console.log(events[i].end<new Date());
					// console.log(events[i].end._i +" "+event.start._i)
				//	console.log(new Date(events[i].start)+" i="+new Date(event.end));
					return events[i];
				}
			}
		}
		return false;
	}
		
	});


</script>
