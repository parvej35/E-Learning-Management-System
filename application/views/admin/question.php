<?php include(__DIR__."/../template/header.php"); ?>

<!-- section -->
<div class="section">
	<div class="container" style="padding-top: 50px;">
		<div class="row">			
			<div class="col-md-12 shadow-border">
				<form id="questionnaire_form" class="clearfix" style="margin-top: 10px;">
					<div class="col-md-12">
						<div class="section-title">
							<h4 class="title">Question Information</h4>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<p>Course</p>
							<select class="input" id="course_id" name="course_id" onchange="populate_lesson_list();">
								<option value="0">-- Select --</option>
								<?php 
	                                foreach($course_list as $course):
	                                  echo "<option value=".$course->id.">".$course->name."</option>"; 
	                                endforeach
	                            ?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<p>Lesson</p>
							<select class="input" id="lesson_id" name="lesson_id">
								<option value="0">-- Select --</option>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<p>Question</p>
							<input class="input" type="text" id="title" name="title" value="">
						</div>
					</div>
						
					<div class="col-md-3">
						<div class="form-group">
							<input type="radio" name="right_answer" id="right_answer" value="1"> &nbsp;Right answer
							<input class="input" type="text" id="answer_1" name="answer_1" value="">
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<input type="radio" name="right_answer" id="right_answer" value="2"> &nbsp;Right answer
							<input class="input" type="text" id="answer_2" name="answer_2" value="">
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<input type="radio" name="right_answer" id="right_answer" value="3"> &nbsp;Right answer
							<input class="input" type="text" id="answer_3" name="answer_3" value="">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<input type="radio" name="right_answer" id="right_answer" value="4"> &nbsp;Right answer
							<input class="input" type="text" id="answer_4" name="answer_4" value="">
						</div>
					</div>
					<div class="col-md-6">
						<i class="fa fa-refresh fa-spin" id="loader"></i>
						<p id="message" class="error"></p>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<button type="button" class="btn btn-danger" id="btn_reset" onclick="clear_form();">Reset Form</button>
							<button type="button" class="btn btn-success" id="btn_submit" onclick="submit_form();" style="float: right;"> Save Questionnaire</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /section -->

<!-- section -->
<div class="section" style="min-height: 800px;">
	<div class="container">
		<h5 style='border-top:1px dotted gray;'></h5>
        <button class="btn btn-info" onclick="reload_table()">
        	<i class="fa fa-refresh"></i> Reload
        </button>

        <br><br>
        <table id="custom_table" class="table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
                <tr style="background-color: lavender;">
				    <th style="width: 5%;">Sl</th>
                    <th style="width: 15%;">Course</th>
                    <th style="width: 15%;">Lesson</th>
                    <th style="width: 45%;">Question</th>
                    <th style="width: 15%;">Answer</th>
                    <th style="width: 5%;"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
	</div>
</div>
<!-- /section -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_div_to_update_info" role="dialog">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-body form">
                <form id="questionnaire_update_form" class="clearfix" style="margin-top: 10px;">
                	<input type="hidden" name="questionnaire_id" id="questionnaire_id" value="0">

                	<div class="col-md-6">
						<div class="form-group">
							<p>Course</p>
							<select class="input" id="update_course_id" name="update_course_id" onchange="populate_lesson_list_to_update()">
								<option value="0">-- Select --</option>
									<?php 
		                                foreach($course_list as $course):
		                                  echo "<option value=".$course->id.">".$course->name."</option>"; 
		                                endforeach
		                            ?>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<p>Lesson</p>
							<select class="input" id="update_lesson_id" name="update_lesson_id">
								<option value="0">-- Select --</option>
							</select>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<p>Question</p>
							<input class="input" type="text" id="update_title" name="update_title" value="">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<input type="radio" name="update_right_answer" id="update_right_answer" value="1"> &nbsp;Right answer
							<input class="input" type="text" id="update_answer_1" name="update_answer_1" value="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="radio" name="update_right_answer" id="update_right_answer" value="2"> &nbsp;Right answer
							<input class="input" type="text" id="update_answer_2" name="update_answer_2" value="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="radio" name="update_right_answer" id="update_right_answer" value="3"> &nbsp;Right answer
							<input class="input" type="text" id="update_answer_3" name="update_answer_3" value="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="radio" name="update_right_answer" id="update_right_answer" value="4"> &nbsp;Right answer
							<input class="input" type="text" id="update_answer_4" name="update_answer_4" value="">
						</div>
					</div>
				</form>
            </div>
            <div class="modal-footer">
            	<i class="fa fa-refresh fa-spin" id="update_loader"></i>
            	<span style="float:left;" class="error" id="update_msg_span"></span>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success" id="btn_update" onclick="update_questionnaire_form();" style="float: right;"> Update questionnaire</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<?php include(__DIR__."/../template/footer.php"); ?>

