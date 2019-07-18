jQuery(function ($) {
    let dayNumber;
    let weekNumber;
    let modal_wrap = $('#addExercise');
    let addExerciseModal;
    // Adding exercises to tables via modal
    
    if( modal_wrap.length ){
        addExerciseModal = new Foundation.Reveal(modal_wrap);
    }
    
    function initHandlers() {
        $('select#exercise_name').change(function (e) {
            renderInfoBoxes(e.target.value, $('#add_exercise').data('line_id'))
        });

        $('#add_exercise').on('click', function (e) {
            e.preventDefault();
            pasteToTable();
            let tableIndex = dayNumber - 1;

            let willOpenIndex = $('.mobile-accordion:eq(' + tableIndex + ') tbody tr').length - 1
            $(window).trigger('updateTableAccordion', ['.mobile-accordion', 0, 767, willOpenIndex, tableIndex]);
        });
    }
    
    initHandlers();
    
    window.whr.context().on('whr-pjax:end', function() {
        modal_wrap = $('#addExercise');
        
        if( modal_wrap.length ){
            addExerciseModal = new Foundation.Reveal(modal_wrap);
        }
        
        initHandlers();
    });
  
    $(document).on('click', '.add-new-day-block', function (e) {
        e.preventDefault()
        
        const week = $(this).closest('.week-wrap');
        const itemsLength = parseInt(week.data('counter'));
        const nextItemIndex = itemsLength + 1
        const currentAmountOfDays = week.find('.day-block').length // current length of days
        const indexNextDay = currentAmountOfDays + 1 // next index of day
        const new_day_template = $('#day-template').html();
        
        week.data('counter', nextItemIndex);
        
        let day = new_day_template.replace(new RegExp("{{day}}","gm"), nextItemIndex).replace(new RegExp("{{week}}","gm"), week.data('week')).replace(new RegExp("{{day_number}}","gm"), indexNextDay);

        week.find('.days').append(day);
    });


    $(document).on('click', '.add-new-exercise', function (e) {
        e.preventDefault();
        
        modalOpen(this);
    });
    
    $(document).on('click', '.exercise-line td:not(:first-child)', function (e) {
        e.preventDefault();
        var line = $(this).closest('.exercise-line');
        
        modalOpen(this, line.attr('id'));
    });
    
    $(document).on('click', '.delete-exercises', function (e) {
        e.preventDefault();
        
        let day = $(this).closest('.day-block');
        let checked_exercises = day.find('.exercise-actions-checkbox:checked').closest('tr');
        
        $(this).closest('.day-block').find('.exercise-actions').removeClass('visible');
        
        checked_exercises.each(function() {
            let exercise_id = $(this).find('input[data-name="id"]').val();
            
            if( exercise_id ) {
                $('input[name="RemoveStrengthExercise['+exercise_id+']"]').attr('checked', true);
            }
        });
        
        checked_exercises.remove();
    });
    
    $(document).on('click', '.remove_day_block', function (e) {
        e.preventDefault();
        removeDay(this);
    });
    
    $(document).on('change', '.day-exercise .exercise-actions-checkbox', function() {
        var has_checked_exercises = $(this).closest('tbody').find('.exercise-actions-checkbox:checked').length > 0;
        
        if( has_checked_exercises ) {
            $(this).closest('.day-block').find('.exercise-actions').addClass('visible');
        } else {
            $(this).closest('.day-block').find('.exercise-actions').removeClass('visible');
        }
    });

    // Remove day on click btn with text 'Remove'
    function removeDay (element) {
        let day = $(element).closest('.day-block');
        let day_id = day.data('id');
        
        if( day_id ) {
            $('input[name="RemoveStrengthDay['+day_id+']"]').attr('checked', true);
        }
        
        day.slideUp('fast', function () {
            $(this).remove();

            $('.week').each(function() {
                $(this).find('.day-block').each(function (index, item) {
                    let day_index = $(this).find('.day-index').val();
                    let new_day_index = index + 1;
                    
                    $(this).find('.day-index').val(new_day_index);
                    $(item).children('.white-block').children('.block-head').children('.day-number').text( new_day_index );

                    $(item).find('input, select, textarea').each(function (i, input) {
                        let inputName = $(input).attr('name');
                        let newInputName = inputName.replace("[days]["+day_index+"]", "[days]["+new_day_index+"]");
                        $(input).attr('name', newInputName );
                    });
                });
            });
        });
    }

    // Get JSON-object and open modal window
    function modalOpen(self, line_id) {
        let line = line_id ? $('#'+line_id) : false;
        let exercisesSelect = $('#exercise_name');
        const DATA = exercisesSelect.data('exercises');
        
        if (!DATA) {
            console.error('No Data')
            return false
        }

        let options = DATA.map((payloadItem) => {
            let pId = payloadItem.id;
            let pName = payloadItem.exercise_name;
            return '<option value="'+pId+'">'+ pName +'</option>';
        });
        
        dayNumber = $(self).data('day');
        weekNumber = $(self).data('week');

        exercisesSelect.html(options.join(''));
        
        if( line ) {
            let exercise_id = line.find('input[data-name="id"]').val();
            exercisesSelect.val(exercise_id);
            renderInfoBoxes(exercisesSelect.val(), line_id);
        } else {
            renderInfoBoxes();
        }
        
        addExerciseModal.open();
    }


    // Render function
    function renderInfoBoxes(val, line_id) {
        let exercisesSelect = $('#exercise_name');
        let line = line_id ? $('#'+line_id) : false;
        const _exercisesData = exercisesSelect.data('exercises');
        const _selectedValue = val || exercisesSelect.val();
        let inputIDs = ['muscle_group', 'type', 'sets', 'reps', 'weight'];
        let currentItem;
        
        currentItem = getSingleExercise(_selectedValue, _exercisesData);

        if( line ) {
            currentItem = {
                muscle_group: currentItem.muscle_group,
                type: currentItem.type,
                sets: line.find('input[data-name="sets"]').val(),
                reps: line.find('input[data-name="reps"]').val(),
                weight: line.find('input[data-name="weight"]').val()
            }
            $('#add_exercise').data('line_id', line_id).text('Save Exercise');
        } else {
            $('#add_exercise').data('line_id', false).text('Add Exercise');
        }

        inputIDs.forEach((input) => {
            for (let key in currentItem) {
                if (input === key) {
                    $('input#' + input).val(currentItem[key]);
                }
            }
        });
    }

    // Paste exercise to table on click btn 'Add Exercise'
    function pasteToTable () {
        const _selectedValue = $('select#exercise_name').val()
        const _exercisesData = $.parseJSON($('select#exercise_name').attr('data-exercises'));
        const _single = getSingleExercise(_selectedValue, _exercisesData)
        
        let exercise_template = $('#exercise-template').html();
        let exercise_wrap = $('.week-wrap[data-week="'+weekNumber+'"] .day-block[data-day="'+dayNumber+'"] table');
        let exercise_index = parseInt(exercise_wrap.data('counter')) + 1;
        let exercise = exercise_template.replace(new RegExp("{{day}}","gm"), dayNumber).replace(new RegExp("{{week}}","gm"), weekNumber).replace(new RegExp("{{exercise}}","gm"), exercise_index);
        let line_id = $('#add_exercise').data('line_id');
        let line = line_id ? $('#'+line_id) : false;
        
        if( line ) {
            exercise = line;
        } else {
            exercise = $(exercise);
        }
        
        for (let key in _single) {
            let value = _single[key]
            
            if( $('input#' + key).length ) {
                value = $('input#' + key).val();
            }
            
            exercise.find('input[data-name="'+key+'"]').val(value);
            exercise.find('span[data-name="'+key+'"]').text(value);
        }
        
        if( !line ) {
            exercise_wrap.data('counter', exercise_index).append(exercise);
        }
        
        addExerciseModal.close();
    }




  // Return single item of exercise object. If {id} of selected value is equal to any element {id} of object, it will return this element
  function getSingleExercise (id, payload) {
    let result
    payload.forEach((payloadItem) => {
      if (parseInt(id) === parseInt(payloadItem.id)) {
        result = payloadItem
      }
    })
    return result
  }


})