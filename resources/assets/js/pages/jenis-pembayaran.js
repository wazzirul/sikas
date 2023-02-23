$(document).ready(function () {
  $('.js-angkatan-multiple').select2({
    placeholder: "Pilih Angkatan ...",
    initSelection: function (element, callback) {
    }
  });

  if ($("#data-jenis-pembayaran").length == 1) {
    $('#data-jenis-pembayaran').DataTable({
      "aaSorting": [[0, "asc"]],
    });
  }

  $('.update-tagihan-button').click(() => {
    let id_tagihan = $('#id_tagihan').val();
    let nama = $('#update_nama').val();
    let id_kelas = $('#update_id_kelas').val();
    let jumlah = $('#update_jumlah').val();

    $.ajax({
      url: '/query/updateJenisPembayaran',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_tagihan: id_tagihan,
        nama: nama,
        id_kelas: id_kelas,
        jumlah: jumlah,
      },
      success: (result) => {
        setTimeout(() => {
          location.reload()
        }, 1000);
      },
      error: (err) => {
        console.log(err);
      }
    })
  })

  $('.delete-tagihan-button').click(() => {
    let id_tagihan = $('#id_tagihan').val();

    $.ajax({
      url: '/query/deleteJenisPembayaran',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_tagihan: id_tagihan,
      },
      success: () => {
        setTimeout(() => {
          location.reload()
        }, 1000);
      },
      error: (err) => {
        console.log(err);
      }
    })
  })

  $('#jumlah').keyup((e) => {
    let input = e.currentTarget.value;
    $('#jumlah').val(formatRupiah(input, 'RP. '))
  })

  $('#update_jumlah').keyup((e) => {
    let input = e.currentTarget.value;
    $('#update_jumlah').val(formatRupiah(input, 'RP. '))
  })

  $.each($('.nominal-pembayaran'), (index, value) => {
    $(value).text('Rp. ' + numberFormat($(value).text()))
  })
});

function changeTagihan($id_tagihan) {
  $('#id_tagihan').val($id_tagihan);

  $.ajax({
    url: '/query/jenisPembayaranById',
    method: 'POST',
    data: {
      _token: $('#ctoken').val(),
      id: $id_tagihan,
    },
    success: (result) => {
      $('#update_nama').val(result.nama);
      $('#update_jumlah').val(result.jumlah);
      $('#update_id_kelas').val(result.id_kelas);
      $('.nama-delete-modal').text(result.nama);
      $('#flow_pembayaran').val(result.flow_tagihan == 1 ? 'Angsuran' : 'Bulanan');
    },
    error: (err) => {
      console.log(err);
    }
  })
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