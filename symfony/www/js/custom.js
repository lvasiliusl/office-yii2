
$( document ).ready(function() {
    $('[data-confirm-submit]').on('click', function(e) {
        var form = $(this).closest('form');
        var submit = window.confirm('Sure?');

        if( submit !== true ) {
            e.preventDefault();
        }
    });

});
