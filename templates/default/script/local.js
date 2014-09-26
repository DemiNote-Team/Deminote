var error_handle = 0;

$(document).ready(function () {
    $('#reg-form-captcha,#auth-form-captcha').on('keyup', function () {
        if (this.value.length > 0) this.style.textTransform = 'uppercase';
        else this.style.textTransform = 'none';
    });
});

function showError(text) {
    clearTimeout(error_handle);
    var div = $('.error-layout');
    div.stop();
    div.hide();
    div.css('opacity', '1');

    $(".hidden-layout").show();
    $(".error-text").html(text);
    div.css('display', 'inline-block');
    error_handle = setTimeout(function () {
        $('.error-layout').animate({opacity: 0}, 1000, function () {
            div.hide();
            div.css('opacity', '1');
        })
    }, 3000);
}

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
    $('#auth-form-captcha,#reg-form-captcha').val('');
    $('#auth-form-captcha,#reg-form-captcha').css('text-transform', 'none');
}

function processRegister() {
    $(".reg-window-content input").prop('disabled', 'true');
    $(".hidden-layout").show();

    var login = $('#reg-form-login').val();
    var password1 = $('#reg-form-password').val();
    var password2 = $('#reg-form-password-repeat').val();
    var email = $('#reg-form-email').val();
    var name = $('#reg-form-name').val();
    var captcha = $('#reg-form-captcha').val();
    var error = [];

    if (login.length < 4)
        error.push('Логин должен быть не менее четырех символов.');
    if (login.length > 10)
        error.push('Логин должен быть не более десяти символов.');
    if (!/^([a-zа-я0-9\-]+)$/im.test(login))
        error.push('Неверный логин. Используйте только буквы, цифры и символ "-".');
    if (/^([0-9]+)$/im.test(login[0]))
        error.push('Неверный логин. Логин не может начинаться с цифры.');
    if (/([\-]{2,20})/im.test(login))
        error.push('Неверный логин. Символы "-" не могут идти подряд.');
    if (/([а-я]+)/im.test(login) && /([a-z]+)/im.test(login))
        error.push('Неверный логин. Не используйте кириллицу и латиницу одновременно.');
    if (password1 != password2)
        error.push('Пароли не совпадают.');
    if (password1.length < 8)
        error.push('Пароль должен быть не менее восьми символов.');
    if (password1.length > 32)
        error.push('Пароль должен быть не более тридцати двух символов.');
    if (name.length < 2)
        error.push('Имя должно быть не менее двух символов.');
    if (name.length > 24)
        error.push('Имя должно быть не более двадцати четырех символов.');
    if (!/^([a-z0-9\.\-\_]{1,20})@([a-z0-9\-]{1,20})\.([a-z]{1,20})$/im.test(email))
        error.push('Неверный электронный адрес.');
    if (captcha.length != 5)
        error.push('Неверный код с картинки.');

    if (error.length != 0) {
        showError(error[0]);
        $(".reg-window-content input").removeAttr('disabled');
        return false;
    }

    $(".loading-layout").css('display', 'inline-block');

    sendRegisterRequest({
            login: login,
            password: password1,
            email: email,
            name: name,
            captcha: captcha
        }, function (data) {
            console.log(data);
            $(".loading-layout").hide();
            try {
                data = JSON.parse(data);
            } catch (e) {
                showError("Произошла ошибка. Попробуйте перезагрузить страницу.");
                return false;
            }
            if (data.success) {
                var session = data.session;
                document.cookie = 'session=' + session + '; path=/;';
                location.href = '/';
            }
            if (data.error) {
                var errorText = '';
                switch (data.desc) {
                    case 'small-login':
                        errorText = 'Слишком маленький логин.';
                        break;
                    case 'big-login':
                        errorText = 'Слишком большой логин.';
                        break;
                    case 'small-password':
                        errorText = 'Слишком маленький пароль.';
                        break;
                    case 'big-password':
                        errorText = 'Слишком большой пароль.';
                        break;
                    case 'small-name':
                        errorText = 'Слишком маленькое имя.';
                        break;
                    case 'big-name':
                        errorText = 'Слишком большое имя.';
                        break;
                    case 'wrong-login':
                        errorText = 'Неверный логин.';
                        break;
                    case 'login-closed':
                        errorText = 'Этот логин уже занят.';
                        break;
                    case 'bad-passwords':
                        errorText = 'Пароли не совпадают.';
                        break;
                    case 'wrong-captcha':
                        errorText = 'Неверный код с картинки!';
                        break;
                    case 'wrong-email':
                        errorText = 'Неверный электронный адрес.';
                        break;
                    default:
                        errorText = "Произошла ошибка. Попробуйте перезагрузить страницу.";
                        break;
                }
                updateCaptcha();
                showError(errorText);
                $(".reg-window-content input").removeAttr('disabled');
            }
        }, function () {
            showError("Произошла ошибка. Попробуйте перезагрузить страницу.");
            $(".loading-layout").hide();
        });
}