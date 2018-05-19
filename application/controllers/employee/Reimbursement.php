<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Reimbursement extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // only login users can access Account controller
        $this->verify_login();
        $user = $this->ion_auth->user()->row();
        if($user->type != 'user'){
            redirect('auth/login');
        }

        $this->load->library('form_builder');
        $this->mTitle = TITLE;
    }


    function index(){
        $this->mViewData['panel'] = TRUE;
        $employeeID = $this->ion_auth->user()->row()->employee_id;
        $this->mViewData['reimbursements'] = $this->db->order_by('id', 'desc')->get_where('reimbursement', array(
            'employee_id' => $employeeID
        ))->result();

        $this->mTitle .= lang('reimbursement_list');

        $this->render('reimbursement');
    }

    function view($id=null){
        $id = my_decode($id);
        $id == TRUE || emp_home();

        $this->mViewData['reimbursement'] = $this->db->get_where('reimbursement', array(
            'id' => $id,
        ))->row();


        $this->mTitle .= lang('reimbursement');

        $this->render('reimbursement_view');
    }

    function viewPending($id=null){

        $id = my_decode($id);
        $id == TRUE || emp_home();

        $this->mViewData['reimbursement'] = $this->db->get_where('reimbursement', array(
            'id' => $id,
        ))->row();


        $this->mTitle .= lang('reimbursement');

        $this->render('reimbursement_view_pending');
    }

    function applicationForm(){


        $form = $this->form_builder->create_form('',true, array('class' =>'form-horizontal'));
        $employee_id = $this->ion_auth->user()->row()->employee_id;

        if ($form->validate())
        {
            $employee = $this->db->get_where('employee', array('id' => $employee_id))->row();
            $manager_id = $this->db->get_where('supervisor', array('employee_id' => $employee->id))->row()->supervisor_id;

            $data= array(
                'date'              => date("Y-m-d", strtotime($this->input->post('date'))),
                'department_id'     => $employee->department,
                'employee_id'       => $employee->id,
                'employee_name'     => $employee->first_name.' '.$employee->last_name,
                'manager_id'        => $manager_id,
                'amount'            => (double)$this->input->post('amount'),
                'memo'              => $this->input->post('memo'),
            );

            $this->db->insert('reimbursement', $data);

            $this->message->save_success('employee/reimbursement');

        }
        $this->mTitle= lang('new_reimbursement_form');
        $this->mViewData['form'] = $form;
        $this->render('reimbursement_form');
    }

    function approval()
    {
        $employeeID = $this->ion_auth->user()->row()->employee_id;
        $this->mViewData['reimbursements'] = $this->db->order_by('id', 'desc')->get_where('reimbursement', array(
            'manager_id' => $employeeID
        ))->result();

        $this->mTitle .= lang('reimbursement_list');

        $this->render('pending_reimbursement');
    }

    function update_manager()
    {
        $id = my_decode($this->input->post('id'));
        $data= array(
            'approved_manager'    => $this->input->post('approved_manager'),
            'manager_comment'     => $this->input->post('manager_comment'),
        );

        $this->db->where('id', $id);
        $this->db->update('reimbursement', $data);

        $this->message->save_success('employee/reimbursement/approval');

    }


}