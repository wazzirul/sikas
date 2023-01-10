$(document).ready(function () {
  if ($("#data-karyawan").length == 1) {
    $('#data-karyawan').DataTable({
      "aaSorting": [],
    });
  }

  $('.update-karyawan-button').click(() => {
    let id_anggota = $('#id_anggota').val();
    let nama_karyawan = $('#nama_karyawan').val();
    let nip = $('#nip').val();

    $.ajax({
      url: '/query/updateKaryawan',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_anggota: id_anggota,
        nama_karyawan: nama_karyawan,
        nip: nip,
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

  $('.delete-karyawan-button').click(() => {
    let id_anggota = $('#id_anggota').val();

    $.ajax({
      url: '/query/deleteKaryawan',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
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

  $('#karyawan-upload-file').change(() => {
    $('#importForm').submit();
  })
});

function changeAnggota($id_anggota) {
  $('#id_anggota').val($id_anggota);

  $.ajax({
    url: '/query/guruById',
    method: 'POST',
    data: {
      _token: $('#ctoken').val(),
      id: $id_anggota,
    },
    success: (result) => {
      $('#update_nama_karyawan').val(result.nama);
      $('#update_nip').val(result.nip);
      result.jabatan !== null ? $('#update_jabatan').val(result.jabatan.id_struktur_sekolah) : $('#update_jabatan').val("")
      $('.nama-delete-modal').text(result.nama);
    },
    error: (err) => {
      console.log(err);
    }
  })
}