<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover your password</title>
</head>
<body>
    <p>Hi {{ $mailData['name']}},</p>
    <p>Your new password is: {{ $mailData['password'] }}</p>
    <p>Use it to login into our website. If you want to change it, you can do that by editing your profile.</p>
</body>
</html>