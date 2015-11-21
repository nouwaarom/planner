define(['flight/component'], function(defineComponent) {

    function calendarList() {

        var createList = function (day, appointments) {
            var list = '<paper-material elevation="1" class=col-day>';
            list += '<h1 class="day-name">' + day + '</h1>';

            list += '<ul class=day-list>';
                appointments.forEach( function(appointment) {
                    list += createAppointment(appointment);
                });
            list += '</ul>';
            list += '</paper-material>';

            return list;
        }

        //Todo add edit appointmen/deadline functionality
        var createAppointment = function (appointment) {
            var item = '<paper-button class="item" data-id="' + appointment.id + '">';
            item += appointment.description;
            item += '</paper-button>';

            return item;
        }

        this.fill = function (e) {
            jQuery.ajax({
                url: '/api/calendar',
                type: 'get',
                dataType: 'json',
                data: {
                    start: 'today',
                    end:   'today +2 days'
                },
                success: function (data) {
                    var list = $('#js-calendar-list');

                    Object.keys(data).forEach(function (day) {
                        list.append(createList(day, data[day]));
                    });

                }.bind(this),
                error: function (data) {
                    console.log("CRITICAL ERROR");
                }
            });
        };

        this.after('initialize', function() {
            this.fill();
        });

        this.attributes({
            itemSelector: 'li'
        });

    }

    return defineComponent(calendarList);

});
