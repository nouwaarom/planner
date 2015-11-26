define(['flight/component'], function(defineComponent) {

    function calendarList() {

        var startDate;
        var endDate;

        var addDays = function(date, days) {
            var result = new Date(date);
            result.setDate(result.getDate() + days);

            return result;
        }

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

        var fill = function () {
            jQuery.ajax({
                url: '/api/calendar',
                type: 'get',
                dataType: 'json',
                data: {
                    start: startDate,
                    end:   endDate
                },
                success: function (data) {
                    var list = $('.calendar-list');
                    list.empty();

                    Object.keys(data).forEach(function (day) {
                        list.append(createList(day, data[day]));
                    });

                }.bind(this),
                error: function (data) {
                    console.log("CRITICAL ERROR");
                }
            });
        };

        this.loadPreviousPage = function(e) {
            startDate = addDays(startDate, -3);
            endDate   = addDays(endDate,   -3);
            fill();
        }

        this.loadNextPage = function(e) {
            startDate = addDays(startDate, 3);
            endDate   = addDays(endDate,   3);
            fill();
        }

        this.after('initialize', function() {
            this.on('click', {
                previousPageButtonSelector: this.loadPreviousPage,
                nextPageButtonSelector:     this.loadNextPage
            });

            //fill the calendar list
            startDate = new Date();
            endDate   = addDays(startDate, 2);
            fill();
        });

        this.attributes({
            itemSelector: 'li',
            previousPageButtonSelector: '#js-previous-page',
            nextPageButtonSelector: '#js-next-page'
        });

    }

    return defineComponent(calendarList);

});
