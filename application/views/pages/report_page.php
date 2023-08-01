<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Begin Page Content -->
<style type="text/css">
	.select2-container--default .select2-selection--single {
		background-color: transparent; !important ;
		margin-top: -20px !important;
		border: 1px solid transparent;
		width: 320px !important;
		border-radius: 4px;
	}
	.select2-container--default .select2-selection--single .select2-selection__arrow b {
		border-color: #888 transparent transparent transparent;
		border-style: solid;
		border-width: 5px 4px 0 4px;
		height: 0;
		left: 50%;
		margin-left: -4px;
		margin-top: -20px !important;
		position: absolute;
		top: 50%;
		width: 0;
	}
	.form-control {
		display: block;
		width: 100%;
		
		padding: 1.5rem 0.75rem !important;
		font-size: 1rem;
		font-weight: 400;
		line-height: 1.5;
		color: #6e707e;
		background-clip: padding-box;
		border: 1px solid #d1d3e2;
		border-radius: 107.35rem !important;
		transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
</style>
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Report</h1>
		<!-- <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btn-addnew">
			<i class="fa fa-user-plus fa-sm text-white-50"></i> Add New Record
		</button> -->
	</div>

	<div class="card-body">
		<div class="row">
			<div class="col-md-3 form-group">
				<label>From</label>
				<input type="date" class="form-control" name="fDate" id="fDate">
			</div>
			<div class="col-md-3 form-group">
				<label>To</label>
				<input type="date" class="form-control" name="tDate" id="tDate">
			</div>
			<div class="col-md-3 form-group">
				<label>Location</label>
                <select name="fLocation" class="form-control form-control-user" id="fLocation">
                    <option value="">Pilih Lokasi</option>
                    <?php 
                    if ( isset($location) and $location != 0 ) {
                        foreach ($location as $row) {
                            ?>
                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                            <?php 
                        }
                    }
                    ?>

                </select>
			</div>
			<div class="col-md-3 form-group">
				<label>Employee</label>
                <select name="fEmp" class="form-control form-control-user" id="fEmp">
                    <option value="">Pilih Karyawan</option>
                    <?php 
                    if ( isset($emp) and $emp != 0 ) {
                        foreach ($emp as $row) {
                            ?>
                            <option value="<?= $row->emp_nip ?>"><?= $row->emp_name ?></option>
                            <?php 
                        }
                    }
                    ?>

                </select>
			</div>
			<div class="col-md-3">
				<button type="button" class="btn btn-primary btn-md btn-submit" id="btn-filter">Filter</button>
				<button type="button" class="btn btn-danger btn-md btn-reset">Reset</button>
			</div>
		</div>
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
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>


</div>
<!-- /.container-fluid -->


<!-- View Detail Attendance-->
<div class="modal fade" id="exampleModal3" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width: 1000px; margin-left: -225px;">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModal3Label">View Detail Attendance</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body">
				<!-- <div class="form-group row">
					<div class="col-sm-6">
						<select name="view_emp_nip" class="form-control form-control-user" id="view_emp_nip" disabled></select>
					</div>
					<div class="col-sm-6">
						<select name="view_guestID" id="view_guestID" class="form-control form-control-user" disabled></select>
					</div>
				</div> -->
				<div class="form-group row">
					<div class="col-sm-6">
						<label class="col-sm-6">Tujuan</label>
						<input type="text" name="view_purpose" class="form-control form-control-user" id="view_purpose" placeholder="Tujuan" readonly>
					</div>
					<div class="col-sm-6">
						<label class="col-sm-6">Jumlah Tamu</label>
						<input type="number" name="view_total_guest" class="form-control form-control-user" id="view_total_guest" placeholder="Jumlah Tamu" readonly>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label class="col-sm-6">NIP - Nama Employee</label>
						<input type="text" name="view_detail_employee" class="form-control form-control-user" id="view_detail_employee" placeholder="" readonly>
					</div>
					<div class="col-sm-6">
						<label class="col-sm-6">Departemen Employee</label>
						<input type="text" name="view_detail_employee_department" class="form-control form-control-user" id="view_detail_employee_department" placeholder="" readonly>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label class="col-sm-6">Nama - No.HP Tamu</label>
						<input type="text" name="view_detail_guest" class="form-control form-control-user" id="view_detail_guest" placeholder="" readonly>
					</div>
					<div class="col-sm-6">
						<label class="col-sm-6">Alamat Tamu</label>
						<input type="text" name="view_detail_guest_address" class="form-control form-control-user" id="view_detail_guest_address" placeholder="" readonly>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label class="col-sm-6">Foto Tamu</label>
						<img src="" id="view_detail_identityPhoto">
					</div>
					<div class="col-sm-6">
						<label class="col-sm-6">Foto KTP Tamu</label>
						<img src="" id="view_detail_photo">
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Delete Attendance Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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