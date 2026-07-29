import os
import re
import sys
import json
import numpy as np
from typing import List, Dict
from sklearn.metrics.pairwise import cosine_similarity
import gensim
import logging

# Initialize logging
logging.basicConfig(level=logging.INFO)

# ----------------------------
# Import Scraper
# ----------------------------
from live_scrapers.jsearch_scraper import scrape_jobs_from_jsearch

# ----------------------------
# Load Skill2Vec Model
# ----------------------------
skill2vec_model_path = os.path.expanduser("~/fyp/ai-ml/models/skill2vec.model")
try:
    skill2vec_model = gensim.models.Word2Vec.load(skill2vec_model_path)
    logging.info("✅ Skill2Vec model loaded.")
except Exception as e:
    logging.error(f"❌ Failed to load Skill2Vec model: {e}")
    skill2vec_model = None

# ----------------------------
# Utility Functions
# ----------------------------
def clean_skill(skill: str) -> str:
    """Cleans and normalizes a skill string."""
    return re.sub(r"[^a-zA-Z0-9+#.-]+", " ", skill.strip().lower())


def normalize_skill(skill: str) -> str:
    """Normalizes a skill using Skill2Vec or returns the cleaned skill."""
    skill = clean_skill(skill)
    if skill2vec_model:
        if skill in skill2vec_model.wv:
            return skill
        try:
            similar = skill2vec_model.wv.most_similar(skill, topn=3)
            for word, score in similar:
                if score > 0.8:
                    return clean_skill(word)
        except KeyError:
            pass
    return skill



def normalize_skills(skills: List[str]) -> List[str]:
    """Normalizes a list of skills."""
    return list({normalize_skill(s) for s in skills})


def filter_relevant_skills(skills: List[str]) -> List[str]:
    """Filters a list of skills to include only relevant ones."""
    # Expanded list of irrelevant terms
    irrelevant_terms = {
        "panda", "graduation", "bachelor", "time", "job", "role",
        "excellent", "commitment", "college", "university", "experience",
        "ability", "strong", "effective", "detail", "problem", "solution",
        "communication", "designing", "device", "teamwork", "graduate",
        "internship", "training", "application", "tool", "system", "process",
        "understanding", "knowledge", "familiarity", "skill", "level",
        "basic", "intermediate", "advanced", "expert", "proficient",
        "working", "exposure", "background", "technique", "method",
        "principle", "concept", "approach", "practice", "standard",
        "requirement", "responsibility", "duty", "function", "task",
        "admin", "environment", "qualification", "browser", "science",
        "general", "support", "analysis", "management", "development",
        "and", "or", "with", "for", "the", "a", "an", "plus",  # Common words
        "etc", "ie", "eg",  # Abbreviations
        "various", "multiple", "related", "associated", "including",  # Connectors
        "high", "good", "best", "top", "quality",  # Adjectives
        "new", "current", "latest", "recent",  # Time related
        "position", "candidate", "person", "individual",  # Job related
        "field", "area", "domain", "sector",  # Domain
        "aspect", "factor", "element",  # Element
        "set", "group", "collection",  # Grouping
        "range", "variety", "type", "form",  # Variety
        "part", "component", "piece",  # Part
        "nature", "kind", "sort",  # Kind
        "way", "mean", "manner",  # Way
        "thing", "stuff", "material",  # Thing
        "service", "product", "solution",  # Offering
        "perform", "conduct", "execute",  # Action
        "ensure", "maintain", "provide",  # Ensure
        "assist", "help", "support",  # Support
        "ability", "capable", "proficient",  # Ability
        "responsible", "involved", "accountable",  # Responsibility
        "contribute", "participate",  # Contribution
        "develop",  # Overlap with "development" but kept for context
        "create", "build", "design",  # Creation
        "implement", "configure", "install",  # Implementation
        "operate", "utilize", "employ",  # Operation
        "manage",  # Overlap
        "oversee", "direct",  # Direction
        "improve", "enhance", "optimize",  # Improvement
        "analyze", "evaluate", "assess",  # Analysis
        "research", "investigate",  # Research
        "test", "validate", "verify",  # Testing
        "document", "report", "record",  # Documentation
        "train", "educate", "instruct",  # Training
        "support",  # Overlap
        "maintain",  # Overlap
        "troubleshoot", "diagnose", "resolve",  # Troubleshooting
        "collaborate", "coordinate", "liaise",  # Collaboration
        "plan", "organize", "schedule",  # Planning
        "budget", "finance", "accounting",  # Finance
        "market", "sell", "promote",  # Marketing
        "customer service", "client relations",  # Customer Service
        "human resources", "hr", "recruitment",  # HR
        "legal", "compliance", "regulatory",  # Legal
        "safety", "security", "risk management",  # Safety/Security
        "quality assurance", "qa", "quality control",  # Quality
        "project management", "program management", "portfolio management",  # Project Management
        "business development", "sales",  # Business
        "operations", "logistics", "supply chain",  # Operations
        "facilities", "maintenance",  # Facilities
        "administrative", "clerical", "secretarial",  # Admin
        "technical", "engineering",  # Technical
        "scientific", "research",  # Scientific
        "medical", "healthcare",  # Medical
        "financial",  # Overlap
        "educational",  # Overlap
        "environmental",  # Overlap
        "political",  # Added
        "social", # Added
        "cultural", # Added
        "economical", # Added
        "global", # Added
        "international" # Added
    }
    return [skill for skill in skills if skill not in irrelevant_terms]




