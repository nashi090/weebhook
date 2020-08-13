<?php

ob_start();

$API_KEY = '1364246243:AAGml4XFRKetMeGLHzanltgIacs-b5bpgNM';
##------------------------------##
define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

$update = json_decode(file_get_contents('php://input'));
$output = json_decode(file_get_contents('php://input'), TRUE);
$message = $update->message;
$chat_id = $message->chat->id;
$textmsg = $message->text;
$username = $update->message->from->username;
$from_id = $update->message->from->id;
$message_id = $message->message_id;
if(isset($update->callback_query)){
    $callbackMessage = 'الاعدادات الرئيسية';
    var_dump(bot('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>$callbackMessage
    ]));
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    $callback_query = $output['callback_query'];
    $username = $callback_query['from']['username'];
    $from_id = $callback_query['from']['id'];
if($data=="how"){
   bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
   'text'=>"📩 بوت صارحني
‎▫️صارحني لتلقي النقد البناء بسرية تامة لتنمية الذات مع الحفاظ على سرية هوية المرسل وخصوصية الرسائل

‎▫️ احصل على نقد بناء بسرية تامة من زملائك في العمل وأصدقائك.

‎▪️ الفائدة .
‎▫️عزز نقاط القوة لديك
‎▫️عالج نقاط ضعفك
‎▫️عزز صداقاتك بمعرفة مزاياك وعيوبك
‎▫️مكّن أصحابك من مصارحتك

‎📱 يتيح لك بوت صارحني مشاركة الرابط والرد على الرسائل بسهولة وحظر المستخدمين المزعجين

‎🔘 هل أنت مستعد لمعرفة ملاحظات الناس عنك بدون أن تعرفهم ؟
-",
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"🔙 رجوع ...",'callback_data'=>"back"],
                        ],
                ]
            ])
        ]);
         }
if($data=="cans"){
file_put_contents("settings/$from_id","");
file_put_contents("settings2/$from_id","");
   bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"✅ تم الغاء الارسال .
‎▫️ لن يمكنك إرسال اي رسالة الان .
‎▫️ اذا كنت تريد معاودة الإرسال ادخل من الرابط مره أخرى لنفس العضو.
-",
        ]);
         }



if($data=="make"){
$link = file_get_contents("codes/$from_id/code.txt");
   bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
   'text'=>"▪️ الرابط الخاص بك .

▫️ https://t.me/Sarh24bot?start=$chat_id

‎▫️ يمكنك نشر الرابط في قروبات التيليجرام او بين أصدقائك او مواقع التواصل الإجتماعي.

‎▪️حانت لحظة الصراحة .
-",
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                                    [
                        ['text'=>"🌐 مشاركة الرابط",'switch_inline_query'=>" "],
                        ],
                    [
                        ['text'=>"🔙 رجوع ...",'callback_data'=>"back"],
                        ],
                ]
            ])
        ]);
         }
