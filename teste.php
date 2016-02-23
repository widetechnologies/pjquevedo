<?php

echo "<pre>";
print_r(PDO::getAvailableDrivers());
echo "</pre>";

//try {
//
//ini_set('display_errors', 1);
//include './class/bd/banco.class.php';
//
////$db = banco::pdoCon();
//$dbm = new PDO ("sqlsrv:server=192.168.33.191; Database=LEC", "rm", "rm");
////$dbm = new PDO("dblib:host=192.168.33.191;dbname=Contratos", 'rm', 'rm'); 
//
//function findAll(){
//    
//    global $db;
//    $stmt = $db->query("SELECT * FROM usuario");
//   
//    $list = array();
//    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//        $list[] = $row;
//    }
//    return $list;
//}
//
//function findById($id){
//    global $db;
//    //$stmt = $db->query("SELECT * FROM usuario where id = $id");
//    $stmt = $db->prepare("SELECT * FROM usuario where id = :id");
//    $stmt->execute(array(':id' => $id));
//    $row = $stmt->fetch(PDO::FETCH_ASSOC);
//    return $row;
//}
//
//function insert(){
//    global $db;
//    $result = $db->exec("insert into usuario(usuario, nome, senha, tipo) values('teste', 'teste', md5('teste'),1);");
//    return $db->lastInsertId();
//}
//
//function update($id, $nome){
//    global $db;
//    $result = $db->exec("update usuario set nome = '$nome' where id = $id");
//    return $result;
//}
//
//function delete($id){
//    global $db;
//    $result = $db->exec("delete from usuario where id = $id");
//    return $result;
//}
//
//
//    
////    echo ' <hr>MySQL';
////    echo "<pre>";
////    print_r(findById(1));
////    echo "</pre>";
//    $query = 'select * from vw_horario Where id_horario = ?;';
//    //$stmt = $dbm->query('select * from vw_horario Where id_horario = 2101;');
//    
//    $stmt = $dbm->prepare($query);
//
//		$stmt->execute(array(2101));
//                
//    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    
//    echo "<hr>SQLServer<pre>";
//    print_r($list);
//    echo "</pre>";
//    
//
//} catch (PDOException $ex) {
//    echo $ex->getMessage();
//}