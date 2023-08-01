<?php
if ($this->session->userdata('username') == '') {
	redirect(site_url('Login'));
}

if ($this->session->userdata('role') == 1) {
	$role = 'admin';
}else{
	$role = 'non admin';
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('_partials/header.php') ?>
</head>
<?php $this->load->view('_partials/navbar.php') ?>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Attendance</h1>
		<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
			class="fa fa-user-plus fa-sm text-white-50"></i> Add New Record</a>
		</div>

		<!-- DataTales Example -->
		<div class="card shadow mb-4">
			<div class="card-header py-3">

			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Date</th>
								<th>Location</th>
								<th>User</th>
								<th>Employee</th>
								<th>Guest</th>
								<th>Total Guest</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>01/01/2022, 10:57 AM</td>
								<td>Grand Lobby</td>
								<td>Ratna Novita Sari</td>
								<td>KOESWANTO</td>
								<td>Sugiono</td>
								<td>3</td>
								<td>
									<button class="btn btn-success btn-circle btn-sm">
										<i class="fas fa-check"></i>
									</button> 
									<button class="btn btn-danger btn-circle btn-sm">
										<i class="fas fa-trash"></i>
									</button>
								</td>
							</tr>
							<tr>
								<td>01/01/2022, 10:57 AM</td>
								<td>Grand Lobby</td>
								<td>Ratna Novita Sari</td>
								<td>Hahahaha</td>
								<td>Wkwkwk</td>
								<td>5</td>
								<td>
									<a href="#" class="btn btn-success btn-circle btn-sm">
										<i class="fas fa-check"></i>
									</a> 
									<a href="#" class="btn btn-danger btn-circle btn-sm">
										<i class="fas fa-trash"></i>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>


	</div>
	<!-- /.container-fluid -->

	<!-- Add New Attendance Modal-->
	<div class="modal fade" id="attModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Attendance</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="user">
					<div class="form-group row">
						<div class="col-sm-6 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" id="guest_name"
							placeholder="Guest Name">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control form-control-user" id="identityNo"
							placeholder="No. KTP">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<input type="text" class="form-control form-control-user" id="phone"
							placeholder="Nomor Telepon">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control form-control-user" id="total"
							placeholder="Total Guest">
						</div>
					</div>
					<div class="form-group">
						<input type="text" class="form-control form-control-user" id="address"
						placeholder="Alamat">
					</div>
					camera ktp
					camera foto tamu
					
					<hr>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<button class="btn btn-primary" id="submitAtt">Submit</button>
			</div>
		</div>
	</div>
</div>

<!-- View Detail Attendance Modal-->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Detail Attendance</h5>
			<button class="close" type="button" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="modal-body">
			<form class="user">
					<div class="form-group row">
						<div class="col-sm-6 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" id="guest_name"
							placeholder="Guest Name">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control form-control-user" id="identityNo"
							placeholder="No. KTP">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<input type="text" class="form-control form-control-user" id="phone"
							placeholder="Nomor Telepon">
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control form-control-user" id="total"
							placeholder="Total Guest">
						</div>
					</div>
					<div class="form-group">
						<input type="text" class="form-control form-control-user" id="address"
						placeholder="Alamat">
					</div>
					camera ktp
					camera foto tamu
					
					<hr>
				</form>
		</div>
	</div>
</div>
</div>

<!-- Delete Attendance Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Are you sure to delete this data?</h5>
			<button class="close" type="button" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="modal-body">The data will deleted permanently.</div>
		<div class="modal-footer">
			<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
			<button class="btn btn-primary" id="deleteAtt">Delete</button>
		</div>
	</div>
</div>
</div>

</div>
<!-- End of Main Content -->
<?php $this->load->view('_partials/footer.php') ?>
<?php $this->load->view('_partials/js.php') ?>