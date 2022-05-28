<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mfixture extends CI_Model {
	 
		public function reg_insert($data) {
			$this->db->insert('bz_fixture', $data);
			return $this->db->insert_id();
		}
		
		public function check_by_cat($cat) {
			$query = $this->db->get_where('bz_fixture', array('cat' => $cat));
			return $query->num_rows();
		}
		
		public function query_fixture() {
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('bz_fixture');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_fixture_id($data) {
			$query = $this->db->where('id', $data);
			$query = $this->db->get('bz_fixture');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function update_fixture($id, $data) {
			$this->db->where('id', $id);
			$this->db->update('bz_fixture', $data);
			return $this->db->affected_rows();	
		}
		
		public function delete_fixture($id) {
			$this->db->where('id', $id);
			$this->db->delete('bz_fixture');
			return $this->db->affected_rows();
		}
	}