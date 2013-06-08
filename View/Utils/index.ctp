<script type="text/javascript">
    $(document).ready(function() {
        $(".checkbox").attr("disabled", true);
        permissionObj.permission('view');
        $(".checkbox").on('click', function() {
            if ($(this).is(":checked")) {
                permissionObj.permission('check', $(this).attr('id'));
            } else {
                permissionObj.permission('uncheck', $(this).attr('id'));
            }
        });
    });

    var permissionObj = {
        basePath: '<?php echo Configure::read('Site.url'); ?>',
        permission: function(type, refer_id) {
            switch (type) {
                case 'view':
                    $(".checkbox").each(function(index) {
                        var id = $(this).attr('id');
                        var label = $(this).val();
                        var group_id = $(this).parent().attr('class');
                        var data = {'group_id': group_id, 'label': label, 'action': type};
                        $.ajax({
                            dataType: "json",
                            url: permissionObj.basePath + 'cauth/utils/ajaxPermission',
                            type: "POST",
                            data: data,
                            cache: false,
                            success: function(html) {
                                if (html == '1') {
                                    $("#" + id).attr('checked', 'checked');
                                }
                                $("#" + id).removeAttr("disabled");
                            }
                        });
                    });
                    break;
                case 'check':
                    var id = refer_id;
                    var label = $("#"+refer_id).val();
                    var group_id = $("#"+refer_id).parent().attr('class');
                    var data = {'group_id': group_id, 'label': label, 'action': type};

                    $.ajax({
                        dataType: "json",
                        url: permissionObj.basePath + 'cauth/utils/ajaxPermission',
                        type: "POST",
                        data: data,
                        cache: false,
                        success: function(html) {
                            alert('success');
                        }
                    });
                    break;
                case 'uncheck':

                    var id = refer_id;
                    var label = $("#"+refer_id).val();
                    var group_id = $("#"+refer_id).parent().attr('class');
                    var data = {'group_id': group_id, 'label': label, 'action': type};

                    $.ajax({
                        dataType: "json",
                        url: permissionObj.basePath + 'cauth/utils/ajaxPermission',
                        type: "POST",
                        data: data,
                        cache: false,
                        success: function(html) {

                        }
                    });
                    break;


            }
        },
    }
</script>
<style type="text/css">
    table.display_list tbody tr td {
        padding: 0px 2px;
    }
</style>

<div class="items index" id="items">
    <h2><?php echo __('Access Control'); ?></h2>
    <table cellpadding="0" cellspacing="0" class="display_list">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('title'); ?></th>
            <?php
            foreach ($groups as $group_id => $group) {
                ?>
                <th class="<?php echo $group_id; ?>"><?php echo $this->Text->truncate($group); ?></th>
                <?php
            }
            ?>
        </tr>
        <?php foreach ($items as $rowno => $item): ?>
            <tr>
                <td><?php echo h($item['Item']['id']); ?>&nbsp;</td>
                <td><?php echo empty($item['Item']['title'])?h($item['Item']['url']): h($item['Item']['title']); ?>&nbsp;</td>
                <?php
                foreach ($groups as $group_id => $group) {
                    ?>
                    <td class="<?php echo $group_id; ?>">
                        <input type="hidden" class="group_id" name="group_id" value="<?php echo $group_id; ?>">
                        <input id="<?php echo $group_id . '_' . $rowno; ?>" name="checkbox" type="checkbox" class="checkbox" value="<?php echo h($item['Item']['url']); ?>" disabled></td>
                    <?php
                }
                ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        $this->Paginator->options(array (
            'update'      => '#items',
            'evalScripts' => true
        ));
        echo $this->Paginator->counter(array (
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>    </p>
    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('previous'), array (), null, array ('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array ('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array (), null, array ('class' => 'next disabled'));
        ?>
    </div>
</div>






