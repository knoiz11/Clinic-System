@extends('layout.admin')

@section('inventory')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
                <h4 class="fw-bold mb-4 text-center" style="color:#7c0020;">Edit Inventory Item</h4>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.inventory.update', $inventory->id) }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="object_id" class="form-label">Object ID</label>
                    <input type="text" class="form-control" id="object_id" name="object_id" value="{{ old('object_id', $inventory->object_id) }}">
                </div>

                <div class="mb-3">
                    <label for="date_purchased" class="form-label">Date of Purchase</label>
                    <input type="date" class="form-control" id="date_purchased" name="date_purchased" value="{{ old('date_purchased', $inventory->date_purchased) }}">
                </div>

                <div class="mb-3">
                    <label for="supply_type" class="form-label">Supply Type</label>
                    <select class="form-select" id="supply_type" name="supply_type">
                        <option value="">Select Type</option>
                        <option value="Clinic" {{ old('supply_type', $inventory->supply_type) == 'Clinic' ? 'selected' : '' }}>Clinic</option>
                        <option value="Office" {{ old('supply_type', $inventory->supply_type) == 'Office' ? 'selected' : '' }}>Office</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="item_name" class="form-label">Item Name & Brand</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" value="{{ old('item_name', $inventory->item_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="0" value="{{ old('quantity', $inventory->quantity) }}" required>
                </div>

                <div class="mb-3">
                    <label for="unit" class="form-label">Unit</label>
                    <input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit', $inventory->unit) }}">
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks">{{ old('remarks', $inventory->remarks) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.inventory') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-warning">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
