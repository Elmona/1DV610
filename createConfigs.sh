#!/bin/bash

MYSQL_USERNAME=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 12 | head -n 1)
MYSQL_PASSWORD=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 15 | head -n 1)
ROOT=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 18 | head -n 1)
ROOT_PASSWORD=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 20 | head -n 1)
PEPPER=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 20 | head -n 1)
DATABASE=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 10 | head -n 1)

cat > ./web/Config.php <<EOF
<?php

\$_ENV['display_errors'] = 'On';
\$_ENV['timezone'] = 'Europe/Stockholm';
\$_ENV['pepper'] = '$PEPPER';

class Config {
    public \$host = 'mysql';
    public \$user = '$MYSQL_USERNAME';
    public \$password = '$MYSQL_PASSWORD';
    public \$database = '$DATABASE';
    public \$port = '3306';
}
EOF

cat > .env <<EOF
#!/usr/bin/env bash

# Nginx
NGINX_HOST=localhost

# PHP
PHP_VERSION=latest

# MySQL
MYSQL_VERSION=5.7.22
MYSQL_HOST=mysql
MYSQL_DATABASE=$DATABASE
MYSQL_ROOT_USER=$ROOT
MYSQL_ROOT_PASSWORD=$ROOT_PASSWORD
MYSQL_USER=$MYSQL_USERNAME
MYSQL_PASSWORD=$MYSQL_PASSWORD
EOF

echo "Created config files with random credentials."
echo "Start application with: docker-compose up"