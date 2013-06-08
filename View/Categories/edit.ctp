<div class="categories form">
    <?php
        echo $this->Form->create('Category', array (
            'class'         => 'form-horizontal',
            'inputDefaults' => array (
                'format'  => array ('before', 'label', 'between', 'input', 'error', 'after'),
                'div'     => array ('class' => 'control-group'),
                'label'   => array ('class' => 'control-label'),
                'between' => '<div class="controls">',
                'after'   => '</div>',
                'error'   => array ('attributes' => array ('wrap'  => 'span', 'class' => 'help-inline')),
            )
        ));
        ?>
		
    <fieldset>
        <legend><?php echo __('Edit Category'); ?></legend>
        	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('comments');
		echo $this->Form->input('visibility');
	?>
    </fieldset>
    <div class="control-group">
        <div class="controls">
            
                <?php
                echo $this->Form->button('Submit', array ('type'  => 'submit', 'class' => 'btn btn-success submit', 'div'   => false));
                echo $this->Form->button('Reset', array ('type'  => 'reset', 'class' => 'btn btn-warning reset', 'div'   => false));
                echo '<button class="btn btn-danger reset" type="reset" onclick="history.back();">Cancel</button>';
                ?>
				        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>

                    <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Category.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Category.id'))); ?></li>
                <li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?></li>
        		<li><?php echo $this->Html->link(__('List Items'), array('controller' => 'items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
    </ul>
</div>

