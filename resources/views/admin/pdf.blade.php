<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ucfirst($type) }} Report</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 11px; 
            margin: 20px;
        }
        h2 { 
            text-align: center; 
            margin-bottom: 5px;
            color: #7c0020;
        }
        .header-info {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
            font-size: 10px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #999; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background: #7c0020; 
            color: white;
            font-weight: bold;
        }
        .summary-box {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .summary-box h4 {
            margin: 0 0 10px 0;
            color: #7c0020;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-clinic {
            background: #17a2b8;
            color: white;
        }
        .badge-office {
            background: #28a745;
            color: white;
        }
        .low-stock {
            color: #dc3545;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    @if ($type === 'employees')
        <h2>Employee Report</h2>
        <div class="header-info">
            Generated on {{ now()->format('F d, Y h:i A') }}
        </div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Employee ID</th>
                    <th style="text-align: center;">Visits</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->id }}</td>
                        <td style="text-align: center;">{{ $employee->appointments_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @elseif ($type === 'visits')
        <h2>Visit Report</h2>
        <div class="header-info">
            Generated on {{ now()->format('F d, Y h:i A') }}
        </div>
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

    @elseif ($type === 'inventory')
        <h2>Complete Inventory Report</h2>
        <div class="header-info">
            Generated on {{ now()->format('F d, Y h:i A') }}
        </div>
        
        <div class="summary-box">
            <h4>Summary</h4>
            <div class="summary-row">
                <span>Total Items:</span>
                <strong>{{ $totalItems }}</strong>
            </div>
            <div class="summary-row">
                <span>Clinic Supplies:</span>
                <strong>{{ $totalClinic }}</strong>
            </div>
            <div class="summary-row">
                <span>Office Supplies:</span>
                <strong>{{ $totalOffice }}</strong>
            </div>
            <div class="summary-row">
                <span>Low Stock Items (≤10):</span>
                <strong class="low-stock">{{ $lowStockCount }}</strong>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Object ID</th>
                    <th>Item Name</th>
                    <th>Type</th>
                    <th style="text-align: center;">Quantity</th>
                    <th>Unit</th>
                    <th>Date Purchased</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->object_id ?? '-' }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>
                            <span class="badge badge-{{ strtolower($item->supply_type) }}">
                                {{ $item->supply_type }}
                            </span>
                        </td>
                        <td style="text-align: center;" class="{{ $item->quantity <= 10 ? 'low-stock' : '' }}">
                            {{ $item->quantity }}
                        </td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->date_purchased ? \Carbon\Carbon::parse($item->date_purchased)->format('m/d/Y') : '-' }}</td>
                        <td>{{ $item->remarks ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @elseif (in_array($type, ['inventory-clinic', 'inventory-office', 'inventory-low-stock']))
        <h2>{{ $supplyType }} Inventory Report</h2>
        <div class="header-info">
            Generated on {{ now()->format('F d, Y h:i A') }}
        </div>

        <div class="summary-box">
            <h4>Summary</h4>
            <div class="summary-row">
                <span>Total Items in Report:</span>
                <strong>{{ count($items) }}</strong>
            </div>
            @if($type === 'inventory-low-stock')
            <div class="summary-row">
                <span>Alert Level:</span>
                <strong class="low-stock">Quantity ≤ 10</strong>
            </div>
            @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th>Object ID</th>
                    <th>Item Name</th>
                    @if($type === 'inventory-low-stock')
                    <th>Type</th>
                    @endif
                    <th style="text-align: center;">Quantity</th>
                    <th>Unit</th>
                    <th>Date Purchased</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->object_id ?? '-' }}</td>
                        <td>{{ $item->item_name }}</td>
                        @if($type === 'inventory-low-stock')
                        <td>
                            <span class="badge badge-{{ strtolower($item->supply_type) }}">
                                {{ $item->supply_type }}
                            </span>
                        </td>
                        @endif
                        <td style="text-align: center;" class="{{ $item->quantity <= 10 ? 'low-stock' : '' }}">
                            {{ $item->quantity }}
                        </td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->date_purchased ? \Carbon\Carbon::parse($item->date_purchased)->format('m/d/Y') : '-' }}</td>
                        <td>{{ $item->remarks ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>Cultural Center of the Philippines - Clinic Information System</p>
        <p>This is a system-generated report. No signature required.</p>
    </div>
</body>
</html>