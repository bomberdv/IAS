<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->load->model('settings_model');
        $this->load->model('global_model');
        $this->mTitle = TITLE;
    }

    function payrollList()
    {
        echo 'hi';
    }

    function employee()
    {
        $this->mTitle .= lang('make_payment');
        $this->mViewData['department'] = $this->db->select('*')->from('department')->where('branch_id', $this->session->userdata('branch_id'))->get()->result();
        $this->render('payroll/select_employee');
    }

    function payslip()
    {
        $this->mTitle .= lang('make_payment');
        $this->mViewData['department'] = $this->db->select('*')->from('department')->where('branch_id', $this->session->userdata('branch_id'))->get()->result();
        $this->render('payroll/payslip_type');
    }

    function payslip_employee()
    {
        $type = $this->input->post('type');

        $department = $this->input->post('department_id');
        $this->mViewData['employees'] = $this->db->select('employee.*, department.department as department_name , job_title.job_title,salary.id as salary_id, salary.total_payable, salary.total_cost_company, salary.total_deduction, salary.component, salary.type, salary.hourly_salary  ')
            ->from('employee')
            ->join('salary', 'employee.id = salary.employee_id', 'left')
            ->join('department', 'employee.department = department.id', 'left')
            ->join('job_title', 'employee.title = job_title.id', 'left')
            ->where('employee.department', $department)
            ->where('salary.type', $type)
            ->where('employee.termination', 1)
            ->where('employee.soft_delete', 0)
			->where('employee.branch_id', $this->session->userdata('branch_id'))
            ->get()
            ->result();

        $this->mViewData['department'] = $department;
        $this->mViewData['month'] = $this->input->post('month');
        $this->mTitle .= lang('make_payment');

        if($type == 'Monthly'){//monthly salary generate
            $this->render('payroll/monthly_payslip');
        }else{//hourly salary generate
            $this->mViewData['date_range'] = $this->input->post('date_range');
            $this->render('payroll/hourly_payslip');
        }
    }

    function save_batch_employee_payslip()
    {
        $employee_id = $this->input->post('employee_id');
        $fine = $this->input->post('fine');
        $bonus = $this->input->post('bonus');
        $month = $this->input->post('month');
        $payment_method = $this->input->post('payment_method');
        $note = $this->input->post('note');
        $sl = $this->input->post('sl');

        if (count($sl)) {
            foreach ($sl as $item) {
                //salary
                $salary = $this->db->get_where('salary', array('employee_id' => $employee_id[$item]))->row();
                //employee
                $employee = $this->db->get_where('employee', array('id' => $employee_id[$item]))->row();
                $total_payable = $salary->total_payable;
                //fine deduction
                if (!empty($fine)) {
                    $total_payable -= $fine[$item];
                }

                //add bonus
                if (!empty($bonus)) {
                    $total_payable += $bonus[$item];
                }

                //check duplicate payroll
                $prevPayroll = $this->db->get_where('payroll', array(
                    'employee_id' => $employee_id[$item],
                    'month' => $month
                ))->row();


                if (!empty($prevPayroll)) {
                    $has_payroll[] = array(
                        'id' => $prevPayroll->id,
                        'employee_id' => $employee_id[$item],
                        'department_id' => $employee->department,
                        'gross_salary' => $salary->total_payable + $salary->total_deduction,
                        'deduction' => $salary->total_deduction,
                        'net_salary' => $salary->total_payable,
                        'fine_deduction' => $fine[$item],
                        'bonus' => $bonus[$item],
                        'net_payment' => $total_payable,
                        'month' => $month,
                        'type' => $salary->type,
                        'payment_method' => $payment_method[$item],
                        'note' => $note[$item],
                    );
                } else {
                    $data[] = array(
                        'employee_id' => $employee_id[$item],
                        'department_id' => $employee->department,
                        'gross_salary' => $salary->total_payable + $salary->total_deduction,
                        'deduction' => $salary->total_deduction,
                        'net_salary' => $salary->total_payable,
                        'fine_deduction' => $fine[$item],
                        'bonus' => $bonus[$item],
                        'net_payment' => $total_payable,
                        'month' => $month,
                        'type' => $salary->type,
                        'payment_method' => $payment_method[$item],
                        'note' => $note[$item],
                    );
                }


            }//end foreach

            if(count($has_payroll)){
                $this->db->update_batch('payroll',$has_payroll, 'id');
            }
            if(count($data)){
                $this->db->insert_batch('payroll', $data);
            }

            $this->message->save_success('admin/payroll/viewPayment/'.$employee->department.'/'.$month);
        }else{
            $this->message->custom_error_msg('admin/payroll/employee', lang('need_to_select_employee'));
        }//end id
    }

    function save_batch_employee_hourlyPayslip()
    {
        $employee_id = $this->input->post('employee_id');
        $fine = $this->input->post('fine');
        $bonus = $this->input->post('bonus');
        $month = $this->input->post('month');
        $date_range = $this->input->post('date_range');
        $total_hour = $this->input->post('total_hour');
        $payment_method = $this->input->post('payment_method');
        $note = $this->input->post('note');
        $sl = $this->input->post('sl');


        if (count($sl)) {
            foreach ($sl as $item) {
                //salary
                $salary = $this->db->get_where('salary', array('employee_id' => $employee_id[$item]))->row();
                //employee
                $employee = $this->db->get_where('employee', array('id' => $employee_id[$item]))->row();
                $total_payable = $total_hour[$item] * $salary->hourly_salary;
                //fine deduction
                if (!empty($fine)) {
                    $total_payable -= $fine[$item];
                }

                //add bonus
                if (!empty($bonus)) {
                    $total_payable += $bonus[$item];
                }


                $data[] = array(
                    'employee_id' => $employee_id[$item],
                    'department_id' => $employee->department,
                    'gross_salary' => $salary->hourly_salary,
                    'total_hour' => $total_hour[$item],
                    'net_salary' => $salary->hourly_salary * $total_hour[$item],
                    'fine_deduction' => $fine[$item],
                    'bonus' => $bonus[$item],
                    'net_payment' => $total_payable,
                    'month' => $month,
                    'type' => $salary->type,
                    'date_range' => $date_range,
                    'payment_method' => $payment_method[$item],
                    'note' => $note[$item],
                );


            }//end foreach

            $this->db->insert_batch('payroll', $data);

            $this->message->save_success('admin/payroll/viewPayment/'.$employee->department.'/'.$month);
        }else{
            $this->message->custom_error_msg('admin/payroll/employee', lang('need_to_select_employee'));
        }//end id
    }


    function setEmployeePayment()
    {

        $this->form_validation->set_rules('department_id', lang('department'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('employee_id', lang('employee'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('month', lang('month'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == TRUE) {

            $this->mTitle .= lang('make_payment');
            $this->mViewData['department']  = $this->db->get_where('department', array('id' => $this->input->post('department_id')))->row();
            $this->mViewData['employee']    = $this->db->get_where('employee', array('id' => $this->input->post('employee_id')))->row();
            $this->mViewData['employee']    =  $this->db->select('employee .*, job_title.job_title, emp_status.status_name ')
                                                ->from('employee')
                                                ->join('job_title', 'job_title.id = employee.title', 'left')
                                                ->join('emp_status', 'emp_status.id = employee.employment_status', 'left')
                                                ->where('employee.id', $this->input->post('employee_id'))
                                                ->get()->row();



            $this->mViewData['month']       = $this->input->post('month');
            $this->mViewData['salary']      = $this->db->get_where('salary', array('employee_id' => $this->input->post('employee_id')))->row();
             $awal = ($this->input->post('month').'-01');
            $akhir = ($this->input->post('month').'-31');
            $id =$this->input->post('employee_id');
            $sql ='select count(employee_id) as bnyk from tbl_attendance where date >= "'.$awal.'" and  date <= "'.$akhir.'" and employee_id = '.$id;
            $q    =   $this->db->query($sql); 
            $this->mViewData['masuk'] = $q->row();
            // $this->mViewData['masuk']    =  $this->db->sql('count(employee_id)')
            //                                     ->from('tbl_attendance')
            //                                     ->where('date >=',$awal)
            //                                     ->where('date <=', $akhir)
            //                                     ->where('employee_id', $id)
            //                                     ->get()->row(); 

            //     $this->db->sql('count(employee_id)')
            //                                         ->from('tbl_attendance')
            //                                         ->where('date >=',$awal)
            //                                         ->where('date <=', $akhir)
            //                                         ->where('employee_id', $id);
            // $q = $this->db->get();
            //        $this->mViewData['masuk']  = $q->result();
            // var_dump($this->mViewData['masuk']);
            // die();
            if( $this->mViewData['salary']->type == 'Monthly'){
                $form = $this->form_builder->create_form('admin/payroll/savePayroll_monthly','',array('class' => 'form-horizontal'));
                $this->mViewData['form'] = $form;
                $this->mViewData['type'] = 'Monthly';
                $this->mViewData['payroll']     = $this->db->get_where('payroll', array(
                    'employee_id' => $this->input->post('employee_id'),
                    'month' =>$this->input->post('month')
                ))->row();
            }else{
                $form = $this->form_builder->create_form('admin/payroll/savePayroll_hourly','',array('class' => 'form-horizontal'));
                $this->mViewData['form'] = $form;
                $this->mViewData['type'] = 'Hourly';

            }

            $this->mViewData['salary'] == TRUE || $this->message->custom_error_msg('admin/payroll/employee','Sorry! This Employee salary has not set yet.');
            $this->mViewData['award']       = $this->db->get_where('employee_award', array(
                                                'award_month' => $this->input->post('month'),
                                                'employee_id' =>$this->input->post('employee_id')
                                                ))->result();



            $this->render('payroll/make_payment');

        } else {
            $error = validation_errors();
            $this->message->custom_error_msg('admin/payroll/employee',$error);
        }
    }

    function editPaySlip($id = null)
    {
        $payroll_id = my_decode($id);
        if(empty($payroll_id))
            admin_home();

        $payroll = $this->db->get_where('payroll', array('id' => $payroll_id))->row();

        $this->mTitle .= lang('make_payment');
        $this->mViewData['department']  = $this->db->get_where('department', array('id' => $payroll->department_id))->row();
        $this->mViewData['employee']    =  $this->db->select('employee .*, job_title.job_title, emp_status.status_name ')
            ->from('employee')
            ->join('job_title', 'job_title.id = employee.title', 'left')
            ->join('emp_status', 'emp_status.id = employee.employment_status', 'left')
            ->where('employee.id', $payroll->employee_id)
            ->get()->row();

        $this->mViewData['month']       = $payroll->month;
        $this->mViewData['salary']      = $this->db->get_where('salary', array('employee_id' => $payroll->employee_id))->row();

        if( $this->mViewData['salary']->type == 'Monthly'){
            $form = $this->form_builder->create_form('admin/payroll/savePayroll_monthly','',array('class' => 'form-horizontal'));
            $this->mViewData['form'] = $form;
            $this->mViewData['type'] = 'Monthly';
        }else{
            $form = $this->form_builder->create_form('admin/payroll/savePayroll_hourly','',array('class' => 'form-horizontal'));
            $this->mViewData['form'] = $form;
            $this->mViewData['type'] = 'Hourly';
        }

        $this->mViewData['award']       = $this->db->get_where('employee_award', array(
            'award_month' => $payroll->month,
            'employee_id' => $payroll->employee_id
        ))->result();

        $this->mViewData['payroll']     = $payroll;

        $this->render('payroll/make_payment');
    }

    public function savePayroll_monthly()
    {
        $this->form_validation->set_rules('payment_method', lang('payment_method'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('employee_id', TRUE)));
            $month = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('month', TRUE)));



            //check duplicate payroll
            $payroll_id = $this->db->get_where('payroll', array(
                'employee_id' => $id,
                'month' => $month
            ))->row()->id;

            //salary
            $salary = $this->db->get_where('salary', array('employee_id' => $id))->row();
            //award
            $award  = $this->db->get_where('employee_award', array(
                            'award_month' => $month,
                            'employee_id' =>$id
                        ))->result();
            //employee
            $employee = $this->db->get_where('employee', array('id' => $id))->row();
                $awal = ($month.'-01');
            $akhir = ($month.'-31');
            $sql ='select count(employee_id) as bnyk from tbl_attendance where date >= "'.$awal.'" and  date <= "'.$akhir.'" and employee_id = '.$id;
            $q    =   $this->db->query($sql); 
            // $masuk = $q->row();
            foreach ($q->result() as $row)
                {
                        $bnyk = $row->bnyk;
                }
            $utm = ((($salary->total_payable*(0.7/100)*21)/21)*$bnyk);
           
            $data['employee_id']    = $id;
            $data['department_id']  = $employee->department;
            $data['gross_salary']   = $salary->total_payable + $salary->total_deduction + $utm;
            $data['deduction']      = $salary->total_deduction;
            $data['net_salary']     = $salary->total_payable;
            $data['utm']            = $utm;
            $total_payable = $salary->total_payable;

            if(!empty($award)){
                $employee_award = array();
                foreach($award as $item){
                    if(!empty($item->award_amount)) {
                        $employee_award[] = array(
                            'award_name' => $item->award_name,
                            'award_amount' => $item->award_amount,
                        );
                        $total_payable += $item->award_amount;
                    }
                }

                $data['award'] = json_encode($employee_award);
            }

            //fine deduction
            if(!empty($this->input->post('fine_deduction', TRUE))){
                $data['fine_deduction'] = $this->input->post('fine_deduction', TRUE);
                $total_payable -= $data['fine_deduction'];
            }

            //add bonus
            if(!empty($this->input->post('bonus', TRUE))){
                $data['bonus'] = $this->input->post('bonus', TRUE);
                $total_payable += $data['bonus'];
            }

            $data['net_payment'] = $total_payable;
            $data['payment_method'] = $this->input->post('payment_method', TRUE);
            $data['note'] = $this->input->post('note', TRUE);
            $data['month'] = $month;


            //validation check @id and @month
            if($id && $month){//validation check
                if($payroll_id){//update
                    $this->db->where('id', $payroll_id);
                    $this->db->update('payroll', $data);
                    $paySleepID = $payroll_id;
                }else{//insert new data
                    $this->db->insert('payroll', $data);
                    $paySleepID = $this->db->insert_id();
                }
            }else{//redirect with error
                $this->message->norecord_found('admin/payroll/employee/');
            }

            
            $this->message->save_success('admin/payroll/employeePaySlip/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($paySleepID)));
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/payroll/employee/',$error);
        }
    }

    function savePayroll_hourly()
    {
        $this->form_validation->set_rules('date_range', lang('date_range'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('total_hour', lang('total_hour'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $id = my_decode($this->input->post('employee_id', TRUE));
            $month = my_decode($this->input->post('month', TRUE));
            $date_range =$this->input->post('date_range', TRUE);
            $total_hour =$this->input->post('total_hour', TRUE);

            $payroll_id = my_decode($this->input->post('payroll_id', TRUE));

            //salary
            $salary = $this->db->get_where('salary', array('employee_id' => $id))->row();
            //award
            $award  = $this->db->get_where('employee_award', array(
                'award_month' => $month,
                'employee_id' =>$id
            ))->result();
            //employee
            $employee = $this->db->get_where('employee', array('id' => $id))->row();
        
         
            $total_payable = $salary->hourly_salary * $total_hour ;

            if(!empty($award)){
                $employee_award = array();
                foreach($award as $item){
                    if(!empty($item->award_amount)) {
                        $employee_award[] = array(
                            'award_name' => $item->award_name,
                            'award_amount' => $item->award_amount,
                        );
                        $total_payable += $item->award_amount;
                    }
                }
            }

            //fine deduction
            if(!empty($this->input->post('fine_deduction', TRUE))){
                $total_payable -= (double)$this->input->post('fine_deduction', TRUE);
            }

            //add bonus
            if(!empty($this->input->post('bonus', TRUE))){
                $total_payable += (double)$this->input->post('bonus', TRUE);
            }


            $data = array(
                'employee_id' => $id,
                'department_id' => $employee->department,
                'gross_salary' => $salary->hourly_salary,
                'total_hour' => $total_hour,
                'net_salary' => $salary->hourly_salary * $total_hour,
                'fine_deduction' => (double)$this->input->post('fine_deduction', TRUE),
                'bonus' => (double)$this->input->post('bonus', TRUE),
                'net_payment' => $total_payable,
                'award' =>  json_encode($employee_award),
                'month' => $month,
                'type' => $salary->type,
                'date_range' => $date_range,
                'payment_method' => $this->input->post('payment_method', TRUE),
                'note' => $this->input->post('note', TRUE),
            );


            //validation check @id and @month
            if($id && $month){//validation check
                if($payroll_id){//update
                    $this->db->where('id', $payroll_id);
                    $this->db->update('payroll', $data);
                    $paySleepID = $payroll_id;
                }else{//insert new data
                    $this->db->insert('payroll', $data);
                    $paySleepID = $this->db->insert_id();
                }
            }else{//redirect with error
                $this->message->norecord_found('admin/payroll/employee/');
            }

            $this->message->save_success('admin/payroll/employeePaySlip/'. my_encode($paySleepID));
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/payroll/employee/',$error);
        }
    }



    function employeePaySlip($id = null)
    {
        $this->mTitle .= lang('salary_payslip');
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        $id == TRUE || $this->message->norecord_found('admin/payroll/employee');

        $this->mViewData['pay_slip'] = $this->db->get_where('payroll', array('id' => $id))->row();
        $this->mViewData['employee'] = $this->db->get_where('employee', array('id' => $this->mViewData['pay_slip']->employee_id))->row();

        $this->mViewData['employee']    =  $this->db->select('employee .*, job_title.job_title, department.department, ')
                                            ->from('employee')
                                            ->join('job_title', 'job_title.id = employee.title', 'left')
                                            ->join('department', 'department.id = employee.department', 'left')
                                            ->where('employee.id', $this->mViewData['pay_slip']->employee_id)
                                            ->get()->row();


        $this->render('payroll/employee_payslip');
    }

    function listSalaryPayment()
    {
        $this->mTitle .= lang('employee_payroll_list');
        $this->mViewData['department'] = $this->db->select('*')->from('department')->where('branch_id', $this->session->userdata('branch_id'))->get()->result();

        if($this->input->post('department_id') && $this->input->post('month') ){


            $this->mViewData['payroll_list'] = $this->db->select('payroll .*, employee.employee_id, employee.first_name, employee.last_name, employee.termination  ,job_title.job_title, department.department, ')
                ->from('payroll')
                ->join('employee', 'employee.id = payroll.employee_id', 'left')
                ->join('job_title', 'job_title.id = employee.title', 'left')
                ->join('department', 'department.id = payroll.department_id', 'left')
                ->where('payroll.department_id', $this->input->post('department_id'))
                ->where('payroll.month', $this->input->post('month'))
                ->get()->result();

            $this->mViewData['selected_department'] = $this->input->post('department_id');
            $this->mViewData['date'] = $this->input->post('month');
        }
        $this->render('payroll/list_payroll');
    }

    function viewPayment()
    {
        $department= $this->uri->segment(4);
        $month = $this->uri->segment(5);

        $this->mTitle .= lang('employee_payroll_list');
        $this->mViewData['department'] = $this->db->get('department')->result();
        $this->mViewData['selected_department'] = $department;
        $this->mViewData['date'] = $month;

        if($department && $month ){


            $this->mViewData['payroll_list'] = $this->db->select('payroll .*, employee.employee_id, employee.first_name, employee.last_name, employee.termination  ,job_title.job_title, department.department, ')
                ->from('payroll')
                ->join('employee', 'employee.id = payroll.employee_id', 'left')
                ->join('job_title', 'job_title.id = employee.title', 'left')
                ->join('department', 'department.id = payroll.department_id', 'left')
                ->where('payroll.department_id', $department)
                ->where('payroll.month', $month)
                ->order_by('payroll.employee_id', 'asc')
                ->get()->result();
        }
        $this->render('payroll/list_payroll');
    }

    function deletePayroll($id = null)
    {
        $id = my_decode($id);
        if(empty($id))
            admin_home();
        $pieces = explode("*", $id);

        $department = $pieces[0];
        $month = $pieces[1];
        $id = $pieces[2];

        $this->db->delete('payroll', array('id' => $id));
        $this->message->delete_success('admin/payroll/viewPayment/'.$department.'/'.$month);
    }



}