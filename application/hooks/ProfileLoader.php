<?php
class ProfileLoader
{
    function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');
        
        $updateProfile = $ci->session->userdata('update_profile');
        if($ci->uri->segment(2) == 'logout') {
            
        } elseif($ci->uri->segment(2) == 'getMemberInformation') {
        
        } else {
            if ($ci->session->userdata('is_authenticate_member') == TRUE && $updateProfile==0) {            
                if($ci->uri->segment(2) != 'updateprofile') {
                    if($ci->uri->segment(2)=='getstates'){
                        
                    } elseif($ci->uri->segment(2)=='getcities'){
                        
                    } elseif($ci->uri->segment(2)=='memberRegistrationupdate') {
                        
                    } else {
                        redirect('member/updateprofile');
                    }
                } 
            } 
        }
       
    }
}