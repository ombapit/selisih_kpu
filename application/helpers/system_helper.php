<?php
function get_name($table,$id,$field_id,$field_name) {
	$CIobj = & get_instance();
	$CIobj->db->where($field_id,$id);
	$q = $CIobj->db->get($table);
	$res = $q->row_array();
	return $res[$field_name];
}