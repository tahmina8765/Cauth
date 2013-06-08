<div class="categories view">
    <h2><?php  echo __('Category'); ?></h2>
    <dl>
        		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($category['Category']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($category['Category']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comments'); ?></dt>
		<dd>
			<?php echo h($category['Category']['comments']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Visibility'); ?></dt>
		<dd>
			<?php echo h($category['Category']['visibility']); ?>
			&nbsp;
		</dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        		<li><?php echo $this->Html->link(__('Edit Category'), array('action' => 'edit', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category'), array('action' => 'delete', $category['Category']['id']), null, __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Items'), array('controller' => 'items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
    </ul>
</div>
    <div class="related">
        <h3><?php echo __('Related Items'); ?></h3>
        <?php if (!empty($category['Item'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Url'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th><?php echo __('Visibility'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            	<?php
		$i = 0;
		foreach ($category['Item'] as $item): ?>
		<tr>
			<td><?php echo $item['id']; ?></td>
			<td><?php echo $item['title']; ?></td>
			<td><?php echo $item['url']; ?></td>
			<td><?php echo $item['category_id']; ?></td>
			<td><?php echo $item['visibility']; ?></td>
			<td><?php echo $item['created']; ?></td>
			<td><?php echo $item['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'items', 'action' => 'view', $item['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'items', 'action' => 'edit', $item['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'items', 'action' => 'delete', $item['id']), null, __('Are you sure you want to delete # %s?', $item['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
        </table>
        <?php endif; ?>

        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
            </ul>
        </div>
    </div>
