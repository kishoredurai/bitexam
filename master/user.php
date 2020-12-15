<?php



include('header.php');

?>
<br /><br>

<br><Br>
<div class="card">
	<div class="card-header">

	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div id="table-filter"></div>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" id="user_data_table">
				<thead>
					<tr>
					<th>S.No</th>
						<th>Image</th>
						<th>User Name</th>
						<th>Email Address</th>
						<th>Rollno</th>
						<th>Year</th>
						<th>Mobile No</th>
						<th>Department</th>
						<th>Action</th>
					</tr>
				</thead>
				<tfoot></tfoot>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="detailModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">User Details</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body" id="user_details">

			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<style>
	.btn {
		font-size: 0.875rem;
		font-weight: 500;
		width: 140px;
	}
</style>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
	var selections = []
	$(document).ready(function() {

		var dataTable = $('#user_data_table').DataTable({
			// "processing": true,
			"serverSide": true,
			"paging": false,
			"order": [],
    		select: true,
    		// stateSave: true,
			"ajax": {
				url: "ajax_action.php",
				type: "POST",
				data: {
					action: 'fetch',
					page: 'user'
				}
			},

			"columnDefs": [{
					"targets": [0, 1, 8],
					"orderable": false,
				},
			],

			initComplete: function () {
            this.api().columns([2, 5, 7]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $('#table-filter'))
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
						
                        dataTable
							.search( val )
                            .draw();
                    } );
					
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
			
		});

		



		$(document).on('click', '.details', function() {
			var user_id = $(this).attr('id');
			$.ajax({
				url: "ajax_action.php",
				method: "POST",
				data: {
					action: 'fetch_data',
					user_id: user_id,
					page: 'user'
				},
				success: function(data) {
					$('#user_details').html(data);
					$('#detailModal').modal('show');
				}
			});
		});

	});
</script>