import requests
from bs4 import BeautifulSoup
from telegram import Bot
import os
import random
import time

# Get the bot token and channel ID from environment variables
BOT_TOKEN = os.environ['BOT_TOKEN']
CHANNEL_ID = os.environ['CHANNEL_ID']  # Replace with your channel ID

bot = Bot(token=BOT_TOKEN)

def scrape_aliexpress():
    url = 'https://best.aliexpress.com/'
    response = requests.get(url)
    if response.status_code != 200:
        print(f"Error fetching the URL: {response.status_code}")
        return []

    soup = BeautifulSoup(response.content, 'html.parser')
    
    product_links = []

    for link in soup.find_all('a', href=True):
        href = link['href']
        if href.startswith('https://www.aliexpress.com/item/'):
            product_links.append(href)

    if not product_links:
        print("No product links found.")
    return product_links

def post_to_channel():
    product_links = scrape_aliexpress()
    
    if product_links:
        # Randomly select a product link
        random_link = random.choice(product_links)
        bot.send_message(chat_id=CHANNEL_ID, text=random_link)
    else:
        print("No product links found.")

if __name__ == "__main__":
    print("Bot started.")
    while True:
        post_to_channel()
        print("Waiting for 60 seconds before posting again...")
        time.sleep(60)
