<?php 
class user extends db{
	protected $tblName = 'user';
	function init(){

	}
	
	function get($fbID){
		return $this->select('id,account,password')->where('fb_id = ?',$fbID)->fetch();
	}

	function newUser($data){
		$data['created_at'] = '~NOW()';
		$this->insert($data);
		return $this->get($data['fb_id']);
	}
	
	function getList($offset=0){
		return $this->select('id,id,account,password,login_at,nickname')->fetchAll();
	}
	
	function getAmount(){
		return $this->count();
	}
	
	function filter($filter){
		foreach($filter as $key => $val){
			if(!empty($val)){
				if(is_numeric($val))
					$this->andWhere("{$key}=?", $val);
				else
					$this->andWhere("{$key} LIKE ?", $val);
			}
		}
		return $this;
	}
}
?>
