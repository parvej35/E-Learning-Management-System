<?php include("template/header.php"); ?>

<div class="container" style="padding-top: 50px; min-height: 500px;">
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-primary" style="min-height: 320px;">
                    <div class="panel-heading">
                        <i class="fa fa-bars fa-fw"></i> Your Perticipated Test Report
                    </div>                
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <?php 
                                    if(isset($evaluation_report) && count($evaluation_report) > 0 ) { 
                                        echo "<tr style='background-color:#F5F5F5;'><td style='width: 5%;text-align:center;'>#</td><td style='width: 25%;'>Exam Date</td><td style='width: 30%;'>Course Name</td><td style='width: 30%;'>Lesson Name</td><td style='width: 10%;'></td></tr>";

                                        for ($i = 0; $i < count($evaluation_report); $i++) {
                                            $report = $evaluation_report[$i];
                                            
                                            echo "<tr><td style='width: 5%;text-align:center;'>".($i+1)."</td><td style='width: 25%;'>".$report->exam_date."</td><td style='width: 30%;'>".$report->course_name."</td><td style='width: 30%;'>".$report->lesson_name."</td><td style='width: 10%;'><a class='btn btn-xs btn-success' href='javascript:void();' title='Show report' onclick='show_evaluation_report(".$report->id.")'>Details</a></td></tr>";
                                        }
                                    } else { 
                                        echo "<tr><td style='width: 100%;'>You did not perticipate in any Model Tet <i class='fa fa-frown-o' style='color:red;font-size:24px;'></i></td></tr>";
                                    }
                                        
                                    ?>     
                                </tbody>                        
                            </table>
                        </div>  
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<?php include("template/footer.php"); ?>

<script type="text/javascript">
    function show_evaluation_report(id){
        window.open("<?php echo base_url();?>model_test/report?id=" +id, "_blank");
    }
</script>    


