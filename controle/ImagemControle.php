<?php

include_once 'modelo/Imagem.php';
include_once 'configuracao/UploadHandler.php';

class ImagemControle extends UploadHandler {

    private $parametros;
    private $idImagem;

    public function __construct($parametros = NULL) {
        $this->parametros = $parametros;
        parent::__construct(array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
            'user_dirs' => true,
            //'download_via_php' => true,
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
            'upload_dir' => dirname($_SERVER["SCRIPT_FILENAME"]) . '/fotos/',
            'upload_url' => dirname($_SERVER["HTTP_REFERER"]) . '/fotos/',
        ));
    }

    protected function handle_form_data($file, $index) {
        //var_dump(2);
        $file->legenda = $this->parametros["txtLegenda" . $index];
        $file->idImagem = '';
    }

    public function delete($print_response = true) {
        parent::delete();

        //var_dump(4);
        exit();
        $genericoDAO = new GenericoDAO();
        $imagem = new Imagem();
        //var_dump($file);
        $resultado = $genericoDAO->consultar($imagem, false, array("id" => $this->idImagem));

        $file_name = isset($_REQUEST['file']) ?
                basename(stripslashes($_REQUEST['file'])) : null;

        $file_path = $this->options['upload_dir'] . $file_name;
        $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
        $deleta = "DELETE FROM fotos WHERE imagemP = '$file_name'";
        $executa = mysql_query($deleta) or die(mysql_error());
        if ($success) {
            foreach ($this->options['image_versions'] as $version => $options) {
                $file = $options['upload_dir'] . $file_name;
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        header('Content-type: application/json');
        echo json_encode($success);
        die();
        $response = parent::delete(false);
        foreach ($response as $name => $deleted) {
            /* if ($deleted) {
              $sql = 'DELETE FROM `'
              .$this->options['db_table'].'` WHERE `name`=?';
              $query = $this->db->prepare($sql);
              $query->bind_param('s', $name);
              $query->execute();
              } */
            #sql para excluir
        }
        return $this->generate_response($response, $print_response);
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null, $content_range = null) {
        //var_dump(1);
        $file = parent::handle_file_upload(
                        $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        if (empty($file->error)) {
            $genericoDAO = new GenericoDAO();
            $imagem = new Imagem();
            $entidadeImagem = $imagem->cadastrar($this->parametros, $file);
            $idImagem = $genericoDAO->cadastrar($entidadeImagem);
            //var_dump($idImagem);
            $file->idImagem = $idImagem;
            $file->id = $idImagem;
        }
        return $file;
    }

    protected function set_additional_file_properties($file) {
        //var_dump(3);
        parent::set_additional_file_properties($file);
        //$genericoDAO = new GenericoDAO();
        //$imagem = new Imagem();
        //var_dump($file);
        //$resultado = $genericoDAO->consultar($imagem, false, array("id" => $file->idImagem));
        //var_dump($resultado);
        //$file->id = $resultado[0]->getId();
        //$file->legenda = $resultado[0]->getLegenda();
        //var_dump($file);
        //$file->deleteUrl = 'index.php?hdnEntidade=Imagem&hdnAcao=excluir&idImagem=11'.$file->idImagem.'&files='.rawurlencode($file->name);
        //var_dump($file);
    }
}
