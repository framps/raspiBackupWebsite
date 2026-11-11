<?php
/**
 * Router for PHP's built-in web server: serve real files, send everything else
 * to WordPress so pretty permalinks (/en/home/, /de/home-deutsch/) work.
 */
$root = rtrim( $_SERVER['DOCUMENT_ROOT'], '/' );
$path = urldecode( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );

if ( is_file( $root . $path ) ) {
	return false;
}
if ( is_dir( $root . $path ) && is_file( $root . rtrim( $path, '/' ) . '/index.php' ) && '/' !== $path ) {
	return false;
}

$_SERVER['SCRIPT_NAME']     = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . '/index.php';
$_SERVER['PHP_SELF']        = '/index.php';
chdir( $root );
require $root . '/index.php';
