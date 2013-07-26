<div class="users form">
    <?php
        echo $this->Form->create('User', array (
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
        <legend><?php echo __('Add User'); ?></legend>
        	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('group_id');
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