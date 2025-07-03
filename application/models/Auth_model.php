<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Auth_model extends CI_Model 
{
    public function checkCredential($username, $password)
    {
		$user = $this->db->get_where('users', array('username' => $username))->row();

		if ($user && password_verify($password, $user->password)){
			return $user;
		}

		return false;
    }                                       
}


/* End of file Auth_model.php and path \application\models\Auth_model.php */
