<!DOCTYPE html>
<html>

<head>
    <title>National Labor Summary Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
</head>

<body>

    <h2>National Labor Summary Report</h2>

    <table>
        <tr>
            <th>Total Employees</th>
            <td>{{ $employees }}</td>
        </tr>
        <tr>
            <th>Approved Employers</th>
            <td>{{ $employers }}</td>
        </tr>
        <tr>
            <th>Employment Records</th>
            <td>{{ $histories }}</td>
        </tr>
        <tr>
            <th>Total Disputes</th>
            <td>{{ $disputes }}</td>
        </tr>
    </table>

    <p style="margin-top:40px;">
        Generated on: {{ now()->format('d M Y') }}
    </p>

</body>

</html>