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






document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'assets/backProcess/loginProcess.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            var response = JSON.parse(this.responseText);
            if (response.status === 'error') {
                document.getElementById('msg').innerHTML = "<div class='redWarn'>" + response.message + "</div>";
            } else {
                window.location.href = 'home.php';
            }
        }
    };
    xhr.send('email=' + email + '&password=' + password);
});
