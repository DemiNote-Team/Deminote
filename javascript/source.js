function sendAjax(method, data, success, error) {
    $.ajax({
        url: '/public/ajax/',
        type: 'POST',
        data: $.extend(true, data, {
            method: method
        }),
        error: error,
        success: success
    });
}