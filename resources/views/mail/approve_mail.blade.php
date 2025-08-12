<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Appointment Approve Mail</title>
</head>

<body>
    <h1>Dear {{ $patientName }},</h1>
    <p>Your appointment with Dr. {{ $doctorName }} on **{{ $appointmentDate }}** has been approved.</p>
    <p>Appointment Date: {{ $appointmentDate }}</p>
    <p>Thank you for choosing our service!</p>
    <p>
        Regards,  
        {{ config('app.name') }}
    </p>
</body>

</html>
