$(document).ready(function () {
  if ($("#data-siswa").length == 1) {
    $('#data-siswa').DataTable({
      "aaSorting": [],
    });
  }

  $('.update-siswa-button').click(() => {
    let id_anggota = $('#id_anggota').val();
    let nama_siswa = $('#nama_siswa').val();
    let nis = $('#nis').val();
    let id_kelas = $('#id_kelas').val();
    let id_jurusan = $('#id_jurusan').val();
    let nomor_kelas = $('#nomor_kelas').val();

    $.ajax({
      url: '/query/updateSiswa',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_anggota: id_anggota,
        nama_siswa: nama_siswa,
        nis: nis,
        id_kelas: id_kelas,
        id_jurusan: id_jurusan,
        nomor_kelas: nomor_kelas,
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

  $('.delete-siswa-button').click(() => {
    let id_anggota = $('#id_anggota').val();

    $.ajax({
      url: '/query/deleteSiswa',
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

  $('#siswa-upload-file').change(() => {
    $('#importForm').submit();
  })
});

function changeAnggota($id_anggota) {
  $('#id_anggota').val($id_anggota);

  $.ajax({
    url: '/query/siswaById',
    method: 'POST',
    data: {
      _token: $('#ctoken').val(),
      id: $id_anggota,
    },
    success: (result) => {
      $('#update_nama_siswa').val(result.nama);
      $('#update_nis').val(result.nis);
      $('#update_nomor_kelas').val(result.nomor_kelas);
      result.id_kelas !== null ? $('#update_id_kelas').val(result.kelas.id_kelas) : $('#update_id_kelas').val("")
      result.id_jurusan !== null ? $('#update_id_jurusan').val(result.kelas.id_jurusan) : $('#update_id_jurusan').val("")
      $('.nama-delete-modal').text(result.nama);
    },
    error: (err) => {
      console.log(err);
    }
  })
}