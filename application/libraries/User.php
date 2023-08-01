<?php defined('BASEPATH') OR exit("No direct script access allowed");

/*
Level of Approval : (field APPROVELEVEL in Table ESS_LOGIN_APP)
	'1'		=>	-
	'2'		=> STAFF
	'3'		=> SECTION HEAD
	'4'		=> DEPARTMENT HEAD
	'5'		=> DEPUTY DIVISION HEAD
	'6'		=> DIVISION HEAD
	'7'		=> DIRECTOR

! NEW LEVEL OF APPROVAL (APRIL 2019)
! Refer from Table HRMEMPLOYEE (Oracle) => field CGOLNO, CGOLDESC
! PER 28 MAY 2019 ONLY IMPLEMENTED TO LEAVE
TODO : IMPLEMENT ON ABSENCE/ATTENDANCE REQUEST
	'1'	=> 'Worker',
	'2'	=> 'Staff / Officer', //DEFAULT IF UNDEFINED
	'3'	=> 'Sub Section',
	'4'	=> 'Section',
	'5'	=> 'Department',
	'6'	=> 'Sub Division',
	'7'	=> 'Division',
	'8'	=> 'Sub Directorate',
	'9'	=> 'Directorate'

*/
class User{
	
	var $user = NULL;
	var $CI;
	
	function __construct(){
		$this->CI = &get_instance();
		$this->CI->load->library('session');
		$this->user = ($this->CI->session->userdata(SESS)) ? $this->CI->session->userdata(SESS) : NULL;
	}
	
	function getNip()		{return ($this->user) ? trim($this->user->log_user) : NULL;}
	function getName()		{return ($this->user) ? trim($this->user->log_name) : NULL;}
	function getJoin()		{return ($this->user) ? trim($this->user->log_join) : NULL;}	/*** Date of Join Group ***/
	function getPrs()		{return ($this->user) ? trim($this->user->log_prs) : NULL;}		/*** Company (add 11-03-2019 AP) [TEMPORARY - PLEASE UPDATE IF CHANGED]***/
	function getCdpt()		{return ($this->user) ? trim($this->user->log_cdpt) : NULL;} 	/*** Directorate ID ***/
	function getDirName()	{return ($this->user) ? trim($this->user->log_dir) : NULL;} 	/*** Directorate Name ***/
	function getCdic()		{return ($this->user) ? trim($this->user->log_cdic) : NULL;} 	/*** Division ID ***/
	function getDivName()	{return ($this->user) ? trim($this->user->log_div) : NULL;} 	/*** Division Name ***/
	function getCsdp()		{return ($this->user) ? trim($this->user->log_csdp) : NULL;} 	/*** Department ID ***/
	function getDept()		{return ($this->user) ? trim($this->user->log_dept) : NULL;} 	/*** Department Name ***/
	function getCdac()		{return ($this->user) ? trim($this->user->log_cdac) : NULL;} 	/*** Section ID ***/
	function getPost()		{return ($this->user) ? trim($this->user->log_post) : NULL;} 	/*** Position (add 22-02-2019 AP) ***/
	function getEmail()		{return ($this->user) ? trim($this->user->log_email) : NULL;} 	/*** Email (add 24-07-2018 AP) ***/
	function getGender()	{return ($this->user) ? trim($this->user->log_gender) : NULL;} 	/*** Gender (add 22-02-2019 AP) ***/
	function getDOB()		{return ($this->user) ? trim($this->user->log_dob) : NULL;} 	/*** DOB (add 24-06-2019 AP) ***/
	function getGold()		{return ($this->user) ? trim($this->user->log_gold) : NULL;}	/*** Golongan No. => NEW APPROVAL LEVEL ***/
	function getLevel()		{return ($this->user) ? trim($this->user->log_level) : NULL;}	/*** Old Approval Level (still used for Attendance Request, need Re-work) ***/
	function getUpdate()	{return ($this->user) ? $this->user->log_update : NULL;}		/*** Status of Biodata Update, only for HRIS Employee (used for validation in Core Controller) ***/
	
	
	/* get Approver List for Attendance, update 2019-08-09, preparing for approval system integration (Leave, Attendance, Performance Appraisal) */
	function getApprover($nav_id){
		// if ( empty($this->getLevel()) or $this->getLevel() == "1" or $this->getLevel() == "2" ){
		// 	$sql = "SELECT * FROM i_uac WHERE nav_id = ? AND ((level = 3 AND sect_id = ?) OR (level IN (2,4) AND dept_id = ?)) AND email LIKE '%metrotvnews.com'";
		// 	$q = $this->CI->db->query($sql, [$nav_id, $this->getCdac(), $this->getCsdp()]);
		// 	return ($q->num_rows() == 0) ? FALSE : $q->result();
		// }
		// else if ( $this->getLevel() == "3" ){
		// 	$sql = "SELECT * FROM i_uac WHERE nav_id = ? AND ( level IN (2,4) AND dept_id = ?) AND email LIKE '%metrotvnews.com'";
		// 	$q = $this->CI->db->query($sql, [$nav_id, $this->getCsdp()]);
		// 	return ($q->num_rows() == 0) ? FALSE : $q->result();
		// }
		// else if ( $this->getLevel() == "4" ){
		// 	$sql = "SELECT * FROM i_uac WHERE nav_id = ? AND (level IN (5,6) AND div_id = ?) AND email LIKE '%metrotvnews.com'";
		// 	$q = $this->CI->db->query($sql, [$nav_id, $this->getCdic()]);
		// 	return ($q->num_rows() == 0) ? FALSE : $q->result();
		// }
		return false;
	}

	/*** MOVED TO APPLICATION/HOOKS - MARCH 2019 ***/
	function useraccess($menu="dashboard"){
		// $browser = getBrowser();
		// $ua = implode(",", $browser);
		// $data = [
			// "timestamp"			=> time(),
			// "ipaddress"			=> $_SERVER['REMOTE_ADDR'],
			// "cempnip"			=> $this->getNip(),
			// "device"			=> "0",
			// "user_agent"		=> $ua,
			// "menu"				=> $menu
		// ];
		// $this->CI->sitemodel->insert("logaccess", $data);
		return false;
	}
}