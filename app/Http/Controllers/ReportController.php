<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Appointment;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $employees = Employee::withCount('appointments')->get();
        $visits = Appointment::with('employee')->orderBy('date', 'desc')->get();
        
        // Get inventory data grouped by supply type
        $inventoryMeds = Inventory::where('supply_type', 'Meds')->get();
        $inventoryNonMeds = Inventory::where('supply_type', 'Non-Meds')->get();
        $inventoryAll = Inventory::all();
        
        // Get low stock items (quantity <= 10)
        $lowStockItems = Inventory::where('quantity', '<=', 10)->get();

        return view('components.admin.reports', compact(
            'employees', 
            'visits',
            'inventoryMeds',
            'inventoryNonMeds',
            'inventoryAll',
            'lowStockItems'
        ));
    }

    public function generatePDF($type, $mode = 'preview')
    {
        $data = [];

        switch ($type) {
            case 'employees':
                $data['employees'] = Employee::withCount('appointments')->get();
                break;

            case 'visits':
                $data['visits'] = Appointment::with('employee')->orderBy('date', 'desc')->get();
                break;

            case 'inventory':
                $data['items'] = Inventory::orderBy('supply_type')->orderBy('item_name')->get();
                $data['totalMeds'] = Inventory::where('supply_type', 'Meds')->count();
                $data['totalNonMeds'] = Inventory::where('supply_type', 'Non-Meds')->count();
                $data['totalItems'] = Inventory::count();
                $data['lowStockCount'] = Inventory::where('quantity', '<=', 10)->count();
                break;

            case 'inventory-meds':
                $data['items'] = Inventory::where('supply_type', 'Meds')
                                         ->orderBy('item_name')->get();
                $data['supplyType'] = 'Meds';
                break;

            case 'inventory-non-meds':
                $data['items'] = Inventory::where('supply_type', 'Non-Meds')
                                         ->orderBy('item_name')->get();
                $data['supplyType'] = 'Non-Meds';
                break;

            case 'inventory-low-stock':
                $data['items'] = Inventory::where('quantity', '<=', 10)
                                         ->orderBy('quantity')->get();
                $data['supplyType'] = 'Low Stock';
                break;

            default:
                abort(404);
        }

        $data['type'] = $type;
        $pdf = PDF::loadView('admin.pdf', $data);

        if ($mode === 'download') {
            return $pdf->download(ucfirst($type) . '_Report_' . now()->format('Y-m-d') . '.pdf');
        }

        return $pdf->stream();
    }
}