<?php

App::uses('CauthAppModel', 'Cauth.Model');

/**
 * Item Model
 *
 * @property Category $Category
 */
class Item extends CauthAppModel {

    public $useTable = 'cauth_items';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array (
        'url' => array (
            'notempty' => array (
                'rule' => array ('notempty'),
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
        'Category' => array (
            'className'  => 'Cauth.Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        )
    );

//    public function beforeSave($options = array()) {
//        if (empty($this->data['Item']['title'])) {
//            $this->data['Item']['title'] = $this->data['Item']['url'];
//        }
//        return true;
//
//    }

}
