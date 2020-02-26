

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
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
	  datesAboveResources: true,
      defaultDate: '2020-02-07',
	  aspectRatio: 2.6,
	 minTime: '08:00:00',
			maxTime: '22:00:00',
      editable: true,
      selectable: true,
      eventLimit: true, // allow "more" link when too many events
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'resourceTimeGridDay,resourceTimeGridTwoDay,resourceTimeGridWeek,timeGridWeek,dayGridMonth'
      },
      views: {
        resourceTimeGridTwoDay: {
          type: 'resourceTimeGrid',
          duration: { days: 2 },
          buttonText: '2 days',
        }
      },

      //// uncomment this line to hide the all-day slot
      //allDaySlot: false,

      resources: [
        { id: 'a', title: 'Suur saal' },
        { id: 'b', title: 'Väike saal', eventColor: 'green' },
        { id: 'c', title: 'Õueala', eventColor: 'orange' },
        { id: 'd', title: 'Tohutu ruum', eventColor: 'red' },
		{ id: 'e', title: 'Kitsas ruum', eventColor: 'ligthblue' },
		{ id: 'f', title: 'Milline saal', eventColor: 'black' },
      ],
	  events: [

		// your event source
		{
			url: "<?php echo base_url(); ?>fullcalendar/load/<?php echo ($this->input->get('roomId')); ?>" // use the `url` property

			// rendering : 'background'
		}


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
      now: '2020-02-07',
	  height: 350,
	
      aspectRatio: 1.8,
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
        { id: 'a', title: 'Suur saal', occupancy: 40 },
        { id: 'b', title: 'Väike saal', occupancy: 40, eventColor: 'green' },
        { id: 'c', title: 'Õueala', occupancy: 40, eventColor: 'orange' },
        { id: 'f', title: 'Kitsas saal', occupancy: 40, eventColor: 'red' },
        { id: 'g', title: 'Punane saal', occupancy: 40 },
      
        { id: 'z', title: 'Auditorium Z', occupancy: 40 }
      ],
      events: [
        { id: '1', resourceId: 'b', start: '2020-02-07T02:00:00', end: '2020-02-07T07:00:00', title: 'event 1' },
        { id: '2', resourceId: 'c', start: '2020-02-07T05:00:00', end: '2020-02-07T22:00:00', title: 'event 2' },
        { id: '3', resourceId: 'd', start: '2020-02-06', end: '2020-02-08', title: 'event 3' },
        { id: '4', resourceId: 'e', start: '2020-02-07T03:00:00', end: '2020-02-07T08:00:00', title: 'event 4' },
        { id: '5', resourceId: 'f', start: '2020-02-07T00:30:00', end: '2020-02-07T02:30:00', title: 'event 5' }
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


