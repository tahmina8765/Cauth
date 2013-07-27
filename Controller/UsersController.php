<?php

App::uses('CauthAppController', 'Cauth.Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends CauthAppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'login', 'logout', 'changePassword', 'forgetPassword');
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());

    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array ('conditions' => array ('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));

    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array ('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));

    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array ('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options             = array ('conditions' => array ('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));

    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array ('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array ('action' => 'index'));

    }

    /**
     *  login method
     */
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }
        if ($this->Session->read('Auth.User')) {
            $this->Session->setFlash('You are logged in!');
            $this->redirect('/', null, false);
        }

    }

    /**
     * logout method
     */
    public function logout() {
        $this->Session->setFlash(__('You have successfully logged out from the system.'));
        $this->redirect($this->Auth->logout());

    }

    /**
     *
     * @param type $id
     * @throws NotFoundException
     */
    public function changePassword($id = null, $password_change_code = null) {

        $this->User->validate['password'] = array (
            'notempty'           => array (
                'rule' => array ('notempty'),
            ),
            'minLength'          => array (
                'rule'    => array ('minLength', 6),
                'message' => 'Password must be min 6 char long'
            ),
            'identitcalpassword' => array (
                'rule'    => array ('identitcalpassword'),
                'message' => 'You are already using this password',
            )
        );

        $this->User->validate['rpassword'] = array (
            'notempty'  => array (
                'rule' => array ('notempty'),
            ),
            'rpassword' => array (
                'rule'    => array ('rpassword'),
                'message' => 'Re-type password does not match',
            )
        );

        $loggedin = $this->Session->check('Auth.User');
        if ($loggedin) {
            $this->User->validate['cpassword'] = array (
                'notempty'  => array (
                    'rule' => array ('notempty'),
                ),
                'cpassword' => array (
                    'rule'    => array ('cpassword'),
                    'message' => 'Invalid current password',
                )
            );

            $current_user_group_id = $this->Session->read('Auth.User.group_id');
            if ($current_user_group_id != '1' || empty($id)) {
                $id = $this->Session->read('Auth.User.id');
            }
        } else {
            $this->User->validate['password_change_code'] = array (
                'notempty'  => array (
                    'rule' => array ('notempty'),
                ),
                'matchPasswordChangeCode' => array (
                    'rule'    => array ('matchPasswordChangeCode'),
                    'message' => 'Invalid password change code',
                )
            );
        }

        /**
         * Check this user is valid to chnage password
         * Rule 1: Admin is allowed to change anyone password
         * Rule 2: Only own password will be change for other types of user
         */
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $tmp = $this->request->data['User']['password_change_code'];
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Password has changed successfully.'), 'success');
                $this->redirect(array ('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Password could not be changed. Please, try again.'), 'error');
            }
        } else {
            $options                                 = array ('conditions' => array ('User.' . $this->User->primaryKey => $id));
            $this->request->data                     = $this->User->find('first', $options);
            $this->request->data['User']['password'] = '';
        }

        $this->set(compact('password_change_code'));

    }

    /**
     * forgetPassword
     */

    public function forgetPassword() {
        $this->User->validate['username'] = array (
            'notempty'        => array (
                'rule'       => array ('notempty'),
                'allowEmpty' => true,
                'required'   => false,
            ),
            'usernameOrEmail' => array (
                'rule'    => array ('usernameOrEmail'),
                'message' => 'Insert username or email',
            )
        );
        $this->User->validate['email']    = array (
            'notempty'        => array (
                'rule'       => array ('notempty'),
                'allowEmpty' => true,
                'required'   => false,
            ),
            'usernameOrEmail' => array (
                'rule'    => array ('usernameOrEmail'),
                'message' => 'Insert username or email',
            )
        );


        if ($this->request->is('post') || $this->request->is('put')) {
            $options = '';
            if (!empty($this->request->data['User']['username'])) {
                $options = array ('conditions' => array ('User.username' => $this->request->data['User']['username']));
            } else if (!empty($this->request->data['User']['email'])) {
                $options = array ('conditions' => array ('User.email' => $this->request->data['User']['email']));
            }
            if (!empty($options)) {
                $data = $this->User->find('first', $options);
            }
            if (!empty($data)) {
                unset($this->request->data['User']);
                $this->request->data['User']['id']                   = $data['User']['id'];
                $this->request->data['User']['password_change_code'] = md5(date('Y-m-d h:i:s'));
                if ($this->User->save($this->request->data)) {
                    $Email = new CakeEmail();
                    $Email->from(array ('tahmina8765@yahoo.com' => 'Cauth'));
                    $Email->to($data['User']['email']);
                    $Email->subject('Forget Password Request');
                    $link  = 'cauth/users/changePassword/' . $data['User']['id'] . '/' . $this->request->data['User']['password_change_code'];
                    $Email->send($link);
                    $this->Session->setFlash(__($link));
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                }
            } else {
                $this->Session->setFlash(__('Invalid username or email'), 'error');
            }
        } else {

        }

    }

}
