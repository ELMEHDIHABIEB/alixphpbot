# alixphpbot
Aliexpress auto-post products in Telegram using PHP 



. Setup GitHub Secrets
Go to your repository on GitHub.
Navigate to Settings > Secrets and variables > Actions.
Add the following secrets:
TELEGRAM_BOT_TOKEN: Your Telegram bot token.
TELEGRAM_CHAT_ID: Your Telegram chat ID (e.g., @Telegram_Channel_ID).
@Commit and Push
Commit your changes to GitHub.
Push your repository.
@Run the Workflow
Go to the Actions tab in your GitHub repository.
Select the workflow you created and run it manually or wait for the scheduled time.
Explanation
bot.php: The PHP script that sends a message to your Telegram channel using GuzzleHTTP.
composer.json: Defines GuzzleHTTP as a dependency.
main.yml: Defines the GitHub Actions workflow to run the PHP script every minute.
