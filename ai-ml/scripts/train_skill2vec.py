import pandas as pd
import ast
import os
from gensim.models import Word2Vec

# Paths
csv_path = os.path.expanduser("~/fyp/ai-ml/datasets/skill2vec/cleaned_skill2vec_50K_with_skills.csv")
output_model_path = os.path.expanduser("~/fyp/ai-ml/models/skill2vec.model")

# Load cleaned CSV
df = pd.read_csv(csv_path)

# Convert stringified lists to actual lists
def parse_skills(skills_str):
    try:
        # The string is formatted like '["skill1", "skill2"]'
        # We need to evaluate this string as a Python list.
        return ast.literal_eval(skills_str)
    except (ValueError, SyntaxError):
        return []

# Apply the parsing function to the 'cleaned_extracted_skills' column
df["cleaned_extracted_skills"] = df["cleaned_extracted_skills"].apply(parse_skills)

# Filter out empty lists
skill_lists = [skills for skills in df["cleaned_extracted_skills"] if skills]

# Train Word2Vec model
print(f"Training Word2Vec on {len(skill_lists)} skill sets...")
model = Word2Vec(sentences=skill_lists, vector_size=100, window=5, min_count=1, workers=4, sg=1)

# Save model
model.save(output_model_path)
print(f"✅ Retrained model saved to: {output_model_path}")