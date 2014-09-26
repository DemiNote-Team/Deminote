function sendRegisterRequest(data, success, error) {
    $.ajax({
        url: '/public/ajax/',
        type: 'POST',
        data: data,
        error: error,
        success: success
    });
}