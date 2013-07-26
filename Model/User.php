<?php
App::uses('AuthComponent', 'Controller/Component');
App::uses('CauthAppModel', 'Cauth.Model');

/**
 * User Model
 *
 * @property Group $Group
 */
class User extends CauthAppModel {



    /**
     * Validation rules
     *
     * @var array
     *
     */
    public $name = 'User';
    public $useTable = 'users';

    public $validate = array (
        'username' => array (
            'notempty' => array (
                'rule' => array ('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'email' => array (
            'notempty' => array (
                'rule' => array ('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'password' => array (
            'notempty' => array (
                'rule' => array ('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'group_id' => array (
            'numeric' => array (
                'rule' => array ('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array (
        'Group' => array (
            'className'  => 'Cauth.Group',
            'foreignKey' => 'group_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        )
    );

    public function beforeSave($options = array ()) {
        if(!empty($this->data['User']['password']))
        $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        return true;
    }

    public $actsAs = array ('Acl' => array ('type' => 'requester'));

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array ('Group' => array ('id' => $groupId));
        }
    }


    public function identitcalpassword() {
        $return = false;
        $id     = $this->data['User']['id'];
        $user   = $this->find('first', array ('conditions' => array ('User.' . $this->primaryKey => $id)));
        if (!empty($user)) {
            if ($user['User']['password'] != AuthComponent::password($this->data['User']['password'])) {
                $return = true;
            }
        }
        return $return;
    }

    public function matchPasswordChangeCode() {
        $return = false;
        $id     = $this->data['User']['id'];
        $user   = $this->find('first', array ('conditions' => array ('User.' . $this->primaryKey => $id)));
        if (!empty($user)) {
            if ($user['User']['password_change_code'] == $this->data['User']['password_change_code']) {
                $return = true;
            }
        }
        return $return;
    }

    public function cpassword() {
        $return = false;
        $id     = $this->data['User']['id'];
        $user   = $this->find('first', array ('conditions' => array ('User.' . $this->primaryKey => $id)));
        if (!empty($user)) {
            if ($user['User']['password'] == AuthComponent::password($this->data['User']['cpassword'])) {
                $return = true;
            }
        }
        return $return;
    }

    public function rpassword() {
        $return = false;
        if (($this->data['User']['password']) == ($this->data['User']['rpassword'])) {
            $return = true;
        }
        return $return;

    }
    public function usernameOrEmail() {
        $return = false;
        if (!empty($this->data['User']['username']) || !empty($this->data['User']['email'])) {
            $return = true;
        }
        return $return;

    }

//    public function bindNode($user) {
//        return array ('model'       => 'Cauth.Group', 'foreign_key' => $user['User']['group_id']);
//
//    }

}
