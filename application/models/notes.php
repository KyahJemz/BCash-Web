<?php

// DATABASE READ
    $this->db->select('*');
    $this->db->from('table_name');
    $this->db->where('column_name','values');
    $result = $this->db->get();

// DATABASE UPDATE
    $data = [
        'column_name1' => 'new_value1',
        'column_name2' => 'new_value2'
    ];
    
    $this->db->where('column_name', 'values');
    $this->db->update('table_name', $data);
    
// DATABASE CREATE
    $data = [
        'column_name1' => 'value1',
        'column_name2' => 'value2'
    ];
    $this->db->insert('table_name', $data);
?>