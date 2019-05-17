<?php
defined('BASEPATH') || exit('No direct script access allowed');
class Portal extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->data = array(HEADER_STRING => array('title' => 'Portal'),
                            TOP_NAV_STRING => array(),
                            CONTENT_STRING => array(),
                            FOOTER_STRING => array()
		);

		$this->lang->load('portal');
		$this->lang->load('login');
		
		$this -> load -> Model( 'Gogs_model' );
		$this -> load -> Model( 'membership_model' );
	} 
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$username = $this->session->userdata( 'username' );
		$this->data[TOP_NAV_STRING]['username'] = $username;

		$role = $this->membership_model->get_role($username);
		$is_priviledged_user = $role === 'priviledged_user';
		
		$this->data[CONTENT_STRING]['is_priviledged_user'] = $is_priviledged_user;
		$this->data[CONTENT_STRING]['userrole'] = $role;
		$this->template->set(TOP_NAV_STRING, $role.'/top_nav', $this->data[TOP_NAV_STRING]);   

		$this->template->set(HEADER_STRING, 'all/header', $this->data[HEADER_STRING]);
        $this->template->set(CONTENT_STRING, 'portal', $this->data[CONTENT_STRING]);
        $this->template->set(FOOTER_STRING, 'all/footer', $this->data[FOOTER_STRING]);
        
        $this->template->load('template');
	}
}
