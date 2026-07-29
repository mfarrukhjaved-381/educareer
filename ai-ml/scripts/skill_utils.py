# ~/fyp/ai-ml/scripts/skill_utils.py
from difflib import get_close_matches
import spacy

def suggest_similar_skills(skill, model, topn=5):
    vocab = model.wv.index_to_key
    skill_lower = skill.lower().replace('_', ' ')
    if skill_lower in vocab:
        print(f"'{skill}' found in vocabulary.")
        return [skill_lower]
    else:
        print(f"'{skill}' not found. Suggesting similar skills:")
        suggestions = get_close_matches(skill_lower, vocab, n=topn, cutoff=0.6)
        for s in suggestions:
            print(f" - {s}")
        return suggestions



# Load spaCy model (make sure it's installed: python -m spacy download en_core_web_sm)
nlp = spacy.load("en_core_web_sm")

def generate_summary_from_text(text, max_sentences=3):
    """
    Generates a summary by extracting key sentences from the CV text.
    Prioritizes sentences with experience, skills, and education.
    """
    doc = nlp(text)
    sentences = [sent.text.strip() for sent in doc.sents if 30 < len(sent.text) < 200]

    keywords = ['experience', 'skilled', 'expertise', 'education', 'projects', 'developed', 'responsible']
    scored_sentences = sorted(sentences, key=lambda s: sum(1 for k in keywords if k in s.lower()), reverse=True)

    summary = " ".join(scored_sentences[:max_sentences])
    return summary if summary else "Experienced professional with a diverse skill set and background."
