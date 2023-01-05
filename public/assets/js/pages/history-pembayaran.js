$(document).ready(function () {
  if ($("#history-pembayaran").length == 1) {
    $('#history-pembayaran').DataTable();
  }
  if ($("#riwayat-transaksi").length == 1) {
    $('#riwayat-transaksi').DataTable();
  }
  if ($("#riwayat-tabungan-sekolah").length == 1) {
    $('#riwayat-tabungan-sekolah').DataTable();
  }
  if ($("#riwayat-tabungan").length == 1) {
    $('#riwayat-tabungan').DataTable();
  }
  if ($("#upload-surat-pengajuan").length == 1) {
    $('#upload-surat-pengajuan').change(function () {
      var f = this.files[0];
      var name = f.name;
      $('.pengajuan-keringanan-form__item-upload').find('.file-name').text(name);
    });
  }

  $('.sisa-tanggungan').text(numberFormat($('.sisa-tanggungan').text()));

  $.each($('.nominal-transaksi'), (index, value) => {
    $(value).text('+ Rp. ' + numberFormat($(value).text()))
  })

  $('#jumlah-pembayaran').keyup((e) => {
    let input = e.currentTarget.value;
    $('#jumlah-pembayaran').val(formatRupiah(input, 'RP. '))
  })

  $('.update-transaksi-button').click(() => {
    let id_transaksi = $('#id_transaksi').val();
    $('#update-result').text(numberFormat($('#jumlah-pembayaran').val()));

    $.ajax({
      url: '/query/updateHistoryPembayaran',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_transaksi: id_transaksi,
        nominal: $('#jumlah-pembayaran').val(),
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

  $('.delete-transaksi-button').click(() => {
    let id_transaksi = $('#id_transaksi').val();

    $.ajax({
      url: '/query/deleteHistoryPembayaran',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_transaksi: id_transaksi,
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
});

function numberFormat(x) {
  var parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  return parts.join(",");
}

function formatRupiah(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split = number_string.split(','),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function changeTransaksi($id_transaksi) {
  $('#id_transaksi').val($id_transaksi);
}