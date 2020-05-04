<?php

/*
@botsazicli
سورس تست شده توسط حسین 
دیباگ دیباگ‌ کانال ما @Alirezahm_ir
*/

// نیاز به کرونجاب 1 دقیقه ای

ini_set('display_errors', 0);
ini_set('memory_limit', -1);
ini_set('max_execution_time', 300);
 if(file_exists('codex.madeline') && file_exists('update-session/codex.madeline') && (time() - filectime('codex.madeline')) > 20){
 unlink('codex.madeline.lock');
 unlink('codex.madeline');
 unlink('madeline.phar');
 unlink('madeline.phar.version');
 unlink('madeline.php');
 unlink('MadelineProto.log');
 unlink('bot.lock');
 copy('update-session/codex.madeline', 'codex.madeline');
 }
 if(file_exists('codex.madeline') && file_exists('update-session/codex.madeline') && (filesize('codex.madeline')/1024) > 10240){
 unlink('codex.madeline.lock');
 unlink('codex.madeline');
 unlink('madeline.phar');
 unlink('madeline.phar.version');
 unlink('madeline.php');
 unlink('bot.lock');
 unlink('MadelineProto.log');
 copy('update-session/codex.madeline', 'codex.madeline');
 }
function closeConnection($message='@Alirezahm_ir Is Running ...'){
 if (php_sapi_name() === 'cli' || isset($GLOBALS['exited'])) {
  return;
 }
    @ob_end_clean();
    header('Connection: close');
    ignore_user_abort(true);
    ob_start();
    echo "$message";
    $size = ob_get_length();
    header("Content-Length: $size");
    header('Content-Type: text/html');
    ob_end_flush();
    flush();
    $GLOBALS['exited'] = true;
}
function shutdown_function($lock)
{
   try {
    $a = fsockopen((isset($_SERVER['HTTPS']) && @$_SERVER['HTTPS'] ? 'tls' : 'tcp').'://'.@$_SERVER['SERVER_NAME'], @$_SERVER['SERVER_PORT']);
    fwrite($a, @$_SERVER['REQUEST_METHOD'].' '.@$_SERVER['REQUEST_URI'].' '.@$_SERVER['SERVER_PROTOCOL']."\r\n".'Host: '.@$_SERVER['SERVER_NAME']."\r\n\r\n");
    flock($lock, LOCK_UN);
    fclose($lock);
} catch(Exception $v){}
}
if (!file_exists('bot.lock')) {
 touch('bot.lock');
}
$lock = fopen('bot.lock', 'r+');
$try = 1;
$locked = false;
while (!$locked) {
 $locked = flock($lock, LOCK_EX | LOCK_NB);
 if (!$locked) {
  closeConnection();
 if ($try++ >= 30) {
 exit;
 }
   sleep(1);
 }
}
if(!file_exists('data.json')){
 file_put_contents('data.json','{"autochat":{"on":"on"},"admins":{}}');
}
if(!is_dir('update-session')){
 mkdir('update-session');
}
if(!file_exists('madeline.php')){
 copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include_once 'madeline.php';
$settings = [];
$settings['logger']['logger'] = 0;
$settings['serialization']['serialization_interval'] = 1;
$settings['serialization']['cleanup_before_serialization'] = true;
$MadelineProto = new \danog\MadelineProto\API('codex.madeline', $settings);
$MadelineProto->start();
class EventHandler extends \danog\MadelineProto\EventHandler {
public function __construct($MadelineProto){
parent::__construct($MadelineProto);
}
public function onUpdateSomethingElse($update)
{
 yield $this->onUpdateNewMessage($update);
}
public function onUpdateNewChannelMessage($update)
{
 yield $this->onUpdateNewMessage($update);
}
public function onUpdateNewMessage($update){
 try {
 if(!file_exists('update-session/codex.madeline')){
   copy('codex.madeline', 'update-session/codex.madeline');
 }
 $userID = @$update['message']['from_id'];
 $msg = @$update['message']['message'];
 $msg_id = $update['message']['id'];
 $MadelineProto = $this;
 $me = yield $MadelineProto->get_self();
 $me_id = $me['id'];
 $info = yield $MadelineProto->get_info($update);
 $chatID = $info['bot_api_id'];
 $type2 = $info['type'];
 @$data = json_decode(file_get_contents("data.json"), true);
 $creator = 277826937; // ایدی عددی ران کننده ربات
 $admin = 277826937; // ایدی عددی ادمین اصلی
 if(file_exists('codex.madeline') && filesize('codex.madeline')/1024 > 6143){
   unlink('codex.madeline.lock');
   unlink('codex.madeline');
   copy('update-session/codex.madeline', 'codex.madeline');
   exit(file_get_contents('http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']));
   exit;
   exit;
 }
 if($userID != $me_id){
   if ($msg == 'شارژ' && $userID == $creator) {
  copy('update-session/codex.madeline', 'update-session/codex.madeline2');
  unlink('update-session/codex.madeline');
  copy('update-session/codex.madeline2', 'update-session/codex.madeline');
  unlink('update-session/codex.madeline2');
  yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '⚡️ ربات برای 30 روز دیگر شارژ شد']);
   }
   if((time() - filectime('update-session/codex.madeline')) > 2505600){
     if ($userID == $admin || isset($data['admins'][$userID])) {
    yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '❗️اخطار: مهلت استفاده شما از این ربات به اتمام رسیده❗️']);
    }
   } else {
 if($type2 == 'channel' || $userID == $admin || isset($data['admins'][$userID])) {
 if (strpos($msg, 't.me/joinchat/') !== false) {
  $a = explode('t.me/joinchat/', "$msg")[1];
  $b = explode("\n","$a")[0];
  try {
  yield $MadelineProto->channels->joinChannel(['channel' => "https://t.me/joinchat/$b"]);
  } catch(Exception $p){}
  catch(\danog\MadelineProto\RPCErrorException $p){}
 }
}

if (isset($update['message']['reply_markup']['rows'])) {
if($type2 == 'supergroup'){
foreach ($update['message']['reply_markup']['rows'] as $row) {
foreach ($row['buttons'] as $button) {
 yield $button->click();
   }
  }
 }
}

 if ($chatID == 777000) {
   @$a = str_replace(0,'۰',$msg);
   @$a = str_replace(1,'۱',$a);
   @$a = str_replace(2,'۲',$a);
   @$a = str_replace(3,'۳',$a);
   @$a = str_replace(4,'۴',$a);
   @$a = str_replace(5,'۵',$a);
   @$a = str_replace(6,'۶',$a);
   @$a = str_replace(7,'۷',$a);
   @$a = str_replace(8,'۸',$a);
   @$a = str_replace(9,'۹',$a);
   yield $MadelineProto->messages->sendMessage(['peer' => $admin, 'message' => "$a"]);
   yield $MadelineProto->messages->deleteHistory(['just_clear' => true, 'revoke' => true, 'peer' => $chatID, 'max_id' => $msg_id]);
 }

 // O * G * H * A * B

if ($userID == $admin) {
 if(preg_match("/^[#\!\/](addadmin) (.*)$/", $msg)){
 preg_match("/^[#\!\/](addadmin) (.*)$/", $msg, $msg1);
$id = $msg1[2];
if (!isset($data['admins'][$id])) {
$data['admins'][$id] = $id;
file_put_contents("data.json", json_encode($data));
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => 'ادمین شد کاربر توسط ✪ $first_name ✪']);
}else{
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => "این کاربر از قبل ادمین بود :/"]);
}
}
 if(preg_match("/^[\/\#\!]?(clean admins)$/i", $msg)){
$data['admins'] = [];
file_put_contents("data.json", json_encode($data));
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => "لیست ادمین خالی شد !"]);
}
 if(preg_match("/^[\/\#\!]?(adminlist)$/i", $msg)){
if(count($data['admins']) > 0){
$txxxt = "لیست ادمین ها :
";
$counter = 1;
foreach($data['admins'] as $k){
$txxxt .= "$counter: <code>$k</code>\n";
$counter++;
}
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => $txxxt, 'parse_mode' => 'html']);
}else{
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => "ادمینی وجود ندارد !"]);
  }
 }
}

 if ($userID == $admin || isset($data['admins'][$userID])){
 if($msg == 'بروز'){
yield $MadelineProto->messages->deleteHistory(['just_clear' => true, 'revoke' => true, 'peer' => $chatID, 'max_id' => $msg_id]);
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '♻️ ربات دوباره راه اندازی شد.']);
 // exit;
 yield $this->restart();
}

 if($msg == 'پاکسازی'){
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => 'لطفا کمی صبر کنید ...']);
   $all = yield $MadelineProto->get_dialogs();
   foreach($all as $peer){
   $type = yield $MadelineProto->get_info($peer);
   if($type['type'] == 'supergroup'){
   $info = yield $MadelineProto->channels->getChannels(['id' => [$peer]]);
   @$banned = $info['chats'][0]['banned_rights']['send_messages'];
   if ($banned == 1) {
 yield $MadelineProto->channels->leaveChannel(['channel' => $peer]);
  }
 }
}
  yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '✅ پاکسازی باموفقیت انجام شد.
