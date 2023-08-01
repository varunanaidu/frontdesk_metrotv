$( function () {

    var t = $('#dataTable').DataTable({
        "processing": true,
        "language": {
            "processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
        },
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + "attendance/view",
            "type": "POST"
        },
        "searchDelay": 750,
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
            url: base_url + "attendance/find",
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
                    url: base_url + "attendance/delete",
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
	
    $("#emp_nip").select2({
        placeholder: "Employee Name",
        minimumInputLength: 2,
        // allowClear: true,
        ajax: {
            url: base_url + "attendance/search_emp",
            dataType: "json",
            delay: 250,
            processResults: function(data) {
            	console.log(data);
                return {
                    results: data
                };
            },
            cache: true,
        },
        dropdownParent: $('#attModal'),
    });
	
    $("#guestID").select2({
        placeholder: "Guest Name",
        minimumInputLength: 2,
        // allowClear: true,
        ajax: {
            url: base_url + "attendance/search_guest",
            dataType: "json",
            delay: 250,
            processResults: function(data) {
            	console.log(data);
                return {
                    results: data
                };
            },
            cache: true,
        },
        dropdownParent: $('#attModal'),
        language: {
        	noResults: function() {
        		return `No Data Found</li><li><button style="width: 100%" type="button" class="btn btn-primary" id="btn-add-guest">+ Add New Item</button></li>`;
        	}
         },
       
        escapeMarkup: function (markup) {
            return markup;
        }
    });

    $('#view_emp_nip').select2();
    $('#view_guestID').select2();

	$(document).on('click', '#btn-add-guest', function () {
		
		$('#exampleModal2').modal('show');
		
		// Grab elements, create settings, etc.
		var video = document.getElementById('video');
		var video2 = document.getElementById('video2');

		// Get access to the camera!
		if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
		    // Not adding `{ audio: true }` since we only want video now
		    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
		        //video.src = window.URL.createObjectURL(stream);
		        video.srcObject = stream;
		        video.play();
		    });
		}
		// Get access to the camera!
		if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
		    // Not adding `{ audio: true }` since we only want video now
		    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
		        //video.src = window.URL.createObjectURL(stream);
		        video2.srcObject = stream;
		        video2.play();
		    });
		}
	});

	$('#snap').on('click', function (e) {
		e.preventDefault();
		
		var video = document.getElementById('video');		
		var canvas = document.getElementById('canvas');
		var context = canvas.getContext('2d')

		context.drawImage(video, 0, 0, 450, 480);

		canvas.toBlob( (blob) => {
			const file = new File( [blob], 'identityPhoto.png' );
			const dT = new DataTransfer();
			dT.items.add( file );
			document.getElementById('identityPhoto').files = dT.files;
		});
	});

	$('#snap2').on('click', function (e) {
		e.preventDefault();
		
		var video2 = document.getElementById('video2');		
		var canvas2 = document.getElementById('canvas2');
		var context2 = canvas2.getContext('2d')

		context2.drawImage(video2, 0, 0, 450, 480);

		canvas2.toBlob( (blob) => {
			const file = new File( [blob], 'photo.png' );
			const dT = new DataTransfer();
			dT.items.add( file );
			document.getElementById('photo').files = dT.files;
		});
	});

	$('#guest-form').on('submit', function (e) {
		e.preventDefault();

    	var formData = new FormData(this);

    	var name = $('#name').val();
    	var phone = $('#phone').val();

    	$.ajax({
			url : base_url + 'attendance/save_guest',
			type : "POST",
			dataType : "JSON",
			cache: false,
			contentType: false,
			processData: false,
			data : formData,
			beforeSend : function(){
				$("#btn-submit2").html ( 'Processing...' ).removeClass("btn-primary").addClass("btn-warning").prop("disabled", true);
			},
			success : function(data){
				if ( data.type == "done" ){
					Swal.fire({title : "Success", html : data.msg, type : "success"}).then( function () {
						$('#exampleModal2').modal('hide');
						$('#guest_id').val(data.guestID);
						$('#guestID').append('<option value="'+data.guestID+'">'+name+' - '+phone+'</option>');
						$("#btn-submit2").html ( 'Save changes' ).removeClass("btn-warning").addClass("btn-primary").prop("disabled", false);
						$('#guest-form').trigger('reset');

						var canvas = document.getElementById('canvas');
						var canvas2 = document.getElementById('canvas2');
						var context = canvas.getContext('2d');
						var context2 = canvas2.getContext('2d');
						context.clearRect(0, 0, canvas.width, canvas.height);
						context2.clearRect(0, 0, canvas2.width, canvas2.height);
					});
				}
				else{
					Swal.fire ( "Failed!", data.msg, "error");
					$("#btn-submit2").html ( 'Save changes' ).removeClass("btn-warning").addClass("btn-primary").prop("disabled", false);
				}				
			},
			error : function(){
				Swal.fire ( "Failed!", "Error Occurred, Please refresh your browser.", "error");
				$("#btn-submit2").html ( 'Save changes' ).removeClass("btn-warning").addClass("btn-primary").prop("disabled", false);
			},
			complete : function(){
				// $("#btn-submit2").html ( 'Save Changes' ).removeClass("btn-warning").addClass("btn-primary").prop("disabled", false);
			}
		});
	});

	$('#attendance-form').on('submit', function (e) {
		e.preventDefault();

    	var formData = new FormData(this);

    	$.ajax({
			url : base_url + 'attendance/save_attendance',
			type : "POST",
			dataType : "JSON",
			cache: false,
			contentType: false,
			processData: false,
			data : formData,
			beforeSend : function(){
				$("#submitAtt").html ( 'Processing...' ).removeClass("btn-primary").addClass("btn-warning").prop("disabled", true);
			},
			success : function(data){
				if ( data.type == "done" ){
					Swal.fire({title : "Success", html : data.msg, type : "success"}).then( function () {
						window.location.href = base_url;
					});
				}
				else{
					Swal.fire ( "Failed!", data.msg, "error");
					$("#submitAtt").html ( 'Save changes' ).removeClass("btn-warning").addClass("btn-primary").prop("disabled", false);
				}				
			},
			error : function(){
				Swal.fire ( "Failed!", "Error Occurred, Please refresh your browser.", "error");
				$("#submitAtt").html ( 'Save Changes' ).removeClass("btn-warning").addClass("btn-primary").prop("disabled", false);
			},
			complete : function(){
				// $("#submitAtt").html ( 'Save Changes' ).removeClass("btn-warning").addClass("btn-primary").prop("disabled", false);
			}
		});
	});


	$('#btn-addnew').on('click', function () {
		
		$('#attModal').modal('show');
	});

	$('#btn-viewatt').on('click', function () {
		
		$('#viewModal').modal('show');
	});

	$('#btn-deleteatt').on('click', function () {
		
		$('#deleteModal').modal('show');
	});

});