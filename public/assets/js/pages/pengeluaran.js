$(document).ready(function () {
  if ($("#riwayat-pengeluaran").length == 1) {
    $('#riwayat-pengeluaran').DataTable();
  }

  $('#nominalPengeluaran').keyup((e) => {
    let input = e.currentTarget.value;
    $('#nominalPengeluaran').val(formatRupiah(input, 'RP. '))
  })
  $('#jumlah-pembayaran').keyup((e) => {
    let input = e.currentTarget.value;
    $('#jumlah-pembayaran').val(formatRupiah(input, 'RP. '))
  })

  $.each($('.nominal-transaksi'), (index, value) => {
    $(value).text('Rp. ' + numberFormat($(value).text()))
  })

  $('.update-transaksi-button').click(() => {
    updateTransaksi();
  })
  $('.delete-transaksi-button').click(() => {
    deleteTransaksi();
  })

  $('.pengajuan-pemasukan-button').click((e) => {
    $.ajax({
      url: '/query/pengeluaran',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        nominal: $('#nominalPengeluaran').val(),
        keterangan: $('#keterangan').val(),
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

function updateTransaksi() {
  let id_transaksi = $('#id_transaksi').val();
  $('#update-result').text(numberFormat($('#jumlah-pembayaran').val()));

  $.ajax({
    url: '/query/updatePengeluaran',
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
}

function deleteTransaksi() {
  let id_transaksi = $('#id_transaksi').val();

  $.ajax({
    url: '/query/deletePengeluaran',
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
}

function changeTransaksi($id_transaksi) {
  $('#id_transaksi').val($id_transaksi);
}

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