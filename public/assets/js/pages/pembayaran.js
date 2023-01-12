$(document).ready(function () {
  if ($("#riwayat-transaksi").length == 1) {
    $('#riwayat-transaksi').DataTable({
      "aaSorting": [],
    });
  }
  if ($("#riwayat-tabungan-sekolah").length == 1) {
    $('#riwayat-tabungan-sekolah').DataTable({
      "aaSorting": [],
    });
  }
  if ($("#history-transaksi-siswa").length == 1) {
    $('#history-transaksi-siswa').DataTable({
      "aaSorting": [],
    });
  }

  if ($("#upload-surat-pengajuan").length == 1) {
    $('#upload-surat-pengajuan').change(function () {
      var f = this.files[0];
      var name = f.name;
      $('.pengajuan-keringanan-form__item-upload').find('.file-name').text(name);
    });
  }

  $.each($('.jumlah-pembayaran'), (index, value) => {
    $(value).text('Rp. ' + numberFormat($(value).text()))
  })
});

function numberFormat(x) {
  var parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  return parts.join(",");
}