import pandas as pd
import ast
import re
import spacy
import nltk
import os
import pickle
from nltk.corpus import stopwords

nltk.download('stopwords', quiet=True)
stop_words_en = set(stopwords.words('english'))

# Load spaCy model
nlp = spacy.load("en_core_web_sm", disable=["ner", "parser"])

# Define your filters
common_non_skills = {"", "and", "or", "the", "of", "in", "for", "with", "on", "at", "to", "from", "as", "an", "a",
                     "is", "are", "was", "were", "by", "be", "been", "have", "has", "had", "having", "will", "would",
                     "should", "can", "could", "may", "might", "must", "about", "above", "across", "after", "against",
                     "along", "among", "around", "before", "behind", "below", "beneath", "beside", "between", "beyond",
                     "during", "except", "few", "following", "inside", "into", "like", "near", "onto", "outside",
                     "over", "since", "through", "under", "until", "upon", "within", "without", "that", "this", "these",
                     "those", "which", "who", "whom", "whose", "where", "when", "why", "how", "all", "any", "both",
                     "each", "either", "every", "much", "many", "some", "other", "such", "no", "nor", "not", "only",
                     "own", "same", "so", "than", "too", "very", "s", "t", "m", "d", "ll", "re", "ve", "y"}
common_degrees = {"bachelor", "master", "phd", "associate", "degree", "ba", "bs", "ma", "ms", "doctorate"}
common_locations = {"city", "state", "country", "region", "area"}
job_title_keywords = ["engineer", "analyst", "developer", "manager", "specialist", "coordinator", "associate",
                        "officer", "consultant", "architect", "administrator", "representative", "executive",
                        "president", "vice president", "director", "lead", "staff", "technician", "programmer"]


def is_likely_job_title(text):
    text_lower = text.lower()
    return any(k in text_lower for k in job_title_keywords) or (text.istitle() and len(text.split()) <= 3)


def clean_text(text):
    text = re.sub(r"[^a-zA-Z\s\-]", "", text)
    text = re.sub(r"\s+", " ", text).strip().lower()
    return text


def extract_clean_skills(skills):
    cleaned_skills = []

    languages_to_exclude = {
        "urdu", "punjabi", "hindi", "bengali", "arabic", "french", "german", "spanish", "chinese", "mandarin",
        "korean", "japanese", "italian", "russian", "persian", "turkish", "pashto", "sindhi"
    }

    locations_to_exclude = {
        # Cities
        "dubai", "karachi", "lahore", "islamabad", "rawalpindi", "peshawar", "quetta", "multan", "faisalabad",
        "hyderabad", "london", "new york", "tokyo", "paris", "berlin", "moscow", "beijing", "shanghai",
        # States/Provinces
        "punjab", "sindh", "balochistan", "khyber pakhtunkhwa", "gilgit baltistan",
        "california", "texas", "florida", "new york state",
        # Countries
        "pakistan", "india", "china", "usa", "uk", "france", "germany", "japan", "russia", "australia",
        "canada", "brazil", "saudi arabia", "uae", "qatar", "turkey", "iran",
        # Generic Business Terms
        "strategy", "logistics", "procurement",
         "budgeting", "forecasting",
        # Generic Soft Skills
        "organization", "planning", "decision making", "interpersonal", "presentation", "negotiation",
         "collaboration", "adaptability", "flexibility", 
        # Generic Action Words
        "managing", "coordinating", "supporting", "leading", "organizing", "planning",
        "executing", "monitoring", "evaluating", "reviewing", "implementing"
        # Generic Tools/Equipment
        "tools", "equipment", "machinery", "devices", "instruments", 
        # Generic Work Terms
        "project", "task", "responsibility", "duty", "objective", "goal",
        "requirement", "specification", "documentation", "report", "analysis",
        # Generic Industry Terms
        "industry", "sector", "market", "business unit", "department", "division",
        "enterprise", "corporation", "organization", "company", "firm",
        # Generic Process Terms
        "process", "procedure", "methodology", "framework", "approach", "initiative",
        "program", "workflow", "lifecycle", "pipeline", "protocol",
    }

    for skill in skills:
        if not isinstance(skill, str):
            continue

        skill = clean_text(skill)

        if (len(skill) <= 2 or
            skill in stop_words_en or
            skill in common_non_skills or
            skill in common_degrees or
            skill in common_locations or
            skill in languages_to_exclude or
            skill in locations_to_exclude or
            is_likely_job_title(skill)):
            continue

        doc = nlp(skill)
        phrase = " ".join([
            token.lemma_ for token in doc
            if token.pos_ in ['NOUN', 'PROPN', 'ADJ'] and token.text not in stop_words_en
        ])
        
        if len(phrase) > 2 and not any(char.isdigit() for char in phrase):
            cleaned_skills.append(phrase.strip())

    return list(set(cleaned_skills))



def clean_skill_dataset(input_csv_path, output_csv_path, output_list_path):
    df = pd.read_csv(input_csv_path, low_memory=False)
    cleaned_skills_list = []

    if 'extracted_skills' not in df.columns:
        print("❌ Error: 'extracted_skills' column not found.")
        return

    # Ensure the output directory exists
    output_dir = os.path.dirname(output_list_path)
    if not os.path.exists(output_dir):
        os.makedirs(output_dir)
        print(f"✅ Created output directory: {output_dir}")

    for skills_str in df['extracted_skills']:
        try:
            skills = ast.literal_eval(skills_str)
            if isinstance(skills, list):
                cleaned_skills = extract_clean_skills(skills)
                cleaned_skills_list.append(cleaned_skills)
            else:
                cleaned_skills_list.append([])
        except Exception as e:
            print(f"⚠️ Error processing skills string '{skills_str}': {e}")
            cleaned_skills_list.append([])

    # Save cleaned list of lists as pickle for faster loading in training
    with open(output_list_path, 'wb') as f:
        pickle.dump(cleaned_skills_list, f)

    df['cleaned_extracted_skills'] = ['["{}"]'.format('", "'.join(sk)) for sk in cleaned_skills_list]
    df.drop(columns=[col for col in df.columns if 'Unnamed' in col], inplace=True, errors='ignore')
    df.to_csv(output_csv_path, index=False)
    print(f"✅ Cleaned CSV saved to: {output_csv_path}")
    print(f"✅ Cleaned list of skill lists saved to: {output_list_path}")


# ---- PATHS ----
input_file = os.path.expanduser('~/fyp/ai-ml/datasets/skill2vec/skill2vec_50K_with_skills.csv')
output_csv = os.path.expanduser('~/fyp/ai-ml/datasets/skill2vec/cleaned_skill2vec_50K_with_skills.csv')
output_list = os.path.expanduser('~/fyp/ai-ml/datasets/skill2vec/cleaned_skill2vec_sentences.pkl')

# ---- RUN ----
clean_skill_dataset(input_file, output_csv, output_list)