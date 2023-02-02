$(document).ready(function () {
  if ($("#history-pembayaran").length == 1) {
    $('#history-pembayaran').DataTable({
      "aaSorting": [[0, 'DESC']],
    });
  }

  if ($("#upload-surat-pengajuan").length == 1) {
    $('#upload-surat-pengajuan').change(function () {
      var f = this.files[0];
      var name = f.name;
      $('.pengajuan-keringanan-form__item-upload').find('.file-name').text(name);
    });
  }

  $('.sisa-tanggungan').text('Rp. ' + numberFormat($('.sisa-tanggungan').text()));
  $('.total-penambahan').text('Rp. ' + numberFormat($('.total-penambahan').text()));
  $('.total-keringanan').text('Rp. ' + numberFormat($('.total-keringanan').text()));
  $('.total-tabungan').text('Rp. ' + numberFormat($('.total-tabungan').text()));

  $.each($('.nominal-transaksi'), (index, value) => {
    $(value).text('Rp. ' + numberFormat($(value).text()))
  })

  $('#jumlah-pembayaran').keyup((e) => {
    let input = e.currentTarget.value;
    $('#jumlah-pembayaran').val(formatRupiah(input, 'RP. '))
  })

  $('.update-transaksi-button').click(() => {
    let id_transaksi = $('#id_transaksi').val();
    let tipe_transaksi = $('#tipe_transaksi').val();
    let id_anggota = $('#id_anggota').val();
    $('#update-result').text(numberFormat($('#jumlah-pembayaran').val()));

    if (tipe_transaksi == "1") {
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
    } else {
      $.ajax({
        url: '/query/updateHistoryTabungan',
        method: 'POST',
        data: {
          _token: $('#ctoken').val(),
          id_transaksi: id_transaksi,
          id_anggota: id_anggota,
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
  })

  $('.delete-transaksi-button').click(() => {
    let id_transaksi = $('#id_transaksi').val();
    let tipe_transaksi = $('#tipe_transaksi').val();
    let id_anggota = $('#id_anggota').val();

    if (tipe_transaksi == "1") {
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

    } else {
      $.ajax({
        url: '/query/deleteHistoryTabungan',
        method: 'POST',
        data: {
          _token: $('#ctoken').val(),
          id_transaksi: id_transaksi,
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
    }
  })

  $('#history-pembayaran').on('page.dt', function () {
    setTimeout(() => {
      $.each($('.nominal-transaksi'), (index, value) => {
        $(value).text('Rp. ' + numberFormat($(value).text().replaceAll('Rp', '').replaceAll('.', '').replaceAll(' ', '')))
      })
    }, 100);
  });

  $('#tahunAjaran').keyup((e) => {
    console.log($('.form-control.form-control-sm').find('input[type=search]'));
    $('.form-control.form-control-sm').find('input[type=search]').prevObject.each((index, value) => {
      $(value).val(e.currentTarget.value);
      $(value).keyup();
    });
  })
});

$(document).on('click', 'button#button-cetak-laporan', function () {
  let tableInnerHTML = $(document).find('table#history-pembayaran').html()
  let namaSiswa = $(document).find('#detail-siswa-history__nama').text()

  printJS({
    printable: `
    <div>
      <div class="page-header">
        <h2 class="page-header-title">Riwayat Transaksi ${namaSiswa}</h2>
      </div>
      <div class="page-content">
        <table>
          ${tableInnerHTML}
        </table>
      </div>
    </div>`,
    type: 'raw-html',
    header: null,
    style: '@media print { @page { margin-top: 48px; margin-bottom: 48px; } @page:first { margin-top: 0; margin-bottom: 0; } body { font-size: 14px; padding: 0; } } .page { width: 100%; min-height: 420px; padding-top: 16px; padding-bottom: 16px; display: flex; flex-direction: column; align-items: stretch; justify-content: space-between; } .page-header { display: flex; flex-direction: row; align-items: center; justify-content: space-between; } .page-content { margin-top: 16px; } table { border: 1px solid #E0E0E0; border-collapse: collapse; } table th, table td { border: 1px solid #E0E0E0; padding: 8px 16px !important; } table thead th, table thead td { text-align: left; white-space: nowrap; } table tr td:last-child,tr th:last-child { display:none; } caption { display:none; }',
    gridStyle: 'padding: 2px;',
    documentTitle: 'Data Laporan'
  })
})

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

function changeTransaksi($id_transaksi, $tipe_transaksi, $id_anggota) {
  $('#id_transaksi').val($id_transaksi);
  $('#tipe_transaksi').val($tipe_transaksi);
  $('#id_anggota').val($id_anggota);
}