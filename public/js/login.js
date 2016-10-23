emailFormat = function (email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};

errorReport = function ($element, message) {
    $element.text(message);
};

clearErrors = function ($element) {
    $element.parents('.field').find('.errorAccount').text('');
};

setError = function ($element) {
    $element.removeClass('success');
    $element.addClass('error');
    return false;
};

setSuccess = function ($element) {
    clearErrors($element);
    $element.removeClass('error');
    $element.addClass('success');
    return true;
};

validateEmail = function ($element) {
    var email = $element.val();
    if (!email) {
        errorReport($('#emailError'), 'Email is required');
        return setError($element);
    } else if (!emailFormat(email)) {
        errorReport($('#emailError'), 'Email format is invalid, please review.');
        return setError($element);
    } else {
        return setSuccess($element);
    }
};

validatePassword = function ($password) {
    var password = $password.val();
    if (!password) {
        errorReport($('#passwordError'), 'Password is required');
        return setError($password);
    } else if (password.length < 6 || password.length > 30) {
        errorReport($('#passwordError'), 'Password must be 6 to 30 characters long.');
        return setError($password);
    } else {
        return setSuccess($password);
    }
};

const ENTER = 13;
$(document).ready(function () {
    var validEmail = false;
    var validPassword = false;
    var allowSubmit = true;
    var $form = $('form'),
        $button = $('button');

    var $email = $('input[name=email]'),
        $password = $('input[name=password]');

    //e-mail
    $email.on('keyup', function (e) {
        validateEmail($(this));
    });
    //password
    $password.on('keyup', function (e) {
        validatePassword($(this));
    });

    $(document).on('keyup', function (e) {
        if (e.keyCode == ENTER) {
            $button.click();
        }
    });

    var onSubmit = function ($form) {
        validEmail = validateEmail($email);
        validPassword = validatePassword($password);

        if (validEmail && validPassword && allowSubmit) {
            allowSubmit = false;
            $form.submit();
        }
    };

    // if click on the button
    $button.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        onSubmit($form);
    });
});