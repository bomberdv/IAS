
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('add_new_task') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $form->open(); ?>

            <div class="panel-body">
                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>


                <div class="form-group margin">
                    <label class="col-sm-2 control-label"> <?= lang('title') ?> <span class="required">*</span></label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control input-lg" name="title" value="<?php if(!empty($task)) echo $task->title ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?= lang('status') ?> </label>

                    <div class="col-sm-7">
                        <select name="status" class="form-control input-lg">
                            <option value="<?= lang('due') ?>" <?php if(!empty($task)) echo $task->status === lang('due') ?'selected':''  ?>> <?= lang('due') ?></option>
                            <option value="<?= lang('done') ?>" <?php if(!empty($task)) echo $task->status === lang('done') ?'selected':''  ?>><?= lang('done') ?></option>
                            <option value="<?= lang('progress') ?>" <?php if(!empty($task)) echo $task->status === lang('progress') ?'selected':''  ?>><?= lang('progress') ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?= lang('priority') ?> </label>

                    <div class="col-sm-7">
                        <select name="priority"  class="form-control input-lg">
                            <option value="<?= lang('low') ?>" <?php if(!empty($task)) echo $task->priority === lang('low') ?'selected':''  ?>><?= lang('low') ?></option>
                            <option value="<?= lang('medium') ?>" <?php if(!empty($task)) echo $task->priority === lang('medium') ?'selected':''  ?>><?= lang('medium') ?></option>
                            <option value="<?= lang('high') ?>" <?php if(!empty($task)) echo $task->priority === lang('high') ?'selected':''  ?>><?= lang('high') ?></option>
                            <option value="<?= lang('urgent') ?>" <?php if(!empty($task)) echo $task->priority === lang('urgent') ?'selected':''  ?>><?= lang('urgent') ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group margin">
                    <label class="col-sm-2 control-label"><?= lang('start_date') ?><span class="required">*</span></label>

                    <div class="col-sm-7">
                        <div class="input-group">
                            <input  type="text" name="start_date" class="form-control datepicker input-lg" value="<?php if(!empty($task))  echo date('m/d/Y', strtotime($task->start_date));?>">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group margin">
                    <label class="col-sm-2 control-label"><?= lang('due_date') ?><span class="required">*</span></label>

                    <div class="col-sm-7">
                        <div class="input-group">
                            <input  type="text" name="due_date" class="form-control datepicker input-lg" value="<?php if(!empty($task))  echo date('m/d/Y', strtotime($task->due_date));?>">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?= lang('assign_to') ?> <span class="required">*</span></label>

                    <div class="col-sm-7">
                        <select name="employee_id"  class="form-control input-lg" >
                            <option value="" ><?= lang('please_select') ?>...</option>
                            <?php foreach ($employees as $item) : ?>
                                <option value="<?php echo $item->employee_id ?>" <?php if(!empty($task)) echo $task->assign_to === $item->employee_id ?'selected':''  ?>> <?php echo $item->first_name.' '.$item->last_name?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group margin">
                    <label class="col-sm-2 control-label"><?= lang('note') ?><span class="required">*</span></label>

                    <div class="col-sm-7">
                        <textarea id="compose-textarea" class="form-control input-lg" rows="8" name="note"><?php if(!empty($task))  echo $task->job ?></textarea>
                    </div>
                </div>

                <input type="hidden" name="project_id" value="<?php echo my_encode($id)?>" >
                <input type="hidden" name="task_id" value="<?php if(!empty($task))  echo my_encode($task->id) ?>" >
                <input type="hidden" name="tab" value="<?php echo $tab ?>" >


                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-1" >
                        <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-flat btn-md btn-block"><?= lang('add') ?></button>
                    </div>
                </div>

            </div>

            <?php echo $form->close(); ?>

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
