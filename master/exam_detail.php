<?php

//exam.php 

include('header.php');

include('../include/db.php');

$exam_code = $_GET['code'];

$exam->query = "
			SELECT online_exam_id FROM `online_exam_table` where online_exam_code='$exam_code';
			";

$exam->execute_query();
$id_res = $exam->query_result();
$exam_id = $id_res[0]["online_exam_id"];
$_SESSION['exam_id'] = $exam_id;

?>
<style>
    .btn {
        font-size: small;
    }
</style>


<div class="container">
    <div class="modal" id="sectionModal">
        <div class="modal-dialog modal-lg">
            <form method="post" id="section_form">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="question_modal_title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Section Title<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <!-- <input type="text" name="question_title" id="question_title" autocomplete="off" class="form-control" /> -->
                                    <!-- question -->
                                    <input id="section_title" name="section_title" autocomplete="off" class="form-control">
                                    <!-- <input type="hidden" name="question_title" id="question_title"> -->
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Total Questions<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" name="total_question" id="total_question" min="1" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="hidden" name="question_id" id="question_id" />

                        <input type="hidden" name="online_exam_id" id="hidden_online_exam_id" />

                        <input type="hidden" name="page" value="section" />

                        <input type="hidden" name="action" id="section_hidden_action" value="Add" />

                        <input type="submit" name="section_button_action" id="section_button_action" class="btn btn-success btn-sm" value="Add" />

                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="questionModal">
        <div class="modal-dialog modal-lg">
            <form method="post" id="question_form">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="question_modal_title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Question <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <!-- <input type="text" name="question_title" id="question_title" autocomplete="off" class="form-control" /> -->
                                    <!-- question -->
                                    <textarea id="question_text" autocomplete="off" class="form-control question_textarea" rows="5" cols="30"></textarea>
                                    <input type="hidden" name="question_title" id="question_title">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option A <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="option_title_1" id="option_title_1" autocomplete="off" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option B <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="option_title_2" id="option_title_2" autocomplete="off" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option C <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="option_title_3" id="option_title_3" autocomplete="off" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option D <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="option_title_4" id="option_title_4" autocomplete="off" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Answer <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <select name="answer_option" id="answer_option" class="form-control">
                                        <option value="">Select</option>
                                        <option value="1">A Option</option>
                                        <option value="2">B Option</option>
                                        <option value="3">C Option</option>
                                        <option value="4">D Option</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="correct-answer-mark" class="col-md-4 text-right">Correct Answer Mark</label>
                                <div class="col-md-8">
                                    <input type="number" name="correct_mark" id="correct_mark" class="form-control" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="wrong-answer-mark" class="col-md-4 text-right">Wrong Answer Mark</label>
                                <div class="col-md-8">
                                    <input type="number" name="wrong_mark" id="wrong_mark" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="hidden" name="question_number" id="question_number" />

                        <input type="hidden" name="section_id" id="section_id" />

                        <input type="hidden" name="page" value="question" />

                        <input type="hidden" name="action" id="question_hidden_action" value="Add" />

                        <input type="submit" name="question_button_action" id="question_button_action" class="btn btn-success btn-sm" value="Add" />

                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="row" style="height: 100vh;">

        <div class="col-md-7 h-75 m-2">
            <div class="card">
                <div class="card-header">
                    Section
                </div>
                <div class="card-body">
                    <div id="question_view">
                        <p>After adding section click on question number to add or view a question.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 h-50 m-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-5">
                            <h5>All Sections</h5>
                        </div>
                        <div class="col-7">
                            <button type="button" name="add_question" id="add_section_action" class="btn btn-primary add_section">Add Section</button>
                            <!-- <button type="button" name="add_question" class="btn btn-info btn-sm add_question" id="' . $row['online_exam_id'] . '">Add Question</button>&nbsp;<a href="question.php?code=' . $row['online_exam_code'] . '" class="btn btn-warning btn-sm">View Question</a> -->
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div id="sections_view">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

<script src="./textboxio/textboxio.js"></script>

