define(['component/todo_list', 'component/doing_list', 'component/done_list', 'component/todo_info'], function (TodoList, DoingList, DoneList, TodoInfo) {

    return function () {

        TodoList.attachTo('#js-todo-list');
        DoingList.attachTo('#js-doing-list');
        DoneList.attachTo('#js-done-list');

        TodoInfo.attachTo('#js-info-box');
    }

});