♻️ گروه هایی که در آنها بن شده بودم حذف شدند.']);
}

 if($msg == 'انلاین' || $msg == 'تبچی' || $msg == '!ping' || $msg == '#ping' || $msg == 'ربات' || $msg == 'ping' || $msg == '/ping'){
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'reply_to_msg_id' => $msg_id, 'message' => "[تبچی آلفاتب هم اکنون انلاین میباشد!](tg://user?id=$userID)", 'parse_mode' => 'markdown']);
}

 if($msg == 'ورژن ربات'){
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'reply_to_msg_id' => $msg_id ,'message' => '**⚙️ نسخه سورس تبچی : 6.6**','parse_mode' => 'MarkDown']);
}

  if($msg == 'شناسه' || $msg == 'من' || $msg == 'ایدی' || $msg == 'مشخصات'){
 $name = $me['first_name'];
 $phone = '+'.$me['phone'];
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'reply_to_msg_id' => $msg_id ,'message' => "🔅 مشخصات من :
🥇 ادمین‌اصلی: [$admin](tg://user?id=$admin)
👤 نام: $name
#️⃣ ایدی‌عددی: `$me_id`
📞 شماره‌تلفن: `$phone`
",'parse_mode' => 'MarkDown']);
}

 if($msg == 'امار' || $msg == 'آمار' || $msg == 'stats'){
 $day = (2505600 - (time() - filectime('update-session/codex.madeline'))) / 60 / 60 / 24;
 $day = round($day, 0);
 $hour = (2505600 - (time() - filectime('update-session/codex.madeline'))) / 60 / 60;
 $hour = round($hour, 0);
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message'=>'لطفا کمی صبر کنید...','reply_to_msg_id' => $msg_id]);
 $mem_using = round((memory_get_usage()/1024)/1024, 0).'MB';
 $sat = $data['autochat']['on'];
 if($sat == 'on'){
 $sat = '✅';
 } else {
 $sat = '❌';
 }
 $mem_total = 'NotAccess!';
 $CpuCores = 'NotAccess!';
 try {
 if(strpos(@$_SERVER['SERVER_NAME'], '000webhost') === false){
if (strpos(PHP_OS, 'L') !== false || strpos(PHP_OS, 'l') !== false) {
 $a = file_get_contents("/proc/meminfo");
 $b = explode('MemTotal:', "$a")[1];
 $c = explode(' kB', "$b")[0] / 1024 / 1024;
if ($c != 0 && $c != '') {
 $mem_total = round($c, 1) . 'GB';
} else {
 $mem_total = 'NotAccess!';
}
} else {
 $mem_total = 'NotAccess!';
}
if (strpos(PHP_OS, 'L') !== false || strpos(PHP_OS, 'l') !== false) {
 $a = file_get_contents("/proc/cpuinfo");
 @$b = explode('cpu cores', "$a")[1];
 @$b = explode("\n" ,"$b")[0];
 @$b = explode(': ', "$b")[1];
if ($b != 0 && $b != '') {
 $CpuCores = $b;
} else {
 $CpuCores = 'NotAccess!';
}
} else {
 $CpuCores = 'NotAccess!';
}
}
} catch(Exception $f){}
$s = yield $MadelineProto->get_dialogs();
$m = json_encode($s, JSON_PRETTY_PRINT);
$supergps = count(explode('peerChannel',$m));
$pvs = count(explode('peerUser',$m));
$gps = count(explode('peerChat',$m));
$all = $gps+$supergps+$pvs;
yield $MadelineProto->messages->sendMessage(['peer' => $chatID,
 'message' => "🔅 Stats AlFaTaB :

🔅 امار کلی ربات》 : $all
•••••••••••••••••••••••••••••
🔅تعداد گروه ها + کانال ها》 : $supergps
•••••••••••••••••••••••••••••
🔅تعداد گروه های معمولی》 : $gps
•••••••••••••••••••••••••••••
🔅تعداد پیوی های ربات 》 : $pvs
•••••••••••••••••••••••••••••
🔅چت خودکار ربات 》 : $sat
•••••••••••••••••••••••••••••
🔅تاریخ انقضاء :
$day روز یا  Or $hour ساعت
•••••••••••••••••••••••••••••
🔅هسته های سی پی ویو》 : $CpuCores
•••••••••••••••••••••••••••••
🔋 MemTotal : $mem_total
•••••••••••••••••••••••••••••
♻️ رم در حال استفاده شده this ربات : $mem_using
•••••••••••••••••••••••••••••
🥇 CreatoR:
🔥 @Alirezahm_ir"]);
if ($supergps > 400 || $pvs > 1500){
yield $MadelineProto->messages->sendMessage(['peer' => $chatID,
 'message' => '⚠️ اخطار: به دلیل کم بودن منابع هاست تعداد گروه ها نباید بیشتر از 400 و تعداد پیوی هاهم نباید بیشتراز 1.5K باشد.
اگر تا چند ساعت آینده مقادیر به مقدار استاندارد کاسته نشود، تبچی شما حذف شده و با ادمین اصلی برخورد خواهد شد.']);
 }
}

 if($msg == 'help' || $msg == '/help' || $msg == 'Help' || $msg == 'راهنما'){
  yield $MadelineProto->messages->sendMessage([
    'peer' => $chatID,
    'message' => '🔅 راهنمای آلفاتب🔅

🔅 انلاین
👽 دریافت وضعیت ربات
•••••••••••••••••••••••••••••
🔅 امار
👽 دریافت آمار گروه ها و کاربران
•••••••••••••••••••••••••••••
🔅 افزودن  [ایدی کاربر]
👽 ادد کردن یڪ کاربر به همه گروه ها
•••••••••••••••••••••••••••••
🔅 افزودن مخاطبین  [ایدی عددی گروه]
👽ادد کردن همه ے افرادے که در پیوے هستن به یڪ گروه
•••••••••••••••••••••••••••••
🔅 فور همه  [ریپلایی]
👽 فروارد کردن پیام ریپلاے شده به همه گروه ها و کاربران
•••••••••••••••••••••••••••••
🔅 فور پیوی  [ریپلایی]
👽 فروارد کردن پیام ریپلاے شده به همه کاربران
•••••••••••••••••••••••••••••
🔅 فور گپ  [ریپلایی]
👽 فروارد کردن پیام ریپلاے شده به همه گروه ها
•••••••••••••••••••••••••••••
🔅 فور سوپر گپ  [ریپلایی]
👽فروارد کردن پیام ریپلاے شده به همه سوپرگروه ها
•••••••••••••••••••••••••••••
🔅ارسال همگانی به گروه ها
👽 s2gps 
مثال 
s2gps سلام
<strong>•••••••••••••••••••••••••••••</strong>
🔅ارسال همگانی به سوپرگروه ها
👽 s2sgps
مثال 
s2sgps سلام
<strong>•••••••••••••••••••••••••••••</strong>
🔅ارسال همگانی  به پیوی ها 
👽 s2pv
مثال 
s2pv سلام
<strong>•••••••••••••••••••••••••••••</strong>
🔅ارسال همگانی  به همه 
👽 s2all
مثال 
s2all سلام
<strong>•••••••••••••••••••••••••••••</strong>
🔅 فور  [ریپلایی],[تایم_فور]
👽 فعالسازے فروارد خودکار زماندار حداقل از 10دقیقه بالاتر تنظیم خواهد شد
•••••••••••••••••••••••••••••
🔅 پاکسازی تایم فور
👽 حذف فروارد خودکار زماندار
•••••••••••••••••••••••••••••
🔅 تنظیم یوزرنیم [یوزر]
👽 تنظیم نام کاربرے (آیدے)ربات
•••••••••••••••••••••••••••••
🔅 تنظیم اطلاعات  [نام] | [فامیل] | [بیوگرافی]
👽 تنظیم نام اسم ,فامیل و بیوگرافے ربات
•••••••••••••••••••••••••••••
🔅 جوین  [ایدی] or [لینک]
👽 عضویت در یڪ کانال یا گروه
•••••••••••••••••••••••••••••
🔅 ورژن ربات
👽 نمایش نسخه سورس تبچے شما
•••••••••••••••••••••••••••••
🔅 پاکسازی
👽 خروج از گروه هایے که مسدود کردند
•••••••••••••••••••••••••••••
🔅 مشخصات
👽 دریافت ایدی‌عددے ربات تبچی
•••••••••••••••••••••••••••••
🔅 پاکسازی کانال ها
👽خروج از همه ے کانال ها
•••••••••••••••••••••••••••••
🔅 پاکسازی گروه ها
👽خروج از همه ے گروه ها
•••••••••••••••••••••••••••••
🔅 تنظیم پروفایل  [لینک عکس]
👽 اپلود عکس پروفایل جدید
•••••••••••••••••••••••••••••
🔅 چت [on] or [off]
👽 فعال یا خاموش کردن چت خودکار (پیوی و گروه ها)

≈ ≈ ≈ ≈ ≈ ≈ ≈ ≈ ≈ ≈

🔅 این دستورات فقط براے ادمین اصلے قابل استفاده هستند :
/addadmin  [ایدی‌عددی]
👽 افزودن ادمین جدید
•••••••••••••••••••••••••••••
/deladmin  [ایدی‌عددی]
👽 حذف ادمین
•••••••••••••••••••••••••••••
/clean admins
👽 حذف همه ادمین ها
•••••••••••••••••••••••••••••
/adminlist
👽 لیست همه ادمین ها
🥇 CreatoR:
🔥 @Alirezahm_ir',
 'parse_mode' => 'markdown']);
}

 if($msg == 'فور همه' || $msg == 'فور همه'){
 if($type2 == 'supergroup'){
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'⛓ درحال فروارد ...']);
   $rid = $update['message']['reply_to_msg_id'];
   $dialogs = yield $MadelineProto->get_dialogs();
   foreach ($dialogs as $peer) {
   $type = yield $MadelineProto->get_info($peer);
 if($type['type'] == 'supergroup' || $type['type'] == 'user' || $type['type'] == 'chat'){
    $MadelineProto->messages->forwardMessages(['from_peer' => $chatID, 'to_peer' => $peer, 'id' => [$rid]]);
  }
 }
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'فروارد همگانی با موفقیت به همه ارسال شد 👌🏻']);
   }else{
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.']);
}
}

  if($msg == 'فور پیوی' || $msg == 'فور پیوی'){
  if($type2 == 'supergroup'){
  yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'⛓ درحال فروارد ...']);
   $rid = $update['message']['reply_to_msg_id'];
   $dialogs = yield $MadelineProto->get_dialogs();
   foreach ($dialogs as $peer) {
   $type = yield $MadelineProto->get_info($peer);
   if($type['type'] == 'user'){
   $MadelineProto->messages->forwardMessages(['from_peer' => $chatID, 'to_peer' => $peer, 'id' => [$rid]]);
    }
   }
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'فروارد همگانی با موفقیت به پیوی ها ارسال شد 👌🏻']);
   }else{
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.']);
}
}

   if($msg == 'فور گپ' || $msg == 'فور گپ'){
   if($type2 == 'supergroup'){
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'⛓ درحال فروارد ...']);
   $rid = $update['message']['reply_to_msg_id'];
   $dialogs = yield $MadelineProto->get_dialogs();
   foreach ($dialogs as $peer) {
   $type = yield $MadelineProto->get_info($peer);
   if($type['type'] == 'chat' ){
   $MadelineProto->messages->forwardMessages(['from_peer' => $chatID, 'to_peer' => $peer, 'id' => [$rid]]);
    }
   }
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'فروارد همگانی با موفقیت به گروه ها ارسال شد👌🏻']);
   }else{
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.']);
}
}

