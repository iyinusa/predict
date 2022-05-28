<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mclub extends CI_Model {
	 
		public function reg_insert($data) {
			$this->db->insert('bz_club', $data);
			return $this->db->insert_id();
		}
		
		public function query_club() {
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('bz_club');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_club_id($data) {
			$query = $this->db->where('id', $data);
			$query = $this->db->get('bz_club');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function update_club($id, $data) {
			$this->db->where('id', $id);
			$this->db->update('bz_club', $data);
			return $this->db->affected_rows();	
		}
		
		public function delete_club($id) {
			$this->db->where('id', $id);
			$this->db->delete('bz_club');
			return $this->db->affected_rows();
		}
	}