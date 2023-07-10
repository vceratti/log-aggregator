CREATE DATABASE IF NOT EXISTS log_storage;
CREATE DATABASE IF NOT EXISTS log_storage_test;

# create root user and grant rights
GRANT ALL PRIVILEGES ON *.* TO 'user'@'%';
