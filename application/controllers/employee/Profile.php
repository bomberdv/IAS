<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Profile extends MY_Controller
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
		$this->load->model('global_model');
        $this->load->library('form_builder');
        $this->load->library('form_validation');
        $this->mTitle = TITLE;
    }


    function index()
    {

        // only top-level users can reset Admin User passwords


        $user = $this->ion_auth->user()->row();

        $this->mViewData['employee'] =  $this->db->select('employee.*, department.department as department_name,
                                        job_title.job_title as job_title_name, job_category.category_name, emp_status.status_name, work_shift.shift_name ')
                                        ->from('employee')
                                        ->join('department', 'department.id = employee.department', 'left')
                                        ->join('job_title', 'job_title.id = employee.title', 'left')
                                        ->join('job_category', 'job_category.id = employee.category', 'left')
                                        ->join('emp_status', 'emp_status.id = employee.employment_status', 'left')
                                        ->join('work_shift', 'work_shift.id = employee.work_shift', 'left')
                                        ->where('employee.id', $user->employee_id)
                                        ->get()
                                        ->row();

        $form = $this->form_builder->create_form();

        $this->mViewData['form'] = $form;
        $this->mTitle .= lang('employee_profile');
        $this->render('employee_profile');
    }
	
	function employeeDetails($id =null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        
        if(empty($id)) {
            $url = $this->input->get('tab');
            $pieces = explode("/", $url);
            $tab = $pieces[0];
            $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $pieces[1]));
        }
        
        //select employee from database
        $data['employee'] = $this->global_model->get_employee($id);
        //country
        $data['provinces'] 	= $this->db->get('provinsi')->result();
		$data['countries'] 	= $this->db->get('kabupaten')->result();
		$data['districts'] 	= $this->db->get('kecamatan')->result();
		$data['villages'] 	= $this->db->get('kelurahan')->result();
        

        $data['employee'] == TRUE || $this->message->norecord_found('admin/employee/employeeList');

        if(!$this->input->get('tab') || $tab == 'personal' )
        {
            $view   = 'personal';
            $tab    = 'personal';
            $this->mTitle .= lang('personal_details');
        }
        elseif($tab == 'contact')
        {
            $view   = $tab;
            $tab    = $tab;
            $this->mTitle .= lang('contact_details');
        }
        elseif($tab == 'dependents')
        {
            $view   = $tab;
            $tab    = $tab;
            $this->mTitle .= lang('dependents');
        }
        elseif($tab == 'job')
        {
            $view   = $tab;
            $tab    = $tab;

            $data['job'] =    $this->db->select('job_history.*, department.department as department_name, job_title.job_title as title, emp_status.status_name, work_shift.shift_name, job_category.category_name')
                ->from('job_history')
                ->join('department', 'department.id = job_history.department','left')
                ->join('job_title', 'job_title.id = job_history.title','left')
                ->join('emp_status', 'emp_status.id = job_history.employment_status','left')
                ->join('work_shift', 'work_shift.id = job_history.work_shift','left')
                ->join('job_category', 'job_category.id = job_history.category','left')
                ->where('job_history.employee_id', $id)
                ->order_by('job_history.id', 'desc')
                ->get()
                ->result();

            $this->mTitle .= lang('employee_job');
        }
        elseif($tab == 'salary')
        {
            $view   = $tab;
            $tab    = $tab;

            $data['empSalary'] = $this->db->get_where('salary', array('employee_id' => $id ))->row();

            if(!empty($data['empSalary']->component))
            {
                $data['empSalaryDetails'] = json_decode($data['empSalary']->component,true);
            }

            $data['gradeList'] = $this->db->get('salary_grade')->result();
            $data['salaryEarningList'] = $this->db->get_where('salary_component', array('type' =>1))->result();
            $data['salaryDeductionList'] = $this->db->get_where('salary_component', array('type' =>2))->result();
            $this->mTitle .= lang('salary');
        }
        elseif($tab == 'report')
        {
            $view   = $tab;
            $tab    = $tab;
            $data['supervisor'] =  $this->db->select('employee.first_name, employee.last_name, supervisor.*, s_visor.first_name as supervisor_first_name, s_visor.last_name as supervisor_last_name')
                                    ->from('supervisor')
                                    ->join('employee', 'employee.id = supervisor.employee_id', 'left')
                                    ->join('employee as s_visor', 's_visor.id = supervisor.supervisor_id', 'left')
                                    ->where('supervisor.employee_id', $id)
                                    ->get()
                                    ->result();

            $data['subordinate'] =  $this->db->select('employee.first_name, employee.last_name, subordinate.*, s_ordinate.first_name as subordinate_first_name, s_ordinate.last_name as subordinate_last_name')
                                    ->from('subordinate')
                                    ->join('employee', 'employee.id = subordinate.employee_id', 'left')
                                    ->join('employee as s_ordinate', 's_ordinate.id = subordinate.subordinate_id', 'left')
                                    ->where('subordinate.employee_id', $id)
                                    ->get()
                                    ->result();

            $this->mTitle .= lang('employee_report');
        }
        elseif($tab == 'deposit')
        {
            $view   = $tab;
            $tab    = $tab;
//            $data['deposit'] = $this->db->get_where('users', array('employee_id' => $id))->row();
            $this->mTitle .= lang('direct_deposit');
        }
        elseif($tab == 'login')
        {
            $view   = $tab;
            $tab    = $tab;
            $data['login'] = $this->db->get_where('users', array('employee_id' => $id))->row();
            $this->mTitle .= lang('employee_login');
        }
        elseif($tab == 'termination')
        {
            $view   = $tab;
            $tab    = $tab;
            $data['termination'] = $this->db->get_where('employee', array('id' => $id))->row();
            $this->mTitle .= lang('termination_note');
        }


        $data['form']  = $this->form_builder->create_form();
        $this->mViewData['tab']                 = $tab;
        $this->mViewData['tab_view']            = $this->load->view('admin/employee/includes/'.$view,$data,true);
        $this->render('employee/employee_details');
    }
	
    public function reset_password()
    {
        $this->form_validation->set_rules('password', lang('password'), 'required');
        $this->form_validation->set_rules('retype_password', lang('retype_password'), 'required|matches[password]');

        if ($this->form_validation->run()== TRUE)
        {
            // pass validation
            $data = array('password' => $this->input->post('password'));

            // [IMPORTANT] override database tables to update Frontend Users instead of Admin Users
            $this->ion_auth_model->tables = array(
                'users'				=> 'users',
                'groups'			=> 'groups',
                'users_groups'		=> 'users_groups',
                'login_attempts'	=> 'login_attempts',
            );
            $id = $this->ion_auth->user()->row()->id;

            // proceed to change user password
            if ($this->ion_auth->update($id, $data))
            {
                $messages = $this->ion_auth->messages();
                $this->system_message->set_success($messages);
            }
            else
            {
                $errors = $this->ion_auth->errors();
                $this->message->custom_error_msg('employee/profile/' ,$errors);
            }
            $this->message->custom_success_msg('employee/profile/', lang('password_update_successfully'));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('employee/profile/' ,$error);
        }


    }



}