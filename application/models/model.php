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
	
	public function validate_user()
	{
		$this->load->library('session');
		$this->db->where('empid', $this->input->post('user_name'));
		$this->db->where('pass', md5($this->input->post('user_pass')));
		
		$login = $this->db->get('fa13segk.employee');
	 
		$userd = $login->row();

		
		if ( $login->num_rows() == 1 )
		{
			$sess_array = array(
				'id' => $userd->empid,
				'fname' => $userd->fname,
				'lname' => $userd->lname,
				'role'	=> $userd->role
			);
			
			$this->session->set_userdata($sess_array);
			return true;
		}
	 
		return false;
 
	}
	
	public function get_schools ()
	{
		$query = $this->db->query('SELECT S.name AS name, Y.scid AS scid, Y.grade AS grade, Y.isopen AS isopen FROM fa13segk.school S, fa13segk.years Y WHERE Y.haslist = false AND Y.scid = S.scid');
		if ($query->num_rows() > 0){
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
		else
		{
			return false;
		}
	}
	
	 public function get_open_schools ()
	{
		$query = $this->db->query('SELECT S.name AS name, Y.grade AS grade FROM fa13segk.school S, fa13segk.years Y WHERE Y.isopen = true AND Y.scid = S.scid AND Y.haslist = FALSE');
		
		return $query;
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
	
	public function exist($info)
	{
	
		
		$this->db->select('reggrade'); 
		$results = $this->db->get_where('fa13segk.school', array('scid' => $info['School']))->result(); 
		$results = $results[0];
		if($results->reggrade > $info['grade'])
		{
				$error = 2;
				return $error;
		}
		else
		{
			$x = ($info['grade'] - $results->reggrade);
			
			$year = date('Y');
			
			$list_grade = ($year - $x);
			
			$result2 = $this->db->get_where('fa13segk.years', array('grade' => $list_grade, 'scid' => $info['School']))->result();  
			
			
			if(empty($result2))
			{
				$error = 3;
				return $error;
			}
			else 
			{
				return;
			}
		}
	}
	
	//add new lottery
	public function create_lottery()
	{
		//check if lottery already exists
		$result = $this->db->get_where('years',array('grade' => $this->input->post('year'), 'scid' => $this->input->post('school')))->result();
		//if dosnt exist insert
		if(empty($result))
		{
			$datai = array(
				'grade' => $this->input->post('year'),
				'scid' => $this->input->post('school'),
				'enrollnum' => $this->input->post('attend')
			);
			$this->db->insert('fa13segk.years', $datai);
			//return true if inserted
			return true;
		}
		else
		{	
			//return false if lottery already exists
			return false;
		}
	}
	
	public function get_lists()
	{
		$query = $this->db->query('SELECT S.name AS name, Y.scid AS scid, Y.grade AS grade FROM fa13segk.school S, fa13segk.years Y WHERE Y.haslist = true AND Y.scid = S.scid');
		
		return $query;
	}
	
	public function that_list($scid,$grade)
	{
		$this->db->select('identifier, scid, grade, position, isaccept, iswaiting, isenrolled');
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
	
	public function get_app()
	{
		//SELECT * from student st, stud_ident si, ident i, appinfo a , list l where st.stid = si.stid and si.identifier=i.identifier and i.appid=a.appid and i.identifier=l.identifier
		$this->db->select('i.iyear, i.identifier, st.stid, st.fname as sfname, st.lname as slname, a.fname as afname, a.lname as alname, a.street, a.city, a.zip, a.hphone, a.wphone, a.ophone, a.email, a.prefcont, s.name, l.grade, l.isaccept, l.notified');
		$this->db->from('fa13segk.ident as i');
		$this->db->join('fa13segk.stud_ident as si','si.identifier=i.identifier');
		$this->db->join('fa13segk.student as st','st.stid = si.stid');
		$this->db->join('fa13segk.appinfo as a','i.appid=a.appid');
		$this->db->join('fa13segk.list as l','i.identifier=l.identifier');
		$this->db->join('fa13segk.school as s','s.scid = l.scid');
		$this->db->where('i.identifier',$this->input->post('identifier'));
		$result = $this->db->get();
		
		return $result;
	}
	
	public function set_notified()
	{
		$mydate = date('Y-m-d H:i:s');
		$datan = array(
			'notified' => $mydate
		);
		$this->db->where('identifier', $this->input->post('identifier'));
		$this->db->update('fa13segk.list',$datan);
	}
	
	public function set_enrolled()
	{
		$datae = array(
			'isenrolled' => 't'
		);
		$this->db->where('identifier',$this->input->post('identifier'));
		$this->db->update('fa13segk.list',$datae);
	}
	
	public function delete($id)
	{
		echo $id;
		$this->db->from('fa13segk.ident as i');
		$this->db->join('fa13segk.stud_ident as si','si.identifier=i.identifier');
		$this->db->join('fa13segk.student as st','st.stid = si.stid');
		$this->db->join('fa13segk.appinfo as a','i.appid=a.appid');
		$this->db->join('fa13segk.list as l','i.identifier=l.identifier');
		$this->db->join('fa13segk.school as s','s.scid = l.scid');
		$this->db->join('fa13segk.years as y','y.scid = l.scid AND y.grade = l.grade');
		$this->db->where('i.identifier',$id);
		$result = $this->db->get();
		
		$app = $result->row();
		$this->db->from ('stud_ident');
		$this->db->where('stid', $app->stid);
		$app2 = $this->db->get();
		$app3 = $result->row();
		
		if ($app2->num_rows() > 1)
		{
			$app2 = $app2->row();
			$this->db->where('identifier', $id );
			$this->db->delete('list');
		}
		else
		{
			foreach ($result->result() as $row)
			{
				$this->db->where('stid', $row->stid );
				$this->db->delete('student');
			}	
			
			$this->db->where('identifier', $id );
			$this->db->delete('list');
			
			$this->db->where('appid', $row->appid );
			$this->db->delete('appinfo');
		}
		
		if ($app3->haslist =='t' )
		{
			$this->db->order_by('position','asc');
			$list = $this->db->get_where('fa13segk.list',array('scid' => $app3->scid, 'grade' => $app3->grade));
			$list2 = $list->result_array();
			$z = 1;
			foreach($list2 as $row){
				if ($z <= $app3->enrollnum){
					$dataz = array('position' => $z, 'isaccept' => 't');
					$this->db->where('identifier', $row['identifier']);
					$this->db->update('fa13segk.list', $dataz);
					$z++;
				}
				else{
					$dataz = array('position' => $z, 'iswaiting' => 't');
					$this->db->where('identifier', $row['identifier']);
					$this->db->update('fa13segk.list', $dataz);
					$z++;
				}
			}
		}
		
		
	}
	
}
?>