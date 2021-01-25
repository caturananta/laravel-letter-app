$('table tr').click(function(event){
    console.log();
    if ($(event.target).hasClass("except")) return true
    else window.location = $(this).data('href'); return false;
});

$('.navbar-search').on('keypress',function(e) {
    if(e.which == 13) {
        console.log('You pressed enter!asd');
    }
});
