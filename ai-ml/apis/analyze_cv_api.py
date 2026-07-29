import sys
import os
import json
import logging
import tempfile
import ast
import pandas as pd
import spacy
import gensim
import streamlit as st
import re
from flask import Flask, request, jsonify
from flask_cors import CORS
from gensim.models import Word2Vec

# Logging
logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

# Initialize Flask app
app = Flask(__name__)
CORS(app)

# 1. Define the absolute path to the 'scripts' directory
scripts_dir = '/home/muhammad-farrukh-javed/fyp/ai-ml/scripts'  # <---  ADJUST THIS PATH
sys.path.append(scripts_dir)

# 2. Import your modules AFTER adding the path
from upload_cv import extract_text_from_pdf, extract_text_from_docx
from job_recommendations import recommend_jobs
from course_recommendations import get_course_recommendations
from career_path_recommendation import recommend_career_path
from skill_extraction import clean_skills_with_skill2vec



# Load Skill2Vec model once
skill2vec_model_path = '/home/muhammad-farrukh-javed/fyp/ai-ml/models/skill2vec.model'  # Use absolute path
try:
    skill2vec_model = Word2Vec.load(skill2vec_model_path)
    logging.info("✅ Skill2Vec model loaded successfully.")
except Exception as e:
    logging.error(f"❌ Failed to load Skill2Vec model: {e}")
    skill2vec_model = None

# Stop words and NLP model
stop_words = set(spacy.lang.en.stop_words.STOP_WORDS)  # Use spaCy's stop words
nlp = spacy.load("en_core_web_sm")

def load_skill2vec_model(path='~/fyp/ai-ml/models/skill2vec.model'):
    path = os.path.expanduser(path)
    try:
        model = gensim.models.Word2Vec.load(path)
        print(f"✅ Skill2Vec loaded: {path}")
        return model
    except Exception as e:
        st.error(f"❌ Error loading Skill2Vec: {e}")
        return None


def load_known_skills(filepath='~/fyp/ai-ml/datasets/skill2vec/cleaned_skill2vec_50K_with_skills.csv'):
    filepath = os.path.expanduser(filepath)
    try:
        df = pd.read_csv(filepath, usecols=['cleaned_extracted_skills'])
        skills = set()
        for val in df['cleaned_extracted_skills'].dropna():
            try:
                items = ast.literal_eval(val)
                if isinstance(items, list):
                    skills.update([s.strip().lower() for s in items if isinstance(s, str)])
                elif isinstance(val, str):
                    skills.add(val.strip().lower())
            except:
                skills.add(str(val).strip().lower())
        print(f"✅ {len(skills)} known skills loaded")
        return skills
    except Exception as e:
        st.error(f"❌ Failed loading known skills: {e}")
        return set()

skill2vec_model = load_skill2vec_model()
known_skills = load_known_skills()

def get_core_skills(cleaned_skills, top_n=5):
    """
    Extracts the most relevant/important skills for job & course recommendations.
    Priority is given to common tech skills and domain-specific keywords.
    """
    core_keywords = ['html', 'css', 'javascript', 'python', 'react', 'reactjs', 'django', 'node', 'frontend',
                     'backend', 'java', 'c++', 'sql', 'bootstrap', 'postman', 'php', 'angular', 'vue', 'typescript',
                     'jquery', 'mongodb', 'mysql', 'postgresql', 'redis', 'aws', 'azure', 'gcp', 'docker', 'kubernetes',
                     'git', 'github', 'gitlab', 'bitbucket', 'jenkins', 'travis', 'circleci', 'nginx', 'apache', 'linux',
                     'windows', 'macos', 'ios', 'android', 'flutter', 'react native', 'xamarin', 'unity', 'unreal',
                     'blender', 'photoshop', 'illustrator', 'figma', 'sketch', 'adobe xd', 'indesign', 'premiere pro',
                     'after effects', 'final cut pro', 'maya', '3ds max', 'zbrush', 'substance painter', 'marvelous designer',
                     'tensorflow', 'pytorch', 'keras', 'scikit-learn', 'pandas', 'numpy', 'scipy', 'matplotlib', 'seaborn',
                     'tableau', 'power bi', 'excel', 'word', 'powerpoint', 'outlook', 'jira', 'confluence', 'trello',
                     'asana', 'slack', 'discord', 'zoom', 'teams', 'skype', 'webex', 'meet', 'ruby', 'rails', 'laravel',
                     'spring', 'hibernate', 'express', 'flask', 'fastapi', 'graphql', 'rest', 'soap', 'xml', 'json',
                     'yaml', 'markdown', 'latex', 'bash', 'powershell', 'cmd', 'vim', 'vscode', 'intellij', 'eclipse',
                     'netbeans', 'android studio', 'xcode', 'sublime text', 'atom', 'notepad++', 'emacs', 'pytorch',
                     'opencv', 'selenium', 'cypress', 'jest', 'mocha', 'chai', 'junit', 'pytest', 'phpunit', 'gradle',
                     'maven', 'npm', 'yarn', 'pip', 'conda', 'virtualenv', 'docker-compose', 'terraform', 'ansible']

    # Filter skills that match core keywords
    filtered = [skill for skill in cleaned_skills if any(k in skill.lower() for k in core_keywords)]

    # Fall back to first N if no match found
    if not filtered:
        filtered = cleaned_skills[:top_n]

    return filtered[:top_n]



