# Use the official MySQL image from the Docker Hub
FROM mysql:latest

# Set environment variables for MySQL
ENV MYSQL_DATABASE=hotel
ENV MYSQL_USER=hotel
ENV MYSQL_PASSWORD=hotel
ENV MYSQL_RANDOM_ROOT_PASSWORD=yes

# Copy the initialization SQL script to the Docker image
COPY init.sql /docker-entrypoint-initdb.d/

# Expose the default MySQL port
EXPOSE 3306