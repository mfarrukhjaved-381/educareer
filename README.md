<div align="center">
  <img src="https://placehold.co/800x200/007bff/ffffff?text=EduCareer" alt="EduCareer Banner" width="800" style="border-radius: 10px;">
</div>

<h1 align="center">EduCareer</h1>

> A full-stack AI-powered career guidance platform that bridges the gap between CVs and dream careers through intelligent skill extraction and mapping.

<p align="center">
  <a href="https://github.com/mfarrukhjaved-381/educareer/actions"><img src="https://img.shields.io/badge/build-passing-brightgreen?style=for-the-badge" alt="Build Status"></a>
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12"></a>
  <a href="https://www.python.org/"><img src="https://img.shields.io/badge/Python-3.x-3776AB?style=for-the-badge&logo=python&logoColor=white" alt="Python 3"></a>
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge" alt="License"></a>
</p>

---

## 🧐 Why?

Job seekers often don't know exactly what skills they lack for their desired roles, and career advisors struggle to provide data-driven recommendations at scale. Existing tools are either too simplistic or locked behind enterprise paywalls.

EduCareer provides an open-source, full-stack solution that leverages actual NLP and machine learning embeddings (`skill2vec`) to compare a user's CV against current industry requirements, democratizing advanced career analytics.

## ✨ Features

### Core Platform
- **Smart CV Analysis:** Extract technical and soft skills directly from uploaded resumes.
- **Career Path Mapping:** AI-driven recommendations matching user profiles to viable career trajectories.
- **Skill Gap Visualization:** Dashboards highlighting missing skills required for target jobs.

### Course & Job Recommendations
- **Dynamic Job Matching:** Recommends specific roles based on vector similarity.
- **Targeted Upskilling:** Suggests courses tailored to bridge individual skill gaps.

### Administration
- **Role-Based Access Control:** Distinct workflows for admins, career advisors, and standard users.
- **Customizable ML Engine:** Swap out the default embedding models for industry-specific fine-tuning.

---

## 🛠 Tech Stack

### Backend
- **Laravel 12** (PHP 8.2)
- **MySQL / SQLite**

### Frontend
- **Blade Templating**
- **Tailwind CSS**
- **Alpine.js / Vue.js**
- **Vite**

### AI & Machine Learning Engine
- **Python 3.x**
- **Gensim** (`skill2vec` embeddings)
- **Scikit-Learn** & **Pandas**

---

## 🏗 Architecture

EduCareer is split into a robust web application and an isolated AI analytics engine.

```text
                ┌──────────────┐
                │ User Browser │
                └──────┬───────┘
                       │ HTTP / AJAX
                       ▼
          ┌─────────────────────────┐
          │     Laravel Backend     │
          │ (Auth, Views, DB Logic) │
          └──────┬───────────┬──────┘
                 │           │
        SQL Data │           │ API/Subprocess Call
                 ▼           ▼
        ┌──────────┐   ┌──────────────┐
        │  MySQL   │   │ Python AI/ML │
        │ Database │   │    Engine    │
        └──────────┘   └──────────────┘
                       (skill2vec, NLP)
```

---

## 📋 Prerequisites

To run EduCareer locally, ensure you have the following installed:

- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18 and npm >= 9
- Python >= 3.9
- MySQL / MariaDB (or SQLite for simple testing)

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/mfarrukhjaved-381/educareer.git
cd educareer
```

### 2. Setup the Web Application (Laravel)

```bash
cd frontend-backend

# Install PHP and Node dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run database migrations (Ensure your DB is created first)
php artisan migrate

# Start the application
php artisan serve & npm run dev
```

### 3. Setup the AI/ML Engine (Python)

```bash
# Open a new terminal and navigate to the ML directory
cd ../ai-ml

# Create and activate a virtual environment
python3 -m venv venv
source venv/bin/activate  # On Windows: venv\Scripts\activate

# Install required ML packages
pip install pandas scikit-learn gensim numpy
```

---

## ⚙️ Environment Variables

Create a `.env` file in `frontend-backend/` based on `.env.example`. 

| Variable | Description | Required |
|---|---|---|
| `APP_ENV` | Application environment (`local`, `production`) | Yes |
| `DB_CONNECTION` | Database driver (e.g., `mysql`, `sqlite`) | Yes |
| `DB_DATABASE` | Database name or absolute path to SQLite file | Yes |
| `GOOGLE_CLIENT_ID` | OAuth Client ID for Google Login | Optional |
| `GOOGLE_CLIENT_SECRET`| OAuth Client Secret for Google Login | Optional |

---

## 💡 Usage

### Running ML Scripts manually
While Laravel handles user interactions, you can manually run ML analysis or retrain models:

```bash
cd ai-ml
source venv/bin/activate

# Generate job recommendations
python scripts/job_recommendations.py

# Retrain the skill2vec model with new data
python scripts/train_skill2vec.py
```

---

## 🧪 Testing

Run the automated test suite for the Laravel backend:

```bash
cd frontend-backend

# Run Unit & Feature tests
php artisan test
```

---

## 🗺 Roadmap

- [x] User Authentication & Dashboard
- [x] CV Parsing & NLP Skill Extraction
- [x] Job & Course Recommendation Engine
- [ ] Implement Redis caching for faster ML model loading
- [ ] Build standalone REST API for mobile app integration
- [ ] Implement OAuth integrations (LinkedIn, Google)

---

## 🤝 Contributing

We welcome community contributions! Please read our [CONTRIBUTING.md](CONTRIBUTING.md) before submitting an issue or pull request.

**Typical Workflow:**
`Fork` ➔ `Feature Branch` ➔ `Tests` ➔ `Pull Request` ➔ `Review` ➔ `Merge`

---

## 🔒 Security

If you discover any security vulnerabilities, please review [SECURITY.md](SECURITY.md) for responsible disclosure instructions. Do not report security vulnerabilities on the public issue tracker.

---

## 📄 License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.

---

## 👨‍💻 Maintainers

Maintained by [Muhammad Farrukh Javed](https://github.com/mfarrukhjaved-381).

For general usage questions, please open a GitHub Discussion or issue.
