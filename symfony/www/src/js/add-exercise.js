jQuery(function ($) {
  
  $(document).on('click', '.add-another-alternate', function(e) {
      e.preventDefault();
      let template = $('#alternate-template').html();
      let alternate = $(template);
      alternate.appendTo('.alternate-wrapper');
  });
  
  $(document).on('click', '.remove-alternate', function(e) {
      $(this).closest('.alternate-line').remove();
  });
})
