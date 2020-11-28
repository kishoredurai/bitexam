<?php


include('../master/Examination.php');
$exam = new Examination;

$exam->user_session_private();
include('../include/db.php');	
include('../include/user_header.php');
require_once '../include/db.php';

$id = $_SESSION['user_id'];

$result = mysqli_query($db,"SELECT * from user_table where user_id='$id' ;");
$user = mysqli_fetch_assoc($result);
$year=$user['user_year'];
$course=$user['user_course'];
$sql = "SELECT e_id, event_title, start, end, color FROM event_table where user_year='$year' and user_course='$course';";

$req = $bdd->prepare($sql);
$req->execute();

$events = $req->fetchAll();




?>
<br>
<link href="bootstrap.min.css" rel="stylesheet">
	
	<!-- FullCalendar -->
	<link href='../include/calender/css/fullcalendar.css' rel='stylesheet' />

<link href="../style/button.css" rel="stylesheet" type="text/css">
<style>
  
	#calendar {
		max-width: 800px;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
		.fc-content {
	color: white;
}
	
    </style>
 <br>
    <div class="container">
<center>	<h1>Upcoming Events with Time</h1></center>
        <div class="row ">
            <div class="col-lg-12 text-center">
               <br><br>
                <div id="calendar" class="col-centered border border-primary" >
                </div>
            </div>
		
        </div>
        <!-- /.row -->
	
		
    </div>
 

    <!-- jQuery Version 1.11.1 -->
    <script src="../include/calender/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../include/calender/js/bootstrap.min.js"></script>
	
	<!-- FullCalendar -->
	<script src='../include/calender/js/moment.min.js'></script>
	<script src='../include/calender/js/fullcalendar.min.js'></script>
	
	<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '2016-01-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit').modal('show');
				});
			},
			eventDrop: function(event, delta, revertFunc) { // si changement de position

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},
			events: [
			<?php foreach($events as $event): 
			
				$start = explode(" ", $event['start']);
				$end = explode(" ", $event['end']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['start'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['end'];
				}
			?>
				{
					id: '<?php echo $event['e_id']; ?>',
					title: '<?php echo $event['event_title']; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					color: '<?php echo $event['color']; ?>',
				},
			<?php endforeach; ?>
			]
		});
		
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			
			id =  event.id;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			
			$.ajax({
			 url: 'editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Saved');
					}else{
						alert('Could not be saved. try again.'); 
					}
				}
			});
		}
		
	});

</script>

</body>
</html>
