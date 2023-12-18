// seleziona tutti i record
selectAllRecord = function() {
    // array all form-check-input
    const allFormCheckBox = document.querySelectorAll('.form-check-input');

    allFormCheckBox.forEach(checkBox => {
        // imposto la proprietà checked a true
        checkBox.checked = true;
    });

    // btn deseleziona tutto
    btnDeselectAll = document.getElementById('deselect_all_record');
    btnDeselectAll.classList.remove('d-none');
}


// deseleziona tutti i record
deselectAllRecord = function() {
    // array all form-check-input
    const allFormCheckBox = document.querySelectorAll('.form-check-input');

    allFormCheckBox.forEach(checkBox => {
        // imposto la proprietà checked a false
        checkBox.checked = false;
    });

    // btn deseleziona tutto
    btnDeselectAll = document.getElementById('deselect_all_record');
    btnDeselectAll.classList.add('d-none');
}

// chiudi tutti gli alert in automatico
$(document).ready(function() {
    $('.alert').each(function(index, alert) {
        setTimeout(() => {
            $(alert).hide();
        }, 3000);
    });
});

// apri un modal (verrebbe usato quando è presente un form con errori di validazione)
openModal = (idHtmlModal) => {
    let modalChangePassword = new bootstrap.Modal(document.getElementById(idHtmlModal), {
        keyboard: false
    });
    modalChangePassword.show();
}