if($data=="back"){
   bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
   'text'=>"اهلاً بك: [@$username](t.me/$username)

‎▪️ بوت صارحني

‎▫️ احصل على نقد بناء بسرية تامة من زملائك في العمل وأصدقائك.

‎🌐 احصل على الرابط الخاص بك .
‎💌 إقرأ ما كتبه الناس عنك .
‎⚙️ أوامر البوت - /help
-",
   'parse_mode'=>'MARKDOWN',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"💡 عن بوت صارحني",'callback_data'=>"how"],
                        ],
                                            [
                        ['text'=>"🌐 إنشاء رابط خاص",'callback_data'=>"make"],
                        ]
                ]
            ])
        ]);
         }
}
if($textmsg=="/start"){
 $user = file_get_contents('Member.txt');
    $members = explode("\n",$user);
    if (!in_array($from_id,$members)){
      $add_user = file_get_contents('Member.txt');
      $add_user .= $from_id."\n";
     file_put_contents('Member.txt',$add_user);
     $Rand = substr(str_shuffle("1364246243:AAGml4XFRKetMeGLHzanltgIacs-b5bpgNM"), -6);
file_put_contents("Members/$Rand","$from_id");
file_put_contents("settings/$from_id","");
file_put_contents("settings2/$from_id","");
file_put_contents("ban/$from_id","");
file_put_contents("username/$from_id","$username");
mkdir("codes/$from_id");
file_put_contents("codes/$from_id/code.txt","$Rand");
   bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"اهلاً بك: [@$username](t.me/$username)

‎▪️ بوت صارحني

‎▫️ احصل على نقد بناء بسرية تامة من زملائك في العمل وأصدقائك.

‎🌐 احصل على الرابط الخاص بك .
‎💌 إقرأ ما كتبه الناس عنك .
‎⚙️ أوامر البوت - /help
-",
   'parse_mode'=>'MARKDOWN',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"💡 عن بوت صارحني",'callback_data'=>"how"],
                        ],
                                            [
                        ['text'=>"🌐 إنشاء رابط خاص",'callback_data'=>"make"],
                        ]
                ]
            ])
]);
         }else {
                bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"اهلاً بك: [@$username](t.me/$username)

‎▪️ بوت صارحني

‎▫️ احصل على نقد بناء بسرية تامة من زملائك في العمل وأصدقائك.

‎🌐 احصل على الرابط الخاص بك .
‎💌 إقرأ ما كتبه الناس عنك .
‎⚙️ أوامر البوت - /help
-",
   'parse_mode'=>'MARKDOWN',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"💡 عن بوت صارحني",'callback_data'=>"how"],
                        ],
                                            [
                        ['text'=>"🌐 إنشاء رابط خاص",'callback_data'=>"make"],
                        ]
                ]
            ])
]);
         }
}
if($textmsg=="/help"){
                    bot('sendMessage',[
   'chat_id'=>$chat_id,
    'reply_to_message_id'=>$message_id,
   'text'=>"
‎بعض الإوامر الخاصك بك:

▫️/ban -  مع الرد على الرسالة  - حظر
▫️/unban  - مع الرد على الرسالة - رفع الحظر

-",
]);
}
//=======main========//
$usersa = file_get_contents("Members/".$match[2]);
$useruu = file_get_contents("username/$usersa");
if(preg_match('/^\/([Ss]tart) (.*)/',$textmsg)){
preg_match('/^\/([Ss]tart) (.*)/',$textmsg,$match);
$usersa = file_get_contents("Members/".$match[2]);
$useruu = file_get_contents("username/$usersa");
$list = file_get_contents("ban/$usersa.txt");
if ($from_id != $usersa){
if(strpos($list , "$from_id") === false){
file_put_contents("settings/$from_id","open");
file_put_contents("settings2/$from_id","$usersa");
                bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"▪️ اهلاً بك ..
‎▫️ `سوف يتم إرسال الرسالة الى` ( *@$useruu *)` بسرية تامة .`
‎▫️`صارحني انا مستعد لمواجهة الصراحة .`
‎▫️`اكتب ماتريد في هذه المحدثة وسوف يتم إرسالها إلى` ( *@$useruu *)

‎💡 عند الانتهاء قم بالضغط على زر (🚫 الغاء إرسال الرسائل)

‎[🌐أضغط هنا وتابع جديدنا ](https://telegram.me/c3d3d) 🌐

-",
   'parse_mode'=>'MARKDOWN',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"🚫 الغاء إرسال الرسائل",'callback_data'=>"cans"],
                        ]
                ]
            ])
]);
}else{
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'reply_to_message_id'=>$message_id,
    'text'=>"▪️ انت محضور من الدخول لصاحب هذا الرابط",
]);
}
}else {
                    bot('sendMessage',[
    'chat_id'=>$chat_id,
    'reply_to_message_id'=>$message_id,
    'text'=>"▪️لا يمكنك الإرسال لنفسك .",
]);
}
}
$fffa = file_get_contents("settings/$from_id");
$fffaaw = file_get_contents("reply/$from_id");
$fffahbdhbh = file_get_contents("settings/$fffaaw");
if($message->reply_to_message && $textmsg !="/ban" && $textmsg !="/unban"){
if($fffahbdhbh == "open"){
    bot('sendMessage',[
    'chat_id'=>$fffaaw,
    'text'=>"✉️ رد على رسالتك:

$textmsg
-",
]);
}else{
bot('sendMessage',[
    'chat_id'=>$chat_id,
    'reply_to_message_id'=>$message_id,
    'text'=>"▫️عفواً لا يمكنك الرد على هذا الشخص

‎▪️لأنه قام بأغلاق إرسال الرسائل الخاصة بالصراحه ",
]);
}
}
if ($message->reply_to_message && $textmsg== "/ban") {
			$myfile2 = fopen("ban/$from_id.txt", "a") or die("Unable to open file!");
			fwrite($myfile2, "$fffaaw\n");
			fclose($myfile2);
		file_put_contents("settings/$fffaaw","not");
        file_put_contents("settings2/$fffaaw","not");
bot('sendMessage',[
    'chat_id'=>$chat_id,
    'reply_to_message_id'=>$message_id,
    'text'=>"🛡 تم حظر صاحب هذه الرسالة.",
]);
bot('sendMessage',[
    'chat_id'=>$fffaaw,
    'text'=>"▪️ تم حظرك .

‎▫️وتم اغلاق إرسال الرسائل تلقائياً",
]);
}

