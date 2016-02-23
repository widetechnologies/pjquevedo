<?php

$base = parse_ini_file('../../config/conf.ini',true);
$base = $base['dblocal'];

define('DB_HOST', $base['host']);
define('DB_USER', $base['user']);
define('DB_PASS', $base['password']);
define('DB_BASE', $base['database']);

class Settings {

    public static $validator_written = false;

}

class TableDescriptor {

    private $table;
    private $dblink;
    private $columns = array();
    private $primary_key;

    public function __construct($table) {
        $this->table = $table;
        if ($this->Connect()) {
            $this->Load();
        }
    }

    public function __destruct() {
        if (is_resource($this->dblink)) {
            mysql_close($this->dblink);
        }
    }

    public function Connect() {
        if ($this->table != '') {
            return $this->getDbLink();
        }
    }

    public function Query($q) {
        $result = mysql_query($q, $this->Connect());
        return $result;
    }

    public function GetRow($r) {
        return mysql_fetch_assoc($r);
    }

    public function getDbLink() {
        if (!is_resource($this->dblink)) {
            $dblink = mysql_connect(DB_HOST, DB_USER, DB_PASS);
            mysql_select_db(DB_BASE);
            $this->dblink = $dblink;
        }
        return $this->dblink;
    }

    public function AddColumn($column) {
        $pattern = "([a-z]{1,})[\(]{0,}([0-9]{0,})[\)]{0,}";
        $matches = array();
        ereg($pattern, $column['Type'], $matches);
        $column['Type'] = $matches[1];
        $column['Length'] = $matches[2];
        $this->columns[] = $column;
        if ($column['Key'] == 'PRI'){
            $this->primary_key = $column['Field'];
        }
    }

    public function getTable() {
        return $this->table;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getPrimaryKey() {
        return $this->primary_key;
    }

    public function Load() {
        $query = "SHOW COLUMNS FROM {$this->getTable()}";
        $result = $this->Query($query);
        while ($row = $this->GetRow($result)) {
            $this->AddColumn($row);
        }
    }

}

class ClassBuilder {

    private $buffer;
    private $validate;
    private $table_descriptor;
    private $variable_types = array(
        "int" => "int",
        "text" => "string",
        "bool" => "bool",
        "date" => "int",
        "blob" => "int",
        "float" => "int",
        "double" => "int",
        "decimal" => "int",
        "bigint" => "int",
        "tinyint" => "int",
        "longint" => "int",
        "varchar" => "string",
        "smallint" => "int",
        "datetime" => "string",
        "timestamp" => "string",
        "time" => "string"
    );

    public function __construct($table = '', $validate = false) {
        $this->table_descriptor = new TableDescriptor($table);
        $this->validate = $validate;
        $this->Load();
    }

