<?php

class CEP {

    private $cep;
    private $urlCorreios = "http://www.buscacep.correios.com.br/servicos/dnec/consultaLogradouroAction.do";
    private $urlRepublica = "http://republicavirtual.com.br/web_cep.php?formato=query_string&cep="; //passar o valor do cep na url

    public function __construct($cep) {
        $cep = str_replace('.', '', str_replace('-', '', $cep)); //retira o ponto e traco
        $this->cep = $cep;
    }

    public function buscar() {
        if (strlen($this->cep) <> 8)
            return false;

        $resultadoCEP = $this->CurlCorreios(); //primeira opcao
        if (!$resultadoCEP) {
            $resultadoCEP = $this->WebserviceRepublica(); //contingencia
        }
        return $resultadoCEP;
    }

    public function CurlCorreios() {
        if (function_exists("curl_init")) {
            $cURL = curl_init($this->urlCorreios);
            if (is_resource($cURL)) {
                $post = 'CEP=' . $this->cep . '&Metodo=listaLogradouro&TipoConsulta=cep';
                curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($cURL, CURLOPT_HEADER, 0);
                curl_setopt($cURL, CURLOPT_POST, 1);
                curl_setopt($cURL, CURLOPT_POSTFIELDS, $post);
                curl_setopt($cURL, CURLOPT_ENCODING, "UTF-8");
                $saida = curl_exec($cURL);
                curl_close($cURL);
                $saida = utf8_encode($saida);
                preg_match_all('@<td (.*?)<\/td>@i', $saida, $tabela);
                $tabela = $tabela[0];
                //echo "<pre>";            print_r($tabela);            echo "</pre>";
                if (is_array($tabela) && !empty($tabela)) {
                    $resultado['logradouro'] = strip_tags($tabela[0]);
                    $resultado['bairro'] = strip_tags($tabela[1]);
                    $resultado['cidade'] = strip_tags($tabela[2]);
                    $resultado['uf'] = strip_tags($tabela[3]);
                    //var_dump($resultado);
                    return $resultado;
                } else
                    return false;
            }
            return $cURL;
        } else
            return false;
    }

    public function WebserviceRepublica() {
        //$codificado = array_map('htmlentities',$retorno);//transcodifica para mostrar a acentuacao em HTML como vai ser em um campo de formulario nao precisa
        $resultado = @file_get_contents($this->urlRepublica . $this->cep); //webservice que retorna os dados do endereco

        if (is_string($resultado)) {
            $resultado = utf8_encode(urldecode($resultado)); //faz a conversao de urlcoding para utf8
            parse_str($resultado, $retorno); //armazear o resultado em uma string $retorno
        }

        //var_dump($retorno);
        if (is_array($resultado) && !empty($resultado)) {
            $resultado['logradouro'] = $retorno['tipo_logradouro'] . ' ' . $retorno['logradouro'];
            $resultado['bairro'] = $retorno['bairro'];
            $resultado['cidade'] = $retorno['cidade'];
            $resultado['uf'] = $retorno['uf'];
            return $resultado; //retorna o resultado da pesquisa CEP
        } else
            return false;
    }

}

?>
