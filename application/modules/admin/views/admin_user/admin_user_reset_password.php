<div class="row">
	<div class="col-md-12">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border bg-primary-dark">
				<h3 class="box-title"><?= lang('admin_user_reset_password') ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo $form->open(); ?>

			<div class="box-body">

				<!-- View massage -->
				<?php echo $form->messages(); ?>

				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12">


						<table class="table table-bordered">
							<tr>
								<th style="width:120px"><?= lang('username') ?> : </th>
								<td><?php echo $target->username; ?></td>
							</tr>
							<tr>
								<th><?= lang('first_name') ?> : </th>
								<td><?php echo $target->first_name; ?></td>
							</tr>
							<tr>
								<th><?= lang('last_name') ?> : </th>
								<td><?php echo $target->last_name; ?></td>
							</tr>
							<tr>
								<th><?= lang('email') ?> : </th>
								<td><?php echo $target->email; ?></td>
							</tr>
						</table>
						<?php echo $form->bs3_password(lang('password'), 'new_password'); ?>
						<?php echo $form->bs3_password(lang('retype_password'), 'retype_password'); ?>


					</div>
				</div>
                <button class="btn btn-primary" type="submit" value="Submit"><i class="fa fa-save"></i> <?= lang('reset_password') ?></button>
			</div>
			<!-- /.box-body -->

			<?php echo $form->close(); ?>

		</div>
		<!-- /.box -->

	</div>
</div>

