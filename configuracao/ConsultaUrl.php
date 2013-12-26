<?php

class ConsultaUrl {

    public static function consulta($pagina) {
        $controlador = fopen("/var/www/PIP/assets/txt/urls.php", "r");
        $resultado = NULL;
        if ($controlador) {
            $pesquisando = true;
            while (!feof($controlador) && $pesquisando) {
                $urlinfo = fscanf($controlador, "%s\t%s\n");
                if ($pagina == $urlinfo[0]) {
                    $pesquisando = false;
                    $resultado = $urlinfo[1];
                }
            }
        }
        fclose($controlador);
        return $resultado;
    }

}
