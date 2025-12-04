@extends('layout.admin')

@section('reports')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h4 class="fw-bold mb-4 text-center">Reports Dashboard</h4>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-4" id="reportTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#employee-reports" type="button">Employees</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#illness-reports" type="button">Common Illnesses</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#visit-reports" type="button">Visits</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inventory-reports" type="button">Inventory</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="reportTabsContent">

                        <!-- Employee Reports -->
                        <div class="tab-pane fade show active" id="employee-reports">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">Employee Reports</h5>
                                <button class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#pdfPreviewModal" 
                                        data-type="employees">
                                    <i class="ti ti-file-type-pdf me-1"></i> Generate PDF
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Employee ID</th>
                                            <th class="text-center">Visits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($employees as $employee)
                                            <tr>
                                                <td class="fw-medium">{{ $employee->name }}</td>
                                                <td>{{ $employee->id }}</td>
                                                <td class="text-center">{{ $employee->appointments_count }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No employees found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Common Illnesses Report (Placeholder) -->
                        <div class="tab-pane fade" id="illness-reports">
                            <h5 class="fw-bold mb-3">Common Illnesses Report</h5>
                            <p class="text-muted">No illness data available yet.</p>
                        </div>

                        <!-- Visit Reports -->
                        <div class="tab-pane fade" id="visit-reports">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">Visit Reports</h5>
                                <button class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#pdfPreviewModal" 
                                        data-type="visits">
                                    <i class="ti ti-file-type-pdf me-1"></i> Generate PDF
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Employee</th>
                                            <th>Reason for Visit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($visits as $visit)
                                            <tr>
                                                <td>{{ $visit->date }}</td>
                                                <td>{{ $visit->time }}</td>
                                                <td>{{ $visit->employee ? $visit->employee->name : 'N/A' }}</td>
                                                <td>{{ $visit->reason ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No visits recorded.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Inventory Reports -->  
                        <div class="tab-pane fade" id="inventory-reports">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">Complete Inventory</h5>
                                <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#pdfPreviewModal"
                                        data-type="inventory">
                                    <i class="ti ti-file-type-pdf me-1"></i> Generate PDF
                                </button>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th>Type</th>
                                            <th class="text-center">Qty</th>
                                            <th>Unit</th>
                                            <th>Date Purchased</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($inventoryAll as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td>{{ $item->supply_type }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td>{{ $item->unit }}</td>
                                                <td>{{ $item->date_purchased }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No inventory items available.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Clinic Supplies -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">Clinic Supplies</h5>
                                <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#pdfPreviewModal"
                                        data-type="inventory-clinic">
                                    <i class="ti ti-file-type-pdf me-1"></i> Generate PDF
                                </button>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th class="text-center">Qty</th>
                                            <th>Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($inventoryClinic as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td>{{ $item->unit }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No clinic supplies.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Office Supplies -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">Office Supplies</h5>
                                <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#pdfPreviewModal"
                                        data-type="inventory-office">
                                    <i class="ti ti-file-type-pdf me-1"></i> Generate PDF
                                </button>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th class="text-center">Qty</th>
                                            <th>Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($inventoryOffice as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td>{{ $item->unit }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No office supplies.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Low Stock Alerts -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0 text-danger">Low Stock (≤10)</h5>
                                <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#pdfPreviewModal"
                                        data-type="inventory-low-stock">
                                    <i class="ti ti-file-type-pdf me-1"></i> Generate PDF
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th>Type</th>
                                            <th class="text-center">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($lowStockItems as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td>{{ $item->supply_type }}</td>
                                                <td class="text-center text-danger fw-bold">{{ $item->quantity }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No low stock items.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>


                    </div> <!-- end tab-content -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PDF Preview Modal -->
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfPreviewLabel">PDF Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="height: 80vh;">
                <iframe id="pdfFrame" src="" width="100%" height="100%" style="border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <a id="downloadPdfBtn" href="#" class="btn btn-primary" target="_blank">
                    <i class="ti ti-download me-1"></i> Download PDF
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('pdfPreviewModal');
    const iframe = document.getElementById('pdfFrame');
    const downloadBtn = document.getElementById('downloadPdfBtn');

    modal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const type = button.getAttribute('data-type');
        const previewUrl = `{{ url('admin/reports/pdf') }}/${type}/preview`;
        const downloadUrl = `{{ url('admin/reports/pdf') }}/${type}/download`;

        iframe.src = previewUrl;
        downloadBtn.href = downloadUrl;
    });

    modal.addEventListener('hidden.bs.modal', () => {
        iframe.src = '';
    });
});
</script>
@endsection
