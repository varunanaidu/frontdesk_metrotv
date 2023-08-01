<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/layout-top');
$this->load->view($pagename);
$this->load->view('layout/layout-bot'); ?>