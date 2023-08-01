<script>
	$(document).ready(function() {
		$('#changePBtn').click(function() {
			window.location.href = '<?php echo site_url('LoginController/change_P') ?>';
		});

		$('#outBtn').click(function() {
			window.location.href = '<?php echo site_url('LoginController/logout') ?>';
		});

		$('#attBtn').click(function() {
			window.location.href = '<?php echo site_url('Attendance') ?>';
		});

		$('#locBtn').click(function() {
			window.location.href = '<?php echo site_url('Location') ?>';
		});

		$('#UserBtn').click(function() {
			window.location.href = '<?php echo site_url('User') ?>';
		});

		$('#addUserBtn').click(function() {
			window.location.href = '<?php echo site_url('LoginController/addUserPage') ?>';
		});
	});
</script>