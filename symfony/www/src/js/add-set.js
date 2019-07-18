jQuery(function ($) {
  $('.add-set').on('click', function (e) {
    let amountOfSets = $(this).parent().siblings('.exercises_completed_area').children('.exercises_completed').length;
    
    console.log($(this).parent().siblings('.exercises_completed_area'))
    let dayNumber = $(this).parent().siblings('.exercises_completed_area').attr('data-day');
    /* reps */
    const maxReps = 30;
    const repsStep = 1;
    const repsSelectName = 'repsD'+ dayNumber +'E'+ (amountOfSets + 1); // generate name
    let repsOptions = '';

    for (let i = 1; i <= maxReps; i += repsStep) {
      repsOptions += '<option value="' + i + '">' + i + '</option>'
    }

    /* weight */
    const maxWeight = 150;
    const weightStep = 10;
    const weightSelectName = 'weightD'+ dayNumber +'E'+ (amountOfSets + 1); // generate name
    let weightOptions = '';

    for (let i = weightStep; i <= maxWeight; i += weightStep) {
      weightOptions += '<option value="' + i + '">' + i + ' Kg</option>'
    }

    

    let setHtml = '<ul class="exercises_completed">' +
                '<li><span class="number">#'+ (amountOfSets + 1) +'</span></li>' +
                '<li><div class="select_wrapper">' +
                '<select id="" name="'+ repsSelectName +'">' +
                '<option value="" hidden selected>Select...</option>' + repsOptions +
                '</select>' +
                '</div></li>' +
                '<li><div class="select_wrapper">' +
                '<select id="" name="'+ weightSelectName +'">' +
                '<option value="" hidden selected>Select...</option>' + weightOptions +
                '</select></div></li></ul>'
                
    $('.exercises_completed_area').append(setHtml)
    e.preventDefault()
    return false;
  })
})