#!/bin/bash

cp -rp ../web_portal_FE/view/* /var/www/html/
cp -rp ../web_portal_FE/js/* /var/www/html/js/
cp -rp ../web_portal_FE/img/* /var/www/html/img/
cp -rp ../web_portal_FE/icons/* /var/www/html/icons/
cp -rp ../web_portal_FE/icons/* /var/www/html/icons/
cp -rp ../web_portal_FE/css/* /var/www/html/css/

chmod -R 655 /var/www/html/

echo Dummy installation finished
exit

