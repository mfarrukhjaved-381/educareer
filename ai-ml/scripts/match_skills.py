import numpy as np
import pickle
from sklearn.metrics.pairwise import cosine_similarity
import pandas as pd
import os

# Load pre-trained embeddings (Ensure this file exists)
EMBEDDINGS_FILE = "../datasets/skill_embeddings/filtered_skill_embeddings.pkl"

# Load job-related skills from Skill2Vec dataset
JOB_SKILLS_FILE = "../datasets/skill2vec/skill2vec_50K_with_skills.csv"

def load_embeddings():
    """Load pre-trained skill embeddings from a pickle file."""
    try:
        with open(EMBEDDINGS_FILE, "rb") as f:
            return pickle.load(f)
    except FileNotFoundError:
        print(f"Error: Embeddings file not found at {EMBEDDINGS_FILE}")
        return {}

def get_skill_vector(skill, embeddings):
    """Convert a skill into a vector using pre-trained embeddings."""
    if isinstance(skill, str):
        return embeddings.get(skill.lower(), np.zeros((100,)))  # Corrected vector size
    else:
        return np.zeros((100,))

def match_skills(extracted_skills):
    """Match user skills to job titles using cosine similarity"""

    # Load precomputed skill embeddings
    try:
        with open("../datasets/skill_embeddings/filtered_skill_embeddings.pkl", "rb") as f:
            skill_embeddings = pickle.load(f)
    except FileNotFoundError:
        print("Error: filtered_skill_embeddings.pkl not found.")
        return []

    # Load job data
    try:
        job_data = pd.read_csv("../datasets/skill2vec/skill2vec_50K_with_skills.csv", low_memory=False)
    except FileNotFoundError:
        print("Error: Job data file not found.")
        return []

    matched_jobs = []

   
    for _, row in job_data.iterrows():
        job_title = row[job_data.columns[1]]
        job_skills = eval(row["extracted_skills"])

        job_vectors = np.array([skill_embeddings.get(skill.lower(), np.zeros(100)) for skill in job_skills if isinstance(skill, str)])
        extracted_vectors = np.array([skill_embeddings.get(skill.lower(), np.zeros(100)) for skill in extracted_skills])

        if job_vectors.size > 0 and extracted_vectors.size > 0:
            similarity = cosine_similarity(job_vectors, extracted_vectors).mean()

            if similarity > 0.5:
                matched_jobs.append({"job_title": job_title, "similarity_score": float(similarity)})

    matched_jobs = sorted(matched_jobs, key=lambda x: x["similarity_score"], reverse=True)

    return matched_jobs