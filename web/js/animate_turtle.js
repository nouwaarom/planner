jQuery(document).ready(function ($) {

    var $turtle = $('#js-turtle');
    $('#js-fan').one('click', function () {
        var $that = $(this);

        $turtle.css('transform', 'rotate(20deg)').animate({
            'right': '45%',
            'bottom': '400px'
        }, 1500).animate({
            'bottom': '45%'
        }, 500).animate({
            'bottom': '100%',
            'right': '50%',
            'width': '500%',
            'opacity': '0'
        }, 1000, function () {
            $that.animate({'right': '-200px'}, 200);
        });
    });

    var codes = [75, 73, 76, 76, 32, 84, 72, 69, 32, 84, 85, 82, 84, 76, 69];
    var index = 0;
    var $piano = $('#js-piano');
    $(document).on('keydown', function (e) {
        if (e.keyCode == 27) {
            index = 0;
            return;
        }

        if (codes[index] === e.keyCode) {
            index++;
        } else {
            index = 0;
        }

        if (index == codes.length) {
            $piano.css('display', 'block').animate({'bottom': '200px'}, 100);
            $turtle.delay(50).animate({'height': '0px'}, 100);
        }
    });

});

