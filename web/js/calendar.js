/*
 * Highlights appointments and todo items that are linked
 */
var attribute = "elevation";

var items = document.getElementsByClassName("item");

var i, j;

for(i = 0; i < items.length; i++)
{
    items[i].addEventListener("mouseenter", function(event)
    {
        var id = event.target.dataset.id;

        var todo = document.querySelectorAll("[data-id]");

        for(j = 0; j < todo.length; j++)
        {
            if( todo[j].dataset.id == id){
                todo[j].setAttribute(attribute, "4");
            }
        }
        event.target.setAttribute(attribute, "4");
    });

    items[i].addEventListener("mouseleave", function(event)
    {
        var id = event.target.dataset.id;

        var todo = document.querySelectorAll("[data-id]");

        for(j = 0; j < todo.length; j++)
        {
            if( todo[j].dataset.id == id){
                todo[j].setAttribute(attribute, "0");
            }
        }
        event.target.setAttribute(attribute, "0");
    });
}


function goPage(start) {
    var parts = window.location.pathname.split("/");

    if (parts.length == 3) {
        parts.push(Number(parts.pop()) + start);
    }

    else {
        parts.push(start);
    }

    window.location.pathname = parts.join("/");
}
