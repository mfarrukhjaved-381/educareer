@extends('user-dashboard.app')

@section('content')
<div class="container py-4">
    <div class="page-inner">
        <div class="pt-4 pb-2">
            <h3 class="fw-bold mb-1">Surveys</h3>
            <h6 class="op-7 mb-3">Your feedback helps us improve EduCareer!</h6>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-4 shadow-sm">
            <!-- Progress Bar -->
            <div class="progress mb-4">
                <div id="survey-progress-bar" class="progress-bar" style="width: 33%;" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <form action="{{ route('surveys.submit') }}" method="POST">
                @csrf
                
                <!-- Rating -->
                <div class="mb-4">
                    <label for="rating" class="form-label">How would you rate EduCareer?</label>
                    <select id="rating" name="rating" class="form-select" required>
                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 - Poor</option>
                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 - Fair</option>
                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 - Good</option>
                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 - Very Good</option>
                        <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 - Excellent</option>
                    </select>
                </div>

                <!-- Feedback -->
                <div class="mb-4">
                    <label for="feedback" class="form-label">Any suggestions or feedback?</label>
                    <textarea id="feedback" name="feedback" rows="4" class="form-control" required>{{ old('feedback') }}</textarea>
                    <small id="characterCount" class="form-text text-muted">0/1000 characters</small>
                </div>

                <!-- Anonymous Option -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="anonymousCheck" name="anonymous">
                    <label class="form-check-label" for="anonymousCheck">
                        Submit anonymously
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Submit Feedback</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Update progress bar based on form completion (example: 33% progress for this part)
    document.getElementById('rating').addEventListener('change', function() {
        let progress = 66;  // Assume user has filled rating (you can adjust as more fields are completed)
        document.getElementById('survey-progress-bar').style.width = progress + '%';
        document.getElementById('survey-progress-bar').setAttribute('aria-valuenow', progress);
    });

    // Character count for feedback text area
    document.getElementById('feedback').addEventListener('input', function() {
        let count = this.value.length;
        document.getElementById('characterCount').textContent = `${count}/1000 characters`;
    });

    // Rating Tooltip
    document.querySelectorAll('#rating option').forEach(function(option) {
        option.addEventListener('mouseover', function() {
            const ratingText = {
                1: 'Poor',
                2: 'Fair',
                3: 'Good',
                4: 'Very Good',
                5: 'Excellent'
            };
            let tooltip = document.createElement('div');
            tooltip.id = 'rating-tooltip';
            tooltip.style.position = 'absolute';
            tooltip.style.backgroundColor = '#000';
            tooltip.style.color = '#fff';
            tooltip.style.padding = '5px';
            tooltip.style.borderRadius = '5px';
            tooltip.textContent = ratingText[option.value];
            document.body.appendChild(tooltip);
            
            option.addEventListener('mouseleave', function() {
                document.body.removeChild(tooltip);
            });
        });
    });
</script>
@endsection
