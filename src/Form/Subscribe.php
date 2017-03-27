<?php
namespace Svbk\WP\Helpers\Form;

use Svbk\WP\Helpers\MailChimp;

class Subscribe extends Submission {

    public $field_prefix = 'sbs';
    public $action = 'svbk_subscribe';
    
    public $mc_apikey = '';
    
    protected function mainAction(){
        
        if( !empty( $this->mc_apikey ) && !empty( $this->mc_list_id )){
            $mc = new MailChimp( $this->mc_apikey );
            
            $errors = $mc->subscribe( $this->mc_list_id, $this->getInput('email'), $this->subscribeAttributes() );
            
            array_walk($errors, array($this, 'addError'));
        }
        
    }    
    
    protected function subscribeAttributes(){
        return array( 
            'merge_fields' => [ 
                'FNAME'=> $this->getInput('fname'), 
                'LNAME' => $this->getInput('lname'),
                'MARKETING' => $this->getInput('policy_directMarketing') ? 'yes' : 'no',
            ] 
        );
    }
 
    
}