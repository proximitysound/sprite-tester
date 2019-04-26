<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sprite_class {

        public function my_print_r($arr) 
        	
        	{ 
        	
        	echo '<pre>'; print_r($arr); echo '</pre>'; 
        	
        	}
        	
    	public function load($view, $vars = array())
    		{	
       			$CI = &get_instance();
        		$CI->load->view('master/header', $vars);
        		$CI->load->view($view, $vars);
        		$CI->load->view('master/footer', $vars);
    		}
        	
}