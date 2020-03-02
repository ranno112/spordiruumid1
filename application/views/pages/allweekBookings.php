<button class="printBtn hidden-print">Print</button>

<script type="text/javascript">
  $('.printBtn').on('click', function (){
    window.print();
  });
</script>
<a href="<?php echo base_url(); ?>/allbookings/">Nimekiri </a>
	<a href="<?php echo base_url(); ?>/allbookings/weekview">Kalender</a>
	<?php echo base_url(); ?>allbookings/load/<?php echo $this->session->userdata['building']; ?>
	<br>

		
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<!-- <link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.css" rel="stylesheet" type="text/css" />
<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.print.css " rel="stylesheet" type="text/css" media="print" /> -->
<link href='<?php echo base_url(); ?>assets/css/fullcalendar.print.css' rel="stylesheet" type="text/css"  media="print">`
<link href='<?php echo base_url(); ?>assets/packages/core/main.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/packages/daygrid/main.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/packages/timegrid/main.css' rel='stylesheet' />
<script src='<?php echo base_url(); ?>assets/packages/core/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages/interaction/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages/daygrid/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages/timegrid/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages-premium/resource-common/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages-premium/resource-daygrid/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages-premium/resource-timegrid/main.js'></script>

<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendar1El = document.getElementById('calendar1');

    var calendar1 = new FullCalendar.Calendar(calendar1El, {
		
      plugins: [ 'interaction', 'resourceDayGrid', 'resourceTimeGrid' ],
		
      defaultView: 'resourceTimeGridWeek',
	   datesAboveResources: true,
   	firstDay: 1,
		 allDaySlot: false,
	  aspectRatio: 2,
	 minTime: '08:00:00',
			maxTime: '22:00:00',
      editable: true,
      selectable: true,
      eventLimit: true, // allow "more" link when too many events
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'resourceTimeGridDay,resourceTimeGridThreeDay,resourceTimeGridFourDay,resourceTimeGridWeek,timeGridWeek,dayGridMonth'
      },
      views: {
        resourceTimeGridWeek: {
          type: 'resourceTimeGrid',
         
					slotDuration: '00:30:00',
          buttonText: 'Resourceweek',
					
        }, resourceTimeGridFourDay: {
          type: 'resourceTimeGrid',
          duration: { days: 4 },
          buttonText: '4 days'
        }, resourceTimeGridThreeDay: {
          type: 'resourceTimeGrid',
          duration: { days: 3 },
          buttonText: '3 days'
        }
      },

      //// uncomment this line to hide the all-day slot
      //allDaySlot: false,

      resources: {	
					url: "<?php echo base_url(); ?>allbookings/loadRooms/<?php echo $this->session->userdata['building']; ?>" // use the `url` property
				 },
     
     
			eventSources: [

// your event source
{
	url: "<?php echo base_url(); ?>allbookings/load/<?php echo $this->session->userdata['building']; ?>" // use the `url` property
	
}

// any other sources...

],
      select: function(arg) {
        console.log(
          'select',
          arg.startStr,
          arg.endStr,
          arg.resource ? arg.resource.id : '(no resource)'
        );
      },
      dateClick: function(arg) {
        console.log(
          'dateClick',
          arg.date,
          arg.resource ? arg.resource.id : '(no resource)'
        );
      }
    });

    calendar1.render();
 var removedResources=[];
 var removedAll=true;
    $('input[type="checkbox"]').change(function()
      {
			
			// 			if ($(this).is(':checked')) {
      //      // Do something...
      //   //   alert("Id: " + $(this).attr("id") + " Value: " + $(this).val());
		
			// index = removedResources.indexOf($(this).val());
			// if (index == -1) {
			// 	removedResources.push($(this).val());
			// 	console.log(removedResources);
			// 		var resourceA = calendar1.getResourceById($(this).val());
			// 				resourceA.remove();
			// }
          
      //   }
			if($(this).is(':checked')){
					calendar1.refetchResources();
					
					index = removedResources.indexOf($(this).val());
		
				removedResources=[];
				removedAll=false;
		
	
				}
				console.log(calendar1.getResources());
				var sList = "";
				setTimeout(function(){ 
		$('input[type=checkbox]').each(function () {
				sList += "(" + $(this).val() + "-" + (this.checked ? "checked" : "not checked") + ")";
				if(!this.checked){
					index = removedResources.indexOf($(this).val());
			if (index == -1) {
				removedResources.push($(this).val());
				console.log(removedResources);
					var resourceA = calendar1.getResourceById($(this).val());
							resourceA.remove();
			}
			
				
		}
	
});
console.log (sList); }, 100);
      });

		



		$(function () {
		$('#addOrRemoveRoom').click(function () {
			var id = $(this).attr('id');
			alert(id);
		});
	});
	
		console.log(	$("#addOrRemoveRoom").attr("id"));
  });

</script>
<style>

  body {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar1 {
    max-width: 100%;
    margin: 50px auto;
  }

</style>
</head>
<body>


<?php 
foreach($rooms as $value){
	echo  '<input type="checkbox" id="addOrRemoveRoom'.$value['id'].'" name="vehicle" value="'.$value['id'].'" checked>
  <label for="vehicle1"> '.$value['roomName'].'</label>'
	;}?>



<input type="button" id="demo" value = "Demo" />
 
<script type = "text/javascript" src = "http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.6.1.min.js"></script>
<script type="text/javascript">
  
</script>



  <div id='calendar1'></div>

</body>
</html>






<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href="<?php echo base_url(); ?>assets/css/bootstrap-clockpicker.min.css" type="text/css" rel="stylesheet">
<link href='<?php echo base_url(); ?>assets/packages/core/main.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/packages/daygrid/main.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/packages/timegrid/main.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/packages-premium/timeline/main.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/packages-premium/resource-timeline/main.css' rel='stylesheet' />
<script src='<?php echo base_url(); ?>assets/packages/core/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages/daygrid/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages/timegrid/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages-premium/timeline/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages-premium/resource-common/main.js'></script>
<script src='<?php echo base_url(); ?>assets/packages-premium/resource-timeline/main.js'></script>

<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
		schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
      plugins: [ 'dayGrid', 'timeGrid', 'resourceTimeline' ],
     
	  height: 450,
		firstDay: 1,
		allDaySlot: false,
      scrollTime: '00:00',
      header: {
        left: 'today prev,next',
        center: 'title',
		right: 'resourceTimelineDay,resourceTimelineWeek, timelineWeek,resourceTimelineMonth, resourceTimelineFourDays '
      },
      defaultView: 'resourceTimelineWeek',
	  minTime: '08:00:00',
	maxTime: '22:00:00',
      views: {
				resourceTimelineFourDays: {
					slotDuration: '02:00:00',
      type: 'resourceTimeline',
      duration: { days: 2 }
    },
		resourceTimelineWeek: {
                type: 'timelineWeek',
                slotDuration: '01:00:00'
            },
						
      },
      resourceAreaWidth: '10%',
      resourceColumns: [
        {
          labelText: 'Room',
          field: 'title'
        }
      
      ],

			
			resources: {	
					url: "<?php echo base_url(); ?>allbookings/loadRooms/<?php echo $this->session->userdata['building']; ?>" // use the `url` property
				 },
			eventSources: [

			// your event source
			{
				url: "<?php echo base_url(); ?>allbookings/load/<?php echo $this->session->userdata['building']; ?>" // use the `url` property

			}

			// any other sources...

			]

    });

    calendar.render();
  });

</script>
<style>

  body {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 100%;
    margin: 50px auto;
  }

</style>
</head>
<body>

  <div id='calendar'></div>

</body>
</html>





<div class="container">




</div>


