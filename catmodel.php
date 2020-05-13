<?php
class cat extends Model{
	protected $table='category';
	public function add($data){
		return $this->db->autoExecute($this->table,$data);
	}
}
?>