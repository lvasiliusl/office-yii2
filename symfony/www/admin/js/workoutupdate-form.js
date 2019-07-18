jQuery(document).on('change', '#workoutupdate-rate_type', function(){

    var fixed_field = document.querySelector('#workoutupdate-fixed');
    var rate_field = document.querySelector('#workoutupdate-rate');
    var hours_h_field = document.querySelector('#workoutupdate-hours_h');
    var hours_m_field = document.querySelector('#workoutupdate-hours_m');
    var fixed_type = document.querySelector('#fixed_type');
    var hourly_type = document.querySelector('#hourly_type');

    if (this.value == 'fixed') {
        fixed_type.classList.remove('hidden');
        hourly_type.classList.add('hidden');
        rate_field.value = '';
        hours_h_field.value = '';
        hours_m_field.value = '';
    } else if (this.value == 'hourly') {
        fixed_type.classList.add('hidden');
        hourly_type.classList.remove('hidden');
        fixed_field.value = '';
    }
});
