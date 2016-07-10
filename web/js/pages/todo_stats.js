define(['component/todo_done_over_time', 'chart/chart'], function (TodoDoneOverTime) {

    return function () {
        TodoDoneOverTime.attachTo('#js-stat-chart');
    }
});

