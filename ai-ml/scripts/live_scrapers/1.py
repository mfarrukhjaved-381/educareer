import base64

client_id = "1tUXp2bPCOYCuW8wadGUApAJzdGcR6y1GwCKFfJA0Y2UJSDj"
client_secret = "GJWff1bASD9GpHXiUSS7Am4XfukASY1FCQ7QEXArGxTAAF2mIgfV4HpR7p9fDk9I"
credentials = f"{client_id}:{client_secret}"
encoded_credentials = base64.b64encode(credentials.encode()).decode()

print("Base64 Encoded:", encoded_credentials)
