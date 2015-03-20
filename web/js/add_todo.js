var $collectionHolder;

// setup an "add a tag" link
var $addTodoLink = $('<a href="#" class="add_todo_link">Todo for this appointment</a>');
var $newLinkLi = $('<li></li>').append($addTodoLink);

jQuery(document).ready(function($) {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.todo');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTodoLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTodoForm($collectionHolder, $newLinkLi);
    });
});

function addTodoForm($collectionHolder, $newLinkLi)
{
    var prototype = $collectionHolder.data('prototype');

    var index = $collectionHolder.data('index');

    var newForm = prototype.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);

    var $newFormLi = jQuery('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}


