<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BarAssociation
 *
 * @author jaeeme
 */
class Barassociation extends CI_Controller {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('Members_model', 'member');
        $this->load->model('Barassociation_model', 'bar');
        $this->lang->load(array('register', 'english'));
        $this->load->library('pagination');
        $this->load->library('Sendinblue');
        $this->load->helper('share');
        $this->load->helper('text');
    }
    // listing all bar association
    public function index() {
        $this->load->library('form_validation');
        $response['metaDescription'] = 'Bar Association - Get all information about bar association on Soolegal.com';
        $response['metaKeywords'] = '';
        $response['title'] = "Bar Association | SoOLEGAL";
        $response['breadcrumbs'] = array('Bar Association List' => '#', 'List' => '#');
        $response['metaOGlocale'] = 'en_US';
        $response['metaOGtype'] = 'article';
        $response['metaOGtitle'] = 'Bar Association | SoOLEGAL';
        $response['metaOGurl'] = site_url().'bar-association';
        $response['metaOGDescription'] = 'Bar Association - Get all information about bar association on Soolegal.com';
        $response['metaOGpublisher'] = "https://www.facebook.com/SOciallyOptimizedLEGAL";
        $response['metaOGsiteName'] = 'SoOLEGAL';
        $response['metaOGimage'] = HTTP_IMAGES_PATH."social-images/bar-association.jpg";
        $response['metatwitterImg'] = HTTP_IMAGES_PATH."social-images/bar-association.jpg";
        $response['metatwitterCard'] = 'summary_large_image';
        $response['metatwitterSite'] = '@Soo_Legal';
        $response['metatwitterTitle'] = 'Bar Association | SoOLEGAL';
        $response['metatwitterDescription'] = 'Bar Association - Get all information about bar association on Soolegal.com';
        $response['metatwitterCreater'] = '@Soo_Legal';
        $response['metatwitterUrl'] = site_url().'bar-association';
        $response['fbAppid'] = '121840825165548';
        $this->bar->setStatus(1);
        $this->bar->setMemberType(7);        
        if (!empty($this->input->get('ftr'))) {
            $this->bar->setBarAssociationName($this->input->get('ftr'));
        }        
        $config['total_rows'] = $this->bar->getAllBarAssociationCount();        
        $config['suffix'] = '';
        $page_number = $this->uri->segment(2);
        if ($page_number > 0) {
            $config['base_url'] = base_url() . 'bar-association';
        } else {
            $config['base_url'] = base_url() . 'bar-association';
        }            
        if (empty($page_number))
        $page_number = 1;        
        if($config['total_rows']>=10) {       
        $offset = ($page_number - 1) * $this->pagination->per_page;
        } else {
            $offset = 0;
        }
        $this->bar->setPageNumber($this->pagination->per_page);
        $this->bar->setOffset($offset);
        $this->pagination->cur_page = $offset;
        $this->pagination->initialize($config);
        $response['page_links'] = $this->pagination->create_links();
        $response['listBarAssociation'] = $this->bar->getAllBarAssociation();
        $this->load->view('barassociation/listBarAssociation', $response);
    }
    // bar association registration method
    public function register() {
        $this->load->library('form_validation');
        $response['metaDescription'] = 'Bar Association Registration';
        $response['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
        $response['title'] = "Bar Association Registration - SoOLEGAL";
        $response['breadcrumbs'] = array('Bar Association Registration' => '#', 'Add' => '#');
        $this->load->view('barassociation/addBar', $response);
    }
    //forgot password
    public function forgotpassword() {
        if ($this->session->userdata('is_authenticate_member') == TRUE) {
            redirect('member'); // the user is not logged in, redirect them!
        } else {
            $msg = $this->input->get('msg');
            $response['metaDescription'] = 'Bar Association Forgot Password';
            $response['metaKeywords'] = 'Bar Association Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $response['title'] = "Forgot Password - SoOLEGAL";
            $response['breadcrumbs'] = array('Forgot Password' => '#');
            if (!empty($msg)) {
                $response['msg'] = $msg;
            } else {
                $response['msg'] = '';
            }
            $this->load->view('barassociation/forgotPassword', $response);
        }
    }
    //send password        
    public function sendpassword() {
        if ($this->session->userdata('is_authenticate_member') == TRUE) {
            redirect('member'); // the user is not logged in, redirect them!
        } else {
            $email = $this->input->post('forgot_email');
            $this->member->setemail($email);
            $checkmail = $this->member->getEmailID();            
            if (!empty($checkmail['email'])) {
                $pass = $this->generate_random_password(6);
                $encriptPass = md5(SALT . $pass);
                $this->member->setpassword($encriptPass);
                $this->member->updatePasswordByForgotPassword();                
                $sendMsg = '';
                $firstName = $checkmail['first_name'];
                $data['mail_to'] = $checkmail['email'];
                $data['from_mail'] = FROM_MAIL;
                $data['topMsg'] = 'Dear '. $checkmail['first_name'];
                $data['bodyMsg'] = '<p>Your login ID is: ' . $checkmail['email'] . '</p><p>Your new password: ' . $pass . '</p><p>Please Click Here to <a href="' . site_url() . 'bar-association/login">Login</a>.</p>';
                $data['thanksMsg'] = 'With Best Regards,';
                $data['delimeter'] = 'SoOLEGAL team';
                $config = array(
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'priority' => '1'
                );                
                $sendMail = new Mailin(EMAIL_BASE_URL, EMAIL_API_KEY);        
                $dataMail = array( 
                    "to" => array($data['mail_to'] => $firstName),
			        "from" => array($data['from_mail'], "from SoOLEGAL"),
			        "replyto" => array(NOREPLY_MAIL, "no-reply"),
			        "subject" => "SoOLEGAL - Forgot Password",			
			        "html" => $this->load->view('mailTemplates/bar_association/forgotPassword.php', $data, TRUE),			
			        "headers" => array("Content-Type"=> "text/html; charset=iso-8859-1", "X-param1"=> "value1", "X-param2"=> "value2", "X-Mailin-custom"=>"SoOLEGAL", "X-Mailin-IP"=> IP_ADDRESS, "X-Mailin-Tag" => Mailin_TAG)
                );
                $sendMail->send_email($dataMail);                
                redirect('barassociation/forgotpassword?msg=1');
            } else {
                redirect('barassociation/forgotpassword?msg=2');
            }
        }
    }    
    // bar association login method
    public function login() {
        $rlink = urldecode(base64_decode($this->input->get('usid')));
        if ($this->input->get('verification') != null) {
            $this->member->setVerificationCode($this->input->get('verification'));
            $this->member->activateMemberAccount();
        } elseif ($this->input->get('ssid') != null) {
            $this->member->setVerificationCode($this->input->get('ssid'));
            $this->member->activateMemberAccount();
        } elseif ($rlink != null) {
            $this->member->setVerificationCode($rlink);
            $this->member->activateMemberAccount();
        }
        if ($this->session->userdata('is_authenticate_member') == TRUE) {
            redirect('barassociation/dashboard');
        } else {
            $this->load->library('form_validation');
            $response['metaDescription'] = 'Bar Association Login';
            $response['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $response['title'] = "Bar Association Login - SoOLEGAL";
            $response['breadcrumbs'] = array('Bar Association Login' => '#', 'Login' => '#');
            $this->load->view('barassociation/LoginBar', $response);
        }
    }
    // profile edit method
    public function edit() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Edit';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association Login - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Edit' => '#', 'Edit' => '#');

            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();

            $this->load->view('barassociation/controlpanel/personal-information/action/renderProfile', $data);
        }
    }
    // profile edit action method
    public function saveEdit() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $name = $this->input->post('bar_name');
            $contactno = $this->input->post('bar_contact');
            $email = $this->input->post('bar_email');
            $dof = $this->input->post('bar_doe');
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setBarAssociationName($name);
            $this->bar->setBarAssociationEmail($email);
            $this->bar->setBarAssociationContactNum($contactno);
            $this->bar->setDof($dof);
            $this->bar->updateBarAssociation();

            $this->bar->setStatus(1);
            $json['member'] = $this->bar->getSingleMemberByID();
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/personal-information/view/profile', $json);
        }
    }
    //change pwd
    public function changepwd() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $response['metaDescription'] = 'Bar Association Edit';
            $response['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $response['title'] = "Bar Association Login - SoOLEGAL";
            $response['breadcrumbs'] = array('Bar Association Edit' => '#', 'Edit' => '#');

            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $response['member'] = $this->bar->getSingleMemberByID();

            $this->load->view('barassociation/controlpanel/changepassword', $response);
        }
    }
    //save Change Pwd
    public function saveChangePwd() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $password = $this->input->post('bar_association_password');
            if (!empty($password)) {
                $encriptPass = md5(SALT . $password);
                $this->bar->setBarAssociationID($this->session->userdata('member_id'));
                $this->bar->setResetPassword($encriptPass);
                $this->bar->updateBarAssociationPassword();
            }
            $this->output->set_header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
    //change Address
    public function changeAddress() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->model('Location_model', 'location');
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Address';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association Login - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Address' => '#', 'Address' => '#');

            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();
            $this->location->setCountryID($data['member']['country']);
            
            $data['office_country'] =  $data['member']['country'];
            $data['office_state'] = $data['member']['state'];
            $data['office_city'] = $data['member']['city'];
            $data['allCountriesList'] = $this->location->getAllCountries();

            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/personal-information/action/renderAddress', $data);
        }
    }
    //save Change Address
    public function saveChangeAddress() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $google_map_url = $this->input->post('google_map_url');
            $bar_association_address = $this->input->post('resaddress');
            $bar_association_country = $this->input->post('rescountry');
            $bar_association_state = $this->input->post('resstate');
            $bar_association_city = $this->input->post('rescity');
            $bar_association_zipcode = $this->input->post('bar_zipcode');
            if (!empty($bar_association_address)) {
                $this->bar->setBarAssociationID($this->session->userdata('member_id'));
                $this->bar->setBarAssociationAddress($bar_association_address);
                $this->bar->setNewsDescription($google_map_url);
                $this->bar->setBarAssociationCountry($bar_association_country);
                $this->bar->setBarAssociationState($bar_association_state);
                $this->bar->setBarAssociationCity($bar_association_city);
                $this->bar->setBarAssociationZipcode($bar_association_zipcode);
                $this->bar->setTimestamp(time());
                $this->bar->updateBarAssociationAddress();
                $json['address'] = $this->bar->getBarAssociationAddress();
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/personal-information/view/address', $json);
        }
    }
    // bar association control panel 
    public function dashboard($param=NULL) {
        if ($this->session->userdata('bar_association') != "barassociation") {
            redirect('member/login'); // the bar association is not logged in, redirect them!
        } else {
            //Bar Association Profile
            $this->session->unset_userdata('lawyer_id');
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();
            if(empty($param) || !empty($param) && $param=='profile') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');                
                $data['addressInfo'] = $this->bar->getBarAssociationAddress();
                $data['aboutus'] = $this->bar->getbarAssociationAboutUs();
                $data['disclaimerInfo'] = $this->bar->getbarAssociationDisclaimer();
                $this->load->view('barassociation/controlpanel/display/profile', $data);            
            }
            //Bar about us
            if(!empty($param) && $param=='aboutus') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');
                $data['aboutus'] = $this->bar->getbarAssociationAboutUs();                
                $this->load->view('barassociation/controlpanel/display/aboutus', $data);            
            }            
            //Bar calendar
            if(!empty($param) && $param=='calendar') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');
                $data['calendarInfo'] = $this->bar->getbarAssociationCalendar();                
                $this->load->view('barassociation/controlpanel/display/calendar', $data);            
            }          
            // committee            
            if(!empty($param) && $param=='committee') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');
                if(!empty($this->input->get('name'))) {
                   $this->bar->setBarAssociationName(trim($this->input->get('name')));
                }
                if(!empty($this->input->get('mail'))) {
                    $this->bar->setBarAssociationEmail(trim($this->input->get('mail')));
                }
                
                if(!empty($this->input->get('cnt'))) {
                    $this->bar->setBarAssociationContactNum(trim($this->input->get('cnt')));
                }
        
                $config['total_rows'] = $this->bar->countBarCommitteeMember();        
                $config['suffix'] = '';
                $page_number = $this->uri->segment(4);                
                if ($page_number > 0) {
                    $config['base_url'] = base_url() . 'barassociation/dashboard/committee';
                } else {
                    $config['base_url'] = base_url() . 'barassociation/dashboard/committee';
                }            
                if (empty($page_number))
                $page_number = 1;
                $offset = ($page_number - 1) * $this->pagination->per_page;                
                $this->bar->setPageNumber($this->pagination->per_page);
                $this->bar->setOffset($offset);
                $this->pagination->cur_page = $offset;
                $this->pagination->initialize($config);
                $data['page_links'] = $this->pagination->create_links();
                $data['committeeMember'] = $this->bar->getCommitteeMember();
                $this->load->view('barassociation/controlpanel/display/committee', $data); 
            }
            // members            
            if(!empty($param) && $param=='members') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');
                if(!empty($this->input->get('name'))) {
                   $this->bar->setBarAssociationName(trim($this->input->get('name')));
                }
                if(!empty($this->input->get('mail'))) {
                    $this->bar->setBarAssociationEmail(trim($this->input->get('mail')));
                }
                
                if(!empty($this->input->get('cnt'))) {
                    $this->bar->setBarAssociationContactNum(trim($this->input->get('cnt')));
                }
                $config['total_rows'] = $this->bar->countBarMembers();        
                $config['suffix'] = '';
                $page_number = $this->uri->segment(4);                
                if ($page_number > 0) {
                    $config['base_url'] = base_url() . 'barassociation/dashboard/members';
                } else {
                    $config['base_url'] = base_url() . 'barassociation/dashboard/members';
                }            
                if (empty($page_number))
                $page_number = 1;
                $offset = ($page_number - 1) * $this->pagination->per_page;                
                $this->bar->setPageNumber($this->pagination->per_page);
                $this->bar->setOffset($offset);
                $this->pagination->cur_page = $offset;
                $this->pagination->initialize($config);
                $data['page_links'] = $this->pagination->create_links();
                $data['barMember'] = $this->bar->getBarAssociationConnectMember();                
                $this->load->view('barassociation/controlpanel/display/members', $data); 
            }
            // upload and move image
            if(!empty($param) && $param=='upload') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association Upload- SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');

                $move_upload_path = $this->input->post('move_upload_path');
                if(!empty($move_upload_path)) {
                    $dir    = $move_upload_path;
                    //$files1 = scandir($dir);
                    $files1 = glob($dir);
                    foreach($files1 as $value) {
                        $getFileName = strtolower($value);
                        $ext = pathinfo($getFileName, PATHINFO_EXTENSION);
                        if(!empty($ext)) {
                            $getFinalPath = explode('.', $getFileName);
                            if(!empty($getFinalPath[0])) {                                
                                $this->bar->setBarAssociationID($this->session->userdata('member_id'));
                                $this->bar->setBarAssociationRegistrationNum($getFinalPath[0]);
                                $dataPath[] = $this->bar->uploadMemberPicture();
                            }
                        }
                    }                    
                    $dataPathInfo = array_filter($dataPath);                                        
                    $data['dataPathInfo'] = $dataPathInfo;
                    $data['extension'] = $ext;
                    $data['move_upload_path'] = $move_upload_path;
                    
                }                               
                $this->load->view('barassociation/controlpanel/display/upload', $data);
            }
            // news            
            if(!empty($param) && $param=='news') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');
                if(!empty($this->input->get('srch'))) {
                    $this->bar->setContentSrch(trim($this->input->get('srch')));
                }
                $config['total_rows'] = $this->bar->countBarAssociationNews();        
                $config['suffix'] = '';
                $page_number = $this->uri->segment(4);                
                if ($page_number > 0) {
                    $config['base_url'] = base_url() . 'barassociation/dashboard/news';
                } else {
                    $config['base_url'] = base_url() . 'barassociation/dashboard/news';
                }            
                if (empty($page_number))
                $page_number = 1;
                $offset = ($page_number - 1) * $this->pagination->per_page;                
                $this->bar->setPageNumber($this->pagination->per_page);
                $this->bar->setOffset($offset);
                $this->pagination->cur_page = $offset;
                $this->pagination->initialize($config);
                $data['page_links'] = $this->pagination->create_links();
                $barAssociationNewsOnDashboard = $this->bar->getBarAssociationNews();            
                foreach($barAssociationNewsOnDashboard as $element) {
                    $this->bar->setContentID($element['news_id']);
                    $mailInfo = $this->bar->getMailInformation();
                    $notificationInfo = $this->bar->getnotificationInformation();
                    $linknews = site_url() . 'news/bar-association/' . $element['slug'];
                   $data['barAssociationNewsOnDashboard'][] = array( 
                        'news_id' => $element['news_id'],
                        'slug' => $element['slug'],
                        'head_line' => $element['head_line'],
                        'description' => word_limiter(strip_tags($element['description']), 20, '<a target="blank" href="'.$linknews.'"> [...]</a>'),
                        'image_url' => $element['image_url'],
                        'create_date_time' => $element['create_date_time'],
                        'bar_association_id' => $element['bar_association_id'],
                        'status' => $element['status'],
                        'modified_date_time' => $element['modified_date_time'],
                        'mailInfo' => $mailInfo,
                        'notificationinfo' => $notificationInfo,
                        );
                }                
                $this->load->view('barassociation/controlpanel/display/news', $data); 
            }            
            // circular            
            if(!empty($param) && $param=='circular') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');                
                if(!empty($this->input->get('srch'))) {
                    $this->bar->setContentSrch(trim($this->input->get('srch')));
                }
                $config['total_rows'] = $this->bar->countBarAssociationCircular();        
                $config['suffix'] = '';
                $page_number = $this->uri->segment(4);                
                if ($page_number > 0) {
                    $config['base_url'] = base_url() . 'barassociation/dashboard/circular';
                } else {
                    $config['base_url'] = base_url() . 'barassociation/dashboard/circular';
                }            
                if (empty($page_number))
                $page_number = 1;
                $offset = ($page_number - 1) * $this->pagination->per_page;                
                $this->bar->setPageNumber($this->pagination->per_page);
                $this->bar->setOffset($offset);
                $this->pagination->cur_page = $offset;
                $this->pagination->initialize($config);
                $data['page_links'] = $this->pagination->create_links();
                $barAssociationCircularOnDashboard = $this->bar->getBarAssociationCircular();
                // make array for bar association circular  
                foreach($barAssociationCircularOnDashboard as $element) {
                    $this->bar->setCircularID($element['circular_id']);
                    $this->bar->setContentID($element['circular_id']);
                    $smsInfo = $this->bar->getSMSInformation();
                    $count_attachment = $this->bar->checkBarCircularAttachmentCount();
                    $list_attachment = $this->bar->getBarCircularAttachment();
                    $linkclur = site_url() . 'circular/bar-association/' . $element['slug'];
                    $data['barAssociationCircularOnDashboard'][] = array(
                        'circular_id' => $element['circular_id'],
                        'slug' => $element['slug'],
                        'subject' => $element['subject'],
                        'description' => word_limiter(strip_tags($element['description']), 15, '<a target="blank" href="'.$linkclur.'"> [...]</a>'),
                        'created_date_time' => $element['created_date_time'],
                        'modified_date_time' => $element['modified_date_time'],
                        'bar_association_id' => $element['bar_association_id'],
                        'status' => $element['status'],
                        'short_url' => $element['short_url'],
                        'count_attachment' => $count_attachment,
                        'list_attachment' => $list_attachment,
                        'smsInfo' => $smsInfo
                    );
                }                
                $this->load->view('barassociation/controlpanel/display/circular', $data); 
            }            
            // gallery            
            if(!empty($param) && $param=='gallery') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');
                $data['albumsInfo'] = $this->bar->getBarAssociationImageGalleryWithAlbum();
                $this->load->view('barassociation/controlpanel/display/gallery', $data); 
            }            
            // message            
            if(!empty($param) && $param=='message') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');
                $data['smsInfo'] = $this->bar->getSMSInformation();
                $data['mailInfo'] = $this->bar->getMailInformation();
                $data['notificationInfo'] = $this->bar->getnotificationInformation();
                $this->load->view('barassociation/controlpanel/display/message', $data); 
            }          
            
            
             // notification            
            if(!empty($param) && $param=='notification') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');
               
              
                $data['notificationInfo'] = $this->bar->getnotificationInformation();
                $this->load->view('barassociation/controlpanel/display/notification', $data); 
            }          
            // role            
            if(!empty($param) && $param=='role') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');
                $data['roleInfo'] = $this->bar->getAllRole();               
                $this->load->view('barassociation/controlpanel/display/role', $data); 
            }
            // add member
            if(!empty($param) && $param=='addmember') {
                $this->load->model('Profile_model', 'profile');
                $lawyer_id = $this->uri->segment(4);
                if(!empty($lawyer_id)) {
                    $this->session->set_userdata(array('lawyer_id' => $lawyer_id));
                } else {
                    $this->session->set_userdata(array('lawyer_id' => 'blank_id'));
                }                                 
                $this->load->library('form_validation');
                $this->load->model('Location_model', 'location');   
                $data = array();             
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association Add Member - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#'); 
                $data['geoplugin_countryCode'] = 'IN';
                $data['country_phone_code_list'] = $this->location->getCountryPhoneCode();
                $this->bar->setmemberID($lawyer_id);
                $this->bar->setStatus(1);
                $memberInfo = $this->bar->editBarAssociationMember();
                if(!empty($memberInfo) && count($memberInfo)>0){
                    $data['first_name'] = $memberInfo['first_name'];
                    $data['last_name'] = $memberInfo['last_name'];
                    $data['email'] = $memberInfo['email'];
                    $data['contact_num'] = $memberInfo['contact_num'];
                    $data['profile_picture'] = $memberInfo['profile_picture'];
                    
                    if(!empty($memberInfo['bar_association_num'])) {
                        $data['bar_association_num'] = $memberInfo['bar_association_num'];
                        $data['mban_id'] = $memberInfo['mban_id'];
                    } else {
                        $data['bar_association_num'] ='';
                        $data['mban_id'] ='';
                    }
                    if(!empty($memberInfo['bar_council_registration_num'])) {
                        $data['bar_council_registration_num'] = $memberInfo['bar_council_registration_num'];
                        $data['council_id'] = $memberInfo['council_id'];
                    } else {
                        $data['bar_council_registration_num'] = '';
                        $data['council_id'] = '';
                    }
                    $data['office_address_id'] = ''; 
                    $data['chamber_address_id'] = ''; 
                    $data['residence_address_id'] ='';
                    $this->profile->setMemberID($this->session->userdata('lawyer_id')); 
                    $data['lawyer_id'] = $this->session->userdata('lawyer_id');
                    $memberAddress = $this->profile->getLawyerAddress();
                    
                    foreach($memberAddress as $element) {
                        //office Address
                        if($element['flag']==1){
                            $data['officeAddress'] = array(
                                'office_address_id' => $element['address_id'],
                                'office_contact_num' => $element['contact_num'],
                                'office_address' => $element['personal_address'],
                                'office_country' => $element['country_id'],
                                'office_pincode' => $element['personal_pincode'],
                                'office_state' => $element['state_id'],
                                'office_city' => $element['city_id'],
                                'office_pactice_location' => $element['personal_pactice_location'],
                                'office_status' => $element['address_status'],
                                'office_flag' => $element['flag'],
                                'office_primary_address' => $element['primary_address'],
                            );
                        }
                        // Chamber Address
                        if($element['flag']==2){
                            $data['chamberAddress'] = array(
                                'chamber_address_id' => $element['address_id'],
                                'chamber_contact_num' => $element['contact_num'],
                                'chamber_address' => $element['personal_address'],
                                'chamber_country' => $element['country_id'],
                                'chamber_pincode' => $element['personal_pincode'],
                                'chamber_state' => $element['state_id'],
                                'chamber_city' => $element['city_id'],
                                'chamber_pactice_location' => $element['personal_pactice_location'],
                                'chamber_status' => $element['address_status'],
                                'chamber_flag' => $element['flag'],
                                'chamber_primary_address' => $element['primary_address'],
                            );
                        }
                        // Residence Address
                        if($element['flag']==3){
                            $data['residenceAddress'] = array(
                                'residence_address_id' => $element['address_id'],
                                'residence_contact_num' => $element['contact_num'],
                                'residence_address' => $element['personal_address'],
                                'residence_country' => $element['country_id'],
                                'residence_pincode' => $element['personal_pincode'],
                                'residence_state' => $element['state_id'],
                                'residence_city' => $element['city_id'],
                                'residence_pactice_location' => $element['personal_pactice_location'],
                                'residence_status' => $element['address_status'],
                                'residence_flag' => $element['flag'],
                                'residence_primary_address' => $element['primary_address'],
                            );
                        }
                    }
                    $data['member_id'] = $this->session->userdata('lawyer_id');
                    
                } else {
                    $data['first_name']='';
                    $data['last_name']='';
                    $data['email']='';
                    $data['contact_num']='';
                    $data['profile_picture'] ='';
                    $data['lawyer_id'] = '';
                    $data['member_id']='';
                    $data['bar_council_registration_num'] = '';
                    $data['mban_id'] ='';
                    $data['council_id'] ='';
                    $data['officeAddress'] = array(); 
                    $data['chamberAddress'] = array(); 
                    $data['residenceAddress'] = array();   
                    $data['bar_association_num'] ='';                                    
                }             
                
                $data['allCountriesList'] = $this->location->getAllCountries();                          
                $this->load->view('barassociation/controlpanel/display/newmember', $data); 
            }           
            // settings            
            if(!empty($param) && $param=='settings') {
                $this->load->library('form_validation');
                $data['metaDescription'] = 'Bar Association Dashboard';
                $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
                $data['title'] = "Bar Association - SoOLEGAL";
                $data['breadcrumbs'] = array('Bar Association Dashboard' => '#', 'List' => '#');
                $data['smsInfo'] = $this->bar->getSMSInformation();
                $data['mailInfo'] = $this->bar->getMailInformation();
                $data['notificationInfo'] = $this->bar->getnotificationInformation();
                $this->load->view('barassociation/controlpanel/display/settings', $data); 
            }
           
                           
        }       
    }
    
    // bar association control panel
    public function profile($username = '', $pagename = '', $pagename2 = '') {
        $this->load->helper('text');
        if ($username != '' && !empty($username)) {
            $this->bar->setUserName($username);
            $member_id['memberinfo'] = $this->bar->getMemberID();
        } else {
            if ($this->session->userdata('is_authenticate_member') == TRUE) {
                $member_id['memberinfo']['member_id'] = $this->session->userdata('member_id');
                $member_id['memberinfo']['member_type'] = $this->session->userdata('member_type');
            } else {
                $response['profile'] = 'Bar association does not exist';
                $response['title'] = "Bar association does not exist - SoOLEGAL";
                $this->load->view('errors/html/error_404', $response);
            }
        }
        if (empty($member_id['memberinfo'])) {
            $response['profile'] = 'Bar association does not exist';
            $response['title'] = "Bar association does not exist - SoOLEGAL";
            $this->load->view('errors/html/error_404', $response);
        } else {
            $this->load->library('form_validation');
            $this->bar->setBarAssociationID($member_id['memberinfo']['member_id']);
            $this->bar->setStatus(1);
            $response['member'] = $this->bar->getSingleMemberByID();

            $response['home'] = site_url() . 'bar-association/' . $username;
            $response['committeemember'] = site_url() . 'bar-association/' . $username . '/committee-member';
            $response['circular'] = site_url() . 'bar-association/' . $username . '/circular';
            $response['news'] = site_url() . 'bar-association/' . $username . '/news';

            $response['aboutus'] = site_url() . 'bar-association/' . $username . '/about-us';
            $response['roarlink'] = site_url() . 'bar-association/' . $username . '/roar';
            $response['barMember'] = site_url() . 'bar-association/' . $username . '/members';
            $response['calendar'] = site_url() . 'bar-association/' . $username . '/calendar';
            $response['disclaimer'] = site_url() . 'bar-association/' . $username . '/disclaimer';
            $response['gallery'] = site_url() . 'bar-association/' . $username . '/gallery';
            $response['helpline'] = site_url() . 'bar-association/' . $username . '/helpline';
            $response['pastofficials'] = site_url() . 'bar-association/' . $username . '/past-officials';
            $response['contactus'] = site_url() . 'bar-association/' . $username . '/contact-us';
            $response['bar_asso_name'] = $username;
            $response['bar_association_url'] = site_url() . 'bar-association/'. $username;
            $this->bar->setPageNumber(3);
            $barAssociationCircular = $this->bar->getBarAssociationCircular();
            foreach($barAssociationCircular as $element) {
                $this->bar->setCircularID($element['circular_id']);
                $count_attachment = $this->bar->checkBarCircularAttachmentCount();
                $response['barAssociationCircular'][] = array(
                    'circular_id' => $element['circular_id'],
                    'slug' => $element['slug'],
                    'subject' => $element['subject'],
                    'description' => $element['description'],
                    'created_date_time' => $element['created_date_time'],
                    'modified_date_time' => $element['modified_date_time'],
                    'bar_association_id' => $element['bar_association_id'],
                    'status' => $element['status'],
                    'count_attachment' => $count_attachment,
                );
            }
            $response['barAssociationNews'] = $this->bar->getBarAssociationNews();
            $response['disclaimerInfo'] = $this->bar->getbarAssociationDisclaimer();
            if (!empty($pagename) && $pagename == 'committee-member') {
            $response['metaDescription'] = '';
            $response['metaKeywords'] = '';
            $response['title'] =  'Commitee Members :'.$response['member']['first_name'].' | SoOLEGAL';
            $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                $item_per_page = 10;
                $page_number = $this->input->post('bacm_page');
                $position = (($page_number - 1) * $item_per_page);
                $this->bar->setOffset($position);
                $this->bar->setPageNumber($item_per_page);
                if(!empty($this->input->get('name'))) {
                   $this->bar->setBarAssociationName(trim($this->input->get('name')));
                }
                if(!empty($this->input->get('mail'))) {
                    $this->bar->setBarAssociationEmail(trim($this->input->get('mail')));
                }
                
                if(!empty($this->input->get('cnt'))) {
                    $this->bar->setBarAssociationContactNum(trim($this->input->get('cnt')));
                }
                
                $response['totalCount'] = $this->bar->countBarCommitteeMember();
                
                $response['bar_association_id'] = $member_id['memberinfo']['member_id'];
                
                $this->load->view('barassociation/front/committeemember', $response);
            } 
            elseif (!empty($pagename) && $pagename  == 'members') {
                
            $response['metaDescription'] = '';
            $response['metaKeywords'] = '';
            $response['title'] =  'Members :'.$response['member']['first_name'].' | SoOLEGAL';
            $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                $item_per_page = 10;
                $page_number = $this->input->post('baam_page');
                $position = (($page_number - 1) * $item_per_page);
                $this->bar->setOffset($position);
                $this->bar->setPageNumber($item_per_page);
                
                if(!empty($this->input->get('name'))) {
                   $this->bar->setBarAssociationName(trim($this->input->get('name')));
                }
                if(!empty($this->input->get('mail'))) {
                    $this->bar->setBarAssociationEmail(trim($this->input->get('mail')));
                }
                
                if(!empty($this->input->get('cnt'))) {
                    $this->bar->setBarAssociationContactNum(trim($this->input->get('cnt')));
                }
                $response['totalCount'] = $this->bar->countBarMembers();                
                $response['bar_association_id'] = $member_id['memberinfo']['member_id'];                
                $this->load->view('barassociation/front/member', $response);
            }
            elseif (!empty($pagename) && $pagename == 'aboutus') {
                $response['metaDescription'] = '';
                $response['metaKeywords'] = '';
                $response['title'] = 'About Us :'.$response['member']['first_name'].' | SoOLEGAL';
                $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                $response['aboutusinfo'] = $this->bar->getbarAssociationAboutUs();
                $this->load->view('barassociation/front/aboutus', $response);
            }
            elseif (!empty($pagename) && $pagename == 'calendar') {
                $response['metaDescription'] = '';
                $response['metaKeywords'] = '';
                $response['title'] =  'Calender :'.$response['member']['first_name'].' | SoOLEGAL';
                $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                $response['calendarInfo'] = $this->bar->getbarAssociationCalendar();
                $this->load->view('barassociation/front/calendar', $response);
            } 
            elseif (!empty($pagename) && $pagename == 'gallery') {
                 $response['metaDescription'] = '';
                 $response['metaKeywords'] = '';
                 $response['title'] =  'Gallery :'.$response['member']['first_name'].' | SoOLEGAL';
                 $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                if(!empty($pagename2)) {
                    $this->bar->setalbumID($pagename2);
                    $response['imageGalleryInfo'] = $this->bar->getBarAssociationImageGallery();
                    $this->load->view('barassociation/front/gallery', $response);
                } else {                    
                    $response['imageAlbumInfo'] = $this->bar->getBarAssociationAlbum();
                    $this->load->view('barassociation/front/album', $response);
                }
            } 
            
            elseif (!empty($pagename) && $pagename == 'news') {
                $response['metaDescription'] = '';
                $response['metaKeywords'] = '';
                $response['title'] =  'News :'.$response['member']['first_name'].' | SoOLEGAL';
                $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                if(!empty($this->input->get('srch'))) {
                    $this->bar->setContentSrch(trim($this->input->get('srch')));
                }
                $config['total_rows'] = $this->bar->countBarAssociationNews();        
                $config['suffix'] = '';
                $page_number = $this->uri->segment(4);                
                if ($page_number > 0) {
                    $config['base_url'] = base_url() . 'bar-association/demo-bar-association-spn/news';
                } else {
                    $config['base_url'] = base_url() . 'bar-association/demo-bar-association-spn/news';
                }            
                if (empty($page_number))
                $page_number = 1;
                $offset = ($page_number - 1) * $this->pagination->per_page;                
                $this->bar->setPageNumber($this->pagination->per_page);
                $this->bar->setOffset($offset);
                $this->pagination->cur_page = $offset;
                $this->pagination->initialize($config);
                $response['page_links'] = $this->pagination->create_links();
                $barAssociationNewsOnSite = $this->bar->getBarAssociationNews();            
                foreach($barAssociationNewsOnSite as $element) {
                    $this->bar->setContentID($element['news_id']);
                    $mailInfo = $this->bar->getMailInformation();
                    $notificationInfo = $this->bar->getnotificationInformation();
                    $linknews = site_url() . 'news/bar-association/' . $element['slug'];
                    $response['barAssociationNewsList'][] = array( 
                        'news_id' => $element['news_id'],
                        'slug' => $element['slug'],
                        'head_line' => $element['head_line'],
                        'description' => word_limiter(strip_tags($element['description']), 20, '<a target="blank" href="'.$linknews.'"> [...]</a>'),
                        'image_url' => $element['image_url'],
                        'create_date_time' => $element['create_date_time'],
                        'bar_association_id' => $element['bar_association_id'],
                        'status' => $element['status'],
                        'modified_date_time' => $element['modified_date_time'],                        
                        );
                }
                //$response['barAssociationNewsList'] = $this->bar->getBarAssociationNews();
                $this->load->view('barassociation/front/news', $response);
            } elseif (!empty($pagename) && $pagename == 'circular') {
                $response['metaDescription'] = '';
                $response['metaKeywords'] = '';
                $response['title'] =  'Circular :'.$response['member']['first_name'].' | SoOLEGAL';
                $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                if(!empty($this->input->get('srch'))) {
                    $this->bar->setContentSrch(trim($this->input->get('srch')));
                }
                $config['total_rows'] = $this->bar->countBarAssociationCircular();        
                $config['suffix'] = '';
                $page_number = $this->uri->segment(4);                
                if ($page_number > 0) {
                    $config['base_url'] = base_url() . 'bar-association/demo-bar-association-spn/circular';
                } else {
                    $config['base_url'] = base_url() . 'bar-association/demo-bar-association-spn/circular';
                }            
                if (empty($page_number))
                $page_number = 1;
                $offset = ($page_number - 1) * $this->pagination->per_page;                
                $this->bar->setPageNumber($this->pagination->per_page);
                $this->bar->setOffset($offset);
                $this->pagination->cur_page = $offset;
                $this->pagination->initialize($config);
                $response['page_links'] = $this->pagination->create_links();
                $barAssociationCircularSite = $this->bar->getBarAssociationCircular();
                // make array for bar association circular  
                foreach($barAssociationCircularSite as $element) {
                    $this->bar->setCircularID($element['circular_id']);
                    $this->bar->setContentID($element['circular_id']);
                    $smsInfo = $this->bar->getSMSInformation();
                    $count_attachment = $this->bar->checkBarCircularAttachmentCount();
                    $list_attachment = $this->bar->getBarCircularAttachment();
                    $linkclur = site_url() . 'circular/bar-association/' . $element['slug'];
                    $response['barAssociationCircularList'][] = array(
                        'circular_id' => $element['circular_id'],
                        'slug' => $element['slug'],
                        'subject' => $element['subject'],
                        'description' => word_limiter(strip_tags($element['description']), 15, '<a target="blank" href="'.$linkclur.'"> [...]</a>'),
                        'created_date_time' => $element['created_date_time'],
                        'modified_date_time' => $element['modified_date_time'],
                        'bar_association_id' => $element['bar_association_id'],
                        'status' => $element['status'],
                        'count_attachment' => $count_attachment,
                        'list_attachment' => $list_attachment,                        
                    );
                }               
                $this->load->view('barassociation/front/circular', $response);
            }
            
            elseif (!empty($pagename) && $pagename == 'circular1') {
                $response['metaDescription'] = '';
                $response['metaKeywords'] = '';
                $response['title'] =  'Circular :'.$response['member']['first_name'].' | SoOLEGAL';
                $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                 $response['barAssociationCircularList'] = $this->bar->getBarAssociationCircular();
                $this->load->view('barassociation/front/circular1', $response);
            } 
            elseif (!empty($pagename) && $pagename == 'helpline') {
                $response['metaDescription'] = '';
                $response['metaKeywords'] = '';
                $response['title'] =  'Helpline :'.$response['member']['first_name'].' | SoOLEGAL';
                $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                $response['helplineTitle'] = 'Help Line';
                $this->load->view('barassociation/front/helpline', $response);
            }
            elseif (!empty($pagename) && $pagename == 'past-officials') {
                $response['metaDescription'] = '';
                $response['metaKeywords'] = '';
                $response['title'] = 'Past Officials :'.$response['member']['first_name'].' | SoOLEGAL';
                $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                $response['pastofficialsTitle'] = 'Past Officials';
                $this->load->view('barassociation/front/pastofficials', $response);
            }
            elseif (!empty($pagename) && $pagename == 'contact-us') {
                $response['metaDescription'] = '';
                $response['metaKeywords'] = '';
                $response['title'] = 'Contact Us :'.$response['member']['first_name'].' | SoOLEGAL';
                $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                $response['contactusInfo'] = '';//$this->bar->getbarAssociationCalendar();
                $this->load->view('barassociation/front/contactus', $response);
            }
            elseif (!empty($pagename) && $pagename == 'about-us') {
                $response['metaDescription'] = '';
                $response['metaKeywords'] = '';
                $response['title'] = 'About Us :'.$response['member']['first_name'].' | SoOLEGAL';
                $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                $response['aboutusinfo'] = $this->bar->getbarAssociationAboutUs();
                $this->load->view('barassociation/front/home', $response);
                
                
            }
            else {
                $response['metaDescription'] = '';
                $response['metaKeywords'] = '';
                $response['title'] = $response['member']['first_name'].' | SoOLEGAL';
                $response['breadcrumbs'] = array('Bar Association Profile' => '#', 'List' => '#');
                $response['aboutusinfo'] = $this->bar->getbarAssociationAboutUs();
                $this->load->view('barassociation/front/home', $response);
            }
        }
    }
    // bar Associate Members
    public function barAssociateMembers() {
        $json = array();
        $item_per_page = 10;
        $page_number = $this->input->post('baam_page');
        $position = (($page_number - 1) * $item_per_page);
        $barBssociationID = $this->input->post('barBssociationID');
        
        if(!empty($this->input->post('name'))) {
           $this->bar->setBarAssociationName(trim($this->input->post('name')));
        }
        if(!empty($this->input->post('mail'))) {
            $this->bar->setBarAssociationEmail(trim($this->input->post('mail')));
        }
        
        if(!empty($this->input->post('cnt'))) {
            $this->bar->setBarAssociationContactNum(trim($this->input->post('cnt')));
        }
        
        $this->bar->setOffset($position);
        $this->bar->setPageNumber($item_per_page);
        $this->bar->setBarAssociationID($barBssociationID);
        $this->bar->setStatus(1);
        $json['barMemberInfo'] = $this->bar->getBarAssociationConnectMember();
        $this->output->set_header('Content-Type: application/json');
        $this->load->view('barassociation/front/loadMoreMember', $json);
    }
    // bar Associate Committee Members
    public function barAssociateCommitteeMembers() {
        $json = array();
        $item_per_page = 10;
        $page_number = $this->input->post('bacm_page');
        $position = (($page_number - 1) * $item_per_page);
        $barBssociationCID = $this->input->post('barBssociationCID');
        
        if(!empty($this->input->post('name'))) {
           $this->bar->setBarAssociationName(trim($this->input->post('name')));
        }
        if(!empty($this->input->post('mail'))) {
            $this->bar->setBarAssociationEmail(trim($this->input->post('mail')));
        }
        
        if(!empty($this->input->post('cnt'))) {
            $this->bar->setBarAssociationContactNum(trim($this->input->post('cnt')));
        }
        
        $this->bar->setOffset($position);
        $this->bar->setPageNumber($item_per_page);
        $this->bar->setBarAssociationID($barBssociationCID);
        $this->bar->setStatus(1);
        $json['committeeMemberInformaion'] = $this->bar->getCommitteeMember();        
        $this->output->set_header('Content-Type: application/json');
        $this->load->view('barassociation/front/loadMoreCommitteeMember', $json);
    }
    
    // create bar association registration method
    public function barRegistration() {
        $json = array();
        $firstName = $this->input->post('name');
        $contactNum = $this->input->post('bar_association_contactno');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $passwordConfirm = $this->input->post('passwordConfirm');
        $memberType = $this->input->post('memberType');

        $bar_association_registration = $this->input->post('bar_registration_no');
        $bar_association_court_name = $this->input->post('bar_association_court_name');
        $bar_association_address = $this->input->post('bar_association_address');
        $bar_association_aboutus = $this->input->post('bar_association_aboutus');

        $verificationCode = uniqid();
        $rLink = site_url() . 'bar-association/login?usid=' . urlencode(base64_encode($verificationCode));

        $encriptPass = md5(SALT . $password);

        if (empty($firstName)) {
            $json['error']['bar_association_name'] = $this->lang->line('error_association_name');
        }

        if (empty(trim($email))) {
            $json['error']['bar_association_email'] = $this->lang->line('error_email_address');
        }

        if (!preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
            $json['error']['bar_association_email'] = $this->lang->line('error_email_chkvalid');
        }

        if (empty($password)) {
            $json['error']['bar_association_password'] = $this->lang->line('error_password');
        }

        if (empty(trim($contactNum))) {
            $json['error']['bar_association_contactno'] = $this->lang->line('error_phone');
        }

        if (empty(trim($bar_association_registration))) {
            $json['error']['bar_association_registration_no'] = $this->lang->line('error_association_registration_num');
        }


        if (empty(trim($bar_association_court_name))) {
            $json['error']['bar_association_court_name'] = $this->lang->line('error_court_name');
        }
        if (!$json) {
            if (!empty($email)) {
                $this->load->library('email');
                $userName = $this->member->createUniqueUsername('member',trim($firstName), 'username');
                $this->member->setuserName($userName);
                $this->member->setfirstName($firstName);
                $this->member->setcontactNum($contactNum);
                $this->member->setemail($email);
                $this->member->setpassword($encriptPass);
                $this->member->setgender(0);
                $this->member->setdob(0);
                $this->member->setstatus(1);
                $this->member->setVerificationCode($verificationCode);
                $this->member->setTimestamp(time());
                $this->member->setmemberType($memberType);

                // sms functionality
                if (!empty($contactNum)) {
                    $smsMSG = '';
                    $this->load->model('Smsapi_model', 'msgApi');
                    $link = $rLink;
                    $smsMSG .= urlencode('We welcome you to SoOLEGAL family');
                    $smsMSG .= urlencode('login ID: ' . $userName . ' password: ' . $password);
                    $smsMSG .= urlencode(' ' . $link);
                     $bindData = "username=" . SMS_USER_NAME . "&password=" . SMS_PWD . "&senderid=" . SMS_SENDER_ID . "&number=" . $contactNum ."&route=" . SMS_ROUTE_ID . "&message=" . $smsMSG;
                    $this->msgApi->setSmsUrl(SMS_URL);
                    $this->msgApi->setSmsData($bindData);
                    // call sms send method 
                    $this->msgApi->postSmsData();
                }
                // mail functionality
                $sendMsg = '';
                $data['mail_to'] = $email;
                $data['from_mail'] = FROM_MAIL;
                $data['topMsg'] = 'Dear ' . $firstName;
                $data['bodyMsg'] = '<p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;"><strong>We welcome you to SoOLEGAL family!</strong> It’s a great platform for lawyer and clients to find each other and stay connected.</p><p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;">You are receiving this email because you recently signed up to our SoOLEGAL services. To activate your account you can click on the button given below.</p><table border="0" cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;"><tr><td valign="top" align="center"><p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;"><a style="display:inline-block;color:white;background:#03618c;border:solid #03618c;border-width:10px 20px 10px 20px;font-weight:bold;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;text-decoration:none;" href="' . $rLink . '">Activate Account</a></p></td></tr></table>';
                $data['thanksMsg'] = 'Thank You,';
                $data['delimeter'] = 'SoOLEGAL Team';
                $config = array(
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'priority' => '1'
                );
                // call member registration method 
                $getLastID = $this->member->createMember();
                $this->bar->setBarAssociationRegistrationNum($bar_association_registration);
                $this->bar->setBarAssociationCourt($bar_association_court_name);
                $this->bar->setBarAssociationAddress($bar_association_address);
                $this->bar->setBarAssociationAbout($bar_association_aboutus);
                $this->bar->setBarAssociationID($getLastID);
                $this->bar->setTimestamp(time());
                $this->bar->setstatus(4);
                $this->bar->createBarAssociationRegistrationNum();
                $this->bar->createBarAssociationCourtName();
                $this->bar->createBarAssociationAddress();
                $this->bar->createBarAssociationAbout(); 
                $sendMail = new Mailin(EMAIL_BASE_URL, EMAIL_API_KEY);        
                $dataMail = array( 
                    "to" => array($data['mail_to'] => $firstName),
			        "from" => array($data['from_mail'], "from SoOLEGAL"),
			        "replyto" => array(NOREPLY_MAIL, "no-reply"),
			        "subject" => "SoOLEGAL - Verification",			
			        "html" => $this->load->view('mailTemplates/memberRegisterVerification', $data, TRUE),			
			        "headers" => array("Content-Type"=> "text/html; charset=iso-8859-1", "X-param1"=> "value1", "X-param2"=> "value2", "X-Mailin-custom"=>"SoOLEGAL", "X-Mailin-IP"=> IP_ADDRESS, "X-Mailin-Tag" => Mailin_TAG)
                );
                $sendMail->send_email($dataMail);                
                
                $json['success'] = 'success';
            }
        }
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }
    // bar association login action method
    public function doLogin() {
        $this->load->library('email');
        $this->load->library('form_validation');
        if ($this->session->userdata('is_authenticate_member') == TRUE) {
            redirect(base_url() . 'member');
        } else if (empty($this->input->post('username')) && empty($this->input->post('password'))) {
            redirect(base_url() . 'member/login');
        } else {
            if ($this->input->post('login_bar_association')) {
                $this->form_validation->set_rules('username', 'email', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');

                if ($this->form_validation->run() == FALSE) {
                    $response['title'] = 'SoOLEGAL - Home';
                    $response['metaDescription'] = 'SoOLEGAL - Login';
                    $response['metaKeywords'] = 'SoOLEGAL - Login';
                    $this->parser->parse('home/Home', $response);
                } else {
                    $username = $this->input->post('username');
                    $password = $this->input->post('password');
                    $enc_pass = md5(SALT . $password);
                    $this->member->setVerificationCode(1);
                    $this->member->setuserName($username);
                    $this->member->setpassword($enc_pass);
                    $this->member->setStatusIN(7);
                    $check = $this->member->checkLogin();
                    if ($check > 0) {
                        $dologin = $this->member->doLogin();
                        $this->session->set_userdata(
                            array(
                                'member_id' => $dologin->member_id,
                                'username' => $dologin->username,
                                 'firstname' => $dologin->first_name,
                                'email' => $dologin->email,
                                'custom_url' => $dologin->custom_url,
                                'is_authenticate_member' => TRUE,
                                'member_type' => $dologin->member_type,
                                'bar_association' => 'barassociation',
                            )
                        );
                        $this->member->setmemberID($dologin->member_id);
                        $memberCount = $this->member->getMemberCount();
                        if (empty($memberCount['count'])) {
                            // sms functionality
                            if (!empty($dologin->contact_num)) {
                                $smsMSG = '';
                                $this->load->model('Smsapi_model', 'msgApi');
                                $smsMSG .= urlencode('We welcome you to SoOLEGAL family.');
                                $bindData = "username=" . SMS_USER_NAME . "&password=" . SMS_PWD . "&senderid=" . SMS_SENDER_ID . "&number=" . $dologin->contact_num ."&route=" . SMS_ROUTE_ID . "&message=" . $smsMSG;
                                $this->msgApi->setSmsUrl(SMS_URL);
                                $this->msgApi->setSmsData($bindData);
                                // call sms send method 
                                $this->msgApi->postSmsData();
                            }

                            if (!empty($dologin->email)) {
                                // Start Welcome mail functionality for default user
                                $sendMsg = '';
                                $firstName = $dologin->first_name;
                                $data['mail_to'] = $dologin->email;
                                $data['from_mail'] = FROM_MAIL;
                                $data['topMsg'] = 'Dear ' . $dologin->email;

                                $data['bodyMsg'] = '<p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;"><strong>We welcome you to SoOLEGAL family!</strong> It’s a great platform for lawyer and clients to find each other and stay connected.</p><p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;">.</p><table border="0" cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;"><tr><td valign="top" align="center"><p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;"><a style="display:inline-block;color:white;background:#03618c;border:solid #03618c;border-width:10px 20px 10px 20px;font-weight:bold;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;text-decoration:none;" href="' . base_url(). 'barassociation/dashboard' . $dologin->username . '">Click</a></p></td></tr></table>';
                                $data['thanksMsg'] = 'Thank You,';
                                $data['delimeter'] = 'SoOLEGAL Team';
                                $config = array(
                                    'mailtype' => 'html',
                                    'charset' => 'utf-8',
                                    'priority' => '1'
                                );                                
                                $sendMail = new Mailin(EMAIL_BASE_URL, EMAIL_API_KEY);        
                                $dataMail = array( 
                                    "to" => array($data['mail_to'] => $firstName),
			                        "from" => array($data['from_mail'], "from SoOLEGAL"),
			                        "replyto" => array(NOREPLY_MAIL, "no-reply"),
			                        "subject" => "SoOLEGAL - Request complete your profile",			
			                        "html" => $this->load->view('mailTemplates/reminder/memberProfilePictureReminder', $data, TRUE),			
			                        "headers" => array("Content-Type"=> "text/html; charset=iso-8859-1", "X-param1"=> "value1", "X-param2"=> "value2", "X-Mailin-custom"=>"SoOLEGAL", "X-Mailin-IP"=> IP_ADDRESS, "X-Mailin-Tag" => Mailin_TAG)
                                );
                                
                                $sendMail->send_email($dataMail);
                                // End Welcome mail functionality for default user
                            }
                            $this->member->setMemberCount(1);
                            $this->member->insertMemberCount();
                        } else {
                            $this->member->setMemberCount($memberCount['count'] + 1);
                            $this->member->updateMemberCount();
                        }

                        if ($this->input->post('remember_me') == 'on') {
                            $this->load->helper('cookie');
                            $cookie = array(
                                'name' => 'login_user',
                                'value' => $dologin->username,
                                'expire' => time() + 604800,
                                'path' => '/'
                            );
                            $this->input->set_cookie($cookie);
                        }
                        redirect('barassociation/dashboard');
                    } else {
                        //echo $check;
                        $this->session->set_flashdata('err_msg', '<div class="alert alert-danger">Invalid username or password. </div>');
                        redirect('/barassociation/login?umsg=1');                        
                    }
                }
            } else {
                redirect('bar-association/login');
            }
        }
    }
    // bar association logout method
    public function logout() {
        $this->session->unset_userdata('member_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('custom_url');
        $this->session->unset_userdata('bar_association');
        $this->session->unset_userdata('member_type');
        $this->session->unset_userdata('is_member_login');
        $this->session->unset_userdata('is_firm_login');
        $this->session->unset_userdata('is_authenticate_member');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('bar-association/login');
    }
    // list Member
    public function listMember() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);

            $json['roleList'] = $this->bar->getAllRole();
            $json['memberList'] = $this->bar->getAllMember();
            $committee_member_id = $this->input->post('committee_member_id');

            if (!empty($committee_member_id)) {
                $this->bar->setCmID($committee_member_id);
                $json['committeeMemberInfo'] = $this->bar->getSingleCommitteeMemberByID();
            } else {
                $json['committeeMemberInfo'] = '';
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/committee-member/renderCommitteeMember', $json);
        }
    }
    //check Committee Member
    public function checkCommitteeMember() {  
        $json = array();          
        $committeeMemberID = $this->input->post('bam_member_id');
        $committee_id = $this->input->post('committee_id');        
        $this->bar->setBarAssociationID($this->session->userdata('member_id'));
        $this->bar->setCommitteeMemberID($committeeMemberID);
        $this->bar->setCmID($committee_id);
        if(!empty($committee_id)) {
            $json['count_cm'] = $this->bar->updateCheckCommitteeMember();
        } else {
            $json['count_cm'] = $this->bar->checkCommitteeMember();
        }        
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }
    //save Member    
    public function saveMember() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $cmID = $this->input->post('cm_id');
            $committeeMemberID = $this->input->post('member_id');
            $roleID = $this->input->post('role_id');
            $position = $this->input->post('position');
            if (!empty($committeeMemberID)) {
                $this->bar->setBarAssociationID($this->session->userdata('member_id'));
                $this->bar->setRoleName($roleID);
                $this->bar->setCommitteeMemberID($committeeMemberID);
                $this->bar->setTimestamp(time());
                $this->bar->setStatus(4);
                $this->bar->setPosition($position);
                if (!empty($cmID)) {
                    $this->bar->setCmID($cmID);
                    $this->bar->updateCommitteeMember();
                    $this->bar->setCmID($cmID);
                    $json['committeeMemberInfo'] = $this->bar->getSingleCommitteeMemberByID();
                    $json['updated'] = 'updated';
                } else {
                    $cmID = $this->bar->createCommitteeMember();
                    $this->bar->setCmID($cmID);
                    $json['committeeMemberInfo'] = $this->bar->getSingleCommitteeMemberByID();
                    $json['created'] = 'created';
                }
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/committee-member/committeeMember', $json);
        }
    }
    // add Member
    public function addMember() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Member';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Member' => '#', 'List' => '#');

            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();

            $data['roleList'] = $this->bar->getAllRole();
            $data['memberList'] = $this->bar->getAllMember();
            $this->load->view('barassociation/controlpanel/add/addMember', $data);
        }
    }
    // list News
    public function listNews() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $news_id = $this->input->post('news_id');
            if (!empty($news_id)) {
                $this->bar->setNewsID($news_id);
                $json['barAssociationNews'] = $this->bar->getSingleNewsByID();
            } else {
                $json['barAssociationNews'] = '';
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/news/renderNews', $json);
        }
    }
    // save News
    public function saveNews() {
        $this->load->model('Universal_model', 'universal');
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $news_id = $this->input->post('news_id');
            $head_line = $this->input->post('head_line');
            $news_description = $this->input->post('description');
            if (!empty($_FILES['imageURL'])) {
                $path = ROOT_UPLOAD_BAR_ASSOCIATION_NEWS_PATH;
                $initi = $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "gif|jpg|jpeg|png|bmp",
                    "remove_spaces" => TRUE
                ));
                if (!$this->upload->do_upload('imageURL')) {
                    $error = array('error' => $this->upload->display_errors());
                    echo $this->upload->display_errors();
                } else {
                    $data = $this->upload->data();
                    $image_url = $data['file_name'];
                }
                $configThumb = array(
                    'source_image' => $data['full_path'],
                    'new_image' => ROOT_UPLOAD_BAR_ASSOCIATION_NEWS_PATH . '_thumb/',
                    'maintain_ratio' => FALSE,
                    'width' => 100,
                    'height' => 100
                );

                $this->load->library('image_lib', $configThumb);
                $this->image_lib->resize();
            } else {
                $image_url = '';
            }
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $slug = $this->universal->createUniqueSlug('bar_association_news', trim($head_line), 'slug', NULL, NULL);
            $this->bar->setSlug($slug);
            $this->bar->setHeadLine($head_line);
            $this->bar->setNewsDescription($news_description);
            $this->bar->setImageUrl($image_url);
            $this->bar->setTimestamp(time());
            $this->bar->setStatus(4);
            if (!empty($news_id)) {
                $this->bar->setNewsID($news_id);
                $this->bar->updateNews();
                $json['success'] = 'updated';
            } else {
                $news_id = $this->bar->createNews();
                $this->bar->setNewsID($news_id);
                $json['success'] = 'created';
            }            
            if (!empty($news_id)) {
                $barAssociationNews = $this->bar->getSingleNewsByID();
                $linkNews = site_url() . 'news/bar-association/' . $barAssociationNews['slug'];
                $summary = word_limiter(strip_tags($barAssociationNews['description']), 20, '<a target="blank" href="'.$linkNews.'"> [...]</a>');
                $json['barAssociationNews'] = array(
                    'news_id' => $barAssociationNews['news_id'], 
                    'image_url' => $barAssociationNews['image_url'],
                    'head_line' => $barAssociationNews['head_line'],
                    'linkSlug' => $linkNews,
                    'description' => $summary,
                    'create_date_time' => date(DATE_FORMAT, $barAssociationNews['create_date_time']),
                );
            }
            
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/news/news', $json);
        }
    }
    // add News
    public function addNews() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association News';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association News' => '#', 'List' => '#');

            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();

            $this->load->view('barassociation/controlpanel/add/addNews', $data);
        }
    }
    //list Circular
    public function listCircular() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $circular_id = $this->input->post('circular_id');
            if (!empty($circular_id)) {
                $this->bar->setCircularID($circular_id);
                $barAssociationCircular = $this->bar->getSingleCircularByID();                
                $count_attachment = $this->bar->checkBarCircularAttachmentCount();
                $list_attachment = $this->bar->getBarCircularAttachment();
                $json['barAssociationCircular'] = array(
                    'circular_id' => $barAssociationCircular['circular_id'], 
                    'subject' => $barAssociationCircular['subject'],
                    'description' => $barAssociationCircular['description'],
                    'created_date_time' => $barAssociationCircular['created_date_time'],
                    'attachment' => $list_attachment,
                    'count_attachment' => $count_attachment,
                );                
            } else {
                $json['barAssociationCircular'] = '';
            }            
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/circular/renderCircular', $json);
        }
    }
    // add Circular
    public function addCircular() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Circular';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Circular' => '#', 'List' => '#');

            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();

            $this->load->view('barassociation/controlpanel/add/addCircular', $data);
        }
    }
    // save Circular
    public function saveCircular() {
        $this->load->model('Universal_model', 'universal');
        $this->load->library('GoogleURL');
        $this->googleurl->_initialize(GOOGLE_URL_SHORTNER);        
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $circular_id = $this->input->post('circular_id');
            $subject = $this->input->post('subject');
            $circular_description = $this->input->post('description');
            $upload_attachment = $this->input->post('attachment_title');
            
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $slug = $this->universal->createUniqueSlug('bar_association_circular', trim($subject), 'slug', NULL, NULL);
            //ALTER TABLE `bar_association_circular` ADD `short_url` TEXT NULL DEFAULT NULL AFTER `status`;
            $shortCircularURL = site_url() . 'circular/bar-association/' .$slug;
            $shortURLCircular = $this->googleurl->shorten($shortCircularURL);
            $this->bar->setShortUrl($shortURLCircular);
            $this->bar->setSlug($slug);
            $this->bar->setHeadLine($subject);
            $this->bar->setNewsDescription($circular_description);
           
            $this->bar->setTimestamp(time());
            $this->bar->setStatus(4);
            if (!empty($circular_id)) {
                $this->bar->setCircularID($circular_id);
                $this->bar->updateCircular();                
                $json['success'] = 'updated';
            } else {
                $circular_id = $this->bar->createCircular();
                $this->bar->setCircularID($circular_id); 
                
                $json['success'] = 'created';
            }            
            $slugAttachment = '';
            if (!empty($_FILES['attachment_url']) && count($_FILES['attachment_url']) > 0) {
                $path = ROOT_UPLOAD_BAR_ASSOCIATION_CIRCULAR_PATH;
                // Define file rules
                $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "jpg|jpeg|png|bmp|doc|docx|xlsx|xls|pdf",
                    "remove_spaces" => TRUE
                ));
                if ($this->upload->do_multi_upload("attachment_url")) {
                    $data['upload_data'] = $this->upload->get_multi_upload_data();
                    $this->load->library('image_lib');
                    $this->image_lib->resize();
                } else {
                    $errors = array('error' => $this->upload->display_errors('<p class = "bg-danger">', '</p>'));
                    foreach ($errors as $k => $error) {
                        echo $error;
                    }
                }
                if (!empty($data['upload_data']) && count($data['upload_data']) > 0) {
                    foreach ($data['upload_data'] as $key => $element) {
                        $slugAttachment = $this->universal->createUniqueSlug('resource_centre_attachment', trim($upload_attachment[$key]), 'slug', NULL, NULL);
                        $batch[] = array(
                            'slug' => $slugAttachment,
                            'title' => $upload_attachment[$key],
                            'url' => $element['file_name'],
                            'circular_id' => $circular_id,
                        );
                    }
                    $this->bar->setBatchImport($batch);
                    $this->bar->addAircularAttachment();
                }
            }
            if (!empty($circular_id)) {
                $barAssociationCircular = $this->bar->getSingleCircularByID();
                $count_attachment = $this->bar->checkBarCircularAttachmentCount();
                $list_attachment = $this->bar->getBarCircularAttachment();
                $linkSlug = site_url() . 'circular/bar-association/' . $barAssociationCircular['slug'];
                $json['barAssociationCircular'] = array(
                    'circular_id' => $barAssociationCircular['circular_id'], 
                    'subject' => $barAssociationCircular['subject'],
                    'linkSlug' => $linkSlug,
                    'short_url' => $barAssociationCircular['short_url'],
                    'description' => word_limiter(strip_tags($barAssociationCircular['description']), 15, '<a target="blank" href="'.$linkSlug.'"> [...]</a>'),
                    'created_date_time' => $barAssociationCircular['created_date_time'],
                    'attachment' => $list_attachment,
                    'count_attachment' => $count_attachment,
                );
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/circular/circular', $json);
        }
    }    
    // delete resource centre attachment
    public function deleteBarCircularAttachment() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setAttachmentID($this->input->post('circular_attach_id'));
            $json = $this->bar->barCircularDeleteAttachment();
        }
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }
    // add AboutUs
    public function addAboutUs() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association About Us';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association About Us' => '#', 'List' => '#');

            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();
            $data['aboutus'] = $this->bar->getbarAssociationAboutUs();

            $this->load->view('barassociation/controlpanel/add/addAboutUs', $data);
        }
    }
    // profile edit method
    public function editAboutus() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Edit';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association Login - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Edit' => '#', 'Edit' => '#');
            $aboutID = $this->input->post('about_id');
            $this->bar->setAboutUsID($aboutID);
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $data['aboutus'] = $this->bar->getbarAssociationAboutUs();
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/personal-information/action/renderAboutus', $data);
        }
    }

 // sms method
    public function viewsms() {      
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Edit';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association Login - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Edit' => '#', 'Edit' => '#');
            $smsID = $this->input->post('sms_id');
            $this->bar->setsmsID($smsID);
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $data['smsInfo'] = $this->bar->getbarAssociationsms();            
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/sms/renderSMS', $data);
        }
    }

 public function viewmail() {       
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Edit';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association Login - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Edit' => '#', 'Edit' => '#');
            $mailID = $this->input->post('mail_id');
            $this->bar->setmailID($mailID);
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $data['mailInfo'] = $this->bar->getbarAssociationmail();
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/mail/renderMAIL', $data);
        }
    }
    
    
    
 public function viewnotification() {       
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Edit';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association Login - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Edit' => '#', 'Edit' => '#');
            $notificationID = $this->input->post('notification_id');
            $this->bar->setmailID($notificationID);
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $data['notificationInfo'] = $this->bar->getbarAssociationnotification();
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/mail/renderNOTIFICATION', $data);
        }
    }
    
    
    
    
    //save AboutUs
    public function saveAboutUs() {
        $json = array();
        $description = $this->input->post('description');
        if (!empty($description)) {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setNewsDescription($description);
            $this->bar->setTimestamp(time());
            $this->bar->setStatus(4);
            $this->bar->barAssociationAboutUs();
            $json['aboutus'] = $this->bar->getbarAssociationAboutUs();
        }
        $this->output->set_header('Content-Type: application/json');
        $this->load->view('barassociation/controlpanel/personal-information/action/aboutus', $json);
    }
    // add Disclaimer
    public function addDisclaimer() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Disclaimer';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Disclaimer' => '#', 'List' => '#');

            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();


            $data['disclaimerInfo'] = $this->bar->getbarAssociationDisclaimer();
            $this->load->view('barassociation/controlpanel/add/addDisclaimer', $data);
        }
    }
    // edit Disclaimer edit method
    public function editDisclaimer() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Edit';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association Login - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Edit' => '#', 'Edit' => '#');
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $data['disclaimerInfo'] = $this->bar->getbarAssociationDisclaimer();
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/disclaimer/renderDisclaimer', $data);
        }
    }
    // save Disclaimer
    public function saveDisclaimer() {
        $json = array();
        $description = $this->input->post('description');
        if (!empty($description)) {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setNewsDescription($description);
            $this->bar->setTimestamp(time());
            $this->bar->setStatus(4);
            $this->bar->barAssociationDisclaimer();
            $json['disclaimerInfo'] = $this->bar->getbarAssociationDisclaimer();
        }
        $this->output->set_header('Content-Type: application/json');
        $this->load->view('barassociation/controlpanel/disclaimer/disclaimer', $json);
    }
    // list Album
    public function listAlbum() {    
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $album_id = $this->input->post('album_id');
            if (!empty($album_id)) {
                $this->bar->setalbumID($album_id);
                $json['albumInfo'] = $this->bar->getSingleAlbumByID();                
            } else {
                $json['albumInfo'] = '';
            }           
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/gallery/renderAlbum', $json);
        }
    }
    // save Album
    public function saveAlbum() {    
        $json = array();
        $album_id = $this->input->post('album_id');
        $album_title = $this->input->post('album_title');
        $album_caption = $this->input->post('album_caption');
        $date_time = $this->input->post('date_time');
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            if (!empty($_FILES['imageURL'])) {
                $path = ROOT_UPLOAD_BAR_ASSOCIATION_GALLERY_PATH;
                $initi = $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "gif|jpg|jpeg|png|bmp|pdf",
                    "remove_spaces" => TRUE
                ));

                if (!$this->upload->do_upload('imageURL')) {
                    $error = array('error' => $this->upload->display_errors());
                    echo $this->upload->display_errors();
                } else {
                    $data = $this->upload->data();
                    $image_url = $data['file_name'];
                }
                $configThumb = array(
                    'source_image' => $data['full_path'],
                    'new_image' => ROOT_UPLOAD_BAR_ASSOCIATION_GALLERY_PATH . '_thumb/',
                    'maintain_ratio' => FALSE,
                    'width' => 300,
                    'height' => 200
                );
                $this->load->library('image_lib', $configThumb);
                $this->image_lib->resize();
            } else {
                $image_url = '';
            }
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setalbumID($album_id);            
            $this->bar->setHeadLine($album_title);
            $this->bar->setNewsDescription($album_caption);
            $this->bar->setPublishDate(strtotime($date_time));
            $this->bar->setImageUrl($image_url);
            $this->bar->setTimestamp(time());
            $this->bar->setStatus(4);
            if (!empty($album_id)) {
                $this->bar->setalbumID($album_id);
                $this->bar->updateAlbumGallery();
                $json['albumInfo'] = $this->bar->getSingleAlbumByID();
                $json['success'] = 'updated';
            } else {
                $album_id = $this->bar->createAlbumGallery();
                $this->bar->setalbumID($album_id);
                $json['albumInfo'] = $this->bar->getSingleAlbumByID();
                $json['success'] = 'created';
            }            
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/gallery/albumImage', $json);
        }
    }
    // back To Albums
    public function backToAlbums() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));                
            $json['albumsInfo'] = $this->bar->getBarAssociationImageGalleryWithAlbum();            
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/display/listAlbums', $json);
        }
    }
    //display Bar Association Image Gallery
    public function displayBarAssociationImageGallery() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));            
            $album_id = $this->input->post('album_id');
            if (!empty($album_id)) {
                $this->bar->setalbumID($album_id);
                $json['renderGallery'] = $this->bar->getBarAssociationImageGallery();               
                $json['albumName'] = $this->bar->getSingleAlbumByID();
            } 
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/display/listGallery', $json);
        }
    }
    //list Gallery
    public function listGallery() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $json['albumList'] = $this->bar->getBarAssociationAlbum();
            $gallery_id = $this->input->post('gallery_id');
            $album_id = $this->input->post('album_id');
            if (!empty($gallery_id)) {
                $this->bar->setGalleryID($gallery_id);
                $json['imageGalleryInfo'] = $this->bar->getSingleImageGalleryByID();
            } else {
                $json['imageGalleryInfo'] = '';
                if(!empty($album_id)) {    
                    $json['album_id'] = $album_id;
                } else {
                    $json['album_id'] = 0;
                }
                
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/gallery/renderImageGallery', $json);
        }
    }
    // save gallery
    public function savegallery() {
        $json = array();
        $gallery_id = $this->input->post('gallery_id');
        $album_id = $this->input->post('album_id');
        if(!empty($album_id)){
            $album_id = $album_id;
        } else {
            $album_id = 0;
        }
        $caption = $this->input->post('caption');
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            if (!empty($_FILES['imageURL'])) {
                $path = ROOT_UPLOAD_BAR_ASSOCIATION_GALLERY_PATH;
                $initi = $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "gif|jpg|jpeg|png|bmp|pdf",
                    "remove_spaces" => TRUE
                ));

                if (!$this->upload->do_upload('imageURL')) {
                    $error = array('error' => $this->upload->display_errors());
                    echo $this->upload->display_errors();
                } else {
                    $data = $this->upload->data();
                    $image_url = $data['file_name'];
                }
                $configThumb = array(
                    'source_image' => $data['full_path'],
                    'new_image' => ROOT_UPLOAD_BAR_ASSOCIATION_GALLERY_PATH . '_thumb/',
                    'maintain_ratio' => FALSE,
                    'width' => 300,
                    'height' => 200
                );
                $this->load->library('image_lib', $configThumb);
                $this->image_lib->resize();
            } else {
                $image_url = '';
            }
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setGalleryID($gallery_id);
            $this->bar->setalbumID($album_id);
            $this->bar->setHeadLine($caption);
            $this->bar->setImageUrl($image_url);
            $this->bar->setTimestamp(time());
            $this->bar->setStatus(4);
            if (!empty($gallery_id)) {
                $this->bar->setGalleryID($gallery_id);
                $this->bar->updateImageGallery();
                $json['imageGalleryInfo'] = $this->bar->getSingleImageGalleryByID();
                $json['success'] = 'updated';
            } else {
                $gallery_id = $this->bar->createImageGallery();
                $this->bar->setGalleryID($gallery_id);
                $json['imageGalleryInfo'] = $this->bar->getSingleImageGalleryByID();
                $json['success'] = 'created';
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/gallery/imageGallery', $json);
        }        
    }
    //list Multiple Gallery
    public function listMultipleGallery() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $json['albumList'] = $this->bar->getBarAssociationAlbum();
            $gallery_id = $this->input->post('gallery_id');
            $album_id = $this->input->post('album_id');
            if (!empty($gallery_id)) {
                $this->bar->setGalleryID($gallery_id);
                $json['imageGalleryInfo'] = $this->bar->getSingleImageGalleryByID();
            } else {
                $json['imageGalleryInfo'] = '';
                if(!empty($album_id)) {    
                    $json['album_id'] = $album_id;
                } else {
                    $json['album_id'] = 0;
                }
                
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/gallery/renderMultipleGallery', $json);
        }
    }
    // add multiple image in gallery
    public function saveMultipleImageGallery() {
        $json = array();
        $gallery_id = $this->input->post('gallery_id');
        $album_id = $this->input->post('album_id');
        if(!empty($album_id)){
            $album_id = $album_id;
        } else {
            $album_id = 0;
        }
        $caption = $this->input->post('caption');
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {            
          $path = ROOT_UPLOAD_BAR_ASSOCIATION_GALLERY_PATH;
          // Define file rules
          $this->upload->initialize(array(
              "upload_path" => $path,
              "allowed_types" => "gif|jpg|jpeg|png|bmp",
              "remove_spaces" => TRUE
          ));
            
          if ($this->upload->do_multi_upload("imageURL")) {
              $data['upload_data'] = $this->upload->get_multi_upload_data();
              $this->load->library('image_lib');
              foreach ($data['upload_data'] as $key => $element) {
                  $getFileName[] = $element['file_name'];
                  $configThumb = array(
                      'source_image' => $element['full_path'],
                      'new_image' => ROOT_UPLOAD_BAR_ASSOCIATION_GALLERY_PATH . '_thumb/',
                      'maintain_ratio' => FALSE,
                      'width' => 100,
                      'height' => 100
                  );
                  $this->image_lib->initialize($configThumb);
                  $this->image_lib->resize();
                  $this->image_lib->clear();
              }
              for ($i = 0; $i < count($getFileName); $i++) {
                $createBunch[] = array('image_url' => $getFileName[$i], 'caption' => $caption, 'bar_association_id' => $this->session->userdata('member_id'), 'create_date_time' => time(), 'status' => 4, 'album_id' => $album_id);
                $json['imageGalleryInfo'][] = array('image_url' => $getFileName[$i], 'caption' => $caption, 'bar_association_id' => $this->session->userdata('member_id'), 'create_date_time' => time(), 'status' => 4, 'album_id' => $album_id, 'gallery_id' =>0);
              }
              $this->bar->setBatchImport($createBunch);
              $this->bar->importImageGallery();
          } else {
              $errors = array('error' => $this->upload->display_errors('<p class = "bg-danger">', '</p>'));
              foreach ($errors as $k => $error) {
                echo $error;
              }
          }
          $this->output->set_header('Content-Type: application/json');
          $this->load->view('barassociation/controlpanel/gallery/imageMultipleGallery', $json);
        }
    }
    // add Gallery
    public function addGallery() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Gallery';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Gallery' => '#', 'List' => '#');

            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();

            $data['disclaimerInfo'] = $this->bar->getbarAssociationDisclaimer();
            $this->load->view('barassociation/controlpanel/add/addGallery', $data);
        }
    }
    // add Calendar
    public function addCalendar() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Calendar';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Calendar' => '#', 'List' => '#');
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();
            $data['calendarInfo'] = $this->bar->getbarAssociationCalendar();
            $this->load->view('barassociation/controlpanel/add/addCalendar', $data);
        }
    }
    //edit Calendar
    public function editCalendar() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->load->library('form_validation');
            $data['metaDescription'] = 'Bar Association Calendar';
            $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
            $data['title'] = "Bar Association - SoOLEGAL";
            $data['breadcrumbs'] = array('Bar Association Calendar' => '#', 'List' => '#');
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $data['calendarInfo'] = $this->bar->getbarAssociationCalendar();
            $this->load->view('barassociation/controlpanel/personal-information/action/renderCalendar', $data);
        }
    }
    // save Calendar
    public function saveCalendar() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $add_calendar = $_FILES['imageURL'];
            if (!empty($add_calendar)) {
                $path = ROOT_UPLOAD_BAR_ASSOCIATION_CALENDAR_PATH;
                $initi = $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "gif|jpg|jpeg|png|bmp",
                    "remove_spaces" => TRUE
                ));
                $image_url = 'no-img.jpg';
                if (!$this->upload->do_upload('imageURL')) {
                    $error = array('error' => $this->upload->display_errors());
                    echo $this->upload->display_errors();
                } else {
                    $data = $this->upload->data();
                    $image_url = $data['file_name'];
                }
                $configThumb = array(
                    'source_image' => $data['full_path'],
                    'new_image' => ROOT_UPLOAD_BAR_ASSOCIATION_CALENDAR_PATH . '_thumb/',
                    'maintain_ratio' => FALSE,
                    'width' => 300,
                    'height' => 200
                );
                $this->load->library('image_lib', $configThumb);
                $this->image_lib->resize();
                $this->bar->setBarAssociationID($this->session->userdata('member_id'));
                $this->bar->setImageUrl($image_url);
                $this->bar->barAssociationCalendar();
                $json['calendarInfo'] = $this->bar->getbarAssociationCalendar();
                $this->output->set_header('Content-Type: application/json');
                $this->load->view('barassociation/controlpanel/personal-information/action/calendar', $json);
            }
        }
    }

    public function listRole() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $role_id = $this->input->post('role_id');
            if (!empty($role_id)) {
                $this->bar->setRoleID($role_id);
                $json['roleInfo'] = $this->bar->getSingleRoleByID();
            } else {
                $json['roleInfo'] = '';
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/personal-information/role/renderRole', $json);
        }
    }

    public function saveRole() {
        $json = array();
        $role_id = $this->input->post('role_id');
        $role_name = $this->input->post('role_name');
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setRoleID($role_id);
            $this->bar->setRoleName($role_name);
            $this->bar->setStatus(4);
            if (!empty($role_id)) {
                $this->bar->setRoleID($role_id);
                $this->bar->updateRole();
                $json['roleInfo'] = $this->bar->getSingleRoleByID();
                $json['success'] = 'updated';
            } else {
                $role_id = $this->bar->createRole();
                $this->bar->setRoleID($role_id);
                $json['roleInfo'] = $this->bar->getSingleRoleByID();
                $json['success'] = 'created';
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/controlpanel/personal-information/role/role', $json);
        }
    }
    public function array_map_assoc( $callback , $array ){
      $r = array();
      foreach ($array as $key=>$value)
        $r[$key] = $callback($key,$value);
      return $r;
    }
    // send SMS
    public function sendSMS() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            $json['success'] = 'failed';
        } else {
        $content = $this->input->post('sms_content');
        $type = $this->input->post('type');
        $test_mobile = $this->input->post('test_mobile');
        $this->bar->setBarAssociationID($this->session->userdata('member_id'));
         
        $this->bar->setStatus(1);
        $barInformation = $this->bar->getSingleMemberByID();
        // for committee members
        if($type=='commitee'){
            $getSMSMember = $this->bar->createSMSBatchCommitteeMember();        
        }
        else {
            $getSMSMember = $this->bar->createSMSBatchBarAssociationConnectMember();
        }
                
        foreach($getSMSMember as $key=>$element) {
            if(preg_match('/^\d{10}$/',$element['contact_num'])) {
                $mobileNo[] = $element['contact_num'];
            }
        }
        // send Delhi Bar Association aditional message 
        if($this->session->userdata('member_id') == 3949) {
            $mobileNo[] = '9654235738'; 
            $mobileNo[] = '9910613016';
            $mobileNo[] = '8588821499';
            $mobileNo[] = '9910402374';
            $mobileNo[] = '9811038518';
            $mobileNo[] = '9971311578';
            $mobileNo[] = '9654681238';
            $mobileNo[] = '9811138858';
            $mobileNo[] = '9711102532';
        }
        // news delhi bar association
        else if ($this->session->userdata('member_id') == 20719) {
            $mobileNo[] = '9540764588';
            $mobileNo[] = '9711102532';
        }  
        else if ($this->session->userdata('member_id') == 20722) {
            $mobileNo[] = '9711102532';
        } 
        $getMobileNum = implode(',', $mobileNo);        
        
        if(!empty($test_mobile)) {
            $totalMember = 1;
            // delhi high court bar association
            if($this->session->userdata('member_id') == 3949) {
                $status = $this->sendSMSBarAssociationDHCBA($test_mobile, $content);
            } 
            // new delhi bar association
            elseif($this->session->userdata('member_id') == 20719) {
                $status = $this->sendSMSBarAssociationNDBA($test_mobile, $content);
            }
            // Rohini Court Bar Association 
            elseif($this->session->userdata('member_id') == 20722){
                         $status = $this->sendSMSBarAssociationRCBA($test_mobile, $content);
                    }
            else {
                $status = $this->sendSMSBarAssociation($test_mobile, $content, $barInformation['first_name']);
            }
        } else {
            $totalMember = count($getSMSMember);
            // delhi high court bar association 
            if($this->session->userdata('member_id') == 3949) {
                $status = $this->sendSMSBarAssociationDHCBA($getMobileNum, $content);
            }
            // new delhi bar association
            elseif($this->session->userdata('member_id') == 20719) {
                $status = $this->sendSMSBarAssociationNDBA($getMobileNum, $content);
            }
            // Rohini Court Bar Association
            elseif($this->session->userdata('member_id') == 20722){
                 $status = $this->sendSMSBarAssociationRCBA($getMobileNum, $smsContent, $smsContentURL, $smsContentDelimiter);
            }
            else { 
                $status = $this->sendSMSBarAssociation($getMobileNum, $content, $barInformation['first_name']);
            }
        }
        if($status === TRUE) {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setTimestamp(TIMESTAMP_FORMAT);
            $this->bar->setMsgTotal($totalMember);
            $this->bar->setNewsDescription($content);
            $this->bar->setStatus(1);
            $this->bar->sendSMS();
            $json['success'] = 'success';
        }
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }
    // send Mail
    public function sendMail() {
        $json = array();
        $subject = $this->input->post('email_subject');
        $content = $this->input->post('email_content');
        $type = $this->input->post('type');
        $test_email = $this->input->post('test_email');
        $this->bar->setBarAssociationID($this->session->userdata('member_id'));
        
        $this->bar->setStatus(1);
        $barInformation = $this->bar->getSingleMemberByID();        
        if($type=='commitee'){
            $getSMSMember = $this->bar->getCommitteeMember();        
        } else {
            $getSMSMember = $this->bar->getBarAssociationConnectMember();
        }
        $totalMember = count($getSMSMember); 
        if(!empty($test_email)) {
            $status = $this->sendMailBarAssociation($test_email, 'SoOLEGAL', $content, $barInformation['email'], $barInformation['first_name'], $subject);
        } else {        
            foreach($getSMSMember as $key=>$element) {
                $status = $this->sendMailBarAssociation($element['email'], $element['first_name'], $content, $barInformation['email'], $barInformation['first_name'], $subject);
            }
        }
        
        if($status === TRUE) {
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $this->bar->setTimestamp(TIMESTAMP_FORMAT);
            $this->bar->setMsgTotal($totalMember);
            $this->bar->setNewsDescription($content);
            $this->bar->setHeadLine($subject);
            $this->bar->setStatus(1);
            $this->bar->sendMail();
            $json['success'] = 'success'; 
        }        
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }    
    //send Circular SMS
    public function sendCircularSMS() {
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            $json['success'] = 'failed';
        } else {
            $json = array();
            $status = FALSE;
            $circular_id = $this->input->post('sms_circular');
            $smsContent = $this->input->post('smsContent');
            $smsContentURL = $this->input->post('smsContentURL');
            
            $smsContentDelimiter = $this->input->post('smsContentDelimiter');
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $test_mobile = $this->input->post('test_sms_contact');
            $type = $this->input->post('type');
            $this->bar->setStatus(1);
            $barInformation = $this->bar->getSingleMemberByID();
    
            //$getSMSMember = $this->bar->getBarAssociationConnectMemberCircularSMS();
            
            if($type=='commitee-notif'){
                $getSMSMember = $this->bar->createSMSBatchCommitteeMember();        
            }
            else {
                $getSMSMember = $this->bar->createSMSBatchBarAssociationConnectMember();
            }
            
            foreach ($getSMSMember as $key => $element) {
                if (preg_match('/^\d{10}$/', $element['contact_num'])) {
                    $mobileNo[] = $element['contact_num'];
                }
            }           
            
            // delhi high court bar association
            if ($this->session->userdata('member_id') == 3949) {
                $mobileNo[] = '9654235738';
                $mobileNo[] = '9910613016';
                $mobileNo[] = '8588821499';
                $mobileNo[] = '9910402374';
                $mobileNo[] = '9811038518';
                $mobileNo[] = '9971311578';
                $mobileNo[] = '9654681238';
                $mobileNo[] = '9811138858';
                $mobileNo[] = '9711102532';
            } 
            // news delhi bar association
            else if ($this->session->userdata('member_id') == 20719) {
                $mobileNo[] = '9540764588';
                $mobileNo[] = '9711102532';
            }
            
            // Dwarka Court Bar Association
            else if ($this->session->userdata('member_id') == 20720) {
                $mobileNo[] = '9953805001';
                $mobileNo[] = '9868339956';
                $mobileNo[] = '9711102532';
            }
            // Rohini Court Bar Association
            else if ($this->session->userdata('member_id') == 20722) {
                $mobileNo[] = '9711102532';
            }
            // Saket Court Bar Association 
            else if ($this->session->userdata('member_id') == 20721) {
                $mobileNo[] = '9711102532';
            }
            // Gurugram Court Bar Association
            else if ($this->session->userdata('member_id') == 68255) {
                $mobileNo[] = '9711102532';
            }
            
            // make comma seperated values
            $getMobileNum = implode(',', $mobileNo);
            if(!empty($smsContent)) {
                if (!empty($test_mobile)) {
                    $totalMember = 1;
                    // delhi high court bar association
                    if ($this->session->userdata('member_id') == 3949) {
                        $status = $this->sendSMSBarAssociationDHCBA($test_mobile, $smsContent, $smsContentURL, $smsContentDelimiter);
                    } 
                    // new delhi bar association
                    elseif($this->session->userdata('member_id') == 20719){
                        $status = $this->sendSMSBarAssociationNDBA($test_mobile, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    // Dwarka Court Bar Association 
                    elseif($this->session->userdata('member_id') == 20720){
                         $status = $this->sendSMSBarAssociationDCBA($test_mobile, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    // Rohini Court Bar Association 
                    elseif($this->session->userdata('member_id') == 20722){
                         $status = $this->sendSMSBarAssociationRCBA($test_mobile, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    // Saket Court Bar Association 
                    elseif($this->session->userdata('member_id') == 20721){
                         $status = $this->sendSMSBarAssociationSCBA($test_mobile, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    // Gurugram Court Bar Association 
                    elseif($this->session->userdata('member_id') == 68255){
                         $status = $this->sendSMSBarAssociationDBAG($test_mobile, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    else {
                        $status = $this->sendSMSBarAssociation($test_mobile, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    $json['success'] = 'test-sms';
                } else {
                    $totalMember = count($getSMSMember);
                    // delhi high court bar association
                    if ($this->session->userdata('member_id') == 3949) {
                        $status = $this->sendSMSBarAssociationDHCBA($getMobileNum, $smsContent, $smsContentURL, $smsContentDelimiter);
                    } 
                    // new delhi bar association
                    elseif($this->session->userdata('member_id') == 20719){
                        $status = $this->sendSMSBarAssociationNDBA($getMobileNum, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    // Dwarka Court Bar Association 
                    elseif($this->session->userdata('member_id') == 20720){
                         $status = $this->sendSMSBarAssociationDCBA($getMobileNum, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    // Rohini Court Bar Association
                    elseif($this->session->userdata('member_id') == 20722){
                         $status = $this->sendSMSBarAssociationRCBA($getMobileNum, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    // Saket Court Bar Association
                    elseif($this->session->userdata('member_id') == 20721){
                         $status = $this->sendSMSBarAssociationSCBA($getMobileNum, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    // Gurugram Court Bar Association
                    elseif($this->session->userdata('member_id') == 68255){
                         $status = $this->sendSMSBarAssociationDBAG($getMobileNum, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    
                    else {
                        $status = $this->sendSMSBarAssociation($getMobileNum, $smsContent, $smsContentURL, $smsContentDelimiter);
                    }
                    if ($status === TRUE) {
                        $this->bar->setBarAssociationID($this->session->userdata('member_id'));
                        $this->bar->setTimestamp(TIMESTAMP_FORMAT);
                        $this->bar->setMsgTotal($totalMember);
                        $this->bar->setNewsDescription($smsContent.'\n'.$smsContentURL.'\n'.$smsContentDelimiter);
                        $this->bar->setStatus(1);
                        $this->bar->setMobileLog($getMobileNum);
                        $this->bar->setContentType(1);
                        $this->bar->setContentID($circular_id);
                        $lastID = $this->bar->sendSMS();
                        $json['rendercnt'] = '<li><span class="badge" title="Count">'.$totalMember.'</span> <i class="fa fa-fw fa-calendar" title="Date"></i> '.date(DATE_FORMAT, TIMESTAMP_FORMAT).' <a href="javascript:void(0);" id="view-smsdescription" data-smsid='.$lastID.' data-toggle="modal" data-target="#smsdescription"><i class="fa fa-fw fa-eye"></i>View SMS</a></li>';
                        $json['success'] = 'success';
                    }
                }
            } else {
                $json['success'] = 'failed';
            }
            
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }   
    // send News Notify
    public function sendNewsNotify() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            $json['success'] = 'failed';
        } else {
            $news_id = $this->input->post('notify_news');
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));        
            $this->bar->setStatus(1);
            $barInformation = $this->bar->getSingleMemberByID();        
            $getSMSMember = $this->bar->getBarAssociationConnectMember();
            $totalMember = count($getSMSMember);         
            $this->bar->setNewsID($news_id);
            $newsInfo = $this->bar->getSingleNewsByID();
            $subject = 'Notification from '.$barInformation['first_name'];
            $link = site_url() . 'news/bar-association/' . $newsInfo['slug'];        
            $content = 'News Notification read more click here. <br /><a target="_blank" href="'.$link.'">'.$newsInfo['head_line'].'</a>';        
            $emailArr = array();
            foreach($getSMSMember as $key=>$element) {
                $emailArr[] = $element['email'];
                if (preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $element['email'])) {
                    $status = $this->sendMailBarAssociation($element['email'], $element['first_name'], $content, $barInformation['email'], $barInformation['first_name'], $subject);
                }
            }
            $getEmailArr = implode(',', $emailArr);        
            if($status === TRUE) {
                $this->bar->setBarAssociationID($this->session->userdata('member_id'));
                $this->bar->setTimestamp(TIMESTAMP_FORMAT);
                $this->bar->setMsgTotal($totalMember);
                $this->bar->setNewsDescription($content);
                $this->bar->setHeadLine($subject);
                $this->bar->setStatus(1);
                $this->bar->setMobileLog($getEmailArr);
                $this->bar->setContentType(1);
                $this->bar->setContentID($news_id);
                $lastID = $this->bar->sendMail();
                $json['renderncnt'] = '<li><span class="badge" title="Count">'.$totalMember.'</span> <i class="fa fa-fw fa-calendar" title="Date"></i> '.date(DATE_FORMAT, TIMESTAMP_FORMAT).' <a href="javascript:void(0);" id="view-maildescription" data-mailid='.$lastID.' data-toggle="modal" data-target="#maildescription"><i class="fa fa-fw fa-eye"></i>View Mail</a></li>';
                $json['success'] = 'success';
            }
        }              
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }
    //delete Bar Association Item
    public function deleteBarAssociationItem() {    
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE && $this->session->userdata('bar_association') != "barassociation") {
            redirect('bar-association/login'); // the bar association is not logged in, redirect them!
        } else {    
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));
            $flag = $this->input->post('flag');
            if (!empty($flag) && $flag == 'committeemember') {
                $committee_member_id = $this->input->post('delete_id');
                $this->bar->setCommitteeMemberID($committee_member_id);
                $this->bar->removeCommitteMember();
            } else if (!empty($flag) && $flag == 'barassonews') {
                $news_id = $this->input->post('delete_id');
                $this->bar->setNewsID($news_id);
                $this->bar->removeNews();
            } else if (!empty($flag) && $flag == 'barassocircular') {
                $circular_id = $this->input->post('delete_id');
                $this->bar->setCircularID($circular_id);
                $this->bar->removeCircular();
            } else if (!empty($flag) && $flag == 'barassogallery') {
                $gallery_id = $this->input->post('delete_id');
                $this->bar->setGalleryID($gallery_id);
                $this->bar->removeImageGallery();
            }

else if (!empty($flag) && $flag == 'barassoalbum') {
                $album_id = $this->input->post('delete_id');
                $this->bar->setAlbumID($album_id);
                $this->bar->removeImageAlbum();
            }
 else if (!empty($flag) && $flag == 'barassorole') {
                $role_id = $this->input->post('delete_id');
                $this->bar->setRoleID($role_id);
                $this->bar->removeRole();
            }
        }
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }
    
    // send Mail Bar Association via mail
    public function sendMailBarAssociation($memberEmail, $memberName, $content, $replyto, $barAssociationName, $subject) {
        $this->load->library('Sendinblue');
        /* mail functionality */
        $data['mail_to'] = $memberEmail;
        $data['from_mail'] = FROM_MAIL;
        $data['topMsg'] = 'Dear ' . $memberName;
        $data['bodyMsg'] = '<p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;">'.$content.'</p>';
        $data['thanksMsg'] = 'Thank You,';
        $data['delimeter'] = $barAssociationName;
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'priority' => '1'
        );
        //  API Details       
        $sendMail = new Mailin(EMAIL_BASE_URL, EMAIL_API_KEY);        
        $dataMail = array( 
            "to" => array($data['mail_to'] => $memberName),
			"from" => array($data['from_mail'], $barAssociationName),
			"replyto" => array($replyto, "reply"),
			"subject" => $subject,			
			"html" => $this->load->view('mailTemplates/bar_association/barAssociation', $data, TRUE),			
			"headers" => array("Content-Type"=> "text/html; charset=iso-8859-1","X-param1"=> "value1", "X-param2"=> "value2","X-Mailin-custom"=>"SoOLEGAL", "X-Mailin-IP"=> IP_ADDRESS, "X-Mailin-Tag" => Mailin_TAG)
);
            $sendMail->send_email($dataMail);
            return TRUE;
    }
    // Gurgaon court bar association 68255
    public function sendSMSBarAssociationDBAG($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .' 


via soolegal.com');
       $bindData = "username=" . SMS_USER_NAME . "&password=" . SMS_PWD . "&senderid=" . SMS_DBAG_SENDER_ID . "&number=" . $contactNum ."&route=" . SMS_ROUTE_ID . "&message=" . $smsMSG;
        $this->msgApi->setSmsUrl(SMS_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    } 
    
    // saket court bar association 20721
    public function sendSMSBarAssociationSCBA($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .' 


via soolegal.com');
        $bindData = "username=" . SMS_USER_NAME . "&password=" . SMS_PWD . "&sender=" . SMS_SCBA_SENDER_ID . "&sendto=" . $contactNum . "&message=" . $smsMSG;        
        $this->msgApi->setSmsUrl(SMS_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    }
    // Rohni court bar association 
    public function sendSMSBarAssociationRCBA($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .' 


via soolegal.com');
       $bindData = "username=" . SMS_USER_NAME . "&password=" . SMS_PWD . "&senderid=" . SMS_RCBA_SENDER_ID . "&number=" . $contactNum ."&route=" . SMS_ROUTE_ID . "&message=" . $smsMSG;        
        $this->msgApi->setSmsUrl(SMS_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    }
    
    // drarka court bar association 
    public function sendSMSBarAssociationDCBA($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .' 


via soolegal.com');
       $bindData = "username=" . SMS_USER_NAME . "&password=" . SMS_PWD . "&senderid=" . SMS_DCBA_SENDER_ID . "&number=" . $contactNum ."&route=" . SMS_ROUTE_ID . "&message=" . $smsMSG;   
        $this->msgApi->setSmsUrl(SMS_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    }
    
    // new delhi bar association 
    public function sendSMSBarAssociationNDBA($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .' 


via soolegal.com');
        $bindData = "username=" . SMS_USER_NAME . "&password=" . SMS_PWD . "&senderid=" . SMS_NDBA_SENDER_ID . "&number=" . $contactNum ."&route=" . SMS_ROUTE_ID . "&message=" . $smsMSG;        
        $this->msgApi->setSmsUrl(SMS_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    }
    // for Delhi high court bar association
    public function sendSMSBarAssociationDHCBA($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        //$smsMSG = urlencode($content);
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .'


via soolegal.com');
       $bindData = "username=" . SMS_USER_NAME . "&password=" . SMS_PWD . "&senderid=" . SMS_DHCBA_SENDER_ID . "&number=" . $contactNum ."&route=" . SMS_ROUTE_ID . "&message=" . $smsMSG;        
        $this->msgApi->setSmsUrl(SMS_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    }    
    // common
    public function sendSMSBarAssociation($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .' 


via soolegal.com');
            $bindData = "username=" . SMS_USER_NAME . "&password=" . SMS_PWD . "&senderid=" . SMS_SENDER_ID . "&number=" . $contactNum ."&route=" . SMS_ROUTE_ID . "&message=" . $smsMSG;   
        $this->msgApi->setSmsUrl(SMS_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    }
    
    /*
    // New SMS Panel Here
    // drarka court bar association 
    public function sendSMSBarAssociationDCBA($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .' 


via soolegal.com');
        $bindData = "user=" . SM_USER_NAME . "&pass=" . SM_PWD . "&sender=" . SM_DCBA_SENDER_ID . "&phone=" . $contactNum . "&text=" . $smsMSG. "&priority=" . SM_PRIORITY_NON_DND . "&stype=".SM_TYPE_NORMAL;        
        $this->msgApi->setSmsUrl(SM_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    }
    
    // new delhi bar association 
    public function sendSMSBarAssociationNDBA($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .' 


via soolegal.com');
        $bindData = "user=" . SM_USER_NAME . "&pass=" . SM_PWD . "&sender=" . SM_NDBA_SENDER_ID . "&phone=" . $contactNum . "&text=" . $smsMSG. "&priority=" . SM_PRIORITY_NON_DND . "&stype=".SM_TYPE_NORMAL;         
        $this->msgApi->setSmsUrl(SM_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    }
    // for Delhi high court bar association
    public function sendSMSBarAssociationDHCBA($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        //$smsMSG = urlencode($content);
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .'


via soolegal.com');
        $bindData = "user=" . SM_USER_NAME . "&pass=" . SM_PWD . "&sender=" . SM_DHCBA_SENDER_ID . "&phone=" . $contactNum . "&text=" . $smsMSG. "&priority=" . SM_PRIORITY_NON_DND . "&stype=".SM_TYPE_NORMAL;        
        $this->msgApi->setSmsUrl(SM_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    }    
    // common
    public function sendSMSBarAssociation($contactNum, $smsContent, $smsContentURL, $smsContentDelimiter) {
        
        $smsMSG = '';
        $this->load->model('Smsapi_model', 'msgApi');
        
        $smsMSG = urlencode($smsContent . ' '. $smsContentURL .' 


via soolegal.com');
            $bindData = "user=" . SM_USER_NAME . "&pass=" . SM_PWD . "&sender=" . SM_SENDER_ID . "&phone=" . $contactNum . "&text=" . $smsMSG. "&priority=" . SM_PRIORITY_NON_DND . "&stype=".SM_TYPE_NORMAL;        
        $this->msgApi->setSmsUrl(SM_URL);
        $this->msgApi->setSmsData($bindData);
        // call sms send method 
        $this->msgApi->postSmsData();
        return TRUE;
    }*/
    // view Circular
    public function circularDetails($slug) {
        $this->bar->setSlug($slug);
        $barCircularInfo = $this->bar->getSingleCircularByID();
        $this->bar->setCircularID($barCircularInfo['circular_id']);
        if (!isset($barCircularInfo) || empty($barCircularInfo)) {
            $data['title'] = 'Page not found - SoOLEGAL';
            $this->load->view('errors/html/error_404', $data);
        } else { 
            
            $publishDate = date('Y-m-d h:i:s', $barCircularInfo['modified_date_time']);
            $modifiedDate = date('Y-m-d h:i:s', $barCircularInfo['modified_date_time']);
            
            $data['breadcrumbs'] = array('Circular' => '#', 'detail' => '#');
            $data['title'] = $barCircularInfo['subject'] . ' - SoOLEGAL';
            $data['metaDescription'] = 'Bar Association Circular';
            $data['metaKeywords'] = 'Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing, Bar Association Circular';

           
            $data['metaOGtype'] = 'bar-association-circular';
            $data['metaOGtitle'] = $barCircularInfo['subject'];
            $data['metaOGurl'] = site_url() . 'circular/bar-association/' . $barCircularInfo['slug'] . '/';
            $data['metaOGDescription'] = strip_tags($barCircularInfo['description']);
            $data['metaOGPublishedTime'] = $publishDate;
            $data['metaOGModifiedTime'] = $modifiedDate;
            $data['metaOGsiteName'] = 'SoOLEGAL - Global Intgrated Legal Directory';
            $data['metaOGimage'] = HTTP_IMAGES_PATH . 'img-pdf-doc-thumb.jpg';
            
            $data['metaOGIMGwidth'] = 300;
            $data['metaOGIMGheight'] = 300;
            $data['metatwitterImg'] = HTTP_IMAGES_PATH . 'img-pdf-doc-thumb.jpg';
            $data['metatwitterCard'] = 'summary_large_image';
            
            $data['title'] = "Bar Association Circular: " . $barCircularInfo['subject'] . " - SoOLEGAL";
            $this->bar->setBarAssociationID($barCircularInfo['bar_association_id']);
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();
            //Menu
            if(!empty($barCircularInfo['custom_url'])){
                $username = $barCircularInfo['custom_url'];
            } else {
                $username = $barCircularInfo['username'];
            }
            
            $data['bar_association_url'] = site_url() . 'bar-association/'. $username;
            
            $data['home'] = site_url() . 'bar-association/' . $username;
            $data['committeemember'] = site_url() . 'bar-association/' . $username . '/committee-member';
            $data['circular'] = site_url() . 'bar-association/' . $username . '/circular';
            $data['news'] = site_url() . 'bar-association/' . $username . '/news';
            $data['aboutus'] = site_url() . 'bar-association/' . $username . '/about-us';
            $data['roarlink'] = site_url() . 'bar-association/' . $username . '/roar';
            $data['barMember'] = site_url() . 'bar-association/' . $username . '/members';
            $data['calendar'] = site_url() . 'bar-association/' . $username . '/calendar';
            $data['disclaimer'] = site_url() . 'bar-association/' . $username . '/disclaimer';
            $data['gallery'] = site_url() . 'bar-association/' . $username . '/gallery';
            $data['helpline'] = site_url() . 'bar-association/' . $username . '/helpline';
            $data['pastofficials'] = site_url() . 'bar-association/' . $username . '/past-officials';
            $data['contactus'] = site_url() . 'bar-association/' . $username . '/contact-us';
            // display bar association circular
            $this->bar->setCircularID($barCircularInfo['circular_id']);
            $count_attachment = $this->bar->checkBarCircularAttachmentCount();
            $list_attachment = $this->bar->getBarCircularAttachment();                       
            $data['barCircularDetails'] = array(
                'circular_id' => $barCircularInfo['circular_id'],
                'slug' => $barCircularInfo['slug'],
                'subject' => $barCircularInfo['subject'],
                'description' => $barCircularInfo['description'],
                'created_date_time' => $barCircularInfo['created_date_time'],
                'modified_date_time' => $barCircularInfo['modified_date_time'],
                'bar_association_id' => $barCircularInfo['bar_association_id'],
                'status' => $barCircularInfo['status'],
                'custom_url' => $barCircularInfo['custom_url'],
                'username' => $barCircularInfo['username'],
                'first_name' => $barCircularInfo['first_name'],
                'url' => $barCircularInfo['url'],
                'list_attachment' => $list_attachment,
                'count_attachment' =>$count_attachment, 
            );            
            $barAssociationCircular = $this->bar->getBarAssociationCircular();            
            foreach($barAssociationCircular as $element) {
                $this->bar->setCircularID($element['circular_id']);
                $count_attachment = $this->bar->checkBarCircularAttachmentCount();
                $data['barAssociationCircular'][] = array(
                    'circular_id' => $element['circular_id'],
                    'slug' => $element['slug'],
                    'subject' => $element['subject'],
                    'description' => $element['description'],
                    'created_date_time' => $element['created_date_time'],
                    'modified_date_time' => $element['modified_date_time'],
                    'bar_association_id' => $element['bar_association_id'],
                    'status' => $element['status'],
                    'count_attachment' => $count_attachment,
                );
            }            
            $data['barAssociationNews'] = $this->bar->getBarAssociationNews();
            $data['disclaimerInfo'] = $this->bar->getbarAssociationDisclaimer();
            $this->load->view('barassociation/front/circularDetails', $data);
        }
    }
    // view News
    public function newsDetails($slug) {
        $this->bar->setSlug($slug);
        $barNewsInfo = $this->bar->getSingleNewsByID();
        $this->bar->setNewsID($barNewsInfo['news_id']);
        if (!isset($barNewsInfo) || empty($barNewsInfo)) {
            $data['title'] = 'Page not found - SoOLEGAL';
            $this->load->view('errors/html/error_404', $data);
        } else {
            /*if ($barNewsInfo['bar_association_id'] != $this->session->userdata('member_id') || $this->session->userdata('is_authenticate_member') == FALSE) {
                $this->load->library('user_agent');
                if ($this->agent->is_browser()) {
                    $agent = $this->agent->browser() . ',' . $this->agent->version();
                } elseif ($this->agent->is_mobile()) {
                    $agent = $this->agent->mobile();
                } else {
                    $agent = 'Unidentified User Agent';
                }
                $ip_address = $this->input->ip_address();
                $geo_location = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip_address));
                $city = $geo_location['geoplugin_city'];
                $country = $geo_location['geoplugin_countryName'];
                $location = '';
                if (!empty($city) && !empty($country)) {
                    $location = $city . '|' . $country;
                }
                $this->bar->setLocation($location);
                $this->bar->setVisitorIP($ip_address);
                $this->bar->setDeviceOS($this->agent->platform());
                $this->bar->setDeviceType($agent);
                $this->bar->setTimestamp(time());                
                $this->bar->insertBarNewsViews();
            }*/
            $publishDate = date('Y-m-d h:i:s', $barNewsInfo['modified_date_time']);
            $modifiedDate = date('Y-m-d h:i:s', $barNewsInfo['modified_date_time']);
            $data['breadcrumbs'] = array('News' => '#', 'detail' => '#');
            $data['title'] = $barNewsInfo['head_line'] . ' - SoOLEGAL';
            $data['metaDescription'] = 'Bar Association News';
            $data['metaKeywords'] = 'Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing, Bar Association News';           
            $data['metaOGtype'] = 'bar-association-news';
            $data['metaOGtitle'] = $barNewsInfo['head_line'];
            $data['metaOGurl'] = site_url() . 'news/bar-association/' . $barNewsInfo['slug'] . '/';
            $data['metaOGDescription'] = strip_tags($barNewsInfo['description']);
            $data['metaOGPublishedTime'] = $publishDate;
            $data['metaOGModifiedTime'] = $modifiedDate;
            $data['metaOGsiteName'] = 'SoOLEGAL - Global Intgrated Legal Directory';
            $data['metaOGimage'] = site_url() . 'assets/uploads/barassociation/news/' . $barNewsInfo['image_url'];
            $data['metaOGIMGwidth'] = 300;
            $data['metaOGIMGheight'] = 300;
            $data['metatwitterImg'] = site_url() . 'assets/uploads/barassociation/news/' . $barNewsInfo['image_url'];
            $data['metatwitterCard'] = 'summary_large_image';
            
            $data['title'] = "Bar Association News: " . $barNewsInfo['head_line'] . " - SoOLEGAL";
            $this->bar->setBarAssociationID($barNewsInfo['bar_association_id']);
            $this->bar->setStatus(1);
            $data['member'] = $this->bar->getSingleMemberByID();
            //Menu
            if(!empty($barNewsInfo['custom_url'])){
                $username = $barNewsInfo['custom_url'];
            } else {
                $username = $barNewsInfo['username'];
            }
            
            $data['bar_association_url'] = site_url() . 'bar-association/'. $username;
            
            $data['home'] = site_url() . 'bar-association/' . $username;
            $data['committeemember'] = site_url() . 'bar-association/' . $username . '/committee-member';
            $data['circular'] = site_url() . 'bar-association/' . $username . '/circular';
            $data['news'] = site_url() . 'bar-association/' . $username . '/news';
            $data['aboutus'] = site_url() . 'bar-association/' . $username . '/about-us';
            $data['roarlink'] = site_url() . 'bar-association/' . $username . '/roar';
            $data['barMember'] = site_url() . 'bar-association/' . $username . '/members';
            $data['calendar'] = site_url() . 'bar-association/' . $username . '/calendar';
            $data['disclaimer'] = site_url() . 'bar-association/' . $username . '/disclaimer';
            $data['gallery'] = site_url() . 'bar-association/' . $username . '/gallery';
            $data['helpline'] = site_url() . 'bar-association/' . $username . '/helpline';
            $data['pastofficials'] = site_url() . 'bar-association/' . $username . '/past-officials';
            $data['contactus'] = site_url() . 'bar-association/' . $username . '/contact-us';
            $data['barNewsDetails'] = $barNewsInfo;
            $data['comments'] = $this->bar->getSingleBarNewsComments();            
            $barAssociationCircular = $this->bar->getBarAssociationCircular();
            foreach($barAssociationCircular as $element) {
                $this->bar->setCircularID($element['circular_id']);
                $count_attachment = $this->bar->checkBarCircularAttachmentCount();
                $data['barAssociationCircular'][] = array(
                    'circular_id' => $element['circular_id'],
                    'slug' => $element['slug'],
                    'subject' => $element['subject'],
                    'description' => $element['description'],
                    'created_date_time' => $element['created_date_time'],
                    'modified_date_time' => $element['modified_date_time'],
                    'bar_association_id' => $element['bar_association_id'],
                    'status' => $element['status'],
                    'count_attachment' => $count_attachment,
                );
            }
            $data['barAssociationNews'] = $this->bar->getBarAssociationNews();
            $data['disclaimerInfo'] = $this->bar->getbarAssociationDisclaimer();
            $this->load->view('barassociation/front/newsDetails', $data);
        }
    }
    // save Comment on Bar Association News
    public function saveComments() {
        if ($this->session->userdata('is_authenticate_member') == FALSE) {
            redirect('bar-association/login'); // the user is not logged in, redirect them!
        } else {
            $this->bar->setMemberID($this->session->userdata('member_id'));
            $this->bar->setComment(trim($this->input->post('comment')));
            $this->bar->settimestamp(time());
            $this->bar->setstatus(1);
            $this->bar->setNewsID($this->input->post('news_id'));
            $comment_id = $this->bar->createComment();
            $this->bar->setCommentID($comment_id);
            $json['commentDetails'] = $this->bar->getRenderCommentOnBarAssociationNews();
            if ($this->session->userdata('member_id') != $this->input->post('member_id')) {
                $this->load->model('Notification_model', 'notification');
                $this->notification->setNotificationTypeID($this->input->post('news_id') . '|' . $comment_id);
                $this->notification->setReceiverID($this->input->post('member_id'));
                $this->notification->setSenderID($this->session->userdata('member_id'));
                $this->notification->setNotificationType(8);
                $this->notification->setNotification(26);
                $this->notification->setTimeStamp(time());
                $this->notification->setSenderType(1);
                $this->notification->setStatus(0);
                $this->notification->sendNotification();
            }
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('barassociation/front/comment', $json);
        }
    }
    // check existing email address
    public function checkemailDashboard() {    
        $json = array();
        $email = $this->input->post('email');
        
        if($this->session->userdata('email') != $email) {
            $json['difmail'] = 'difmail';
        }       
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->member->setemail($email);
            if(!empty($this->session->userdata('member_id'))) { 
                if(!empty($this->session->userdata('lawyer_id') && $this->session->userdata('lawyer_id') !='blank_id')) {
                    $this->member->setmemberID($this->session->userdata('lawyer_id'));
                    $json['contact_email'] = $this->member->updateCheckEmail();
                } elseif(!empty($this->session->userdata('lawyer_id') && $this->session->userdata('lawyer_id') =='blank_id')) {
                    $json['contact_email'] = $this->member->checkemail();
                } else { 
                    $this->member->setmemberID($this->session->userdata('member_id'));
                    $json['contact_email'] = $this->member->updateCheckEmail();
                }
            } else {
                $json['contact_email'] = $this->member->checkemail();
            }
            $this->output->set_header('Content-Type: application/json');
            echo json_encode($json);
        } else {
            $json['contact_email'] = 'blank';
            $this->output->set_header('Content-Type: application/json');
            echo json_encode($json);
        }         
    }
    // check existing mobile number
    public function checkContactNumDashboard() {
        $json = array();
        $contactNo = $this->input->post('contactNo');        
        if (preg_match('/^\d{10}$/', $contactNo)) {
            $this->member->setcontactNum($contactNo);
            if(!empty($this->session->userdata('member_id'))) {
                if(!empty($this->session->userdata('lawyer_id') && $this->session->userdata('lawyer_id') !='blank_id')) {
                    $this->member->setmemberID($this->session->userdata('lawyer_id'));
                    $json['contact_count'] = $this->member->updateCheckContactNo();
                } elseif(!empty($this->session->userdata('lawyer_id') && $this->session->userdata('lawyer_id') =='blank_id')) {
                    $json['contact_count'] = $this->member->updateCheckContactNo();
                } else {
                    $this->member->setmemberID($this->session->userdata('member_id'));
                    $json['contact_count'] = $this->member->updateCheckContactNo();
                }
            } else {
                $json['contact_count'] = $this->member->checkContactNo();
            }
            $this->output->set_header('Content-Type: application/json');
            echo json_encode($json);
        } else {
            $json['contact_count'] = 'blank';
            $this->output->set_header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
    // generate random password
    public function generate_random_password($length = 10) {
        $alphabets = range('a', 'z');
        $numbers = range('0', '9');
        $final_array = array_merge($alphabets, $numbers);

        $password = '';

        while ($length--) {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }

        return $password;
    }
    
    public function autocompleteCommittee() {
		$json = array();
		if(!empty($this->input->get("q"))){
		    $this->bar->setBarAssociationID($this->session->userdata('member_id'));
			$this->bar->setBarAssociationName($this->input->get("q"));
			$committeeMember = $this->bar->autocompleteAllMember();
			foreach($committeeMember as $element) {
			    $json[] = array(
			        'id' => $element['member_id'],
			        'text' => $element['fullname']
			    );
			}			
		}		
		echo json_encode($json);
	}
	// action Save Member
    public function actionSaveMember() {
        $json = array();
        if ($this->session->userdata('is_authenticate_member') == FALSE) {
            $json['msg'] = 'failed'; // the bar association is not logged in, redirect them!
        } else {
            $this->load->model('Profile_model', 'profile');
            $this->bar->setBarAssociationID($this->session->userdata('member_id'));         
            $this->bar->setStatus(1);
            $barInformation = $this->bar->getSingleMemberByID();
            
            $verificationCode = uniqid();
            $rLink = site_url() . 'login';
            
            $pass = $this->generate_random_password(6);
            $encriptPass = md5(SALT . $pass);
            $this->bar->setPassword($encriptPass);
            // post variable        
            // personal info
            $associate_member_id = $this->input->post('associate_member_id');
            $member_bar_assoc_id = $this->input->post('member_bar_assoc_id');
            $profile_avatar_url = $this->input->post('profile_avatar_url');
            $firstName = $this->input->post('firstName');
            $lastName = $this->input->post('lastName');
            $email = $this->input->post('email');
            if(!empty($email)){
                $email = $email;
            } else {
                $email = NULL;
            }
            $phone_code = $this->input->post('phone_code');
            $contactNum = $this->input->post('contactNum');
            // enroll and bar num
            $barAsoociationNum = $this->input->post('barAsoociationNum');
            $enrolment_No_Council = $this->input->post('Enrolment_No_of_Bar_Council');
            
            // office address            
            $office_address_id = $this->input->post('office_address_id');
            $office_address = $this->input->post('office_address');
            $office_country = $this->input->post('office_country');
            $office_state = $this->input->post('office_state');
            $office_city = $this->input->post('office_city');
            $office_zip = $this->input->post('office_zip');
            
            // chamber address
            $chamber_address_id = $this->input->post('chamber_address_id');
            $chamber_address = $this->input->post('chamber_address');
            $chamber_country = $this->input->post('chamber_country');
            $chamber_state = $this->input->post('chamber_state');
            $chamber_city = $this->input->post('chamber_city');
            $chamber_zip = $this->input->post('chamber_zip');
            
            // residence address
            $residence_address_id = $this->input->post('residence_address_id');
            $residence_address = $this->input->post('residence_address');
            $residence_country = $this->input->post('residence_country');
            $residence_state = $this->input->post('residence_state');
            $residence_city = $this->input->post('residence_city');
            $residence_zip = $this->input->post('residence_zip');
            
            // setter function
            $this->bar->setmemberID($associate_member_id);
            $this->bar->setBarAssociationName($firstName);
            $this->bar->setLastName($lastName);
            $this->bar->setBarAssociationEmail($email);
            $this->bar->setPhoneCountryCode($phone_code);
            $this->bar->setBarAssociationContactNum($contactNum);
            $this->bar->setMemberType(0);
            $this->bar->setTimestamp(TIMESTAMP_FORMAT);
                
            
            if(!empty($associate_member_id)) {
                $this->profile->setMemberID($associate_member_id);                
                $return = $this->bar->updateRegistration();
                
                if($return === FALSE) {
                    $json['msg'] = 'failed';
                } else {                    
                    // update Enroll no and bar association no
                    if(!empty($barAsoociationNum) || !empty($this->session->userdata('member_id')) ) {
                    //if(!empty($barAsoociationNum)) {
                        $this->member->setmemberID($associate_member_id);
                        $this->member->setBarAssociationID($member_bar_assoc_id);
                        $this->member->setBarAssociationNum($barAsoociationNum);
                        $this->member->setBarAssociationName($this->session->userdata('member_id'));
                        $this->member->settimestamp(TIMESTAMP_FORMAT);
                        $this->member->setstatus(4);
                        $this->member->createUpdateBarAssociationNum();
                    }
                    if(!empty($enrolment_No_Council)) {
                        $this->profile->setBarCouncilRegNo($enrolment_No_Council);
                        $this->profile->setMemberID($associate_member_id);
                        $this->profile->setStatus(4);
                        $this->profile->createUpdateBarCouncilRegistration();
                    }
                    // update office address
                    if(!empty($office_address) && !empty($office_address_id)){
                        $this->profile->setAddressID($office_address_id);
                        $this->profile->setAddress($office_address);
                        $this->profile->setCity($office_city);
                        $this->profile->setState($office_state);
                        $this->profile->setCountry($office_country);
                        $this->profile->setPinCode($office_zip);
                        $this->profile->setFlag(1);
                        $this->profile->setPrimaryAddress(1);
                        $this->profile->updateLawyerAddress();
                    } 
                    // insert new office address
                    else {
                        $this->profile->setAddress($office_address);
                        $this->profile->setCity($office_city);
                        $this->profile->setState($office_state);
                        $this->profile->setCountry($office_country);
                        $this->profile->setPinCode($office_zip);
                        $this->profile->setStatus(4);
                        $this->profile->setFlag(1);
                        $this->profile->setPrimaryAddress(1);
                        $lastInsertedID = $this->profile->insertLawyerAddress();
                    }
                    // update chamber address
                    if(!empty($chamber_address) && !empty($chamber_address_id)){
                        $this->profile->setAddressID($chamber_address_id);
                        $this->profile->setAddress($chamber_address);
                        $this->profile->setCity($chamber_city);
                        $this->profile->setState($chamber_state);
                        $this->profile->setCountry($chamber_country);
                        $this->profile->setPinCode($chamber_zip);
                        $this->profile->setFlag(2);
                        $this->profile->setPrimaryAddress(0);
                        $this->profile->updateLawyerAddress();
                    } 
                    // insert new chamber address    
                    else {
                        $this->profile->setAddress($chamber_address);
                        $this->profile->setCity($chamber_city);
                        $this->profile->setState($chamber_state);
                        $this->profile->setCountry($chamber_country);
                        $this->profile->setPinCode($chamber_zip);
                        $this->profile->setStatus(4);
                        $this->profile->setFlag(2);
                        $this->profile->setPrimaryAddress(0);
                        $lastInsertedID = $this->profile->insertLawyerAddress();
                    }
                    // update residence address
                    if(!empty($residence_address) && !empty($residence_address_id)){
                        $this->profile->setAddressID($residence_address_id);
                        $this->profile->setAddress($residence_address);
                        $this->profile->setCity($residence_city);
                        $this->profile->setState($residence_state);
                        $this->profile->setCountry($residence_country);
                        $this->profile->setPinCode($residence_zip);
                        $this->profile->setFlag(3);
                        $this->profile->setPrimaryAddress(0);
                        $this->profile->updateLawyerAddress();
                    } 
                    // insert new residence address
                    else {
                        $this->profile->setAddress($residence_address);
                        $this->profile->setCity($residence_city);
                        $this->profile->setState($residence_state);
                        $this->profile->setCountry($residence_country);
                        $this->profile->setPinCode($residence_zip);
                        $this->profile->setStatus(4);
                        $this->profile->setFlag(3);
                        $this->profile->setPrimaryAddress(0);
                        $lastInsertedID = $this->profile->insertLawyerAddress();
                    }
                    
                    $sms = $barInformation['first_name'].' has made below change in your account: email and mobile on soolegal.com';
                    $message = '<p>'.$barInformation['first_name'].' has made below change in your account: email and mobile.</p>';
                    $this->sendMemberVerification($email, $message, $firstName, $rLink);
                    $this->sendSMSVerification($sms, $contactNum, $pass); 
                                        
                    $json['msg'] = 'success';
                }
            } else {
                $userName = $this->member->createUniqueUsername('member',trim($firstName), 'username');
                $this->bar->setUserName($userName);
                $this->bar->setVerificationCode(1);
                $return = $this->bar->createRegistration();
                $this->profile->setMemberID($return);
                $this->profile->setStatus(4);
                if(!empty($profile_avatar_url)){
                    $this->bar->setmemberID($return);
                    $this->bar->setImageUrl($profile_avatar_url);
                    $this->bar->createProfileAvatar();
                }
                if($return === FALSE) {
                    $json['msg'] = 'failed';
                } else {                
                    // create Enroll no and bar association no
                    if(!empty($barAsoociationNum) || !empty($this->session->userdata('member_id')) ) {
                    //if(!empty($barAsoociationNum)) {
                        $this->member->setmemberID($return);
                        $this->member->setBarAssociationNum($barAsoociationNum);
                        $this->member->setBarAssociationName($this->session->userdata('member_id'));
                        $this->member->settimestamp(TIMESTAMP_FORMAT);
                        $this->member->setstatus(4);
                        $this->member->createBarAssociationID();
                    }
                    if(!empty($enrolment_No_Council)) {
                        $this->profile->setBarCouncilRegNo($enrolment_No_Council);
                        $this->profile->setMemberID($return);
                        $this->profile->setStatus(4);
                        $this->profile->insertLawyerBarCouncilRegistrationNum();
                    }
                    
                    // create office address
                    if(!empty($office_address)){
                        $this->profile->setAddress($office_address);
                        $this->profile->setCity($office_city);
                        $this->profile->setState($office_state);
                        $this->profile->setCountry($office_country);
                        $this->profile->setPinCode($office_zip);
                        $this->profile->setFlag(1);
                        $this->profile->setPrimaryAddress(1);
                        $lastInsertedID = $this->profile->insertLawyerAddress();
                    }
                    // create chamber address
                    if(!empty($chamber_address)){
                        $this->profile->setAddress($chamber_address);
                        $this->profile->setCity($chamber_city);
                        $this->profile->setState($chamber_state);
                        $this->profile->setCountry($chamber_country);
                        $this->profile->setPinCode($chamber_zip);
                        $this->profile->setFlag(2);
                        $this->profile->setPrimaryAddress(0);
                        $lastInsertedID = $this->profile->insertLawyerAddress();
                    }
                    // create residence address
                    if(!empty($residence_address)){
                        $this->profile->setAddress($residence_address);
                        $this->profile->setCity($residence_city);
                        $this->profile->setState($residence_state);
                        $this->profile->setCountry($residence_country);
                        $this->profile->setPinCode($residence_zip);
                        $this->profile->setFlag(3);
                        $this->profile->setPrimaryAddress(0);
                        $lastInsertedID = $this->profile->insertLawyerAddress();
                    }                    
                    $sms = 'Congratulation! you have been added by '.$barInformation['first_name'].' on soolegal.com';
                    $message = '<p>Congratulation! you have been added by '.$barInformation['first_name'].' </p><p>Username:'.$email.'</p><p>Password:'.$pass.'</p> ';                                    
                    $this->sendMemberVerification($email, $message, $firstName, $rLink);
                    $this->sendSMSVerification($sms, $contactNum, $pass);
                    $json['msg'] = 'success';
                }
            }
            
        }
        $this->output->set_header('Content-Type: application/json');
        echo json_encode($json);
    }
    // send SMS Verification
    public function sendSMSVerification($sms, $contactnum, $password){
        if (preg_match('/^\d{10}$/', $contactnum)) {
            $smsMSG = '';
            $this->load->model('Smsapi_model', 'msgApi');
            $link = site_url() . 'member/login';
            $smsMSG .= urlencode($sms.' login with your mobile no. & password: ' . $password . '

SoOLEGAL.com');
           $bindData = "username=" . SMS_USER_NAME . "&password=" . SMS_PWD . "&senderid=" . SMS_SENDER_ID . "&number=" . $contactnum ."&route=" . SMS_ROUTE_ID . "&message=" . $smsMSG;
            $this->msgApi->setSmsUrl(SMS_URL);
            $this->msgApi->setSmsData($bindData);
            // call sms send method
            $this->msgApi->postSmsData();
        }
    }
    
    // send Member Verification via mail
    public function sendMemberVerification($email, $content, $firstName, $rLink) {
        /* mail functionality */
        $data['mail_to'] = $email;
        $data['from_mail'] = FROM_MAIL;
        $data['topMsg'] = 'Dear ' . $firstName;
        $data['bodyMsg'] = $content.'<p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;"><strong>We welcome you to SoOLEGAL family!</strong> It’s a great platform for lawyer and clients to find each other and stay connected.</p><p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;">You are receiving this email because you recently signed up to our SoOLEGAL services. To activate your account you can click on the button given below.</p><table border="0" cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;"><tr><td valign="top" align="center"><p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;"><a style="display:inline-block;color:white;background:#03618c;border:solid #03618c;border-width:10px 20px 10px 20px;font-weight:bold;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;text-decoration:none;" href="' . $rLink . '">Login</a></p></td></tr></table>';
        $data['thanksMsg'] = 'Thank You,';
        $data['delimeter'] = 'SoOLEGAL Team';
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'priority' => '1'
        );
        //         
        $sendMail = new Mailin(EMAIL_BASE_URL, EMAIL_API_KEY);
        $dataMail = array(
            "to" => array($data['mail_to'] => $firstName),
            "from" => array($data['from_mail'], "from SoOLEGAL"),
            "replyto" => array(NOREPLY_MAIL, "no-reply"),
            "subject" => "SoOLEGAL - Verification",
            "html" => $this->load->view('mailTemplates/memberRegisterVerification', $data, TRUE),
            "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "SoOLEGAL", "X-Mailin-IP" => IP_ADDRESS, "X-Mailin-Tag" => Mailin_TAG)
        );
        $sendMail->send_email($dataMail);
    }	
    
    
    
    
     public function sendnotification() {
         
        $json = array();
       
        $content = $this->input->post('notificationcontent');
        $this->bar->setBarAssociationID($this->session->userdata('member_id'));
        $this->bar->setStatus(1);
        $this->bar->setStatus(1);
        $barInformation = $this->bar->getSingleMemberByID();        
        if(!empty($content)) {
            $this->bar->setNewsDescription($content);
              $this->bar->setTimeStamp(time());
            $this->bar->setTimestampfornotification(date('Y-m-d h:i:s'));
  

            $getnotifyID = $this->bar->createNotifyMobileBarAssociationMember();
            
        }
        
        $this->bar->setDeviceTypeName(0);
        $notifyMobileMember = $this->bar->notifyMobileBarAssociationMember();
        $total=count($notifyMobileMember);
        

        // Appointment Notif Android
        if(!empty($notifyMobileMember) && count($notifyMobileMember)>0) {
            foreach($notifyMobileMember as $key=>$element) {
                $contentwithout = $this->cleanHTMLTags($content);
                $arrapVal = array(
                    'id' => $getnotifyID,
                    'notif_url' => site_url().'notification/bar-association/'.$getnotifyID,
                    'member_id' => $element['member_id'],
                    'device_member_id' => $element['device_member_id'],
                    'username' => $element['username'],
                    'first_name' => $element['first_name'],
                    'bar_association_name' => $barInformation['first_name'],
                    'content' => $content,
                    'date_time' => TIMESTAMP_FORMAT,
                    "title" => $barInformation['first_name'],
                    "text" =>  character_limiter($contentwithout,40,'..'),
                    "icon" => 'app_icon',
                    "type"=>"Bar Association Notification",
                    "priority"=>"HIGH",
                ); 
                $ap_fields = array(
                    'registration_ids' => array($element['app_device_id']),
                    "data"=>$arrapVal,
                );            
                $data = json_encode($ap_fields);
                $this->pushNotification($ap_fields);            
             //    $this->bar->setmemberID($element['member_id']);
             //   $this->bar->setNotiftype('Notification From barassciation');
            //     $this->bar->setNewsDescription($data);
            //    $this->bar->setHeadLine('Notification from bar association');
            //    $abc = $this->bar->createNotificationLog();
             //   if(!empty($abc)){
            //    $json['success'] = 'success';
            //    }
            
            }
        }
        $this->bar->setDeviceTypeName(1);
        $notifyMobileMemberIOS = $this->bar->notifyMobileBarAssociationMember();
        $total=count($notifyMobileMember);
        
        // Appointment Notif IOS
        
        if(!empty($notifyMobileMemberIOS) && count($notifyMobileMemberIOS)>0) {
            foreach($notifyMobileMemberIOS as $key=>$element) {
                $contentwithout = $this->cleanHTMLTags($content);
                $arrapValIOS = array(
                    'id' => $getnotifyID,
                    'notif_url' => site_url().'notification/bar-association/'.$getnotifyID,
                    'member_id' => $element['member_id'],
                    'device_member_id' => $element['device_member_id'],
                    'username' => $element['username'],
                    'first_name' => $element['first_name'],
                    'bar_association_name' => $barInformation['first_name'],
                    'content' => $content,
                    'date_time' => TIMESTAMP_FORMAT,
                    "title" => $barInformation['first_name'],
                    "text" =>  character_limiter($contentwithout,40,'..'),
                    "icon" => 'app_icon',
                    "type"=>"Bar Association Notification",
                    "priority"=>"HIGH",
                ); 
                
                $msg_payload = array (
    		        'mtitle' => $barInformation['first_name'],
    		        'mdesc' => character_limiter($contentwithout,40,'..'),
    	        );
                
                if (!empty($element['app_device_id'])) {
        		    $this->iOS($msg_payload, $element['app_device_id']);
        		}
            }
        }
        
        
        
         $this->session->set_flashdata('success_barnotification', '<div class="alert alert-success">Notification Send Successfully.<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> </div>');
                redirect('barassociation/viewbarnotification');
        //$this->bar->setBarAssociationID($this->session->userdata('member_id'));
        //  $this->bar->setStatus(1);
        // $data['notificationInfo'] = $this->bar->getnotificationInformation();
        //$this->load->view('barassociation/viewbarnotification/mail/view_notification', $data);
 
    }
    
    // Sends Push notification for iOS users
    public function iOS($data, $devicetoken) {
		$deviceToken = $devicetoken;
		$ctx = stream_context_create();
		// ck.pem is your certificate file
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'slegal.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', 'SOOLGL@123#kINDRA@#2');
		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		// Create the payload body
		$body['aps'] = array(
			'alert' => array(
			    'title' => $data['mtitle'],
                'body' => $data['mdesc'],
			 ),
			'sound' => 'default'
		);
		// Encode the payload as JSON
		$payload = json_encode($body);
		
		// Build the binary notification
	    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		// Close the connection to the server
		fclose($fp);
		if (!$result)
			return 'Message not delivered' . PHP_EOL;
		else
			return 'Message successfully delivered' . PHP_EOL;
	}
    
    // cleanHTMLTags
    public function cleanHTMLTags($input) {
        $search = array(
            '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );
        $output = preg_replace($search, '', $input);
        return $output;
    }
    
     // FCM Push Notification
    public function pushNotification($fields) {
      
        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        //building headers for the request
        $headers = array(
            "Authorization: key=" . FIREBASE_API_KEY,
            "Content-Type: application/json"
        );

        //Initializing curl to open a connection
        $ch = curl_init();
 
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);

        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        //finally executing the curl request 
        $result = curl_exec($ch);
        //print_r($result);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        //Now close the connection
        curl_close($ch);
 
        //and return the result 
        return $result;
    }
    

    public function notifyMobileBarDetails($id) {
        $response['metaDescription'] = 'Bar Association Notification';
        $response['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
        $response['title'] = "Bar Association Notification | SoOLEGAL";
        $response['breadcrumbs'] = array('Bar Association Notification' => '#', 'List' => '#');  
        $this->bar->setNotifyID($id);
        $notifinfo = $this->bar->notifyMobileBbarAssociationDetails();
        $this->bar->setBarAssociationID($notifinfo['member_id']);
        $this->bar->setStatus(1);
        $response['member'] = $this->bar->getSingleMemberByID();
        $response['disclaimerInfo'] = $this->bar->getbarAssociationDisclaimer();
        
        //Menu
        if(!empty($notifinfo['custom_url'])){
            $username = $notifinfo['custom_url'];
        } else {
            $username = $notifinfo['username'];
        }
        
        $response['home'] = site_url() . 'bar-association/' . $username;
        $response['committeemember'] = site_url() . 'bar-association/' . $username . '/committee-member';
        $response['circular'] = site_url() . 'bar-association/' . $username . '/circular';
        $response['news'] = site_url() . 'bar-association/' . $username . '/news';

        $response['aboutus'] = site_url() . 'bar-association/' . $username . '/about-us';
        $response['roarlink'] = site_url() . 'bar-association/' . $username . '/roar';
        $response['barMember'] = site_url() . 'bar-association/' . $username . '/members';
        $response['calendar'] = site_url() . 'bar-association/' . $username . '/calendar';
        $response['disclaimer'] = site_url() . 'bar-association/' . $username . '/disclaimer';
        $response['gallery'] = site_url() . 'bar-association/' . $username . '/gallery';
        $response['helpline'] = site_url() . 'bar-association/' . $username . '/helpline';
        $response['pastofficials'] = site_url() . 'bar-association/' . $username . '/past-officials';
        $response['contactus'] = site_url() . 'bar-association/' . $username . '/contact-us';
        $response['bar_asso_name'] = $username;
        $response['bar_association_url'] = site_url() . 'bar-association/'. $username;
        $response['notifDetails'] = $notifinfo;
       
        $this->load->view('barassociation/front/notif', $response);
        
        
    }
    
    
    
    
    
    
    // update and Sync member profile picture
    public function Sync() {       
        $this->load->model('Members_model', 'members');
        $member_id = $this->input->post('member_id');
        $move_upload_path = $this->input->post('move_upload_path');
        $file_extension = $this->input->post('file_extension');
        if(!empty($member_id)) {
            foreach($member_id as $element) {            
                $this->bar->setBarAssociationID($this->session->userdata('member_id'));
                $this->bar->setmemberID($element); 
                $memberInfo = $this->bar->updateMemberPicture();
                if(!empty($memberInfo['bar_association_num']) && !empty($file_extension)) {
                    // update members profile picture
                    $sourcePath = $move_upload_path.'/'.strtoupper($memberInfo['bar_association_num'].'.'.$file_extension);
                    $destination = ROOT_UPLOAD_PATH."_thumb/".$memberInfo['bar_association_num'].'.'.$file_extension;  
                    $fileName = $memberInfo['bar_association_num'].'.'.$file_extension;                  
                    
                    if(file_exists($sourcePath)) {
                        $moved =  copy($sourcePath, $destination);                 
                        if(!empty($moved) && $moved==1) {           
                            $this->members->setMemberID($memberInfo['member_id']);
                            $this->members->seturl($fileName); 
                            $this->members->setMemberProfilePicture();
                        }
                    }
                    
                }
            }
            redirect('barassociation/dashboard/members');
        }
        redirect('barassociation/dashboard/upload');
        
    }
    
    
    
   public function sendbarnotification() {       
       $data['metaDescription'] = 'Bar Association Notification';
       $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
       $data['title'] = "Bar Association Notification | SoOLEGAL";
       $data['breadcrumbs'] = array('Bar Association Notification' => '#', 'List' => '#');  
       
     $this->bar->setBarAssociationID($this->session->userdata('member_id'));
     $this->bar->setStatus(1);
     $data['notificationInfo'] = $this->bar->getnotificationInformation();
     $this->load->view('barassociation/controlpanel/mail/send_notification',$data);
        
    }  
    
    
    
     public function viewbarnotification() {       
    $data['metaDescription'] = 'Bar Association Notification';
    $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
    $data['title'] = "Bar Association Notification | SoOLEGAL";
    $data['breadcrumbs'] = array('Bar Association Notification' => '#', 'List' => '#');  
       
     $this->bar->setBarAssociationID($this->session->userdata('member_id'));
     $this->bar->setStatus(1);
     $data['notificationInfo'] = $this->bar->getnotificationInformation();
     $this->load->view('barassociation/controlpanel/mail/view_notification', $data);
        
    }
    
    //created by raunak
    public function servicesbarassociation() {   
    $data['metaDescription'] = 'Service For Barassociation';
    $data['metaKeywords'] = 'Member, Law Firm, High Court, Supreme Court, Case, Lawyer, Hearing';
    $data['title'] = "Service For Barassociation | SoOLEGAL";
    $data['breadcrumbs'] = array('Service For Barassociation' => '#', 'List' => '#');  
    $this->load->view('barassociation/servicesbarassociation',$data);
        
    }
    
 
    
    
    
    
    
    
    
    
    
}