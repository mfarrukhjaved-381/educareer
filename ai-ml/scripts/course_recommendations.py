# course_recommendations.py
import logging
import requests
from bs4 import BeautifulSoup
from typing import List, Dict
from urllib.parse import quote_plus
import os
import json  # Import the json module

# Setup logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)


def deduplicate_skills(skills: List[str]) -> List[str]:
    """
    Removes duplicate skills and normalizes them to lowercase.
    """
    return list(set(skill.lower() for skill in skills))


def fetch_coursera_courses(skill_query: str, limit: int = 10) -> List[Dict[str, str]]:
    """
    Fetches course information from Coursera search results.

    Args:
        skill_query (str): The skill to search for on Coursera.
        limit (int): The maximum number of courses to fetch.

    Returns:
        List[Dict[str, str]]: A list of dictionaries, where each dictionary
        contains the course name, URL, and other details.
        Returns an empty list on error.
    """
    try:
        base_url = "https://www.coursera.org/search"
        encoded_query = quote_plus(skill_query)
        search_params = {"query": encoded_query}
        target_url = requests.Request("GET", base_url, params=search_params).prepare().url

        api_key = os.getenv("SCRAPINGBEE_API_KEY")  # Ensure this is exported in shell
        if not api_key:
            logger.error("❌ SCRAPINGBEE_API_KEY is not set in environment.")
            return []
        payload = {
            "api_key": api_key,
            "url": target_url,
            "render_js": True,
        }
        headers = {"User-Agent": "Mozilla/5.0"}
        response = requests.get(
            "https://app.scrapingbee.com/api/v1/", params=payload, headers=headers
        )
        response.raise_for_status()  # Raise HTTPError for bad responses (4xx or 5xx)

        soup = BeautifulSoup(response.text, "html.parser")
        course_cards = soup.select("div.cds-ProductCard-base")
        courses = []
        seen_links = set()  # To track already added courses

        for card in course_cards[:limit * 2]:  # Fetch extra to filter duplicates
            title_elem = card.select_one("a.cds-119 h3")
            url_tag = card.select_one("a.cds-119")
            provider_elem = card.select_one("div.cds-ProductCard-partners")
            rating_elem = card.select_one("div.cds-RatingStat-meter span")

            def get_text(element):
                return element.get_text(strip=True) if element else "N/A"

            def get_url(element):
                return (
                    f"https://www.coursera.org{element['href']}"
                    if element and "href" in element.attrs
                    else "N/A"
                )

            if title_elem and url_tag:
                title = get_text(title_elem)
                url = get_url(url_tag)
                if url in seen_links:
                    continue  # Skip duplicate courses
                seen_links.add(url)  # Add URL to the set
                provider = get_text(provider_elem)
                rating = get_text(rating_elem)
                courses.append(
                {
                 "name": title,
                 "course_link": url,
                 "provider": provider if provider != "N/A" else "Coursera",
                 "rating": rating,
                 "skills": [skill_query.lower()],
                }
                )


                if len(courses) >= limit:
                    break  # Stop when we reach the limit

        return courses
    except requests.exceptions.RequestException as e:
        logger.error(f"❌ Error during request to Coursera: {e}")
        return []
    except Exception as e:
        logger.error(f"❌ Error scraping Coursera: {e}")
        return []



def fetch_live_courses(skills: List[str], max_results: int = 5) -> List[Dict[str, str]]:
    """
    Fetches courses from multiple sources (Coursera, EdX, etc.) for the given skills.

    Args:
        skills (List[str]): List of skills to search for.
        max_results (int): Max courses to fetch per source.

    Returns:
        List[Dict[str, str]]: Combined course list with skill information.
    """
    unique_skills = deduplicate_skills(skills)
    all_courses = []
    for skill in unique_skills:
        courses = fetch_coursera_courses(skill, max_results)
        all_courses.extend(courses)
    return all_courses



def match_courses_to_skills(
    courses: List[Dict[str, str]], user_skills: List[str]
) -> List[Dict[str, str]]:
    """
    Matches courses to user skills.

    Args:
        courses (List[Dict[str, str]]): List of courses.
        user_skills (List[str]): List of user skills (lower case).

    Returns:
        List[Dict[str, str]]: List of courses with matched skills.
    """
    matched_courses = []
    for course in courses:
        matched_skills = [
    skill for skill in course.get("skills", []) if skill in user_skills
        ]
    # Safe access
        if matched_skills:
            matched_courses.append(
                {**course, "matched_skills": matched_skills}
            )  # add matched skills to the course dict
    return matched_courses



def get_course_recommendations(cv_data):
    """
    Orchestrates the process of fetching and matching courses based on CV data.

    Args:
        cv_data (dict):  The data extracted from the user's CV.  This should
                        contain a 'skills' key with a list of skills.

    Returns:
        dict: A dictionary containing the recommended courses, or an error message.
              The 'courses' key will hold the list of matched courses.
    """
    print("\n--- get_course_recommendations  ---")
    if not cv_data or "skills" not in cv_data:
        error_message = "No skills found in CV data."
        print(error_message)
        return {"error": error_message, "courses": []}  # Return empty list for consistency

    user_skills = [skill.lower() for skill in cv_data["skills"]]

    # skills to search courses
    course_skills = user_skills
    courses = fetch_live_courses(course_skills, max_results=3)
    matched_courses = match_courses_to_skills(courses, user_skills)
    if not matched_courses:
        matched_courses = courses[:1]  # fallback to top 3 scraped

    return {"courses": matched_courses}  #  Include matched_courses in the return data
    

if __name__ == "__main__":
    # Example usage  (Simulated CV data)
    cv_data = {
        "skills": ["Python", "Machine Learning", "Data Science", "Web Development", "JavaScript"],
    }
    recommendations = get_course_recommendations(cv_data)
    print(json.dumps(recommendations, indent=4))