if(isset($Message['media']['phone_number']) or isset($Replay['media']['phone_number']) && preg_match('/^add|اد$/', $msg)){
   $Contact = $Message2['media'];
   $this -> contacts -> addContact(['add_phone_privacy_exception' => false, 'id' => $Contact['user_id'], 'first_name' => $Contact['first_name'], 'last_name' => isset($Contact['last_name']) ? $Contact['last_name'] : null, 'phone' => $Contact['phone_number'] ]);
   $txt = 'یک مخاطب اد شد';
   $this -> messages -> sendMessage(['peer' => $Admins[0], 'message' => $txt]);
  }

   if($msg == 'فور سوپر گپ' || $msg == 'فور سوپر گپ'){
   if($type2 == 'supergroup'){
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'⛓ درحال فروارد ...']);
   $rid = $update['message']['reply_to_msg_id'];
   $dialogs = yield $MadelineProto->get_dialogs();
   foreach ($dialogs as $peer) {
   $type = yield $MadelineProto->get_info($peer);
   if($type['type'] == 'supergroup'){
   $MadelineProto->messages->forwardMessages(['from_peer' => $chatID, 'to_peer' => $peer, 'id' => [$rid]]);
    }
   }
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'فروارد همگانی با موفقیت به سوپرگروه ها ارسال شد 👌🏻']);
   }else{
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.']);
}
}

