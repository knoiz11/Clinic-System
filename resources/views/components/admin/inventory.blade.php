
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper"
     data-layout="vertical"
     data-navbarbg="skin6"
     data-sidebartype="full"
     data-sidebar-position="fixed"
     data-header-position="fixed">

    <!-- Sidebar -->
    @include('components.admin.sidebar')

    <!-- Main Wrapper -->
    <div class="body-wrapper">

        <!-- Header -->
        @include('components.admin.header')

        <!-- Main Content -->
        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">

                            <!-- Header Section -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0">Inventory Management</h4>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                    <i class="ti ti-plus me-1"></i> Add Item
                                </button>
                            </div>

                            <!-- Search & Filter -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control" placeholder="Search item...">
                                </div>
                                <select class="form-select w-auto">
                                    <option value="">All Categories</option>
                                    <option value="Medicine">Medicine</option>
                                    <option value="Equipment">Equipment</option>
                                    <option value="Supplies">Supplies</option>
                                </select>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Price</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Paracetamol</td>
                                            <td>Medicine</td>
                                            <td><span class="badge bg-success">120</span></td>
                                            <td>Tablets</td>
                                            <td>₱2.50</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm"><i class="ti ti-edit"></i></button>
                                                <button class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Stethoscope</td>
                                            <td>Equipment</td>
                                            <td><span class="badge bg-info">15</span></td>
                                            <td>Units</td>
                                            <td>₱1,200.00</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm"><i class="ti ti-edit"></i></button>
                                                <button class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Alcohol (70%)</td>
                                            <td>Supplies</td>
                                            <td><span class="badge bg-danger">5</span></td>
                                            <td>Bottles</td>
                                            <td>₱75.00</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm"><i class="ti ti-edit"></i></button>
                                                <button class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-end mt-3">
                                <nav>
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('components.admin.footer')
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemLabel">Add New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Item Name</label>
                    <input type="text" class="form-control" placeholder="Enter item name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="form-select">
                        <option value="">Select Category</option>
                        <option>Medicine</option>
                        <option>Equipment</option>
                        <option>Supplies</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" placeholder="Enter quantity">
                </div>
                <div class="mb-3">
                    <label class="form-label">Unit</label>
                    <input type="text" class="form-control" placeholder="e.g. Tablets, Bottles, Units">
                </div>
                <div class="mb-3">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" step="0.01" class="form-control" placeholder="Enter price">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Add Item</button>
            </div>
        </div>
    </div>
</div>

