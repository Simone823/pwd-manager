// seleziona tutti i record
selectAllRecord = function() {
    // Array di tutti i check select record
    $('.form-check-input').each(function(index, checkBox) {
        checkBox.checked = true;
    });

    // btn deseleziona tutto
    btnDeselectAll = $('#deselect_all_record');
    btnDeselectAll.removeClass('d-none');
}

// deseleziona tutti i record
deselectAllRecord = function() {
    // Array di tutti i check select record
    $('.form-check-input').each(function(index, checkBox) {
        checkBox.checked = false;
    });

    // btn deseleziona tutto
    btnDeselectAll = $('#deselect_all_record');
    btnDeselectAll.addClass('d-none');
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