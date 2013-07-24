<?php

App::uses('CauthAppController', 'Cauth.Controller');
App::uses('ShellDispatcher', 'Console');

/**
 * Utils Controller
 *
 */
class UtilsController extends CauthAppController {

    var $components = array ('Cauth.Tree');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('initDB', 'acoSync', 'updateItem', 'index');
    }

    public function index() {
        $this->loadModel('Cauth.Item');
        $this->loadModel('Cauth.User');

        $groups = $this->User->Group->find('list');

        $this->Item->recursive = 0;
        $this->paginate        = array (
            'conditions' => array (
                'Item.visibility' => '1'
            ),
            'limit'      => 10
        );

        $items = $this->paginate('Item');

        $this->set(compact('groups', 'items'));

    }

    public function acoSync() {
        ini_set('max_execution_time', '800');
        $command    = '-app ' . APP . ' AclExtras.AclExtras aco_sync';
        $args       = explode(' ', $command);
        $dispatcher = new ShellDispatcher($args, false);
        try {
            $return = $dispatcher->dispatch();
            $this->Session->setFlash(__('Access control objetcs updated successfully!'));
        } catch (Exception $e) {
            print_r($e);
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
        $this->redirect(array ('plugin'     => 'cauth', 'controller' => 'utils', 'action'     => 'index'));

    }

    public function initDB() {
        $this->loadModel('Cauth.User');
        $group     = $this->User->Group;
        //Allow admins to everything
        $group->id = 1;
        $this->Acl->allow($group, 'controllers');
//
//        //allow managers to posts and widgets
//        $group->id = 2;
//        $this->Acl->deny($group, 'controllers');
////        $this->Acl->allow($group, 'controllers/Posts');
////        $this->Acl->allow($group, 'controllers/Widgets');
//        //allow users to only add and edit on posts and widgets
//        $group->id = 3;
//        $this->Acl->deny($group, 'controllers');
////        $this->Acl->allow($group, 'controllers/Cauth/Users/add');
////        $this->Acl->allow($group, 'controllers/Posts/edit');
////        $this->Acl->allow($group, 'controllers/Widgets/add');
////        $this->Acl->allow($group, 'controllers/Widgets/edit');
//        //we add an exit to avoid an ugly "missing views" error message
        echo "all done";
        exit;

    }

//    public function permission_bk($group_id = null) {
//        ini_set('max_execution_time', '800');
//        $this->helpers[] = 'Cauth.TreeView';
//        $this->loadModel('Cauth.User');
//        $this->loadModel('Cauth.Acoslug');
//
//        $group      = $this->User->Group;
//        $group_list = $this->User->Group->find('list');
//        $slugall    = $this->Acoslug->find('all');
//        $sluglist   = array ();
//        if (!empty($slugall)) {
//            foreach ($slugall as $slug) {
//                $sluglist[$slug['Acoslug']['url']] = $slug['Acoslug']['label'];
//            }
//        }
//
//
//        if (!$this->User->Group->exists($group_id)) {
//            throw new NotFoundException(__('Invalid group'));
//        }
//
//        $aco               = $this->Acl->Aco->generateTreeList(null, null, null, '|');
//        $resources         = array ();
//        $allowed_resources = array ();
//        $save              = false;
//        if ($this->request->is('post')) {
//            $group->id      = $this->request->data['group_id'];
//            $save           = true;
//            $success_status = array ();
//        }
//
//        foreach ($aco as $key => $row) {
//            // $result_array[$key] = $row.$this->getLevel($key);
//            $level           = "";
//            $level           = $this->getLevel($key);
//            $resources[$key] = preg_replace('/\d{1,9999}/', '', $row) . $level;
//            if ($save) {
//                if (in_array($level, $this->request->data['resources'])) {
//                    $this->Acl->allow($group, $level);
//                    $checkPerm = true;
//                } else {
//                    $this->Acl->deny($group, $level);
//                    $checkPerm = false;
//                }
//                $success_status[] = '1';
//            } else {
//                $checkPerm        = $this->Acl->check(array (
//                    'model'       => 'Group',
//                    'foreign_key' => $group_id
//                        ), $level);
//                $success_status[] = '0';
//            }
//            if ($checkPerm) {
//                $allowed_resources[] = $key;
//            }
//            //debug($this->Acl->check($this->getLevel($key), 'Data entry operator'));
//            // $result_array[$key] = $this->getLevel($key);
//        }
//
//        if (!in_array('0', $success_status)) {
//            $this->Session->setFlash(__('Access control objetcs updated successfully!'), 'success');
//        }
//
//        $this->set(compact('aco', 'resources', 'allowed_resources', 'group_id', 'sluglist'));
//
////        if (count($group_list) > 0) {
////            foreach ($group_list as $group_id => $group_name) {
////                switch ($group_id) {
////                    case '1':
////                        $group->id = 1;
////                        $this->Acl->allow($group, 'controllers');
////                        break;
////                    default:
////                        $group->id = $group_id;
////                        $this->Acl->deny($group, 'controllers');
////                        break;
////                }
////            }
////        }
////
////        die();
//
//    }

    public function getLevel($id = null) {
        $return = "";
        if (!empty($id)) {
            $details   = $this->Acl->Aco->find('first', array (
                'conditions' => array (
                    'id' => $id
                )
            ));
            $parent_id = $details['Aco']['parent_id'];
            $alias     = $details['Aco']['alias'];
            if (empty($parent_id)) {
                $return = $alias;
            } else {
                $data   = $this->getLevel($parent_id);
                $return = $data . '/' . $alias;
            }
        }
        return $return;

    }

    public function updateItem() {
        ini_set('max_execution_time', '800');
        $this->loadModel('Cauth.Item');
        $aco  = $this->Acl->Aco->generateTreeList(null, null, null, '');
        $data = array ();

        foreach ($aco as $key => $row) {
            // $result_array[$key] = $row.$this->getLevel($key);
            $level                     = "";
            $level                     = $this->getLevel($key);
            $data[$key]['Item']['id']  = $key;
            $data[$key]['Item']['url'] = preg_replace('/\d{1,9999}/', '', $row) . $level;
        }

        $this->Item->create();
        if ($this->Item->saveAll($data)) {
            $this->Session->setFlash(__('The item has been saved'), 'success');
            $this->redirect(array ('plugin'     => 'cauth', 'controller' => 'Items', 'action'     => 'index'));
        } else {
            $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'error');
            $this->redirect(array ('plugin'     => 'cauth', 'controller' => 'Items', 'action'     => 'index'));
        }

    }

    public function ajaxPermission() {
        $this->loadModel('Cauth.User');
        $group = $this->User->Group;
        //Allow admins to everything

        $this->layout     = false;
        $this->autoRender = false;
        if ($this->request->is('post') || $this->request->is('put')) {
            $group_id = $_POST['group_id'];
            $label    = $_POST['label'];
            $action   = $_POST['action'];
            switch ($action) {
                case 'view':
                    $checkPerm = $this->Acl->check(array (
                        'model'       => 'Group',
                        'foreign_key' => $group_id
                            ), $label);
                    if ($checkPerm) {
                        return 1;
                    } else {
                        return 0;
                    }
                    break;
                case 'check': {
                        $group->id = $group_id;
                        $this->Acl->deny($group, 'controllers');
                        $this->Acl->allow($group, $label);
                    }
                    break;
                case 'uncheck': {
                        $group->id = $group_id;
                        $this->Acl->deny($group, 'controllers');
                        $this->Acl->deny($group, $label);
                    }
                    break;
            }
        }

    }

}
