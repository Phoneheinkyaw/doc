<!DOCTYPE html>
<html>
<head>
    <style>
        th {
            font-weight: bold;
            text-align: left;
            width: 200px;
        }
        td {
            padding: 8px;
            width: 200px;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>Total Appointments</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->patient_id }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->total_appointments }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
