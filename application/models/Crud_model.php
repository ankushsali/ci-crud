<?php  
class Crud_model extends CI_Model {
  public function get_entries()
  {
    $query = $this->db->order_by('id', 'asc')->get('user');
    if (count($query->result()) > 0) {
      return $query->result();
    }
  }

  public function insert_entry($data)
  {
    return $this->db->insert('user', $data);
  }

  public function delete_entry($id) {
    return $this->db->delete('user', array('id' => $id));
  }

  public function single_entry($id) {
    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('id', $id);
    $query = $this->db->get();
    if (count($query->result()) > 0) {
      return $query->row();
    }
  }

  public function update_entry($data)
  {
    return $this->db->update('user', $data, array('id' => $data['id']));
  }
}
?>