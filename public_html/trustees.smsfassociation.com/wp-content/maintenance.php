<?php
$protocol = $_SERVER["SERVER_PROTOCOL"];
IF ("HTTP/1.1" != $protocol AND "HTTP/1.0" != $protocol ) :
  $protocol = "HTTP/1.0";
ENDIF;
header("$protocol 503 Service Unavailable", true, 503 );
header("Content-Type: text/html; charset=utf-8");
header("Retry-After: 600");
?>
<table style="height:100%;width:100%;background-color:lightblue;">
<tr style="height:100%;width:100%"><td style="height:100%;text-align:center;vertical-align:middle;font-size:24px;color:darkblue;">
<div style="width:40%;margin:0 auto;border:10px solid dodgerblue;background-color:#EDF3FD;">
<p>This site is undergoing scheduled maintenance.</p>
<p>We apologize for any inconvenience</p><p>and thank you for your patience.</p>
</div>
</td></tr>
</table>
