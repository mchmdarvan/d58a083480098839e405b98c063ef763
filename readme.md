How to run this project.

1. I put the vendor folder on purpose since i do some adjustment on it.
2. Make sure you already import the sql file and json collection to postman that has already been provide.
3. Please run php -S localhost:8000
4. If it's already done, please run this command "php config/worker/queue.php" to put the email in queue list. If you want to send the email just need to run this one "php config/worker/worker.php" All the logs will be show in the terminal when you run the command.