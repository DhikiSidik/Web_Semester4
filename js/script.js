function showErrorAlert(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message
    });
}

function showSuccessAlert(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message
    });
}

function validateNumber(event) {
    var keyCode = event.which ? event.which : event.keyCode;
    if (keyCode < 48 || keyCode > 57) {
        event.preventDefault();
    }
}

