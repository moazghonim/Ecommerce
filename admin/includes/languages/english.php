<?php



function lang($phrase)
{

    static $lang = [

        // Navbar Likns

        'HOME_ADMIN' => 'Home',
        'CATEGORIES' => 'Categories',
        'ITEMS'      => 'Itmes',
        'MEMBERS'    => 'Members',
        'STATISTICS' => 'Statistics',
        'LOGS'       => 'Logs'


    ];

    return $lang[$phrase];
}