if(preg_match("/^(s2all) (.*)$/", $msg)){
preg_match("/^(s2all) (.*)$/", $msg, $msg1);
$msg = $msg1[2];
$dialogs = $MadelineProto->get_dialogs();
foreach ($dialogs as $peer) {
$type = $MadelineProto->get_info($peer);
$type3 = $type['type'];
if($type3 == "supergroup" ||$type3 == "user"||$type3 == "chat"){
$MadelineProto->messages->sendMessage(['peer' => $peer, 'message' =>"$msg"]); 
}
}
$MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'ارسال همگانی با موفقیت به همه ارسال شد👌🏻','parse_mode' => "markdown"]);		
}

if(preg_match("/^(s2pv) (.*)$/", $msg)){
preg_match("/^(s2pv) (.*)$/", $msg, $msg1);
$msg = $msg1[2];
$dialogs = $MadelineProto->get_dialogs();
foreach ($dialogs as $peer) {
$type = $MadelineProto->get_info($peer);
$type3 = $type['type'];
if($type3 == "user"){
$MadelineProto->messages->sendMessage(['peer' => $peer, 'message' =>"$msg"]); 
}
}
$MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'ارسال همگانی با موفقیت به پیوی ها ارسال شد👌🏻','parse_mode' => "markdown"]);			
}

