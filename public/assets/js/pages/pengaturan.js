$('#update_password').keyup(() => {
    if ($('#update_password').val() == $('#update_re_password').val()) {
        $('.alert-change-password').addClass('d-none');
        $('.submit-button').removeClass('disabled');

    } else {
        $('.alert-change-password').removeClass('d-none');
        $('.submit-button').addClass('disabled');
    }
})

$('#update_re_password').keyup(() => {
    if ($('#update_password').val() == $('#update_re_password').val()) {
        $('.alert-change-password').addClass('d-none');
        $('.submit-button').removeClass('disabled');

    } else {
        $('.alert-change-password').removeClass('d-none');
        $('.submit-button').addClass('disabled');
    }
})

$(document).on('submit', 'form#myform', function (e) {
    e.preventDefault()

    let form = $(this),
        url = form.attr('action'),
        method = form.attr('method'),
        data = form.serialize()

    let dontSubmit = false
    form.find('input:not([type="hidden"])').each((_, el) => {
        if (!$(el).val()) dontSubmit = true
    })
    if (dontSubmit) return

    $.ajax({
        url,
        method,
        data,
        success: (result) => {
            $('.success-button').click()
        },
        error: (err) => {
            $('.error-button').click()
        },
        complete: () => {
            form.trigger('reset')
        }
    })
})

$(document).on('submit', 'form#formupdate', function (e) {
    e.preventDefault()

    let form = $(this),
        url = form.attr('action'),
        method = form.attr('method'),
        data = form.serialize()

    // let dontSubmit = false
    // form.find('input:not([type="hidden"])').each((_, el) => {
    //     if (!$(el).val()) dontSubmit = true
    // })
    // if (dontSubmit) return

    $.ajax({
        url,
        method,
        data,
        success: (result) => {
            $('.success-button').click()
        },
        error: (err) => {
            $('.error-button').click()
        },
        complete: () => {
            // form.trigger('reset')
        }
    })
})
