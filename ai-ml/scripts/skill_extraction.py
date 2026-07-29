import os
import re
import spacy
import gensim
from gensim.models import Word2Vec
from typing import List, Set
from difflib import get_close_matches

# Load spaCy model
nlp = spacy.load("en_core_web_sm")
stop_words = nlp.Defaults.stop_words

# Load Skill2Vec model
MODEL_PATH = os.path.expanduser("~/fyp/ai-ml/models/skill2vec.model")
try:
    model = Word2Vec.load(MODEL_PATH)
    print("✅ Skill2Vec model loaded successfully.")
except Exception as e:
    print(f"❌ Error loading Word2Vec model: {e}")
    model = None

model_vocab = set(model.wv.index_to_key) if model else set()
known_skills = model_vocab  # Using model vocabulary as known skills

# Rejected terms collector
REJECTED_TERMS = set()


# Junk & generic keywords to ignore
IRRELEVANT_KEYWORDS = set([
    'car', 'pink', 'world', 'modular', 'apple', 'like', 'done', 'good', 'bad',
    'thing', 'object', 'item', 'data', 'model', 'color', 'stuff', 'beautiful',
    'fast', 'slow', 'today', 'tomorrow', 'weather', 'train', 'game', 'music', 'access',
    'control', 'system', 'process', 'operation', 'maintenance', 'facility', 'equipment',
    'tool', 'machine', 'device', 'instrument', 'meter', 'gauge', 'sensor', 'actuator',
    'component', 'part', 'module', 'unit', 'procedure', 'protocol', 'standard',
    'specification', 'design', 'architecture', 'blueprint', 'diagram', 'chart', 'graph',
    'table', 'database', 'file', 'record', 'information', 'knowledge', 'skill', 'ability',
    'red', 'blue', 'green', 'yellow', 'orange', 'purple', 'black', 'white', 'gray',
    'book', 'paper', 'pen', 'pencil', 'desk', 'chair', 'room', 'building', 'house',
    'street', 'road', 'path', 'garden', 'tree', 'flower', 'plant', 'animal', 'bird',
    'status', 'condition', 'state', 'mode', 'setting', 'configuration', 'setup', 'layout',
    'format', 'structure', 'framework', 'platform', 'environment', 'context', 'scenario',
    'situation', 'case', 'instance', 'example', 'sample', 'template', 'pattern', 'style',
    'method', 'technique', 'approach', 'strategy', 'plan', 'scheme', 'arrangement',
    'organization', 'management', 'coordination', 'direction', 'guidance', 'instruction',
    'command', 'order', 'request', 'demand', 'requirement', 'need', 'want', 'desire',
    'preference', 'choice', 'option', 'alternative', 'possibility', 'opportunity',
])