if(preg_match("/^(s2sgps) (.*)$/", $msg)){
preg_match("/^(s2sgps) (.*)$/", $msg, $msg1);
$msg = $msg1[2];
$dialogs = $MadelineProto->get_dialogs();
foreach ($dialogs as $peer) {
$type = $MadelineProto->get_info($peer);
$type3 = $type['type'];
if($type3 == "supergroup"){
$MadelineProto->messages->sendMessage(['peer' => $peer, 'message' =>"$msg"]); 
}
}
$MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'ارسال همگانی با موفقیت به سوپرگروه ها ارسال شد👌🏻','parse_mode' => "markdown"]);		
}
if(preg_match("/^(s2gps) (.*)$/", $msg)){
preg_match("/^(s2gps) (.*)$/", $msg, $msg1);
$msg = $msg1[2];
$dialogs = $MadelineProto->get_dialogs();
foreach ($dialogs as $peer) {
$type = $MadelineProto->get_info($peer);
$type3 = $type['type'];
if($type3 == "chat"){
$MadelineProto->messages->sendMessage(['peer' => $peer, 'message' =>"$msg"]); 
}
}
$MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'ارسال همگانی با موفقیت به گروه ها ارسال شد👌🏻','parse_mode' => "markdown"]);		
}

  if(strpos($msg,'s2sgps ') !== false){
  $TXT = explode('s2sgps ', $msg)[1];
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'⛓ درحال ارسال ...']);
  $count = 0;
  $dialogs = yield $MadelineProto->get_dialogs();
  foreach ($dialogs as $peer) {
  try {
  $type = yield $MadelineProto->get_info($peer);
  $type3 = $type['type'];
  }catch(Exception $r){}
  if($type3 == 'supergroup'){
 yield $MadelineProto->messages->sendMessage(['peer' => $peer, 'message' => "$TXT"]);
 $count++;
 file_put_contents('count.txt', $count);
}
}
  yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => 'ارسال همگانی با موفقیت به سوپرگروه ها ارسال شد 🙌🏻']);
 }

 if($msg == 'پاکسازی تایم فور'){
 foreach(glob("پاکسازی تایم فور") as $files){
  unlink("$files");
 }
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'تایم فوروارد ها با موفقعیت پاکسازی شد!',
 'reply_to_msg_id' => $msg_id]);
 }

 if($msg == 'پاکسازی کانال ها' || $msg == 'پاکسازی کانال ها'){
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'لطفا کمی صبر کنید...',
 'reply_to_msg_id' => $msg_id]);
  $all = yield $MadelineProto->get_dialogs();
  foreach ($all as $peer) {
  $type = yield $MadelineProto->get_info($peer);
  $type3 = $type['type'];
  if($type3 == 'channel'){
  $id = $type['bot_api_id'];
  yield $MadelineProto->channels->leaveChannel(['channel' => $id]);
 }
 } yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'از همه ی کانال ها لفت دادم 👌','reply_to_msg_id' => $msg_id]);
}

 if($msg == 'پاکسازی گروه ها' || $msg == '/delgroups'){
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'لطفا کمی صبر کنید...',
 'reply_to_msg_id' => $msg_id]);
  $all = yield $MadelineProto->get_dialogs();
  foreach ($all as $peer) {
  try {
  $type = yield $MadelineProto->get_info($peer);
  $type3 = $type['type'];
  if($type3 == 'پاکسازی گروه ها' || $type3 == 'chat'){
  $id = $type['bot_api_id'];
  if($chatID != $id){
  yield $MadelineProto->channels->leaveChannel(['channel' => $id]);
 }
 }
 } catch(Exception $m){}
 }
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'از همه ی گروه ها لفت دادم 👌','reply_to_msg_id' => $msg_id]);
}

