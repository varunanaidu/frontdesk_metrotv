<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">User</h1>
		<!-- SESUAIKAN DENGAN ID DI TABLE USERRROLE -->
		<?php 
		if ( $log_role == 1 ) {
		 ?>
			<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btn-addnewuser">
				<i class="fa fa-user-plus fa-sm text-white-50"></i> Add New User
			</button>
		 <?php 
		}
		  ?>
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
							<th>Action</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>


</div>
<!-- /.container-fluid -->

<!-- Add New user Modal-->
<div class="modal fade" id="user-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width: 700px;">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">User - <span id="modal-type">Add</span></h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="user" id="user-form" accept-charset="UTF-8" method="POST">
					<div class="form-group row">
						<div class="col-sm-12">
							<label>Username</label>
							<input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12">
							<label>Full Name</label>
							<input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full Name">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12">
							<label>Role</label>
							<select name="roleID" id="roleID" class="form-control form-control-user">
								<option value="">Pilih Role</option>
								<?php 
									if ( isset($role) and $role != 0 ) {
										foreach ($role as $row) {
								?>
								<option value="<?= $row->id ?>"><?= $row->role_name ?></option>
								<?php 
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<input type="text" class="collapse" id="type" name="type" value="">
						<input type="text" class="collapse" id="id" name="id" value="">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
						<button class="btn btn-primary" type="submit" id="btn-submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<!-- End of Main Content -->