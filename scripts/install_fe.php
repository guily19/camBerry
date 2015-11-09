<?php

        echo "Inicio de la instalacion: \n";

        $apache_files_path = "/var/www/html/";

        try {
                echo "Creating js/css directories in /var/www/html \n";

                exec("sudo mkdir ".$apache_files_path."js");
                exec("sudo mkdir ".$apache_files_path."css");
                exec("sudo mkdir ".$apache_files_path."img");
                exec("sudo mkdir ".$apache_files_path."icons");

                echo "Coping files to ".$apache_files_path;

                exec("cp -r ../web_portal_FE/js/ ".$apache_files_path);
                exec("cp -r ../web_portal_FE/css/ ".$apache_files_path);
                exec("cp -r ../web_portal_FE/img/ ".$apache_files_path);
                exec("cp -r ../web_portal_FE/icons/ ".$apache_files_path);
                exec("cp ../web_portal_FE/view/index.php ".$apache_files_path);
                exec("cp ../web_portal_FE/view/main.php ".$apache_files_path);
                exec("cp ../web_portal_FE/view/register.html ".$apache_files_path);

                //exec("mv ".$apache_files_path."main.html ".$apache_files_path."index.html");

        } catch (Exception $e) {
                echo $e;
                exit;
        }

        try {
                echo "Changing permissions of the directory \n";

                exec("chmod 655 /var/www/html/js/*");
                exec("chmod 655 /var/www/html/css/*");
                exec("chmod 655 /var/www/html/img/*");
                exec("chmod 655 /var/www/html/icons/*");
                exec("chmod 655 /var/www/html/");

        } catch (Exception $e) {
                echo $e;
                exit;
        }
?>
