@extends('user-dashboard.app')

@section('content')
    <div class="cv-container">
        <form action="{{ route('uploadUserData') }}" method="POST">
            @csrf

            {{-- Basic Info --}}
            <div class="cv-section">
                <h2 class="section-title">Basic Information</h2>
                <input type="text" name="full_name" class="form-control" placeholder="Full Name">
                <input type="text" name="headline" class="form-control" placeholder="Headline (e.g. Software Developer)">
                <input type="text" name="location" class="form-control" placeholder="Location (e.g. City, Country)">
                <input type="email" name="email" class="form-control" placeholder="Email Address">
                <input type="tel" name="phone" class="form-control" placeholder="Phone Number">
            </div>

            {{-- Skills --}}
            <div class="cv-section">
                <h2 class="section-title">Skills</h2>
                <input type="text" name="skills[]" class="form-control" placeholder="Skill 1">
                <input type="text" name="skills[]" class="form-control" placeholder="Skill 2">
                <input type="text" name="skills[]" class="form-control" placeholder="Skill 3">
            </div>

            {{-- Education --}}
            <div class="cv-section">
                <h2 class="section-title">Education</h2>
                <input type="text" name="education[degree][]" class="form-control" placeholder="Degree Title">
                <input type="text" name="education[institute][]" class="form-control" placeholder="Institute Name">
                <input type="text" name="education[duration][]" class="form-control"
                    placeholder="Duration (e.g. 2020 - 2024)">
            </div>

            {{-- Experience --}}
            <div class="cv-section">
                <h2 class="section-title">Experience</h2>
                <input type="text" name="experience[title][]" class="form-control" placeholder="Job Title">
                <input type="text" name="experience[company][]" class="form-control" placeholder="Company Name">
                <input type="text" name="experience[duration][]" class="form-control"
                    placeholder="Duration (e.g. 2021 - 2023)">
            </div>

            {{-- Interests --}}
            <div class="cv-section">
                <h2 class="section-title">Interests</h2>
                <input type="text" name="interests[]" class="form-control" placeholder="Interest 1">
                <input type="text" name="interests[]" class="form-control" placeholder="Interest 2">
            </div>

            {{-- Languages --}}
            <div class="cv-section">
                <h2 class="section-title">Languages</h2>
                <input type="text" name="languages[]" class="form-control" placeholder="Language 1">
                <input type="text" name="languages[]" class="form-control" placeholder="Language 2">
            </div>

            {{-- Certifications --}}
            <div class="cv-section">
                <h2 class="section-title">Certifications</h2>
                <input type="text" name="certifications[]" class="form-control" placeholder="Certification Name">
            </div>

            {{-- Projects --}}
            <div class="cv-section">
                <h2 class="section-title">Projects</h2>
                <input type="text" name="projects[title][]" class="form-control" placeholder="Project Title">
                <textarea name="projects[description][]" class="form-control" rows="2" placeholder="Project Description"></textarea>
            </div>

            {{-- Objective --}}
            <div class="cv-section">
                <h2 class="section-title">Career Objective</h2>
                <textarea name="objective" class="form-control" rows="3" placeholder="Write your career objective here..."></textarea>
            </div>

            {{-- LinkedIn Profile Link --}}
            <div class="cv-section">
                <h2 class="section-title">Links</h2>
                <input type="text" name="linkedin_url[link][]" class="form-control" placeholder="LinkedIn Profile Link">
            </div>

            <div class="text-center">
                <button type="submit" class="submit-btn">Submit All</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Toggle section visibility
            document.querySelectorAll('.section-header').forEach(header => {
                header.addEventListener('click', () => {
                    const section = header.parentElement;
                    section.classList.toggle('active');
                    updateProgress();
                });
            });

            // Update profile completion
            function updateProgress() {
                const completedSections = document.querySelectorAll('.section.completed').length;
                const totalSections = document.querySelectorAll('.section').length;
                const progress = Math.min(100, Math.round((completedSections / totalSections) * 100));

                document.getElementById('progressBar').style.width = `${progress}%`;
                document.querySelector('.progress-text').textContent = `${progress}% complete`;
            }

            // Mark section as complete when "Save" is clicked
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const section = this.closest('.section');
                    section.classList.add('completed');
                    updateProgress();

                    const originalText = this.textContent;
                    this.textContent = '✓ Saved!';
                    this.style.backgroundColor = '#28a745';

                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.backgroundColor = '';
                    }, 1500);
                });
            });
        });
    </script>
@endsection
