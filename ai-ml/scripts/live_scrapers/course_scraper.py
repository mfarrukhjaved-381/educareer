import logging
import requests
from bs4 import BeautifulSoup
from typing import List, Dict
from urllib.parse import quote_plus
import os

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
    logger.info(f"📚 Scraping Coursera for: {skill_query}")
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
                        "provider": provider,
                        "rating": rating,
                        "skills": [
                            skill_query.lower()
                        ],  # Add the skill here, make it lower case
                    }
                )
                if len(courses) >= limit:
                    break  # Stop when we reach the limit

        logger.info(f"✅ Found {len(courses)} Coursera courses for '{skill_query}'.")
        return courses
    except requests.exceptions.RequestException as e:
        logger.error(f"❌ Error during request to Coursera: {e}")
        return []
    except Exception as e:
        logger.error(f"❌ Error scraping Coursera: {e}")
        return []



def fetch_live_courses(skills: List[str], max_results: int = 10) -> List[Dict[str, str]]:
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
        ]  # Safe access
        if matched_skills:
            matched_courses.append(
                {**course, "matched_skills": matched_skills}
            )  # add matched skills to the course dict
    return matched_courses


if __name__ == "__main__":
    # Example usage
    user_skills = ["python", "machine learning", "data science", "web development"]
    test_skills = ["Python", "Machine Learning", "Data Science"]
    courses = fetch_live_courses(test_skills, max_results=3)
    matched_courses = match_courses_to_skills(courses, user_skills)

    print("🌟 Recommended Courses (Matched Skills):")
    if matched_courses:
        for course in matched_courses:
            print(
                f"- {course['name']} ➤ {course['course_link']} (Provider: {course['provider']}, Rating: {course['rating']})"
            )
            print(f"  Matched Skills: {', '.join(course['matched_skills'])}")
    else:
        print("No courses matched your skills.")
