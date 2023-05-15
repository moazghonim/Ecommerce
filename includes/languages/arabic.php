<?php

function lang($phrase)
{

    static $lang = [

        "Message" => "مرحبا",
        "Admin" => "المدير",
    ];

    return $lang[$phrase];
}
