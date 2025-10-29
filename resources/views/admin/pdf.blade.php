<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ucfirst($type) }} Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <h2>{{ ucfirst($type) }} Report</h2>

    @if ($type === 'employees')
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Employee ID</th>
                    <th>Visits</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->appointments_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif ($type === 'visits')
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Employee</th>
                    <th>Reason for Visit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($visits as $visit)
                    <tr>
                        <td>{{ $visit->date }}</td>
                        <td>{{ $visit->time }}</td>
                        <td>{{ $visit->employee ? $visit->employee->name : 'N/A' }}</td>
                        <td>{{ $visit->reason ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
