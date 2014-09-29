var error_handle = 0;

$(document).ready(function () {
    lang = JSON.parse(lang);

    $('#reg-form-captcha,#auth-form-captcha').on('keyup', function () {
        if (this.value.length > 0) this.style.textTransform = 'uppercase';
        else this.style.textTransform = 'none';
    });

    if (oauthdata != 0) {
        oauthdata = JSON.parse(oauthdata);
    }

    var uri = location.href.split('/');
    if (uri[uri.length - 1] == '#continuereg' && oauthdata) {
        openRegWindow();
        $('#reg-form-email').val(oauthdata['email']);
        $('#reg-form-name').val(oauthdata['name']);
        $('#reg-form-email,#reg-form-name').prop('disabled', 'true');
        $('.reg-window-content-td').eq(1).detach();
        $('.reg-window').css('width', '284px');
    }

    process();
});

function process() {
    $('.comment').each(function (i, v) {
        $(this).css('margin-left', (55 * Math.min(parseInt($(this).attr('deep')), 9)) + 'px');
    });

    $('.touchable .plus-rating-img, .touchable .minus-rating-img').on('mouseenter', function () {
        this.src = this.src.replace('_passive', '');
    }).on('mouseleave', function () {
        this.src = this.src.replace('.png', '_passive.png');
    });

    var count = 0;
    $('a').each(function (i, v) {
        if (this.onclick == null) {
            $(this).unbind('click').bind('click', function (event) {
                var s = this.href.split('/');
                s.splice(0, 1);
                s.splice(1, 1);
                navigate(s.join('/'));
                event.preventDefault();
                return false;
            });
            count++;
        }
    });
    console.log(count + " links replaced.");
    try {
        CKEDITOR.replaceAll();
    } catch (e) {
        console.log('Error: ' + e);
    }
}

function showError(text) {
    clearTimeout(error_handle);
    var div = $('.error-layout');
    div.stop();
    div.hide();
    div.css('opacity', '1');

    //$(".hidden-layout").show();
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

function updateCaptcha(div) {
    $(div + ' img.captcha').each(function () {
        this.src = this.src + Math.floor(Math.random() * 100);
    });
    $('#auth-form-captcha,#reg-form-captcha').val('');
    $('#auth-form-captcha,#reg-form-captcha').css('text-transform', 'none');
}

function processAuthorizing() {
    $(".auth-window-content input").prop('disabled', 'true');
    $(".hidden-layout").show();
    var login = $('#auth-form-login').val();
    var password = $('#auth-form-password').val();
    var captcha = $('#auth-form-captcha').val();

    $(".loading-layout").css('display', 'inline-block');
    sendAjax('authorize', {
        login: login,
        password: password,
        captcha: captcha
    }, function (data) {
        console.log(data);
        $(".loading-layout").hide();
        try {
            data = JSON.parse(data);
        } catch (e) {
            showError(lang.error_happened_refresh_page);
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
                case 'wrong-password':
                    errorText = lang.wrong_password_or_incorrect_user;
                    break;
                case 'wrong-captcha':
                    errorText = lang.incorrect_captcha;
                    break
                default:
                    errorText = lang.error_happened_refresh_page;
                    break;
            }
            updateCaptcha('.auth-window');
            showError(errorText);
            $(".auth-window-content input").removeAttr('disabled');
        }
    }, function () {
        showError(lang.error_happened_refresh_page);
        $(".loading-layout").hide();
    });
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
        error.push(lang.login_cannot_be_small);
    if (login.length > 10)
        error.push(lang.login_cannot_be_big);
    if (!/^([a-zа-я0-9\-]+)$/im.test(login))
        error.push(lang.incorrect_login_symbols_use);
    if (/^([0-9]+)$/im.test(login[0]))
        error.push(lang.login_cannot_start_from_number);
    if (/([\-]{2,20})/im.test(login))
        error.push(lang.do_not_use_symbols_in_a_row);
    if (/([а-я]+)/im.test(login) && /([a-z]+)/im.test(login))
        error.push(lang.do_not_use_2_alphabets);
    if (password1 != password2)
        error.push(login.not_the_same_passwords);
    if (password1.length < 8)
        error.push(lang.password_cannot_be_small);
    if (password1.length > 32)
        error.push(lang.password_cannot_be_small);
    if (name.length < 2)
        error.push(lang.name_cannot_be_small);
    if (name.length > 24)
        error.push(lang.name_cannot_be_big);
    if (!/^([a-z0-9\.\-\_]{1,20})@([a-z0-9\-]{1,20})\.([a-z]{1,20})$/im.test(email))
        error.push(lang.incorrect_email);
    if (captcha.length != 5)
        error.push(lang.incorrect_captcha);

    if (error.length != 0) {
        showError(error[0]);
        $(".reg-window-content input").removeAttr('disabled');
        if (oauthdata) {
            $('#reg-form-email,#reg-form-name').prop('disabled', 'true');
        }
        return false;
    }

    $(".loading-layout").css('display', 'inline-block');

    sendAjax('register', {
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
                showError(lang.error_happened_refresh_page);
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
                        errorText = lang.login_cannot_be_small;
                        break;
                    case 'big-login':
                        errorText = lang.login_cannot_be_big;
                        break;
                    case 'small-password':
                        errorText = lang.password_cannot_be_small;
                        break;
                    case 'big-password':
                        errorText = lang.password_cannot_be_big;
                        break;
                    case 'small-name':
                        errorText = lang.name_cannot_be_small;
                        break;
                    case 'big-name':
                        errorText = lang.name_cannot_be_big;
                        break;
                    case 'wrong-login':
                        errorText = lang.incorrect_login_symbols_use;
                        break;
                    case 'login-closed':
                        errorText = lang.login_closed;
                        break;
                    case 'bad-passwords':
                        errorText = lang.not_the_same_password;
                        break;
                    case 'wrong-captcha':
                        errorText = lang.incorrect_captcha;
                        break;
                    case 'wrong-email':
                        errorText = lang.incorrect_email;
                        break;
                    default:
                        errorText = lang.error_happened_refresh_page;
                        break;
                }
                updateCaptcha('.reg-window');
                showError(errorText);
                $(".reg-window-content input").removeAttr('disabled');
                if (oauthdata) {
                    $('#reg-form-email,#reg-form-name').prop('disabled', 'true');
                }
            }
        }, function () {
            showError(lang.error_happened_refresh_page);
            $(".loading-layout").hide();
        });
}

