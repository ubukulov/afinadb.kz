$(document).ready(function(){
    $('.all_education').on('click', function(e){
        e.preventDefault();
        $(this).hasClass('all_education_down') ? $(this).removeClass('all_education_down') : $(this).addClass('all_education_down');
       $('.all_education_content').toggle();
    });
});