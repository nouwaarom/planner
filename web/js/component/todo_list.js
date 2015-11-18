define(['flight/component'], function (defineComponent) {
    function todoList() {

        var createItem = function (itemData) {
            var item = '<li data-id="' + itemData.id + '">';
            item += '<paper-button class="todo">' + itemData.description + '</paper-button>';
            item += '</li>';

            return item;
        }

        this.fill = function (e) {
            jQuery.ajax({
                'url': '/api/todo/todo',
                'type': 'get',
                'dataType': 'json',
                'success': function (data) {
                    var list = $('#js-todo-list');

                    data.forEach(function (item) {
                        list.append(createItem(item));
                    });
                }.bind(this),
                'error': function (data) {
                    console.log("CRITICAL ERROR");
                }
            });
        };

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

                    //show the mark done button
                    $('#js-todo-mark-done').show();
                    $('#js-todo-mark-done').attr("todo-id", data.id);
                    //hide the delete button
                    $('#js-todo-delete').hide();

                    $('#js-info-box').animate({ 'top': '50%' });
                }
            });
        };

        this.after('initialize', function () {
            this.on('click', {
                itemSelector: this.getInfo
            });

            this.fill();
        });

        this.attributes({
            itemSelector: 'li',
            markDoneButtonSelector: '#js-todo-update-status',
            infoBoxSelector: '#js-info-box'
        });

    }

    return defineComponent(todoList);

});
