$(document).ready(function () {
  if ($("#data-master-jurusan").length == 1) {
    $('#data-master-jurusan').DataTable({
      "aaSorting": [],
    });
  }

  $('.update-jurusan-button').click(() => {
    let id_jurusan = $('#id_jurusan').val();
    let jurusan = $('#update_jurusan').val();

    $.ajax({
      url: '/query/updateJurusan',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_jurusan: id_jurusan,
        nama: jurusan,
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
    let id_jurusan = $('#id_jurusan').val();

    $.ajax({
      url: '/query/deleteJurusan',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_jurusan: id_jurusan,
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

function changeJurusan(id_jurusan) {
  $('#id_jurusan').val(id_jurusan);

  $.ajax({
    url: '/query/jurusanById',
    method: 'POST',
    data: {
      _token: $('#ctoken').val(),
      id: id_jurusan,
    },
    success: (result) => {
      $('#update_jurusan').val(result.nama);
      $('.nama-delete-modal').text(result.nama);
    },
    error: (err) => {
      console.log(err);
    }
  });
}
