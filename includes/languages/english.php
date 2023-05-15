<?php



function lang($phrase)
{

    static $lang = [

        // Navbar Likns

        'HOME_ADMIN' => 'Home',
        'CATEGORIES' => 'Categories',
        'ITEMS'      => 'Itmes',
        'MEMBERS'    => 'Members',
        'COMMENTS'   => 'Comments',
        'STATISTICS' => 'Statistics',
        'LOGS'       => 'Logs'


    ];

    return $lang[$phrase];
}
