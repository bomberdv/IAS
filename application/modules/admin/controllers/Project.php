<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->mTitle = TITLE;
        $this->load->model('global_model');
        $this->load->model('crud_model', 'crud');
        $this->load->library('grocery_CRUD');
    }




    public function newProject($id= null)
    {
        $form = $this->form_builder->create_form('',true, array('class' =>'form-horizontal'));
        $id = my_decode($id);
        if ($form->validate())
        {

            $assign_to = json_encode($this->input->post('employee_id'));
            $employees = $this->input->post('employee_id');

            $data= array(
                'title'                 => $this->input->post('title'),
                'status'                => $this->input->post('status'),
                'priority'              => $this->input->post('priority'),
                'customer_id'           => $this->input->post('customer_id'),
                'budget'                => (double)$this->input->post('budget'),
                'start_date'            => date("Y-m-d", strtotime($this->input->post('start_date'))),
                'due_date'              => date("Y-m-d", strtotime($this->input->post('due_date'))),
                'assign_to'             => $assign_to,
                'note'                  => $this->input->post('note'),
                'tags'                  => $this->input->post('tags'),
                'calender'                  => $this->input->post('calender'),
            );

            if($id){
                $this->db->where('id', $id);
                $this->db->update('project', $data);

                //delete
                $this->db->delete('project_assign', array('project_id' => $id));
                //check assign
                foreach ($employees as $item) {
                    $data = array(
                        'project_id' => $id,
                        'employee_id' => $item,
                    );
                    $this->db->insert('project_assign', $data);
                }

                $this->_project_log($id, $activity = 'Update Project', $title='' );
                $this->message->save_success('admin/project/manageProject');

            }else{
                $this->db->insert('project', $data);
                $id = $this->db->insert_id();

                foreach ($employees as $item) {
                    $data = array(
                        'project_id' => $id,
                        'employee_id' => $item,
                    );
                    $this->db->insert('project_assign', $data);
                }
                $this->_project_log($id, $activity = 'Create New Project', $title='' );
                $this->message->save_success('admin/project/manageProject');
            }


        }

        $this->mViewData['customer'] = $this->db->get('customer')->result();
        $this->mViewData['project'] = $this->db->get_where('project', array( 'id' => $id))->row();
        $this->mViewData['assign'] = $this->db->get_where('project_assign', array( 'project_id' => $id))->result();
        $this->mViewData['employee'] = $this->db->get_where('employee', array(
            'termination' => 1,
            'soft_delete' => 0,
        ))->result();;

        if($id){
            $this->mTitle .= lang('edit_project');
            $this->mViewData['title'] = lang('edit_project');
            $this->mViewData['btn'] = lang('update');
        }else{
            $this->mTitle .= lang('new_project');
            $this->mViewData['title'] = lang('new_project');
            $this->mViewData['btn'] = lang('add');
        }

        $this->mViewData['form'] = $form;
        $this->render('project/crete_project');
    }

    public function manageProject()
    {
        $crud = new grocery_CRUD();
        $crud->columns('title','start_date','due_date','customer_id','status', 'budget', 'actions');
        $crud->order_by('id','desc');
        $crud->set_relation('customer_id', 'customer', 'name');

        $crud->display_as('start_date', lang('date').'(Y-M-D)');
        $crud->display_as('due_date', lang('date').'(Y-M-D)');
        $crud->display_as('actions', lang('actions'));
        $crud->set_table('project');

        $crud->callback_column('actions',array($this->crud,'_callback_action_project'));
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = lang('manage_project');

        $this->mTitle .= lang('manage_project');
        $this->render('project/project_list');
    }

    function viewProject(){
        $tab = $this->uri->segment(4);
        $id = $this->uri->segment(5);

        $id = my_decode($id);
        $id == TRUE || admin_home();

        $this->mViewData['project'] = $this->db->get_where('project', array( 'id' => $id,))->row();
        //$this->mViewData['tasks'] = $this->db->order_by('id', 'desc')->get_where('project_tasks', array('project_id' => $id))->result();

        $this->mViewData['tasks'] = $this->db->select('project_tasks.*, employee.first_name, employee.last_name ')
            ->from('project_tasks')
            ->join('employee', 'project_tasks.assign_to = employee.id', 'left')
            ->where('project_tasks.project_id', $id)
            ->get()
            ->result();
        $this->mViewData['logs'] = $this->db->get_where('project_log', array( 'project_id' => $id,))->result();
        $this->mViewData['tab'] = $tab;
        $this->mTitle .= lang('project_details');
        $this->render('project/view_project');
    }

    function add(){
        $tab = $this->uri->segment(4);
        $id = my_decode($this->uri->segment(5));
        if(empty($id)){
            admin_home();
        }


        if($tab === 'tasks'){
            $this->_add_tasks($id, $tab);
        }else{

        }
    }

    function _add_tasks($id, $tab){


        $form = $this->form_builder->create_form('admin/project/save_task',true, array('class' =>'form-horizontal'));
        $this->mViewData['employees'] = $this->db->select('project_assign.*, employee.first_name, employee.last_name ')
            ->from('project_assign')
            ->join('employee', 'employee.id = project_assign.employee_id', 'left')
            ->where('project_assign.project_id', $id)
            ->get()
            ->result();


        $this->mViewData['customer'] = $this->db->get('customer')->result();
        $this->mViewData['id'] = $id;
        $this->mViewData['tab'] = $tab;

        $this->mTitle= lang('add_new_task');
        $this->mViewData['form'] = $form;
        $this->render('project/add_task');
    }

    function save_task()
    {
        $this->form_validation->set_rules('title', lang('title'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_date', lang('start_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('due_date', lang('due_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('employee_id', lang('assign_to'), 'trim|required|xss_clean');

        $project_id = $this->input->post('project_id');
        $task_id = my_decode($this->input->post('task_id'));
        $tab = $this->input->post('tab');


        if ($this->form_validation->run() == TRUE) {

            $data = array(
                'project_id'    => my_decode($this->input->post('project_id')),
                'title'         => $this->input->post('title'),
                'status'        => $this->input->post('status'),
                'priority'      => $this->input->post('priority'),
                'start_date'    => date("Y-m-d", strtotime($this->input->post('start_date'))),
                'due_date'      => date("Y-m-d", strtotime($this->input->post('due_date'))),
                'assign_to'     => $this->input->post('employee_id'),
                'job'           => $this->input->post('note'),
            );


            if($task_id){
                $this->db->where('id', $task_id);
                $this->db->update('project_tasks', $data);
                $this->_project_log($id = my_decode($this->input->post('project_id')) , $activity = 'Update New Task', $title = $this->input->post('title') );
            }else{
                $this->db->insert('project_tasks', $data);
                $this->_project_log($id = my_decode($this->input->post('project_id')) , $activity = 'Create New Task', $title = $this->input->post('title') );
            }

            $this->message->save_success('admin/project/viewProject/'.$tab.'/'.$project_id);
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/project/add/'.$tab.'/'.$project_id, $error);
        }
    }

    function edit_task(){

        $tab = $this->uri->segment(4);
        $task_id = my_decode($this->uri->segment(5));

        if(empty($task_id)){
            admin_home();
        }


        $form = $this->form_builder->create_form('admin/project/save_task',true, array('class' =>'form-horizontal'));

        $this->mViewData['task'] = $this->db->get_where('project_tasks', array('id' => $task_id))->row();
        $this->mViewData['employees'] = $this->db->select('project_assign.*, employee.first_name, employee.last_name ')
            ->from('project_assign')
            ->join('employee', 'employee.id = project_assign.employee_id', 'left')
            ->where('project_assign.project_id', $this->mViewData['task']->project_id)
            ->get()
            ->result();

        $this->mViewData['customer'] = $this->db->get('customer')->result();
        $this->mViewData['id'] = $this->mViewData['task']->project_id;
        $this->mViewData['tab'] = $tab;

        $this->mTitle= lang('add_new_task');
        $this->mViewData['form'] = $form;
        $this->render('project/add_task');
    }

    function _project_log($projectId, $activity, $title)
    {
        $user = $this->ion_auth->user()->row();
        $data = array(
            'project_id'    => $projectId,
            'activity'      => $activity,
            'title'         => $title,
            'employee'      => $user->first_name.' '. $user->last_name,
        );
        $this->db->insert('project_log', $data);
    }






}