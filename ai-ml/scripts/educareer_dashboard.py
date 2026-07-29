# edu_career_dashboard.py
import streamlit as st
import tempfile, os, re, ast
import pandas as pd
import gensim
from difflib import get_close_matches
from streamlit.components.v1 import html
from nltk.corpus import stopwords
import spacy

# 📌 Custom Modules
from upload_cv import extract_text_from_pdf, extract_text_from_docx
from job_recommendations import recommend_jobs
from course_recommendations import get_course_recommendations
from career_path_recommendation import recommend_career_path
from skill_gap import analyze_skill_gap_for_career
from skill_extraction import get_most_similar_skill


# =============================
# ⚙️ Streamlit Setup
# =============================
st.set_page_config(
    page_title="EduCareer Dashboard",
    page_icon="📘",
    layout="wide"
)

# =============================
# 🎨 Custom CSS Styling
# =============================
st.markdown("""
    <style>
    .title { font-size: 36px; font-weight: bold; color: #2c3e50; }
    .subtitle { font-size: 18px; color: #34495e; }
    .section-title { font-size: 22px; color: #1f618d; margin-top: 1em; }
    .card { background-color: #f9f9f9; padding: 1rem; border-radius: 10px;
            margin-bottom: 1.2rem; box-shadow: 0 0 8px rgba(0,0,0,0.05); }
    </style>
""", unsafe_allow_html=True)



# =============================
# 🧠 Enhanced Skill Extraction
# =============================
def clean_text(text):
    text = re.sub(r'[^\w\s]', ' ', text)
    return re.sub(r'\s+', ' ', text).lower().strip()

def extract_candidate_phrases(text):
    doc = nlp(text)
    phrases = []

    for chunk in doc.noun_chunks:
        phrase = chunk.text.lower().strip()
        if phrase not in stop_words and len(phrase.split()) <= 4:
            phrases.append(phrase)

    return phrases

def clean_skills_with_skill2vec(text, known_skills, model, similarity_threshold=0.9, embedding_threshold=0.7):
    if not model or not known_skills:
        return []

    text = clean_text(text)
    words = [w for w in text.split() if len(w) > 2 and w not in stop_words]
    phrases = extract_candidate_phrases(text)

    extracted_skills = set()

    # 🔹 Direct Matches
    extracted_skills.update([w for w in words if w in known_skills])
    extracted_skills.update([p for p in phrases if p in known_skills])

    # 🔹 Fuzzy Matching (for noisy data)
    for phrase in phrases:
        if phrase not in extracted_skills:
            match = get_close_matches(phrase, known_skills, n=1, cutoff=similarity_threshold)
            if match:
                extracted_skills.add(match[0])

    # 🔹 Semantic Matching with Skill2Vec
    for word in words:
        if word in model.wv and word not in extracted_skills:
            try:
                for sim_word, score in model.wv.most_similar(word, topn=3):
                    if sim_word in known_skills and score >= embedding_threshold:
                        extracted_skills.add(sim_word)
            except:
                continue

    return sorted(skill for skill in extracted_skills if len(skill) > 2)
# =============================
# 🚀 Streamlit Main UI
# =============================
def main():
    st.markdown("<div class='title'>📘 EduCareer: Career Intelligence Platform</div>", unsafe_allow_html=True)
    st.markdown("<div class='subtitle'>Upload your CV to get personalized jobs, courses, and career suggestions.</div>", unsafe_allow_html=True)
    st.markdown("---")

    uploaded_file = st.file_uploader("📄 Upload your CV", type=["pdf", "docx"])
    extracted_text = ""

    if uploaded_file:
        with tempfile.NamedTemporaryFile(delete=False) as tmp:
            tmp.write(uploaded_file.read())
            file_path = tmp.name

        extracted_text = extract_text_from_pdf(file_path) if uploaded_file.type == "application/pdf" else extract_text_from_docx(file_path)
        os.unlink(file_path)

    if extracted_text:
        extracted_skills = clean_skills_with_skill2vec(extracted_text, known_skills, skill2vec_model)

        st.expander("🧠 Extracted Skills").success(", ".join(extracted_skills) if extracted_skills else "No skills found.")
        st.expander("📜 Raw Text").code(extracted_text[:2000] + "..." if len(extracted_text) > 2000 else extracted_text)

        # JOB RECOMMENDATIONS
        st.markdown("<div class='section-title'>💼 Top Job Recommendations</div>", unsafe_allow_html=True)
        jobs = recommend_jobs(extracted_skills)
        if jobs:
            for idx, job in enumerate(jobs[:3]):
                st.markdown(f"**{idx+1}. {job['Job Title']}**")
                st.write(f"🏢 {job.get('Company', 'N/A')} | 🌍 {job.get('Location', 'N/A')}")
                st.success(f"✅ Matching: {', '.join(job.get('Matching Skills', []))}")
                gap = analyze_skill_gap_for_career(extracted_skills, job['Job Title'])
                if gap: st.warning(f"⚠️ Skill Gaps: {', '.join(gap)}")
                if job.get("URL"): st.markdown(f"[🔗 Apply Now]({job['URL']})", unsafe_allow_html=True)

        else:
            st.info("No matching jobs found.")

        # COURSE RECOMMENDATIONS
        st.markdown("<div class='section-title'>📚 Recommended Courses</div>", unsafe_allow_html=True)
        courses = get_course_recommendations(extracted_skills)
        if courses:
            for course in courses:
                try:
                    required = ast.literal_eval(course.get("Required Skills", "[]"))
                except: required = []
                matching = [s for s in extracted_skills if s.lower() in map(str.lower, required)]
                st.markdown(f"**🎓 {course['Course Name']}** (_{course['Platform']}_)")
                st.success(f"Matching: {', '.join(matching)}")
        else:
            st.info("No relevant courses found.")

        # CAREER PATH
        st.markdown("<div class='section-title'>🧭 Career Path Suggestions</div>", unsafe_allow_html=True)
        paths = recommend_career_path(extracted_skills)
        if paths:
            for idx, path in enumerate(paths):
                st.markdown(f"**{idx+1}. {path['Career Path']}**")
                st.success(f"✅ Skills: {', '.join(path['Matching Skills'])}")
                st.info(f"➡️ Next Roles: {', '.join(path['Next Roles'])}")
                st.write(f"📊 Relevance: `{path['Relevance Score']:.2f}`")
        else:
            st.warning("No career paths found.")
    else:
        st.info("👆 Upload your CV to begin.")

    st.markdown("---")
    st.caption("🚀 Powered by Skill2Vec • Built by Farrukh & Usman • BSCS FYP 2025 🎓")

# 🔁 Run the Streamlit App
if __name__ == "__main__":
    main()
