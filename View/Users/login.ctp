<div class="users form">
    <?php
    echo $this->Form->create('User', array (
        'class'         => 'form-horizontal form-signin',
        'url'           => array ('plugin'     => 'cauth', 'controller' => 'users', 'action'     => 'login'),
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
        <legend style="text-align: center;"><?php echo __(':: Secured Login ::'); ?></legend>
        <?php
        echo $this->Form->input('User.username', array ('label' => array ('text'  => 'Login ID', 'class' => 'control-label')));
        echo $this->Form->input('User.password', array ('label' => array ('text'  => 'Password', 'class' => 'control-label')));
        ?>
        <?php
        echo $this->html->link('Forget Password', array('plugin' => 'cauth', 'controller' => 'users', 'action' => 'forgetPassword'));
        ?>
        <div class="control-group">
            <div class="controls">
                <?php
                echo $this->Form->button('Login', array ('type'  => 'submit', 'class' => 'btn btn-success submit', 'div'   => false));
                echo '<button class="btn btn-danger reset" type="reset" onclick="history.back();">Cancel</button>';
                ?>
            </div>
        </div>
    </fieldset>
    <?php
    echo $this->Form->end();
    ?>
</div>

