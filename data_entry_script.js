$(function(){

    $(":text").keyup(function(){

        $(this).val($(this).val().replace(/^\s+/g, ''));

    });
})