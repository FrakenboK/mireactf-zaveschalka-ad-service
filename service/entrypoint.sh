#!/bin/bash
cd /app

mkdir users
mkdir wills

export SECRET=$(php -r 'echo md5(random_bytes(32));')

php -S 0.0.0.0:80
