window.onload = function() {
    const inputs = document.getElementsByClassName('input');
    const emailInput = document.getElementById('email');
    const countryInput = document.getElementById('country');
    const cityInput = document.getElementById('city');

    const cities = {
        Morocco: ['Casablanca', 'Marrakech', 'Fes', 'Tangier', 'Rabat', 'Agadir', 'Meknes', 'Oujda', 'Kenitra', 'Tetouan'],
        USA: ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Philadelphia', 'Phoenix', 'San Antonio', 'San Diego', 'Dallas', 'San Jose'],
        Canada: ['Toronto', 'Montreal', 'Vancouver', 'Calgary', 'Edmonton', 'Ottawa', 'Winnipeg', 'Quebec City', 'Hamilton', 'Kitchener'],
        France: ['Paris', 'Marseille', 'Lyon', 'Toulouse', 'Nice', 'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux', 'Lille'],
        Germany: ['Berlin', 'Hamburg', 'Munich', 'Cologne', 'Frankfurt', 'Stuttgart', 'Düsseldorf', 'Dortmund', 'Essen', 'Leipzig'],
        Italy: ['Rome', 'Milan', 'Naples', 'Turin', 'Palermo', 'Genoa', 'Bologna', 'Florence', 'Bari', 'Catania'],
        Japan: ['Tokyo', 'Yokohama', 'Osaka', 'Nagoya', 'Sapporo', 'Fukuoka', 'Kobe', 'Kawasaki', 'Kyoto', 'Saitama'],
        Australia: ['Sydney', 'Melbourne', 'Brisbane', 'Perth', 'Adelaide', 'Gold Coast', 'Canberra', 'Newcastle', 'Wollongong', 'Logan City'],
        Brazil: ['São Paulo', 'Rio de Janeiro', 'Salvador', 'Brasília', 'Fortaleza', 'Belo Horizonte', 'Manaus', 'Curitiba', 'Recife', 'Porto Alegre'],
        China: ['Shanghai', 'Beijing', 'Chongqing', 'Tianjin', 'Guangzhou', 'Shenzhen', 'Wuhan', 'Dongguan', 'Chengdu', 'Nanjing']
    };

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

    countryInput.addEventListener('change', function() {
        const selectedCountry = this.value;
        const countryCities = cities[selectedCountry];

        cityInput.innerHTML = '';

        countryCities.forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.text = city;
            cityInput.appendChild(option);
        });
    });
}

document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var name = document.getElementById('name').value;
    var address = document.getElementById('address').value;
    var country = document.getElementById('country').value;
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

    xhr.send('email=' + email + '&password=' + password + '&name=' + name + '&address=' + address + '&country=' + country + '&city=' + city);
});
