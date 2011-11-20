<?php

require_once 'cms_model.php';

//
// the User model
//

class User_model extends CMS_Model {

    // get user from database by id
    // 
    function get($id = '') {
        $user = null;

        if ($id) {
            $this->db->select('*')->from('a3m_account');
            $this->db->join('fs_user', 'user_id = id', 'left');
            $this->db->join('a3m_account_details', 'account_id = id');
            $this->db->where('id', $id);
            $this->db->group_by('id');
            $this->db->order_by('id', 'desc');
            $query = $this->db->get();
            foreach ($query->result() as $c) {
                $user['id'] = $c->id;
                $user['username'] = $c->username;
                $user['firstname'] = $c->firstname;
                $user['lastname'] = $c->lastname;
                $user['email'] = $c->email;
                $user['permission'] = $c->permission;
                $user['admin_state'] = $c->admin_state;
                $user['admin_topic'] = $c->admin_topic;
                break;
            }
        }
        else {
            $user = array();
            $user['id'] = '';
            $user['username'] = '';
            $user['firstname'] = '';
            $user['lastname'] = '';
            $user['email'] = '';
            $user['permission'] = '';
            $user['admin_state'] = '';
            $user['admin_topic'] = '';
        }

        return $user;
    }

    function get_authors() {
        $this->db->select('*')->from('a3m_account_details');
        $this->db->join('fs_user', 'account_id = user_id');
        $this->db->where('permission', 'SUPER');
        $this->db->order_by('account_id', 'desc');
        return ($this->db->get());
    }

    function delete($id) {
        $this->db->delete('a3m_account_details', array('account_id' => $id));
        $this->db->delete('a3m_account_facebook', array('account_id' => $id));
        $this->db->delete('a3m_account_openid', array('account_id' => $id));
        $this->db->delete('a3m_account_twitter', array('account_id' => $id));
        $this->db->delete('a3m_account', array('id' => $id));
        $this->db->delete('fs_user', array('user_id' => $id));
    }

    function quick_update($id, $changes) {

        // if updating a field with the quick edit feature
        $data = array();
        if (isset($changes['username']))
            $data['username'] = $changes['username']; 
        if (isset($changes['email']))
            $data['email'] = $changes['email']; 

        if (!empty($data)) {
            $this->db->where('id', $id);
            $this->db->update('a3m_account', $data);
        }

        // update details
        $data = array();
        if (isset($changes['firstname']))
            $data['firstname'] = $changes['firstname']; 
        if (isset($changes['lastname']))
            $data['lastname'] = $changes['lastname'];
        if (!empty($data)) {
            $this->db->where('account_id', $id);
            $this->db->update('a3m_account_details', $data);
        }
    }

    // create a new user and save to the database
    //
    function save($id = '') {
		
        $username = $this->input->post('username');

        $this->db->select('*')->from('a3m_account');
        $this->db->where('username', $username);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            foreach ($query->result() as $u) {
                if (!($id) || (($id && ($u->id != $id))))
                    return "User name '$username' already exists";
                break;
            }
        }

        $password = $this->input->post('password');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $permission = $this->input->post('permission');
        $id = $this->input->post('id');
        $email = $this->input->post('email');
        $admin_state = '';
        $admin_topic = '';

        if ($permission != 'SUPER') {
            $admin_state = $this->input->post('admin_state');
            $admin_topic = $this->input->post('admin_topic');
        }

        // Create password hash using phpass
        if ($password) {
            $this->load->helper('account/phpass');
            $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
            $hashed_password = $hasher->HashPassword($password);
        }
		
        // save
        if ($id) {

            // update account
            $this->db->where('id', $id);
            $data = array(
                'username' => $username, 
                'email' => $email, 
            );
            if (isset($hashed_password))
                $data['password'] = $hashed_password;

            $this->db->update('a3m_account', $data);

            // update permissions
            // if fs_user doesn't exist, create it, this user joined by account
            $this->db->where('user_id', $id);
            $this->db->from('fs_user');
            $fs_user = $this->db->get();

            $this->db->where('user_id', $id);
            if ($fs_user->num_rows > 0) {
                $this->db->update('fs_user', array(
                        'user_id' => $id,
                        'permission' => $permission,
                        'admin_state' => $admin_state,
                        'admin_topic' => $admin_topic
                    ));
            }
            else {
                $this->db->insert('fs_user', array(
                        'user_id' => $id,
                        'permission' => $permission,
                        'admin_state' => $admin_state,
                        'admin_topic' => $admin_topic
                    ));
            }

            // update details
            $this->db->where('account_id', $id);
            $this->db->update('a3m_account_details', array(
                    'firstname' => $firstname, 
                    'lastname' => $lastname
                ));
        }

        // create
        else {
 
            $this->load->helper('date');
            $this->db->insert('a3m_account', array(
                    'username' => $username, 
                    'email' => $email, 
                    'password' => isset($hashed_password) ? $hashed_password : NULL, 
                    'createdon' => mdate('%Y-%m-%d %H:%i:%s', now())
		));
            $id = $this->db->insert_id();
            $this->db->insert('fs_user', array(
                    'user_id' => $id,
                    'permission' => $permission,
                    'admin_state' => $admin_state,
                    'admin_topic' => $admin_topic
                ));
            $this->db->insert('a3m_account_details', array(
                    'account_id' => $id, 
                    'firstname' => $firstname, 
                    'lastname' => $lastname
                ));
        }

        return $id;
    }
}