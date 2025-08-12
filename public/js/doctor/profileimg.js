$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#editProfileButton').on('click', function (e) {
        e.preventDefault();
        $('#editProfileModal').modal('show');
    });

    $('#profileImage').on('change', function (event) {
        const [file] = event.target.files;
        const imgPreview = $('#newProfileImagePreview');
        const errorMessage = $('#fileError');
        const allowedExtensions = ['png', 'jpeg', 'jpg'];

        if (file) {
            const fileExtension = file.name.split('.').pop().toLowerCase();

            if (allowedExtensions.includes(fileExtension)) {
                imgPreview.attr('src', URL.createObjectURL(file));
                imgPreview.show();
                errorMessage.text(''); // Clear the error message
            } else {
                imgPreview.hide();
                errorMessage.text('Invalid file format. Only PNG, JPEG, and JPG are allowed.').css('color', 'red');
                $(this).val(''); // Clear the input value
            }
        } else {
            imgPreview.hide();
            errorMessage.text(''); // Clear the error message
        }
    });

    // Handle the form submission with AJAX
    $('#profileImageForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        const formData = new FormData(this);
        const fileInput = $('#profileImage');
        const fileError = $('#fileError');

        if (!fileInput[0].files.length) {
            fileError.text('Please select a file before submitting.').css('color', 'red');
            return; // Stop form submission if file is empty
        } else {
            fileError.text(''); // Clear the error if a file is selected
        }

        $.ajax({
            url: '/doctor/upload',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#profileImagePreview').attr('src', response.image);
                $('#doctor-header').attr('src', response.image);
                $('#editProfileModal').modal('hide');
                $('#success_message').addClass('alert alert-success').text(response.message);
                setTimeout(function () {
                    $('#success_message').fadeOut('slow');
                }, 1000);
            },
            error: function (xhr) {
                console.log(xhr.responseJSON);
                alert('An error occurred: ' + (xhr.responseJSON.message || 'Error updating the profile image.'));
            }
        });
    });
});
