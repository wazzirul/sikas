$(document).ready(function () {
  if ($("#riwayat-tabungan-siswa").length == 1) {
    $('#riwayat-tabungan-siswa').DataTable({
      "aaSorting": [],
    });
  }
  if ($("#riwayat-tabungan-umum").length == 1) {
    $('#riwayat-tabungan-umum').DataTable({
      "aaSorting": [],
    });
  }
  if ($("#konfirmasi-tabungan").length == 1) {
    $('#konfirmasi-tabungan').DataTable({
      "aaSorting": [],
    });
  }

  $.each($('.jumlah-pembayaran'), (index, value) => {
    $(value).text('Rp. ' + numberFormat($(value).text()))
  })

  $(function () {
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('#date-range-span span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
      $('#date-range-input').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }

    $('#date-range-span').daterangepicker({
      startDate: start,
      endDate: end,
      alwaysShowCalendars: true,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, cb);

    cb(start, end);

  });

  $('.approve-button').click((e) => {
    $('.modal--transaksi__nominal-penarikan').text('Rp. ' + numberFormat(e.currentTarget.dataset.jumlah));

    if (e.currentTarget.dataset.tipe_tabungan == 'siswa') {
      $('#id_anggota_setoran').val(e.currentTarget.dataset.id_tabungan)
      $('#tipe_tabungan_setoran').val('siswa')
    } else {
      $('#id_tabungan_umum_setoran').val(e.currentTarget.dataset.id_tabungan)
      $('#tipe_tabungan_setoran').val('umum')
    }
  })

});

function numberFormat(x) {
  var parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  return parts.join(",");
}

function changeTransaksi($id_transaksi) {
  $('#id_transaksi').val($id_transaksi);
}

$('.confirm-transaksi-button').click(() => {
  let id_transaksi = $('#id_transaksi').val();
  let id_tabungan_umum = $('#id_tabungan_umum_setoran').val();
  let id_anggota = $('#id_anggota_setoran').val();
  let tipe_tabungan = $('#tipe_tabungan_setoran').val();

  let url;
  if (tipe_tabungan == 'siswa') url = '/query/approvePenarikanTabunganSiswa'
  else url = '/query/approvePenarikanTabunganUmum'

  $.ajax({
    url: url,
    method: 'POST',
    data: {
      _token: $('#ctoken').val(),
      id_transaksi: id_transaksi,
      id_tabungan_umum: id_tabungan_umum,
      id_anggota: id_anggota,
    },
    success: () => {
      setTimeout(() => {
        location.reload()
      }, 2000);
    },
    error: (err) => {
      console.log(err);
    }
  })
})