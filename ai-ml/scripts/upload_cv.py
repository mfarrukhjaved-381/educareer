import os
import re
import logging
from flask import Flask, request, jsonify
from PyPDF2 import PdfReader
from docx import Document
# from transformers import pipeline
import requests
# from extract_user_profile import (
#     extract_name, extract_email, extract_role, extract_location,
#     extract_summary, extract_education, extract_experience,
#     extract_projects, extract_certifications, extract_interests
# )


# Custom imports
from skill_extraction import extract_skills
from job_recommendations import recommend_jobs

# === Init Flask App ===
app = Flask(__name__)
UPLOAD_FOLDER = os.path.join(os.path.dirname(__file__), "uploads")
os.makedirs(UPLOAD_FOLDER, exist_ok=True)
app.config["UPLOAD_FOLDER"] = UPLOAD_FOLDER
ALLOWED_EXTENSIONS = {"pdf", "docx"}
logging.basicConfig(level=logging.INFO)

# # === HuggingFace summarizer ===
# summarizer = pipeline("summarization", model="facebook/bart-large-cnn")

# === File Validation ===
def allowed_file(filename):
    return "." in filename and filename.rsplit(".", 1)[1].lower() in ALLOWED_EXTENSIONS

# === Extract Text from PDF ===
def extract_text_from_pdf(pdf_path):
    text = ""
    try:
        with open(pdf_path, 'rb') as file:
            reader = PdfReader(file)
            for page in reader.pages:
                content = page.extract_text()
                if content:
                    text += content + "\n"
    except Exception as e:
        logging.error(f"❌ Error extracting PDF: {e}")
        return None
    return text.strip()

# === Extract Text from DOCX ===
def extract_text_from_docx(docx_path):
    text = ""
    try:
        document = Document(docx_path)
        for paragraph in document.paragraphs:
            text += paragraph.text + "\n"
    except Exception as e:
        logging.error(f"❌ Error extracting DOCX: {e}")
        return None
    return text.strip()

# === Extract Basic Fields Using Regex ===
def extract_profile_data(text):
    name = re.findall(r"(?i)name[:\- ]+(.*)", text)
    email = re.findall(r"[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+", text)
    role = re.findall(r"(?i)(?:job\s*title|position)[:\- ]+(.*)", text)
    location = re.findall(r"(?i)(?:location|address)[:\- ]+(.*)", text)

    def extract_section(section_name):
        pattern = rf"(?i){section_name}[:\-]?\s*((?:.|\n)*?)(?:\n\s*\n|$)"
        match = re.search(pattern, text)
        return match.group(1).strip() if match else ""

    return {
        "name": name[0].strip() if name else "",
        "email": email[0] if email else "",
        "role": role[0].strip() if role else "",
        "location": location[0].strip() if location else "",
        "education": extract_section("education"),
        "experience": extract_section("experience"),
        "interests": extract_section("interests"),
        "projects": extract_section("projects"),
        "certifications": extract_section("certifications"),
        "summary": extract_section("summary")
    }

# === Generate AI Summary if Needed ===
def generate_summary(text):
    try:
        chunk = text[:1000]  # Summarizer limit
        summary = summarizer(chunk, max_length=100, min_length=30, do_sample=False)
        return summary[0]['summary_text'].strip()
    except Exception as e:
        logging.error(f"❌ Error generating summary: {e}")
        return "Summary not available."

# # === Upload Route ===
# @app.route('/upload', methods=['POST'])
# def upload_cv():
#     if 'cv' not in request.files:
#         return jsonify({"status": "error", "message": "No CV file provided"}), 400

#     cv_file = request.files['cv']
#     filename = cv_file.filename

#     if not allowed_file(filename):
#         return jsonify({"status": "error", "message": "Invalid file type. Only PDF and DOCX allowed."}), 400

#     filepath = os.path.join(app.config['UPLOAD_FOLDER'], filename)
#     cv_file.save(filepath)

#     text = extract_text_from_pdf(filepath) if filename.endswith(".pdf") else extract_text_from_docx(filepath)
#     if not text:
#         return jsonify({"status": "error", "message": "Failed to extract text from CV"}), 500

#     try:
#         # === Extract all fields ===
#         name = extract_name(text)
#         email = extract_email(text)
#         role = extract_role(text)
#         location = extract_location(text)
#         summary = extract_summary(text)

#         if not summary:
#             summary = generate_summary(text)

#         education = extract_education(text)
#         experience = extract_experience(text)
#         projects = extract_projects(text)
#         certifications = extract_certifications(text)
#         interests = extract_interests(text)
#         skills = extract_skills(text)
#         jobs = recommend_jobs(skills)

#         # === Final profile data ===
#         profile_data = {
#             "name": name,
#             "email": email,
#             "role": role,
#             "location": location,
#             "summary": summary,
#             "skills": skills,
#             "education": education,
#             "experience": experience,
#             "interests": interests,
#             "projects": projects,
#             "certifications": certifications
#         }

#         # === Send to Laravel ===
#         def send_profile_to_laravel(data):
#             laravel_api_url = "http://127.0.0.1:8000/api/save-profile"
#             headers = {
#                 "Content-Type": "application/json",
#                 "Accept": "application/json"
#             }

#             try:
#                 response = requests.post(laravel_api_url, json=data, headers=headers)
#                 if response.status_code == 200:
#                     logging.info("✅ Profile sent to Laravel successfully.")
#                 else:
#                     logging.error(f"❌ Failed to send profile to Laravel: {response.status_code} - {response.text}")
#             except Exception as e:
#                 logging.error(f"❌ Exception while sending profile to Laravel: {e}")

#         send_profile_to_laravel(profile_data)

#         # === Final response to frontend ===
#         return jsonify({
#             "status": "success",
#             "profile": profile_data,
#             "recommended_jobs": jobs
#         }), 200

#     except Exception as e:
#         logging.error(f"❌ Error processing CV: {e}")
#         return jsonify({"status": "error", "message": "Failed to process CV."}), 500

#     finally:
#         try:
#             os.remove(filepath)
#         except:
#             pass


if __name__ == "__main__":
    app.run(debug=True, port=5000)
