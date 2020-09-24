<?php include(__DIR__."/../template/header.php"); ?>

<div class="container" style="padding-top: 50px;padding-bottom: 100px;">
	<div class="row ques_form" id="ques_div" style="background-color: ivory; box-shadow: 0 0 8px 3px silver;margin-bottom: 20px;">			
		<div class="col-md-12" style="margin-top: 50px;margin-bottom: 20px;">
			<?php 
			$exam_ques_ids = "";

			for ($i = 0; $i < count($ques_ans); $i++) {
				$ques_id = $ques_ans[$i]['id'];
				$title = $ques_ans[$i]['title'];
				$answer_1 = $ques_ans[$i]['answer_1'];
				$answer_2 = $ques_ans[$i]['answer_2'];
				$answer_3 = $ques_ans[$i]['answer_3'];
				$answer_4 = $ques_ans[$i]['answer_4'];

				$exam_ques_ids .=$ques_id.",";
			?>

			<div class="col-md-12 ques-div" id="<?php echo ($i + 1); ?>" style="<?php if ($i != 0) echo 'display:none'; ?>">

				<div id="<?php echo "question_".$ques_id; ?>">
					<div class="col-md-12" style="font-size: 18px;" >
						<p>
							<span class="badge badge-primary badge-pill">
								<?php echo ($i+1); ?>
							</span>
							&nbsp;<?php echo $title; ?>
						</p>
					</div>

					<div class="col-md-6">
						<p class="answer" id="<?php echo $ques_id."_1"; ?>">
							<?php echo $answer_1; ?>
						</p>
					</div>	
					<div class="col-md-6">	
						<p class="answer" id="<?php echo $ques_id."_2"; ?>">
							<?php echo $answer_2; ?>
						</p>
					</div>
					<div class="col-md-6">
						<p class="answer" id="<?php echo $ques_id."_3"; ?>">
							<?php echo $answer_3; ?>
						</p>
					</div>	
					<div class="col-md-6">	
						<p class="answer" id="<?php echo $ques_id."_4"; ?>">
							<?php echo $answer_4; ?>
						</p>
					</div>

					<div class="col-md-12" style="padding:30px 0px 20px 0px;">
						<?php if($i > 0) { ?>
						<button type="button" class="btn btn-primary btn-previous" onclick="show_previous_question(<?php echo $i; ?>);"><i class="fa fa-chevron-left"></i> &nbsp;&nbsp;Previous </button>
						<?php } ?>

						<?php if($i < (count($ques_ans) - 1)) { ?>
						<button type="button" class="btn btn-primary btn-next" style="float: right;" onclick="show_next_question(<?php echo ($i + 2); ?>);">Next &nbsp;&nbsp;<i class="fa fa-chevron-right"></i></button>
						<?php } ?>
					</div>
				</div>
			</div>

			<?php } ?>
		</div>

		<form id="answer-form" class="clearfix">
			<input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id; ?>">
			<input type="hidden" name="lesson_id" id="lesson_id" value="<?php echo $lesson_id; ?>">
	        <input type="hidden" name="selected_answer" id="selected_answer" value="">	
	        <input type="hidden" name="exam_ques_ids" id="exam_ques_ids" value="<?php echo $exam_ques_ids; ?>">	
		</form>		
	</div>	

	<div class="row" id="btn_div">
		<div class="col-md-12 col-md-offset-4">
			<button type="button" class="btn btn-danger" id="btn_reset" onclick="confirm_reset_all_answer();"> Reset all answer </button>
			<button type="button" class="btn btn-success" id="btn_finish" onclick="finishexam();"> Finish Exam</button>
		</div>
	</div>

	<div class="row" id="processing-div" style="display: none;">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top: 20px;">
			<p style="font-size: 17px; text-align: center;">
				Exam result is evaluating. <br>Please wait a while ...
			</p>
		</div>			
		<div class="col-md-offset-5 col-lg-2 col-md-4 col-sm-4 col-xs-4">
	    	<img class="img-responsive" src="<?php echo base_url()?>asset/image/heartbeat.gif">
      	</div> 	      		
	</div>

	<div class="row" id="report_summary" style="display: none;">
		<div class="col-md-12" style="border-bottom: 1px solid gray;padding-bottom: 10px; margin-bottom: 20px; text-align:center;font-size:20px;">
			Congratulations!<br>Your result has been evaluated
    	</div>

		<div class="col-md-12">
			<table class="table table-responsive table-bordered table-striped" style="margin-top: 10px;">
	            <thead>
	                <tr style="background-color: lavender;">
	                    <th style="width: 5%;">#</th>
	                	<th style="width: 55%;">Question</th>
	                    <th style="width: 20%;">Right answer</th>
	                    <th style="width: 20%;">Given answer</th>
	                </tr>
	            </thead>
	            <tbody id="evaluation_report_table">
	            	
	            </tbody>
	        </table>
		</div>
	</div>	
