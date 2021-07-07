# javascript-behat-tests
Behat test 

Lauch chrome in shell with 
google-chrome-stable --remote-debugging-address=0.0.0.0 --remote-debugging-port=9222

(or headless start)
google-chrome --disable-gpu --headless --remote-debugging-address=0.0.0.0 --remote-debugging-port=9222

Make sure it's running

Launch tests with 
./vendor/bin/behat

Composer is installed but here are install command:
composer require --dev behat/behat behat/mink-extension behat/mink-goutte-driver dmore/behat-chrome-extension


