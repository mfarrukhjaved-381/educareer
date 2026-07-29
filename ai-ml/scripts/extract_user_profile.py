import re
from transformers import pipeline

# Load once at top level to avoid repeated loading
summarizer = pipeline("summarization", model="facebook/bart-large-cnn")

def extract_name(text):
    lines = text.splitlines()
    for line in lines:
        if line.strip() and len(line.split()) <= 4:
            return line.strip()
    return "Unknown"

def extract_email(text):
    match = re.search(r'[\w\.-]+@[\w\.-]+', text)
    return match.group(0) if match else "Not found"

def extract_location(text):
    for line in text.splitlines():
        if "Pakistan" in line or "City" in line:
            return line.strip()
    return "Unknown"

def extract_summary(text):
    # Use only first 1000 tokens max to fit model context
    summary = summarizer(text[:1000], max_length=100, min_length=40, do_sample=False)
    return summary[0]['summary_text']

def extract_role(text):
    lines = text.splitlines()
    for line in lines:
        if any(title in line.lower() for title in ['developer', 'engineer', 'designer', 'manager']):
            return line.strip()
    return "Not found"

# Stub functions for other fields (to implement in next steps)
def extract_education(text): return []
def extract_experience(text): return []
def extract_projects(text): return []
def extract_certifications(text): return []
def extract_interests(text): return []
