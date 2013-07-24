<?php

App::uses('CauthAppModel', 'Cauth.Model');

/**
 * Category Model
 *
 * @property Item $Item
 */
class Category extends CauthAppModel {

    public $useTable = 'cauth_categories';

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
        'title' => array (
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
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array (
        'Item' => array (
            'className'    => 'Item',
            'foreignKey'   => 'category_id',
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

}
