console.log('cities.js is loaded');
document.addEventListener('DOMContentLoaded', function() {
    console.log('cities.js is loaded');
    document.getElementById('country').addEventListener('input', function() {
        let countryName = this.value;
        let countryOption = Array.from(document.getElementById('countryList').options).find(option => option.value === countryName);
        if (countryOption) {
            let countryId = countryOption.getAttribute('data-id');
            console.log(countryId);
            fetch(`/cities/${countryId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!Array.isArray(data)) {
                        throw new Error('Invalid JSON response');
                    }
                    console.log(data)
                    let cityList = document.getElementById('cityList');
                    cityList.innerHTML = '';
                    data.forEach(function(city) {
                        let option = document.createElement('option');
                        option.value = city;
                        cityList.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));
        } else {
            document.getElementById('cityList').innerHTML = '';
        }
    });
});
