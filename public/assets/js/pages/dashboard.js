$(document).ready(function () {
  $('#transaksi-terakhir').DataTable();

  $('.jumlah-keringanan').text('Rp. ' + numberFormat($('.jumlah-keringanan').text()) + ',00');
  $('.jumlah-tabungan').text('Rp. ' + numberFormat($('.jumlah-tabungan').text()) + ',00');
});

function numberFormat(x) {
  var parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  return parts.join(",");
}