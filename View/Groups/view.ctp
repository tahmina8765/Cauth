<div class="groups view">
    <h2><?php echo __('Group'); ?></h2>
    <dl>
        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($group['Group']['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($group['Group']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($group['Group']['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php echo h($group['Group']['modified']); ?>
            &nbsp;
        </dd>
    </dl>
</div>

