document.querySelector('form').addEventListener('submit', function (event) {
    var username = document.getElementById('username').value;
    var old_password = document.getElementById('old_password').value;
    var new_password = document.getElementById('new_password').value;

    if (username === '' || old_password === '' || new_password === '') {
        alert('Mohon isi semua form!');
        event.preventDefault();
    }
});
