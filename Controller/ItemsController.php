<?php

App::uses('CauthAppController', 'Cauth.Controller');

/**
 * Items Controller
 *
 * @property Item $Item
 */
class ItemsController extends CauthAppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Item->recursive = 0;
        $this->set('items', $this->paginate());

    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Item->exists($id)) {
            throw new NotFoundException(__('Invalid item'));
        }
        $options = array ('conditions' => array ('Item.' . $this->Item->primaryKey => $id));
        $this->set('item', $this->Item->find('first', $options));

    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Item->create();
            if ($this->Item->save($this->request->data)) {
                $this->Session->setFlash(__('The item has been saved'), 'success');
                $this->redirect(array ('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'error');
            }
        }
        $categories = $this->Item->Category->find('list');
        $this->set(compact('categories'));

    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Item->exists($id)) {
            throw new NotFoundException(__('Invalid item'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Item->save($this->request->data)) {
                $this->Session->setFlash(__('The item has been saved'), 'success');
                $this->redirect(array ('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The item could not be saved. Please, try again.'), 'error');
            }
        } else {
            $options             = array ('conditions' => array ('Item.' . $this->Item->primaryKey => $id));
            $this->request->data = $this->Item->find('first', $options);
        }
        $categories = $this->Item->Category->find('list');
        $this->set(compact('categories'));

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
        $this->Item->id = $id;
        if (!$this->Item->exists()) {
            throw new NotFoundException(__('Invalid item'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Item->delete()) {
            $this->Session->setFlash(__('Item deleted'), 'success');
            $this->redirect(array ('action' => 'index'));
        }
        $this->Session->setFlash(__('Item was not deleted'), 'error');
        $this->redirect(array ('action' => 'index'));

    }

}
