<?php

function autocatset_array_htmlspecialchars($string) {
    if (is_array($string)) {
        return array_map("autocatset_array_htmlspecialchars", $string);
    } else {
        return htmlspecialchars($string, ENT_QUOTES);
    }
}