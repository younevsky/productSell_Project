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

document.getElementById('verifyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var code = document.getElementById('code').value;
    var email = document.getElementById('email').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'assets/backProcess/verifyProcess.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            var response = JSON.parse(this.responseText);
            if (response.status === 'error') {
                document.getElementById('msg').innerHTML = "<div class='redWarn'>" + response.message + "</div>";

            } else {
                document.getElementById('msg').innerHTML = "<div class='greenWarn'>" + response.message + "</div>";

                setTimeout(function() { 
                    window.location.href = 'home.php';
                }, 1000);
                
            }
        } else {
        }
    };

    xhr.send('email=' + email + '&code=' + code);
});


