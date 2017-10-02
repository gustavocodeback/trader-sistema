<?php defined('BASEPATH') OR exit('No direct script access allowed');

// pacotes padroes
$config['default'] = [ 'jquery', 'global', 'bootstrap', 'navbar', 'aside', 'footer', 'jquery-mask' ];

// configuracao dos assets globais
$config['global'] = [
    'css' => [
        site_url( 'assets/global/global.css' ),
        'https://fonts.googleapis.com/css?family=Ubuntu'
    ],
    'js' => [
        site_url( 'assets/global/global.js' ),
        site_url( 'assets/global/upload.js' ),
    ]
];

// inclui o bootstrap
$config['bootstrap'] = [
    'css'=> [
        site_url( 'assets/bootstrap/dist/css/bootstrap.min.css' )
    ],
    'js' => [
        site_url( 'assets/bootstrap/dist/js/bootstrap.min.js' )
    ]
];

// inclui o jquery
$config['jquery'] = [
    'js' => [
        site_url( 'assets/jquery/dist/jquery.min.js' )
    ]
];

// mascaras
$config['jquery-mask'] = [
    'js' => [
        site_url( 'assets/jquery-mask-plugin/dist/jquery.mask.min.js' ),
        site_url( 'assets/global/masks.js' ),
    ]
];

// seta o login
$config['login'] = [
    'css'=> [
        site_url( 'assets/pages/login/login.css' )
    ],
    'js'=> [
        site_url( 'assets/pages/login/login.js' )
    ]
];

// seta o dashboard
$config['aside'] = [
    'css'=> [
        site_url( 'assets/components/aside/aside.css' )
    ]
];

// seta o dashboard
$config['dashboard'] = [
    'css'=> [
        site_url( 'assets/pages/dashboard/dashboard.css' )
    ]
];

// seta o grid
$config['grid'] = [
    'css'=> [
        site_url( 'assets/pages/grid/grid.css' )
    ]
];

// seta o navbar
$config['navbar'] = [
    'css'=> [
        site_url( 'assets/components/navbar/navbar.css' )
    ]
];

// seta o footer
$config['footer'] = [
    'css'=> [
        site_url( 'assets/components/footer/footer.css' )
    ]
];

// seta o footer
$config['cover'] = [
    'css'=> [
        site_url( 'assets/components/cover/cover.css' )
    ]
];

// seta o footer
$config['minha_loja'] = [
    'css'=> [
        site_url( 'assets/pages/minha_loja/index.css' )
    ], 
    'js'=> [
        site_url( 'assets/pages/minha_loja/index.js' )
    ]
];

// seta o footer
$config['acessos'] = [
    'css'=> [
        site_url( 'assets/pages/acessos/index.css' )
    ], 
    'js'=> [
        site_url( 'assets/pages/acessos/index.js' )
    ]
];

// inclui o fullcalendar
$config['calendar'] = [
    'js' => [
        site_url( 'assets/moment/moment.js' ),        
        site_url( 'assets/fullcalendar/dist/fullcalendar.min.js' ),
        site_url( 'assets/fullcalendar/dist/locale/pt-br.js' ),
        site_url( 'assets/global/calendar.js' ),
    ],
    'css' => [
        site_url( 'assets/fullcalendar/dist/fullcalendar.min.css' )
    ]
];

// seta as mensagens
$config['mensagens'] = [
    'css'=> [
        site_url( 'assets/pages/mensagens/mensagens.css' )
    ],
    'js' => [
        site_url( 'assets/pages/mensagens/mensagens.js' )
    ]
];

// mascaras
$config['text-editor'] = [
    'js' => [
        site_url( 'assets/tinymce/js/tinymce/jquery.tinymce.min.js' ),
        site_url( 'assets/tinymce/js/tinymce/tinymce.min.js' ),
        site_url( 'assets/pages/editor/editor.js' ),
    ],
    'css' => [
        site_url( 'assets/tinymce/js/tinymce/skins/lightgray/content.inline.min.css' ),
        site_url( 'assets/tinymce/js/tinymce/skins/lightgray/content.min.css' ),
        site_url( 'assets/tinymce/js/tinymce/skins/lightgray/skin.min.css' ),
    ]
];