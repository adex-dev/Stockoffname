import { sukses, warningerror, tunggu } from "./alert.js";
export function style() {
	$("img").attr("loading", "lazy");
	$(".clock").datetimepicker({
		lang: "en",
		timepicker: false,
		format: "Y-m-d",
		formatDate: "Y-m-d",
		scrollMonth: false,
	});
	let tanggal = localStorage.getItem("tanggal");
	if (tanggal == null) {
		location.href = hostname + "logout";
	}
	$(".tgl").val(tanggal);
	$(".tglg").text(tanggal);
	$(".select1").select2();
	if ($(window).width() > 992) {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 40) {
				$("#navbar_top").addClass("fixed-top");
				// add padding top to show content behind navbar
				$("body").css("padding-top", $(".navbar").outerHeight() + "px");
			} else {
				$("#navbar_top").removeClass("fixed-top");
				// remove padding top from body
				$("body").css("padding-top", "0");
			}
		});
	}
	$(document).on("click", ".btnupload", function (e) {
		e.preventDefault();
		tunggu();
		let acti = $(this).data("konteks");
		var uploadDataStok = $("input[name=filesname]")[0].files[0];
		let formdata = "",
			url = "",
			tanggal = localStorage.getItem("tanggal"),
			store = localStorage.getItem("store");
		switch (acti) {
			case "x20":
				formdata = new FormData();
				formdata.append("namafile", uploadDataStok),
					formdata.append("tanggal", tanggal);
				formdata.append("store", store);
				url = hostname + "dataload/uploadfilex20";
				break;
			case "chiperlab":
				let ad = $("select[name=floor]").val();
				formdata = new FormData();
				formdata.append("namafile", uploadDataStok),
					formdata.append("tanggal", tanggal);
				formdata.append("store", store);
				formdata.append("namaflor", ad);
				url = hostname + "dataload/uploadchiperlab";
				break;
		}
		$.ajax({
			type: "POST",
			url: url,
			data: formdata,
			cache: false,
			processData: false,
			contentType: false,
			dataType: "json",
			success: function (response) {
				if (response.sukses) {
					sukses(response.sukses).then(function () {
						$.ajax({
							type: "POST",
							url: hostname + "dataload/hapusfile",
							data: formdata,
							cache: false,
							processData: false,
							contentType: false,
							dataType: "json",
							success: function (response) {
								kirimdatadummy(tanggal, store);
								location.reload();
							},
						});
					});
				} else if (response.gagal) {
					warningerror(response.gagal).then(function () {
						$.ajax({
							type: "POST",
							url: hostname + "dataload/hapusfile",
							data: formdata,
							cache: false,
							processData: false,
							contentType: false,
							dataType: "json",
							success: function (response) {
								location.reload();
							},
						});
					});
				}
			},
			error: function (jqXHR, error, errorThrown) {
				if (jqXHR.status && jqXHR.status == 500) {
					let text =
						"Periksa Kembali isi file anda,pastikan tidak ada spesial character";
					warningerror(text).then(function () {
						Swal.close();
						$.ajax({
							type: "POST",
							url: hostname + "dataload/hapusfile",
							data: formdata,
							cache: false,
							processData: false,
							contentType: false,
							dataType: "json",
							success: function (response) {
								location.reload();
							},
						});
					});
				} else {
					let text =
						"Periksa Kembali isi file anda,pastikan tidak ada spesial character";
					warningerror(text).then(function () {
						Swal.close();
						$.ajax({
							type: "POST",
							url: hostname + "dataload/hapusfile",
							data: formdata,
							cache: false,
							processData: false,
							contentType: false,
							dataType: "json",
							success: function (response) {
								location.reload();
							},
						});
					});
				}
			},
		});
	});
	$(document).on("click", ".btndownload", function (e) {
		e.preventDefault();
		let filess = $(this).data("files");
		let uri = "",
			name = "";
		switch (filess) {
			case "x20":
				uri = hostname + "dataload/downloadsampel/";
				name = "sampel-x20.xlsx";
				break;
			case "store":
				uri = hostname + "dataload/downloadsampel/";
				name = "MASTERSTORE.xls";
				break;
		}
		$.ajax({
			type: "POST",
			url: uri,
			data: { request: "download", download: name },
			dataType: "json",
			success: function (response) {
				sukses(response.respon).then(function () {
					window.location.href = hostname + "src/bundle/sampel/" + name;
					swal.close();
				});
			},
		});
	});
	let tipe = "",
		url = "",
		data = "",
		$table = "",
		$foot = "";
	let a = localStorage.getItem("tanggal"),
		store = localStorage.getItem("store");
	switch (segment) {
		case "laporanaudit":
			tipe = "POST";
			url = hostname + "dataload/datalaporanaudit";
			data = { tgl: a, store: store };
			$table = ".tablelaporanaudit tbody";
			$foot = ".tablelaporanaudit tfoot";
			kirimdata(tipe, url, data, $table, $foot);
			break;
		case "diffx20":
			tipe = "POST";
			url = hostname + "dataload/datalaporandiffrent";
			data = { tgl: a, store: store };
			$table = ".tableauditdiff tbody";
			$foot = ".tableauditdiff tfoot";
			kirimdata(tipe, url, data, $table, $foot);
			break;
		case "laporanx20":
			tipe = "POST";
			url = hostname + "dataload/datax20";
			data = { tgl: a, store: store };
			$table = ".tablex20 tbody";
			$foot = ".tablex20 tfoot";
			kirimdata(tipe, url, data, $table, $foot);
			break;
		case "rekapchiperlab":
			tipe = "POST";
			url = hostname + "dataload/laporanchiperlab";
			data = { tgl: a, store: store };
			$table = ".tablerekapchiperlab tbody";
			$foot = "";
			kirimdata(tipe, url, data, $table, $foot);
			break;
		case "laporandatauser":
			tipe = "POST";
			url = hostname + "dataload/laporanuser";
			data = { tgl: a, store: store };
			$table = ".tablalaporanuser tbody";
			$foot = "";
			kirimdata(tipe, url, data, $table, $foot);
			break;
		case "laporandatahistoris":
			tipe = "POST";
			url = hostname + "dataload/laporanhistoris";
			data = { tgl: a, store: store };
			$table = ".tballaporanhistoris tbody";
			$foot = "";
			kirimdata(tipe, url, data, $table, $foot);
			break;
		case "chiperlab":
			tipe = "POST";
			url = hostname + "dataload/datadummychiperlab";
			data = { tgl: a, store: store };
			$table = ".tabledummy tbody";
			$foot = ".tabledummy tfoot";
			kirimdatadummy(a, store);
			kirimdata(tipe, url, data, $table, $foot);
			break;
	}
	switch (segment1) {
		case "closeaudit":
			if (navigator.onLine) {
				$(".kirmdataonline").removeClass("d-none");
			} else {
				$(".kirmdataonline").addClass("d-none");
			}
			break;
	}
	$(document).on("click", ".btndownloadlaporan", function (e) {
		e.preventDefault();
		let search = $('input[type="search"]').val();
		let title = $(".description").text();
		switch (segment) {
			case "diffx20":
				tipe = "POST";
				url = hostname + "baseexcel/downloaddiffrent";
				data = { tgl: a, store: store, search: search, title: title };
				kirimdataexcel(tipe, url, data, title);
				break;
			case "laporanaudit":
				tipe = "POST";
				url = hostname + "baseexcel/downloadlaporanaudit";
				data = { tgl: a, store: store, search: search, title: title };
				kirimdataexcel(tipe, url, data, title);
				break;
			case "rekapchiperlab":
				tipe = "POST";
				url = hostname + "baseexcel/rekapchiperlab";
				data = { tgl: a, store: store, search: search, title: title };
				kirimdataexcel(tipe, url, data, title);
				break;
			case "laporandatahistoris":
				tipe = "POST";
				url = hostname + "baseexcel/rekaphistoris";
				data = { tgl: a, store: store, search: search, title: title };
				kirimdataexcel(tipe, url, data, title);
				break;
		}
	});
	$(document).on("search", ".Search", function (e) {
		e.preventDefault();
		let tipe = "",
			url = "",
			data = "",
			search = $('input[type="search"]').val(),
			$table = "",
			$foot = "";
		let a = localStorage.getItem("tanggal"),
			store = localStorage.getItem("store");
		switch (segment) {
			case "laporanaudit":
				tipe = "POST";
				url = hostname + "dataload/datalaporanaudit";
				data = { tgl: a, store: store, search: search };
				$table = ".tablelaporanaudit tbody";
				$foot = ".tablelaporanaudit tfoot";
				kirimdata(tipe, url, data, $table, $foot);
				break;
			case "diffx20":
				tipe = "POST";
				url = hostname + "dataload/datalaporandiffrent";
				data = { tgl: a, store: store, search: search };
				$table = ".tableauditdiff tbody";
				$foot = ".tableauditdiff tfoot";
				kirimdata(tipe, url, data, $table, $foot);
				break;
			case "laporanx20":
				tipe = "POST";
				url = hostname + "dataload/datax20";
				data = { tgl: a, store: store, search };
				$table = ".tablex20 tbody";
				$foot = ".tablex20 tfoot";
				kirimdata(tipe, url, data, $table, $foot);
				break;
			case "rekapchiperlab":
				tipe = "POST";
				url = hostname + "dataload/laporanchiperlab";
				data = { tgl: a, store: store, search: search };
				$table = ".tablerekapchiperlab tbody";
				$foot = "";
				kirimdata(tipe, url, data, $table, $foot);
				break;
			case "laporandatauser":
				tipe = "POST";
				url = hostname + "dataload/laporanuser";
				data = { tgl: a, store: store, search: search };
				$table = ".tablalaporanuser tbody";
				$foot = "";
				kirimdata(tipe, url, data, $table, $foot);
				break;
			case "laporandatahistoris":
				tipe = "POST";
				url = hostname + "dataload/laporanhistoris";
				data = { tgl: a, store: store, search: search };
				$table = ".tballaporanhistoris tbody";
				$foot = "";
				kirimdata(tipe, url, data, $table, $foot);
				break;
		}
	});
	$(document).on("keyup", 'input[type="search"]', function (e) {
		let tipe = "",
			url = "",
			data = "",
			search = $('input[type="search"]').val(),
			$table = "",
			$foot = "";
		let a = localStorage.getItem("tanggal"),
			store = localStorage.getItem("store");
		switch (segment) {
			case "laporanaudit":
				tipe = "POST";
				url = hostname + "dataload/datalaporanaudit";
				data = { tgl: a, store: store, search: search };
				$table = ".tablelaporanaudit tbody";
				$foot = ".tablelaporanaudit tfoot";
				kirimdata(tipe, url, data, $table, $foot);
				break;
			case "diffx20":
				tipe = "POST";
				url = hostname + "dataload/datalaporandiffrent";
				data = { tgl: a, store: store, search: search };
				$table = ".tableauditdiff tbody";
				$foot = ".tableauditdiff tfoot";
				kirimdata(tipe, url, data, $table, $foot);
				break;
			case "laporanx20":
				tipe = "POST";
				url = hostname + "dataload/datax20";
				data = { tgl: a, store: store, search };
				$table = ".tablex20 tbody";
				$foot = ".tablex20 tfoot";
				kirimdata(tipe, url, data, $table, $foot);
				break;
			case "rekapchiperlab":
				tipe = "POST";
				url = hostname + "dataload/laporanchiperlab";
				data = { tgl: a, store: store, search: search };
				$table = ".tablerekapchiperlab tbody";
				$foot = "";
				kirimdata(tipe, url, data, $table, $foot);
				break;
			case "laporandatauser":
				tipe = "POST";
				url = hostname + "dataload/laporanuser";
				data = { tgl: a, store: store, search: search };
				$table = ".tablalaporanuser tbody";
				$foot = "";
				kirimdata(tipe, url, data, $table, $foot);
				break;
			case "laporandatahistoris":
				tipe = "POST";
				url = hostname + "dataload/laporanhistoris";
				data = { tgl: a, store: store, search: search };
				$table = ".tballaporanhistoris tbody";
				$foot = "";
				kirimdata(tipe, url, data, $table, $foot);
				break;
		}
	});
	$(document).on("click", ".closeaudit", function (e) {
		e.preventDefault();
		let tanggal = localStorage.getItem("tanggal"),
			store = localStorage.getItem("store"),
			staf = $("input[name=staffstore]").val();
		if (staf != "") {
			tunggu();
			$.ajax({
				type: "POST",
				url: hostname + "dataload/closeaudit",
				data: { tgl: tanggal, store: store, staf: staf },
				dataType: "json",
				success: function (response) {
					if (response.sukses) {
						sukses(response).then(function () {
							location.reload();
						});
					} else if (response.gagal) {
						sukses(response.gagal).then(function () {
							location.reload();
						});
					}
				},
				error: function (jqXHR, error, errorThrown) {
					if (jqXHR.status && jqXHR.status == 500) {
						let text = "Data Error";
						warningerror(text).then(function () {
							Swal.close();
						});
					} else {
						let text = "Data Error";
						warningerror(text).then(function () {
							Swal.close();
						});
					}
				},
			});
		} else {
			let text = "Nama Staff Tidak Boleh Kosong";
			warningerror(text).then(function () {
				Swal.close();
			});
		}
	});
	$.ajax({
		type: "POST",
		url: hostname + "dataload/cekstatus",
		data: {
			tgl: localStorage.getItem("tanggal"),
			store: localStorage.getItem("store"),
		},
		dataType: "json",
		success: function (response) {
			$(".statuss").text(response.respon);
			$(".pengaudit").text(response.pengaudit);
		},
	});
	$(document).on("click", ".kirmdataonline", function (e) {
		e.preventDefault();
		let tanggal = localStorage.getItem("tanggal");
		let store = localStorage.getItem("store");
		tunggu();
		$.ajax({
			type: "POST",
			url: hostname + "dataload/postserveronline",
			data: { store: store, tanggal: tanggal },
			dataType: "json",
			success: function (response) {
				if (response.respon == "200") {
					sukses(response.messages).then(function (e) {
						$.ajax({
							type: "POST",
							url: hostname + "dataload/hapusfile2",
							data: formdata,
							cache: false,
							processData: false,
							contentType: false,
							dataType: "json",
							success: function (response) {
								Swal.close();
							},
						});
					});
				} else if (response.respon == "404") {
					warningerror(response.messages).then(function (e) {
						Swal.close();
					});
				}
			},
			error: function (jqXHR, error, errorThrown) {
				if (jqXHR.status && jqXHR.status == 500) {
					let isi = "sorry we have temporary server issues.";
					warningerror(isi).then((response) => {
						Swal.close();
					});
				} else if (jqXHR.status && jqXHR.status == 404) {
					let isi = "URL 404";
					warningerror(isi).then((response) => {
						Swal.close();
					});
				} else {
					let isi = "Error data";
					warningerror(isi).then((response) => {
						Swal.close();
					});
				}
			},
		});
	});
}
function kirimdata(tipe, url, data, $table, $foot) {
	tunggu();
	$.ajax({
		type: tipe,
		url: url,
		data: data,
		dataType: "json",
		success: function (response) {
			swal.close();
			$($table).html(response.respon);
			$($foot).html(response.Total);
		},
	});
}
function kirimdatadummy(a, b) {
	$.ajax({
		type: "POST",
		url: hostname + "dataload/suminventoris",
		data: { tgl: a, store: b },
		dataType: "json",
		success: function (response) {
			$(".totalsumchiper").text(response.respon);
		},
	});
}
function kirimdataexcel(tipe, url, formdata, title) {
	tunggu();
	$.ajax({
		type: tipe,
		url: url,
		data: formdata,
		dataType: "json",
		success: function (response) {
			if (response.sukses) {
				sukses(response.sukses).then(function (e) {
					Swal.close();
				});
			} else if (response.respon) {
				warningerror(response.gagal).then(function (e) {
					Swal.close();
				});
			}
		},
		error: function (jqXHR, error, errorThrown) {
			if (jqXHR.status && jqXHR.status == 500) {
				let isi = "sorry we have temporary server issues.";
				warningerror(isi).then((response) => {
					Swal.close();
				});
			} else if (jqXHR.status && jqXHR.status == 404) {
				let isi = "URL 404";
				warningerror(isi).then((response) => {
					Swal.close();
				});
			} else {
				let isi = "sorry we have temporary server issues.";
				warningerror(isi).then((response) => {
					Swal.close();
				});
			}
		},
	}).done(function (data) {
		Swal.close();
		var $a = $("<a>");
		$a.attr("href", data.file);
		$("body").append($a);
		$a.attr("download", title + ".xlsx");
		$a[0].click();
		$a.remove();
	});
}
