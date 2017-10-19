<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Push {

    // instancia do codeigniter
    public $ci;

    // key do servidor
    public $key = 'AAAAMpo0tGU:APA91bHRNJ_XHj6d0f7BX5hRR3GBquD48srQJ-mkOcpfgtTArYw1l962pHF0ok0ndfb_lfsVHLeXwDiA_A4uTR7pb-CVOymPcq9mWXrqd3hLk9XhFQpbUztfqFGjGbpXBQjw9FFhoWFf';

    // titulo
    public $title = '';

    // corpo
    public $body = '';

    // imagem
    public $image = null;

    // url
    public $url = 'https://fcm.googleapis.com/fcm/send';

    // método construtor
    public function __construct() {

        // pega a instancia do ci
        $this->ci =& get_instance();
    }

    // seta o titulo
    public function setTitle( $title ) {
        $this->title = $title;
        return $this;
    }

    // seta o corpo
    public function setBody( $body ) {
        $this->body = $body;
        return $this;
    }

    // seta a imagem
    public function setImage( $image ) {
        $this->image = $image;
        return $this;
    }

    // dispara a notificacao
    public function fire( $idCelular = false ) {

        // seta o corpo
        $body = [
            "to" => ( $idCelular ) ? $idCelular : "/topics/all",
            "notification" => [	
                "title"        => $this->title, 
                "body"         => $this->body, 
                "sound"        => "default", 
                "icon"         => "notify"
            ],
            "data" => [
                "message" => $this->body
            ]
        ];

        // verifica se existe uma imagem
        if ( $this->image ) {
            $body['notification']['image'] = $this->image;
        }
        $fields = json_encode( $body );

        // seta os headers
        $headers = [
            'Authorization: key=' . $this->key,
            'Content-Type: application/json'
        ];

        // envia o curl
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $this->url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        // pega o resultado
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result ;
    }
}

/* end of file */
