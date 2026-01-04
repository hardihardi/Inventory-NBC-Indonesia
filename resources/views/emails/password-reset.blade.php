<!DOCTYPE html>
<html>
<head>
    <style>
        .button {
            background-color: #3498db;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <h2>Halo!</h2>
    <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
    <p>Silakan klik tombol di bawah ini untuk mereset password Anda:</p>
    <a href="{{ $link }}" class="button">Reset Password</a>
    <p>Link reset password ini akan kadaluarsa dalam 60 menit.</p>
    <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.</p>
    <p>Terima kasih,<br>{{ config('app.name') }}</p>
    <hr>
    <p style="font-size: 0.8rem; color: #777;">Jika Anda kesulitan mengklik tombol "Reset Password", salin dan tempel URL di bawah ini ke browser Anda:<br>{{ $link }}</p>
</body>
</html>
