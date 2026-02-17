<!DOCTYPE html>
<html>
<head>
    <title>Orders (Power Joins)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e2f0d9;
        }

        td {
            color: #555;
        }
    </style>
</head>
<body>

<h2>Orders with Products</h2>

<table>
    <thead>
        <tr>
            <th>User</th>
            <th>Product</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $row)
            <tr>
                <td>{{ $row->user_name }}</td>
                <td>{{ $row->product_name }}</td>
                <td>{{ $row->quantity }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