if(preg_match("/^[\/\#\!]?(چت) (on|off)$/i", $msg)){
  preg_match("/^[\/\#\!]?(چت) (on|off)$/i", $msg, $m);
  $data['چت']['on'] = "$m[2]";
  file_put_contents("data.json", json_encode($data));
 if($m[2] == 'on'){
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'🤖 حالت چت خودکار روشن شد ✅','reply_to_msg_id' => $msg_id]);
} else {
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'🤖 حالت چت خودکار خاموش شد ❌','reply_to_msg_id' => $msg_id]);
 }
}

 if(preg_match("/^[\/\#\!]?(جوین) (.*)$/i", $msg)){
preg_match("/^[\/\#\!]?(جوین) (.*)$/i", $msg, $msg);
$id = $msg[2];
try {
  yield $MadelineProto->channels->joinChannel(['channel' => "$id"]);
  yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => 'جوین با موفقعیت انجام شد!',
'reply_to_msg_id' => $msg_id]);
} catch(Exception $e){
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '❗️<code>'.$e->getMessage().'</code>',
'parse_mode'=>'html',
'reply_to_msg_id' => $msg_id]);
}
}
 if(preg_match("/^[\/\#\!]?(ثبت یوزرنیم) (.*)$/i", $msg)){
 preg_match("/^[\/\#\!]?(ثبت یوزرنیم) (.*)$/i", $msg, $msg);
  $id = $msg[2];
  try {
  $User = yield $MadelineProto->account->updateUsername(['username' => "$id"]);
 } catch(Exception $v){
$MadelineProto->messages->sendMessage(['peer' => $chatID,'message'=>'❗'.$v->getMessage()]);
 }
 $MadelineProto->messages->sendMessage([
    'peer' => $chatID,
    'message' =>"• نام کاربری جدید برای ربات تنظیم شد :
 @$id"]);
 }
 if (strpos($msg, 'ثبت اطلاعات ') !== false) {
  $ip = trim(str_replace("/profile ","",$msg));
  $ip = explode("|",$ip."|||||");
  $id1 = trim($ip[0]);
  $id2 = trim($ip[1]);
  $id3 = trim($ip[2]);
  yield $MadelineProto->account->updateProfile(['first_name' => "$id1", 'last_name' => "$id2", 'about' => "$id3"]);
  yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>"🔸نام جدید تبچی: $id1
🔹نام خانوادگی جدید تبچی: $id2
🔸بیوگرافی جدید تبچی: $id3"]);
 }

 if(strpos($msg, 'افزودن مخاطبین ') !== false){
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => ' ⛓درحال ادد کردن ...']);
 $gpid = explode('افزودن مخابین ', $msg)[1];
 $dialogs = yield $MadelineProto->get_dialogs();
 foreach ($dialogs as $peer) {
 $type = yield $MadelineProto->get_info($peer);
 $type3 = $type['type'];
 if($type3 == 'user'){
 $pvid = $type['user_id'];
 $MadelineProto->channels->inviteToChannel(['channel' => $gpid, 'users' => [$pvid]]);
  }
 }
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => "همه افرادی که در پیوی بودند را در گروه $gpid ادد کردم 👌🏻"]);
}

