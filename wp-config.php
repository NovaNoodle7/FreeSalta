<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'freesalta_wp');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '@Bjr7&EDG}m0$jo%7FCO3S2bAVD#yW|~< w1%py<v],:%m`2E&QZP.N[r4:LTQl{');
define('SECURE_AUTH_KEY', 'vm<W}/i/25x7(?J}l=gVk&gB9T}]_/$-XCbc9KPgjb-H68K<s@`dz *fMTqi+|zu');
define('LOGGED_IN_KEY', ';b%.yg60%OeMKA%X*gd_7^EGn{y/<g643hLMZP[NS-3?sT-D,w/ts(HmR?y#uX]D');
define('NONCE_KEY', 'R%;oUe$:iR}g7>_AR0nM,%I=D=ef%g+.1?[JC ge6cHGSm87(5;Jk7o4-+8}!D@-');
define('AUTH_SALT', 'iEApRk~UIp4Hiorr>St.HM*iLP3[EGN|~f/-Y!+mS|rCeNgxo6BSC#D xfz^w=}`');
define('SECURE_AUTH_SALT', '>R&])pR629PnhTb6Y9[LgQI^TD=$Ivt,6[$:1fRuZHFaQ$sNK4J@VV=Qf0jd#T[T');
define('LOGGED_IN_SALT', '`[sl$As)oYI6EXSzSTJ$SztY,Nu^5)ol)3LsQL6^IOB,`nc,6A]KUYB^Frpvhawu');
define('NONCE_SALT', '^E)*ED`<M-7/Tk8&p)ANzE].2I?Elg^mwmHs%|U5q~btkeV/gST&?J]O@i8mtJ$-');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

