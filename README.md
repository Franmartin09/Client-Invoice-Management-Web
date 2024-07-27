# Client and Invoice Management Web Page

This repository contains a web application for managing clients and invoices, built using the CodeIgniter framework.

## Description

This PHP web application allows you to manage clients and invoices efficiently. It provides a user-friendly interface that use Bootstrap for adding, editing, and deleting client information and generating and managing invoices.

## Features

- **Client Management:**
  - Add, edit, and delete client information
  - View detailed client profiles

- **Invoice Management:**
  - Create, edit, and delete invoices
  - Generate PDF invoices
  - Track invoice statuses (paid, pending, overdue)

- **User Authentication:**
  - Secure login and registration system
  - Role-based access control

## Requirements

- Docker
- Docker Compose

## Installation

1. **Clone the repository:**
    ```sh
    git clone https://github.com/Franmartin09/Client-Invoice-Management-Web
    cd your-repository
    ```

2. **Set up environment variables:**
    - Copy `.env.example` to `.env`:
        ```sh
        cp .env.example .env
        ```
    - Update the `.env` file with your database and application details:
        ```sh
        APP_ENV = development
        database.default.hostname = mysql
        database.default.database = your_database_name
        database.default.username = your_database_user
        database.default.password = your_database_password
        database.default.DBDriver = MySQLi
        database.default.port     =  3306
        ```

3. **Build and run the containers:**
    ```sh
    docker-compose up --build
    ```

4. **Set up the database:**
    - Once the containers are up and running, you can access the MySQL container:
        ```sh
        docker-compose exec db mysql -u root -p
        ```
    - Create your database and import the `database.sql` file located in the `database` folder.

5. **Access the application:**
    Open your web browser and go to `http://localhost:8080`.

## Usage

1. **Login:**
    - Use the default admin credentials to log in (provided in the `seeders` file or database setup script).
    - Change the default password immediately after logging in.

2. **Manage Clients:**
    - Navigate to the "Clients" section.
    - Add new clients using the "Add Client" button.
    - Edit or delete existing clients using the action buttons next to each client.

3. **Manage Invoices:**
    - Navigate to the "Invoices" section.
    - Create new invoices using the "Create Invoice" button.
    - Edit or delete existing invoices using the action buttons next to each invoice.
    - Generate PDF invoices using the "Generate PDF" button.

## Docker Compose Setup

The `docker-compose.yml` file sets up the following services:

- **app:** Runs the PHP application using a web server.
- **db:** Runs a MySQL database server.

### docker-compose.yml Example

```yaml
version: '3.7'
name: clientes_y_facturas
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    ports:
      - "8080:80"
    volumes:
      - ./SRC/:/var/www/html
      - ./config-ng/site.conf:/etc/nginx/conf.d/site.conf
    depends_on:
      - db

  db:
    image: mysql:5.7
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: your_database_name
      MYSQL_USER: your_database_user
      MYSQL_PASSWORD: your_database_password
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any improvements or bug fixes.

## License

This project is licensed under the MIT License. See the [LICENSE](https://github.com/Franmartin09/Client-Invoice-Management-Web/blob/main/LICENSE) file for more details.

---
