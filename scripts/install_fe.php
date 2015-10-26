<?php
	
	echo "Inicio de la instalacion: \n";

	try {
		exec("unzip web_FE.zip");
	} catch (Exception $e) {
		echo "ERROR: "+$e;
		exit();
	}

	$apache_files_path = "/var/www/html/";
	$apache_js_files_path = "/var/www/html/js";
	$apache_css_files_path = "/var/www/html/css";

	try {
		echo "Moving files to ".$apache_files_path;

		exec("mv -r js/* "+$apache_js_files_path);
		exec("mv -r css/* "+$apache_css_files_path);
		exec("mv -r view/*.html "+$apache_files_path);

	} catch (Exception $e) {
		echo $e;
		exit;
	}

	try {
		echo "Changing permissions of the directory \n";
		
		exec("chmod 644 /var/www/html/js/*");
		exec("chmod 644 /var/www/html/css/*");
		exec("chmod 644 /var/www/html/*");

	} catch (Exception $e) {
		echo $e;
		exit;
	}
?>
	