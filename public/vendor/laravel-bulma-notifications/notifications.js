var notificationBox = document.getElementById("bulma-notification-box");
var cookieBox = document.getElementById("bulma-cookie-box");
var timeLimit = 3000;

if (notificationBox) {

    notificationBox.className += " is-" + bumifyOptions.type;

    var notificationContent = '';

    if (bumifyOptions.title) {
        notificationContent += '<h6 class="subtitle">' + bumifyOptions.title + '</h6>';
    }

    if (bumifyOptions.text) {
        notificationContent += '<p>' + bumifyOptions.text + '</p>';
    }

    if (notificationContent) {
        document.getElementById("bulma-notification-box").innerHTML += notificationContent;
    } else {
        document.getElementById("laravel-bulma-notifications-container").style.display = "none";
    }
    timeLimit = bumifyOptions.timer;
}

if(cookieBox) {
    document.getElementById("laravel-bulma-notifications-cookie-msg").innerHTML = bumifyCookie.text;

    if(bumifyCookie.options.buttonText) {
        document.getElementById("bulma-cookie-close").innerHTML = bumifyCookie.options.buttonText;
    }

    let buttonClass = bumifyCookie.options.buttonClass ? bumifyCookie.options.buttonClass : 'is-primary';
    document.getElementById("bulma-cookie-close").className += ' '+buttonClass;

    let backgroundClass = bumifyCookie.options.backgroundClass ? bumifyCookie.options.backgroundClass : 'is-info';
    document.getElementById("bulma-cookie-box").className += ' '+backgroundClass;

    let containerClasses = bumifyCookie.options.containerClasses ? bumifyCookie.options.containerClasses : 'is-full is-full-mobile is-full-tablet';
    document.getElementById("laravel-bulma-notifications-cookie").className += ' '+containerClasses;
}

window.addEventListener('load', function() {

    if(cookieBox) {

        let cookieAccepted = function() {
            document.getElementById("laravel-bulma-notifications-cookie").style.display = "none";
            localStorage.setItem('laravel-bulma-notifications-cookie-accepted', 'yes');
        }

        if (localStorage.getItem('laravel-bulma-notifications-cookie-accepted')) {
            cookieAccepted;
        } else {
            document.getElementById("laravel-bulma-notifications-cookie").style.display = "block";
        }

        document.getElementById('bulma-cookie-close').onclick = cookieAccepted;
    }

    if(notificationBox) {
        let closeBulmaNotify = function () {
            document.getElementById("laravel-bulma-notifications").style.display = "none";
        }

        setTimeout(function () {
            closeBulmaNotify();
        }, timeLimit);

        document.getElementById('bulma-notify-close').onclick = closeBulmaNotify;
    }
})