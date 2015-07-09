<?php
class db{
	protected $tblName;			//用來讓子類別繼承設定table名稱用
	private $_table = NULL;			//table名稱
	private $_history = array();	//資料庫使用記錄
	private $_query_count=0;		//下query的次數
	private $_mc;				//memcache
	private $_select = array();	//搜尋欄位
	private $_where;			//搜尋條件
	private $_order;			//排序
	private $_limit;			//limit 個數
	private $_offset;			//limit 起始位置
	private $_join = array();	//join的table
	private $_mysql_link_read;	//讀取資料庫的連線
	private $_mysql_link_write;	//寫入資料庫的連線
	
	public function __construct(){	
		if(isset($this->tblName))
			$this->setTable($this->tblName);

		$this->init();
	}
	
	protected function init(){}	//給子類別做初始化
	
	private function connectReadLink(){
		if(empty($this->_mysql_link_read)){
			$this->_mysql_link_read = new PDO('mysql:host='.READ_HOST.';dbname='.READ_DB.';charset=utf8', 
				READ_USER, 
				READ_PSW, 
				array(
					PDO::ATTR_PERSISTENT => true,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
				)
			);
		}
	}
	
	private function connectWriteLink(){
		if(empty($this->_mysql_link_write)){
			$this->_mysql_link_write = new PDO('mysql:host='.WRITE_HOST.';dbname='.WRITE_DB, 
				WRITE_USER, 
				WRITE_PSW, 
				array(
					PDO::ATTR_PERSISTENT => true,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
				)
			);
		}
	}
	
	private function connectMemcache(){
		//memcache連線
		$this->mc = new Memcache;
		$this->mc->connect(MEMCACHE_HOST, MEMCACHE_PORT) or die ("Could not connect");
	}
	
	public function setTable($table){
		$this->_table = DB_PREFIX . $table;
		return $this;
	}
	
	public function getTable(){
		return $this->_table;
	}
	
	public function select($cols){
		unset($this->_select);
		$this->_select = array();
		
		if(!is_array($cols)){
			$cols = explode(',',$cols);
		}
		
		while(list($keys,$vars) = each($cols)){
			if(!is_numeric($keys))
				$this->_select[] = "{$vars} as {$keys}";
			else
				$this->_select[] = $vars;
		}

		return $this;
	}
	
	public function where($condition, $value = null, $bool = true){
		unset($this->_where);
		$this->_where = array();
		$this->_where[] = array($this->quoteInto($condition, $value),$bool);
		return $this;
	}
	
	public function orWhere($condition, $value = null, $bool = false){	
		$this->_where[] = array($this->quoteInto($condition, $value),$bool);
		return $this;
	}
	
	public function andWhere($condition, $value = null, $bool = true){	
		$this->_where[] = array($this->quoteInto($condition, $value),$bool);
		return $this;
	}
	
	public function whereIn($condition, $value, $bool = true){
		unset($this->_where);
		$this->_where = array();
		foreach($value as &$val){
			$val = $this->quote($val);
		}
		$this->_where[] = array("{$condition} IN (".join(',',$value).")",$bool);
		return $this;
	}
	
	public function orWhereIn($condition, $value, $bool = false){
		foreach($value as &$val){
			$val = $this->quote($val);
		}
		$this->_where[] = array("{$condition} IN (".join(',',$value).")",$bool);
		return $this;
	}
	
	public function andWhereIn($condition, $value, $bool = true){
		foreach($value as &$val){
			$val = $this->quote($val);
		}
		$this->_where[] = array("{$condition} IN (".join(',',$value).")",$bool);
		return $this;
	}
	
	public function order($order){
		$this->_order = $order;
		return $this;
	}
	
	public function limit($limit){
		$this->_limit = $limit;
		return $this;
	}
	
	public function offset($offset){
		$this->_offset = $offset;
		return $this;
	}
	
	public function innerJoin($tblName, $condition, $value=NULL){	
		$this->_join($tblName, $condition, $value, 'inner');
		return $this;
	}
	
	public function leftJoin($tblName, $condition, $value=NULL){	
		$this->_join($tblName, $condition, $value, 'left');
		return $this;
	}
	
	public function fetch($mc = false){
		$this->limit(1);
		$rows = $this->query(NULL, $mc);
		if(!empty($rows[0]))
			return $rows[0];
		else
			return false;
	}
	
	public function fetchAll($mc = false){
		return $this->query(NULL, $mc);
	}
	
	public function count($mc = false){
		$sql = "SELECT count(123) as `totalrecord`";
		$sql .= $this->_getTable();
		$sql .= $this->_getJoin();
		$sql .= $this->_getWhere();
		$rows = $this->query($sql, $mc);
		return $rows[0]['totalrecord'];
	}
	
	public function isExist($mc = false){
		return ($this->count($mc))? true:false;
	}
	
	public function toString(){
		$sqlQuery = $this->_getSelect();
		$sqlQuery .= $this->_getTable();
		$sqlQuery .= $this->_getJoin();
		$sqlQuery .= $this->_getWhere();
		$sqlQuery .= $this->_getOrder();
		$sqlQuery .= $this->_getLimit();
		return $sqlQuery;
	}
		
	public function query($query="", $mc=false){				
		if(!empty($query)){
			$sqlQuery = "{$query}";
		}else{
			$sqlQuery = $this->_getSelect();
			$sqlQuery .= $this->_getTable();
			$sqlQuery .= $this->_getJoin();
			$sqlQuery .= $this->_getWhere();
			$sqlQuery .= $this->_getOrder();
			$sqlQuery .= $this->_getLimit();
		}

		if(IS_MEMCACHE && $mc){
			if(empty($this->mc)) $this->connectMemcache();
		
			$key = md5($sqlQuery);
			if(!($rowset = $this->mc->get($key))){
				$rowset = $this->_query($sqlQuery);
				$this->mc->add($key, $rowset);
				return $rowset;
			}
		}else{
			return $this->_query($sqlQuery);
		}
	}
	
