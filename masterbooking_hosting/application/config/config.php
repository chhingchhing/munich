<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| If this is not set then CodeIgniter will guess the protocol, domain and
| path to your installation.
|
*/
$config['base_url']	= '';

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
$config['index_page'] = '';

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of 'AUTO' works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'AUTO'			Default - auto detects
| 'PATH_INFO'		Uses the PATH_INFO
| 'QUERY_STRING'	Uses the QUERY_STRING
| 'REQUEST_URI'		Uses the REQUEST_URI
| 'ORIG_PATH_INFO'	Uses the ORIG_PATH_INFO
|
*/
$config['uri_protocol']	= 'AUTO';

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/urls.html
*/

$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'dutch';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
*/
$config['charset'] = 'UTF-8';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = FALSE;


/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/core_classes.html
| http://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MU_';


/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify with a regular expression which characters are permitted
| within your URLs.  When someone tries to submit a URL with disallowed
| characters they will get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';


/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| By default CodeIgniter enables access to the $_GET array.  If for some
| reason you would like to disable it, set 'allow_get_array' to FALSE.
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string 'words' that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd'; // experimental not currently in use

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to
| determine what gets logged. Threshold options are:
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 0;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ folder. Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| system/cache/ folder.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class or the Session class you
| MUST set an encryption key.  See the user guide for info.
|
*/
$config['encryption_key'] = 'munichC@D!NG#TE';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_cookie_name'		= the name you want for the cookie
| 'sess_expiration'			= the number of SECONDS you want the session to last.
|   by default sessions last 7200 seconds (two hours).  Set to zero for no expiration.
| 'sess_expire_on_close'	= Whether to cause the session to expire automatically
|   when the browser window is closed
| 'sess_encrypt_cookie'		= Whether to encrypt the cookie
| 'sess_use_database'		= Whether to save the session data to a database
| 'sess_table_name'			= The name of the session database table
| 'sess_match_ip'			= Whether to match the user's IP address when reading the session data
| 'sess_match_useragent'	= Whether to match the User Agent when reading the session data
| 'sess_time_to_update'		= how many seconds between CI refreshing Session Information
|
*/
$config['sess_cookie_name']		= 'ci_session';
$config['sess_expiration']		= 7200;
$config['sess_expire_on_close']	= FALSE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= FALSE;
$config['sess_table_name']		= 'ci_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= 300;

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix' = Set a prefix if you need to avoid collisions
| 'cookie_domain' = Set to .your-domain.com for site-wide cookies
| 'cookie_path'   =  Typically will be a forward slash
| 'cookie_secure' =  Cookies will only be set if a secure HTTPS connection exists.
|
*/
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
$config['cookie_secure']	= FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
*/
$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or 'gmt'.  This pref tells the system whether to use
| your server's local time as the master 'now' reference, or convert it to
| GMT.  See the 'date helper' page of the user guide for information
| regarding date handling.
|
*/
$config['time_reference'] = 'local';


/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
*/
$config['rewrite_short_tags'] = FALSE;


/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy IP
| addresses from which CodeIgniter should trust the HTTP_X_FORWARDED_FOR
| header in order to properly identify the visitor's IP address.
| Comma-delimited, e.g. '10.0.1.200,10.0.1.201'
|
*/
$config['proxy_ips'] = '';