function addComment() {
    var text = CKEDITOR.instances.newcomment.getData();
    sendAjax('addcomment', {
        text: text,
        topic: topic
    }, function (data) {
        data = JSON.parse(data);
        console.log(data);
        if (data.error) {
            showError(lang.error_happened_refresh_page);
        }
        if (data.success) {
            navigate(location.href);
            CKEDITOR.instances.newcomment.setData();
        }
    }, function () {
        showError(lang.error_happened_refresh_page);
    })
}

function addReply(id) {
    var text = CKEDITOR.instances.replycomment.getData();
    sendAjax('addcomment', {
        text: text,
        topic: topic,
        reply: id
    }, function (data) {
        console.log(data);
        data = JSON.parse(data);
        if (data.error) {
            showError(lang.error_happened_refresh_page);
        }
        if (data.success) {
            $('.reply-form').detach();
            navigate(location.href);
        }
    }, function () {
        showError(lang.error_happened_refresh_page);
    })
}

function openReplyForm(id) {
    $('.reply-form').detach();
    var button = $('#add-comment').outerHTML().replace('addComment();', 'addReply(\'' + id + '\');');
    var button_cancel = '<button class="add-comment-b" onclick="abortReply();">' + lang.cancel + '</button>';
    $('#add-comment-form').slideUp(500);
    $('#comment-' + id).append('<div class="reply-form"><br /><textarea id="replycomment" class="ckeditor reply-textarea"></textarea>' + button + button_cancel + '</div>');
    try {
        CKEDITOR.replace('replycomment');
    } catch (e) {
        //ну хуле, бывает
        console.log('Error: ' + e);
    }
    setTimeout(function () {
        jump('comment-' + id);
    }, 1);
}

function jump(hash) {
    location.hash = hash;
}

function abortReply() {
    $('.reply-form').detach();
    $('#add-comment-form').slideDown(500);
}

function changeFavicon(icon) {
    $('link[rel="shortcut icon"]').detach();
    (function() {
        var link = document.createElement('link');
        link.type = 'image/x-icon';
        link.rel = 'shortcut icon';
        link.href = '/' + icon;
        document.getElementsByTagName('head')[0].appendChild(link);
    }());
}

function navigate(href) {
    console.log('Navigating to ' + href + '...');
    changeFavicon('loading.gif');
    $('.loading-layout').show();
    sendAjax('getcontent', {
        link: href
    }, function (data) {
        data = JSON.parse(data);
        console.log(data);
        if (data.success) {
            data = Base64.decode(data.html);
            $('.content').html(data);
            window.history.replaceState({}, document.title, href);
            document.body.scrollTop = 0;
            process();
            changeFavicon('favicon.png');
            $('.loading-layout').hide();
        }
        if (data.script) {
            eval(data.script);
        }
    }, function () {
        showError(lang.error_happened_refresh_page);
    });
}