$(document).ready(function () {
  if ($("#data-master-jurusan").length == 1) {
    $('#data-master-jurusan').DataTable({
      "aaSorting": [],
    });
  }

  $('.update-jurusan-button').click(() => {
    let id_struktur_sekolah = $('#id_struktur_sekolah').val();
    let jurusan = $('#update_jurusan').val();

    $.ajax({
      url: '/query/updateJurusan',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_struktur_sekolah: id_struktur_sekolah,
        jurusan: jurusan,
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

  $('.delete-jurusan-button').click(() => {
    let id_struktur_sekolah = $('#id_struktur_sekolah').val();

    $.ajax({
      url: '/query/deleteJurusan',
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
      $('#update_jurusan').val(result.jurusan);
      $('.nama-delete-modal').text(result.jurusan);
    },
    error: (err) => {
      console.log(err);
    }
  })
}