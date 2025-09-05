# CollaBox

<p align="center">
  <img src="public/logowhite.png" alt="CollaBox Logo" width="150">
  <h1 align="center">Facility Management System</h1>
  <p align="center">This system enables multidisciplinary student teams from Computer Science/Software Engineer- ing and Engineering to collaborate on real-world projects carried out at government facilities. It provides a unified platform to manage programs, facilities, services, equipment, projects, partic- ipants, and outcomes, ensuring that projects are well-organized, properly resourced, and aligned with Uganda’s NDPIII, Digital Transformation Roadmap (2023–2028), and 4IR Strategy.

This Project was built with Laravel and strictly follows the MVC Architecture.</p>
  
  <p align="center">
    <a href="#features">Features</a> •
    <a href="#requirements">Requirements</a> •
    <a href="#installation">Installation</a> •
    <a href="#usage">Usage</a> •
    <a href="#license">License</a>
  </p>
</p>

## 🚀 Features

- **Facility Management**: Track and manage multiple facilities with ease
- **Service Tracking**: Monitor services and maintenance schedules
- **Equipment Management**: Keep track of equipment across facilities
- **User Authentication**: Secure user management system
- **Responsive Design**: Works on desktop and mobile devices
- **Modern UI**: Clean and intuitive user interface

## 🛠 Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7 or MariaDB >= 10.3
- Node.js >= 14.x
- NPM or Yarn

## 🚀 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/facility-management-system.git
   cd facility-management-system
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install NPM dependencies:
   ```bash
   npm install
   ```

4. Create a copy of the .env file:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Configure your database in the `.env` file

7. Run database migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

8. Compile assets:
   ```bash
   npm run build
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` in your browser to see the application.

## 📝 Usage

1. Register a new account or use the default admin credentials:
   - Email: admin@example.com
   - Password: password

2. Navigate through the dashboard to manage facilities, services, and equipment.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com)
- Frontend powered by [Tailwind CSS](https://tailwindcss.com/)
- Icons from [Heroicons](https://heroicons.com/)

## 🔒 Security

If you discover any security related issues, please email your team's security contact instead of using the issue tracker.

