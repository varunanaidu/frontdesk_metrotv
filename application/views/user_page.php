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
		<h1 class="h3 mb-0 text-gray-800">User</h1>
		<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
			class="fa fa-user-plus fa-sm text-white-50"></i> Add New User</a>
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
								<th>Name</th>
								<th>Operator</th>
								<th>Receptionist</th>
								<th>Admin</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Ratna Novita Sari</td>
								<td>
									<label class="switch">
										<input type="checkbox">
										<span class="slider round"></span>
									</label>
								</td>
								<td>
									<label class="switch">
										<input type="checkbox">
										<span class="slider round"></span>
									</label>
								</td>
								<td>
									<label class="switch">
										<input type="checkbox">
										<span class="slider round"></span>
									</label>
								</td>
								<td>
									<button class="btn btn-success btn-circle btn-sm">
										<i class="fa fa-pencil"></i>
									</button> 
									<button class="btn btn-danger btn-circle btn-sm">
										<i class="fas fa-trash"></i>
									</button>
								</td>
							</tr>
							<tr>
								<td>Udin</td>
								<td>
									<label class="switch">
										<input type="checkbox">
										<span class="slider round"></span>
									</label>
								</td>
								<td>
									<label class="switch">
										<input type="checkbox">
										<span class="slider round"></span>
									</label>
								</td>
								<td>
									<label class="switch">
										<input type="checkbox">
										<span class="slider round"></span>
									</label>
								</td>
								<td>
									<button class="btn btn-success btn-circle btn-sm">
										<i class="fa fa-pencil"></i>
									</button> 
									<button class="btn btn-danger btn-circle btn-sm">
										<i class="fas fa-trash"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
	<!-- /.container-fluid -->

<!-- Edit User Modal-->
	<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit User Data</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="user">
					<div class="form-group row">
						<div class="col-sm-4 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" id="name"
							placeholder="Name">
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control form-control-user" id="username"
							placeholder="username">
						</div>
					</div>
					<hr>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<button class="btn btn-primary" id="editUser">Edit</button>
			</div>
		</div>
	</div>
</div>

<!-- Delete User Modal-->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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

	<!-- End of Main Content -->
	<?php $this->load->view('_partials/footer.php') ?>
	<?php $this->load->view('_partials/js.php') ?>