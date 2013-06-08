<?php
App::uses('cauthAppModel', 'cauth.Model');
/**
* Aco Model
*
*/
class CauthAco extends cauthAppModel {

    public $useTable = 'acos';
    /**
    * Display field
    *
    * @var string
    */
    public $displayField = 'alias';

    }
