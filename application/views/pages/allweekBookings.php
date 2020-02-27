<button class="printBtn hidden-print">Print</button>

<script type="text/javascript">
  $('.printBtn').on('click', function (){
    window.print();
  });
</script>
<a href="<?php echo base_url(); ?>/allbookings/">Nimekiri </a>
	<a href="<?php echo base_url(); ?>/allbookings/weekview">Kalender</a>
	<?php echo base_url(); ?>allbookings/load/<?php echo $this->session->userdata['building']; ?>
		
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
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
		
      plugins: [ 'interaction', 'resourceDayGrid', 'resourceTimeGrid' ],
		
      defaultView: 'resourceTimeGridWeek',
	  // datesAboveResources: true,
   	firstDay: 1,
		 allDaySlot: false,
	  aspectRatio: 2.6,
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

      resources: [
        { id: '1', title: '1. VÄLJAK' },
        { id: '215', title: '2. VÄLJAK', eventColor: 'yellow' },
        { id: '20', title: '3. VÄLJAK', eventColor: 'orange' },
        { id: '214', title: 'Väikse saal', eventColor: 'lightgreen' },
		{ id: '212', title: 'Aeroobika', eventColor: 'pink' },
		{ id: '213', title: 'Nõupidamine', eventColor: 'lightblue' },
		{ id: '216', title: 'Milline saal', eventColor: 'MediumPurple' }
      ],
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
		right: 'resourceTimelineDay,resourceTimelineWeek, timelineWeek,resourceTimelineMonth'
      },
      defaultView: 'resourceTimelineWeek',
	  minTime: '08:00:00',
	maxTime: '22:00:00',
      views: {
		resourceTimelineWeek: {
                type: 'timelineWeek',
                slotDuration: '02:00:00'
            },
      },
      resourceAreaWidth: '10%',
      resourceColumns: [
        {
          labelText: 'Room',
          field: 'title'
        }
      
      ],

			
     resources: [
        { id: '1', title: '1. VÄLJAK' },
        { id: '215', title: '2. VÄLJAK', eventColor: 'green' },
        { id: '20', title: '3. VÄLJAK', eventColor: 'orange' },
        { id: '214', title: 'Väikse saal', eventColor: 'red' },
		{ id: '212', title: 'Aeroobika', eventColor: 'pink' },
		{ id: '213', title: 'Nõupidamine', eventColor: 'lightblue' },
		{ id: '216', title: 'Milline saal', eventColor: 'purple' }
      ],
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





    <div class="table-container mt-3">
       
		
		Kõik Nädalavaade
		<?php // print_r($manageUsers);?>
        <table class="table-borderless table-users mt-3">
            <thead class="bg-grey border-bottom ">
                <tr>
					<th class="pl-3 py-2 txt-strong text-darkblue" scope="col" colspan="2">Esmaspäev</th>
					<th class="py-2 txt-strong text-darkblue" scope="col" colspan="2">Teisipäev</th>
					<th class="py-2 txt-strong text-darkblue" scope="col" colspan="2">Kolmapäev</th>
					<th class="py-2 txt-strong text-darkblue" scope="col" colspan="2">Neljapäev</th>
					<th class="py-2 txt-strong text-darkblue" scope="col" colspan="2">Reede</th>
				
				
                    <th class="py-2 txt-strong text-darkblue" scope="col" colspan="2">Laupäev</th>
                    <th class="py-2 txt-strong text-darkblue" scope="col" colspan="2">Pühapäev</th>
				
				
                </tr>
            </thead>
            <tbody class="">
			<?php foreach($manageUsers as $singleUser) : 
				if(date("W", strtotime($singleUser['startTime']))==date("W", strtotime(date('Y-m-d H:i:s')))){
					echo $singleUser['roomName'];echo date('d.m.Y', strtotime($singleUser['startTime'])); echo date("w", strtotime($singleUser['startTime']));?>
                <tr>
                    <td class="pl-3 p-1 text-darkblue border-bottom-light"><?php if(idate('w', strtotime($singleUser['startTime']))==1){ echo date('H:i', strtotime($singleUser['startTime'])); echo "-". date('H:i', strtotime($singleUser['endTime']));?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php  echo $singleUser['public_info'].", ".$singleUser['workout'];}?></td>
					
		
				
					<td class="p-1 text-darkblue border-bottom-light"><?php if(idate('w', strtotime($singleUser['startTime']))==3){ echo date('H:i', strtotime($singleUser['startTime'])); }?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php if(idate('w', strtotime($singleUser['startTime']))==4){ echo date('H:i', strtotime($singleUser['endTime']));} ?></td>

					<!-- https://stackoverflow.com/questions/365191/how-to-get-time-difference-in-minutes-in-php -->
				
					<td class="p-1 text-darkblue border-bottom-light"><?php if(idate('w', strtotime($singleUser['startTime']))==5){ echo $singleUser['public_info']; }?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php if(idate('w', strtotime($singleUser['startTime']))==6){ echo $singleUser['workout'];} ?></td>
					<td class="p-1 text-darkblue border-bottom-light"><?php if(idate('w', strtotime($singleUser['startTime']))==0){ echo $singleUser['comment'];} ?></td>





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
            <?php }; endforeach; ?>
		</tbody>
        </table>
    </div>
</div>


