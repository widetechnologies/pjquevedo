<?php

class fglobal {

    const S_CONTROLE = 1;
    const S_CURSOSFERIAS = 2;
    const S_SEMENG = 3;
    const S_TECNOFACENS = 4;
    const S_HORARIO = 5;
    const S_BOLSA = 6;
    const S_DISPONIBILIDADE = 7;
    const S_MONITORIA = 8;
    const S_CHAMADA = 9;

    /**
     * Retorna o cliente do soap global
     * @return \SoapClient objeto da classe SoapClient
     */
    public static function global_SoapClient() {
        $options = array(
            "location" => "http://172.16.0.120/global/ws.php",
            "uri" => "http://172.16.0.120/global/",
            "trace" => 1
        );

        return new SoapClient(null, $options);
    }

    /**
     * Pega os dados de um operador
     * @param string $operador usuario de login do operador
     * @return object/boolean objeto usuario com as informação do operador
     * ou false em caso de erro ou inexistencia
     */
    public static function global_buscar_operador($operador) {
        $client = self::global_SoapClient();
        return $client->buscar_operador($operador);
    }

    /**
     * Gera um boleto
     * @param string $nome Nome do sacado
     * @param double $valor Valor do boleto (padrão inglês, ex.: 100.00)
     * @param string $dtvenc Data de vencimento do boleto (yyyy-mm-dd)
     * @param int $idsistema Id do sistema (relacionado nas constantes)
     * @param string $comentario Algum comentario sobre o boleto caso queira
     * @return object/boolean dados do boleto em um objeto padrao,
     * ou false em caso de erro
     */
    public static function global_gerar_boleto($nome, $valor, $dtvenc, $idsistema = '', $comentario = '') {
        $client = self::global_SoapClient();
        return $client->gerar_boleto($nome, $valor, $dtvenc, $idsistema, $comentario);
    }

    /**
     * Busca um boleto
     * @param string $reftran codigo completo com 17 digitos  
     * @return object/boolean dados do boleto em um objeto caso exista,
     * ou false caso contrário
     */
    public static function global_buscar_boleto($reftran) {
        $client = self::global_SoapClient();
        return $client->buscar_boleto($reftran);
    }

}
