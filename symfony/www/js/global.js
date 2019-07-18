
(function($) {
    window.whr = {
        jQuery: function() {
            return jQuery;
        },
        context: function() {
            return $(document);
        }
    };
    
    $(document).on('pjax:end', function(event) {
        window.whr.context().trigger('whr-pjax:end', event.target);
    });
    
})(jQuery)