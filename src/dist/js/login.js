$(document).ready(function () {
  let tanggal = localStorage.getItem('tanggal');
  if (tanggal) {
    location.href=hostname
  }
  $(document).on('click','.btnsyncron',function(e){
    e.preventDefault();

  })
    $('.formlogin').submit(function (e) { 
    e.preventDefault();
    let formdata = $('.formlogin').serialize(),
    tanggal = $('input[name=tanggallogin]').val(),
    store = $('select[name=storelogin]').val();
    $.ajax({
			type: "POST",
			url: hostname + "Auth/loginproses",
			data: formdata,
			cache: false,
			processData: false,
			dataType: "json",
			success: function (response) {
				if (response.sukses) {
          localStorage.setItem('tanggal',tanggal);
          localStorage.setItem('store',store);
          location.href=hostname
				} else if (response.gagal) {
					Swal.fire({
						text: response.gagal,
						icon: "info",
						showCancelButton: false,
						confirmButton: true,
					}).then(function () {
            $('input[name=niklogin]').val("");
            $('input[name=passwordlogin]').val("");
					});
				}
			},
			error: function (jqXHR, error, errorThrown) {
				if (jqXHR.status && jqXHR.status == 500) {
					Swal.fire({
						text: "Mohon Maaf Server Sedang Down.",
						icon: "error",
						showCancelButton: false,
						confirmButton: true,
					});
				} else {
					Swal.fire({
						text: "Terjadi konflik data.",
						icon: "error",
						showCancelButton: false,
						confirmButton: true,
					});
				}
			},
		});
  });
   $(".clock").datetimepicker({
		lang: "en",
		timepicker: false,
		format: "Y-m-d",
		formatDate: "Y-m-d",
		scrollMonth: false,
	});
	$(".btnsyncron").click(function (e) {
		e.preventDefault();
		Swal.fire({
			title: "Silakan pilih data ",
			showDenyButton: true,
			showCancelButton: true,
			confirmButtonText: "DATA STORE",
			denyButtonText: `DATA USER`,
		}).then((result) => {
			Swal.fire({
				backdrop: true,
				position: "center",
				icon: "info",
				title: "synchronize data...",
				text: "Attention please wait.., this process takes a long time",
				showConfirmButton: false,
				allowOutsideClick: false,
				allowEscapeKey: false,
			});
			if (result.isConfirmed) {
				$.ajax({
					type: "GET",
					url: hostname + "auth/ambildataserverstore",
					dataType: "json",
					success: function (response) {
						if (response.sukses) {
							Swal.fire(response.sukses, "", "info").then(function () {
								location.reload();
							});
						} else if (response.gagal) {
							Swal.fire(response.gagal, "", "error").then(function () {
								Swal.close();
							});
						}
					},
				});
			} else if (result.isDenied) {
				$.ajax({
					type: "GET",
					url: hostname + "auth/syncronizeuser",
					dataType: "json",
					success: function (response) {
						if (response.sukses) {
							Swal.fire(response.sukses, "", "info").then(function () {
								location.reload();
							});
						} else if (response.gagal) {
							Swal.fire(response.gagal, "", "error").then(function () {
								Swal.close();
							});
						}
					},
				});
			}else{
        Swal.close();
      }
		});
	});
});