/*
/------------------------------------------------------------------------
/ Country list
/------------------------------------------------------------------------
/ List all countries for select drop down
*/
$config['country_list'] = array(
	"AF"=>"Afghanistan",
	"AL"=>"Albania",
	"DZ"=>"Algeria",
	"AD"=>"Andorra",
	"AO"=>"Angola",
	"AI"=>"Anguilla",
	"AQ"=>"Antarctica",
	"AG"=>"Antigua and Barbuda",
	"AR"=>"Argentina",
	"AM"=>"Armenia",
	"AW"=>"Aruba",
	"AU"=>"Australia",
	"AT"=>"Austria",
	"AZ"=>"Azerbaijan",
	"BS"=>"Bahamas",
	"BH"=>"Bahrain",
	"BD"=>"Bangladesh",
	"BB"=>"Barbados",
	"BY"=>"Belarus",
	"BE"=>"Belgium",
	"BZ"=>"Belize",
	"BJ"=>"Benin",
	"BM"=>"Bermuda",
	"BT"=>"Bhutan",
	"BO"=>"Bolivia",
	"BA"=>"Bosnia and Herzegovina",
	"BW"=>"Botswana",
	"BR"=>"Brazil",
	"IO"=>"British Indian Ocean",
	"BN"=>"Brunei",
	"BG"=>"Bulgaria",
	"BF"=>"Burkina Faso",
	"BI"=>"Burundi",
	"KH"=>"Cambodia",
	"CM"=>"Cameroon",
	"CA"=>"Canada",
	"CV"=>"Cape Verde",
	"KY"=>"Cayman Islands",
	"CF"=>"Central African Republic",
	"TD"=>"Chad",
	"CL"=>"Chile",
	"CN"=>"China",
	"CX"=>"Christmas Island",
	"CC"=>"Cocos (Keeling) Islands",
	"CO"=>"Colombia",
	"KM"=>"Comoros",
	"CD"=>"Congo, Democratic Republic of the",
	"CG"=>"Congo, Republic of the",
	"CK"=>"Cook Islands",
	"CR"=>"Costa Rica",
	"HR"=>"Croatia",
	"CY"=>"Cyprus",
	"CZ"=>"Czech Republic",
	"DK"=>"Denmark",
	"DJ"=>"Djibouti",
	"DM"=>"Dominica",
	"DO"=>"Dominican Republic",
	"TL"=>"East Timor",
	"EC"=>"Ecuador",
	"EG"=>"Egypt",
	"SV"=>"El Salvador",
	"GQ"=>"Equatorial Guinea",
	"ER"=>"Eritrea",
	"EE"=>"Estonia",
	"ET"=>"Ethiopia",
	"FK"=>"Falkland Islands (Malvinas)",
	"FO"=>"Faroe Islands",
	"FJ"=>"Fiji",
	"FI"=>"Finland",
	"FR"=>"France",
	"GF"=>"French Guiana",
	"PF"=>"French Polynesia",
	"GA"=>"Gabon",
	"GM"=>"Gambia",
	"GE"=>"Georgia",
	"DE"=>"Germany",
	"GH"=>"Ghana",
	"GI"=>"Gibraltar",
	"GR"=>"Greece",
	"GL"=>"Greenland",
	"GD"=>"Grenada",
	"GP"=>"Guadeloupe",
	"GT"=>"Guatemala",
	"GN"=>"Guinea",
	"GW"=>"Guinea-Bissau",
	"GY"=>"Guyana",
	"HT"=>"Haiti",
	"HN"=>"Honduras",
	"HK"=>"Hong Kong",
	"HU"=>"Hungary",
	"IS"=>"Iceland",
	"IN"=>"India",
	"ID"=>"Indonesia",
	"IE"=>"Ireland",
	"IL"=>"Israel",
	"IT"=>"Italy",
	"CI"=>"Ivory Coast (C&ocirc;te d\'Ivoire)",
	"JM"=>"Jamaica",
	"JP"=>"Japan",
	"JO"=>"Jordan",
	"KZ"=>"Kazakhstan",
	"KE"=>"Kenya",
	"KI"=>"Kiribati",
	"KR"=>"Korea, South",
	"KW"=>"Kuwait",
	"KG"=>"Kyrgyzstan",
	"LA"=>"Laos",
	"LV"=>"Latvia",
	"LB"=>"Lebanon",
	"LS"=>"Lesotho",
	"LI"=>"Liechtenstein",
	"LT"=>"Lithuania",
	"LU"=>"Luxembourg",
	"MO"=>"Macau",
	"MK"=>"Macedonia, Republic of",
	"MG"=>"Madagascar",
	"MW"=>"Malawi",
	"MY"=>"Malaysia",
	"MV"=>"Maldives",
	"ML"=>"Mali",
	"MT"=>"Malta",
	"MH"=>"Marshall Islands",
	"MQ"=>"Martinique",
	"MR"=>"Mauritania",
	"MU"=>"Mauritius",
	"YT"=>"Mayotte",
	"MX"=>"Mexico",
	"FM"=>"Micronesia",
	"MD"=>"Moldova",
	"MC"=>"Monaco",
	"MN"=>"Mongolia",
	"ME"=>"Montenegro",
	"MS"=>"Montserrat",
	"MA"=>"Morocco",
	"MZ"=>"Mozambique",
	"NA"=>"Namibia",
	"NR"=>"Nauru",
	"NP"=>"Nepal",
	"NL"=>"Netherlands",
	"AN"=>"Netherlands Antilles",
	"NC"=>"New Caledonia",
	"NZ"=>"New Zealand",
	"NI"=>"Nicaragua",
	"NE"=>"Niger",
	"NG"=>"Nigeria",
	"NU"=>"Niue",
	"NF"=>"Norfolk Island",
	"NO"=>"Norway",
	"OM"=>"Oman",
	"PK"=>"Pakistan",
	"PS"=>"Palestinian Territory",
	"PA"=>"Panama",
	"PG"=>"Papua New Guinea",
	"PY"=>"Paraguay",
	"PE"=>"Peru",
	"PH"=>"Philippines",
	"PN"=>"Pitcairn Island",
	"PL"=>"Poland",
	"PT"=>"Portugal",
	"QA"=>"Qatar",
	"RE"=>"R&eacute;union",
	"RO"=>"Romania",
	"RU"=>"Russia",
	"RW"=>"Rwanda",
	"SH"=>"Saint Helena",
	"KN"=>"Saint Kitts and Nevis",
	"LC"=>"Saint Lucia",
	"PM"=>"Saint Pierre and Miquelon",
	"VC"=>"Saint Vincent and the Grenadines",
	"WS"=>"Samoa",
	"SM"=>"San Marino",
	"ST"=>"S&atilde;o Tome and Principe",
	"SA"=>"Saudi Arabia",
	"SN"=>"Senegal",
	"RS"=>"Serbia",
	"CS"=>"Serbia and Montenegro",
	"SC"=>"Seychelles",
	"SL"=>"Sierra Leon",
	"SG"=>"Singapore",
	"SK"=>"Slovakia",
	"SI"=>"Slovenia",
	"SB"=>"Solomon Islands",
	"SO"=>"Somalia",
	"ZA"=>"South Africa",
	"GS"=>"South Georgia and the South Sandwich Islands",
	"ES"=>"Spain",
	"LK"=>"Sri Lanka",
	"SR"=>"Suriname",
	"SJ"=>"Svalbard and Jan Mayen",
	"SZ"=>"Swaziland",
	"SE"=>"Sweden",
	"CH"=>"Switzerland",
	"TW"=>"Taiwan",
	"TJ"=>"Tajikistan",
	"TZ"=>"Tanzania",
	"TH"=>"Thailand",
	"TG"=>"Togo",
	"TK"=>"Tokelau",
	"TO"=>"Tonga",
	"TT"=>"Trinidad and Tobago",
	"TN"=>"Tunisia",
	"TR"=>"Turkey",
	"TM"=>"Turkmenistan",
	"TC"=>"Turks and Caicos Islands",
	"TV"=>"Tuvalu",
	"UG"=>"Uganda",
	"UA"=>"Ukraine",
	"AE"=>"United Arab Emirates",
	"GB"=>"United Kingdom",
	"US"=>"United States",
	"UM"=>"United States Minor Outlying Islands",
	"UY"=>"Uruguay",
	"UZ"=>"Uzbekistan",
	"VU"=>"Vanuatu",
	"VA"=>"Vatican City",
	"VE"=>"Venezuela",
	"VN"=>"Vietnam",
	"VG"=>"Virgin Islands, British",
	"WF"=>"Wallis and Futuna",
	"EH"=>"Western Sahara",
	"YE"=>"Yemen",
	"ZM"=>"Zambia",
	"ZW"=>"Zimbabwe"
);

/* End of file config.php */
/* Location: ./application/config/config.php */