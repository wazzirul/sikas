$(document).ready(function () {
  if ($("#data-siswa").length == 1) {
    $('#data-siswa').DataTable({
      "aaSorting": [],
    });
  }

  $('.update-siswa-button').click(() => {
    let id_anggota = $('#id_anggota').val();
    let nama_siswa = $('#update_nama_siswa').val();
    let nis = $('#update_nis').val();
    let jenis_kelamin = $('#update_jenis_kelamin').val();
    let id_kelas = $('#update_id_kelas').val();
    let id_jurusan = $('#update_id_jurusan').val();
    let nomor_kelas = $('#update_nomor_kelas').val();
    let status_siswa = $('#update_status_siswa').val();

    $.ajax({
      url: '/query/updateSiswa',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_anggota: id_anggota,
        nama_siswa: nama_siswa,
        nis: nis,
        jenis_kelamin: jenis_kelamin,
        id_kelas: id_kelas,
        id_jurusan: id_jurusan,
        nomor_kelas: nomor_kelas,
        status_siswa: status_siswa,
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

  $('.cari-siswa-button').click(() => {
    let id_kelas = $('#filter_id_kelas').val();
    let id_jurusan = $('#filter_id_jurusan').val();
    let nomor_kelas = $('#filter_nomor_kelas').val();
    let angkatan = $('#filter_angkatan_siswa').val();

    $.ajax({
      url: '/query/siswaByFilter',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_kelas: id_kelas,
        id_jurusan: id_jurusan,
        nomor_kelas: nomor_kelas,
        angkatan: angkatan,
      },
      success: (result) => {
        $('#tbody-data-siswa').empty();
        $('#data-siswa').DataTable().clear().destroy();

        $.each(result, (index, value) => {
          $('#tbody-data-siswa').append(`
            <tr>
              <td>
                <p class="text-medium color-neutral-100">${value.nama}</p>              
              </td>
              <td>
                <p class="text-medium color-neutral-100">${value.nis}</p>
              </td>
              <td>
                <p class="text-medium color-neutral-100">${value.jenis_kelamin}</p>
              </td>
              <td>
                <p class="text-medium color-neutral-100">${value.kelas.nama} ${value.jurusan.nama} ${value.nomor_kelas}</p>
              </td>
              <td>
                <p class="text-medium color-neutral-100">${value.alumni == 0 ? 'Siswa Aktif' : value.alumni == 1 ? 'Alumni' : 'Keluar'}</p>
              </td>
              <td>
                <div class="d-flex align-items-center justify-content-end gap-3">
                  <a href="/transaksi/history-transaksi-siswa/detail/${value.id_anggota}" class="table__link-detail d-flex align-items-center gap-2">
                    Detail
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <div class="table-link-border"></div>
                  <a href="#" class="table__link-detail text-info" onClick="changeAnggota(${value.id_anggota})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                    Edit <i class="fa-solid fa-pen"></i>
                  </a>
                  <div class="table-link-border"></div>
                  <a href="#" class="table__link-detail text-danger" onClick="changeAnggota(${value.id_anggota})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                    Hapus <i class="fa-regular fa-trash-can"></i>
                  </a>
                </div>
              </td>
            </tr>
          `);

          if (index == (result.length - 1)) {
            $('#data-siswa').DataTable({
              "aaSorting": [],
            });
          }
        })

        if (result.length == 0) {
          $('#data-siswa').DataTable({
            "aaSorting": [],
          });
        }
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
      $('#update_jenis_kelamin').val(result.jenis_kelamin);
      $('#update_nomor_kelas').val(result.nomor_kelas);
      $('#update_status_siswa').val(result.alumni);
      result.id_kelas !== null ? $('#update_id_kelas').val(result.kelas.id_kelas) : $('#update_id_kelas').val("")
      result.id_jurusan !== null ? $('#update_id_jurusan').val(result.jurusan.id_jurusan) : $('#update_id_jurusan').val("")
      $('.nama-delete-modal').text(result.nama);
    },
    error: (err) => {
      console.log(err);
    }
  })
}