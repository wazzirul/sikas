$(document).ready(function () {
  if ($("#data-teller").length == 1) {
    $('#data-teller').DataTable({
      "aaSorting": [],
    });
  }

  $('.update-teller-button').click(() => {
    let id_user = $('#id_user').val();
    let nama_teller = $('#update_nama_teller').val();
    let username = $('#update_username').val();
    let password = $('#update_password').val();

    $.ajax({
      url: '/query/updateTeller',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_user: id_user,
        nama_teller: nama_teller,
        username: username,
        password: password,
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

  $('.delete-teller-button').click(() => {
    let id_user = $('#id_user').val();

    $.ajax({
      url: '/query/deleteTeller',
      method: 'POST',
      data: {
        _token: $('#ctoken').val(),
        id_user: id_user,
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

  $('#password, #re_password').keyup(() => {
    if ($('#password').val() == $('#re_password').val()) {
      console.log('sama');
      $('.post-teller-button').removeClass('disabled');
      $('.password-alert').addClass('d-none');
    } else {
      $('.post-teller-button').addClass('disabled');
      $('.password-alert').removeClass('d-none');
    }
  })
});

function changeTeller($id_user) {
  $('#id_user').val($id_user);

  $.ajax({
    url: '/query/tellerById',
    method: 'POST',
    data: {
      _token: $('#ctoken').val(),
      id: $id_user,
    },
    success: (result) => {
      $('#update_nama_teller').val(result.nama);
      $('#update_username').val(result.username);
      $('.nama-delete-modal').text(result.nama);
    },
    error: (err) => {
      console.log(err);
    }
  })
}