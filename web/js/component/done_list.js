define(['flight/component'], function (defineComponent) {

    function doneList() {

        this.getInfo = function (e) {
            if (e.target.nodeName == 'LI') {
                var elem = $(e.target);
            } else {
                var elem = $(e.target).parent();
            }

            jQuery.ajax({
                'url': '/api/todo/' + elem.data('id'),
                'type': 'get',
                'dataType': 'json',
                'success': function (data) {

                    $('.info-title').text(data.description);
                    if (data.appointment) {
                        $('.info-text').text('Appointment: ' + data.appointment.description + ' (' + (new Date(data.appointment.epoch)).toLocaleString());
                    }
                    else if (data.deadline) {
                        $('.info-text').text('Deadline: ' + data.deadline.description + ' (' + (new Date(data.deadline.epoch)).toLocaleString());
                    }
                    else {
                        $('.info-text').text("");
                    }

                    //show the delete button
                    $('#js-todo-delete').show();
                    $('#js-todo-delete').attr("todo-id", data.id);
                    //hide the mark done button
                    $('#js-todo-mark-done').hide();

                    $('#js-info-box').animate({ 'top': '50%' });
                }
            });
        };

        this.after('initialize', function () {
            this.on('click', {
                itemSelector: this.getInfo
            });
        });

        this.attributes({
            itemSelector: 'li',
            markDoneButtonSelector: '#js-todo-mark-done',
            infoBoxSelector: '#js-info-box'
        });

    }

    return defineComponent(doneList);

});
