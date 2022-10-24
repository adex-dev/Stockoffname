export function sukses(isi) {
  return Swal.fire({
    icon: 'success',
    title: 'Information',
    text: isi,
    showConfirmButton: false,
    timer: 1500
  })
}
export function warningerror(isiwarning) {
  return Swal.fire({
    text: isiwarning,
    icon: "error",
    showCancelButton: false,
    confirmButton: true,
  });
}
export function tunggu() {
  return Swal.fire({
    backdrop: true,
    position: 'center',
    imageUrl: hostname+'src/bundle/icon/loading.gif',
    imageWidth: 400,
    imageHeight: 200,
    title: 'Mohon Tunggu Sebentar',
    showConfirmButton: false,
    allowOutsideClick: false,
    allowEscapeKey: false
  })
}
