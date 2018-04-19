<?php

//show step sections
$vars['wi_show_step'] = 4;

//include navigation css styler
include ('common.php');

//submit button or not
$vars['form_button'] = 1;

//flow control
$next = true;

if (isset($_POST['mysql_submit'])) {

    //success control
    $results4 = true;

    //------validate form and create vars-------------------------------
    if ($next) {
        //form fields array
        $form = array(
            'database_server',
            'database_name',
            'database_username',
            'database_password');

        //create vars and check them
        foreach ($form as $key) {
            $$key = $_POST[$key];

            $vars[$key] = $_POST[$key]; //to refil form

            //do we have a value
            if ($_POST[$key] == '') {
                $vars['wi_notice_error'] = 1;
                $vars['notice'] = 'Fill in required fields';
                //halt
                $next = false;
            }
        }
    }

    //------test database connection-------------------------------
    if ($next) {

        $dbase = @mysql_connect($database_server, $database_username, $database_password, true);
        @mysql_select_db($database_name);
        
        //store connection in session
        $_SESSION['database_name'] = $database_name;
        $_SESSION['database_username'] = $database_username;
        $_SESSION['database_password'] = $database_password;
        $_SESSION['database_server'] = $database_server;

        //check if connected ok
        if (@mysql_error() || !$dbase) {
            $vars['wi_notice_error'] = 1;
            $vars['notice'] = 'Error connecting to database<br />' . @mysql_error();
            $next = false;
        }

        //check if restore file exist
        if (!is_file('payload/database.sql')) {
            $vars['wi_notice_error'] = 1;
            $vars['notice'] .= '<br/>The database file could not be found in /payload folder';
            $next = false;
        }
    }

    //------restore database-----------------------------------------
    if ($next) {
        //_______loadup mysql file_________
        $mysql_file = 'payload/database.sql';
        $file_content = file($mysql_file);
        $query = "";
        $error_count = 0;
        foreach ($file_content as $sql_line) {
            if (trim($sql_line) != "" && strpos($sql_line, "--") === false) {
                $query .= $sql_line;
                if (preg_match("/;\s*$/", $sql_line)) {
                    @mysql_query($query);
                    if (@mysql_error()) {
                        $error_count++;
                        $mysql_error .= @mysql_error() . '<br />';
                    }
                    $query = "";
                }
            }
        }

        //check results
        if ($error_count > 0) {
            $vars['wi_notice_error'] = 1;
            $vars['notice'] .= '<br/>a MySQL error has occurred. The database could not be populated.';
            $next = false;
        }

    }

    //------create the new database php file-------------------------------
    if ($next) {

        $filedata = '<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the \'Database Connection\'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
*/

$active_group = \'default\';
$active_record = TRUE;

$db[\'default\'][\'hostname\'] = \'' . $database_server . '\';
$db[\'default\'][\'username\'] = \'' . $database_username . '\';
$db[\'default\'][\'password\'] = \'' . $database_password . '\';
$db[\'default\'][\'database\'] = \'' . $database_name . '\';
$db[\'default\'][\'dbdriver\'] = \'mysql\';
$db[\'default\'][\'dbprefix\'] = \'\';
$db[\'default\'][\'pconnect\'] = TRUE;
$db[\'default\'][\'db_debug\'] = TRUE;
$db[\'default\'][\'cache_on\'] = FALSE;
$db[\'default\'][\'cachedir\'] = \'\';
$db[\'default\'][\'char_set\'] = \'utf8\';
$db[\'default\'][\'dbcollat\'] = \'utf8_general_ci\';
$db[\'default\'][\'swap_pre\'] = \'\';
$db[\'default\'][\'autoinit\'] = TRUE;
$db[\'default\'][\'stricton\'] = FALSE;


/* auto-generated by nextloop installer */
/* End of file database.php */
/* Location: ./application/config/database.php */';

    }

    //------save new /config/database.php file---------------------------------------
    if ($next) {
        $database_file = '../application/config/database.php';
        @unlink($database_file);
        $fh = @fopen($database_file, 'wb');
        $result = @fwrite($fh, $filedata);
        @fclose($fh);

        /** FINAL RESULTS */
        if ($result && is_file($database_file)) {
            $_SESSION["step4"] = 'passed';

            //show next step
            $vars['wi_show_step'] = 5;
            $step = 5;

            //reload common for chnage in nav menu
            include ('common.php');

        } else {
            $_SESSION["step4"] = 'failed';
        }

    }

}
