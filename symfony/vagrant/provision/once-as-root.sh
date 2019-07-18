#!/usr/bin/env bash

#== Import script args ==

timezone=$(echo "$1")

#== Bash helpers ==

function info {
  echo " "
  echo "--> $1"
  echo " "
}

#== Provision script ==

info "Provision-script user: `whoami`"

export DEBIAN_FRONTEND=noninteractive

info "Configure timezone"
timedatectl set-timezone ${timezone} --no-ask-password

info "Add the public GPG key"
wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -

info "Create a file with the postgresql repository address"
echo deb http://apt.postgresql.org/pub/repos/apt/ xenial-pgdg main | sudo tee /etc/apt/sources.list.d/postgresql.list

# info "Add php7.0 repository"
# add-apt-repository ppa:ondrej/php

info "Update OS software"
apt-get update
apt-get upgrade -y

info "Install additional software"
apt-get install -y php7.0 php7.0-curl php7.0-cli php7.0-intl php7.0-pgsql php7.0-gd php7.0-fpm php7.0-dom php7.0-mbstring php7.0-xml unzip nginx postgresql-9.6 postgresql-contrib-9.6

info "Create postgresql superuser"
sudo -u postgres psql -c "CREATE USER root WITH SUPERUSER CREATEDB ENCRYPTED PASSWORD '123'"
echo "Done!"

info "Chenge postgresql port"
sudo sed -i "s/port = 5433/port = 5432/" /etc/postgresql/9.6/main/postgresql.conf
echo "Done!"

info "Restart DB"
sudo /etc/init.d/postgresql restart
echo "Done!"

info "Configure PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf
echo "Done!"

info "Configure NGINX"
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
echo "Done!"

info "Enabling site configuration"
ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
echo "Done!"

info "Initailize databases for PostgreSQL"
sudo -u postgres psql -c "CREATE DATABASE yii2advanced OWNER root"
echo "Done!"

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
