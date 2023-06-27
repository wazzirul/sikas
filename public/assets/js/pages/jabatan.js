$(document).ready(function () {
  if ($("#data-master-jabatan").length == 1) {
    $('#data-master-jabatan').DataTable({
      "aaSorting": [],
    });
  }

  $('.update-jabatan-button').click(() => {
    let id_struktur_sekolah = $('#id_struktur_sekolah').val();
    let jabatan = $('#update_jabatan').val();

    $.ajax({
      url: '/query/updateJabatan',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_struktur_sekolah: id_struktur_sekolah,
        jabatan: jabatan,
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

  $('.delete-jabatan-button').click(() => {
    let id_struktur_sekolah = $('#id_struktur_sekolah').val();

    $.ajax({
      url: '/query/deleteJabatan',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_struktur_sekolah: id_struktur_sekolah,
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

function changeStrukturSekolah(id_struktur_sekolah) {
  $('#id_struktur_sekolah').val(id_struktur_sekolah);

  $.ajax({
    url: '/query/strukturSekolahById',
    method: 'POST',
    data: {
      _token: $('#ctoken').val(),
      id: id_struktur_sekolah,
    },
    success: (result) => {
      console.log(result);
      $('#update_jabatan').val(result.jabatan);
      $('.nama-delete-modal').text(result.jabatan);
    },
    error: (err) => {
      console.log(err);
    }
  })
}