<?php
// meta fields
$phone = get_post_meta( get_the_ID(), '_wpp_phone', true );
$phone = intval($phone);

$message = get_post_meta( get_the_ID(), '_wpp_message', true );
$message = wpp_jlh_encodeURI($message);

// Fix Api Whatsapp on Desktops
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
// check if is a mobile
if ($iphone || $android || $palmpre || $ipod || $berry == true)
{
  header('Location: https://api.whatsapp.com/send?phone='. $phone .'&text='.$message);
  //OR
  echo "<script>window.location='https://api.whatsapp.com/send?phone='. $phone .'&text=".$message ."</script>";
}
// all others
else {
  header('Location: https://api.whatsapp.com/send?phone='. $phone .'&text='.$message);
  //OR
  echo "<script>window.location='https://api.whatsapp.com/send?phone='. $phone .'&text=".$message ."</script>";
}
	?>