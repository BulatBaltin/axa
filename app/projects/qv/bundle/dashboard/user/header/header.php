<?
$lingoQty = 3; //GetLingoQty();
$getLingoes = ''; // getLingoes
$noticeQty = 5;

$dev_hash = REQUEST::getParam('id');
$developer = User::findOneBy(['hash'=>$dev_hash]);
$app_user_avatarfile = $developer['avatarfile'];
