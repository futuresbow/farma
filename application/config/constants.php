<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);


/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// custom
defined('PASSWORD_SALT')      OR define('PASSWORD_SALT', "aZhj!76"); // highest automatically-assigned error code


defined('JELLEMZO_EGESZ')      OR define('JELLEMZO_EGESZ', 0); 
defined('JELLEMZO_LEBEGO')      OR define('JELLEMZO_LEBEGO', 1); 
defined('JELLEMZO_STRING')      OR define('JELLEMZO_STRING', 2); 
defined('JELLEMZO_TEXT')      OR define('JELLEMZO_TEXT', 3); 

defined('JOG_SUPERADMIN')      OR define('JOG_SUPERADMIN', 32); 	// legmagasabb 	rang: x00100000
defined('JOG_ADMIN')      OR define('JOG_ADMIN', 16); 			//             		rang: x00010000
defined('JOG_BOSS')      OR define('JOG_BOSS', 8); 			//             		rang: x00001000
defined('JOG_MANAGER')      OR define('JOG_MANAGER', 4); 			//             	rang: x00000100
defined('JOG_EDITOR2')      OR define('JOG_EDITOR2', 2); 			//             	rang: x00000010
defined('JOG_EDITOR1')      OR define('JOG_EDITOR1', 1); 			//             	rang: x00000001
defined('JOG_NINCS')      OR define('JOG_NINCS', 0); 			//             	rang: x00000001
defined('JOG_LISTA')      OR define('JOG_LISTA', "0:Nincs admin jog,32:Szuperadmin,16:Admin,8:Főnök,4:Menedzser,2:Szerkesztő 2,1:Szerkesztő 1"); 			//             rang: x00011111

defined('JOGKOR_MINDENKI') OR define('JOGKOR_MINDENKI', 63);
defined('JOGKOR_FONOKIG_MINDENKI') OR define('JOGKOR_FONOKIG_MINDENKI', 17);
defined('JOGKOR_MANAGER') OR define('JOGKOR_MANAGERIG_MINDENKI', 7);
defined('JOGKOR_SZERKESZTOK') OR define('JOGKOR_SZERKESZTOK', 3);

defined('TEMAMAPPA') OR define('TEMAMAPPA', 'temak');
defined('SZAMLAMAPPA') OR define('SZAMLAMAPPA', FCPATH.'data/');


// termékcimke ID-k
defined('AKCIOSTERMEKCIMKE_ID') OR define('AKCIOSTERMEKCIMKE_ID', 1);
defined('KIEMELTTERMEKCIMKE_ID') OR define('KIEMELTTERMEKCIMKE_ID', 3);




