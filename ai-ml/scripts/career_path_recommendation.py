import pandas as pd
import json
import sys
import os

def recommend_career_path(user_skills, use_semantic_similarity=False, skill2vec_model=None):
    """Recommend a career path based on skills, optionally using semantic similarity."""
    career_path_file_path = os.path.join(os.path.dirname(__file__), '..', 'datasets', 'career_paths', 'career_paths.csv')
    try:
        df = pd.read_csv(career_path_file_path)
        recommendations = []

        for _, row in df.iterrows():
            required_skills = [skill.strip().lower() for skill in row["Required Skills"].split(",")]
            matching_skills = [skill.lower() for skill in user_skills if skill.lower() in required_skills]
            relevance_score = len(matching_skills) / len(required_skills) if required_skills else 0

            if matching_skills:
                recommendations.append({
                    "Career Path": row["Career Path"],
                    "Matching Skills": matching_skills,
                    "Next Roles": [role.strip() for role in row["Next Roles"].split(",")],
                    "Relevance Score": relevance_score
                })

        # Sort by relevance score (more relevant first)
        sorted_recommendations = sorted(recommendations, key=lambda x: x["Relevance Score"], reverse=True)
        return sorted_recommendations
    except FileNotFoundError:
        print(f"Error: career_paths.csv not found at {career_path_file_path}")
        return []
    except Exception as e:
        print(f"Error in recommend_career_path: {e}")
        return []

if __name__ == "__main__":
    try:
        user_skills = json.loads(sys.argv[1])  # Pass user skills as JSON list
        result = recommend_career_path(user_skills)
        print(json.dumps(result, indent=4))
    except (json.JSONDecodeError, IndexError):
        print("Error: Please provide user skills as a JSON array.")
        sys.exit(1)