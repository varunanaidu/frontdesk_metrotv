<?php defined('BASEPATH') OR exit("No direct script access allowed");

	/**
	 * ! WARNING : BO NOT USE THIS LIBRARY IF U CAN, PLEASE USE LIBRARY GUZZLE
	 * ! NOTE BY AP (2019-12-20)
	 */
	class Libcurl{
		private $CI;
		private $url = "http://192.168.100.100/apps-api/";
		private $posts = NULL;
		private $builder = FALSE;
		protected $request = NULL;
		protected $type = NULL;
		protected $agent = NULL;
		
		function __construct($request=NULL, $type=NULL){
			$this->request = $request;
			$this->type = $type;
			$this->agent = $_SERVER['HTTP_USER_AGENT'];
		}
		
		function __pages($posts="", $builder=FALSE, $JSONReturn=TRUE){
			$this->posts = $posts;
			$this->builder = $builder;
			if ( empty($this->request) or empty($this->type) )
				return FALSE;
			else{
				if ( !$this->__list() ) return FALSE;
				else
					return $this->__mapping($JSONReturn);
			}
		}
		
		function __mapping($JSONReturn){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $this->__list());
			// curl_setopt($curl, CURLOPT_ENCODING , "gzip"); 
			// curl_setopt($curl, CURLOPT_ENCODING, '');
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2); /*** Seting maximum timeout for connection to chosen API ***/
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);				
			curl_setopt($curl, CURLOPT_USERAGENT, $this->agent);
			if ( empty($this->posts) == FALSE ){
				$this->posts["userkeys"] = "hris-keys";
				if ( $this->builder )
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->posts));
				else
					curl_setopt($curl, CURLOPT_POSTFIELDS, $this->posts);
			}
			$result = curl_exec($curl);
			curl_close($curl);
			if ( $JSONReturn ){
				$data = json_decode($result);
				return $data;
			}
			return $result;
		}
		
		function __list(){
			$APIList = [
				"performance"	=> [
					"save-subordinate"		=> $this->url."performance-appraisal/save-subordinate",
					"load-subordinate"		=> $this->url."performance-appraisal/load-subordinate",
					"settings"				=> $this->url."performance-appraisal/settings",
					"settings-save"			=> $this->url."performance-appraisal/settings.save",
					"setup-section"			=> $this->url."performance-appraisal/setup-section",
					"list-emp-section"		=> $this->url."performance-appraisal/list-emp-section",
					"setup-sect-others"		=> $this->url."performance-appraisal/setup-sect-others",
					"save-form-kpi"			=> $this->url."performance-appraisal/save-form-kpi",
					"print-kpisect"			=> $this->url."performance-appraisal/print-kpisect",
					"approval-section"		=> $this->url."performance-appraisal/approval-section",
					"approval-dept"			=> $this->url."performance-appraisal/approval-dept",
					"view-section"			=> $this->url."performance-appraisal/view-section",
					"view-standard-list"	=> $this->url."performance-appraisal/view-standard-list",
					"download-excel-sect"	=> $this->url."performance-appraisal/download-excel-sect",
					"total-count-emp"		=> $this->url."performance-appraisal/total-count-emp",
					"reset-form"			=> $this->url."performance-appraisal/reset-form",
				],
				"letters"	=> [
					"new-employee"			=> $this->url."search/newEmp",
					"old-employee"			=> $this->url."search/oldEmp",
					"new-pkwt"				=> $this->url."letters/new_pkwt",
					"new-pkwtt"				=> $this->url."letters/new_pkwtt",
					"pkwt-annually"			=> $this->url."letters/new_pkwtan",
					"setup-pkwt"			=> $this->url."letters/setup_pkwt",
					"setup-pkwt-annually"	=> $this->url."letters/setup_pkwt_an",
					"save-newpkwt"			=> $this->url."letters/save_newpkwt",
					"save-newpkwtt"			=> $this->url."letters/save_newpkwtt",
					"save-pkwt-an"			=> $this->url."letters/save_pkwt_an",
					"notifications"			=> $this->url."letters/notifications",
				],
				"system"	=> [
					"approval-management"	=> $this->url."approval-management/datalist",
					"list-emp"				=> $this->url."employee-management/list-employee/datalist",
					"biodata-info"			=> $this->url."employee-management/list-employee/biodata-info",
					"remove-info"			=> $this->url."employee-management/list-employee/remove-info",
					"assessment-save"		=> $this->url."employee-management/list-employee/save-assessment",
					"find-assessment"		=> $this->url."employee-management/list-employee/find-assessment",
					"medical-save"			=> $this->url."employee-management/list-employee/save-medical",
					"find-medical"			=> $this->url."employee-management/list-employee/find-medical",
					"reset-password"		=> $this->url."employee-management/list-employee/reset-password",
					"approval-biodata"		=> $this->url."employee-management/approval-biodata",
					"proc-approval-biodata"	=> $this->url."employee-management/approval-biodata/process",
					"dis-approval-biodata"	=> $this->url."employee-management/approval-biodata/display",
					"dashboard"				=> $this->url."admin-dashboard",
				],
				"directorate"=> [
					"list"		=> $this->url."list-directorate",
				],
				"department" => [
					"list"		=> $this->url."list-department",
				],
				"employee"	=> [
					"login"		=> $this->url."credential/auth/signin",
					"logout"	=> $this->url."credential/auth/signout",
					"search"	=> $this->url."search/getEmp",
					"search-admin"	=> $this->url."search/getEmpAdmin",
					"change-pwd"=> $this->url."login/idocs_modify_password",
				],
				"hris"		=> [
					"list-dept"	=> $this->url."hris/list_dept",
					"notif"		=> $this->url."hris/notifications",
				],
				"dashboard"	=> [
					"record"	=> $this->url."dashboard/summary",
				],
				"fc" => [
					"record"	=> $this->url."food-coupon/history",
				],
				"work-hours"		=> [
					"list-setup"	=> $this->url."work-hours/record-setup",
					"save-setup"	=> $this->url."work-hours/save-setup",
					"render"		=> $this->url."work-hours/render",
					"save"			=> $this->url."work-hours/save_shift",
					"clone"			=> $this->url."work-hours/clone_shift",
					"reset"			=> $this->url."work-hours/reset_shift",
					"clear"			=> $this->url."work-hours/clear_shift",
					"excel"			=> $this->url."work-hours/generate_excel",
				],
				"attendance" => [
					"record"			=> $this->url."attendance/history", /*** API Record Attendance ***/
					"dept-record"		=> $this->url."attendance/department-record", /*** Department Record Attendance ***/
					"request-record"	=> $this->url."attendance/ss_dt", /*** API Record Attendance Request ***/
					"user-record"		=> $this->url."attendance/user_attreq", /*** API Attendance Request disabled dates ***/
					"find"				=> $this->url."attendance/find_att", /*** API For View Attendance History Request ***/
					"save"				=> $this->url."attendance/save_att", /*** API For View Attendance History Request CRUD ***/
					/*** Administrator Page ***/
					/*** Attendance Request Type ***/
					"ar-record"			=> $this->url."attendance/find", /*** API For Attendance Request Type Data***/
					"ar-save"			=> $this->url."attendance/save", /*** API For Attendance Request Type CRUD***/
					/*** Approval ***/
					"find-approval"		=> $this->url."attendance/find_app", /*** API For View Attendance Approval Request ***/
					"approval"			=> $this->url."attendance/approval", /*** API For Attendance Approval***/
					/*** Email Approval ***/
					"email-app"			=> $this->url."attendance/email-app",
					"directorate"		=> $this->url."attendance/directorate",
					"generate-request"	=> $this->url."attendance/gen_req",
				],
				"training"	=> [
					"record"			=> $this->url."training/history",
					"save"				=> $this->url."training/save",
					"datatable"			=> $this->url."training/datatable",
					"approval"			=> $this->url."training/approval"
				],
				"calendar"	=> [
					"record"			=> $this->url."calendar/get_calendar",
					"holidays"			=> $this->url."calendar/holidays",
					"save"				=> $this->url."calendar/save",
				],
				/*** Moderator Page ***/
				"announcement"	=> [
					"record"			=> $this->url."announcement/history",
					"save"				=> $this->url."announcement/save",
				],
			];
			if ( !array_key_exists($this->request, $APIList) )
				return FALSE;
			else if ( !array_key_exists($this->type, $APIList[$this->request]) )
				return FALSE;
			return $APIList[$this->request][$this->type];
		}
	}