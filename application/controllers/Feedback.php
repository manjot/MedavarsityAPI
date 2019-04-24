<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home Controller FrontEnd
 *
 * @author Jaeeme
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedback extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Feedback_model', 'feedback');
        $this->load->library('Sendinblue');
        $this->load->library('session');
    }

    // load feedbak form 
    public function index() {
        $response['title'] = 'Feedback | SoOLEGAL';
        $response['metaDescription'] = 'Feedback | SoOLEGAL';
        $response['metaKeywords'] = '';
        $this->load->view('feedback/feedback', $response);
    }

    // feed back action
    public function sendFeedback() {
        $fbfullName = $this->input->post('fbfullName');
        $fbsubject = $this->input->post('fbsubject');
        $fbemail = $this->input->post('fbemail');
        $fbcomment = $this->input->post('fbcomment');

        if (!empty($fbfullName)) {
            $this->load->library('email');
            $this->feedback->setFullName($fbfullName);
            $this->feedback->setSubject($fbsubject);
            $this->feedback->setEmail($fbemail);
            $this->feedback->setComment($fbcomment);
            $this->feedback->setStatus(1);
            $this->feedback->setTimeStamp(time());
            //call feedback method
            $this->feedback->createFeedback();
            //mail send feedback functionality
            $sendMsg = '';
            $data['mail_to'] = FROM_MAIL;
            $data['from_mail'] = $fbemail;
            $data['topMsg'] = 'SoOLEGAL Team,';
            $data['bodyMsg'] = $fbcomment;
            $data['thanksMsg'] = 'With Best Regards,';
            $data['delimeter'] = $fbfullName;
            // send Mail Functionality
            $sendMail = new Mailin(EMAIL_BASE_URL, EMAIL_API_KEY);
            $dataMail = array(
                "to" => array($data['mail_to'] => 'SoOLEGAL'),
                "from" => array($data['from_mail'], FROM_TEXT),
                "replyto" => array(NOREPLY_MAIL, "no-reply"),
                "subject" => "SoOLEGAL - Feedback, " . $fbsubject,
                "html" => $this->load->view('mailTemplates/feedbackTemplate', $data, TRUE),
                "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "SoOLEGAL", "X-Mailin-IP" => IP_ADDRESS, "X-Mailin-Tag" => Mailin_TAG)
            );
            $sendMail->send_email($dataMail);
            // mail send confirmation functionality
            $sendMsg = '';
            $data['mail_to'] = $fbemail;
            $data['from_mail'] = FROM_MAIL;
            $data['topMsg'] = 'Dear ' . $fbfullName . ',';
            $data['bodyMsg'] = 'We want to say thank you for sharing your feedback with us. Your feedback is extremely valuable to us. We will use your feedback for future improvement. Do let us know if there is anything else we need to know to improve any area of concern.';
            $data['thanksMsg'] = 'With Best Regards,';
            $data['delimeter'] = 'SoOLEGAL Team';
            // send Mail Functionality
            $sendMail = new Mailin(EMAIL_BASE_URL, EMAIL_API_KEY);
            $dataMail = array(
                "to" => array($data['mail_to'] => $fbfullName),
                "from" => array($data['from_mail'], FROM_TEXT),
                "replyto" => array(NOREPLY_MAIL, "no-reply"),
                "subject" => "SoOLEGAL - Thank you for feedback",
                "html" => $this->load->view('mailTemplates/feedbackTemplateConfirmation', $data, TRUE),
                "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "SoOLEGAL", "X-Mailin-IP" => IP_ADDRESS, "X-Mailin-Tag" => Mailin_TAG)
            );
            $sendMail->send_email($dataMail);
            $this->session->set_flashdata('flsh_msg', '<div class="alert alert-success">Thankyou For Your Feedback.We will contact you soon. </div>');
            redirect("feedback");
        }
    }
    //Testimonial
    public function testimonial(){
        $response['title'] = 'SoOLEGAL - Feedback';
        $response['metaDescription'] = 'SoOLEGAL - Feedback';
        $response['metaKeywords'] = 'SoOLEGAL - Feedback';
        $response['testimonial'] = $this->feedback->getTestimonial();
        $this->load->view('feedback/index', $response);
    }
    //add Testimonial
    public function addTestimonial(){
        $response['title'] = 'SoOLEGAL - Feedback';
        $response['metaDescription'] = 'SoOLEGAL - Feedback';
        $response['metaKeywords'] = 'SoOLEGAL - Feedback';
        $this->load->view('feedback/testimonial', $response);
    }
    //send Testimonial
    public function sendTestimonial() {
        $name = $this->input->post('name');
        $location = $this->input->post('location');
        $message = $this->input->post('message');
        if(!empty($this->session->userdata('member_id'))){
            $member_id = $this->session->userdata('member_id');
        } else {
            $member_id = 0;
        }
        if (!empty($message)) {
            $this->load->library('email');
            $this->feedback->setName($name);
            $this->feedback->setLocation($location);
            $this->feedback->setMemberID($member_id);
            $this->feedback->setComment($message);
            $this->feedback->setStatus(0);
            $this->feedback->setTimeStamp(time());
            //call feedback method
            $this->feedback->createTestimonial();
        }
        $this->session->set_flashdata('flsh_msg', '<div class="alert alert-success">Testimonial has been created.</div>');
        redirect("feedback/testimonial");
    }
}
