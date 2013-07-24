<?php
/*
 * Name: Sidebar element for CMS PLUGIN
 * A sidebar which will contain all common action for Directory Plugin
 * Addedd by - Tahmina Khatoon
 *
 */
?>
<div class="actions">
    <h3><?php echo __('Groups'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New Group'), array ('plugin'     => 'cauth', 'controller' => 'groups', 'action'     => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Groups'), array ('plugin'     => 'cauth', 'controller' => 'groups', 'action'     => 'index')); ?></li>
    </ul>

    <h3><?php echo __('Users'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New User'), array ('plugin'     => 'cauth', 'controller' => 'users', 'action'     => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Users'), array ('plugin'     => 'cauth', 'controller' => 'users', 'action'     => 'index')); ?></li>
    </ul>

    <h3><?php echo __('User'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Change Password'), array ('plugin'     => 'cauth', 'controller' => 'users', 'action'     => 'changePassword')); ?></li>
    </ul>

    <h3><?php echo __('Access Control'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Permission'), array ('plugin'     => 'cauth', 'controller' => 'utils', 'action'     => 'index')); ?></li>
    </ul>

    <h3><?php echo __('Items (Only for developers)'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New Item'), array ('plugin'     => 'cauth', 'controller' => 'items', 'action'     => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Items'), array ('plugin'     => 'cauth', 'controller' => 'items', 'action'     => 'index')); ?></li>
    </ul>

    <h3><?php echo __('Utils (Only for developers)'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Synchronization'), array ('plugin'     => 'cauth', 'controller' => 'utils', 'action'     => 'acoSync')); ?></li>
        <li><?php echo $this->Html->link(__('Update Item (must run after synchronization)'), array ('plugin'     => 'cauth', 'controller' => 'utils', 'action'     => 'updateItem')); ?></li>
        <li><?php echo $this->Html->link(__('Initialize DB'), array ('plugin'     => 'cauth', 'controller' => 'utils', 'action'     => 'initDB')); ?></li>
    </ul>
</div>