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
	    height: calc(1.5em + 0.75rem + 2px);
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
		<h1 class="h3 mb-0 text-gray-800">Attendance</h1>
		<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btn-addnew">
			<i class="fa fa-user-plus fa-sm text-white-50"></i> Add New Record
		</button>
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

<!-- Add New Attendance Modal-->
<div class="modal fade" id="attModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width: 700px;">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Attendance</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="attendance-form" class="user" accept-charset="UTF-8">
					<div class="form-group row">
						<div class="col-sm-6 form-control form-control-user">
							<select name="emp_nip" class="" id="emp_nip"></select>
						</div>
						<div class="col-sm-6 form-control form-control-user">
							<select name="guestID" id="guestID" class=""></select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<input type="text" name="purpose" class="form-control form-control-user" id="purpose" placeholder="Tujuan">
						</div>
						<div class="col-sm-6">
							<input type="number" name="total_guest" class="form-control form-control-user" id="total_guest" placeholder="Jumlah Tamu">
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="guest_id" id="guest_id">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
						<button class="btn btn-primary" type="submit" id="submitAtt">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Add new guest if not exists modal -->
<div class="modal fade" id="exampleModal2" aria-labelledby="exampleModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 700px;">
            <form id="guest-form" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal2Label">Add New Guest Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12">
                        	<input type="text" name="name" id="name" class="form-control form-control-user" placeholder="Name" required>
                    	</div>
                    </div>
					<div class="form-group row">
						<div class="col-sm-6">
								<input type="text" class="form-control form-control-user" id="identityNo" name="identityNo" placeholder="No. KTP" required>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control form-control-user" id="phone" name="phone" placeholder="Nomor Telepon" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<input type="text" class="form-control form-control-user" id="address" name="address" placeholder="Alamat">
						</div>
					</div>
                    <div class="form-group row">
                    	<div class="col-sm-12">
	                    	<label>Foto KTP</label>
	                        <video id="video" width="450" height="480" autoplay></video>
	                        <button class="btn btn-primary" id="snap">Snap Photo</button>
	                        <canvas class="" id="canvas" width="450" height="480"></canvas>
	                        <input type="file" class="collapse" name="identityPhoto" id="identityPhoto">
	                     </div>
                    </div>
                    <div class="form-group row">
                    	<div class="col-sm-12">
	                    	<label>Foto Tamu</label>
	                        <video id="video2" width="450" height="480" autoplay></video>
	                        <button class="btn btn-primary" id="snap2">Snap Photo</button>
	                        <canvas id="canvas2" width="450" height="480"></canvas>
	                        <input type="file" class="collapse" name="photo" id="photo">
	                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit2">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

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