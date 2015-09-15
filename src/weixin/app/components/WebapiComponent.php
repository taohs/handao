<?php
class WebapiComponent extends \Phalcon\Mvc\User\Component
{
    public $loginCodeUrl = 'http://api.handao365.com/user/logincode';
    public $loginUrl = 'http://api.handao365.com/user/login';
    public function webApiGetCode( $mobile )
    {
        $post_data = array( "mobile" => $mobile );
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $this->loginCodeUrl );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data );
        $output = curl_exec( $ch );

        curl_close( $ch );

        return json_decode( $output );
    }
    public function webApiLogin( $mobile, $code )
    {
        $post_data = array( "mobile" => $mobile, "code" => $code );
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $this->loginUrl );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data );
        $output = curl_exec( $ch );
        curl_close( $ch );
        return json_decode( $output );
    }
}