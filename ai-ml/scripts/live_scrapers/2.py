import requests

encoded_credentials = "MXRVWHAyYlBDT1lDdVc4d2FkR1VBcEFKemRHY1I2eTFHd0NLRmZKQTBZMlVKU0RqOkdKV2ZmMWJBU0Q5R3BIWGlVU1M3QW00WGZ1a0FTWTFGQ1E3UUVYQXJHeFRBQUYybUlnZlY0SHBSN3A5ZkRrOUk="

headers = {
    "Authorization": f"Basic {encoded_credentials}",
    "Content-Type": "application/x-www-form-urlencoded"
}

data = {
    "grant_type": "client_credentials"
}

response = requests.post(
    "https://api.coursera.com/oauth2/client_credentials/token",
    headers=headers,
    data=data
)

if response.status_code == 200:
    token_data = response.json()
    access_token = token_data["access_token"]
    print("✅ Access Token:", access_token)
else:
    print("❌ Error:", response.status_code, response.text)
