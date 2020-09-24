<?php include(__DIR__."/../template/header.php"); ?>


<div class="container" style="padding-top: 50px;padding-bottom: 100px;">
	<div class="row">
		<div class="col-md-12" style="border-bottom: 1px solid gray;padding-bottom: 10px; margin-bottom: 20px; text-align:center;font-size:20px;">
			Your Exam's Evaluation Report
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
	            <tbody>
	            	<?php echo $evaluation_report; ?>
	            </tbody>
	        </table>
		</div>
	</div>	
</div>

<?php include(__DIR__."/../template/footer.php"); ?>