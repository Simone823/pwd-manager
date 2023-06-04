/************************ IMPORTS ************************/

// sweet alert
const Swal = require('sweetalert2/dist/sweetalert2.js');
/**********************************************************/


// Visualizza password & username account
apiViewPasswordAccount = function(apiToken, idAccount) {
    axios.get('/api/viewPasswordAccount', {
        headers: {
            Authorization: apiToken,
        },
        params: {
            idAccount: idAccount
        }
    })
    .then((res) => {
        // username & password
        const {username, password} = res.data.data;

        return Swal.fire({
            title: 'Password Account',
            html: `
                <div class="form-floating mb-4">
                    <input type="text" class="form-control input-violet shadow-sm" id="username" name="username" value="${username}" placeholder="Username" readonly>
                    <label for="username" class="text-violet">Username</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control input-violet shadow-sm" id="password" name="password" value="${password}" placeholder="Password" readonly>
                    <label for="password" class="text-violet">Password</label>
                </div>
            `,
        });
    })
    .catch((err) => {
        // error message
        const {message} = err.response.data;
        
        return Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        })
    })
}