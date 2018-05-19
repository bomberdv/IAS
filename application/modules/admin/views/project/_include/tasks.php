


    <a  href="<?php echo site_url('admin/project/add/tasks/'.my_encode($project->id))?>" class="btn btn-success"><?= lang('add_new_task') ?></a>
<br/>
<br/>
    <!-- View massage -->
    <?php echo message_box('success'); ?>
    <?php echo message_box('error'); ?>

    <table class="table table-bordered table-responsive" style="margin-top: 20px; width: 100%">
        <thead>
        <tr>
            <th>#</th>
            <th><?= lang('tasks') ?></th>
            <th><?= lang('assign_to') ?></th>
            <th><?= lang('due_date') ?></th>
            <th><?= lang('start_date') ?></th>
            <th><?= lang('status') ?></th>
            <th><?= lang('actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1 ?>
            <?php if(!empty($tasks)){ foreach ($tasks as $item){?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $item->title ?></td>
                <td><?= $item->first_name.' '.$item->last_name ?></td>
                <td><?= dateFormat($item->due_date) ?></td>
                <td><?= dateFormat($item->start_date) ?></td>
                <td>
                    <?php
                        if($item->status == lang('due')){ ?>
                         <span class="label label-warning"><?= lang('due') ?></span>
                    <?php }elseif($item->status == lang('progress')){?>
                         <span class="label label-primary"><?= lang('progress') ?></span>
                    <?php }else{ ?>
                          <span class="label label-info"><?= lang('done') ?></span>
                    <?php } ?>
                </td>
                <td>
                    <a href="<?= site_url('admin/project/view_task/tasks/'.my_encode($item->id))?>" class="btn btn-xs btn-default" data=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="<?= site_url('admin/project/edit_task/tasks/'.my_encode($item->id))?>" class="btn btn-xs btn-default" data=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-danger item-delete" data=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
            <?php $i++; }; }?>
        </tbody>
    </table>



