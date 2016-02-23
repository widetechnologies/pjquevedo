<?php

class exporta {

    private $matricula;
    private $codtur;
    private $codmat;
    private $f;
    private $ad;
    private $num;
    private $situacao;
    private $perletivo;

    function getPerletivo() {
        return $this->perletivo;
    }

    function setPerletivo($perletivo) {
        $this->perletivo = $perletivo;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function getMatricula() {
        return $this->matricula;
    }

    function getCodtur() {
        return $this->codtur;
    }

    function getCodmat() {
        return $this->codmat;
    }

    function getF() {
        return $this->f;
    }

    function getAd() {
        return $this->ad;
    }

    function getNum() {
        return $this->num;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    function setCodtur($codtur) {
        $this->codtur = $codtur;
    }

    function setCodmat($codmat) {
        $this->codmat = $codmat;
    }

    function setF($f) {
        $this->f = $f;
    }

    function setAd($ad) {
        $this->ad = $ad;
    }

    function setNum($num) {
        $this->num = $num;
    }

    function insert() {

        $link = banco::pdoCon();

        $query = "INSERT INTO chamada_exporta (codtur, mataluno, perletivo, codmat, f$this->num, ad$this->num) VALUES
                    (   
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?
                        
                    );";

        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->codtur, $this->matricula, $this->perletivo, $this->codmat, $this->f, $this->ad));
        return $result;
    }

//insert  

    function update() {
        $link = banco::pdoCon();

        $query = "UPDATE chamada_exporta SET f$this->num = ?, ad$this->num = ? WHERE mataluno = ? AND perletivo = ? AND codtur = ?;";

        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($this->f, $this->ad, $this->matricula, $this->perletivo, $this->codtur));
        return $result;
    }

    function procedureExporta($turma, $mes) {
        $link = banco::pdoCon();
        $query = "[192.168.33.228].side.dbo.fac_CarregaFaltasAulasDadasLuiz ?, ?, ?;";
        $stmt = $link->prepare($query);
        $result = $stmt->execute(array($turma, $mes, $this->perletivo));
        return $result;
    }

    function webServiceExporta($turma, $mes) {
        $pagina = "http://192.168.33.228:3000/exporta_chamada/{$this->perletivo}/{$mes}/{$turma}";
        //$pagina = "http://192.168.33.228:3000/teste_chamada/{$this->perletivo}/{$mes}/{$turma}";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $pagina);

// define que o conteúdo obtido deve ser retornado em vez de exibido
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $retorno = curl_exec($ch);

        curl_close($ch);
        if($retorno == "Sucesso"){
            return true;
        }
        return false;
    }

//insert  
}

//exporta
?>