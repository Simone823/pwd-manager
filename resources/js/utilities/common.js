/************************ IMPORTS ************************/

// sweet alert
const Swal = require('sweetalert2/dist/sweetalert2.js');
/**********************************************************/


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


// elimina record selezionati
deleteSelectedRecord = function(routeWeb) {
    // array all form-check-input
    const allFormCheckBox = document.querySelectorAll('.form-check-input:checked');

    // array id record selezionati
    const idsRecord = []; 

    // controllo se c'è almeno un record selezionato
    if(allFormCheckBox.length == 0) {
        return Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Devi selezionare almeno un record.',
        });
    }

    // push in idsRecord il valore delle checkbox  
    allFormCheckBox.forEach(checkBox => {
        idsRecord.push(checkBox.value);
    });

    axios.post(routeWeb, 
        {
            idsRecord: idsRecord
        }, 
        {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }
    )
    .then((res) => {
        location.reload();
    })
    .catch((err) => {
        console.error(err);
    });
}