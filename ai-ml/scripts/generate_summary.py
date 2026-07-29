from transformers import pipeline

# Load model once globally (fast for reuse)
summarizer = pipeline("summarization", model="facebook/bart-large-cnn")

def generate_summary_from_text(text, max_length=130, min_length=30):
    """
    Uses HuggingFace's BART to generate a summary.
    Trims input to 1024 tokens max (BART model limit).
    """
    if len(text) > 1024:
        text = text[:1024]

    result = summarizer(text, max_length=max_length, min_length=min_length, do_sample=False)
    return result[0]['summary_text'] if result else "Professional summary not available."
