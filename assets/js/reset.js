window.onload = function() {
    const inputs = document.getElementsByClassName('input');
    for(let i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('focusout', function() {
            if(this.value == '') {
                this.classList.add('invalid-input');
            } else {
                this.classList.remove('invalid-input');
            }
        });
    }
}
window.onload = function() {
const inputs = document.getElementsByClassName('input');
const emailInput = document.getElementById('email');

let emailPattern = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

for(let i = 0; i < inputs.length; i++) {
    inputs[i].addEventListener('focusout', function() {
        if(this.value == '') {
            this.classList.add('invalid-input');
        } else {
            this.classList.remove('invalid-input');
        }
    });
}

emailInput.addEventListener('focusout', function() {
    if(!this.value.match(emailPattern)) {
        this.classList.add('invalid-input');
    } else {
        this.classList.remove('invalid-input');
    }
});
}


let step = 1;

document.getElementById('resetForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'assets/backProcess/passResetProcess.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status === 200) {
            let response = JSON.parse(this.responseText);
            if (response.status === 'error') {
                document.getElementById('msg').innerHTML = "<div class='redWarn'>" + response.message + "</div>";
            } else {
                if (step == 1) {
                    document.getElementById('submit').innerHTML = "Confirm";
                    document.getElementById('otpContainer').style.display = "block";
                    document.getElementById('passwordContainer').style.display = "block";
                    document.getElementById('msg').innerHTML = "<div class='greenWarn'>" + response.message + "</div>";
                    step++;
                } else if (step == 2) {
                    document.getElementById('submit').innerHTML = "Done";
                    document.getElementById('msg').innerHTML = "<div class='greenWarn'>" + response.message + "</div>";
                    setTimeout(function() { 
                        window.location.href = 'login.php';
                    }, 2000);
                }
            }
        }
    };

    let params;
    if (step == 1) {
        let email = document.getElementById('email').value;
        params = 'email=' + email;
    } else if (step == 2) {
        let email = document.getElementById('email').value;
        let otp = document.getElementById('otp').value;
        let newPassword = document.getElementById('newPassword').value;
        params = 'email=' + email + '&otp=' + otp + '&newPassword=' + newPassword;
    }
    
    xhr.send(params);
});




