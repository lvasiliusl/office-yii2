window.whr.jQuery()(function ($) {
    function init() {
        $('.editable-input').each(function() {
            var input_wrap = $(this);
            var input = input_wrap.find('input');
            var output = $('.editable-input-body[data-output="'+input_wrap.data('input')+'"]');
            input.val(output.text());
            
            output.off('input');
            output.on('input', () => {
                input.val(output.text());
                
                setTimeout(() => {
                    input.trigger('change');
                }, 100)
            });
        });
    }
    
    window.whr.context().on('whr-pjax:end', init);
    $(document).ready(init);
});