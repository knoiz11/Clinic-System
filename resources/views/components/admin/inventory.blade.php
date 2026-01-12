@extends('layout.admin')

@section('inventory')
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">

        <h4 class="fw-bold mb-4 text-center" style="color:#7c0020;">Inventory</h4>

        <!-- Search + Filter + Add -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <form id="inventoryFilterForm" method="GET" action="{{ route('admin.inventory') }}" class="d-flex gap-2 flex-grow-1">
                <div class="input-group" style="max-width: 270px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="ti ti-search"></i>
                    </span>
                    <input type="search" name="q" id="searchInput" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Search item name or object id...">
                </div>

            <select id="filterSupplyType" name="supply_type" class="form-select" style="max-width: 180px;">
                <option value="">Filter...</option>
                <option value="Clinic" {{ request('supply_type') == 'Clinic' ? 'selected' : '' }}>
                    Clinic
                </option>
                <option value="Office" {{ request('supply_type') == 'Office' ? 'selected' : '' }}>
                    Office
                </option>
            </select>


                <button type="button" class="btn btn-outline-secondary" id="clearFilterBtn">Clear Filter</button>
            </form>

            @if(Auth::user()->role === 'admin')
            <button class="btn btn-warning fw-bold" data-bs-toggle="modal" data-bs-target="#addItemModal" id="addNewItemBtn">
                <i class="bi bi-plus-circle me-2 text-white text-center"></i>Add Item
            </button>
            @endif
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead style="background:#7c0020; color:white;">
                    <tr>
                        <th class="text-center">Object ID</th>
                        <th class="text-center">Date of Purchase</th>
                        <th class="text-center">Supply Type</th>
                        <th class="text-center">Item Name & Brand</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Remarks</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr data-id="{{ $item->id }}">
                        <td>{{ $item->object_id }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date_purchased)->format('m/d/Y') }}</td>
                        <td>{{ $item->supply_type }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }} {{ $item->unit }}</td>
                        <td>{{ $item->remarks }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.inventory.editPage', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                </form>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-2">
            {{ $items->links() }}
        </div>

    </div>
</div>

<!-- Add/Edit Inventory Modal -->
<div class="modal fade inventory-modal" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="inventoryForm" method="POST" action="{{ route('admin.inventory.store') }}">
                @csrf
                @method('POST')
                <input type="hidden" name="item_id" id="item_id">

                <div class="modal-header" style="background:#7c0020; color:white;">
                    <h5 class="modal-title" id="addItemModalLabel">Add Inventory Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="object_id" class="form-label">Object ID</label>
                        <input type="text" class="form-control" id="object_id" name="object_id" required>
                    </div>

                    <div class="mb-3">
                        <label for="date_purchased" class="form-label">Date of Purchase</label>
                        <input type="date" class="form-control" id="date_purchased" name="date_purchased" required>
                    </div>

                    <div class="mb-3">
                        <label for="supply_type" class="form-label">Supply Type</label>
                        <select class="form-select" id="supply_type" name="supply_type" required>
                            <option value="">Select Type</option>
                            <option value="Clinic">Clinic</option>
                            <option value="Office">Office</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name & Brand</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <input type="text" class="form-control" id="unit" name="unit" required>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-bright-danger text-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary text-white fw-bold">Save Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteItemModalLabel">Delete Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger fw-bold">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById('searchInput');
    const supplyFilter = document.getElementById('filterSupplyType');
    const tableBody = document.querySelector('table.table tbody');
    const clearBtn = document.getElementById('clearFilterBtn');
    const ajaxUrl = "{{ route('admin.inventory.ajax') }}";

    if (!tableBody) return;

    let controller = null;

    async function fetchData() {
        if (controller) controller.abort();
        controller = new AbortController();

        const q = searchInput ? encodeURIComponent(searchInput.value) : '';
        const type = supplyFilter ? encodeURIComponent(supplyFilter.value) : '';
        const url = `${ajaxUrl}?q=${q}&supply_type=${type}`;

        try {
            const res = await fetch(url, { signal: controller.signal });
            if (!res.ok) throw new Error('Network error');
            const html = await res.text();
            tableBody.innerHTML = html;
        } catch (err) {
            if (err.name === 'AbortError') return; // ignored
            console.error('Inventory AJAX error', err);
        }
    }

    // Wire inputs
    if (searchInput) searchInput.addEventListener('input', () => fetchData());
    if (supplyFilter) supplyFilter.addEventListener('change', () => fetchData());
    if (clearBtn) clearBtn.addEventListener('click', () => {
        if (searchInput) searchInput.value = '';
        if (supplyFilter) supplyFilter.value = '';
        fetchData();
    });

    // Initial load (in case user landed with query params)
    fetchData();
});
</script>

@endsection
