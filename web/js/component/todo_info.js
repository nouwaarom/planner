define(['flight/component'], function (defineComponent) {

    function todoInfo() {

        //close the info box
        this.closeInfo = function (e) {
            $('#js-info-box').animate({ 'top': '-200%' });
        };

        this.startTodo = function (e) {
            var itemId = this.select('startButtonSelector').attr("todo-id");

            jQuery.ajax({
                url: '/api/todo/start_todo/' + itemId,
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    var doingList = $('#js-doing-list');
                    var item = $('li[data-id=' + itemId + ']');

                    doingList.append(item[0].outerHTML);
                    item.remove();

                    $('#js-info-box').animate({ 'top': '-200%' });
                }
            });
        };

        this.markDone = function (e) {
            var itemId = this.select('doneButtonSelector').attr("todo-id");

            jQuery.ajax({
                url: '/api/todo/mark_done/' + itemId,
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    var doneList = $('#js-done-list');
                    var item = $('li[data-id=' + itemId + ']');

                    doneList.append(item[0].outerHTML);
                    item.remove();

                    $('#js-info-box').animate({ 'top': '-200%' });
                }
            });
        };

        this.deleteTodo = function (e) {
            var itemId = this.select('deleteButtonSelector').attr("todo-id");

            jQuery.ajax({
                url: '/api/todo/delete_todo/' + itemId,
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    $('li[data-id=' + itemId + ']').remove();
                    $('#js-info-box').animate({ 'top': '-200%' });
                }
            });
        };

        this.after('initialize', function () {
        });
    }

    return defineComponent(todoInfo);
});
