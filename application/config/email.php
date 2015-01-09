<?php

$config['mailpath'] = '/usr/sbin/sendmail';
$config['crlf'] = '\n';      //"\r\n" or "\n" or "\r", Newline character. (Use "\r\n" to comply with RFC 822).
$config['mailtype'] = 'html';

$config['protocol'] = 'mail'; //mail, smtp, mail
$config['charset']  = 'utf-8';
$config['wordwrap'] = false;
$config['newline'] = '\r\n';   //"\r\n" or "\n" or "\r", Newline character. (Use "\r\n" to comply with RFC 822).

/*$config['protocol'] = 'smtp';
$config['smtp_host'] = '';
$config['smtp_user'] = '';
$config['smtp_pass'] = '';
$config['smtp_port'] = '25';   //25 465
$config['smtp_timeout'] = '5';*/

?>
