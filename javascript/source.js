function sendRegisterRequest(data, success, error) {
    $.ajax({
        url: '/public/ajax/',
        type: 'POST',
        data: $.extend(true, data, {
            method: 'register'
        }),
        error: error,
        success: success
    });
}

function sendAuthorizeRequest(data, success, error) {
    $.ajax({
        url: '/public/ajax/',
        type: 'POST',
        data: $.extend(true, data, {
            method: 'authorize'
        }),
        error: error,
        success: success
    });
}