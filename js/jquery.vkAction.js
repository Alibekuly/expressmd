(function($) {
    var win = null;
    $.fn.tweetAction = function(options, callback) {
        // Стандартные параметры для всплывающего окна:
        options = $.extend({
            url: window.location.href
        }, options);
        return this.click(function(e) {
            if (win) {
                e.preventDefault();
                return;
            }
            var width = 550,
                height = 350,
                top = (window.screen.height - height) / 2,
                left = (window.screen.width - width) / 2;
            var config = ['scrollbars=yes', 'resizable=yes',
                'toolbar=no', 'location=yes', 'width=' +
                width, 'height=' + height, 'left=' + left,
                'top=' + top
            ].join(',');
            // Всплывающее окно от API вКонтакте:
            win = window.open('http://vkontakte.ru/share.php?' +
                $.param(options), 'TweetWindow', config);
            (function checkWindow() {
                try {
                    // need to put this code in a try/catch:
                    if (!win || win.closed) {
                        throw "Closed!";
                    } else {
                        setTimeout(checkWindow, 100);
                    }
                } catch (e) {
                    win = null;
                    callback();
                }
            })();
            e.preventDefault();
        });
    };
})(jQuery);

$(document).ready(function(){

    $('#tweetLink').tweetAction({
        title: 'Как сделать систему "Рассказать друзьям" вКонтакте чтобы скачать с помощью JQuery и CSS',
        url: 'http://beloweb.ru/',
        description: ' Тут Вы сможете скачать классную систему "Рассказать друзьям"  вКонтакте чтобы скачать, а так же узнаете как она работает'
    },function(){
        $('.downloadButton').addClass('active_offer');
    });

});