	public function debug(){
		$text = "no sql query";
		if($this->_query_count){
			$text = '<p>&nbsp;</p><table width="95%" align="center" cellspacing="0" cellpadding="2" border=1><tr><td>&nbsp;SQL query</td></tr>';
			for($i=0;$i<$this->_query_count;$i++){
				$text .= '<tr>';
				$text .= '<td>&nbsp;'.$this->_history["query"][$i].'</td>';
				$text .= "</tr>";
			}
			$text .= '<tr><td>count:'.$this->_query_count.'</td></tr>';
			$text .= '</table>';
		}
		echo $text;
		return;
	}
	
	public function insert($rows){
		$rows = $this->quoteArray($rows);
		$sql = "INSERT INTO `".$this->_table."`";
		$sql.= " ( ".join(',',array_keys($rows))." ) ";
		$sql .= " values( ".join(",",array_values($rows)).")";
		$this->execute($sql);
		
		return $this->_mysql_link_write->lastInsertId();	//會回傳剛剛新增的id
	}
	
	//資料更新 第一個欄位可以直接給完整的sql語法
	public function update($rows, $condition = null, $value = null){
		$sql="";
		if(is_array($rows)){
			$rows = $this->quoteArray($rows);
			$key =array_keys($rows);
			for($i=0;$i<sizeof($key);$i++){
				if($i > 0) $sql .=",";
				$sql .= $key[$i]."=".$rows[$key[$i]];
			}
		}else{
			$sql = $rows;
		}
		
		if(!empty($condition))
			$where = 'WHERE '.$this->quoteInto($condition,$value);
		
		$sql="UPDATE `".$this->_table."` SET ".$sql." ".$where;
		$this->execute($sql);
	}
	
	public function delete($condition = null, $value = null){
		$sql = "DELETE FROM ".$this->_table.' WHERE '.$this->quoteInto($condition,$value);
		return $this->execute($this->SqlMsg);
	}
	
	private function execute($query){				
		if(empty($query)){
			throw new Exception('SQL can\'t be empty.');
		}

		try{
			$this->writeSqlHistory($query);
			$this->connectWriteLink();
			$sth = $this->_mysql_link_write->prepare($query);
			$sth->execute();
		}catch(Exception $e){
			$this->error($e);
		}
	}
	
	private function _query($sqlQuery){
		$this->writeSqlHistory($sqlQuery);
		$rowset = array();
		
		$this->connectReadLink();
		
		try{
			$sth = $this->_mysql_link_read->prepare($sqlQuery);
			$sth->execute();
			$rowset = $sth->fetchAll(PDO::FETCH_ASSOC);
		}catch(Exception $e){
			$this->error($e);
		}
		
		return $rowset;
	}
	
	private function _join($tblName, $condition, $value, $method){
		$this->_join[] = array($tblName, $this->quoteInto($condition, $value), $method);
	}
	
	private function _getSelect(){
		return 'SELECT '. (empty($this->_select)? '*' : join($this->_select,','));
	}
	
	private function _getTable(){
		if(!empty($this->_table)){
			return ' FROM `'.$this->_table.'`';
		}
		return '';
	}
	
	private function _getJoin(){
		if(!empty($this->_join)){
			$query = '';
			foreach($this->_join as $join){
				$query .= ' '.$join[2].' join `' . $join[0] . '` on '. $join[1];
			}
			return $query;
		}
		return '';
	}
	
	private function _getWhere(){
		$query = '';
		if(!empty($this->_where)){
			foreach($this->_where as $where){
				$query .= (!empty($query))? (($where[1])? ' AND ' . $where[0]:' OR ' . $where[0]) : $where[0];  
			}
			return ' WHERE ' .$query;
		}
		return '';
	}
	
	private function _getOrder(){
		if(!empty($this->_order)){
			return ' ORDER BY '.$this->_order;
		}
		return '';
	}
	
	private function _getLimit(){
		if(!empty($this->_limit)){
			return ' LIMIT ' . ((!empty($this->_offset))? $this->_offset.',':'') . $this->_limit;
		}
		return '';
	}
	
	private function error($e){
		$this->debug();
		echo 'MySQL error:'.$e->getMessage();
		exit;
	}

	private function writeSqlHistory($query=""){
		$this->_history["query"][$this->_query_count] = $query;
		$this->_query_count++;
	}
	
	private function quoteArray($rows) {
		$fields= array_keys($rows);
		foreach( $fields as $v ) {
			if( array_key_exists($v,$rows) ) {
				$new[$v] = substr($rows[$v],0,1)=="~"?substr($rows[$v],1):$this->quote($rows[$v]);
			}
		}
		return $new;
	}
	
	protected function quote($value)
    {
		if (is_array($value)) {
            foreach ($value as &$val) {
                $val = $this->quote($val);
            }
            return implode(', ', $value);
        }
		
        if (is_int($value)) {
            return $value;
        } elseif (is_float($value)) {
            return sprintf('%F', $value);
        } elseif (is_numeric($value)){
			return "'" . $value . "'";
		}
        return "'" . addcslashes($value, "\000\n\r\\'\"\032") . "'";
    }
	
	public function quoteInto($text, $value){
		
		if (!is_array($value)) {
            return str_replace('?', $this->quote($value), $text);
        } else {
			foreach ($value as &$val) {
				if (strpos($text, '?') !== false) {
                    $text = substr_replace($text, $this->quote($val), strpos($text, '?'), 1);
                }				
            }
            return $text;
			
        }
    }
	
	public function begin(){
		
	}
}
?>