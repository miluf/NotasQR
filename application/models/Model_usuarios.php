<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Model_usuarios extends CI_Model
{
    public function ListarUsuarios()
    {
        $this->db->order_by('ID ASC');
        return $this->db->get('usuarios')->result();
    }
    public function ExisteEmail($email)
    {
        $this->db->from('usuarios');
        $this->db->where('EMAIL', $email);
        return $this->db->count_all_results();
    }
    public function SaveUsuarios($arrayCliente)
    {
        /*Nos aseguramos si realizamos todo o no*/
        $this->db->trans_start();
        $this->db->insert('usuarios', $arrayCliente);
        $this->db->trans_complete();
    }
    public function BuscarID($id)
    {

        $query = $this->db->where('ID', $id);
        $query = $this->db->get('usuarios');
        return $query->result();

    }
    public function edit($data, $id)
    {

        $this->db->where('ID', $id);
        $this->db->update('usuarios', $data);

    }

    public function Eliminar($id)
    {

        $this->db->where('ID', $id);
        $this->db->delete('usuarios');

    }
    
    public function MenuCompleto()
    {
        $this->db->order_by('ORDENAMIENTO ASC');
        return $this->db->get('menu_sistema')->result();
    }
    public function MiMenu($id, $id_menu)
    {
        $this->db->from('permisosmenu');
        $this->db->where('ID_USUARIO', $id);
        $this->db->where('ID_MENU', $id_menu);
        $this->db->where('ESTATUS', 0);
        return $this->db->count_all_results();
    }
    public function DesactivaPermisos($id)
    {
        $this->db->where('ID_USUARIO', $id);
        $success = $this->db->update('permisosmenu', array('ESTATUS' => 1));
    }
    public function ExistePermiso($id, $id_menu)
    {
        $this->db->from('permisosmenu');
        $this->db->where('ID_USUARIO', $id);
        $this->db->where('ID_MENU', $id_menu);
        return $this->db->count_all_results();
    }
    public function ActualizaPermiso($id, $id_menu)
    {
        $this->db->where('ID_USUARIO', $id);
        $this->db->where('ID_MENU', $id_menu);
        $success = $this->db->update('permisosmenu', array('ESTATUS' => 0));
    }
    public function AgregaPermiso($arraypermisos)
    {
        $this->db->trans_start();
        $this->db->insert('permisosmenu', $arraypermisos);
        $this->db->trans_complete();
    }
}
