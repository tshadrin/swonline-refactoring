<?php
session_start( );
$player = $_SESSION['player'];
header( "Content-type: text/html; charset=win-1251" );
$text = $player['text'];
?>
<head>
    <meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
</head>
<body bgcolor="F6FAFF">
<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
<link rel="stylesheet" type="text/css" href="style.css">
<font id="iframetext">
<?php
if ( isset( $player['text'] ) ) {
    $text = $player['text'];
    print "{$text}";
}
?>
</font></body>