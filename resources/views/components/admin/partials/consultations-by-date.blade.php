@if($consultations->isEmpty())
    <p class="text-center text-muted">No consultation records found.</p>
@else
    @foreach($consultations as $record)
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-1">
                    {{ $record->created_at->format('h:i A') }}
                </h6>
                <p class="mb-1"><strong>Diagnosis:</strong> {{ $record->diagnosis }}</p>
                <p class="mb-0"><strong>Treatment:</strong> {{ $record->treatment_plan }}</p>
            </div>
        </div>
    @endforeach
@endif
