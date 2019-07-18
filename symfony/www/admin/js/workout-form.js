var fixed_field = document.querySelector('#workout-fixed');
var rate_field = document.querySelector('#workout-rate');
var hours_h_field = document.querySelector('#workout-hours_h');
var hours_m_field = document.querySelector('#workout-hours_m');
var fixed_type = document.querySelector('#fixed_type');
var hourly_type = document.querySelector('#hourly_type');
var currency_id = document.querySelector('#workout-currency_id');
var rate_type = document.querySelector('#workout-rate_type');

jQuery(document).on('change', '#workout-user_id', function(){

    if (usersSalary[this.value].salary_type == 'fixed') {
        rate_type.value = usersSalary[this.value].salary_type;
        fixed_type.classList.remove('hidden');
        hourly_type.classList.add('hidden');
        fixed_field.value = usersSalary[this.value].salary;
        rate_field.value = '';
        hours_h_field.value = '';
        hours_m_field.value = '';
        currency_id.value = usersSalary[this.value].currency_id;

    } else if (usersSalary[this.value].salary_type == 'hourly') {
        rate_type.value = usersSalary[this.value].salary_type;
        fixed_type.classList.add('hidden');
        hourly_type.classList.remove('hidden');
        fixed_field.value = '';
        currency_id.value = usersSalary[this.value].currency_id;
        rate_field.value = usersSalary[this.value].salary;
    }
});

jQuery(document).on('change', '#workout-rate_type', function(){

    var user_id = document.querySelector('#workout-user_id');

    if (this.value == 'fixed') {
        fixed_type.classList.remove('hidden');
        hourly_type.classList.add('hidden');
        fixed_field.value = usersSalary[user_id.value].salary;
        rate_field.value = '';
        hours_h_field.value = '';
        hours_m_field.value = '';
        currency_id.value = usersSalary[user_id.value].currency_id;

    } else if (this.value == 'hourly') {
        fixed_type.classList.add('hidden');
        hourly_type.classList.remove('hidden');
        fixed_field.value = '';
        currency_id.value = usersSalary[user_id.value].currency_id;
        rate_field.value = usersSalary[user_id.value].salary;
    }
});
