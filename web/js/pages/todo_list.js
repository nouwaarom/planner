define(['component/todo_list', 'component/done_list', 'component/todo_info'], function (TodoList, DoneList, TodoInfo) {

    return function () {

        TodoList.attachTo('#js-todo-list');
        DoneList.attachTo('#js-done-list');

        TodoInfo.attachTo('#js-info-box');

    }

});
