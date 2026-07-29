import os
import requests
import logging
import json
from typing import List, Dict

# Initialize logging
logging.basicConfig(level=logging.INFO)

# Replace this with your actual RapidAPI Key
RAPIDAPI_KEY = "94ec2374e7mshf33f0cc2b2e85f2p1834ecjsn60cad8361e20"   # ← Replace this ASAP

if not RAPIDAPI_KEY:
    logging.critical("RapidAPI key is missing. Scraping cannot proceed.")
    raise ValueError("RAPIDAPI_KEY must be set!")


# --------------------- Scraper Function ---------------------
def scrape_jobs_from_jsearch(skills: List[str], location: str = "Pakistan", max_results: int = 10) -> List[dict]:
    """
    Fetches jobs using RapidAPI JSearch based on a *filtered* list of skills and location.

    Args:
        skills (List[str]): A list of *filtered* skills to search for.
        location (str): The location to search in.
        max_results (int): The maximum number of job results to retrieve.
                              Note: JSearch API may have its own limit.

    Returns:
        List[dict]: A list of dictionaries, where each dictionary represents a job posting,
                      or an empty list on error.
    """
    # Define a set of essential skills for job searching.  This set can be expanded.
    essential_skills = {
        "html", "css", "javascript", "react", "node.js", "python", "java", "sql", "mysql",
        "postgresql", "mongodb", "php", "c++", "c#", "angular", "vue.js", "swift", "kotlin",
        "android", "ios", "docker", "kubernetes", "aws", "azure", "gcp", "frontend", "backend",
        "fullstack", "mobile development", "web development", "data science", "machine learning",
        "deep learning", "ui/ux", "graphic design", "wordpress", "linux", "networking",
        "cloud computing", "app development", "database administration", "software engineering",
        "software development", "cybersecurity", "devops",
        "django", "flask", "spring", "spring boot", "ruby on rails", "laravel", "codeigniter",  # Backend Frameworks
        "express.js", "next.js", "gatsby", "typescript", "jquery", "ajax", "graphql",  # Frontend/JS
        "react native", "flutter", "xamarin", "ionic",  # Cross-Platform Mobile
        "sql server", "oracle", "sqlite", "redis", "cassandra",  # Databases
        "c", "objective-c", "go", "rust", "scala", "perl", "r", "matlab", "powershell",  # Languages
        "git", "svn", "jenkins", "ansible", "terraform", "shell scripting",  # DevOps
        "restful api", "api development", "microservices", "serverless",  # API
        "agile", "scrum", "kanban", "waterfall",  # Methodologies
        "oop", "design patterns", "data structures", "algorithms",  # Concepts
        "computer vision", "nlp", "natural language processing", "big data", "hadoop", "spark",  # AI/ML
        "information security", "network security", "penetration testing", "ethical hacking",  # Security
        "aws cloudformation", "azure resource manager", "google cloud deployment manager",  # Cloud Deployment
        "testing", "unit testing", "integration testing", "e2e testing", "selenium", "cypress",  # Testing
        "ui design", "ux research", "wireframing", "prototyping", "usability testing",  # UI/UX
        "cms", "content management system", "ecommerce", "e-commerce", "magento", "shopify", "woocommerce", "drupal",  # CMS/Ecommerce
        "seo", "sem", "digital marketing", "social media marketing",  # Marketing
        "business intelligence", "data warehousing", "etl", "powerbi", "tableau",  # BI
        "sap", "erp", "crm", "salesforce", "dynamics 365",  # Enterprise
        "embedded systems", "iot", "robotics", "firmware",  # Embedded
        "game development", "unity", "unreal engine", "c#", #game dev
        "commerce", #as requested
        "cakephp", #as requested
    }

    # Filter the input skills to include only the essential ones.
    filtered_skills = [skill for skill in skills if skill.lower() in essential_skills]

    # If no essential skills are found, use the original skills (or a subset)
    if not filtered_skills:
        filtered_skills = skills[:10]  # Or you might want to return []

    query = "+".join(filtered_skills)
    url = "https://jsearch.p.rapidapi.com/search"
    params = {
        "query": query,
        "location": location,
        "page": "1",
        "num_pages": "1",
    }
    headers = {
        "X-RapidAPI-Key": RAPIDAPI_KEY,
        "X-RapidAPI-Host": "jsearch.p.rapidapi.com",
    }

    try:
        logging.info(f"🔍 Fetching JSearch jobs for: {query} in {location}")
        response = requests.get(url, headers=headers, params=params, timeout=120)
        logging.info(f"JSearch API response code: {response.status_code}")
        response.raise_for_status()

        data = response.json()
        jobs = []

        if isinstance(data, dict) and isinstance(data.get("data"), list):
            for job in data.get("data", [])[:max_results]:
                jobs.append(
                    {
                        "job_id": job.get("job_id", "N/A"),
                        "title": job.get("job_title", "N/A"),
                        "company": job.get("employer_name", "N/A"),
                        "location": f"{job.get('job_city', 'N/A')}, {job.get('job_country', 'N/A')}",
                        "url": job.get("job_apply_link", "#"),
                        "description": job.get("job_description", "No description available."),
                        "skills": skills,  #  Keep original skills for context
                        "match_score": job.get("match_score", 0), # Add this
                        "matching_skills": job.get("matching_skills", []), #Add this
                    }
                )
        else:
            logging.warning("JSearch API returned an unexpected data format.")
            return []

        return jobs

    except requests.exceptions.RequestException as req_err:
        logging.error(f"❌ Request error: {req_err}")
        return []
    except json.JSONDecodeError:
        logging.error("❌ Error decoding JSON response from JSearch API.")
        return []
    except Exception as e:
        logging.exception(f"❌ Unexpected error occurred: {e}")
        return []



# --------------------- Test Example ---------------------
if __name__ == "__main__":
    test_skills = [
        "Data Scientist",
        "Python",
        "Machine Learning",
        "Graphic Design"
    ]
    test_location = "Pakistan"

    results = scrape_jobs_from_jsearch(test_skills, location=test_skills, max_results=5)
    print(json.dumps(results, indent=2))