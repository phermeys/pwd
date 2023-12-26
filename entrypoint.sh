#!/bin/bash

# Start MySQL service
/etc/init.d/mariadb start

# Start Apache in the foreground
apache2ctl -D FOREGROUND &

# Keep the container running
# tail -f /dev/null
# by backing up the database every hour lol

while true
do
    # Run mysqldump command in the background
    mysqldump -u root pwdgen > /opt/sqlback/pwdgen-hash.sql &
    # touch /opt/sqlback/hello
    # Sleep for 1 hour (3600 seconds)
    sleep 3600
done
