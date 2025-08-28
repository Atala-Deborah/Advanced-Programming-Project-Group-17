# ADVANCED PROGRAMMING PROJECT (Group 17)
## Collabo System
This system enables multidisciplinary student teams from Computer Science/Software Engineer-
ing and Engineering to collaborate on real-world projects carried out at government facilities. It
provides a unified platform to manage programs, facilities, services, equipment, projects, partic-
ipants, and outcomes, ensuring that projects are well-organized, properly resourced, and aligned
with Uganda’s NDPIII, Digital Transformation Roadmap (2023–2028), and 4IR Strategy.

This Project implements a Web application, and mobile app(Android/IOS). It also strictly follows the MVC Architecture.

## Setup Instructions (SQLite) - Windows OS

This guide will help you set up and run the Laravel project on **Windows** using **SQLite**. No additional server stack (XAMPP/WAMP) is required — just make sure you have PHP, Composer, Node.js, and Git setup correctly on your machine.

---

### Prerequisites

1. **PHP 8.1 or higher**  
   - Make sure PHP is installed and added to your system PATH.  
   - Required PHP extensions:
     - `pdo`
     - `pdo_sqlite`
     - `openssl`
     - `mbstring`
     - `tokenizer`
     - `xml`
     - `ctype`
     - `json`
2. **Composer** – PHP dependency manager  
   - [Get Composer](https://getcomposer.org/download/)
3. **Node.js & NPM** – For compiling frontend assets  
   - [Download Node.js](https://nodejs.org/en/download)
4. **Git** – For cloning the repository  
   - [Download Git](https://git-scm.com/downloads)

---

### Step 1: Clone the repo

Open **Command Prompt** or **PowerShell** and run:

```bash
git clone https://github.com/Atala-Deborah/Advanced-Programming-Project-Group-17.git
cd Advanced-Programming-Project-Group-17


### Installation Steps

1. Clone the repository
```bash
git clone https://github.com/Atala-Deborah/Advanced-Programming-Project-Group-17.git
cd Advanced-Programming-Project-Group-17
```

2. Install PHP dependencies
```bash
composer install
```

3. Install NPM packages
```bash
npm install
```

4. Create environment file
This will be shared in the group but you can as well create your own in the project directory using
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Configure database in `.env` file
```
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=ap.capstone
```

7. Create SQLite database file
This is if it doesn't exit already in capstone-app/database
```bash
type nul > database/database.sqlite
```

8. Start the development server
```bash
php artisan serve
```

9. In a separate terminal, compile assets
```bash
npm run dev
```
(This will compile JavaScript and CSS assets required for the frontend)

Your application should now be running at `http://localhost:8000`

### Common Issues
- If you encounter any permissions issues, run commands as administrator
- Check that all required PHP extensions are enabled in php.ini
- Make sure the sqlite3 PHP extension is enabled
Your application should now be running at `http://localhost:8000`

### Common Issues
- If you encounter any permissions issues, run commands as administrator
- Make sure MySQL service is running before migrations
- Check that all required PHP extensions are enabled in php.ini
