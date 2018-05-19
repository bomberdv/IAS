
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $form->open(); ?>

            <div class="panel-body">
                <!-- View massage -->
                <?php echo $form->messages(); ?>

                <div class="form-group margin">
                    <label class="col-sm-2 control-label"> <?= lang('title') ?> <span class="required">*</span></label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control input-lg" name="title" value="<?php if(!empty($project)) echo $project->title ?>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?= lang('status') ?> </label>

                    <div class="col-sm-7">
                        <select name="status" class="form-control input-lg">
                            <option value="<?= lang('waiting') ?>" <?php if(!empty($project)) echo $project->status === lang('waiting') ?'selected':''  ?>><?= lang('waiting') ?></option>
                            <option value="<?= lang('pending') ?>" <?php if(!empty($project)) echo $project->status === lang('pending') ?'selected':''  ?>><?= lang('pending') ?></option>
                            <option value="<?= lang('progress') ?>" <?php if(!empty($project)) echo $project->status === lang('progress') ?'selected':''  ?>><?= lang('progress') ?></option>
                            <option value="<?= lang('finished') ?>" <?php if(!empty($project)) echo $project->status === lang('finished') ?'selected':''  ?>><?= lang('finished') ?></option>
                            <option value="<?= lang('terminated') ?>" <?php if(!empty($project)) echo $project->status === lang('terminated') ?'selected':''  ?>><?= lang('terminated') ?></option>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?= lang('priority') ?> </label>

                    <div class="col-sm-7">
                        <select name="priority"  class="form-control input-lg">
                            <option value="<?= lang('low') ?>" <?php if(!empty($project)) echo $project->priority === lang('low') ?'selected':''  ?>><?= lang('low') ?></option>
                            <option value="<?= lang('medium') ?>" <?php if(!empty($project)) echo $project->priority === lang('medium') ?'selected':''  ?>><?= lang('medium') ?></option>
                            <option value="<?= lang('high') ?>" <?php if(!empty($project)) echo $project->priority === lang('high') ?'selected':''  ?>><?= lang('high') ?></option>
                            <option value="<?= lang('urgent') ?>" <?php if(!empty($project)) echo $project->priority === lang('urgent') ?'selected':''  ?>><?= lang('urgent') ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?= lang('customer') ?> <span class="required">*</span></label>

                    <div class="col-sm-7">
                        <select name="customer_id"  class="form-control select2 input-lg" >
                            <option value="" ><?= lang('please_select') ?>...</option>
                            <?php foreach ($customer as $item) : ?>
                                <option value="<?php echo $item->id ?>" <?php if(!empty($project)) echo $project->customer_id === $item->id ?'selected':''  ?>> <?php echo $item->customer_code.' '.$item->name?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group margin">
                    <label class="col-sm-2 control-label"> <?= lang('budget') ?> <span class="required">*</span></label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control input-lg" name="budget"  value="<?php if(!empty($project)) echo $project->budget ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?= lang('assign_to') ?> <span class="required">*</span></label>

                    <div class="col-sm-7">
                        <select name="employee_id[]"  class="form-control input-lg select2" multiple >
                            <option value="" ><?= lang('please_select') ?>...</option>
                            <?php foreach ($employee as $item) : ?>

                                <?php if(!empty($assign)){ foreach ($assign as $empId): ?>
                                <option value="<?php echo $item->id ?>" <?php echo $empId->employee_id === $item->id ?'selected':''  ?>> <?php echo $item->employee_id.' '.$item->first_name.' '.$item->last_name?></option>
                                <?php endforeach; }else{ ?>
                                    <option value="<?php echo $item->id ?>"> <?php echo $item->employee_id.' '.$item->first_name.' '.$item->last_name?></option>
                                <?php } ?>

                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group margin">
                    <label class="col-sm-2 control-label"><?= lang('start_date') ?><span class="required">*</span></label>

                    <div class="col-sm-7">
                        <div class="input-group">
                            <input  type="text" name="start_date" class="form-control datepicker input-lg" value="<?php if(!empty($project))  echo date('m/d/Y', strtotime($project->start_date));?>">
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
                            <input  type="text" name="due_date" class="form-control datepicker input-lg" value="<?php if(!empty($project))  echo date('m/d/Y', strtotime($project->due_date));?>">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>


                    <div class="form-group margin">
                        <label class="col-sm-2 control-label"><?= lang('note') ?><span class="required">*</span></label>

                        <div class="col-sm-7">
                            <textarea id="compose-textarea" class="form-control input-lg" rows="8" name="note"><?php if(!empty($project)) echo $project->note ?></textarea>
                        </div>
                    </div>

                <div class="form-group margin">
                    <label class="col-sm-2 control-label"> <?= lang('tags') ?> </label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control input-lg" name="tags" value="<?php if(!empty($project)) echo $project->tags ?>">
                    </div>
                </div>

                <div class="form-group margin">
                    <label class="col-sm-2 control-label"> <?= lang('link_to_calender') ?> </label>

                    <div class="col-sm-7">
                        <select name="calender" class="form-control">
                            <option value="0" <?php if(!empty($project)) echo $project->calender == 0 ?'selected':''  ?>><?= lang('no') ?></option>
                            <option value="1" <?php if(!empty($project)) echo $project->calender == 1 ?'selected':''  ?>><?= lang('yes') ?></option>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="project_id" value="<?php if(!empty($project)) echo my_encode($project->id) ?>">

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-1" >
                            <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-flat btn-md btn-block"><?= $btn ?></button>
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
