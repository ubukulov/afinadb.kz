$(document).ready(function(){
    $('.all_education').on('click', function(e){
        e.preventDefault();
        $(this).hasClass('all_education_down') ? $(this).removeClass('all_education_down') : $(this).addClass('all_education_down');
       $('.all_education_content').toggle();
    });
});

function showVideoYoutube(a) {
    var b,t;
    b = $(a).attr('data-video');
    t = $(a).prev().html();
    $('.y_title').html(t);
    $("#you_body").html('<iframe width="800" height="450" src="'+b+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>');
    $('#modal_youtube').removeClass('fade').modal('toggle');
}
function showVideo(a) {
    var b,t;
    b = $(a).attr('data-video');
    t = $(a).prev().html();
    $('.y_title').html(t);
    $("#you_body").html('<video src="'+b+'" width="900" controls></video>');
    $('#modal_youtube').removeClass('fade').modal('toggle');
}
function viewWebinar(a){
    var b;
    b = $(a).attr('data-url');
    window.open(b, '_blank');
}