GENERIC_STOPWORDS = set([
    "project", "resume", "experience", "education", "university", "college",
    "ability", "excellent", "effective", "current", "detail", "strong",
    "problem", "solution", "communication", "designing", "device", "time",
    "teamwork", "graduate", "bachelor", "internship", "training", "application",
    "tool", "system", "process", "understanding", "knowledge", "familiarity",
    "skill", "level", "basic", "intermediate", "advanced", "expert", "proficient",
    "working", "exposure", "background", "technique", "method", "principle", "concept",
    "approach", "practice", "standard", "requirement", "responsibility", "duty",
    "function", "task", "role", "position", "candidate", "person", "individual", "field",
    "area", "domain", "sector", "aspect", "factor", "element", "set", "group", "collection",
    "range", "variety", "type", "form", "part", "component", "piece", "nature", "kind",
    "sort", "way", "mean", "manner", "thing", "stuff", "material", "service", "product",
    "perform", "conduct", "execute", "ensure", "maintain", "provide", "assist", "help",
    "support", "capable", "responsible", "involved", "accountable", "contribute", "participate",
    "develop", "create", "build", "design", "implement", "configure", "install", "operate",
    "utilize", "employ", "manage", "oversee", "direct", "improve", "enhance", "optimize",
    "analyze", "evaluate", "assess", "research", "investigate", "test", "validate", "verify",
    "document", "report", "record", "train", "educate", "instruct", "troubleshoot", "diagnose",
    "resolve", "collaborate", "coordinate", "liaise", "plan", "organize", "schedule", "budget",
    "finance", "accounting", "market", "sell", "promote", "customer", "client", "relations",
    "human", "resources", "recruitment", "legal", "compliance", "regulatory", "safety", "security",
    "risk", "quality", "assurance", "business", "operations", "logistics", "supply chain",
    "facilities", "maintenance", "administrative", "clerical", "secretarial", "medical",
    "healthcare", "financial", "educational", "environmental", "political", "social", "cultural",
    "economical", "global", "international", "familiar", "expertise", "background", "proficiency",
    "adept", "competent", "skillful", "mastery", "aptitude", "talent", "capacity", "potential",
    "limitation",    "fluent", "english", "urdu", "language", "native", "speaker",
    "bilingual", "multilingual", "mother", "tongue", "verbal", "written",
    "excellent", "good", "basic", "communication", "interpersonal", "punjabi", "urdu", "hindi",
    "french", "spanish", "german", "italian", "portuguese", "arabic", "chinese", "japanese",
    "korean", "russian", "turkish", "hindi", "telugu", "tamil", "malayalam", "kannada",
    "marathi", "gujarati", "odia", "bengali", "assamese", "nepali", "tibetan", "burmese",
    "khmer", "lao", "vietnamese", "indonesian", "malay", "filipino", "thai", "myanmar",
    "malagasy", "maldivian", "maldivian", "maldivian", "maldivian", "maldivian", "maldivian", "clarity", "logic", "functionality", "core", "route", "submission", "return",
    "handling", "source", "consistency", "manual", "new", "check", "update",
    "code", "process", "payload", "modular", "ensure", "integration", "correct",
    "absolute", "expected", "test", "verify", "data", "file", "variable", "path",
    "integrate", "replace", "double", "check", "ensure", "correct", "core", "logic",
    "functionality", "route", "submission", "return", "handling", "source", "consistency",
    "manual", "new", "check", "update", "code", "process", "payload", "modular",
    "ensure", "integration", "correct", "absolute", "expected", "test", "verify",
    "data", "file", "variable", "path", "integrate", "replace", "double", "check",
    "ensure", "correct", "core", "logic", "functionality", "route", "submission",
    "return", "handling", "source", "consistency", "manual", "new", "check", "update",
    "objective", "summary", "profile", "qualification", "achievement", "accomplishment",
    "milestone", "target", "goal", "mission", "vision", "strategy", "tactic", "initiative",
    "program", "campaign", "venture", "endeavor", "effort", "attempt", "trial", "experiment",
    "workshop", "seminar", "conference", "meeting", "session", "discussion", "presentation",
    "demonstration", "exhibition", "showcase", "display", "performance", "delivery",
    "implementation", "deployment", "installation", "setup", "configuration", "customization",
    "modification", "adaptation", "adjustment", "alteration", "revision", "amendment",
    "update", "upgrade", "enhancement", "improvement", "advancement", "progression",
    "development", "evolution", "transformation", "transition", "change", "shift",
    "movement", "progress", "growth", "expansion", "scaling", "extension", "enlargement",
    "increase", "addition", "supplementation", "augmentation", "reinforcement", "strengthening",
    "fortification", "consolidation", "integration", "unification", "merger", "combination",
    "synthesis", "fusion", "blending", "mixing", "incorporation", "inclusion", "involvement"
    
])

def clean_text(text: str) -> str:
    # Remove email addresses and URLs
    text = re.sub(r'\S+@\S+\.\S+', ' ', text)
    text = re.sub(r'http\S+|www\S+', ' ', text)

    # Replace common separators or symbols with space
    text = re.sub(r'[•·|]', ' ', text)

    # Preserve programming symbols like +, ., # for languages (e.g., C++, C#, Node.js)
    text = re.sub(r'[^a-zA-Z0-9\+\.\#\s]', ' ', text)

    # Collapse multiple spaces into one
    text = re.sub(r'\s+', ' ', text)

    return text.lower().strip()


def extract_candidate_phrases(text: str) -> List[str]:
    doc = nlp(text)
    phrases = set()
    
    for chunk in doc.noun_chunks:
        phrase = chunk.text.lower().strip()

        # Reject phrases that are too short or too long
        if len(phrase.split()) > 4 or len(phrase) < 3:
            continue

        # Remove phrases that are all stopwords or mostly generic
        tokens = [token.text for token in nlp(phrase) if token.text not in stop_words]
        if not tokens:
            continue

        # Skip if all words in phrase are generic or meaningless
        if all(word in GENERIC_STOPWORDS or word in IRRELEVANT_KEYWORDS for word in tokens):
            continue

        phrases.add(" ".join(tokens))

    return list(phrases)



def extract_relevant_terms(text):
    doc = nlp(text)
    keywords = set()

    for chunk in doc.noun_chunks:
        chunk_text = chunk.text.lower().strip()

        # Skip chunks with too few characters or punctuation
        if len(chunk_text) < 3 or any(char in string.punctuation for char in chunk_text):
            continue

        # Filter individual tokens inside the noun chunk
        tokens = [token for token in chunk if token.is_alpha and not token.is_stop]
        if not tokens:
            continue

        # Join lemmatized words in the chunk (e.g., 'machine learning', 'web development')
        lemmatized = " ".join(token.lemma_.lower() for token in tokens)

        # Skip irrelevant terms
        if (
            lemmatized in GENERIC_STOPWORDS or 
            lemmatized in IRRELEVANT_KEYWORDS or 
            lemmatized in stop_words
        ):
            REJECTED_TERMS.add(lemmatized)
            continue

        # Skip non-technical terms by matching against the known skills model
        if lemmatized in known_skills:
            keywords.add(lemmatized)
        else:
            # If it's not a known skill, we try to fetch similar skills from Skill2Vec
            matches = get_close_matches(lemmatized, known_skills, n=1, cutoff=0.8)
            if matches:
                keywords.add(matches[0])

    return list(keywords)