def process_data(data, source_type):
    """
    Processes the input data (CV or form data) to extract skills and generate recommendations.

    Args:
        data (dict or str):  Either the extracted text from a CV (str) or the data dictionary
                            from the form submission (dict).
        source_type (str):  'cv' or 'form' to indicate the source of the data.

    Returns:
        tuple: (skills, jobs, courses, careers) or (None, None, None, None) on error
    """
    try:
        if source_type == 'cv':
            text = data
            skills = clean_skills_with_skill2vec(text, known_skills, skill2vec_model)
        elif source_type == 'form':
            #  Extract skills from the form data.  Adjust this as necessary
            skills = data.get('skills', [])
            if not skills:
                logging.warning("⚠️ No skills found in form data.")
                skills = []
            skills = [skill.lower() for skill in skills] # lowercase
        else:
            raise ValueError(f"Invalid source_type: {source_type}")

        core_skills = get_core_skills(skills, top_n=5)
        jobs = recommend_jobs(core_skills)
        courses = get_course_recommendations({"skills": core_skills})
        careers = recommend_career_path(skills)  # Use the original extracted skills

        return skills, jobs, courses, careers

    except Exception as e:
        logging.error(f"❌ Error processing {source_type} data: {e}")
        return None, None, None, None



@app.route('/api/analyze-cv', methods=['POST'])
def analyze_cv():
    """Analyzes a CV (PDF or DOCX) to extract information and recommend jobs/courses."""
    if 'cv' not in request.files:
        return jsonify({"status": "error", "message": "No CV uploaded"}), 400
    file = request.files['cv']
    filename = file.filename.lower()

    if not (filename.endswith(".pdf") or filename.endswith(".docx")):
        return jsonify({"status": "error", "message": "Unsupported file type"}), 400

    # Save uploaded file to temp
    with tempfile.NamedTemporaryFile(delete=False, suffix=os.path.splitext(filename)[1]) as tmp:
        file.save(tmp.name)
        temp_path = tmp.name

    try:
        # Extract text from CV
        text = extract_text_from_pdf(temp_path) if filename.endswith(".pdf") else extract_text_from_docx(temp_path)

        if not text:
            return jsonify({"status": "error", "message": "Failed to extract text from the CV."}), 500

        skills, jobs, courses, careers = process_data(text, 'cv')  # Process the CV data

        if skills is None:
            return jsonify({"status": "error", "message": "Failed to process CV data"}), 500

        # Return results
        return jsonify({
            "skills": skills,
            "jobs": jobs,
            "courses": courses,
            "career_paths": careers
        }), 200

    except Exception as e:
        logging.error(f"❌ Error analyzing CV: {str(e)}")
        return jsonify({"status": "error", "message": "Failed to analyze CV"}), 500

    finally:
        try:
            os.remove(temp_path)
        except Exception:
            pass



@app.route('/api/analyze-data', methods=['POST'])
def analyze_data():
    """Analyzes data from the manual form submission."""
    data = request.json.get('data', {})
    logging.info(f"Data received for analysis: {data}")

    skills, jobs, courses, careers = process_data(data, 'form')  # Process the form data

    if skills is None:
        return jsonify({"status": "error", "message": "Failed to process form data"}), 500

    # Return the results
    return jsonify({
        'skills': skills,
        'jobs': jobs,
        'courses': courses,
        'career_paths': careers
    }), 200



if __name__ == "__main__":
    app.run(debug=True, port=5000)
