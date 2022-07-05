<?php namespace resume\common;

use resume\common\Entity;

class Model {

    protected $host;
    protected $db;
    protected $table;
    protected $username;
    protected $password;

    protected $returnType;
    protected $primaryKey;
    protected $allowedFields;
    protected $createdField;
    protected $modifiedField;
    protected $lastInsertId;

    protected $orderBy;
    protected $where;
    protected $columns = '*';

    private $_conn;

    public function __construct() {
    	$this->initialize();
    }

    public function select($id): array {
    	$ids = $id;
    	if(is_array($id)) {
    		$ids = implode(',', $id);
    	}
    	return $this->_query("
        	SELECT ".$this->columns." 
            FROM ".$this->db.".".$this->table." 
            WHERE ".$this->primaryKey." in (".$ids.")
            " .  $this->orderBy . "
        ;", true);
    }

    public function selectAll(): array {
    	return $this->_query("
        	SELECT ".$this->columns." 
            FROM ".$this->db.".".$this->table."
            " .  $this->where . "
            " .  $this->orderBy . "
        ;", true);
    }

    public function selectRange($limit, $offset): array {
    	return $this->_query("
        	SELECT ".$this->columns." 
            FROM ".$this->db.".".$this->table."
            LIMIT ".$limit.", ".$offset."
            " .  $this->where . "
            " .  $this->orderBy . "
        ;", true);
    }

    public function insert($data): int {
    	if(empty($data)) { return null; }
		if(!$data instanceof $this->returnType && !isAssoc($data)) { return null; }

		$columns = [];
		$values = [];

        foreach($data as $key => $value) {
			if(!empty($this->allowedFields) && !in_array($key, $this->allowedFields)) {
				continue;
			}
        	$columns[] = $key;
        	$values[] = "'" . $value . "'";
        }

    	$result = $this->_query("
        	INSERT INTO ".$this->db.".".$this->table."
        	(".implode(',', $columns).")
        	VALUES (".implode(',', $values).");
        ", true);

		return $this->lastInsertId;
    }

    public function delete($id) {
        $d = $this->_query("
            DELETE 
            FROM ".$this->db.".".$this->table." 
            WHERE ".$this->primaryKey." = ".$id.";
        ", true);
    }

    public function getSchema(): array {
        $schema = [];
        $column;
        $d = $this->_query("
            SELECT COLUMN_NAME,DATA_TYPE 
            FROM information_schema.columns 
            WHERE TABLE_SCHEMA = '".$this->db."' and TABLE_NAME = '".$this->table."';
        ", true);
        foreach($d as $i){            
            foreach($i as $key => $value){
                if($key === 'COLUMN_NAME') {
                    $column = $value;                      
                } else {
                    $schema[$column] = $value;
                }
            }
        }
        return $schema;
    }

    public function order($o) {
    	if(!is_array($o)) { return; }

    	$q = 'ORDER BY ';

    	if(isAssoc($o)){

    		foreach($o as $key => $value){
    			$q .= $key . ' ' . $value . ', ';
    		}
    		$q = strLreplace(', ','', $q);

    	} else {

    		$q .= implode(', ', $o);

    	}

    	$this->orderBy = $q;
    }

    public function columns($c) {
    	$this->columns = $c;
    }

    public function search($s) {
        $this->where = $s;
    }

    protected function initialize() { }

    private function _getColumns(): string {
    	if(!empty($this->allowedFields)){
    		return implode(",", $this->allowedFields);
    	}
    	return '*';
    }

    private function _setFormat(): string {
        $setstring = "";
        foreach(get_object_public_vars($this) as $key => $value){
            if(in_array($key, $this->allowedFields)) {
                if($this->_schema[$key] === 'varchar') {
                    $setstring .= $key." = '".$this->_conn->real_escape_string($value)."', ";
                } else {
                    $setstring .= $key." = ".$value.", ";
                }
            }
        }
        $setstring = rtrim($setstring, ', ');        
        return $setstring;
    }

    private function _open() {
        $this->_conn = new \mysqli($this->host, $this->username, $this->password, $this->db);
    }

    private function _close() {
        $this->_conn->close();
    }

    private function _query($i, $s = false): array {
        if($s) { $this->_open(); }

        $data = [];
        $result = $this->_conn->query($i);
        $this->lastInsertId = $this->_conn->insert_id;

        if(!$result) { return [ $this->_conn->error ]; }
        if($result === true) { return $result; }

        while($row = mysqli_fetch_assoc($result)) {
        	$data[] = (isset($this->returnType)) ? new $this->returnType($row) : $row;
        }

        $result->close(); 
        if($s) { $this->_close(); }

        return $data;
    } 

}

?> 