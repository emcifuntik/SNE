<?php
/**
 * User: Tuxick
 * Date: 23.03.2015
 * Time: 7:30
 */

//var_dump($_REQUEST);

$response = file_get_contents("https://api.vk.com/method/audio.get?lang=ru&owner_id=238487654&access_token=520573c0a6c8d95fff3b7c6e0e9cad9abbfdf023b6087adb922d880ddbc5b392c0c8b36de41c547e9ef2a");
$arr = json_decode($response, true);
//print_r($arr["response"][1]);

$tests["audio"] = array();
/*    array("title" => "Макс Корж - Мотылёк", "time" => 200, "url" => "http://cs9-1v4.vk.me/p24/6ef03902c3d93b.mp3?extra=x-xVP9bKsmCjX5DHxXv6DfUv9h0hYfEMPLbAPDP5Khz0-vaBcc72G2IL0R4QDJ0OnRlq4CQJDdwrjzKOJLheKfzfMCXhzoc,179"),
    array("title" => "Макс Корж - Тралики", "time" => 342, "url" => "http://cs9-12v4.vk.me/p16/13a90d9eee97e3.mp3?extra=Ppwx_4QeXIx4KAJs2okHHC467BBPNt5BnPicmB3eUFrILsVnLfxNlvbAawNi5ojCUa5eovfeSmFsbSPhPbEaoxG0qzljCJg,230"),
    array("title" => "Типси Тип - Зелёный светофор", "time" => 187, "url" => "http://cs5632v4.vk.me/u34532884/audios/9e848f9354b1.mp3?extra=t-1RaJX12AqprrMXTq4DvqA_6nQhjf6N4QZ8QeCZSDuzHqTrUTs6nQErlXdlOIU3DQsiTrvnM9N_24LqumIY1tO7EIX7CxjA,185"),
    array("title" => "Типси Тип - Будем жить", "time" => 167, "url" => "http://cs536300v4.vk.me/u43902894/audios/c9537b6db907.mp3?extra=rHqOxPS0L6GlWjidcHIQ9pvnSq-Finh3cIAGYtkPZYyMkrS50moVXV0OaV0L0Ax7N5-qMoAqMjTMsWvx4IBgSv0CNGtOvW0N,237"),
    array("title" => "Hollywood Undead - Undead", "time" => 193, "url" => "http://cs9-5v4.vk.me/p16/8b15c9cd5943a7.mp3?extra=C3ELcY10I4PiFLzhAKK_mn06TZEYYKCOFFhpjAUzIwtd0OuM9Sil_mwoLiDzv4QaZWXKUvcoSJxKCnIuAal4uexqoYjkEKhi,265")
);*/

for($i = 1; $i < count($arr["response"]); $i++)
{
    $tests["audio"][$i]["title"] = $arr["response"][$i]["artist"] . ' - ' . $arr["response"][$i]["title"];
    $tests["audio"][$i]["time"] = $arr["response"][$i]["duration"];
    $tests["audio"][$i]["url"] = $arr["response"][$i]["url"];
}
//echo $tests;