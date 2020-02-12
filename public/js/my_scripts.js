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

function cloneQuestion(){
    var q_ite = $('#q_ite');
    var i = parseInt(q_ite.val()) + 1;
    q_ite.val(i);
    var html = '<div class="col-md-4 question_block" data-id="'+i+'">' +
        '<div class="form-group">' +
        '<label id="q_t">' + '#'+i+'</label>' +
    '<input type="text" name="question['+i+']" required placeholder="Название вопроса" class="form-control">' +
        '</div>' +
        '<div class="row">' +
        '<div class="col-sm-12">' +
        '<div class="form-group row">' +
        '<label class="col-sm-1 col-form-label">A</label>' +
        '<div class="col-sm-11">' +
        '<input type="text" name="answer['+i+'][]" class="form-control" required>' +
    '</div>' +
    '</div>' +

    '<div class="form-group row">' +
        '<label class="col-sm-1 col-form-label">B</label>' +
        '<div class="col-sm-11">' +
        '<input type="text" name="answer['+i+'][]" class="form-control" required>' +
    '</div>' +
    '</div>' +

    '<div class="form-group row">' +
        '<label class="col-sm-1 col-form-label">C</label>' +
        '<div class="col-sm-11">' +
        '<input type="text" name="answer['+i+'][]" class="form-control" required>' +
    '</div>' +
    '</div>' +

    '<div class="form-group row">' +
        '<label class="col-sm-1 col-form-label">D</label>' +
        '<div class="col-sm-11">' +
        '<input type="text" name="answer['+i+'][]" class="form-control" required>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>';

    $('.question_block:last').after(html);
}