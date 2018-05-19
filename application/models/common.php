<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Common Extends CI_Model
{
	
	function clean_string($string)
	{
	   $string = str_replace(' ', '-', strtolower($string));
	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string);		
	}
	
	function getChatList()
	{
		$arr_data = array('' => '--Select--');
		$select = array(
						'id',
						'name'
					);
		$where = array(
						'is_active' => '1'
					);
		$this->db->select($select);
		$this->db->from('cc_user');
		$this->db->where($where);
		$query = $this->db->get();
		$data = $query->result();
		foreach($data as $row){
				$arr_data[$row->id."-chatting"] = $row->name;
		}
		return $arr_data;		
	}
	
	function generateCode()
	{
		// $s = strtoupper(md5(uniqid(rand(),true))); 
		// $guidText = date('mdHi').'-'.substr($s,26); 
		// return $guidText;
		$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
		shuffle($seed);
		$rand = '';
		foreach (array_rand($seed, 4) as $k) $rand .= $seed[$k];
		$s = strtoupper(md5(uniqid(rand(),true))); 
		$guidText = date('dhs').$rand;
		return $guidText;		
	}
	
	function generateCodeProspect()
	{
		$s = strtoupper(md5(uniqid(rand(),true))); 
		$guidText = date('mdHi').'-'.substr($s,26); 
		return $guidText;
		// $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
		// shuffle($seed);
		// $rand = '';
		// foreach (array_rand($seed, 4) as $k) $rand .= $seed[$k];
		// $s = strtoupper(md5(uniqid(rand(),true))); 
		// $guidText = date('dhs').$rand;
		// return $guidText;		
	}
	
	public function getRefMaster($fieldName, $tableName, $criteria, $orderBy, $header=null)
	{
		$arrData = array("" => (!is_null($header)?$header:"[select data]"));
		$sql = "SELECT ".$fieldName." FROM ".$tableName;
		
		if($criteria)
		{
			$sql .= " WHERE ".$criteria;
		}
		
		if($orderBy)
		{
			$sql .= " ORDER BY ".$orderBy;
		}
		$query = $this->db->query($sql);
		
		if ($query->num_rows())
		{
			foreach ($query->result() as $row)
			{
				$arrData[$row->value] = $row->item;
			}
		}
		return $arrData;	
	}
	
	public function getRefMasterCti($fieldName, $tableName, $criteria, $orderBy, $header=null)
	{
		$this->cti = $this->load->database('ecentrix', true);
		$arrData = array("" => (!is_null($header)?$header:"[select data]"));
		$sql = "SELECT ".$fieldName." FROM ".$tableName;
		
		if($criteria)
		{
			$sql .= " WHERE ".$criteria;
		}
		
		if($orderBy)
		{
			$sql .= " ORDER BY ".$orderBy;
		}
		
		// echo $sql;
		$query = $this->cti->query($sql);
		
		if ($query->num_rows())
		{
			foreach ($query->result() as $row)
			{
				$arrData[$row->value] = $row->item;
			}
		}
		$this->cti->close();
		return $arrData;	
	}
	
	function getRunningText()
	{		
		$sql = "SELECT a.message FROM cc_running_text a
				join cc_running_text_detail b on a.id=b.running_text_id
				WHERE a.start_date <= NOW() AND a.end_date >= NOW() and a.is_active='1' and b.user_group='".$this->encrypt->decode($this->session->userdata('GROUP_ID'), $this->config->item('encryption_key'))."'
				group by a.id
				order by a.start_date,a.created_time, a.updated_time asc";
		//echo $sql;
		$query = $this->db->query($sql);
		$message = "";
		$jumlah = $query->num_rows();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row)
			{
				
				if($jumlah%2==0){
					if(!empty($message)) {
						$message .= " <img src='/assets/img/navigate_left2.png'> <span style='color:orange'>".$row->message.'</span>';
					}else{
						$message .= "<span style='color:white'>".$row->message.'</span>';
					}
				}else{
					if(!empty($message)) {

						$message .= " <img src='/assets/img/navigate_left2.png'> <span style='color:yellow'>".$row->message.'</span>';
					}else{
						$message .= "<span style='color:yellow'>".$row->message.'</span>';
					}
				}
				$jumlah = $jumlah-1;
			}
		}
		else
		{
		$message = 'Welcome To Helpdesk Contact Center.';
		}

		return $message;
	}
	
	function getRecordValue($fieldName, $tableName, $criteria)
	{	
		$sql = "SELECT $fieldName FROM $tableName WHERE $criteria";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			return array_pop($query->row_array());
		}
		return null;
	}
	
	function getRecordValueCti($fieldName, $tableName, $criteria)
	{	
		$this->cti = $this->load->database('ecentrix', true);
		$sql = "SELECT $fieldName FROM $tableName WHERE $criteria";
		$query = $this->cti->query($sql);
		
		if ($query->num_rows() > 0)
		{
			return array_pop($query->row_array());
		}
		return null;
	}
	
	function getDataTimeFrame($fieldName, $tableName, $criteria)
	{
		$this->db = $this->load->database('default', true);
		$sql = "SELECT $fieldName FROM $tableName WHERE $criteria";
		$query = $this->db->query($sql);
		$data = $query->result();
		$query->free_result();
		return $data;				
	}
	
	function getDataTimeFrameCti($fieldName, $tableName, $criteria)
	{
		$this->cti = $this->load->database('ecentrix', true);
		$sql = "SELECT $fieldName FROM $tableName WHERE $criteria";
		$query = $this->cti->query($sql);
		$data = $query->result();
		$query->free_result();
		$this->cti->close();
		return $data;				
	}	
	
	function slaTelephony($context)
	{
		$this->cti = $this->load->database('ecentrix', true);
		$sql = "SELECT 
			a.agent_id as agent_id, a.direction as direction, a.start_time as start_time, a.end_time as end_time,
			SUM( CASE b.current_status WHEN 1 THEN (b.duration/1000) ELSE 0 END )+(SUM( CASE b.current_status WHEN 3 THEN (b.duration/1000) ELSE 0 END ))+(SUM( CASE b.current_status WHEN 4 THEN (b.duration/1000) ELSE 0 END )) jumlah, 
			a.last_status as last_status, a.context as context, now() as insert_time, a.start_time as report_time
		FROM
			ecentrix.ecentrix_session_log a, ecentrix.ecentrix_session_track b
		WHERE
			a.id = b.session_log_id
			and date(a.start_time) = date(now())
			and direction='INB' and a.last_status in (10, 19, 14, 15)
		GROUP BY
			a.call_id";
		$query = $this->cti->query($sql);	
		$less = array();
		$more = array();
		$abandone_while_ringing = array();
		$abandone_on_queue = array();
		$abandone_transfer = array();
		$abandone_more = array();
		$abandone_less = array();
		foreach($query->result() as $data){
			if(($data->last_status == '10')){
				$less[] = $data->jumlah;
			}else if(($data->last_status == '10')){
				$more[] = $data->jumlah;
			}else if(($data->last_status != '10')){
				$abandone_less[] = $data->jumlah;
			}else if(($data->last_status != '10')){
				$abandone_more[] = $data->jumlah;
			}
			if($data->last_status == '14'){
				$abandone_on_queue[] = $data->jumlah;
			}
			if($data->last_status == '19'){
				$abandone_while_ringing[] = $data->jumlah;
			}
			if($data->last_status == '15'){
				$abandone_transfer[] = $data->jumlah;
			}
		}
		if(count($less) == 0){
			$percent = 0;
		}else{
			$percent = round(((count($less) / (count($less) + count($more) + count($abandone_less) + count($abandone_more)))*100),2);
		}
		$total = (count($more) + count($abandone_more) + count($abandone_less));
		
		$sql = "select
				sec_to_time(floor(avg(a.service_time/1000))) service_time,
				sec_to_time(floor(avg(a.ring_time/1000))) ring_time,
				sec_to_time(floor(avg(a.hold_time/1000))) hold_time,
				sec_to_time(floor(sum(a.talk_time/1000))) talk_time
				from ecentrix.ecentrix_session_log a
				where date(a.start_time)=current_date()
				group by date(a.start_time);
				";
		$query = $this->db->query($sql);
		$service_time = '';
		$ring_time = '';
		$hold_time = '';
		$talk_time = '';
		foreach($query->result() as $row){
			$service_time = $row->service_time;
			$ring_time = $row->ring_time;
			$hold_time = $row->hold_time;
			$talk_time = $row->talk_time;
		}
		$arr_data = array(
						// "total_call" => $total, 
						"total_call" => $this->common->getRecordValue('count(*)','ecentrix.ecentrix_session_log','date(start_time)=current_date() and last_status in (10,14,19)'), 
						"less" => count($less), 
						"more" => count($more), 
						"abandone_more" => count($abandone_more), 
						"abandone_less" => count($abandone_less), 
						"percent" => $percent, 
						"abandoneRinging" => count($abandone_while_ringing), 
						"abandoneQueue" => count($abandone_on_queue), 
						"abandoneTransfer" => count($abandone_transfer),
						"service_time" => $service_time,
						"ring_time" => $ring_time,
						"hold_time" => $hold_time,
						"talk_time" => $talk_time						
					);
		return json_encode($arr_data);		
		
	}
	
	function slaTelephonyOut($context, $direction)
	{
		$this->cti = $this->load->database('ecentrix', true);
		$sql = "SELECT 
			a.agent_id as agent_id, a.direction as direction, a.start_time as start_time, a.end_time as end_time,
			SUM( CASE b.current_status WHEN 1 THEN (b.duration/1000) ELSE 0 END )+(SUM( CASE b.current_status WHEN 3 THEN (b.duration/1000) ELSE 0 END ))+(SUM( CASE b.current_status WHEN 4 THEN (b.duration/1000) ELSE 0 END )) jumlah, 
			a.last_status as last_status, a.context as context, now() as insert_time, a.start_time as report_time
		FROM
			ecentrix.ecentrix_session_log a, ecentrix.ecentrix_session_track b
		WHERE
			a.id = b.session_log_id AND a.context='".$context."'
			and date(a.start_time) = date(now())
			and direction='".$direction."' and a.last_status in (10, 16, 24)
		GROUP BY
			a.call_id";
		$query = $this->cti->query($sql);	
		$call = array();
		$more = array();
		$abandone_while_ringing = array();
		$abandone_on_queue = array();
		$abandone_transfer = array();
		$abandone_more = array();
		$abandone_less = array();
		$abandone_out_1 = array();
		$abandone_out_2 = array();
		foreach($query->result() as $data){
			if($data->last_status == '10'){
				$call[] = $data->jumlah;
			}
			if($data->last_status == '16'){
				$abandone_out_1[] = $data->jumlah;
			}
			if($data->last_status == '24'){
				$abandone_out_2[] = $data->jumlah;
			}
		}
		$total = count($call);
		$arr_data = array(
						"total_call" => $total, 
						"abandoneOut1" => count($abandone_out_1),
						"abandoneOut2" => count($abandone_out_2)
					);
		return json_encode($arr_data);		
		
	}	
	
	function knowledgeData()
	{
		$sql = "select description, description_file, file_path, SUBSTRING_INDEX(file_path, '/', -1) file_name
				from cc_knowledge 
				where description like '%".$this->input->get_post('id')."%' 
				or description_file like '%".$this->input->get_post('id')."%' 
				or file_path like '%".$this->input->get_post('id')."%'";
		$query = $this->db->query($sql);
		$total = $query->num_rows();
		$list = array();
		foreach($query->result() as $row){
			$list[] = array(
						'description' => $row->description." - ".$row->description_file,
						'file' => $row->file_path,
						'file_name' => $row->file_name,
					);
		}
		$result = array(
					'total' => $total,
					'list' => $list
				);
		echo json_encode($result);		
	}
	
	function jsonData()
	{
		$arrColor = array('0'=>'#808080', '1'=>'#68BC31', '2'=>'#DA5430', '3'=>'#AF4E96');
		$arrLabel = array('0'=>'Agent Not Login', '1'=>'Agent Idle', '2'=>'Agent Not Active', '3'=>'Agent Talking');	
		$arrData = array('0'=>'0','1'=>$this->input->get_post('idle'),'2'=>$this->input->get_post('notactive'),'3'=>$this->input->get_post('talking'));
		for($i=1;$i<=3;$i++){
			$list[] = array(
						'label' => $arrLabel[$i],
						'data' => $arrData[$i],
						'color' => $arrColor[$i],
					);			
		}
		echo json_encode($list);		
	}
	
	function checkPhone($phone)
	{
		$real_phone = $phone;
		
		$sql = "SELECT customer_id FROM cc_master_customer_phone WHERE mobile_phone='".$real_phone."' or customer_id like '%".$id."%' ";
		// echo $sql;
		$query = $this->db->query($sql);		
		if($query->num_rows() == 1){
			$responce = array("num_rows"=>$query->num_rows(), "customer_id"=>array_pop($query->row_array()));
			echo json_encode($responce);
		}
		else if($query->num_rows() == 0){
			$responce = array("num_rows"=>$query->num_rows(), "customer_id"=>"");
			echo json_encode($responce);
		}
		else{
			$customer_id = '';
			$j = 0;
			foreach($query->result() as $row){
				if($j == 0 ){
					$customer_id .= $row->customer_id;
				}
				else{
					$customer_id .= ','.$row->customer_id;
				}
				$j++;
			}
			$responce = array("num_rows"=>$query->num_rows(), "customer_id"=>$customer_id);
			echo json_encode($responce);
		}		
	}
	
	function getCustomerId($id)
	{
		$sql = "SELECT * FROM cc_master_customer a WHERE 
				a.contact_phone like '%".$id."%'
				or a.email like '%".$id."%' 
				or a.contact_phone_it like '%".$id."%' 
				or a.email_it like '%".$id."%' 
				or a.contact_phone_finance like '%".$id."%' 
				or a.email_finance like '%".$id."%'
				or a.customer_id like '%".$id."%' 
				limit 1";
		$query = $this->db->query($sql);
		if($query->num_rows() == '0'){

		}else{
			foreach($query->result() as $row){
				echo $row->customer_id;
			}
		}
	}	
	
	function getCustomerNumber($id)
	{
		$sql = "SELECT * FROM cc_master_customer a WHERE 
				a.contact_phone like '%".$id."%'
				or a.email like '%".$id."%' 
				or a.contact_phone_it like '%".$id."%' 
				or a.email_it like '%".$id."%' 
				or a.contact_phone_finance like '%".$id."%' 
				or a.email_finance like '%".$id."%'
				or a.customer_id like '%".$id."%' 
				limit 1";
		$query = $this->db->query($sql);
		if($query->num_rows() == '0'){

		}else{
			foreach($query->result() as $row){
				echo $row->customer_id;
			}
		}
	}
	
	function getNonCustomerId($id)
	{
		$sql = "SELECT * FROM cc_master_customer a WHERE 
				a.contact_phone like '%".$id."%'
				or a.email like '%".$id."%' 
				or a.contact_phone_it like '%".$id."%' 
				or a.email_it like '%".$id."%' 
				or a.contact_phone_finance like '%".$id."%' 
				or a.email_finance like '%".$id."%'
				or a.customer_id like '%".$id."%' 
				limit 1";
		$query = $this->db->query($sql);
		foreach($query->result() as $row){
			echo $row->customer_id;
		}
	}
	
	function getCustomer($id)
	{
		$sql = "select a.id
					from cc_master_customer a
					where 
				a.contact_phone like '%".$id."%'
				or a.email like '%".$id."%' 
				or a.contact_phone_it like '%".$id."%' 
				or a.email_it like '%".$id."%' 
				or a.contact_phone_finance like '%".$id."%' 
				or a.email_finance like '%".$id."%'
				or a.customer_id like '%".$id."%' 
					limit 1";
		$query = $this->db->query($sql);
		foreach($query->result() as $row){
			echo $row->customer_id;
		}
	}
	
	function getMonitoringAgent()
	{
		$data = array(
					'id' => uuid(false),
					'module' => $this->input->get_post('module'), 
					'start_time' => date('Y-m-d H:i:s'),
					'agent_id' => $this->encrypt->decode($this->session->userdata('USER_ID'), $this->config->item('encryption_key')),
					'created_time' => date('Y-m-d H:i:s'),
				);
		$this->db->insert('cc_monitoring_agent', $data);		
	}
	
	function knowledgeMonitoring()
	{
		$data = array(
					'id' => uuid(false),
					'module' => $this->input->get_post('module'), 
					'start_time' => date('Y-m-d H:i:s'),
					'agent_id' => $this->encrypt->decode($this->session->userdata('USER_ID'), $this->config->item('encryption_key')),
					'created_time' => date('Y-m-d H:i:s'),
				);
		$this->db->insert('cc_knowledge_monitoring', $data);
	}
	
	function ticket_increament()
	{
		$year = date('Y');
		$ticket = $year.date('md').'0001';
		$sql = "select ticket_id from cc_queue where ticket_id='".$ticket."' order by ticket_id desc limit 0,1";
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			$rs = "select max(ticket_id) as id from cc_queue order by ticket_id desc";
			$exec = $this->db->query($rs);
			foreach ($exec->result() as $row)
			{
				return $row->id+1;
			}
		}
		else
		{
			return $ticket;
		}
	}	

	function createQueue()
	{
		$media = $this->input->get_post('media');
		$inbound_source_id = $this->input->get_post('inbound_source_id');
		$from = $this->input->get_post('from');
		$url = $this->input->get_post('url');
		$message = $this->input->get_post('message');
		
		$data = array(
					'id' => $inbound_source_id,
					'inbound_source_id' => $inbound_source_id,
					'source_id' => $media,
					'name' => $from,
					'message' => $message,
					'pickup_flag' => '1',
					'pickup_by' => $this->encrypt->decode($this->session->userdata('USER_ID'), $this->config->item('encryption_key')),
					'modules' => $url,
					'pickup_time' => date('Y-m-d H:i:s'),
					'created_time' => date('Y-m-d H:i:s')
				);
		$this->db->insert('cc_queue', $data);
		echo $inbound_source_id;
	}
	
	function callAlert()
	{
		$ticket = $this->ticket_increament();
		$data = array(
					'id' => uuid(false),
					'ticket_id' => $ticket,
					'inbound_source_id' => $this->input->get_post('inbound_source_id'),
					'source_id' => $this->input->get_post('source_id'),
					'name' => $this->input->get_post('name'),
					'message' => $this->input->get_post('message'),
					'pickup_flag' => '1',
					'pickup_by' => $this->encrypt->decode($this->session->userdata('USER_ID'), $this->config->item('encryption_key')),
					'modules' => $this->input->get_post('module'),
					'pickup_time' => date('Y-m-d H:i:s'),
					'created_time' => date('Y-m-d H:i:s')
				);
		$this->db->insert('cc_queue', $data);
		$this->session->set_userdata('CURRENT_TICKET_ID', $ticket);
		echo $ticket;
	}
	
	function callInbound()
	{
		$sql = "select date_format(created_time, '%H') intervalHour, count(*) jumlah
				from ecentrix.ecentrix_recording 
				where direction='INB' and date(created_time)=date(now())
				group by date_format(created_time, '%Y-%m-%d %H')";
		$query = $this->db->query($sql);
		$arr = array();
		$count = array();
		foreach($query->result() as $row){
			$arr[] = array($row->intervalHour, (int)$row->jumlah);
		}
		return json_encode($arr);
	}
	
	function callOutbound()
	{
		$sql = "select date_format(created_time, '%H') intervalHour, count(*) jumlah
				from ecentrix.ecentrix_recording 
				where direction='OUTB' and date(created_time)=date(now())
				group by date_format(created_time, '%Y-%m-%d %H')";
		$query = $this->db->query($sql);
		$arr = array();
		$count = array();
		foreach($query->result() as $row){
			$arr[] = array($row->intervalHour, (int)$row->jumlah);
		}
		return json_encode($arr);
	}
	
	
	function post_url($data) {
		$url = "http://".$this->config->item('cti_server_address').":".$this->config->item('cti_port_http');
		$username = $this->config->item('cti_username');
		$password = $this->config->item('cti_password');
		$credential = base64_encode($username.":".$password);

		$header = array (
			"Host: ".$this->config->item('cti_server_address'),
			"Accept: text/json",
			"Authorization: Basic ".$credential,
			"Cache-Control: no-cache, no-store",
			"Connection: keep-alive",
		);
		$user_agent = "eCentrix Dashboard";
		$resource = curl_init($url);
		curl_setopt($resource, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($resource, CURLOPT_HTTPHEADER, $header);
		curl_setopt($resource, CURLOPT_HEADER, 0);
		curl_setopt($resource, CURLOPT_TIMEOUT, 30);
		curl_setopt($resource, CURLOPT_POST, 1);
		curl_setopt($resource, CURLOPT_POSTFIELDS, $data);
		curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($resource, CURLOPT_FOLLOWLOCATION, 1);
		$content = curl_exec($resource);
		$header = curl_getinfo($resource);
		curl_close($resource);
		return array (
			"header"	=> $header,
			"content"	=> $content,
		);
	}
	
	function getCustomFields($module)
	{
		$this->db->select('*');
		$this->db->from('custom_fields');
		$this->db->where('modules', $module);
		$result = $this->db->get();
		$return = array();
		foreach($result->result_array() as $row){
			$return[] = $row;
		}
		return $return;
	}
	
	function getTitle($name, $start_date, $end_date, $period){
		$result = "";
		if ($name){
			$result .= $name;
			if (isset($period)){
				$result .= ucwords(str_replace('_','',$period));
			}
			$result .= ' Report ';
			if (isset($start_date) && isset($end_date)){
				if (strcmp(@$period, "monthly")==0){
					$start_month = date("F Y", strtotime($start_date));
					$end_month = date("F Y", strtotime($end_date));
					$result .= "for ".$start_month." ";
					if (strcmp($start_month,$end_month)!=0){
						$result .= "until ".$end_month;
					}
				}
				else{
					$result .= "for ".date("j F Y", strtotime($start_date))." ";
					if (strcmp($start_date,$end_date)!=0){
						$result .= "until ".date("j F Y", strtotime($end_date));
					}
				}
			}
		}

		return trim($result);
	}
	
	function getTrendingInteraction()
	{
		$sql = "select a.category, b.name, count(a.category) jumlah
				from cc_queue a
				join cc_master_category b on a.category=b.id
				where date(a.response_time)=date(now())
				group by a.category";
		$query = $this->db->query($sql);
		$data = array();
		foreach($query->result() as $row){
			$data[] = array('name' => $row->name, 'y'=>intval($row->jumlah));
		}
		return json_encode($data);
	}
	
	
	function addWorkingHours($timestamp, $hoursToAdd, $holidays, $skipWeekends = false)
	{
		// Set constants
		$dayStart = 8;
		$dayEnd = 17;


		// For every hour to add
		for($i = 0; $i < $hoursToAdd; $i++)
		{
			// echo $i;
			$is_holiday = false;
			foreach($holidays as $holiday){
				// $time_holiday = strtotime($holiday);
				$date_timestamp = date("Y-m-d", $timestamp);
				if ($date_timestamp == $holiday){
					$timestamp = strtotime("+1 day", $timestamp); 
					$is_holiday = true;
				}else if(strtotime("+1 day", $timestamp) == $holiday){
					$timestamp = strtotime("+2 day", $timestamp); 
					$is_holiday = true;
				}else{
					$is_holiday = false;
				}
			}
			if(!$is_holiday){
				// Add the hour
				$timestamp += 3600;
				// If the time is between 1800 and 0800
				if ((date('G', $timestamp) >= $dayEnd && date('i', $timestamp) >= 0 && date('s', $timestamp) >= 0) || (date('G', $timestamp) < $dayStart))
				{
					// If on an evening
					if (date('G', $timestamp) >= $dayEnd)
					{
						// Skip to following morning at 08XX
						$timestamp += 3600 * ((24 - date('G', $timestamp)) + $dayStart);
					}
					// If on a morning
					else
					{
						// Skip forward to 08XX
						$timestamp += 3600 * ($dayStart - date('G', $timestamp));
					}
				}
				// If the time is on a weekend
				if ($skipWeekends && (date('N', $timestamp) == 6 || date('N', $timestamp) == 7))
				{
					// Skip to Monday
					$timestamp += 3600 * (24 * (8 - date('N', $timestamp)));
				}
			}
		}
		// Return
		return $timestamp;
	}
	
	function getHolidayDays($date)
	{
		$select = array('*');
		$this->db->from('cc_master_holiday_calendar');
		$this->db->where('holiday_date >=', $date);
		$this->db->select(''.str_replace(' , ', ' ', implode(', ', $select)), false);
		$query = $this->db->get();
		$data = array();
		foreach($query->result() as $row){
			$data[] = $row->holiday_date;
		}
		return $data;                     
	}
	
	function getDataChartTicket($fieldName, $tableName, $criteria, $orderBy)
	{		
		$arrData = array();
		$value = array();
		$sql = "SELECT ".$fieldName." FROM ".$tableName;
		
		if($criteria)
		{
			$sql .= " WHERE ".$criteria;
		}
		
		if($orderBy)
		{
			$sql .= " ORDER BY ".$orderBy;
		}
		$query = $this->db->query($sql);
		if ($query->num_rows())
		{
			foreach ($query->result() as $row)
			{
				$value[$row->item] = intval($row->value);
			}
		}
		return json_encode($value);
	}	
	
	function getDataChartCTI($fieldName, $tableName, $criteria, $orderBy)
	{		
		$this->cti = $this->load->database('ecentrix', true);
		$arrData = array();
		$value = array();
		$sql = "SELECT ".$fieldName." FROM ".$tableName;
		
		if($criteria)
		{
			$sql .= " WHERE ".$criteria;
		}
		
		if($orderBy)
		{
			$sql .= " ORDER BY ".$orderBy;
		}
		$query = $this->cti->query($sql);
		if ($query->num_rows())
		{
			foreach ($query->result() as $row)
			{
				$value[$row->item] = intval($row->value);
			}
		}
		$this->cti->close();
		return json_encode($value);
	}	
	
	function curlWrap($url, $params)
	{
		$postData = '';
		foreach($params as $k => $v) 
		{ 
			$postData .= $k . '='.$v.'&'; 
		}
		rtrim($postData, '&');
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,$url.$postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		// curl_setopt($ch, CURLOPT_TIMEOUT,15);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		$output = curl_exec($ch);
		if(curl_error($ch))
		{
			echo 'error:' . curl_error($ch);
		}		
		return json_decode($output);
	}	
	
	function getProfileCC($acct_nbr)
	{
		// $acct_nbr = '0000000000000029811';
		// $sql = $this->getDataTimeFrame('a.*, CONCAT(SUBSTR(trim(a.CARD_NBR), 1, 4), REPEAT("*", "4"), substr(trim(a.CARD_NBR),-4, 4)) card_number,
				// CASE WHEN CARD_PDT_NBR IN (100, 110) THEN round(CRDACCT_PERM_CRLIMIT-(CRDACCT_OUTSTD_BAL+CRDACCT_OUTSTD_INSTL))
// WHEN CARD_PDT_NBR IN (120, 160) THEN round(CRDACCT_PERM_CRLIMIT-(CRDACCT_OUTSTD_BAL+CRDACCT_OUTSTD_INSTL))
// WHEN CARD_PDT_NBR IN (130) THEN round(CRDACCT_AVAIL_CREDIT)
// ELSE round(CRDACCT_PERM_CRLIMIT-(CRDACCT_OUTSTD_BAL+CRDACCT_OUTSTD_INSTL))
// END CRDACCT_AVAIL_CREDIT, PERIOD_DIFF(LEFT((CURRENT_DATE()-0), 6), LEFT(a.MOB,6)) mob', 'stagging.profile_tele a', 'a.CRDACCT_NBR="'.$acct_nbr.'" and a.CARD_SUP_REL="P" and a.CARD_STATUS in ("1", "2")');
		$sql = $this->getDataTimeFrame('*', 'tms_prospect', 'id="'.$acct_nbr.'" ');
		return $sql;
	}
	
	function getAllCard($acct_nbr)
	{
		// $acct_nbr = '0000000000000029811';
		$sql = $this->getDataTimeFrame('a.*, CONCAT(SUBSTR(trim(a.CARD_NBR), 1, 4), REPEAT("*", "4"), substr(trim(a.CARD_NBR),-4, 4)) card_number,
				CASE WHEN CARD_PDT_NBR IN (100, 110) THEN round(CRDACCT_PERM_CRLIMIT-(CRDACCT_OUTSTD_BAL+CRDACCT_OUTSTD_INSTL))
WHEN CARD_PDT_NBR IN (120, 160) THEN round(CRDACCT_PERM_CRLIMIT-(CRDACCT_OUTSTD_BAL+CRDACCT_OUTSTD_INSTL))
WHEN CARD_PDT_NBR IN (130) THEN round(CRDACCT_AVAIL_CREDIT)
ELSE round(CRDACCT_PERM_CRLIMIT-(CRDACCT_OUTSTD_BAL+CRDACCT_OUTSTD_INSTL))
END CRDACCT_AVAIL_CREDIT', 'stagging.profile_tele a', 'a.CRDACCT_NBR="'.$acct_nbr.'" and a.CARD_STATUS in ("1", "2")');
		return $sql;
	}		
	
	function getCardNumberProfile($acct_nbr)
	{
		$sql = $this->getRecordValue('CONCAT(SUBSTR(trim(a.CARD_NBR), 1, 4), REPEAT("*", "4"), substr(trim(a.CARD_NBR),-4, 4)) card_number', 
				'stagging.profile_tele a', 
				'a.CRDACCT_NBR="'.$acct_nbr.'" and CARD_STATUS in (1,2) and a.CARD_SUP_REL="P"');
		return $sql;
	}		
	
	function getCardNumberNoMasking($acct_nbr)
	{
		$sql = $this->getRecordValue('trim(a.CARD_NBR) card_number', 
				'stagging.profile_tele a', 
				'a.CRDACCT_NBR="'.$acct_nbr.'" and CARD_STATUS in (1,2) and a.CARD_SUP_REL="P"');
		return $sql;
	}		
	
	function getCardNumber($acct_nbr)
	{
		$sql = $this->getRecordValue('CONCAT(SUBSTR(trim(a.CARD_NBR), 1, 4), REPEAT("*", "4"), substr(trim(a.CARD_NBR),-4, 4)) card_number', 
				'stagging.profile_tele a', 
				'a.CRDACCT_NBR="'.$acct_nbr.'" and (CARD_BLK_CODE in ("", "OL", "PD","BI","FP","AK", "NI") or CARD_BLK_CODE is null)
				and (CRDACCT_BLK_CODE in ("", "OL", "PD","BI","FP","AK", "NI") or CRDACCT_BLK_CODE is null)
				and a.CARD_SUP_REL = "P" and a.CARD_STATUS in ("1", "2")');
		return $sql;
	}		
	
	function getDataTrans($acct_nbr)
	{
		// $acct_nbr = '0000000000000030747';
		$sql = $this->getDataTimeFrame('*', 'stagging.data_trans_tele a', 'a.OLSH_ACCT_NBR="'.$acct_nbr.'"');
		return $sql;
	}
	
	function getProfileCC2($acct_nbr)
	{
		$data = array(
					'acct_nbr' => $acct_nbr //'0000000000000000092'
				);
		$result = $this->curlWrap("http://10.11.33.147:9001/multidb?operation=getProfileInfo2&",$data);
		return json_decode(json_encode($result));
	}	
	
	function getPointReward2($acct_nbr)
	{
		$data = array(
					'acct_nbr' => $acct_nbr
				);
		$result = $this->curlWrap("http://10.11.33.147:9001/multidb?operation=getPointReward2&",$data);
		return json_decode(json_encode($result));
	}	
	
	function getInfoCCOnline_PROD($acct_nbr)
	{
		$data = array(
					'accountno' => $acct_nbr //'0000000000000029811'
				);
		$result = $this->curlWrap("http://10.11.33.147:9001/multidb?operation=getInfoCCOnline_PROD&",$data);
		return json_decode(json_encode($result));
	}	
	
	function getDataTransactionOLSHP($acct_nbr)
	{
		$data = array(
					'acct_nbr' => $acct_nbr
				);
		$result = $this->curlWrap("http://10.11.33.147:9001/multidb?operation=getDataTransaksiOLSHP&",$data);
		return json_decode(json_encode($result));
	}
	
	function syncLOCGrab($prospect_id, $customer_id)
	{
		$amount = $this->getRecordValue('a.data_content', 'tms_prospect_campaign_result a', 
				'a.campaign_id="003" and a.prospect_id="'.$prospect_id.'" and a.customer_id="'.$customer_id.'" and a.field_name_id="nominal-transfer"');
				
		$result_id = $this->getRecordValue('id', 'tms_prospect_detail_campaign', 'prospect_id="'.$prospect_id.'" and customer_id="'.$customer_id.'" and campaign="003"');
		$check = $this->getRecordValue('count(*)', 'stagging_sync_to_loc_grab', 'result_id="'.$result_id.'"');
		if($check == '0'){
			$mid = $this->getRecordValue('mid', 'stagging.parm_program', 'campaign_id="003"');
			$sql = "select a.CARD_NBR, a.CUST_ID_NBR 
					from stagging.profile_tele a 
					where a.CRDACCT_NBR='".$customer_id."'
					and a.CARD_STATUS in ('1','2') 
					and a.CRDACCT_STATUS in ('1','2') 
					and a.CARD_SUP_REL='P'";
			$query = $this->db->query($sql);
			foreach($query->result() as $row){
				$data = array(
							'card_number' => $row->CARD_NBR,
							'mid' => $mid,
							'customer_number' => $row->CUST_ID_NBR,
							'description' => 'MEGA LOAN ON CARD',
							'result_id' => $result_id,
							'prospect_id' => $prospect_id,
							'customer_id' => $customer_id,
							'amount_approved' => $amount,
							'decimal' => '00',
							'created_time' => date('Y-m-d H:i:s'),
							'created_by' => $this->encrypt->decode($this->session->userdata('USER_ID'), $this->config->item('encryption_key'))
						);			
				$this->db->insert('stagging_sync_to_loc_grab', $data);
				$this->dataLogging("STAGGING LOC", "GRAB", $this->db->last_query());
			}
		}else{
			$sql = "select * from stagging_sync_to_loc_grab where result_id='".$result_id."'";
			$q = $this->db->query($sql);
			foreach($q->result() as $row){
				$data = array(
							'id' => uuid(false),
							'result_id' =>$row->result_id,
							'mid' => $row->mid,
							'card_number' => $row->card_number,
							'customer_number' => $row->customer_number,
							'description' => $row->description,
							'prospect_id' => $row->prospect_id,
							'customer_id' => $row->customer_id,
							'amount_approved' => $row->amount_approved,
							'decimal' => $row->decimal,
							'is_download' => $row->is_download,
							'download_by' => $row->download_by,
							'download_time' => $row->download_time,
							'file_name' => $row->file_name,
							'response_code' => $row->response_code,
							'approved_code' => $row->approved_code,
							'grab_date' => $row->grab_date,
							'file_upload_name' => $row->file_upload_name,
							'upload_by' => $row->upload_by,
							'upload_time' => $row->upload_time,
							'created_time' => $row->created_time,
							'created_by' => $row->created_by,
						);
				$this->db->insert('stagging_sync_to_loc_grab_history', $data);
				$this->dataLogging("STAGGING LOC", "HISTORY", $this->db->last_query());
				$del = "delete from stagging_sync_to_loc_grab where result_id='".$row->result_id."'";
				$this->db->query($del);
				$this->dataLogging("STAGGING LOC", "DELETE", $this->db->last_query());
				$this->syncLOCGrab($prospect_id, $customer_id);
			}
		}
	}
	
	function syncLOCFinance($prospect_id, $customer_id)
	{
		$amount = $this->getRecordValue('a.data_content', 'tms_prospect_campaign_result a', 
				'a.campaign_id="003" and a.prospect_id="'.$prospect_id.'" and a.customer_id="'.$customer_id.'" and a.field_name_id="nominal-transfer"');
				
		$result_id = $this->getRecordValue('id', 'tms_prospect_detail_campaign', 'prospect_id="'.$prospect_id.'" and customer_id="'.$customer_id.'" and campaign="003"');
		$mid = $this->getRecordValue('mid', 'stagging.parm_program', 'campaign_id="003"');
		$stagging = $this->getRecordValue('concat(trim(CUST_LOCAL_NAME), "|", trim(CUST_ID_NBR))', 'stagging.profile_tele', 'CRDACCT_NBR="'.$customer_id.'" limit 1');
		$arr_stagging = explode("|", $stagging);
		$sql = "select agent_id, last_response_time from tms_prospect a where a.id='".$prospect_id."'";
		$query = $this->db->query($sql);
		foreach($query->result() as $row){
			$data = array(
						'agent_id' => $row->agent_id,
						'prospect_id' => $prospect_id,
						'result_id' => $result_id,
						'customer_id' => $customer_id,
						'registration_date' => $row->last_response_time,
						'cardholder_name' => $arr_stagging[0],
						'ic_no' => $arr_stagging[1],
						'amount' => $this->common->getRecordValue('data_content', 'tms_prospect_campaign_result', 'prospect_id="'.$prospect_id.'" and campaign_id="003" and field_name_id="nominal-transfer"'),
						'bank_name' => $this->common->getRecordValue('data_content', 'tms_prospect_campaign_result', 'prospect_id="'.$prospect_id.'" and campaign_id="003" and field_name_id="nama-bank"'),
						'rek_name' => $this->common->getRecordValue('data_content', 'tms_prospect_campaign_result', 'prospect_id="'.$prospect_id.'" and campaign_id="003" and field_name_id="nama-di-rekening"'),
						'rek_number' => $this->common->getRecordValue('data_content', 'tms_prospect_campaign_result', 'prospect_id="'.$prospect_id.'" and campaign_id="003" and field_name_id="nomor-rekening"')
					);			
			$this->db->insert('stagging_sync_to_loc_finance', $data);
			$this->dataLogging("STAGGING LOC", "FINANCE", $this->db->last_query());
		}
	}
	
	function syncToRdsAddon($prospect_id, $customer_id)
	{
		$result_id = $this->getRecordValue('id', 'tms_prospect_detail_campaign', 'prospect_id="'.$prospect_id.'" and customer_id="'.$customer_id.'" and campaign="001"');
		$c = $this->getRecordValue('concat(data_content,"|", created_by)', 'tms_prospect_campaign_result a', 'a.campaign_id="001" and a.prospect_id="'.$prospect_id.'" and a.customer_id="'.$customer_id.'" and a.result_id="'.$result_id.'" and a.field_name_id="jenis-kartu-yang-dikehendaki"');
		$content = explode('|', $c);
		$arr_c = explode(',', $content[0]);
		$address = $this->getRecordValue('data_content', 'tms_prospect_campaign_result a', 'a.campaign_id="001" and a.prospect_id="'.$prospect_id.'" and a.customer_id="'.$customer_id.'" and a.result_id="'.$result_id.'" and a.field_name_id="alamat-pengiriman-kartu"');
		foreach($arr_c as $a=>$b){
			$data = array(
						'prospect_id' => $prospect_id,
						'result_id' => $result_id,
						'customer_id' => $customer_id,
						'card_number' => $this->getCardNumberNoMasking($customer_id),
						'source_code' => $this->getRecordValue('data_content', 'tms_prospect_campaign_result a', 'a.campaign_id="001" and a.prospect_id="'.$prospect_id.'" and a.customer_id="'.$customer_id.'" and a.result_id="'.$result_id.'" and a.field_name_id="source-code"'),
						'recommend' => $content[1],
						'card_type' => $this->getRecordValue('id', 'stagging.parm_card_type', 'name="'.$b.'"'),
						'address' => $this->getRecordValue('id', 'stagging.parm_bill', 'name="'.$address.'"'),
						'data_tl' => '729.'.date('dm').'.000'.($a+1).'.0',
						'dok_tl' => $result_id,
						'recommen_no' => $content[1],
						'created_by' => $this->encrypt->decode($this->session->userdata('USER_ID'), $this->config->item('encryption_key')),
						'created_time' => date('Y-m-d H:i:s')
					);			
			$this->db->insert('stagging_sync_to_rds', $data);
			$this->dataLogging("STAGGING RDS ADDON", "stagging_sync_to_rds", $this->db->last_query());			
		}
	}
	
	function syncToRdsSupplement($prospect_id, $customer_id, $increament_id)
	{
		$result_id = $this->getRecordValue('id', 'tms_prospect_detail_campaign', 'prospect_id="'.$prospect_id.'" and customer_id="'.$customer_id.'" and campaign="002"');
		$julianDate = $this->getRecordValue('(YEAR(CURRENT_DATE())*1000 + DAYOFYEAR(current_date()))', 'tms_master_reference', 'id="APP_0" limit 1');
		$count = $this->getRecordValue('count(*)+1', 'stagging_sync_to_rds a', 'date(a.created_time)=date(now()) and a.campaign_id="002" and a.result_id !="'.$result_id.'"');
		$sql = "select a.increament_id, a.created_by, a.created_time from tms_prospect_campaign_result a where a.campaign_id='002' and a.prospect_id='".$prospect_id."' and a.customer_id='".$customer_id."' and a.result_id='".$result_id."' and a.increament_id='".$increament_id."' group by a.increament_id";
		$query = $this->db->query($sql);
		foreach($query->result() as $row){
			$s = "select * from tms_prospect_campaign_result where result_id='".$result_id."' and increament_id='".$row->increament_id."'";
			$q = $this->db->query($s);
			$content = array();
			foreach($q->result() as $rs){
				$content[$rs->field_name_id] = $rs->data_content;
			}
			$source_code = $content['source-code'];
			
			$card = $content['card-number'];
			$prod = $this->getRecordValue('CARD_PDT_NBR', 'stagging.profile_tele', 'CARD_NBR="'.$card.'"');
			if($prod == ''){
				$card = $this->getCardNumberNoMasking($customer_id);
			}			
			$prod = $this->getRecordValue('CARD_PDT_NBR', 'stagging.profile_tele', 'CARD_NBR="'.$card.'"');
			$card_type = $this->getRecordValue('id', 'stagging.parm_card_type', 'prod="'.$prod.'"');
			$sales_code = $this->common->getRecordValue('sales_id', 'cc_user', 'id="'.$row->created_by.'"');
			if($content['alamat-supplement']){
				$alamat_1 = $content['alamat-supplement'];
			}else{
				$alamat_1 = '';
			}
			$data = array(
						'prospect_id' => $prospect_id,
						'result_id' => $result_id,
						'customer_id' => $customer_id,
						'campaign_id' => $this->input->get_post('campaign_id'),
						'source_code' => $this->getRecordValue('id', 'stagging.parm_source_cd', 'code="'.$source_code.'"'),
						'agent_id' => $row->created_by,
						'submit_time' => $row->created_time,
						'sales_code' => $sales_code,
						'card_number' => $content['card-number'],
						'recommend' => $this->getRecordValue('name', 'cc_user', 'id="'.$row->created_by.'"'),
						'note_updated' => $content['catatan-perubahan'],
						'basic_name' => $content['nama-lengkap-supplement-sesuai-ktp'],
						'dob' => $content['tanggal-lahir-supplement'],
						'dob_place' => $content['tempat-lahir-supplement'],
						'emboss_name' => $content['nama-embossing-di-kartu'],
						'sex' => $content['jenis-kelamin'],						
						'alamat_1' => $alamat_1,
						'kelurahan' => $content['alamat-supplement-kelurahan'],
						'kecamatan' => $content['alamat-supplement-kecamatan'],
						'kota' => $content['alamat-supplement-kota'],
						'zipcode' => $content['alamat-supplement-zipcode'],
						'pengiriman_kartu' => $content['alamat-pengiriman-kartu'],
						
						'phone_number' => $content['no-telephone-supplement'],
						'identity_id' => $content['no-id-ktppassportkims-supplement'],
						'mother_name' => $content['nama-ibu-kandung-supplement'],
						'relationship' => $content['hubungan-status-keluarga'],
						'card_type' => $card_type,
						'address' => $content['alamat-supplement-kelurahan']." ".$content['alamat-supplement-kecamatan']." ".$content['alamat-supplement-kota']." ".$content['alamat-supplement-zipcode'],
						'data_tl' => '729.'.substr($julianDate,3,4).'.'.str_pad($count,4,"0", STR_PAD_LEFT).'.'.$row->increament_id,
						'dok_tl' => $result_id,
						'recommen_no' => $row->created_by,
						'created_by' => $this->encrypt->decode($this->session->userdata('USER_ID'), $this->config->item('encryption_key')),
						'created_time' => date('Y-m-d H:i:s'),
						'increament_id' => $row->increament_id
					);			
			$this->db->insert('stagging_sync_to_rds', $data);
			$this->dataLogging("STAGGING RDS", "stagging_sync_to_rds", $this->db->last_query());
		}
	}
        
	function getListParentTelephony(){
		$this->db->from('cc_master_link_menu_telephony a');
		$this->db->select('a.*');
		$this->db->where('parent_id = ', 0);
		$this->db->where('a.is_actived = ', 1);
		$query = $this->db->get();
		$data = $query->result();			
		return $data;   
	}
	
	function getListMenuTelephonyByParentId($id){
		$this->db->from('cc_master_link_menu_telephony a');
		$this->db->join('cc_master_link_menu_telephony b', 'a.parent_id = b.id', 'left'  );
		$this->db->select('a.*, b.name as parent_name');
		$this->db->where('a.parent_id = ', $id);
				$this->db->where('a.is_actived = ', 1);
		$query = $this->db->get();
		$data = $query->result();			
		return $data;   
	}
	
	function hash256($input)
	{
		return hash_hmac('sha256', $input, $this->config->item('encryption_key'));
	}		
	
	function get_wav_file($file_path){
		$download = substr($file_path, 6);
		$arr = explode('/',$file_path);
		$wav = substr($arr[8], 0,-4);
		$existing = 'gsm';
		$format = 'wav';
		$source = "../temp/".$arr[8];
		$target = "../temp/".$wav.".".$format;
		$contextOptions = array(
			"ssl" => array(
				"verify_peer"      => false,
				"verify_peer_name" => false,
				),
			);
		copy($file_path, $source, stream_context_create( $contextOptions ) );
		$this->gsm_to_wav($source, $target);
		$response = array('path' => $target,'download' => $download);
		return "https://".$_SERVER['SERVER_NAME']."/temp/".$wav.".wav";
	}

	function gsm_to_wav ($source, $target){
		exec("/usr/bin/sox ".$source." -c1 -r8000 -u ".$target);
	}	
	
}

/* End of File */