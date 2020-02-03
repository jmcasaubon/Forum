$(document).ready(function() { // Une fois que le document (layout) HTML/CSS a bien été complètement chargé...
    $(".del-topic").on("click", function(evt) {
        evt.preventDefault()

        if (confirm("Do you really want to remove this topic ?")) {
            $(location).attr('href', $(this).attr('href')) 
        }
    })
    
    $(".del-post").on("click", function(evt) {
        evt.preventDefault()

        if (confirm("Do you really want to remove this post ?")) {
            $(location).attr('href', $(this).attr('href')) 
        }
    })
})