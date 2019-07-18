jQuery(function ($) {
  var modal = new Foundation.Reveal($('#galleryModal'));
  $('.gallery li a').click(function (e) {
    let imgSrc = $(this).attr('href');
    let date = $(this).children('p').text()
    $('#galleryModal .block-head span').text(date)
    $('#galleryModal .gallery_image').append('<img src="' + imgSrc + '">')
    console.log(imgSrc)
    modal.open()
    e.preventDefault()
    return false;
  })
  $('#galleryModal')
  .on("closed.zf.reveal", function(e,$panel) {
    $('#galleryModal .block-head span').text('')
    $('#galleryModal .gallery_image').html('')
  })
})