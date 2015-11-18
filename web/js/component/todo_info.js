define(['flight/component'], function (defineComponent) {

    function todoInfo() {

        //close the info box
        this.closeInfo = function (e) {
            $('#js-info-box').animate({ 'top': '-200%' });
        };

        //set todo item to done or delete it
        this.markDone = function (e) {
            jQuery.ajax({
                url: '/api/todo/mark_done/' + this.select('doneButtonSelector').attr("todo-id"),
                type: 'post',
                dataType: 'json',
                success: function (data) {
                   console.log("done");
                }
            });
        }

        this.deleteTodo = function (e) {
            jQuery.ajax({
                url: '/api/todo/delete_todo/' + this.select('deleteButtonSelector').attr("todo-id"),
                type: 'post',
                dataType: 'json',
                success: function (data) {
                   console.log("done");
                }
            });
        }

        this.after('initialize', function () {
            this.on('click', {
                closeButtonSelector:  this.closeInfo,
                doneButtonSelector:   this.markDone,
                deleteButtonSelector: this.deleteTodo
            });
        });

        this.attributes({
            closeButtonSelector:  '#js-close-info-box',
            doneButtonSelector:   '#js-todo-mark-done',
            deleteButtonSelector: '#js-todo-delete'
        });

    }

    return defineComponent(todoInfo);

});
