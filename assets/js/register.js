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

document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var name = document.getElementById('name').value;
    var address = document.getElementById('address').value;
    var city = document.getElementById('city').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'assets/backProcess/registerProcess.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            var response = JSON.parse(this.responseText);
            if (response.status === 'error') {
                document.getElementById('msg').innerHTML = "<div class='redWarn'>" + response.message + "</div>";
            } else {
                document.getElementById('msg').innerHTML = "<div class='greenWarn'>" + response.message + "</div>";
                setTimeout(function() { 
                    window.location.href = 'verify.php';
                }, 1000);

            }
        } else {
        }
    };

    xhr.send('email=' + email + '&password=' + password + '&name=' + name + '&address=' + address + '&city=' + city);
});


