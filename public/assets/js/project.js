$(function () {
    // Show the modal when the add project button is clicked
    $('#addProjectModalButton').click(function () {
        $('#addProjectModal').modal('show');
    });
});


function returnItem() {
    var confirmed = confirm("Are you sure you want to return the item?");
    if (confirmed) {
        var request = new XMLHttpRequest();
        request.open('POST', '/update-item-status', true);
        request.setRequestHeader('Content-Type', 'application/json');
        request.onreadystatechange = function () {
            if (request.readyState === XMLHttpRequest.DONE && request.status === 200) {
                // Handle the response from the server if needed
                // ...
            }
        };
        // request.send(JSON.stringify({ itemId: {{ $request->id }} }));
    }
}


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





document.getElementById('profile_picture').onchange = function () {
    var reader = new FileReader();
    reader.onload = function (e) {
        document.querySelector('.avatar img').src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
};

//Filter dropdown
$(document).ready(function () {
    $('.dropdown-toggle').on('click', function (event) {
        event.stopPropagation(); // Prevent propagation to document click event

        $(this).siblings('.dropdown-menu').toggleClass('show');
    });

    $('.dropdown-item').on('click', function () {
        var selectedText = $(this).text();
        $(this).closest('.dropdown').find('.dropdown-toggle').text(selectedText);
    });

    $(document).on('click', function (e) {
        if (!$('.dropdown').is(e.target) && $('.dropdown').has(e.target).length === 0) {
            $('.dropdown-menu').removeClass('show');
        }
    });
});









function showReturnItemModal(id) {
    console.log("testing");
    $('#confirmReturnBtn').data('id', id);
    $('#returnItemModal').modal('show');
}

function cancelRequest() {
    // Perform any necessary actions

    // Close the modal
    $('#returnItemModal').modal('hide');
}






