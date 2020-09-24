<?php include(__DIR__."/../template/header.php"); ?>

<!-- section -->
<div class="container" style="padding-top: 50px; min-height: 500px;">
	<div class="container">
        <h3 style="text-align: center;padding-bottom: 20px;">List of registered user</h3>
		<table id="custom_table" class="table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
                <tr style="background-color: lavender;">
                    <th style="width: 10%;text-align: center;">#</th>
				    <th style="width: 20%;">Full name</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 30%; text-align: center;">Registered on</th>
                    <th style="width: 15%; text-align: center;">Total Test</th>
                </tr>
            </thead>
            <tbody>
            	<?php echo $app_user_info; ?>
            </tbody>
        </table>
	</div>
</div>
<!-- /section -->

<?php include(__DIR__."/../template/footer.php"); ?>
