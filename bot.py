import requests
from bs4 import BeautifulSoup
from telegram import Bot
import os

# Get the bot token and channel ID from environment variables
BOT_TOKEN = os.environ['BOT_TOKEN']
CHANNEL_ID = os.environ['CHANNEL_ID']  # Replace with your channel ID

bot = Bot(token=BOT_TOKEN)

def scrape_aliexpress():
    url = 'https://www.aliexpress.com/wholesale?catId=0&initiative_id=SB_20210608052432&SearchText=your+search+term'
    response = requests.get(url)
    if response.status_code != 200:
        print(f"Error fetching the URL: {response.status_code}")
        return []

    soup = BeautifulSoup(response.content, 'html.parser')
    
    products = []

    for item in soup.select('.item'):  # Adjust the selector to match the AliExpress HTML structure
        title = item.select_one('.item-title')
        price = item.select_one('.price')
        image = item.select_one('.item-img img')
        
        if title and price and image:
            products.append({
                'title': title.get_text(strip=True),
                'price': price.get_text(strip=True),
                'image_url': image['src']
            })

    if not products:
        print("No products found.")
    return products

def post_to_channel():
    products = scrape_aliexpress()
    
    for product in products:
        message = f"Title: {product['title']}\nPrice: {product['price']}\n"
        print(f"Posting: {message}")
        bot.send_photo(chat_id=CHANNEL_ID, photo=product['image_url'], caption=message)

if __name__ == "__main__":
    print("Bot started.")
    post_to_channel()
    print("Bot finished.")
