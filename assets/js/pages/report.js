$( function () {
	reportTable();

	function reportTable(fDate='', tDate='', fLocation='', fEmp='') {
		var t = $('#dataTable').DataTable({
			"dom"       : "lBftipr",
			"processing": true,
			"language": {
				"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
			},
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": base_url + "report/view_report",
				"type": "POST",
				"data"			: {
					"fDate"		: fDate,
					"tDate"		: tDate,
					"fLocation"	: fLocation,
					"fEmp"		: fEmp,
				}
			},
			"searchDelay": 750,
	        "buttons"       : [{
	            'extend' : 'excel',
	            'text'   : '<i class="fas fa-download fa-sm text-white-50"></i> Export to Excel',
	            'attr'   : {
	                'class' : 'btn btn-md btn-primary'
	            },
	            'exportOptions' : {
	            	'columns' : [0,1,2,3,4,5]
	            }
	        }],
			"columnDefs": [{
				"targets": [6],
				"orderable": false,
				"className": "dt-body-center",
			}]
		});

		t.on('click', '#btn-viewatt', function (e) {
    	e.preventDefault();
        var row_id = $(this).data('id');
        $.ajax({
            url: base_url + "report/find",
            type: 'post',
            data: {
                'key': row_id
            },
            dataType: 'json',
            success: function(data) {
                if (data.type != 'done') {
                    var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
                    var sa_type = (data.type == 'done') ? "success" : "error";
                    Swal.fire({
                        title: sa_title,
                        type: sa_type,
                        html: data.msg
                    });
                } else {

                	$('#view_guestID').append('<option value="'+data.msg[0].guestID+'">'+data.msg[0].name+' - '+data.msg[0].phone+'</option>');
                	$('#view_emp_nip').append('<option value="'+data.msg[0].emp_nip+'">'+data.msg[0].emp_nip+' - '+data.msg[0].emp_name+'</option>');
                	$('#view_purpose').val(data.msg[0].purpose);
                	$('#view_total_guest').val(data.msg[0].total_guest);
                	$('#view_detail_employee').val( data.msg[0].emp_nip + ' - ' + data.msg[0].emp_name );
                	$('#view_detail_employee_department').val( data.emp_dept );
                	$('#view_detail_guest').val( data.msg[0].name + ' - ' + data.msg[0].phone );
                	$('#view_detail_guest_address').val( data.msg[0].address );
                	$('#view_detail_identityPhoto').attr('src', base_url + data.msg[0].identityPhoto);
                	$('#view_detail_photo').attr('src', base_url + data.msg[0].photo);

                    var mod = $('#exampleModal3');
                    mod.modal('show');
                }
            },
            error: function() {
                Swal.fire("(500)", "Error Occurred, Please refresh your browser.", "error");
            }
        });
    });

		t.on('click', '#btn-deleteatt', function (e) {
			e.preventDefault();
			var row_id = $(this).data('id');
			Swal.fire({
				title: 'Hapus data !',
				type: 'warning',
				html: '<span class="italic">Apakah anda yakin ingin menghapus data kunjungan ini ?</span>',
				showCancelButton: true,
				confirmButtonText: "Ya, Hapus!",
				cancelButtonText: "Batalkan",
				confirmButtonColor: "#DD6B55",
				showLoaderOnConfirm: true,
			}).then(function(result) {
				if (result.value) {
					$.ajax({
						url: base_url + "report/delete",
						type: 'post',
						data: {
							'key': row_id
						},
						dataType: 'json',
						success: function(data) {
							var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
							var sa_type = (data.type == 'done') ? "success" : "error";
							Swal.fire({
								title: sa_title,
								type: sa_type,
								html: data.msg
							}).then(function() {
								if (data.type == 'done') window.location.reload();
							});
						}
					});
				} else {
					Swal.fire('Dibatalkan', '', 'warning');
				}
			});
		});
	}

	$('#btn-filter').on('click', function () {
		var fDate = $('#fDate').val();
		var tDate = $('#tDate').val();
		var fLocation = $('#fLocation').val();
		var fEmp = $('#fEmp').val();

		$('#dataTable').DataTable().destroy();
		reportTable(fDate, tDate, fLocation, fEmp);

	});

	$('.btn-reset').on('click', function () {
		$('#fDate').val('');
		$('#tDate').val('');
		$('#fLocation').val('');
		$('#fEmp').val('');

		$('#dataTable').DataTable().destroy();
		reportTable();
	});

	$('#btn-viewatt').on('click', function () {

		$('#viewModal').modal('show');
	});

	$('#btn-deleteatt').on('click', function () {

		$('#deleteModal').modal('show');
	});
});