<?php include("template/header.php"); ?>

<div class="container" style="padding-top: 50px; min-height: 500px;">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 shadow-border" style="padding-bottom: 20px;margin-bottom:30px;">    
            <form id="study_form" class="clearfix">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Do Study</h3>
                    </div>
                </div>
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <p>Lesson</p>
                        <select class="input" id="lesson_id" name="lesson_id">
                            <option value="0">-- Select --</option>
                        </select>
                    </div>
                </div>        
                
                <div class="col-md-6">
                    <i class="fa fa-refresh fa-spin" id="loader"></i>
                    <p id="message"></p>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <p id="message" class="error" style="float: left;"></p>
                        <img id="loader" style="display: none;" src="<?php echo base_url('asset/image/loading.gif');?>">
                        <button type="button" class="btn btn-success" id="btn_submit" onclick="search_question();" style="float: right;"> <i class="fa fa-search"></i> Search Question</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-8 col-md-offset-2" id="table_data_div" style="display: none; ">
            <table class="table table-bordered table-hover" style="font-size: 15px;">
                <thead>
                    <tr style="background-color: lavender;">
                        <th style="width: 5%;">#</th>
                        <th style="width: 70%;">Question</th>
                        <th style="width: 25%;">Answer</th>
                    </tr>
                </thead>
                <tbody id="table_data">
                    
                </tbody>
            </table>
        </div>
    </div> 
</div>

<?php include("template/footer.php"); ?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#loader").hide();
	});

    function populate_lesson_list(){
        var course_id = $("#course_id").val();

        if(course_id == 0 || course_id == ''){
            $("#lesson_id").html("<option value='0'>-- Select --</option>"); 
        } else {

            $("#loader").show();

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

                    $("#loader").hide();             
                },
                error: function(e) {
                    $("#loader").hide();
                    $("#message").text("Server side error occured.");    
                }
            });
        }
    }

    function search_question(){
        $("#message").text("");

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

        $("#table_data").html("");

        $("#loader").show();
		$("#btn_submit").attr("disabled", true);

    	$.ajax({
            url: '<?php echo base_url('study/search_question')?>',
            type: 'POST',
            data: $('#study_form').serialize(),
            success: function(data) {
                $("#loader").hide();
                
                var data = jQuery.parseJSON(data);
                
                if(data.is_error == "false"){
                	$("#table_data_div").show();

                    $('#table_data').html(data.table_data).hide().fadeIn("slow");
                    
                } else if(data.is_error == "true"){	                	
                	$("#message").text(data.message);
                }  
                $("#btn_submit").removeAttr("disabled");            
            },
            error: function(jqXHR, error, errorThrown) {  
                $("#loader").hide();
                $("#message").text(errorThrown); 
                
                $("#modal_message").html(jqXHR.responseText);
                $('#error_modal').modal('show');
                $("#btn_submit").removeAttr("disabled");
            }
        });
    }

    
</script>