# Project Manage System by Zardiel

Welcome to **Project Manage System by Zardiel**! This project is a full-featured management system designed to handle companies, projects, demands, and process records seamlessly. Built using Laravel and TailwindCSS, it offers a modern, responsive interface with **no JavaScript** (Zero Script Code). Whether JavaScript is enabled or disabled, the application remains fully functional, delivering a fast, reliable experience across all devices.

## Table of Contents

- [About](#about)
- [Features](#features)
- [Technologies](#technologies)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## About

**Project Manage System** is a web application designed to manage companies, projects, and their associated demands and process records efficiently. The platform allows users to:

- Create and manage companies and assign employees.
- Manage projects under companies.
- Track and organize demands for each project.
- View and manage process records related to demands.
- Admin Control Panel: Manage permissions, roles, users, companies, and more via admin interface.
- Features a permission system, allowing control over user access and capabilities.
- All of this works seamlessly without requiring JavaScript.
- Optimized for Tor

This system features a highly responsive UI that works seamlessly across devices, with tailored designs for smaller screens.

## Features

- **Company Management**: Create, view, and manage company profiles.
- **Project Management**: Assign projects to companies and manage assigned users.
- **Demand Management**: Manage various demands for projects categorized into types such as bugs, development tasks, testing, etc.
- **Process Tracking**: Keep track of process records for demands, including status changes.
- **Responsive Design**: Fully responsive, optimized for both desktop and mobile devices.
- **User Authentication and Authorization**: Access control using Laravel's built-in authentication and roles with Spatie Laravel Permission.

## Technologies

- **Backend**: Laravel (PHP)
- **Frontend**: TailwindCSS - PureCSS
- **Database**: MySQL

## Installation

Follow these steps to get the project up and running on your local machine:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/your-username/project-name.git
    cd project-name
    ```

2. **Install dependencies:**

    ```bash
    composer install
    npm install
    ```

3. **Set up environment variables:**

    - Copy `.env.example` to `.env`:

      ```bash
      cp .env.example .env
      ```

    - Update `.env` with your local database credentials and other required configurations.

4. **Generate application key:**

    ```bash
    php artisan key:generate
    ```

5. **Run migrations and seed the database:**

    ```bash
    php artisan migrate --seed
    ```

6. **Compile assets:**

    ```bash
    npm run dev
    ```

7. **Serve the application:**

    ```bash
    php artisan serve
    ```

8. Visit the application at `http://127.0.0.1:8000` in your browser.

9. Default superadmin account:   username: superadmin , password:superadmin

## Usage

Once the application is up and running:

- **Dashboard**: After logging in, you will be directed to a dashboard that displays an overview of companies, projects, demands, and process records associated with your account.
- **Companies**: Manage your companies, including creating new ones, viewing their details, and managing employees.
- **Projects**: Create and manage projects, assign them to companies, and assign users to projects.
- **Demands**: Track different types of demands for projects, categorized into bugs, development tasks, tests, and others.
- **Process Records**: View the status history and changes of demands across the projects.

## Contributing

Contributions are welcome! If you want to contribute, please fork the repository, create a new branch, and submit a pull request.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -am 'Add some feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Create a new pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.


## Visit Website

For more details, news, and updates, visit [Website](https://zardiel.com)!

