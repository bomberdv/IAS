
<?php
$user = $this->ion_auth->user()->row();

$employee = $this->db->select('employee .*, job_title.job_title, department.department, ')
    ->from('employee')
    ->join('job_title', 'job_title.id = employee.title', 'left')
    ->join('department', 'department.id = employee.department', 'left')
    ->where('employee.id', $user->employee_id)
    ->get()->row();

?>

<div class="wrapper">
    <?php $this->load->view('_partials/navbar'); ?>

    <?php // Left side column. contains the logo and sidebar ?>
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo $employee->photo !='' ? site_url(UPLOAD_EMPLOYEE.$employee->employee_id.'/'.$employee->photo) : site_url(IMAGE.'client.png') ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><b><?php echo $employee->first_name ?></b> <?php echo $employee->last_name ?></p>
                    <a href="#"><?php echo $employee->job_title ?></a>
                </div>
            </div>

            <?php // (Optional) Add Search box here ?>
            <?php //$this->load->view('_partials/sidemenu_search'); ?>
            <?php $this->load->view('_partials/sidemenu'); ?>
        </section>
    </aside>

    <?php // Right side column. Contains the navbar and content of the page ?>
    <div class="content-wrapper">
        <section class="content-header" style="height: 60px">
            <!--			<h1>--><?php //echo $page_title; ?><!--</h1>-->
            <?php $this->load->view('_partials/breadcrumb'); ?>
        </section>
        <section class="content">
            <?php $this->load->view($inner_view); ?>
            <?php $this->load->view('_partials/back_btn'); ?>
        </section>
    </div>

    <?php $this->load->view('_partials/_layout_modal_small'); ?>
    <?php $this->load->view('_partials/_layout_modal'); ?>

    <?php // Footer ?>
    <footer class="main-footer">
        <?php if (ENVIRONMENT=='development'): ?>
            <div class="pull-right hidden-xs">
                CI Bootstrap Version: <strong><?php echo CI_BOOTSTRAP_VERSION; ?></strong>,
                CI Version: <strong><?php echo CI_VERSION; ?></strong>,
                Elapsed Time: <strong>{elapsed_time}</strong> seconds,
                Memory Usage: <strong>{memory_usage}</strong>
            </div>
        <?php endif; ?>
        <strong>&copy; <?php echo date('Y'); ?> <a href="#"><?php //echo COMPANY_NAME; ?></a></strong> All rights reserved.
    </footer>

    <?php $this->load->view('_partials/sidebar'); ?>





</div>