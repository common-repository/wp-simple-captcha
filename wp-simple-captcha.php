<?php
/*
Plugin Name: WP Simple Captcha
Plugin URI: http://html5beta.com/wordpress/wp-simple-captcha/
Description: add a simple math captcha to comment form.no javascript,no css included,just some php code.should just stop robot spammers.
Author: ZHAO Xudong
Version: 1.3
Author URI: http://html5beta.com
Tags: captcha
*/

/*
    Copyright 2011  ZHAO Xudong  (email : zxdong@gmail.com)
	
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
class zxdRoboCheck{
	function zxd_robokiller_fields($fields) {
		$rnum1 =rand(1,10);
		$rnum2 = rand(2,8);
		$rnum = $rnum1 + $rnum2;
		$fields['robo'] = '<p class="comment-form-robo"><label for="robo">'.$rnum1.'+'.$rnum2.'=?'.__('(robot check)').'</label> <span class="required">*</span><input id="robo" name="robo" type="text" value="" size="30" aria-required="true" /><input id="rnum" name="rnum" type="hidden" value="'.$rnum.'" size="0" aria-required="true" class="hide" /></p> ';
		return $fields;
	}
	function roboCheck($comment){
                $userId = get_current_user_id();
                if($userId!=0) return($comment);
		if (empty($_POST['robo']) || trim($_POST['robo']) == '' ) {
			wp_die( __('Error: you are not robot,are you?do the math,fill the blank '));
		}
		$robo_num1 = (int)$_POST['robo'];
		$robo_num2 = (int)$_POST['rnum'];
		if ( $robo_num2 == $robo_num1) {
			return($comment);
		} 
		else {
			wp_die( __('Error: you are not robot,are you?'));
		}
	}
}
if (class_exists("zxdRoboCheck")) {
  $aRoboCheck = new zxdRoboCheck();
  add_action('comment_form_default_fields', array(&$aRoboCheck, 'zxd_robokiller_fields'),1);
  add_filter('preprocess_comment', array(&$aRoboCheck, 'roboCheck'), 1);
}
?>