<script>
    var editor = textboxio.replace('.question_textarea');

    function reset_form() {
        $('#section_button_action').val('Add');
        $('#total_question').val('Add');
        $('#section_form')[0].reset();
        editor.content.set('');
        $('#section_form').parsley().reset();
        $('#question_form').parsley().reset();
    }

    $(document).on('click', '.add_section', function() {
        // reset_question_form();
        $('#sectionModal').modal('show');
        $('#message_operation').html('');
    });

    $('#section_form').parsley();

    $('#section_form').on('submit', function(event) {

        event.preventDefault();
        $('#section_title').attr('required', 'required');
        $('#total_question').attr('required', 'required');
        $('#hidden_online_exam_id').val('<?php echo $_GET['code'] ?>');
        // console.log($('#hidden_online_exam_id'));
        if ($('#section_form').parsley().validate()) {
            $.ajax({
                url: "ajax_action.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#section_button_action').attr('disabled', 'disabled');
                    $('#section_button_action').val('Validate...');
                },
                success: function(data) {
                    if (data.success) {

                        swal("Good job!", "Section added successfully", "success");
                        $('#section_form').trigger('reset');
                        $('#sectionModal').modal('hide');
                    }

                    $('#section_button_action').attr('disabled', false);
                    $('#section_button_action').val($('#section_hidden_action').val());
                    fetch_sections();
                    reset_form();
                }
            });
        }
    });

    function fetch_sections() {

        $.post("ajax_action.php", {
                page: "section",
                action: "fetch"
            })
            .done(function(data) {
                // console.log(data);
                var section_content = '';
                data = JSON.parse(data);
                console.log(data);

                data.sections.forEach(
                    section => {
                        // console.log(section.section_id);
                        var section_id = section.section_id;
                        var question_box = '';
                        for (var i = 1; i <= section.question_count; i++) {
                            var question_box_color = '';
                            console.log(data.questions[section_id]);
                            if (data.questions[section_id]) {
                                if ((data.questions[section_id]).includes(`${i}`)) {
                                    console.log("Questions ", data.questions[section_id], 'Question ', i);
                                    question_box_color = 'bg-success';
                                } else question_box_color = 'bg-primary';
                            } else {
                                console.log("No questions added");
                                question_box_color = 'bg-primary';

                            }

                            question_box += `<a id="${i}" class="question" section=${section_id} onclick="question_fetch();return false;"><div class="d-inline-block p-3 m-2 ${question_box_color}">${i}</div>`
                        }
                        section_content += `<div class="card mb-2">
                                    <div class="card-header">
                                        ${section.title}
                                    </div>
                                    <div class="card-body">
                                        ${question_box}
                                    </div>
                                </div>`
                    }
                );

                document.getElementById('sections_view').innerHTML = section_content;

            });

    }

    fetch_sections();

    var question_data;
    var question_button;
    function question_fetch() {
        $(document).on('click', '.question', function() {
            // console.log(this);
            question_button = this;
            question_number = $(this).attr('id');
            section_id = $(this).attr('section');
            $('#section_id').val(section_id);
            $('#question_number').val(question_number);
            console.log(section_id, question_number);

            $.post("ajax_action.php", {
                page: "section",
                action: "edit_fetch",
                data: {'section_id':  section_id, 'question_number': question_number}
            })
            .done(function(data) {
                var question_content = 'Add question to view';
                data = JSON.parse(data);
                question_data = data;
                // console.log(data);
                if(data.question){
                    question_content = `<button type="button" class="btn btn-primary edit_question float-right" question_id="${data.question.question_id}">Edit Question</button>`;
                    question_content += `<h3>Question ${data.question.question_number}</h3>\n`;
                    question_content += `<h6>${data.question.question_title}</h6>`;
                    question_content += '<h6>Options</h6>\n';
                    data.options.forEach(
                        option => {
                            // console.log(option);
                            question_content += `<p>Option ${option.option_number}: ${option.option_title}<p>\n`;
                        }
                    )
                    question_content += `<h6>Correct option: ${data.question.answer_option}</h6>`;
                    question_content += `<p>Marks for correct answer: ${data.question.correct_mark}</p>`;
                    question_content += `<p>Marks for wrong answer: ${data.question.wrong_mark}</p>`;
                    document.getElementById('question_view').innerHTML = question_content;
                    return;
                }else{
                    $('#questionModal').modal('show');
                    document.getElementById('question_view').innerHTML = question_content;
                }
            });
            
        });
    }

    $(document).on('click', '.edit_question', function(){
        question = question_data.question;
        console.log($(this).attr('question_id'));
        $('#questionModal').modal('show');
        editor.content.set(question.question_title);
        question_data.options.forEach(
            option => {
                // console.log(option);
                document.getElementById(`option_title_${option.option_number}`).value = option.option_title;
            }
        );

        $(`#answer_option option[value=${question.answer_option}]`).attr('selected', 'selected');
        document.getElementById('correct_mark').value = question.correct_mark;
        document.getElementById('wrong_mark').value = question.wrong_mark;
        document.getElementById('question_button_action').value = 'Edit';
        document.getElementById('question_hidden_action').value = 'Edit';
        document.getElementById('question_number').value = question.question_id;
    });

    $('#question_form').parsley();

	// $('#question_form').on('submit', function(event) {
    $('#question_button_action').on('click', function(event){
        event.preventDefault();
		var editors = textboxio.get('#question_text');
		var content = '';
		editors.forEach(function(ed){
			content = ed.content.get();
		});

		// console.log(document.getElementById('question_text'));
		document.getElementById('question_title').value = content;
        console.log(content);
		
		
		$('#question_title').attr('required', 'required');

		$('#option_title_1').attr('required', 'required');

		$('#option_title_2').attr('required', 'required');

		$('#option_title_3').attr('required', 'required');

		$('#option_title_4').attr('required', 'required');

		$('#answer_option').attr('required', 'required');

		if($('#question_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$('#question_form').serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#question_button_action').attr('disabled', 'disabled');
					$('#question_button_action').val('Validate...');
				},
				success:function(data)
				{
					if(data.success)
					{   
						// alert("Question Added successfully");
						swal("Good job!", "Successful", "success");
						
						$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');

						$('#question_form').trigger('reset');
                        reset_form();
						$('#questionModal').modal('hide');
					}
                    reset_form();
					$('#question_button_action').attr('disabled', false);

					$('#question_button_action').val('Add');
                    fetch_sections();
                    $(question_button).click();

                
				}
			});
        }
		// }else return false;

	});

    

</script>