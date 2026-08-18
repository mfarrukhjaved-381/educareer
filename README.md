<p align="center">
  <img src="https://placehold.co/800x200/007bff/ffffff?text=EduCareer" alt="EduCareer Logo" width="800" style="border-radius: 10px;">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=python&logoColor=white" alt="Python">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind">
  <img src="https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge" alt="License">
  <a href="https://github.com/mfarrukhjaved-381/educareer">
    <img src="https://img.shields.io/github/stars/mfarrukhjaved-381/educareer?style=for-the-badge&color=brightgreen" alt="GitHub Stars">
  </a>
</p>

<h1 align="center">EduCareer</h1>

> ⭐ The ultimate AI-powered career guidance platform bridging the gap between CVs and dream careers.

<p align="center">
  Developed by <br>
  <img src="https://github.com/mfarrukhjaved-381.png?size=80" alt="Muhammad Farrukh Javed" style="border-radius: 50%;"><br>
  <strong>Muhammad Farrukh Javed</strong>
</p>

---

## 🎯 Scope, Honestly

EduCareer is a robust platform that takes a user's CV, extracts their skills using machine learning, and maps them to tailored career paths, jobs, and courses. It handles authentication, data visualization, and AI embeddings out of the box. However, it **DOES NOT** automatically apply to jobs for you, nor does it guarantee employment. It is an analytical guidance tool designed to highlight skill gaps and suggest the next best steps in your professional journey. Expect an ecosystem split into a Laravel-powered frontend/backend and a Python-powered AI/ML engine that require separate environments.

> **Status:** Active & Open Source. Ready for developers to explore and deploy.

---

## ⚡ Quick Start

Setting up EduCareer involves running both the Laravel backend and the Python ML environment.

<details>
<summary><b>Option 1: Terminal Setup (Recommended)</b></summary>

### 1. Laravel Application
```bash
# Clone the repository
git clone https://github.com/mfarrukhjaved-381/educareer.git
cd educareer/frontend-backend

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
php artisan migrate

# Start the servers
php artisan serve & npm run dev
```

### 2. AI & ML Scripts
```bash
# Open a new terminal and navigate to the AI/ML directory
cd ../ai-ml

# Setup Python environment
python3 -m venv venv
source venv/bin/activate

# Install dependencies
pip install pandas scikit-learn gensim numpy

# Run the desired scripts (e.g., job recommendations)
python scripts/job_recommendations.py
```
</details>

<details>
<summary><b>Option 2: Direct Download</b></summary>

1. Download the repository as a ZIP file from GitHub.
2. Extract the contents to your local machine.
3. Follow the same terminal instructions above within the extracted folder.
</details>

---

## 🤔 Why This Exists

**The Problem**: Job seekers often don't know what skills they lack for their desired roles, and career advisors struggle to provide data-driven recommendations at scale. Existing tools are either too simplistic or locked behind enterprise paywalls.

**The Fix**: EduCareer provides an open-source, full-stack solution that leverages actual NLP and machine learning embeddings (`skill2vec`) to compare a user's CV against industry requirements. It democratizes advanced career analytics, making personalized guidance accessible to everyone.

> [!TIP]  
> Run the `train_skill2vec.py` script with your own specialized dataset to generate custom skill embeddings tailored to specific industries (e.g., healthcare or finance)!

---

## 🛠 Customizing What's Produced

EduCareer is built for extensibility:
- **Swap the ML Models:** You can replace the default Gensim `skill2vec` model in `ai-ml/models/` with your own fine-tuned NLP models to improve extraction accuracy.
- **Extend the Dashboards:** The Laravel + Tailwind CSS frontend is easily modifiable. Add new Alpine.js components or Vite integrations in `resources/views/` to create custom reporting visualizations.
- **API Integrations:** The Laravel backend exposes endpoints that allow you to connect third-party job board APIs (like LinkedIn or Indeed) directly into the recommendation engine.
- **Database Scalability:** By default, it uses SQLite/MySQL, but you can configure `.env` to scale with PostgreSQL or integrate Redis for faster model caching.

---

## 🤝 Contributing

We welcome community contributions to make EduCareer even better! 
1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'feat: Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📝 License

Distributed under the MIT License. See `LICENSE` for more information.
