<?php

function clean_text($text)
{
    $text = trim($text);
    $text = ucwords($text);
    return $text;
}

function get_detour_text($id)
{
    if($id == 0) return T_("Can't change day");
    if($id == 1) return T_("One day");
    if($id == 2) return T_("Two days");
    if($id == 3) return T_("3-5 days");
    if($id == 6) return T_("6-14 days");
    if($id == 14) return T_("14-30 days");
    if($id == 100) return T_("Anything is fine");
}

function get_motorcycle_type_name($id)
{
    if($id == MOTORCYCLE_TYPE_STREET) return T_("Street/sport");
    if($id == MOTORCYCLE_TYPE_ENDURO) return T_("Enduro");
    if($id == MOTORCYCLE_TYPE_CHOPPER) return T_("Chopper/cruiser");
    if($id == MOTORCYCLE_TYPE_MOTOCROSS) return T_("Motocross/dirt bike");
    if($id == MOTORCYCLE_TYPE_SCOOTER) return T_("Scooter");
}

function age($date)
{
    if($date != '')
        return (round( (time()-strtotime($date))/(3600*24*360) ) - 1).' '.T_("years old");

    return '';
}

function setupPhpGettext()
{
    //if (!function_exists('_gettext')) {
        require_once(APPPATH.'libraries/phpgettext/gettext.inc');
    //}

    $obj =& get_instance();
    //$obj->lang->switch_to('polish');
    $obj->config->set_item('language','polish');

    T_setlocale(LC_MESSAGES, 'pl_PL');
    T_bindtextdomain('lang', APPPATH.'language/locales');
    T_bind_textdomain_codeset('lang', 'UTF-8');
    T_textdomain('lang');
    locale_emulation();
}

setupPhpGettext();

function sendHtmlEmail($email, $subject, $message, $email_from = '', $name_form ='', $email_from_real = '', $name_from_real = '')
{
    $tobj =& get_instance();
    $tobj->load->library('email');
    $tobj->load->config('email');

    $tobj->email->clear();

    $config['mailtype'] = 'html';
    $tobj->email->initialize($config);

    if($email_from_real != '' && $name_from_real != '')
    {
        $tobj->email->from($email_from_real, $name_from_real);
    }
    if($email_from != '' && $name_form != '')
    {
        $tobj->email->from('kamil.rudnicki@gmail.com', 'Kamil R.');
        $tobj->email->reply_to($email_from, $name_form);
    }
    else
    {
        $tobj->email->from('kamil.rudnicki@gmail.com', 'Kamil R.');
    }

    $tobj->email->to($email);
    $tobj->email->subject($subject);
    $tobj->email->message($message);
    $tobj->email->send();
}

function translateDate($in)
{
    $obj =& get_instance();
    $obj->lang->load('calendar');
    $from = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
    $to   = array($obj->lang->line('cal_jan'), $obj->lang->line('cal_feb'), $obj->lang->line('cal_mar'), $obj->lang->line('cal_apr'), $obj->lang->line('cal_may'), $obj->lang->line('cal_jun'), $obj->lang->line('cal_jul'), $obj->lang->line('cal_aug'), $obj->lang->line('cal_sep'), $obj->lang->line('cal_oct'), $obj->lang->line('cal_nov'), $obj->lang->line('cal_dec'), $obj->lang->line('cal_mon'), $obj->lang->line('cal_tue'), $obj->lang->line('cal_wed'), $obj->lang->line('cal_thu'), $obj->lang->line('cal_fri'), $obj->lang->line('cal_sat'), $obj->lang->line('cal_sun'));
    //$to   = array("Sty", "Lut", "Mar", "Kwi", "Maj", "Cze", "Lip", "Sie", "Wrz", "Paź", "Lis", "Gru", "Pon", "Wto", "Sro", "Czw", "Pt", "Sob", "Nie");
    return str_replace($from, $to, $in);
}

function translateFullMonths($in)
{
    $obj =& get_instance();
    $obj->lang->load('calendar');
    $from = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $to   = array($obj->lang->line('cal_january'), $obj->lang->line('cal_february'), $obj->lang->line('cal_march'), $obj->lang->line('cal_april'), $obj->lang->line('cal_mayl'), $obj->lang->line('cal_june'), $obj->lang->line('cal_july'), $obj->lang->line('cal_august'), $obj->lang->line('cal_september'), $obj->lang->line('cal_october'), $obj->lang->line('cal_november'), $obj->lang->line('cal_december'));
    return str_replace($from, $to, $in);
}

function translateDateOfTheWeek($in)
{
    $obj =& get_instance();
    $obj->lang->load('calendar');
    $from = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $to   = array($obj->lang->line('cal_monday'), $obj->lang->line('cal_tuesday'), $obj->lang->line('cal_wednesday'), $obj->lang->line('cal_thursday'), $obj->lang->line('cal_friday'), $obj->lang->line('cal_saturday'), $obj->lang->line('cal_sunday'));
    return str_replace($from, $to, $in);
}