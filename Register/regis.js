document.querySelector('form').addEventListener('submit', function (event) {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirm_password = document.getElementById('confirm_password').value;

    if (username === '' || password === '' || confirm_password === '') {
        alert('Mohon isi semua form!');
        event.preventDefault();
    } else if (password !== confirm_password) {
        alert('Password dan konfirmasi password tidak cocok!');
        event.preventDefault();
    }
});
