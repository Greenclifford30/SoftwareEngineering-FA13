<?php
class model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function insert_entry($info)
    {
		
		$appd = array(
			'fname' => $this->input->post('Pfname'),
			'lname' => $this->input->post('Plname'),
			'street' => $this->input->post('street'),
			'city' => $this->input->post('city'),
			'zip' => $this->input->post('zip'),
			'hphone' => $this->input->post('HPhone'),
			'wphone' => $this->input->post('WPhone'),
			'ophone' => $this->input->post('OPhone'),
			'email' => $this->input->post('email'),
			'prefcont' => $this->input->post('prefCont'),
		);
		$this->db->insert('fa13segk.appinfo', $appd);
		
		 $this->db->select('appid');
		 	$Q_appID = $this->db->get_where('fa13segk.appinfo', array(
			'fname' => $this->input->post('Pfname'),
			'lname' => $this->input->post('Plname'),
			'street' => $this->input->post('street'),
			'city' => $this->input->post('city'),
			'zip' => $this->input->post('zip'),
			'hphone' => $this->input->post('HPhone')
			)
		);
		$appID = $Q_appID->row_array();
		$kyear = date('Y') - $this->input->post('grade');
		
		$this->db->select('identifier');
		$Q_identifier = $this->db->get_where('fa13segk.ident', array('appid' => NULL),1);
		$identifier = $Q_identifier->row_array();
		
		$datau = array(
            'appid' => $appID['appid'],
			'iyear' => date("Y")
        );
		$this->db->where('identifier', $identifier['identifier']);
		$this->db->update('fa13segk.ident', $datau);
		
		$datai2 = array(
			'identifier' => $identifier['identifier'],
			'scid' => $this->input->post('School'),
			'grade' => $kyear
		);
		$this->db->insert('fa13segk.list', $datai2); 
		//loop
		
		for($i = 0; $i <= count($info['children']); $i++)
			{
				$studd[$i] = array(
					'stid' => $info['stID'][$i],
					'fname' => $info['STfname'][$i],
					'lname' => $info['STlname'][$i],
					'dob' => $info['date'][$i],
					'kgrade' => $kyear,
					'school' => $this->input->post('Hschool')
					);
       
				$this->db->insert('fa13segk.student', $studd[$i]);
		
				$datai[$i] = array(
					'stid' => $info['stID'][$i],
					'identifier' => $identifier['identifier']
					);
				$this->db->insert('fa13segk.stud_ident', $datai[$i]);	
			}
		return $identifier['identifier'];
    }
	public function schoolname()
	{
		$query = $this->db->query('SELECT name, scid FROM fa13segk.school');
		return $query;
	}
	
	public function get_schools ()
	{
		$query = $this->db->query('SELECT S.name AS name, Y.scid AS scid, Y.grade AS grade, Y.isopen AS isopen FROM fa13segk.school S, fa13segk.years Y WHERE Y.haslist = false AND Y.scid = S.scid');
		
		foreach ($query->result() as $row)
		{
			$this->db->where('scid', $row->scid);
			$this->db->where('grade', $row->grade);
			$this->db->from('fa13segk.list');
			$studs = $this->db->count_all_results();
			$stack = array(
				"name" => $row->name,
				"scid" => $row->scid,
				"grade" => $row->grade,
				"isopen" => $row-> isopen,
				"studs" => $studs
			);
			$data[] = $stack;
 		}
		
		return $data;
	}
	
	public function set_open()
	{
		$datas = array(
            'isopen' => '1'
        );
		$this->db->where('scid', $this->input->post('scid'));
		$this->db->where('grade', $this->input->post('grade'));
		$this->db->update('fa13segk.years', $datas);
	}
	
	public function set_close()
	{
		$datas = array(
            'isopen' => '0'
        );
		$this->db->where('scid', $this->input->post('scid'));
		$this->db->where('grade', $this->input->post('grade'));
		$this->db->update('fa13segk.years', $datas);
	}
	
	public function set_lottery()
	{
		//get number of students to enroll
		$this->db->select('enrollnum');
		$list0 = $this->db->get_where('fa13segk.years',array('scid' => $this->input->post('scid'), 'grade' => $this->input->post('grade')));
		$enum = $list0->row();
		
		$this->db->select('identifier');
		$list1 = $this->db->get_where('fa13segk.list', array('scid' => $this->input->post('scid'), 'grade' => $this->input->post('grade')));
		$list2 = $list1->result_array();
		shuffle($list2);
		$z = 1;
		foreach($list2 as $row){
			if ($z <= $enum->enrollnum){
				$dataz = array('position' => $z, 'isaccept' => '1');
				$this->db->where('identifier', $row['identifier']);
				$this->db->update('fa13segk.list', $dataz);
				$z++;
			}
			else{
				$dataz = array('position' => $z, 'iswaiting' => '1');
				$this->db->where('identifier', $row['identifier']);
				$this->db->update('fa13segk.list', $dataz);
				$z++;
			}
		} 
		$datas = array(
            'haslist' => '1'
        );
		$this->db->where('scid', $this->input->post('scid'));
		$this->db->where('grade', $this->input->post('grade'));
		$this->db->update('fa13segk.years', $datas);
		
	}
	
	public function list_schools()
	{
		$this->db->select('name,scid');
		$schools = $this->db->get('fa13segk.school');
		return $schools;
	}
	
	public function create_lottery()
	{
		$datai = array(
            'grade' => $this->input->post('year'),
            'scid' => $this->input->post('school'),
			'enrollnum' => $this->input->post('attend')
        );
		$this->db->insert('fa13segk.years', $datai);
	}
	
	public function get_lists()
	{
		$query = $this->db->query('SELECT S.name AS name, Y.scid AS scid, Y.grade AS grade FROM fa13segk.school S, fa13segk.years Y WHERE Y.haslist = true AND Y.scid = S.scid');
		
		return $query;
	}
	
	public function that_list($scid,$grade)
	{
		$this->db->select('identifier, position, isaccept, iswaiting, isenrolled');
		$this->db->order_by('position','asc');
		$list = $this->db->get_where('fa13segk.list',array('scid' => $scid, 'grade' => $grade));
		
		return $list;
	}
	
	public function school_name($scid)
	{
		$this->db->select('name');
		$x = $this->db->get_where('fa13segk.school', array('scid' => $scid));
		$row = $x->row();
		$name = $row->name;
		return $name;
	}
	
	public function get_accepted()
	{
		$query = $this->db->query("SELECT I.iyear, L.identifier, S.name, L.scid, L.grade from fa13segk.list L, fa13segk.school S, fa13segk.ident I where isenrolled = 'f' and isaccept = 't' and notified is NULL and L.scid = S.scid and L.identifier = I.identifier"); 
		
		return $query;
	}
	
	public function get_notified()
	{
		$query = $this->db->query("SELECT I.iyear, L.identifier, S.name, L.scid, L.grade from fa13segk.list L, fa13segk.school S, fa13segk.ident I where isenrolled = 'f' and isaccept = 't' and notified is not NULL and L.scid = S.scid and L.identifier = I.identifier"); 
		
		return $query;
	}
}
?>