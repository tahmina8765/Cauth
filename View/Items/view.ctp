<div class="items view">
    <h2><?php  echo __('Item'); ?></h2>
    <dl>
        		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($item['Item']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($item['Item']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($item['Item']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($item['Category']['title'], array('controller' => 'categories', 'action' => 'view', $item['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Visibility'); ?></dt>
		<dd>
			<?php echo h($item['Item']['visibility']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($item['Item']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($item['Item']['modified']); ?>
			&nbsp;
		</dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        		<li><?php echo $this->Html->link(__('Edit Item'), array('action' => 'edit', $item['Item']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Item'), array('action' => 'delete', $item['Item']['id']), null, __('Are you sure you want to delete # %s?', $item['Item']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Items'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
    </ul>
</div>
