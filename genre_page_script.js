$(function(){
    $("html").css("background-image", "url('images/album_covers/" + $(".albumCover").first().children().first().attr('id') + "')"); // The ID of the first album cover image

    $(".albumCover").css('cursor', 'pointer').click(function(){
        if($(this).children().first().hasClass('expanded'))
        {
            // Shrink the album art and title
            $(this).children().first().animate({
                width:'200px',
                height: '200px'}).removeClass('expanded');
            $(':nth-child(2)', this).animate({
                fontSize: "1.2em",
                maxWidth: "200"});
            $(".details").css({visibility: "hidden"});
        }
        else
        {
            // If another album is already expanded, shrink it
            if($(".albumCover").children().hasClass('expanded'))
            {
                $(':nth-child(1)', ".albumCover").animate({
                    width:'200px',
                    height: '200px'}).removeClass('expanded');
                $(':nth-child(2)', ".albumCover").animate({
                    fontSize: "1.2em",
                    maxWidth: "200"});
            }

            // Expand the album art and title
            $(this).children().first().animate({width:'600px', height: "600px", maxWidth: "600px"}).addClass('expanded');
            $(':nth-child(2)', this).animate({fontSize: "2.5em", width: "600px", maxWidth: "600px"});
            $(".details").css({visibility: "visible"});

            // Scroll the albums div up to the top of the album artwork
            $(".albums").animate({scrollTop: $(this).offset().top - $(this).height() / 2});

            // Set the background dynamically to each album art
            var image = $(this).children().first().attr('id');
            $("html").css("background-image", "url('images/album_covers/" + image + "')");
        }
    })

    $("#search_box").keyup(function(){
        // Remove spaces at the beginning of a word to prevent typos
        $(this).val($(this).val().replace(/^\s+/g, ''));

    });
})