<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class group_action_model extends CI_Model{

	// la base
	var $DB_NAME='group_action';

	function __construct()
    {
        parent::__construct();
    }



	public function isAllow($path,$groups){
		if(empty($groups)){
			return false;
		}
        $sql="select count(*) as nb
				from group_action as ga
				INNER JOIN acl_action a ON a.`id` = ga.`id_action`
				WHERE a.`path` = '".$path."'
				AND ga.`id_group` IN (".implode(',', $groups).")";
        $res = $this->db->query($sql)->result();
		return $res[0]->nb > 0;


	}

	function open($id){
        $this->db->where('id', $id);
        return $this->db->get($this->DB_NAME)->result();
    }
    
    function getAll() {
        return $this->db->select('*')->from($this->DB_NAME)->order_by("id", "desc")->get()->result();
    }

    function count($where = array()) {
        return (int) $this->db->where($where)->count_all_results($this->DB_NAME);
    }

    function openWhere($where=array()){
        $this->db->where($where);
        return $this->db->get($this->DB_NAME)->result();
    }
    
    function insert($data){
        $this->db->insert($this->DB_NAME, $data);
        return $this->db->insert_id();
    }

    function update($id,$data)
    {
        $this->db->update($this->DB_NAME, $data, array('id' => $id));
    }

    function deleteWhere($where){
        $this->db->where($where);
        $this->db->delete($this->DB_NAME);
    }

    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->DB_NAME);
    }

}