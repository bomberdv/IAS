<style>
    .panel-default {
        border-color: #fff;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('new_project') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->


            <div class="panel-body">

                <div class="col-md-12">
                    <div class="panel with-nav-tabs panel-default">
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li class="<?php echo $tab== 'summary'? 'active':''?>"><a href="#summary" data-toggle="tab"><?= lang('summary') ?></a></li>
                                <li class="<?php echo $tab== 'tasks'? 'active':''?>"><a href="#tasks" data-toggle="tab"><?= lang('tasks') ?></a></li>
<!--                                <li class="--><?php //echo $tab== 'milestones'? 'active':''?><!--"><a href="#milestones" data-toggle="tab">--><?//= lang('milestones') ?><!--</a></li>-->
                                <li class="<?php echo $tab== 'files'? 'active':''?>"><a href="#files" data-toggle="tab"><?= lang('files') ?></a></li>
                                <li class="<?php echo $tab== 'note'? 'active':''?>"><a href="#note" data-toggle="tab"><?= lang('note') ?></a></li>
                                <li class="<?php echo $tab== 'invoice'? 'active':''?>"><a href="#invoice" data-toggle="tab"><?= lang('invoices') ?></a></li>
                                <li class="<?php echo $tab== 'comments'? 'active':''?>"><a href="#comments" data-toggle="tab"><?= lang('comments') ?></a></li>
                                <li class="<?php echo $tab== 'log'? 'active':''?>"><a href="#log" data-toggle="tab"><?= lang('activity_log') ?></a></li>

                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade <?php echo $tab== 'summary'? 'in active':''?>" id="summary">
                                    <?php $this->load->view('admin/project/_include/summary')?>
                                </div>
                                <div class="tab-pane fade <?php echo $tab== 'tasks'? 'in active':''?>" id="tasks">
                                    <?php $this->load->view('admin/project/_include/tasks')?>
                                </div>
<!--                                <div class="tab-pane fade --><?php //echo $tab== 'milestones'? 'in active':''?><!--" id="milestones">--><?//= lang('milestones') ?><!--</div>-->
                                <div class="tab-pane fade <?php echo $tab== 'files'? 'in active':''?>" id="files"><?= lang('files') ?></div>
                                <div class="tab-pane fade <?php echo $tab== 'note'? 'in active':''?>" id="note"><?= lang('note') ?></div>
                                <div class="tab-pane fade <?php echo $tab== 'invoice'? 'in active':''?>" id="invoice"><?= lang('invoice') ?></div>
                                <div class="tab-pane fade <?php echo $tab== 'comments'? 'in active':''?>" id="comments"><?= lang('comments') ?></div>
                                <div class="tab-pane fade <?php echo $tab== 'log'? 'in active':''?>" id="log">
                                    <?php $this->load->view('admin/project/_include/project_log')?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>
        <!-- /.box -->

    </div>
</div>

<script>
    $(function () {
        //Add text editor
        $("#compose-textarea").wysihtml5();
    });
</script>
