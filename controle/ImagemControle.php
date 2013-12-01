<?php

include_once 'modelo/Imagem.php';
include_once 'DAO/GenericoDAO.php';

class ImagemControle {

    function upload($parametros) {
        //modelo
        require('configuracao/UploadHandler.php');
       
        $upload_handler = new UploadHandler(array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
            'user_dirs' => true,
            //'download_via_php' => true,
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
            'upload_dir' => dirname($_SERVER["SCRIPT_FILENAME"]) . '/fotos/',
            'upload_url' => dirname($_SERVER["HTTP_REFERER"]) . '/fotos/'
            
        ));
        #Salvar no Banco
        die();
    }
}
