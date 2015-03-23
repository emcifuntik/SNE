<?php
/**
 * Created by PhpStorm.
 * User: Tuxick
 * Date: 06.03.2015
 * Time: 14:20
 */

require "lib/classes/SQL.php";
require "lib/classes/Template.php";
require "tests/audio.php";

use Base\SQL as SQL;
use Base\Template as Template;

$pages = array("user", "audio", "video");
$page = NULL;
foreach($pages as $one)
{
    if(isset($_REQUEST[$one]))
    {
        $page = $one;
        break;
    }
}
$page = isset($page) ? $page : "";


$sql = new SQL(SQL::CONNECTION_SQLITE, "data.sqlite");

$main = new Template("template/default/", "main.tpl");

$main->load_language("ru_RU");
$main->set_value("YEAR", date("Y"));
$main->set_value("TITLE", "Funtik");

$content = NULL;
switch($page) {
    case "user":
        $content = new Template("template/default/", "user.tpl");
        $content->load_language("ru_RU");
        $main->set_value("CONTENT", $content->finish());
        break;
    case "audio":
        $content = new Template("template/default/", "audio.tpl");
        $content->load_language("ru_RU");
        $item = $content->load_block("PLAYLIST_ITEM");
        $text = "";
        foreach($tests["audio"] as $one) {
            $item->reset();
            $item->set_value("AUDIO_TITLE", $one["title"]);
            $time = array(
                "h" => floor($one["time"] / 60),
                "m" => $one["time"] % 60
            );
            $item->set_value("AUDIO_TIME", $time["h"].":".sprintf("%02d", $time["m"]));
            $item->set_value("AUDIO_URL", $one["url"]);
            $text .= $item->finish();
        }
        $content->replace_block("PLAYLIST_ITEM", $text);
        $main->set_value("CONTENT", $content->finish());
        break;
    default:
        $main->set_value("CONTENT", "Ошибка, страница не найдена.");
        break;
}

die($main->finish());