<script type="text/javascript">
	var table;

	$(document).ready(function(){
		$("#loader").hide();
		$("#update_loader").hide();

		table = $('#custom_table').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [], //Initial no order.
	        "ordering": false, //are column will be sortable or not
	        "lengthMenu": [[10, 25, 50, 100, -1], ["10", "25", "50", "100", "All"]],

	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo base_url('questionnaire/populate_list')?>",
	            "type": "POST"
	        },

	        //Set column definition initialisation properties.
	        "columnDefs": [
	        	{ 
	            	"targets": [ -1 ], //last column
	            	"orderable": false, //set not orderable
	        	},
	        ],
	    });
	});

	function reload_table(){
		table.ajax.reload(null,false); 
	}

    function validate_form(){
        var course_id = $("#course_id").val();
        if(course_id == '' || course_id.length <= 0 || course_id == 0){
            $("#course_id").focus();    
            $("#message").text("Select course");
            return false;
        }

        var lesson_id = $("#lesson_id").val();
        if(lesson_id == '' || lesson_id.length <= 0 || lesson_id == 0){
            $("#lesson_id").focus();    
            $("#message").text("Select lesson");
            return false;
        }

    	var title = $("#title").val();
    	if(title.trim() == '' || title.trim().length <= 0){
            $("#title").focus();    
            $("#message").text("Provide question");
            return false;
        } 
        
        var answer_1 = $("#answer_1").val();
        if(answer_1 == '' || answer_1.length <= 0){
            $("#answer_1").focus();    
            $("#message").text("Provide answer 1");
            return false;
        }
        
        var answer_2 = $("#answer_2").val();
        if(answer_2 == '' || answer_2.length <= 0){
            $("#message").text("Provide answer 2");
            return false;
        }

        var answer_3 = $("#answer_3").val();
        if(answer_3 == '' || answer_3.length <= 0){
            $("#message").text("Provide answer 3");
            return false;
        }

        var answer_4 = $("#answer_4").val();
        if(answer_4 == '' || answer_4.length <= 0){
            $("#message").text("Provide answer 4");
            return false;
        }

        var isChecked = $('#right_answer:checked').val() ? true : false;
	    if(isChecked == '' || isChecked == "false"){
            $("#message").text("Select right answer");
            return false;
        }

        return true;
    }

    function submit_form(){
        $("#message").removeClass("success").addClass("error").text("");

        if(!validate_form()){
            return;
        }

        $("#btn_submit").attr("disabled", true);
        $("#btn_reset").attr("disabled", true);        

        $("#loader").show();

        $.ajax({
            url: '<?php echo base_url('questionnaire/save')?>',	            
            type: 'POST',
            data: $('#questionnaire_form').serialize(),
            success: function(data) {
                var data = jQuery.parseJSON(data);
                $("#loader").hide();
                if(data.is_error == "false"){
                	reload_table();
                	clear_form_values("#questionnaire_form");

                	$("#message").removeClass("error").addClass("success").text(data.message);	

                	$("#lesson_id").html("<option value='0'>-- Select --</option>"); 
                } else if(data.is_error == "true"){	                	
                	$("#message").text(data.message);	                 
                }

                $("#btn_submit").removeAttr("disabled");
                $("#btn_reset").removeAttr("disabled");                
            },
            error: function(e) {
            	$("#loader").hide();
            	$("#message").text("Server side error occured.");

                $("#btn_submit").removeAttr("disabled");
                $("#btn_reset").removeAttr("disabled");             
            }
        });       
    }

    function clear_form(){
    	clear_form_values("#questionnaire_form");

    	$("#lesson_id").html("<option value='0'>-- Select --</option>");  
    }

    function populate_lesson_list(){
    	var course_id = $("#course_id").val();

    	if(course_id == 0 || course_id == ''){
    		$("#lesson_id").html("<option value='0'>-- Select --</option>"); 
    	} else {
    		$.ajax({
	            url: '<?php echo base_url('lesson/get_list_by_course_id')?>',
	            type: 'GET',
	            data: "course_id="+course_id,
	            success: function(data) {
	                var data = jQuery.parseJSON(data);
	                if(data.is_error == "false"){
	                	$("#lesson_id").html(data.lesson_list);                    
	                } else if(data.is_error == "true"){	                	
	                	$("#message").text(data.message);	                 
	                }              
	            },
	            error: function(e) {
	            	$("#message").text("Server side error occured.");    
	            }
	        });
    	}
    }

    function show_info_to_edit(questionnaire_id) {
    	$("#update_lesson_id").html("<option value='0'>-- Select --</option>");

    	$("#questionnaire_id").val("");                    
    	$("#update_title").val(""); 
    	$("#update_answer_1").val("");                    
    	$("#update_answer_2").val("");                    
    	$("#update_answer_3").val("");                    
    	$("#update_answer_4").val(""); 

    	$('#modal_div_to_update_info').modal('show');
    	// return;

    	$('input[type=update_right_answer]').removeAttr('checked');

    	$.ajax({
		    url: '<?php echo base_url('questionnaire/get_details_info')?>',	            
		    type: 'GET',
		    data: "questionnaire_id="+questionnaire_id,
		    success: function(data) {
		        var data = jQuery.parseJSON(data);

		        $("#questionnaire_id").val(questionnaire_id);

		        $("#update_lesson_id").html(data.lesson_list);

		        $("#update_title").val(data.title);                    
		    	$("#update_answer_1").val(data.answer_1);                    
		    	$("#update_answer_2").val(data.answer_2);                    
		    	$("#update_answer_3").val(data.answer_3);                    
		    	$("#update_answer_4").val(data.answer_4);

		    	$("input[name=update_right_answer][value=" + data.right_answer + "]").prop('checked', true);

		    	$("#update_course_id option[value="+ data.course_id +"]").attr("selected", "selected");
		        $("#update_lesson_id option[value="+ data.lesson_id +"]").attr("selected", "selected");
		    	
		        $('#modal_div_to_update_info').modal('show');
		    },
		    error: function(e) {
		    	$("#message").text("Server side error occured.");
		    }
		});			    
	}

	function populate_lesson_list_to_update(){
		$("#update_msg_span").text("");	  
    	var update_course_id = $("#update_course_id").val();

    	if(update_course_id == 0 || update_course_id == ''){
    		$("#update_lesson_id").html("<option value='0'>-- Select --</option>"); 
    	} else {
    		$.ajax({
	            url: '<?php echo base_url('lesson/get_list_by_course_id')?>',
	            type: 'GET',
	            data: "course_id="+update_course_id,
	            success: function(data) {
	                var data = jQuery.parseJSON(data);
	                if(data.is_error == "false"){
	                	$("#update_lesson_id").html(data.lesson_list);                    
	                } else if(data.is_error == "true"){	                	
	                	$("#update_msg_span").text(data.message);	                 
	                }              
	            },
	            error: function(e) {
	            	$("#update_msg_span").text("Server side error occured.");    
	            }
	        });
    	}
    }

    function validate_update_form(){
        var course_id = $("#update_course_id").val();
        if(course_id == null || course_id == '' || course_id.length <= 0 || course_id == 0){
            $("#update_msg_span").text("Select lesson");
            return false;
        }

        var lesson_id = $("#update_lesson_id").val();
        if(lesson_id == null || lesson_id == '' || lesson_id.length <= 0 || lesson_id == 0){
            $("#update_msg_span").text("Select lesson");
            return false;
        }

    	var update_title = $("#update_title").val().trim();
        if(update_title == null || update_title == '' || update_title.length <= 0){
            $("#update_ques_in_bn").focus();    
            $("#update_msg_span").text("Provide question");
            return false;
        }

        var answer_1 = $("#update_answer_1").val().trim();
        if(answer_1 == null || answer_1 == '' || answer_1.length <= 0){
            $("#update_answer_1").focus();    
            $("#update_msg_span").text("Provide answer 1");
            return false;
        }
        
        var answer_2 = $("#update_answer_2").val().trim();
        if(answer_2 == null || answer_2 == '' || answer_2.length <= 0){
            $("#update_answer_2").focus();    
            $("#update_msg_span").text("Provide answer 2");
            return false;
        }

        var answer_3 = $("#update_answer_3").val().trim();
        if(answer_3 == null || answer_3 == '' || answer_3.length <= 0){
            $("#update_answer_3").focus();    
            $("#update_msg_span").text("Provide answer 3");
            return false;
        }

        var answer_4 = $("#update_answer_4").val().trim();
        if(answer_4 == null || answer_4 == '' || answer_4.length <= 0){
            $("#update_answer_4").focus();    
            $("#update_msg_span").text("Provide answer 4");
            return false;
        }

        var isChecked = $('#update_right_answer:checked').val() ? true : false;
	    if(isChecked == null || isChecked == '' || isChecked == "false"){
            $("#update_msg_span").text("Select right answer");
            return false;
        }

        return true;
    }

    function update_questionnaire_form(){
        $("#update_msg_span").text("");

        if(!validate_update_form()){
            return;
        }

        $("#update_loader").show();

        $.ajax({
            url: '<?php echo base_url('questionnaire/update')?>',	            
            type: 'POST',
            data: $('#questionnaire_update_form').serialize(),
            success: function(data) {
                var data = jQuery.parseJSON(data);
                $("#update_loader").hide();
                if(data.is_error == "false"){
                	reload_table();    
                	$('#modal_div_to_update_info').modal('hide');
                } else if(data.is_error == "true"){	                	
                	$("#update_msg_span").text(data.message);	                 
                }             
            },
            error: function(e) {
            	$("#update_loader").hide();
            	$("#update_msg_span").text("Server side error occured.");
            }
        });       
    }

</script>