    private function Load() {
        $buf = "";
        $buf .= "/*\n";
        $buf .= "*Classe " . $this->table_descriptor->getTable() . "\n";
        $buf .= "*/\n\n";
        $buf .= "include_once 'bd/banco.class.php'; \n\n";
        $buf .= "class {$this->table_descriptor->getTable()}{\n\n";

        foreach ($this->table_descriptor->getColumns() as $column) {
            $column_name = str_replace('-', '_', $column['Field']);
            $buf .= "\tprivate \$$column_name;\n";
        }
        $buf .= "\n";

        if ($this->table_descriptor->getPrimaryKey() != '') {
            $pk = $this->table_descriptor->getPrimaryKey();
            $buf .= "\tpublic function __construct(\$$pk='')\n";
            $buf .= "\t{\n";
            $buf .= "\t\t\$this->{$pk} = \$$pk;\n";
            //$buf .= "\t\t\$this->Load();\n";
            $buf .= "\t}\n\n";

            $buf .= "\tpublic function select()\n";
            $buf .= "\t{\n\n";
            $buf .= "\t\t\$link = banco::pdoCon();\n";
            //$buf .= "\t\t\$this->$pk = mysqli_real_escape_string(\$link, \$this->$pk);\n\n";
            $buf .= "\t\t\$query = \"SELECT * FROM " . $this->table_descriptor->getTable() . " WHERE $pk = ?;\";\n";
            $buf .= "\t\t\$stmt = \$link->prepare(\$query);\n\n";
            $buf .= "\t\t\$result = \$stmt->execute(array(\$this->$pk));\n\n";          
            $buf .= "\t\tif(\$result) {\n";
            $buf .= "\t\t\twhile(\$row = \$stmt->fetch(PDO::FETCH_ASSOC) ){\n";
            $buf .= "\t\t\t\tforeach(\$row as \$key => \$value)\n";
            $buf .= "\t\t\t\t{\n";
            $buf .= "\t\t\t\t\t\$column_name = str_replace('-','_',\$key);\n";
            $buf .= "\t\t\t\t\t\$this->\$column_name = \$value;\n\n";
            $buf .= "\t\t\t\t}\n";
            $buf .= "\t\t\t}\n";
            $buf .= "\t\t\treturn true;\n";
            $buf .= "\t\t}\n";
            $buf .= "\t\treturn false;\n";
            $buf .= "\t}\n\n";

            $buf .= "\tpublic function selectAll()\n";
            $buf .= "\t{\n";
            $buf .= "\t\t\$link = banco::pdoCon();\n";
            $buf .= "\t\t\$list = array();\n";
            $buf .= "\t\t\$query = \"SELECT * FROM " . $this->table_descriptor->getTable() . ";\";\n\n";
            $buf .= "\t\t\$stmt = \$link->query(\$query);\n\n";
            $buf .= "\t\twhile(\$row = \$stmt->fetch(PDO::FETCH_ASSOC) ){\n";
            $buf .= "\t\t\$item = new {$this->table_descriptor->getTable()}();\n";
            $buf .= "\t\t\tforeach(\$row as \$key => \$value)\n";
            $buf .= "\t\t\t{\n";
            $buf .= "\t\t\t\t\$column_name = str_replace('-','_',\$key);\n";
            $buf .= "\t\t\t\t\$item->\$column_name = \$value;\n\n";
            $buf .= "\t\t\t}\n";
            $buf .= "\t\t\$list[] = \$item;\n\t\t}\n";
            $buf .= "\t\treturn \$list;\n";
            $buf .= "\t}\n\n";

            $update_columns = "";
            $colunas = "";
            foreach ($this->table_descriptor->getColumns() as $column) {
                if ($column['Field'] != $this->table_descriptor->getPrimaryKey()) {
                    $column_name = str_replace('-', '_', $column['Field']);
                    $update_columns .= "\n\t\t\t\t\t\t{$column['Field']} = ?,";
                    $colunas .= "\$this->$column_name,";
                }
            }
            $update_columns = rtrim($update_columns, ',');
            $colunas = rtrim($colunas, ',');

            $buf .= "\tpublic function update()\n";
            $buf .= "\t{\n\n";
            $buf .= "\n\t\t\$link = banco::pdoCon();\n";
            
            //adicionando os tratamentos de sql injection
//            foreach ($this->table_descriptor->getColumns() as $column) {
//                if ($column['Field'] != $this->table_descriptor->getPrimaryKey()) {
//                    $column_name = str_replace('-', '_', $column['Field']);
//                    $buf .= "\t\t\$this->$column_name = mysqli_real_escape_string(\$link, \$this->$column_name);\n";
//                }
//            }

            $buf .= "\t\t\$query = \"UPDATE " . $this->table_descriptor->getTable() . " SET $update_columns \n\t\t\t\t\t\tWHERE $pk='\$this->$pk';\";\n\n";
            $buf .= "\t\t\$stmt = \$link->prepare(\$query);\n\n";
            $buf .= "\t\t\$result = \$stmt->execute(array($colunas));\n\n";
            $buf .= "\t\treturn \$stmt->result();\n";
            $buf .= "\t}\n\n";

            $buf .= "\tpublic function delete()\n";
            $buf .= "\t{\n\n";
            //$buf .= "\t\t\$this->$pk = mysqli_real_escape_string(\$this->$pk);\n\n";
            $buf .= "\t\t\$link = banco::pdoCon();\n";
            $buf .= "\t\t\$query = \"DELETE FROM " . $this->table_descriptor->getTable() . " WHERE $pk = ?;\";\n";
        
            $buf .= "\t\t\$stmt = \$link->prepare(\$query);\n\n";
            $buf .= "\t\t\$result = \$stmt->execute(array(\$this->$pk));\n\n";
            $buf .= "\t\treturn \$result;\n";
            $buf .= "\t}\n\n";
        }

        $insert_columns = "";
        $insert_values = "";
        $colunas = "";
        foreach ($this->table_descriptor->getColumns() as $column) {
            if ($column['Field'] != $this->table_descriptor->getPrimaryKey()) {
                $column_name = str_replace('-', '_', $column['Field']);
                $insert_columns .= "{$column['Field']},";
                $insert_values .= "?,";
                $colunas .= "\$this->$column_name,"; 
            }
        }
        $insert_columns = rtrim($insert_columns, ',');
        $insert_values = rtrim($insert_values, ',');
        $colunas = rtrim($colunas, ',');

        $buf .= "\tpublic function insert()\n";
        $buf .= "\t{\n\n";
        $buf .= "\n\t\t\$link = banco::pdoCon();\n";
        
//        foreach ($this->table_descriptor->getColumns() as $column) {
//            if ($column['Field'] != $this->table_descriptor->getPrimaryKey()) {
//                $column_name = str_replace('-', '_', $column['Field']);
//                $buf .= "\t\t\$this->$column_name = mysqli_real_escape_string(\$link, \$this->$column_name);\n";
//            }
//        }
        
        
        $buf .= "\t\t\$query =\"INSERT INTO {$this->table_descriptor->getTable()} ($insert_columns) VALUES ($insert_values);\";\n";
        $buf .= "\t\t\$stmt = \$link->prepare(\$query);\n";
        $buf .= "\t\t\$result = \$stmt->execute(array($colunas));\n";
        $buf .= "\t\t\$this->id = \$link->lastInsertId();\n";
         $buf .= "\t\treturn \$result;\n";
        $buf .= "\t}\n\n";

        foreach ($this->table_descriptor->getColumns() as $column) {
            $column_name = str_replace('-', '_', $column['Field']);
            $column_name_uc = ucfirst($column_name);
            $buf .= "\tpublic function set$column_name_uc(\$$column_name='')\n";
            $buf .= "\t{\n";
            if ($this->validate) {
                $buf .= "\t\tif(validate::is{$this->variable_types[$column['Type']]}(\$$column_name))\n";
                $buf .= "\t\t{\n";
                $buf .= "\t\t\t\$this->$column_name = \$$column_name;\n";
                $buf .= "\t\t\treturn true;\n";
                $buf .= "\t\t}\n";
                $buf .= "\t\treturn false;\n";
            } else {
                $buf .= "\t\t\$this->$column_name = \$$column_name;\n";
                $buf .= "\t\treturn true;\n";
            }
            $buf .= "\t}\n\n";

            $buf .= "\tpublic function get$column_name_uc()\n";
            $buf .= "\t{\n";
            $buf .= "\t\treturn \$this->$column_name;\n";
            $buf .= "\t}\n\n";
        }

        $buf .= "}\n";
        $this->buffer = $buf;

        $classe = "<?php \n $buf ?>";
        $fp = fopen("{$this->table_descriptor->getTable()}.class.php", "a");
        fwrite($fp, "{$classe}");
        fclose($fp);
    }

    public function Get() {
        return $this->buffer;
    }

}

$dblink = mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db(DB_BASE, $dblink);
$query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . DB_BASE . "'";
$result = mysql_query($query, $dblink);
$new_classes = array();
//echo "<?\n";

while ($row = mysql_fetch_assoc($result)) {
    $tablename = $row['TABLE_NAME'];
    $new_classes[strtolower($tablename)] = "$tablename";
    if((isset($_POST['gerar']) && isset($_POST[$tablename])) || isset($_POST['gerartodas'])){
        $c = new ClassBuilder($tablename, false);
        $c->Get();
    }
}

?>
<html>
    <body>
        <form method="post">
            <?php foreach ($new_classes as $key => $value): ?>
            <label><input type="checkbox" name="<?php echo $value?>"/><?php echo $value?></label><br>
            <?php endforeach; ?><br>
            <input type="submit" name="gerar" value="Gerar classes selecionadas" />
            <input type="submit" name="gerartodas" value="Gerar todas as classes" />
        </form>
    </body>
</html>