def get_vector(skills: List[str]) -> np.ndarray:
    """Gets the Skill2Vec vector representation of a list of skills."""
    if skill2vec_model is None:
        return skill2vec_model.vector_size if skill2vec_model else 100

    vectors = [skill2vec_model.wv[s] for s in skills if s in skill2vec_model.wv]
    return np.mean(vectors, axis=0) if vectors else np.zeros(skill2vec_model.vector_size)



def compute_match_score(user_skills: List[str], job_skills: List[str]) -> float:
    """Computes the cosine similarity between user and job skill vectors."""
    if skill2vec_model is None:
        logging.warning("⚠️ Skill2Vec model not loaded. Returning score 0.")
        return 0.0

    user_vec = get_vector(user_skills)
    job_vec = get_vector(job_skills)
    return float(cosine_similarity([user_vec], [job_vec])[0][0])



# ----------------------------
# Main Recommendation Function
# ----------------------------
def recommend_jobs(user_skills: List[str], location: str = "Pakistan") -> List[Dict[str, str]]:
    """
    Recommends jobs using JSearch API and Skill2Vec.

    Args:
        user_skills (List[str]): List of user skills.
        location (str): Location to search for jobs.

    Returns:
        List[Dict[str, str]]: List of job dictionaries, or an empty list on error.
    """
    logging.info("🔎 Running recommend_jobs...")
    normalized_user_skills = normalize_skills(user_skills)
    relevant_skills = filter_relevant_skills(normalized_user_skills)

    # Use a maximum of 5 relevant skills for the JSearch query
    filtered_skills = relevant_skills[:100]
    if not filtered_skills:
        logging.warning("⚠️ No relevant skills detected, using unfiltered normalized skills.")
        filtered_skills = normalized_user_skills[:100]



    try:
        jobs = scrape_jobs_from_jsearch(filtered_skills, location)  # Use filtered skills

        if not jobs:
            logging.warning("⚠️  No jobs found by JSearch API.")
            return []

        for job in jobs:
            # Normalize job skills, handle missing skills
            job_skills_raw = job.get("Required Skills", [])
            job_skills = normalize_skills(job_skills_raw)
            score = compute_match_score(relevant_skills, job_skills)
            matching_skills = [skill for skill in relevant_skills if skill in job_skills]

            job.update({
            "match_score": round(score, 10),
            "Matching Skills": matching_skills,
            "low_match": len(matching_skills) == 0 and score < 0.2
            })


        return sorted(jobs, key=lambda x: x["match_score"], reverse=True)

    except Exception as e:
        logging.error(f"❌  Error during job recommendation: {e}")
        return []



# ----------------------------
# CLI/Test Mode
# ----------------------------
if __name__ == "__main__":
    try:
        user_input = json.loads(sys.argv[1])
        recommendations = recommend_jobs(user_input)
        print(json.dumps(recommendations, indent=4))
    except Exception as e:
        logging.error(f"❌  Usage Error: {e}\nProvide user skills as a JSON array.")