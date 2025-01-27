### [![LibreTime](https://github.com/libretime/website/blob/main/static/img/logo-512px.png)](https://github.com/libretime/libretime)


### 1. Standard Lbiretime app Setup

This guide walk you though the steps required to install LibreTime on your system using docker.

# Before installing
Before installing LibreTime, you need to make sure that Docker is installed on your operating system and up-to-date.

Download
First, set the version you want to install:

    echo LIBRETIME_VERSION="4.2.0" > .env
Download the docker-compose files from the repository:


# Load LIBRETIME_VERSION variable
    source .env

    wget "https://raw.githubusercontent.com/libretime/libretime/$LIBRETIME_VERSION/docker-compose.yml"
    wget "https://raw.githubusercontent.com/libretime/libretime/$LIBRETIME_VERSION/docker/nginx.conf"
    wget https://raw.githubusercontent.com/libretime/libretime/$LIBRETIME_VERSION/docker/config.template.yml

Setup LibreTime
Once the files are downloaded, generate a set of random passwords for the different docker services used by LibreTime:

    echo "# Postgres
    POSTGRES_PASSWORD=$(openssl rand -hex 16)

    # RabbitMQ
    RABBITMQ_DEFAULT_PASS=$(openssl rand -hex 16)

    # Icecast
    ICECAST_SOURCE_PASSWORD=$(openssl rand -hex 16)
    ICECAST_ADMIN_PASSWORD=$(openssl rand -hex 16)
    ICECAST_RELAY_PASSWORD=$(openssl rand -hex 16)" >> .env

Generate a configuration file from the ./config.template.yml template with the previously generated passwords:
    bash -a -c "source .env; envsubst < config.template.yml > config.yml"

Next, run the following commands to setup the database:
    docker-compose run --rm api libretime-api migrate

Finally, start the services, and check that they're running using the following commands:
    docker-compose up -d
    docker-compose ps
    docker-compose logs -f

First login
Once the setup is completed, log in the interface (with the default user admin and password admin), and edit the project settings (go to Settings > General) to match your needs.


# Securing LibreTime
Once LibreTime is running, it's recommended to install a reverse proxy to setup SSL termination and secure your installation.

Install Apache using below link
    https://ubuntu.com/tutorials/install-and-configure-apache

# Apache
Paste the following configuration in /etc/apache2/sites-available/libretime.example.org.conf and be sure to replace:
•	libretime.example.org with your own station url,
•	localhost:8080 with the location of your LibreTime web server;

    /etc/apache2/sites-available/libretime.example.org.conf
    <VirtualHost *:80>
        ServerName libretime.example.org

        <Location />
            ProxyPass           http://localhost:8080/
            ProxyPassReverse    http://localhost:8080/
        </Location>
    </VirtualHost>

Enable the Apache2 proxy modules:
    sudo a2enmod proxy proxy_http

Enable the Apache2 vhost configuration:
    sudo a2ensite libretime.example.org

Restart Apache2:
    sudo systemctl restart apache2

Install SSL certificate by adding below lines in default-ssl.conf file
    SSLEngine on
    SSLCertificateFile      /home/ubuntu/tuneurl-demo.com_ssl_certificate.cer
    SSLCertificateKeyFile   /home/ubuntu/_.tuneurl-demo.com_private_key.key
    <Location />
            ProxyPass           http://localhost:8080/
            ProxyPassReverse    http://localhost:8080/
    </Location>

### 2. Libretime-TuneURL integration


[Libretime-TuneURL-integration](docs/Libretime-TuneURL-integration.pdf)