if($message->reply_to_message && $textmsg=="/unban"){
			$newlist = str_replace($fffaaw,"",$list);
			file_put_contents("ban/$from_id.txt",$newlist);
bot('sendMessage',[
    'chat_id'=>$chat_id,
    'reply_to_message_id'=>$message_id,
    'text'=>"🛡 تم رفع الحظر عن صاحب هذه الرسالة.",
]);
bot('sendMessage',[
    'chat_id'=>$fffaaw,
    'text'=>"🛡 تم رفع الحظرك عنك.",
]);
}
$idsraha = file_get_contents("settings2/$from_id");
$start = str_replace("/start ","",$textmsg);
if($fffa == "open" && $textmsg !="/start $start" && $textmsg !="/help" && $textmsg !="/ban" && $textmsg !="/unban"){
file_put_contents("reply/$idsraha","$from_id");
  bot('sendmessage',[
    'chat_id'=>$chat_id,
    'reply_to_message_id'=>$message_id,
   'text'=>"✅ تم إرسال رسالتك بنجاح .",
   'parse_mode'=>"Markdown"
  ]);
  $data = date("Y/m/d");
  $time = time() + (979 * 11 + 1 + 30);
  $timee = date('g', $time).":".date('i', $time).":".date('s', $time);
  bot('sendmessage',[
    'chat_id'=>$idsraha,
   'text'=>"💌 وصلت لك رسالة جديدة
‎⏱وقت الرسالة: $data - $timee
‎✉️ المحتوى :  ↓↓
$textmsg
----
‎💡يمكنك الرد بعمل رد على هذه الرسالة .",
   'parse_mode'=>"Markdown"
  ]);
}
//=======inline==========//
$from_idin = $update->inline_query->from->id;
$usernameinl = $update->inline_query->from->username;
$inlink = file_get_contents("codes/$from_idin/code.txt");
if($update->inline_query){
    $inlineqt = $update->inline_query->query;
 $user = file_get_contents('Member.txt');
    $members = explode("\n",$user);
    if (!in_array($from_idin,$members)){
      $add_user = file_get_contents('Member.txt');
      $add_user .= $from_idin."\n";
     file_put_contents('Member.txt',$add_user);
     $Rand = substr(str_shuffle("773477897:AAF6XpvZbb_WtBLUwDxJnOoK9eUjVArA3ZM"), -6);
file_put_contents("Members/$Rand","$from_idin");
file_put_contents("settings/$from_idin","");
file_put_contents("settings2/$from_idin","");
file_put_contents("ban/$from_idin","");
mkdir("codes/$from_idin");
file_put_contents("username/$from_idin","$usernameinl");
file_put_contents("codes/$from_idin/code.txt","$Rand");
if($inlineqt == ''){
bot('answerInlineQuery', [
'inline_query_id' => $update->inline_query->id,
'results' => json_encode([[
'type' => 'article',
'id' => base64_encode(rand(5, 555)),
'title' => '🌐 شارك حسابك مع أصدقائك.',
'description' => 'اضغط هنا وسوف يتم ارسالها تلقائياً',
'input_message_content' => ['parse_mode' => 'MarkDown', 'disable_web_page_preview'=> true, 'message_text' => "▪️صارحني لتلقي النقد البناء بسرية تامة

‎▫️ [هنا يمكنك ارسال اي رسالة لي](http://t.me/Sarh24bot?start=$Rand) , انا مستعد لمواجهة الصراحة 😅 .
-"],
'reply_markup' => [
'inline_keyboard' => [
[['text' => "💌 إرسل لي هنا", 'url' => "http://t.me/Sarh24bot?start=$Rand"]],
]]
]])
]);
}else {
bot('answerInlineQuery', [
'inline_query_id' => $update->inline_query->id,
'results' => json_encode([[
'type' => 'article',
'id' => base64_encode(rand(5, 555)),
'title' => '🌐 شارك حسابك مع أصدقائك.',
'description' => 'اضغط هنا وسوف يتم ارسالها تلقائياً',
'input_message_content' => ['parse_mode' => 'MarkDown', 'disable_web_page_preview'=> true, 'message_text' => "$inlineqt"],
'reply_markup' => [
'inline_keyboard' => [
[['text' => "💌 إرسل لي هنا", 'url' => "http://t.me/Sarh24bot?start=$Rand"]],
]]
],[
'type' => 'article',
'id' => base64_encode(rand(5, 555)),
'title' => '🔖 رسالة مخصصة .',
'description' => '📍سوف يتم إرسال ماتكتبه هنا.',
'input_message_content' => ['parse_mode' => 'MarkDown', 'disable_web_page_preview'=> true, 'message_text' => "$inlineqt"],
'reply_markup' => [
'inline_keyboard' => [
[['text' => "💌 إرسل لي هنا", 'url' => "http://t.me/Sarh24bot?start=$Rand"]],
]]
]])
]);
}
}else {
if($inlineqt == ''){
bot('answerInlineQuery', [
'inline_query_id' => $update->inline_query->id,
'results' => json_encode([[
'type' => 'article',
'id' => base64_encode(rand(5, 555)),
'title' => '🌐 شارك حسابك مع أصدقائك.',
'description' => 'اضغط هنا وسوف يتم ارسالها تلقائياً',
'input_message_content' => ['parse_mode' => 'MarkDown', 'disable_web_page_preview'=> true, 'message_text' => "▪️صارحني لتلقي النقد البناء بسرية تامة

‎▫️ [هنا يمكنك ارسال اي رسالة لي](http://t.me/Sarh24bot?start=$from_idin) , انا مستعد لمواجهة الصراحة 😅 .
-"],
'reply_markup' => [
'inline_keyboard' => [
[['text' => "💌 إرسل لي هنا", 'url' => "http://t.me/Sarh24bot?start=$from_idin"]],
]]
]])
]);
}else {
    bot('answerInlineQuery', [
'inline_query_id' => $update->inline_query->id,
'results' => json_encode([[
'type' => 'article',
'id' => base64_encode(rand(5, 555)),
'title' => '🌐 شارك حسابك مع أصدقائك.',
'description' => 'اضغط هنا وسوف يتم ارسالها تلقائياً',
'input_message_content' => ['parse_mode' => 'MarkDown', 'disable_web_page_preview'=> true, 'message_text' => "$inlineqt"],
'reply_markup' => [
'inline_keyboard' => [
[['text' => "💌 إرسل لي هنا", 'url' => "http://t.me/Sarh24bot?start=$from_idin"]],
]]
],[
'type' => 'article',
'id' => base64_encode(rand(5, 555)),
'title' => '🔖 رسالة مخصصة .',
'description' => '📍سوف يتم إرسال ماتكتبه هنا.',
'input_message_content' => ['parse_mode' => 'MarkDown', 'disable_web_page_preview'=> true, 'message_text' => "$inlineqt"],
'reply_markup' => [
'inline_keyboard' => [
[['text' => "💌 إرسل لي هنا", 'url' => "http://t.me/Sarh24bot?start=$from_idin"]],
]]
]])
]);
}
}
}
?>