def clean_skills_with_skill2vec(
    text: str,
    known_skills: Set[str],
    model: Word2Vec,
    similarity_threshold: float = 0.9,
    embedding_threshold: float = 0.75
) -> List[str]:
    if not model or not hasattr(model, "wv"):
        return []

    text = clean_text(text)
    words = [w for w in text.split() if len(w) > 2 and w not in stop_words]
    phrases = extract_candidate_phrases(text)

    extracted = set()

    corrections = {
        "reacto": "react",
        "develope": "developer",
        "apis": "api",
        "mern": "mern stack", 
        "node": "node.js",
        "js": "javascript",
        "py": "python",
        "ts": "typescript",
        "cpp": "c++",
        "ai": "artificial intelligence",
        "ml": "machine learning",
        "ui": "user interface",
        "ux": "user experience",
        "db": "database",
        "algo": "algorithm",
        "auth": "authentication",
        "aws": "amazon web services",
        "css": "cascading style sheets",
        "html": "hypertext markup language",
        "sql": "structured query language",
        "nosql": "non-relational database",
        "vue": "vue.js",
        "react native": "react native",
        "ng": "angular",
        "mongo": "mongodb",
        "postgres": "postgresql",
        "k8s": "kubernetes",
        "docker": "docker",
        "cicd": "ci/cd",
        "git": "git",
        "oop": "object oriented programming",
        "fp": "functional programming",
        "tdd": "test driven development",
        "rest": "representational state transfer",
        "graphql": "graphql",
        "jwt": "json web token",
        "oauth": "oauth",
        "saas": "software as a service",
        "paas": "platform as a service",
        "iaas": "infrastructure as a service",
        "mvc": "model view controller",
        "orm": "object relational mapping",
        "cdn": "content delivery network",
        "dns": "domain name system",
        "ssl": "secure sockets layer",
        "tls": "transport layer security",
        "http": "hypertext transfer protocol",
        "https": "hypertext transfer protocol secure",
        "tcp": "transmission control protocol",
        "ip": "internet protocol",
        "udp": "user datagram protocol"
    }

    for term in words + phrases:
        term = corrections.get(term.strip().lower(), term.strip().lower())
        if not term:
            continue

        # Filter unwanted terms
        if (
            term in GENERIC_STOPWORDS
            or term in IRRELEVANT_KEYWORDS
            or term in stop_words
            or len(term) <= 2
        ):
            REJECTED_TERMS.add(term)
            continue

        # Direct match
        if term in model_vocab:
            extracted.add(term)
            continue

        # Fuzzy match
        close_matches = get_close_matches(term, model_vocab, n=1, cutoff=similarity_threshold)
        if close_matches:
            extracted.add(close_matches[0])
            continue

        # Semantic similarity match
        try:
            similar_words = model.wv.most_similar(term, topn=5)
            for sim_word, score in similar_words:
                if sim_word in model_vocab and score >= embedding_threshold:
                    extracted.add(sim_word)
                    break
        except KeyError:
            # Word not in vocabulary
            REJECTED_TERMS.add(term)

    return sorted(extracted)

def extract_skills(text: str) -> List[str]:
    text = text.strip()
    if not text:
        return []
    return clean_skills_with_skill2vec(text, model_vocab, model)

# 🔍 Testing Section
if __name__ == "__main__":
    SAMPLE_TEXT = """
    Given your user_details table structure, you do not need to change the table structure. The current structure is suitable for storing the data from your manual form submission.
    
    Here's why and how it aligns:
    
    id: Primary key, auto-increment.
    user_id: Foreign key linking to the users table.
    data: This longtext column is perfect for storing the JSON-encoded data from your form, including skills, education, experience, etc.
    resume_url: Stores the URL of the user's resume.
    linkedin_url: Stores the URL of the user's LinkedIn profile.
    created_at/updated_at: Timestamps for tracking when the record was created and last updated.
    Therefore, you should update your controller (specifically the uploadUserData function) to correctly use this table structure. The key is to ensure that you are encoding the data from your form into JSON format before storing it in the data column.
    
    Here's the relevant part of the controller code again, emphasizing the correct usage with your table structure:
    Controller Update for User Details Table
    8 May, 11:47
    
    Open
    
    Key Points:
    
    Data Storage: The $allData array, which contains all the form fields, is encoded as JSON using json_encode() before being saved to the data column of the user_details table.
    No Table Changes: You do not need to alter your table structure.
    By ensuring your controller uses json_encode() as shown, you'll be correctly storing the form data in your database.
        """

    print("\n🎯 Final Extracted Skills:")
    skills = extract_skills(SAMPLE_TEXT)
    for s in skills:
        print(f"- {s}")

    print("\n🛑 Rejected Terms:")
    for r in sorted(REJECTED_TERMS):
        print(f"- {r}")