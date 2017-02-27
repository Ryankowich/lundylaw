<?php
//////////////////////////////////////////Check Capch Function Start
function CapchaCheck()
{
	
    $captcha;
    if(isset($_REQUEST['g-recaptcha-response']))
    {
        $captcha=$_REQUEST['g-recaptcha-response'];
    }
    if(!$captcha)
    {
        return false;
    }
    $secreatKey="6LcvBgQTAAAAAI80xcg_QsMWBhVik-GrwxO61MTR";
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secreatKey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
    //var_dump($response);
    if($response.success==false)
    {
        return false;
    }
    else
    {
        return true;
    }
}
//////////////////////////////////////////Check ReCaptcha Function End

if(CapchaCheck())
{
    echo 1;
}
else
{
    echo 0;
}
?>