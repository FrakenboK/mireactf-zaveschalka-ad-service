#!/bin/bash
cd /var/www/html

export SECRET=$(php -r 'echo md5(random_bytes(32));')

/usr/bin/supervisord -c /etc/supervisor/supervisord.conf