<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Common_Model extends MY_Model {

	public function __construct() {

        parent::__construct();

    }


	public function get_row_count($table, $where , $column = NULL)
    {

        if ($column) {
            $this->db->select($column);
        }

        $this->db->where($where);

        $res = $this->db->get($table);


        if (!empty($res))

            return $res->num_rows(); 
        else
            return 0;



    }    //eof get_row_count



    public function get_data($table, $where , $column = NULL)
    {



            if ($column) {
                $this->db->select($column);
            }

            $this->db->where($where);
            

            $res = $this->db->get($table)->result_array();

            if (!empty($res))
                return $res; 
            else
                return null;

    }    //eof get data








	public function update_data($table, $data, $where)
    {

        $t=time(); 
       $data['updated_on']=date("Y-m-d H:i:s",$t);
        
       $this->db->where($where);
       $this->db->update($table, $data);

       return $this->db->affected_rows();

	}


	public function set_data($table, $data)
    {

       $t=time(); 
       $data['created_on']=date("Y-m-d H:i:s",$t);
       $data['updated_on']=date("Y-m-d H:i:s",$t);

       // print_r($data);
       // exit();

       $this->db->insert($table, $data);

       return $this->db->insert_id();

	}


    public function delete_where($table, $where)
    {

        $this->db->where($where);

        $this->db->delete($table); 

    }




    public function query($query)
    {

        $res=$this->db->query($query)->result_array();

        if (!empty($res))
            return $res;
        else
            return null;
    }


    public function unset_data($table, $where){



        return $this->db->delete($table, $where);



    }

}