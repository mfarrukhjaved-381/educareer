# EduCareer

EduCareer is a full-stack AI-powered career guidance platform built as a Laravel web application with supporting Python AI/ML scripts.

## Project Overview

This repository combines:

- **Frontend + Backend**: Laravel 12 application in `frontend-backend/`
- **AI & Machine Learning**: Python scripts and datasets under `ai-ml/`

The platform supports career path recommendations, CV skill extraction, course and job suggestions, and personalized skill gap analysis.

## Key Features

- User authentication and dashboard functionality
- CV upload and skill extraction
- Career path recommendation engine
- Job and course recommendation utilities
- Skill gap analysis and visualization support
- Python-based AI/ML tooling for skill embeddings, recommendations, and dataset analysis

## Repository Structure

- `frontend-backend/` - Laravel application
  - `app/` - application controllers, models, providers
  - `routes/` - API and web routes
  - `resources/` - views, CSS, JS assets
  - `public/` - frontend assets and entry file
  - `database/` - migrations, seeders, factories
- `ai-ml/` - machine learning and AI scripts
  - `scripts/` - Python scripts for skill extraction, recommendations, embeddings, and training
  - `datasets/` - CSV files, embeddings, and skill data
  - `models/` - trained models like `skill2vec.model`
- `README.md` - this file

## Technologies

- PHP 8.2
- Laravel 12
- MySQL / SQLite (Laravel database support)
- JavaScript, Vite, Tailwind CSS, Alpine.js, Axios
- Python 3.x for AI/ML scripts
- CSV data processing and word embedding models

## Getting Started

### Laravel application

1. Navigate to the Laravel folder:
   ```bash
   cd frontend-backend
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install frontend dependencies:
   ```bash
   npm install
   ```
4. Copy the environment file and configure database settings:
   ```bash
   cp .env.example .env
   ```
5. Generate the application key:
   ```bash
   php artisan key:generate
   ```
6. Run database migrations:
   ```bash
   php artisan migrate
   ```
7. Start the app and frontend dev server:
   ```bash
   php artisan serve
   npm run dev
   ```

### AI / ML scripts

1. Navigate to the AI/ML folder:
   ```bash
   cd ai-ml
   ```
2. Create and activate a Python virtual environment:
   ```bash
   python3 -m venv venv
   source venv/bin/activate
   ```
3. Install required Python packages as needed. If a requirements file is not present, install dependencies manually:
   ```bash
   pip install pandas scikit-learn gensim numpy
   ```
4. Run specific scripts:
   ```bash
   python scripts/train_skill2vec.py
   python scripts/job_recommendations.py
   python scripts/course_recommendations.py
   ```

## Development Notes

- The Laravel backend lives in `frontend-backend/` and manages web routes, APIs, authentication, and data persistence.
- The AI/ML folder contains scripts for skill extraction, embeddings, recommendation logic, and dataset processing.
- Most project-specific logic is split between Laravel controllers/models and Python analysis scripts.

## License

This project is licensed under the MIT License.
