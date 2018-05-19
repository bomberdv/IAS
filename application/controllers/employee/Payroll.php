<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Payroll extends MY_Controller
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

        // get yearly report
        if ($this->input->post('year', true)) { // if input data
            $year = $this->input->post('year', true);
            $this->mViewData['year'] = $year;
        } else {
            $year = date('Y'); // present year select
            $this->mViewData['year'] = $year;
        }

        $employee_id    = $this->ion_auth->user()->row()->employee_id;

            $this->mViewData['payroll_list'] = $this->db->select('payroll .*, employee.employee_id, employee.first_name, employee.last_name, employee.termination  ,job_title.job_title, department.department, ')
                ->from('payroll')
                ->join('employee', 'employee.id = payroll.employee_id', 'left')
                ->join('job_title', 'job_title.id = employee.title', 'left')
                ->join('department', 'department.id = payroll.department_id', 'left')
                ->where('payroll.employee_id', $employee_id)
                ->like('payroll.month', date('Y'))
                ->get()->result();


            $this->mViewData['selected_department'] = $this->input->post('department_id');


        $this->mTitle .= lang('payroll');
        $this->render('payroll_list');
    }


    function view($id=null){
       $id = my_decode($id);
       if(empty($id))
           emp_home();


        $this->mTitle .= lang('salary_payslip');

        $this->mViewData['pay_slip'] = $this->db->get_where('payroll', array('id' => $id))->row();
        $this->mViewData['employee'] = $this->db->get_where('employee', array('id' => $this->mViewData['pay_slip']->employee_id))->row();

        $this->mViewData['employee']    =  $this->db->select('employee .*, job_title.job_title, department.department, ')
            ->from('employee')
            ->join('job_title', 'job_title.id = employee.title', 'left')
            ->join('department', 'department.id = employee.department', 'left')
            ->where('employee.id', $this->mViewData['pay_slip']->employee_id)
            ->get()->row();

        $this->render('view_payroll');
    }


}