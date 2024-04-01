<?php

class Tweet {
    public $ID_Tweet;
    public $ID_Usuario;
    public $Contenido;
    public $FechaPublicacion;
    public $Likes;
    public $Retweets;
    
    public function __construct($ID_Usuario, $Contenido) {
        $this->ID_Usuario = $ID_Usuario;
        $this->Contenido = $Contenido;
    }
}