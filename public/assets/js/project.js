$(function () {
    // Show the modal when the add project button is clicked
    $('#addProjectModalButton').click(function () {
        $('#addProjectModal').modal('show');
    });
});


function cancelModal() {
    $('#addProjectModal').modal('hide');
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result).show();
            $('#preview-container i').hide();
            $('#remove-image').show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$("#image").change(function () {
    readURL(this);
});

$('#remove-image').click(function () {
    $('#preview').attr('src', '#').hide();
    $('#image').val('');
    $(this).hide();
});