</div>

<?php include(__DIR__."/../template/footer.php"); ?>

<script type="text/javascript">
	var selected_answer_arr = [];

	var current_ques_no = 1;

	$(document).ready(function(){
	    $("#report_summary").hide();
	    $("#processing-div").hide();
	});
	
	$(function() {
	    $('.answer').on('click', function() {
	    	var selected_ans = $(this).attr("id"); 

	    	var res = selected_ans.split("_");
	    	var ques_id = res[0];
	    	var ans_id = res[1];

	        if($(this).hasClass('selected')){//means remove ans

	        	$(this).removeClass('selected');
	        	$("#ans-track-btn-"+ques_id).removeClass('selected');

	        	//remove this from ans_array
	        	var index = selected_answer_arr.indexOf(selected_ans);
	        	selected_answer_arr.splice(index, 1);
	        } else {//means add/replace previous selected answer

	        	//first remove class from all 
	        	$("#question_"+ques_id).find('.selected').removeClass('selected');

	        	//after then add class in selected item
				$(this).addClass('selected');	        	
	        	$("#ans-track-btn-"+ques_id).addClass('selected');

	        	//first remove previous selected ans of question group
	        	for(var ans_no = 1; ans_no <= 4; ans_no++){
	        		var index = selected_answer_arr.indexOf(ques_id+"_"+ans_no);
	        		if(index >= 0){
						selected_answer_arr.splice(index, 1);
					}
	        	}
	        	//now add ans into array
	        	selected_answer_arr.push(selected_ans);
	        }
	    });

	    $('.ans-track-btn').on('click', function() {
	    	$(".ques-div").hide();
	    	var id = $(this).attr("value");
	    	$("#"+id).slideDown("slow");
	    });
	});

	function show_next_question(id) {
		$("#"+id).slideDown("slow");
		$("#"+(id-1)).slideUp("slow");
	}

	function show_previous_question(id){
		$("#"+(id+1)).slideUp("slow");
		$("#"+id).slideDown("slow");
	}

	function confirm_reset_all_answer(){
		if (confirm('Are you sure to reset all answers?')) {

			selected_answer_arr = [];
	    	$("#message").text("");
			$(".ques_form").find('.selected').removeClass('selected');
			$(".ans-track").find('.selected').removeClass('selected');		
		}
	}

	function finishexam(){
    	exam_started = false;

    	$("#message").text("");
    	$("#evaluation_report_table").html("");

    	if(selected_answer_arr.length == 0){
    		alert("Select at least 1 answer.");
    		return;
    	}

    	$("#selected_answer").val(selected_answer_arr);

    	$("#ques_div").hide();
    	$("#btn_div").hide();
		$("#processing-div").show();

		$.ajax({
            url: '<?php echo base_url('model_test/evaluate')?>',
            type: 'POST',
            data: $('#answer-form').serialize(),
            success: function(data) {      
            	$("#processing-div").hide();          
                var data = jQuery.parseJSON(data);
                if(data.is_error == "false"){
            		$(data.evaluation_summary).appendTo("#evaluation_report_table");

            		$("#processing-div").hide();
            		$("#report_summary").show();
                } else if(data.is_error == "true"){	                	
                	$("#message").text(data.message);	
                }              
            },
            error: function (jqXHR, exception) {    
            	$("#processing-div").hide(); 

            	$("#ques_div").show();
    			$("#btn_div").show(); 

            	alert(jqXHR.responseText);
            }
        });

        
    }
</script>