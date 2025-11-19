@extends('layout.admin')

@section('inventory')
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">

        <h4 class="fw-bold mb-4 text-center" style="color:#7c0020;">Inventory</h4>

        <!-- Search + Filter + Add -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex gap-2 flex-grow-1">
                <div class="input-group" style="max-width: 270px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="ti ti-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search...">
                </div>

                <select id="filterSupplyType" class="form-select" style="max-width: 180px;">
                    <option value="">Filter...</option>
                    <option value="Clinic">Clinic</option>
                    <option value="Office">Office</option>
                </select>

                <button class="btn btn-outline-secondary" id="clearFilterBtn">Clear Filter</button>
            </div>

            @if(Auth::user()->role === 'admin')
            <button class="btn btn-warning fw-bold" data-bs-toggle="modal" data-bs-target="#addItemModal" id="addNewItemBtn">
                Add Item
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
                            <button class="btn btn-sm btn-primary editItemBtn">Edit</button>
                            <button class="btn btn-sm btn-danger deleteItemBtn">Delete</button>
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
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="inventoryForm" method="POST" action="{{ route('admin.inventory.store') }}">
                @csrf
                @method('POST')
                <input type="hidden" name="item_id" id="item_id">

                <div class="modal-header" style="background:#7c0020; color:white;">
                    <h5 class="modal-title" id="addItemModalLabel">Add/Edit Inventory Item</h5>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold">Save Item</button>
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
    const addItemModal = new bootstrap.Modal(document.getElementById('addItemModal'));
    const deleteItemModal = new bootstrap.Modal(document.getElementById('deleteItemModal'));

    // Add New Item button
    document.getElementById('addNewItemBtn').addEventListener('click', () => {
        document.getElementById('inventoryForm').reset();
        document.getElementById('inventoryForm').action = "{{ route('admin.inventory.store') }}";
        document.getElementById('inventoryForm').querySelector('input[name="_method"]').value = 'POST';
        document.getElementById('item_id').value = '';
    });

    // Edit Item button
    document.querySelectorAll('.editItemBtn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const cells = row.children;
            const itemId = row.dataset.id;

            document.getElementById('item_id').value = itemId;
            document.getElementById('object_id').value = cells[0].innerText;
            const dateParts = cells[1].innerText.split('/');
            document.getElementById('date_purchased').value = `${dateParts[2]}-${dateParts[0]}-${dateParts[1]}`;
            document.getElementById('supply_type').value = cells[2].innerText;
            document.getElementById('item_name').value = cells[3].innerText;
            document.getElementById('quantity').value = parseInt(cells[4].innerText);
            document.getElementById('unit').value = cells[4].innerText.replace(/\d+/g,'').trim();
            document.getElementById('remarks').value = cells[5].innerText;

            // Change form action and method for update
            document.getElementById('inventoryForm').action = `/admin/inventory/${itemId}`;
            document.getElementById('inventoryForm').querySelector('input[name="_method"]').value = 'PATCH';

            addItemModal.show();
        });
    });

    // Delete Item button
    document.querySelectorAll('.deleteItemBtn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const itemId = row.dataset.id;
            document.getElementById('deleteForm').action = `/admin/inventory/${itemId}`;
            deleteItemModal.show();
        });
    });

</script>
@endsection
