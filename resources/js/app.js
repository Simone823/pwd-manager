require('./bootstrap');

import Swal from 'sweetalert2/dist/sweetalert2.js';

import 'sweetalert2/src/sweetalert2.scss';

// Swal.fire({
//     title: 'Sweet!',
//     html: `<input type="text" id="login" class="swal2-input" placeholder="Username">
//         <input type="password" id="password" class="swal2-input" placeholder="Password">
//     `,
//   });

// div loader
const divLoader = document.getElementById('loader');

// div page loaded
const divPageLoaded = document.getElementById('page-loaded');


// document load event
document.addEventListener('readystatechange', function(e) {
    if(document.readyState == 'complete') {
        setTimeout(() => {
            divLoader.classList.remove('d-block');
            divLoader.classList.add('d-none');

            divPageLoaded.classList.remove('d-none');
        }, 250);
    }
});