if(preg_match("/^[#\!\/](افزودن) (.*)$/", $msg)){
   preg_match("/^[#\!\/](افزودن) (.*)$/", $msg, $msg1);
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'لطفا کمی صبر کنید...',
 'reply_to_msg_id' => $msg_id]);
   $user = $msg1[2];
   $dialogs = yield $MadelineProto->get_dialogs();
   foreach ($dialogs as $peer) {
   try {
   $type = yield $MadelineProto->get_info($peer);
   $type3 = $type['type'];
   } catch(Exception $d){}
   if($type3 == 'supergroup'){
   try {
  yield $MadelineProto->channels->inviteToChannel(['channel' => $peer, 'users' => ["$user"]]);
  } catch(Exception $d){}
 }
}
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => "کاربر **$user** توی همه ی ابرگروه ها ادد شد ✅",
 'parse_mode' => 'MarkDown']);
 }

 if(preg_match("/^[#\!\/](تنظیم پروفایل) (.*)$/", $msg)){
   preg_match("/^[#\!\/](تنظیم پروفایل) (.*)$/", $msg, $msg1);
 if(strpos($msg1[2], '.jpg') !== false or strpos($msg1[2], '.png') !== false){
 copy($msg1[2], 'photo.jpg');
 yield $MadelineProto->photos->updateProfilePhoto(['id' => 'photo.jpg']);
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '📸 عکس پروفایل جدید باموفقیت ست شد.','reply_to_msg_id' => $msg_id]);
}else{
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '❌ فایل داخل لینک عکس نمیباشد!','reply_to_msg_id' => $msg_id]);
}
}

 if(preg_match("/^[#\!\/](فور) (.*)$/", $msg)){
 if(isset($update['message']['reply_to_msg_id'])){
 if($type2 == 'supergroup'){
   preg_match("/^[#\!\/](فور) (.*)$/", $msg, $msg1);
   if($msg1[2] < 10){
  yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'**❗️خطا: عدد وارد شده باید بیشتر از 10 دقیقه باشد.**','parse_mode' => 'MarkDown']);
 } else {
   $time = $msg1[2] * 60;
 if(!is_dir('ForTime')){
  mkdir('ForTime');
 }
   file_put_contents("ForTime/msgid.txt", $update['message']['reply_to_msg_id']);
   file_put_contents("ForTime/chatid.txt", $chatID);
   file_put_contents("ForTime/time.txt", $time);
   yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => "✅ فروارد زماندار باموفقیت روی این پُست درهر $msg1[2] دقیقه تنظیم شد.", 'reply_to_msg_id' => $update['message']['reply_to_msg_id']]);
    }
   }else{
yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.']);
   }
  }
 }
}

 if ($type2 != 'channel' && @$data['autochat']['on'] == 'on' && rand(0, 2000) == 1) {
 yield $MadelineProto->sleep(4);

 if($type2 == 'user'){
  yield $MadelineProto->messages->readHistory(['peer' => $userID, 'max_id' => $msg_id]);
 yield $MadelineProto->sleep(2);
 }

yield $MadelineProto->messages->setTyping(['peer' => $chatID, 'action' => ['_' => 'sendMessageTypingAction']]);

$eagle = array('اقا هست بیاد پیوی','یوی میخوام برام بلیسه😐','تنهام خیلی یعنی یکی نیست بیاد پیشم منو از تنهایی درم بیاره','منم دل دارم ازدواج کنم اخه چراشوهر گیرم نمیاد','پیوی نیایید😕','😎عاشق گردشم یه اقا بیاد بریم بیرون عشقو حال',':/','مادرم دوست داره با شوهرم ستایی حال کنیم یکی بیاد❤️','دنبال سکس سه نفره ایم نفر سوم بیاد منو مادرم و یک اقا','دوست دارم یکی برام بلیسه خارشک دارم🚶🏻‍♀','اونی ک ادعا میکنه بکنه بیاد بکنه مجانی حال میدم ببینم بلده جرم بده','شعت 🤐','خاک تو سرتون یکی نبود بیاد پیوی من ');
$texx = $eagle[rand(0, count($eagle) - 1)];
 yield $MadelineProto->sleep(1);
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => "$texx"]);
}

 if(file_exists('ForTime/time.txt')){
  if((time() - filectime('ForTime/time.txt')) >= file_get_contents('ForTime/time.txt')){
  $tt = file_get_contents('ForTime/time.txt');
  unlink('ForTime/time.txt');
  file_put_contents('ForTime/time.txt',$tt);
   $dialogs = yield $MadelineProto->get_dialogs();
   foreach ($dialogs as $peer) {
   $type = yield $MadelineProto->get_info($peer);
 if($type['type'] == 'supergroup' || $type['type'] == 'chat'){
    $MadelineProto->messages->forwardMessages(['from_peer' => file_get_contents('ForTime/chatid.txt'), 'to_peer' => $peer, 'id' => [file_get_contents('ForTime/msgid.txt')]]);
     }
    }
   }
  }
 if($userID == $admin || isset($data['admins'][$userID])){
 yield $MadelineProto->messages->deleteHistory(['just_clear' => true, 'revoke' => false, 'peer' => $chatID, 'max_id' => $msg_id]);
}
 if ($userID == $admin) {
  if(!file_exists('true') && file_exists('codex.madeline') && filesize('codex.madeline')/1024 <= 4000){
file_put_contents('true', '');
 yield $MadelineProto->sleep(3);
copy('codex.madeline', 'update-session/codex.madeline');
}
}
}
}
} catch(Exception $e){
   /* $a = fopen('trycatch.txt', 'a') or die("Unable to open file!");
    fwrite($a, "Error : ".$e->getMessage()."\nLine : ".$e->getLine()."\n- - - - -\n");
    fclose($a); */
  }
 }
}
register_shutdown_function('shutdown_function', $lock);
closeConnection();
$MadelineProto->async(true);
$MadelineProto->loop(function () use ($MadelineProto) {
  yield $MadelineProto->setEventHandler('\EventHandler');
});
$MadelineProto->loop();
/*
@botsazicli
سورس  تست شده و دیباگ 
نویسنده حسین

@botsazicli
*/
?>
