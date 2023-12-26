# Use the official Apache PHP image as the base image
FROM php:apache

# Install MySQL client and server
RUN apt-get update && apt-get install -y default-mysql-client default-mysql-server && rm -rf /var/lib/apt/lists/*

# Install the MySQL extension for PHP
RUN docker-php-ext-install mysqli pdo_mysql

# Create a directory to store the SQL backup file
WORKDIR /sql_backup

# Copy the SQL backup file from the host to the container
COPY ./mysql/pwdgen-hash.sql .

# Set the MySQL root password
ENV MYSQL_ROOT_PASSWORD=
ENV MARIADB_ROOT_PASSWORD=

# Create and set the default database to 'pwdgen'
ENV MYSQL_DATABASE=pwdgen

# Specify the MySQL socket file location
ENV MYSQL_SOCKET=/run/mysqld/mysqld.sock

# Import the database during the build, set root password
RUN /etc/init.d/mariadb start && mysql -u root -e "CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE" && mysql -u root $MYSQL_DATABASE < ./pwdgen-hash.sql && mysqladmin -u root password ''

# Create a directory to store the website files
WORKDIR /var/www/html

# Copy the contents of the host's ./www directory to the container
COPY ./www/ .

# Set the working directory for the entrypoint script
WORKDIR /usr/local/bin

# Copy the entrypoint script into the container
COPY entrypoint.sh .

# Give execute permissions to the script
RUN chmod +x entrypoint.sh

# Set the entrypoint script as the entry point for the container
ENTRYPOINT ["entrypoint.sh"]

