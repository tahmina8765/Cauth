Cauth
=====

A simple Cakephp ACL based authentication plugin

Prerequisite
============
1. Plugin AclExtras
2. jQuery library enabled in layout

Installation
============
1. Clone the repo or download a tarball and install it into app/Plugin/Cauth or in any of your plugin Paths.
2. Import “Cauth.sql” in your database.
3. Enable plugin at “boostrap.php”.
4. Add the following code in AppController.php

        public $helpers    = array ('Form', 'Time', 'Html', 'Session', 'Js');
        public $counter    = 0;
        public $components = array (
            'RequestHandler',
            'Acl',
            'Auth' => array (
                'authError' => 'Did you really think you are allowed to see that?',
                'authorize' => array (
                    'Actions' => array (
                        'actionPath' => 'controllers',
                        'userModel'  => 'Cauth.User',
                    ),
                )
            ),
            'Session'
        );

        public function beforeFilter() {

            //Configure AuthComponent
            $this->Auth->loginAction    = array ('plugin'     => 'cauth', 'controller' => 'users', 'action'     => 'login');
            $this->Auth->logoutRedirect = array ('plugin'     => 'cauth', 'controller' => 'users', 'action'     => 'login');
            $this->Auth->loginRedirect  = array ('plugin'     => '', 'controller' => 'pages', 'action'     => 'display');

        }
5. We need to create group and user. As without any user we can not create, so for 1st time create we will allow add action in both user and group controller.

        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('add');
        }

6. Browse http://yourdomain/cauth/groups/add and Add an new group, say "Administrator".
7. Browse http://yourdomain/cauth/users/add and Add a new user under "Administrator" group.
8. Now for groups remove the 'add' and make it as follows:

        public function beforeFilter() {
            parent::beforeFilter();
        }

9. And for users remove the 'add' and make it as follows:

        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('login', 'logout');
        }

10. Allow 'initDB', 'acoSync' and 'index' action from utils controller.

        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('initDB', 'acoSync', 'index');
        }

11. Add the following veriable in core.php

        Configure::write('Site.url', 'http://yourdomain/');

12. Run http://yourdomain/cauth/utils/acoSync
13. Run http://yourdomain/cauth/utils/initDB
14. Run http://yourdomain/cauth/utils/updateItem
15. Again remove or block these code from utils controller.
16. Now Cauth is ready to use.

Usage
=====
1. A complete ACL based group permission option
2. Rename option for controllers and action for user readability.
3. Hiding the actions from user that is not necessary for them but has used to perform some internal actions.
