<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="modal fade" id="cp-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width: 700px;">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="user" id="cp-form" accept-charset="UTF-8" method="POST">
					<div class="form-group row">
						<div class="col-sm-12">
							<input type="password" class="form-control form-control-user" id="oldpassword" name="oldpassword" placeholder="Old Password">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12">
							<input type="password" class="form-control form-control-user" id="newpassword" name="newpassword" placeholder="New Password">
						</div>
					</div>
					<input type="checkbox" name="show_pass" id="show_pass"> Show Password
					<div class="modal-footer">
						<input type="text" class="collapse" id="type" name="type" value="">
						<input type="text" class="collapse" id="id" name="id" value="">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
						<button class="btn btn-primary" type="submit" id="btn-submitcp">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Footer -->
<footer class="sticky-footer bg-white">
	<div class="container my-auto">
		<div class="copyright text-center my-auto">
			<span>Copyright &copy; MIS 2022</span>
		</div>
	</div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
	<i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
			<button class="close" type="button" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
		<div class="modal-footer">
			<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
			<a class="btn btn-primary" href="login.html">Logout</a>
		</div>
	</div>
</div>
</div>

<!-- Bootstrap core JavaScript-->
<script type="text/javascript"> var base_url = "<?php echo base_url(); ?>" </script>
<!-- Jquery JS-->
<script src="<?php echo base_url(); ?>assets/vendor/jquery-3.2.1.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->

<!-- Page level plugins -->
<script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/pdfmake/vfs_fonts.js"></script>

<!-- Page Script -->
<script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>
<?php 
if ( isset($js) ) {
	for ( $i = 0; $i < sizeof($js); $i++) { 
		?>
		<script src="<?= $js[$i] ?>"></script>
		<?php 
	}
}
?>

<script type="text/javascript">
	$( function () {
		
		$('#btn-cp').on('click', function (e) {
			e.preventDefault();

			$('#cp-modal').modal('show');
		});

		$('#show_pass').on('change', function (e) {
			e.preventDefault();

			if ( $('#show_pass').is(':checked') ) {
				$('#oldpassword').attr('type', 'text');
				$('#newpassword').attr('type', 'text');
			}else{
				$('#oldpassword').attr('type', 'password');
				$('#newpassword').attr('type', 'password');
			}
		});

	    $("#cp-form").ajaxForm({
	        dataType: "json",
	        url: base_url + 'site/change_password',
	        beforeSubmit: function() {
	            $('#btn-submitcp').removeClass('btn-primary').addClass('btn-warning').prop('disabled', true);
	        },
	        success: function(data) {
	            var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
	            var sa_type = (data.type == 'done') ? "success" : "warning";
	            Swal.fire({
	                title: sa_title,
	                type: sa_type,
	                html: data.msg
	            }).then(function() {
	                if (data.type == 'done') window.location.reload();
	            });
	        },
	        error: function() {
	            Swal.fire("Failed!", "Error Occurred, Please refresh your browser.", "error");
	        },
	        complete: function() {
	            $('#btn-submitcp').removeClass('btn-warning').addClass('btn-primary').prop('disabled', false);
	        }
	    });
	});
</script>

</body>
</html>