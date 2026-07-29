import pandas as pd
import json

# Load career skills dataset
CAREER_SKILLS_FILE = "../datasets/career_paths/tech_roles_skills.csv"

def load_career_skills():
    """Load required skills for different careers."""
    try:
        return pd.read_csv(CAREER_SKILLS_FILE)
    except FileNotFoundError:
        print("Error: Career skills dataset not found.")
        return None

def analyze_skill_gap_for_career(user_skills, career):
    """Analyze skill gaps based on the chosen career path."""
    career_skills_df = load_career_skills()
    if career_skills_df is None:
        return []

    # Find required skills for the selected career
    career_row = career_skills_df[career_skills_df["Career"] == career]
    if career_row.empty:
        print(f"Career '{career}' not found in dataset.")
        return []

    # Check if career_row is not empty BEFORE using it.
    if not career_row.empty:
        required_skills = set(eval(career_row["Required Skills"].values[0])) # Convert string to list
        user_skills_lower = set([skill.lower().strip() for skill in user_skills]) # Normalize
        missing_skills = sorted(list(required_skills - user_skills_lower)) # Find missing skills and sort
        return missing_skills
    else:
        return []

if __name__ == "__main__":
    # Example usage (for testing the module)
    user_skills = ["Python", "SQL ", " JavaScript"]
    career_choice = "Data Scientist"

    missing_skills = analyze_skill_gap_for_career(user_skills, career_choice)

    print("Skill Gap Analysis Result:")
    print(json.dumps({"Career": career_choice, "Missing Skills": missing_skills}, indent=4))