$('table tr').click(function(event){
    console.log();
    if ($(event.target).hasClass("except")) return true
    else window.location = $(this).data('href'); return false;
});

$('.btn-filter').on('click', function () {
    var $target = $(this).data('filter');
    if ($target == 'Y') {
        $('.table tr').css('display', 'none');
        $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
    } else {
        $('.table tr').css('display', 'none').fadeIn('slow');
    }
});

$('.navbar-search').on('keypress',function(e) {
    if(e.which == 13) {
        console.log('You pressed enter!');
    }
});
