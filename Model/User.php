<?php
App::uses('AuthComponent', 'Controller/Component');
App::uses('CauthAppModel', 'Cauth.Model');

/**
 * User Model
 *
 * @property Group $Group
 * @property ActivityLog $ActivityLog
 * @property Commissioner $Commissioner
 * @property LicensedIndividual $LicensedIndividual
 * @property WorkItem $WorkItem
 */
class User extends CauthAppModel {

    /**
     * Validation rules
     *
     * @var array
     *
     */
    var $name = 'User';
    public $validate = array (
        'username' => array (
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

    /**
     * hasMany associations
     *
     * @var array
     */
    /*
    public $hasMany = array (
        'ActivityLog'        => array (
            'className'    => 'ActivityLog',
            'foreignKey'   => 'user_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
        'Commissioner'       => array (
            'className'    => 'Commissioner',
            'foreignKey'   => 'user_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
        'LicensedIndividual' => array (
            'className'    => 'LicensedIndividual',
            'foreignKey'   => 'user_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
        'WorkItem'           => array (
            'className'    => 'WorkItem',
            'foreignKey'   => 'user_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        )
    );
*/
    public function beforeSave($options = array ()) {
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

//    public function bindNode($user) {
//        return array ('model'       => 'Cauth.Group', 'foreign_key' => $user['User']['group_id']);
//
//    }

}
