/*
 * Highlights appointments and todo items that are linked
 */
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
                todo[j].classList.add("high");
            }
        }
        event.target.classList.add("high");
    });

    items[i].addEventListener("mouseleave", function(event)
    {
        var id = event.target.dataset.id;

        var todo = document.querySelectorAll("[data-id]");

        for(j = 0; j < todo.length; j++)
        {
            if( todo[j].dataset.id == id){
                todo[j].classList.remove("high");
            }
        }
        event.target.classList.remove("high");
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
