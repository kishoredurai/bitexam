<?php

//exam_enroll.php // source code modified by jacksonsilass@gmail.com +255 763169695 from weblessons

include('header.php');

$exam_id = $exam->Get_exam_id($_GET['code']);


include('../include/db.php');
require_once'../include/db.php';

$result = mysqli_query($db,"SELECT count(*) as cnt from user_exam_enroll_table WHERE exam_id='$exam_id';");
$row=mysqli_fetch_array($result);
$total=$row["cnt"];


$result = mysqli_query($db,"SELECT count(*) as pres from user_exam_enroll_table WHERE exam_id='$exam_id' and attendance_status='Present';");
$row=mysqli_fetch_array($result);
$present=$row["pres"];


$result = mysqli_query($db,"SELECT count(*) as abse from user_exam_enroll_table WHERE exam_id='$exam_id' and attendance_status='Absent';");
$row=mysqli_fetch_array($result);
$absent=$row["abse"];


?>

<br />
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="exam.php">Exam List</a></li>
    	<li class="breadcrumb-item active" aria-current="page">Exam Enrollment List</li>
  	</ol>
</nav>


<div class="container">
    <div class="row">
    <div class="col-md-3">
      <div class="card-counter primary">
        <i class="fa fa-list"></i>
        <span class="count-numbers"><?php echo $total ?></span>
        <span class="count-name">Total Students</span>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card-counter success">
        <i class="fa fa-check"></i>
        <span class="count-numbers"><?php echo $present ?></span>
        <span class="count-name">Present Students</span>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card-counter danger">
        <i class="fa fa-times"></i>
        <span class="count-numbers"><?php echo $absent ?></span>
        <span class="count-name">Absent Students</span>
      </div>
    </div>

</div>
</div>


<br>
<Br>





<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">Exam Enrollment List</h3>
			</div>
			<div class="col-md-3" align="right">
				<a href="pdf_enroll_result.php?code=<?php echo $_GET['code']; ?>" class="btn danger btn-sm" target="_blank">PDF</a>
        <a href="xls_enroll_result.php?code=<?php echo $_GET['code']; ?>" s class="btn success btn-sm" target="_blank">EXCEL</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table id="enroll_table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
					<th>S.No</th>
						<th>Image</th>
						<th>Name</th>
						<th>Rollno</th>
						<th>Email ID</th>
						<th>Gender</th>
						<th>Attendance</th>
						<th>Exam Intime</th>
						<th>Exam Outtime</th>
						<th>Exam Status</th>
						<th>Remark</th>						
						<th>Result</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>



<script>

$(document).ready(function(){
	var code = "<?php echo $_GET['code']; ?>";

	var dataTable = $('#enroll_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"ajax_action.php",
			type:"POST",
			data:{action:'fetch', page:'exam_enroll', code:code},
		},
		"columnDefs" : [
			{
				"targets" : [0],
				"orderable" : false
			}
		]
	});
});

</script>
<style>
.card-counter{
    box-shadow: 2px 2px 10px #DADADA;
    margin: 5px;
    padding: 20px 10px;
    background-color: #fff;
    height: 100px;
    border-radius: 5px;
    transition: .3s linear all;
  }

  .card-counter:hover{
    box-shadow: 4px 4px 20px #DADADA;
    transition: .3s linear all;
  }

  .card-counter.primary{
    background-color: #007bff;
    color: #FFF;
  }

  .card-counter.danger{
    background-color: #ef5350;
    color: #FFF;
  }  

  .card-counter.success{
    background-color: #66bb6a;
    color: #FFF;
  }  

  .card-counter.info{
    background-color: #26c6da;
    color: #FFF;
  }  

  .card-counter i{
    font-size: 5em;
    opacity: 0.2;
  }

  .card-counter .count-numbers{
    position: absolute;
    right: 35px;
    top: 20px;
    font-size: 32px;
    display: block;
  }

  .card-counter .count-name{
    position: absolute;
    right: 35px;
    top: 65px;
    font-style: italic;
    text-transform: capitalize;
    opacity: 0.5;
    display: block;
    font-size: 18px;
  }
</style>
<?php

include('footer.php');

?>