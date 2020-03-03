
<a href="<?php echo base_url(); ?>/allbookings/">Nimekiri </a>
<a href="<?php echo base_url(); ?>/allbookings/weekview">Kalender</a>

	<br>

		

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


      //allDaySlot: false,

      resources: {	
					url: "<?php echo base_url(); ?>allbookings/loadRooms/<?php echo $this->session->userdata['building']; ?>" // use the `url` property
				 },
     
     
			eventSources: [


{
	url: "<?php echo base_url(); ?>allbookings/load/<?php echo $this->session->userdata['building']; ?>" // use the `url` property
	
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

    calendar1.render();
 var removedResources=[];
 var removedAll=true;
    $('input[type="checkbox"]').change(function()
      {
		
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


</style>
</head>
<body>


<?php 
foreach($rooms as $value){
	echo  '<input type="checkbox" id="addOrRemoveRoom'.$value['id'].'" name="vehicle" value="'.$value['id'].'" checked>
  <label for="vehicle1"> '.$value['roomName'].'</label>'
	;}?>

<div id='calendar1'></div>







