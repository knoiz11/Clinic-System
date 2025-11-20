<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    /**
     * Display inventory list with optional search and filter
     */
    public function index(Request $request)
    {
        $query = Inventory::query();

        // Server-side search
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('item_name', 'like', "%{$q}%")
                  ->orWhere('object_id', 'like', "%{$q}%");
        }

        // Filter by supply type
        if ($request->filled('supply_type')) {
            $query->where('supply_type', $request->input('supply_type'));
        }

        $items = $query->orderBy('object_id')->paginate(10)->withQueryString();

        return view('components.admin.inventory', compact('items'));
    }

    /**
     * AJAX endpoint returning filtered inventory rows (partial view)
     */
    public function ajax(Request $request)
    {
        $query = Inventory::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('item_name', 'like', "%{$q}%")
                  ->orWhere('object_id', 'like', "%{$q}%");
        }

        if ($request->filled('supply_type')) {
            $query->where('supply_type', $request->input('supply_type'));
        }

        $items = $query->orderBy('object_id')->get();

        return view('components.admin.partials.inventory-table', compact('items'));
    }

    /**
     * Store a new inventory item
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'object_id' => 'nullable|string|max:50',
            'date_purchased' => 'nullable|date',
            'supply_type' => 'nullable|string|max:100',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        Inventory::create($data);

        return back()->with('success', 'Item added successfully.');
    }

    /**
     * Show a single inventory item (used for AJAX editing)
     */
    public function edit(Inventory $inventory)
    {
        return response()->json($inventory);
    }

    /**
     * Show edit page for a single inventory item (page-based editing)
     */
    public function editPage(Inventory $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }

    /**
     * Update an existing inventory item
     */
    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'object_id' => 'nullable|string|max:50',
            'date_purchased' => 'nullable|date',
            'supply_type' => 'nullable|string|max:100',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        $inventory->update($data);

        return back()->with('success', 'Item updated successfully.');
    }

    /**
     * Delete an inventory item
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return back()->with('success', 'Item deleted successfully.');
    }
}
