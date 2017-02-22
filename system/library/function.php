<?php
/**
 * 打印数组或对象，用于调试
 *
 */
function dump($vars, $label = null)
{
    if (ini_get('html_errors'))
    {
        $content = "<pre>\n";
        if ($label !== null && $label !== '')
        {
            $content .= "<strong>{$label} :</strong>\n";
        }
        $content .= htmlspecialchars(print_r($vars, true));
        $content .= "\n</pre>\n";
    }
    else
    {
        $content = "\n";
        if ($label !== null && $label !== '')
        {
            $content .= $label . " :\n";
        }
        $content .= print_r($vars, true) . "\n";
    }

    echo $content;
    return null;
}

?>