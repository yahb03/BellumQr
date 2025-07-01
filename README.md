# BellumQR - Weapon Assignment System

BellumQR is a web-based application designed to streamline the process of assigning and managing weapons using QR codes. The system allows administrators to register users and weapons, assign weapons to users, and track the status and location of each weapon.

## Features

*   **User Management:** Register, edit, and delete users.
*   **Weapon Management:** Register, edit, and delete weapons.
*   **QR Code Generation:** Automatically generate QR codes for users, weapons, and assignments.
*   **Weapon Assignment:** Assign weapons to users and track their status.
*   **Search Functionality:** Search for users and weapons by their ID or serial number.
*   **Admin Panel:** A dedicated panel for administrators to manage the system.

## Project Structure

The project follows a modified MVC (Model-View-Controller) pattern:

*   `public/`: The web server's document root. It contains the main `index.php` file, which acts as the front controller, and all the public assets (CSS, images, etc.).
*   `src/`: Contains the application's source code.
    *   `Controllers/`: Handles user requests and interacts with the models and views.
    *   `Core/`: Contains the core application logic, such as database connection and authentication.
    *   `Models/`: Manages the application's data and interacts with the database.
    *   `Views/`: Contains the application's presentation logic (HTML templates).
*   `vendor/`: Contains the project's dependencies, managed by Composer.
*   `config/`: Contains the application's configuration files.
*   `database/`: Contains the database schema and setup scripts.

## Technologies Used

*   **Backend:** PHP
*   **Frontend:** HTML, CSS, JavaScript
*   **Database:** MySQL
*   **Dependencies:**
    *   `endroid/qr-code`: A PHP library for generating QR codes.

## Setup and Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/yahb03/BellumQr.git
    ```
2.  **Install dependencies:**
    ```bash
    composer install
    ```
3.  **Create the database:**
    *   Create a new MySQL database.
    *   Import the `database/schema.sql` file to create the necessary tables.
4.  **Configure the database connection:**
    *   Copy the `config/database.php.example` file to `config/database.php`.
    *   Update the `config/database.php` file with your database credentials.
5.  **Run the application:**
    ```bash
    php -S localhost:8000 -t public
    ```

The application will be available at `http://localhost:8000`.
