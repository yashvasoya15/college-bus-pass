COLLEGE BUS PASS MANAGEMENT SYSTEM - PHP + MONGODB

REQUIREMENTS
- Windows 10/11
- XAMPP (Apache + PHP)
- Composer
- MongoDB Community Server running locally OR a MongoDB Atlas connection string
- PHP MongoDB extension enabled (php_mongodb.dll)

PROJECT SETUP (LOCAL WITH XAMPP)
1. Extract this ZIP.
2. Copy the extracted folder "college-pass-php-mongodb" into:
   C:\xampp\htdocs\
3. Install Composer for Windows if it is not installed:
   https://getcomposer.org/Composer-Setup.exe
4. Open Command Prompt and run:
   cd C:\xampp\htdocs\college-pass-php-mongodb
   composer install
5. Install/start MongoDB Community Server, or create a free MongoDB Atlas cluster.
6. Enable the PHP MongoDB extension:
   - Open C:\xampp\php\php.ini
   - Find the extension directory line and ensure extension_dir points to C:\xampp\php\ext
   - Add this line (only if the matching DLL exists in C:\xampp\php\ext):
     extension=php_mongodb.dll
   - Save php.ini and restart Apache in XAMPP.
   - Check http://localhost/dashboard/phpinfo.php only if you create a phpinfo file; search the page for "mongodb".
   IMPORTANT: The DLL must match your XAMPP PHP version, architecture (usually x64), and thread-safety (TS/NTS).
   Download the matching Windows DLL from https://pecl.php.net/package/mongodb
7. Open config/db.php:
   - For local MongoDB, default is mongodb://127.0.0.1:27017 and database college_pass.
   - For MongoDB Atlas, replace the URI with your Atlas connection string. Keep credentials private.
8. Open in browser:
   http://localhost/college-pass-php-mongodb/
9. Create the demo admin once:
   http://localhost/college-pass-php-mongodb/create_admin.php
   Login: admin@gmail.com
   Password: admin123
10. DELETE create_admin.php after creating the admin.
11. Register a student, log in, apply for a pass, confirm demo payment, then log in as admin to approve/reject.

IF USING MONGODB ATLAS
In config/db.php, replace the default URI with your Atlas URI, for example:
$mongoUri = getenv('MONGODB_URI') ?: 'mongodb+srv://YOUR_USER:YOUR_PASSWORD@YOUR_CLUSTER.mongodb.net/?retryWrites=true&w=majority';
Do not commit real database credentials to GitHub. For deployment, set MONGODB_URI and MONGODB_DATABASE as environment variables.

IMPORTANT
- Payment is simulated only. It does not collect real money.
- This is a learning/demo project, not production-ready. Add CSRF protection, stronger session cookie settings, rate limiting and a real payment gateway before real use.
- If the page says MongoDB extension is missing, install the matching php_mongodb.dll and restart Apache.
- If Composer says the MongoDB extension is missing, enable the extension for the PHP CLI too. Check `php --ini` and `php -m` in Command Prompt; XAMPP PHP and another PHP installation may use different php.ini files.
