$(document).ready(function () {
    $('#reg-form-captcha,#auth-form-captcha').on('keyup', function () {
        if (this.value.length > 0) this.style.textTransform = 'uppercase';
            else this.style.textTransform = 'none';
    });
});

function hideLayout() {
    $(".hidden-layout").hide();
}

function openAuthWindow() {
    $(".hidden-layout").show();
    $(".auth-window").css('display', 'inline-block');
}

function closeAuthWindow() {
    $(".hidden-layout").hide();
    $(".auth-window").hide();
}

function openRegWindow() {
    $(".hidden-layout").show();
    $(".reg-window").css('display', 'inline-block');
}

function closeRegWindow() {
    $(".hidden-layout").hide();
    $(".reg-window").hide();
}

function updateCaptcha() {
    $('img.captcha').each(function () {
        this.src = this.src + Math.floor(Math.random() * 100);
    });
}