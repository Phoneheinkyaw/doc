<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Appointment Rejected Mail</title>
</head>
<body>
    <h1>Dear {{ $patientName }},</h1>
    <p>We regret to inform you that your appointment with Dr. {{ $doctorName }} on **{{ $appointmentDate }}** has been rejected.</p>
    <p>If you have any questions or need further assistance, please feel free to contact us.</p>
    <p>
        Regards,
        {{ config('app.name') }}
    </p>
</body>

</html>
