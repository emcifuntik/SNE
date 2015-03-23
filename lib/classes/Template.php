<?php
/**
 * Created by PhpStorm.
 * User: Tuxick
 * Date: 09.03.2015
 * Time: 6:55
 */

namespace Base;


class Template {
    private $template_text;
    private $template_file;
    private $template_original;

    public function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }

    public function __construct1($text)
    {
        $this->template_text = $text;
        $this->template_original = $this->template_text;
    }
    public function __construct2($_folder, $_filename)
    {
        $this->template_file = $_folder.$_filename;
        $this->template_text = file_get_contents($this->template_file);
        $this->template_original = $this->template_text;
            $this->set_value("PATH", $_folder);
    }

    public function set_value($_alias, $_value)
    {
        $count = 0;
        $this->template_text = str_replace("{ALIAS:".$_alias."}", $_value, $this->template_text, $count);
        return $count;
    }

    public function load_block($_blockname)
    {
        preg_match("/{BLOCK:BEGIN:" . $_blockname . "}((.|\n)*){BLOCK:END:" . $_blockname . "}/", $this->template_text, $matches);

        if(isset($matches[1])) {
            $blocktext = $matches[1];
        }
        else $blocktext = false;
        return new Template($blocktext);
    }

    public function replace_block($_blockname, $_content)
    {
        $this->template_text = preg_replace("/{BLOCK:BEGIN:" . $_blockname . "}((.|\n)*){BLOCK:END:" . $_blockname . "}/",
            $_content,
            $this->template_text);
    }

    public function load_language($_language)
    {
        $lang_file = file_get_contents("language\\".$_language.".lng");
        $strings = explode("\r\n", $lang_file);
        foreach($strings as $string)
        {
            $attrs = explode("=", $string);
            $this->set_value($attrs[0], $attrs[1]);
        }
        return true;
    }

    public function reset()
    {
        $this->template_text = $this->template_original;
    }

    public function finish()
    {
        return $this->template_text;
    }
}