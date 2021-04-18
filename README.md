# Expense Management Exam
This is just a simple implementation of an Expense Management System. Although it's better to use Vue but due to lack of time I opt to use the conventional Blade syntax and JQuery

## System Requirements
Please make sure this is installed in your local machine

- Vagrant
- VirtualBox
- GIT
- Composer
- Mysql

## Create directory
Select a repository you want to deploy the application

```
mkdir ~/Desktop/exam-expense-management
cd ~/Desktop/exam-expense-management
```

## Clone repository

Clone the given repository into your local by running

```
git clone https://github.com/ramzdam/expense-management.git .
```

## Install dependency

Make sure composer is install in your dev machine

```bash
composer install
```

## Modify Host File and Project File
Edit your host file to support custom name

```shell
sudo vi /etc/hosts
```
Add the entry below in your host file then save

```shell
192.168.10.88   homestead.test
```
Duplicate `.env.example` and rename it to `.env`
```
mv ~/Desktop/exam-expense-management/.env.example ~/Desktop/exam-expense-management/.env
```
## Vagrant container
Create your vagrant instance by running vagrant up

```shell
vagrant up
```

Connect to your vagrant container

```shell
vagrant ssh
```

Make sure that nginx is running (although by default this should be running)
```
sudo service nginx start
```

## Migrate
Migrate the files database tables by running command below while still inside the vagrant box.
```
php artisan migrate
```
## Seed
We also need to run the db:seed to make sure the Role Table gets populated by default user role
```
php artisan db:seed
```
# Login Credential
```
Administrator: 
User: admin@admin.com
Password: admin

User: 
User: user@user.com
Password: user
```
## Database
To connect to your database below are the credential

```
Host: 192.168.10.88
Username: homestead
Password: secret
DB Name: homestead
```

## .env content
```
APP_NAME="Expense Management"
APP_ENV=local
APP_KEY=base64:T0C67MaXQi8yquDT/t/k+EXX0IoZlxacYSdAq45EOCY=
APP_DEBUG=true
APP_URL=http://homestead.test

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```
## Homestead.yaml content
```
ip: 192.168.10.88
memory: 2048
cpus: 2
provider: virtualbox
authorize: ~/.ssh/id_rsa.pub
keys:
    - ~/.ssh/id_rsa
folders:
    -
        map: "."
        to: /home/vagrant/code
        type: "nfs"
sites:
    -
        map: homestead.test
        to: /home/vagrant/code/public
databases:
    - homestead
features:
    -
        mariadb: false
    -
        ohmyzsh: false
    -
        webdriver: false
name: exam-expense-management
hostname: exam-expense-management
```
## License
[MIT](https://choosealicense.com/licenses/mit/)

### Developer
Madzmar Ullang  |  madzmar.ullang@gmail.com