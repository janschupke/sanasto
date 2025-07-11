# Sanasto

> **Legacy Project – Not Maintained or Functional**
>
> This repository is provided for historical reference only. Sanasto is a legacy vocabulary-learning web application. It is **not intended for further development or production use** and is not functional out of the box.

---

## Overview

Sanasto was a vocabulary-learning tool that allowed users to create their own database of languages, words, and translations. The system could generate randomized tests to help users memorize vocabulary. This project is no longer maintained, and many features may be incomplete or broken.

---

## Table of Contents
- [Overview](#overview)
- [Prerequisites](#prerequisites)
- [Installation (Legacy)](#installation-legacy)
- [Running the Application](#running-the-application)
- [Backup and Data Restoration](#backup-and-data-restoration)
- [Disclaimer](#disclaimer)

---

## Prerequisites

Sanasto was designed to run on the following stack:
- Apache Server
- Mailserver / ssmtp
- PHP (with PDO)
- PostgreSQL
- Cron
- SSH
- Git
- Less compiler
- npm, bower

---

## Installation (Legacy)

> **Warning:** These instructions are for archival purposes only. The application is not expected to run as described.

### 1. Dependency Installation
```sh
apt-get install -y apache2 ssmtp php5 php5-pgsql postgresql cron ssh git curl
# curl -sL https://deb.nodesource.com/setup | bash -
apt-get install -y nodejs
npm install -g less
npm install -g bower
```

### 2. PostgreSQL Configuration
- Edit `/etc/postgresql/9.x/main/pg_hba.conf` to use `md5` authentication.
- Set the postgres password:
```sh
su postgres
psql
alter user postgres password 'postgres';
```
- Restart PostgreSQL:
```sh
service postgresql restart
```

### 3. Mailing Configuration
```sh
CONF_FILE=/etc/ssmtp/ssmtp.conf
touch $CONF_FILE
echo "mailhub=smtp.internet.starnet.cz" >> $CONF_FILE
echo "hostname=sanasto.eu" >> $CONF_FILE
echo "FromLineOverride=YES" >> $CONF_FILE
```

### 4. User Configuration
```sh
adduser sanasto
# Set password and continue as this user
```

### 5. Clone the Repository
```sh
su sanasto
cd ~/public_html
git clone <repo-url>
# Move files as needed
```

### 6. Create Virtual Host
- Configure Apache for development and production as needed.
- Add `dev-sanasto` and `sanasto.eu` to `/etc/hosts` for local development.

### 7. Install Frontend Dependencies
```sh
sudo ln -s /usr/bin/nodejs /usr/bin/node # if needed
rm -rf node_modules vendor/bower
sudo npm install
bower install
cd scripts/install
sh styles.sh
```

### 8. Install Database Data
```sh
cd scripts/sql
psql -U postgres
\i install.sql
# To restore data:
\i restore
```

### 9. Fix Permissions
```sh
sudo usermod -a -G www-data postgres
cd <app_folder>
mkdir -p files/{backup,archive}
sudo chgrp -R www-data files && \
chmod -R 770 docs files resources scripts && \
chmod -R 660 docs/* && \
chmod -R 775 app vendor node_modules
# Change app/* vendor/* node_modules/* files to 644
```

### 10. Security Checks
- Ensure `/files`, `/docs`, `/resources`, `/scripts` are not web-accessible.
- Ensure `/app/config` sources cannot be read from the browser.

---

## Running the Application

> **Note:** The application is not functional and is not expected to run successfully.

- Several pre-made accounts were included for testing (now removed/sanitized).
- Some accounts are reserved and cannot be registered or logged into.

---

## Backup and Data Restoration

- To backup:
  - Run `/scripts/operation/dataBackup.sh`
- To restore:
  - In PostgreSQL: `\i scripts/sql/restore.sql`

---

## Disclaimer

This project is provided as-is for reference and archival purposes. **It is not maintained, not secure, and not intended for use in any environment.**

All sensitive information and credentials have been replaced with placeholders.
