<?php

function encrypt($string) {
    return hash('sha512', $string);
}
