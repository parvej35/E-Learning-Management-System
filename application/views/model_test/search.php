<?php include(__DIR__."/../template/header.php"); ?>

<div class="container" style="padding-top: 50px; min-height: 500px;">
    <div class="row search_div" style="min-height: 450px;">
        <div class="col-md-6 col-md-offset-3 shadow-border" style="padding-bottom: 20px;margin-bottom:30px; ">    
            <form id="study_form" class="clearfix">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Search Topic For Exam</h3>
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
                    <p id="message" class="error"><?php if(isset($message)) echo $message; ?></p>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <p id="message" class="error" style="float: left;"></p>
                        <img id="loader" style="display: none;" src="<?php echo base_url('asset/image/loading.gif');?>">
                        <button type="button" class="btn btn-success" id="btn_submit" onclick="search_question();" style="float: right;"> Start Test</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 
</div>

<?php include(__DIR__."/../template/footer.php"); ?>

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

        var param = "course_id="+course_id+"&lesson_id="+lesson_id;
        window.location.href = "<?php echo base_url();?>model_test/exam?"+param;     

        
    }

    
</script>