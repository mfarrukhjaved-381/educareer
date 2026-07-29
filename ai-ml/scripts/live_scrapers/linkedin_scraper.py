# ai-ml/scripts/live_scrapers/linkedin_scraper.py
import requests
from bs4 import BeautifulSoup
import urllib.parse

def scrape_linkedin_jobs(skills, location="Remote", limit=5):
    base_url = "https://www.linkedin.com/jobs/search/"
    skill_query = urllib.parse.quote_plus(" ".join(skills[:3]))  # Top 3 skills
    params = {
        "keywords": skill_query,
        "location": location,
    }
    search_url = f"{base_url}?keywords={params['keywords']}&location={params['location']}"
    
    headers = {
        "User-Agent": "Mozilla/5.0"
    }

    response = requests.get(search_url, headers=headers)
    soup = BeautifulSoup(response.text, 'html.parser')

    jobs = []
    for job_card in soup.select(".base-card")[:limit]:
        title = job_card.select_one(".base-search-card__title").text.strip() if job_card.select_one(".base-search-card__title") else ""
        company = job_card.select_one(".base-search-card__subtitle").text.strip() if job_card.select_one(".base-search-card__subtitle") else ""
        location = job_card.select_one(".job-search-card__location").text.strip() if job_card.select_one(".job-search-card__location") else ""
        link = job_card.find("a", href=True)['href']
        
        jobs.append({
            "Job Title": title,
            "Company": company,
            "Location": location,
            "Job URL": link
        })

    return jobs

# TEST
if __name__ == "__main__":
    sample_skills = ["Python", "Data Analysis", "Machine Learning"]
    jobs = scrape_linkedin_jobs(sample_skills)
    for job in jobs:
        print(job)
