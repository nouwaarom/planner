define(['component/calendar_list', 'component/todo_list', 'component/todo_info'], function(CalendarList, TodoList, TodoInfo) {

    return function () {
        CalendarList.attachTo('#js-calendar-list');

        TodoList.attachTo('#js-todo-list');
        TodoInfo.attachTo('#js-info-box');
    }

});
