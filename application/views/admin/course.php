<?php include(__DIR__."/../template/header.php"); ?>

<!-- section -->
<div class="section">
	<div class="container" style="padding-top: 50px;">
		<div class="row">
			<div class="col-md-6 col-md-offset-3 shadow-border">	
				<form id="course_form" class="clearfix">
					<div class="col-md-12">
						<div class="section-title">
							<h4 class="title">Course Information</h4>
						</div>
					</div>
					<div class="col-md-12">					
						<div class="form-group">
							<p>Name</p>
							<input class="input" type="text" id="name" name="name" value="">
							<input class="input" type="hidden" id="id" name="id" value="">
						</div>
					</div>	
					<div class="col-md-6">
						<i class="fa fa-refresh fa-spin" id="loader"></i>
						<p id="message"></p>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<button type="button" class="btn btn-danger" id="btn_reset" onclick="clear_form();"><i class="fa fa-close"></i> Reset </button>
							<button type="button" class="btn btn-success" id="btn_submit" onclick="submit_form();" style="float: right;"> <i class="fa fa-check-square-o"> Save </i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /section -->

<!-- section -->
<div class="section">
	<div class="container">
        <button class="btn btn-info" onclick="reload_table()">
        	<i class="fa fa-refresh"></i> Reload
        </button>

        <br><br>

        <table id="data_table" class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr style="background-color: lavender;">
                	<th style="width: 5%;">ID</th>
                    <th style="width: 80%;">Course Name</th>
                    <th style="width: 15%;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
	</div>
</div>
<!-- /section -->

<?php include(__DIR__."/../template/footer.php"); ?>

<script type="text/javascript">
	var table;

	$(document).ready(function(){
		$("#loader").hide();

		table = $('#data_table').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [], //Initial no order.
	        "ordering": false, //are column will be sortable or not

	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo base_url('course/populate_list')?>",
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

    function submit_form(){
        $("#message").text("");

        var name = $("#name").val();
    	name = $.trim(name);
        if(name == null || name == '' || name.length <= 0){
            $("#name").focus();    
            $("#message").text("Name is required");
            return false;
        }

        $("#btn_submit").attr("disabled", true);
        $("#btn_reset").attr("disabled", true);        

        $("#loader").show();

        $.ajax({
            url: '<?php echo base_url('course/save')?>',	            
            type: 'POST',
            data: $('#course_form').serialize(),
            success: function(data) {
                var data = jQuery.parseJSON(data);
                $("#loader").hide();
                if(data.is_error == "false"){
                	clear_form();
                	reload_table();
                	
                	$("#name").val('');	                    
                	$("#message").text(data.message);	                    

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

    function show_course(id) {
    	clear_form();

    	$("#loader").show();

    	$.ajax({
            url: '<?php echo base_url('course/get_by_id')?>',	
            type: 'GET',
            data: "id="+id,
            success: function(data) {
                var data = jQuery.parseJSON(data);
                if(data.is_error == "false"){
                	$("#id").val(id);
			        $("#name").val(data.name);

			        $("#message").text('');
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

	function delete_course(id) {
		if (confirm('Are you sure to delete this course?')) {
			
			$("#loader").show();

	    	$.ajax({
	            url: '<?php echo base_url('course/delete')?>',	
	            type: 'GET',
	            data: "id="+id,
	            success: function(data) {
	                var data = jQuery.parseJSON(data);
	                if(data.is_error == "false"){
	                	
	                	clear_form();
	                	reload_table();

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


	function clear_form() {
		$("#id").val('');
		$("#name").val('');
		$("#message").text('');

		$("#btn_submit").removeAttr("disabled");
		$("#btn_reset").removeAttr("disabled");     		
	}
    
</script>