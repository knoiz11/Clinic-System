
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

        @include('components.admin.footer')

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
    const previewUrl = `{{ url('reports/pdf') }}/${type}/preview`;
    const downloadUrl = `{{ url('reports/pdf') }}/${type}/download`;
    
    iframe.src = previewUrl; // load preview in modal
    downloadBtn.href = downloadUrl; // this now triggers actual download
    });


    modal.addEventListener('hidden.bs.modal', () => {
        iframe.src = ''; // clear frame when closed
    });
});
</script>
