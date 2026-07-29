import pickle
from sklearn.metrics.pairwise import cosine_similarity

# Load saved skill embeddings
try:
    with open("../datasets/skill_embeddings/filtered_skill_embeddings.pkl", "rb") as f: #added file path.
        skill_embeddings = pickle.load(f)
except FileNotFoundError:
    print("Error: filtered_skill_embeddings.pkl not found.")
    exit()

# Example CV Skills (extracted from uploaded CV)
cv_skills = ["python", "sql", "javascript"]

# Compute similarity scores between CV skills and job skills
def match_skills(cv_skills, job_skills):
    matched_jobs = []
    for job_skill in job_skills:
        max_similarity = 0
        for cv_skill in cv_skills:
            if cv_skill in skill_embeddings and job_skill in skill_embeddings:
                similarity = cosine_similarity([skill_embeddings[cv_skill]], [skill_embeddings[job_skill]])[0][0]
                max_similarity = max(max_similarity, similarity)
        if max_similarity > 0.7:  # Set threshold for matching (adjust as needed)
            matched_jobs.append(job_skill)
    return matched_jobs

# Example: Match CV skills with job-related skills
tech_job_skills = list(skill_embeddings.keys())  # All tech job skills
matched_skills = match_skills(cv_skills, tech_job_skills)

print("Matched Skills:", matched_skills)