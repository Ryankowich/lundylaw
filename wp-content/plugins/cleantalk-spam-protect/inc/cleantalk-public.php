<?php

/**
 * Init functions 
 * @return 	mixed[] Array of options
 */
function ct_init() {
    global $ct_wplp_result_label, $ct_jp_comments, $ct_post_data_label, $ct_post_data_authnet_label, $ct_formtime_label, $ct_direct_post, $ct_options, $ct_data, $ct_check_post_result, $test_external_forms, $cleantalk_executed, $wpdb, $ct_agent_version;

    $ct_options = ct_get_options();
	$ct_data=ct_get_data();
    	
    //Check internal forms with such "action" http://wordpress.loc/contact-us/some_script.php
    if((isset($_POST['action']) && $_POST['action'] == 'ct_check_internal') &&
        (isset($ct_options['check_internal']) && intval($ct_options['check_internal']))
    ){
        $ct_result = ct_contact_form_validate();
        if($ct_result == null){
            echo 'true';
            die();
        }else{
            echo $ct_result;
            die();
        }
    }
    
    //fix for EPM registration form
    if(isset($_POST) && isset($_POST['reg_email']) && shortcode_exists( 'epm_registration_form' ))
    {
    	unset($_POST['ct_checkjs_register_form']);
    }
    
    if(isset($_POST['_wpnonce-et-pb-contact-form-submitted']))
    {
    	add_shortcode( 'et_pb_contact_form', 'ct_contact_form_validate' );
    }
	
    if($test_external_forms && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cleantalk_hidden_method']) && isset($_POST['cleantalk_hidden_action']))
    {
    	$action=htmlspecialchars($_POST['cleantalk_hidden_action']);
    	$method=htmlspecialchars($_POST['cleantalk_hidden_method']);
    	unset($_POST['cleantalk_hidden_action']);
    	unset($_POST['cleantalk_hidden_method']);
    	ct_contact_form_validate();
    	print "<html><body><form method='$method' action='$action'>";
    	ct_print_form($_POST,'');
    	print "</form><center>Redirecting to ".$action."... Anti-spam by CleanTalk.</center></body></html>";
    	print "<script>document.forms[0].submit();</script>";
    	die();
    }
    
    if(isset($ct_options['general_postdata_test']) && $ct_options['general_postdata_test'] == 1 && !@isset($_POST['ct_checkjs_cf7']))
    {
    	$ct_general_postdata_test = @intval($ct_options['general_postdata_test']);
    	//hook for Anonymous Post
    	add_action('template_redirect','ct_contact_form_validate_postdata',1);
    }
    else
    {
    	$ct_general_postdata_test=0;
    }
    
    if (isset($ct_options['general_contact_forms_test']) && $ct_options['general_contact_forms_test'] == 1&&!@isset($_POST['ct_checkjs_cf7']))
    {
		add_action('CMA_custom_post_type_nav','ct_contact_form_validate_postdata',1);
		add_action('template_redirect','ct_contact_form_validate',1);
		if(isset($_POST['reg_redirect_link'])&&isset($_POST['tmpl_registration_nonce_field']))
		{
			unset($_POST['ct_checkjs_register_form']);
			ct_contact_form_validate();
		}
		/*if(isset($_GET['ait-action'])&&$_GET['ait-action']=='register')
		{
			$tmp=$_POST['redirect_to'];
			unset($_POST['redirect_to']);
			ct_contact_form_validate();
			$_POST['redirect_to']=$tmp;
		}*/
	}
	
    if($ct_general_postdata_test==1&&!@isset($_POST['ct_checkjs_cf7']))
    {
    	add_action('CMA_custom_post_type_nav','ct_contact_form_validate_postdata',1);
    }
    
	//add_action('wp_footer','ct_ajaxurl');

    // Fast Secure contact form
    if(defined('FSCF_VERSION')){
	add_filter('si_contact_display_after_fields', 'ct_si_contact_display_after_fields');
	add_filter('si_contact_form_validate', 'ct_si_contact_form_validate');
    }

    // WooCoomerse signups
    if(class_exists('WooCommerce')){
		add_filter('woocommerce_register_post', 'ct_register_post', 1, 3);
    }
	if(class_exists('WC_Wishlists_Wishlist')){
		add_filter('wc_wishlists_create_list_args', 'ct_woocommerce_wishlist_check', 1, 1);
	}
	
	
    // JetPack Contact form
    $jetpack_active_modules = false;
    if(defined('JETPACK__VERSION'))
    {
		if(isset($_POST['action']) && $_POST['action'] == 'grunion-contact-form' ){
			if(JETPACK__VERSION=='3.4-beta')
			{
				add_filter('contact_form_is_spam', 'ct_contact_form_is_spam');
			}
			else if(JETPACK__VERSION=='3.4-beta2'||JETPACK__VERSION>='3.4')
			{
				add_filter('jetpack_contact_form_is_spam', 'ct_contact_form_is_spam_jetpack',50,2);
			}
			else
			{
				add_filter('contact_form_is_spam', 'ct_contact_form_is_spam');
			}
			$jetpack_active_modules = get_option('jetpack_active_modules');
			if ((class_exists( 'Jetpack', false) && $jetpack_active_modules && in_array('comments', $jetpack_active_modules)))
			{
				$ct_jp_comments = true;
			}
		}else
			add_filter('grunion_contact_form_field_html', 'ct_grunion_contact_form_field_html', 10, 2);
    }

    // Contact Form7 
    if(defined('WPCF7_VERSION')){
	add_filter('wpcf7_form_elements', 'ct_wpcf7_form_elements');
	if(WPCF7_VERSION >= '3.0.0')
	{
	    add_filter('wpcf7_spam', 'ct_wpcf7_spam');
	}
	else
	{
	    add_filter('wpcf7_acceptance', 'ct_wpcf7_spam');
	}
    }

    // Formidable
    if(class_exists('FrmSettings')){
	    add_action('frm_validate_entry', 'ct_frm_validate_entry', 1, 2);
	    add_action('frm_entries_footer_scripts', 'ct_frm_entries_footer_scripts', 20, 2);
    }

    // BuddyPress
    if(class_exists('BuddyPress')){
		add_action('bp_before_registration_submit_buttons','ct_register_form',1);
		add_filter('bp_signup_validate', 'ct_registration_errors',1);
		add_filter('bp_signup_validate', 'ct_check_registration_erros', 999999);
		add_action('messages_message_before_save','ct_bp_private_msg_check', 1);
    }

	if(defined('PROFILEPRESS_SYSTEM_FILE_PATH')){
		add_filter('pp_registration_validation', 'ct_registration_errors_ppress', 11, 2);
	}
		
	
    // bbPress
    if(class_exists('bbPress')){
	add_filter('bbp_new_topic_pre_title', 'ct_bbp_get_topic', 1);
	add_filter('bbp_new_topic_pre_content', 'ct_bbp_new_pre_content', 1);
	add_filter('bbp_new_reply_pre_content', 'ct_bbp_new_pre_content', 1);
	add_action('bbp_theme_before_topic_form_content', 'ct_comment_form');
	add_action('bbp_theme_before_reply_form_content', 'ct_comment_form');
    }

	//Custom Contact Forms
	if(defined('CCF_VERSION')){
		add_filter('ccf_field_validator', 'ct_ccf', 1, 4);
	}
	
    add_action('comment_form', 'ct_comment_form');

    //intercept WordPress Landing Pages POST
    if (defined('LANDINGPAGES_CURRENT_VERSION') && !empty($_POST)){
        if(array_key_exists('action', $_POST) && $_POST['action'] === 'inbound_store_lead'){ // AJAX action(s)
            ct_check_wplp();
        }else if(array_key_exists('inbound_submitted', $_POST) && $_POST['inbound_submitted'] == '1'){ // Final submit
            ct_check_wplp();
        }
    }
    
    // intercept S2member POST
    if (defined('WS_PLUGIN__S2MEMBER_PRO_VERSION') && (isset($_POST[$ct_post_data_label]['email']) || isset($_POST[$ct_post_data_authnet_label]['email']))){
        ct_s2member_registration_test(); 
    }
    
    //
    // New user approve hack
    // https://wordpress.org/plugins/new-user-approve/
    //
    if (ct_plugin_active('new-user-approve/new-user-approve.php')) {
        add_action('register_post', 'ct_register_post', 1, 3);
    }
    
    //
    // Gravity forms
    //
    if (defined('GF_MIN_WP_VERSION')) {
        add_filter('gform_get_form_filter', 'ct_gforms_hidden_field', 10, 2);
        add_filter('gform_entry_is_spam', 'ct_gforms_spam_test', 1, 3);
    }
    	
	//
	//Pirate forms
	//
	if(defined('PIRATE_FORMS_VERSION')){
		if(isset($_POST['pirate-forms-contact-name']) && $_POST['pirate-forms-contact-name'] && isset($_POST['pirate-forms-contact-email']) && $_POST['pirate-forms-contact-email'])
			ct_pirate_forms_check();
	}

    //
    // Load JS code to website footer
    //
    if (!(defined( 'DOING_AJAX' ) && DOING_AJAX)) {
        add_action('wp_footer', 'ct_footer_add_cookie', 1);
		add_action('wp_footer', 'ct_page_count', 1);
    }
   
    if ($ct_options['protect_logged_in'] != 1 && is_user_logged_in()) {
        $ct_check_post_result=false;
        ct_contact_form_validate();
    }

    if (ct_is_user_enable()) {
        ct_cookies_test();

        if (isset($ct_options['general_contact_forms_test']) && $ct_options['general_contact_forms_test'] == 1 && !isset($_POST['comment_post_ID']) && !isset($_GET['for'])){
        	$ct_check_post_result=false;
            ct_contact_form_validate();
        }
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $ct_general_postdata_test==1 && !is_admin() && !@isset($_POST['ct_checkjs_cf7'])){
	    	$ct_check_post_result=false;
	    	ct_contact_form_validate_postdata();
	    }
    }
}

// MailChimp Premium for Wordpress
function ct_add_mc4wp_error_message($messages){
		
	$messages['ct_mc4wp_response'] = array(
		'type' => 'error',
		'text' => 'Your message looks like spam.'
	);
	return $messages;
}
add_filter( 'mc4wp_form_messages', 'ct_add_mc4wp_error_message' );

/*
 * Function to set validate fucntion for CCF form
 * Input - Сonsistently each form field
 * Returns - String. Validate function
*/
function ct_ccf($callback, $value, $field_id, $type){
	/*
	if($type == 'name')
		$ct_global_temporary_data['name'] = $value;
	elseif($type == 'email')
		$ct_global_temporary_data['email'] = $value;
	else
		$ct_global_temporary_data[] = $value;
	//*/
	return 'ct_validate_ccf_submission';
}
/*
 * Validate function for CCF form. Gatheering data. Multiple calls.
 * Input - void. Global $ct_global_temporary_data
 * Returns - String. CleanTalk comment.
*/
$ct_global_temporary_data = array();
function ct_validate_ccf_submission($value, $field_id, $required){
	global $ct_global_temporary_data, $ct_options;
	
	$ct_options = ct_get_options();

	//If the check for contact forms enabled
	if(isset($ct_options['contact_forms_test']) && intval($ct_options['contact_forms_test']) == '0')
		return true;
	//If the check for logged in users enabled
	if(isset($ct_options['protect_logged_in']) && intval($ct_options['protect_logged_in']) == 1 && is_user_logged_in())
		return true;
	
	//Accumulate data
	$ct_global_temporary_data[] = $value;
	
	//If it's the last field of the form
	(!isset($ct_global_temporary_data['count']) ? $ct_global_temporary_data['count'] = 1 : $ct_global_temporary_data['count']++);
	$form_id = $_POST['form_id'];
	if($ct_global_temporary_data['count'] != count(get_post_meta( $form_id, 'ccf_attached_fields', true )))
		return true;
	unset($ct_global_temporary_data['count']);
	
	//Getting request params
	$ct_temp_msg_data = ct_get_fields_any($_POST);
	
	unset($ct_global_temporary_data);
			
    $sender_email = ($ct_temp_msg_data['email'] ? $ct_temp_msg_data['email'] : '');
    $sender_nickname = ($ct_temp_msg_data['nickname'] ? $ct_temp_msg_data['nickname'] : '');
    $subject = ($ct_temp_msg_data['subject'] ? $ct_temp_msg_data['subject'] : '');
    $contact_form = ($ct_temp_msg_data['contact'] ? $ct_temp_msg_data['contact'] : true);
    $message = ($ct_temp_msg_data['message'] ? $ct_temp_msg_data['message'] : array());
	
	if ($subject != '')
        $message = array_merge(array('subject' => $subject), $message);
    $message = json_encode($message);
	
	$post_info['comment_type'] = 'feedback_custom_contact_forms'; 
    $post_info['post_url'] = $_SERVER['HTTP_REFERER']; 
    $post_info = json_encode($post_info);
    if ($post_info === false)
	    $post_info = '';
	
	$checkjs = js_test('ct_checkjs', $_COOKIE, true);
    if ($checkjs === null) 
        $checkjs = js_test('ct_checkjs', $_POST, true);
	
	$sender_info = array(
	    'sender_url' => null
    );
			
	//Making a call
	$ct_base_call_result = ct_base_call(array(
        'message' => $subject." ".$message,
        'example' => null,
        'sender_email' => $sender_email,
        'sender_nickname' => $sender_nickname,
        'post_info' => $post_info,
        'checkjs' => $checkjs,
        'sender_info' => $sender_info
    ));
	
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];
		
    if ($ct_result->allow == 0)
		return $ct_result->comment;
	else
		return true;	
}

function ct_woocommerce_wishlist_check($args){
	global $ct_options;
	
	$ct_options = ct_get_options();
	
	//Protect logged in users
	if($args['wishlist_status'])
		if(isset($ct_options['protect_logged_in']) && $ct_options['protect_logged_in'] == 0)
			return $args;
	
	//If the IP is a Google bot
	$hostname = gethostbyaddr( filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) );
	if(!strpos($hostname, 'googlebot.com'))
		return $args;
	
	//Getting request params
	$message = '';
	$subject = '';
	$email = $args['wishlist_owner_email'];
	if($args['wishlist_first_name']!='' || $args['wishlist_last_name']!='')
		$nickname = trim($args['wishlist_first_name']." ".$args['wishlist_last_name']);
	else
		$nickname = '';
	
	$post_info['comment_type'] = 'feedback'; 
    $post_info['post_url'] = $_SERVER['HTTP_REFERER']; 
    $post_info = json_encode($post_info);
    if ($post_info === false)
	    $post_info = '';
	
	$checkjs = js_test('ct_checkjs', $_COOKIE, true);
    if ($checkjs === null) 
        $checkjs = js_test('ct_checkjs', $_POST, true);
	
	$sender_info = array(
	    'sender_url' => null
    );
	
	//Making a call
	$ct_base_call_result = ct_base_call(array(
        'message' => $subject." ".$message,
        'example' => null,
        'sender_email' => $email,
        'sender_nickname' => $nickname,
        'post_info' => $post_info,
        'checkjs' => $checkjs,
        'sender_info' => $sender_info
    ));
	
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];

    if ($ct_result->allow == 0)
		wp_die("<h1>Spam Protection by CleanTalk</h1><h2>".$ct_result->comment."</h2>", '', array('response' => 403, "back_link" => true, "text_direction" => 'ltr'));
	else
		return $args;
}

/**
* Public function - Tests new private messages (dialogs)
* return @array with errors if spam has found
*/

function ct_bp_private_msg_check( $bp_message_obj){
	global $ct_options;
	
	$ct_options = ct_get_options();

	//Check for enabled option
	if($ct_options['bp_private_messages'] == 0)
		return;
	
	//Check for quantity of comments
	$is_max_comments = false;
	if(defined('CLEANTALK_CHECK_COMMENTS_NUMBER'))
    	$comments_check_number = CLEANTALK_CHECK_COMMENTS_NUMBER;
    else
     	$comments_check_number = 3;

    if(isset($ct_options['check_comments_number']))
    	$value = @intval($ct_options['check_comments_number']);
    else
    	$value=1;

    if($value == 1){
		$args = array(
			'user_id' => $bp_message_obj->sender_id,
			'box' => 'sentbox',
			'type' => 'all',
			'limit' => $comments_check_number,
			'page' => null,
			'search_terms' => '',
			'meta_query' => array()
		);
    	$sentbox_msgs = BP_Messages_Thread::get_current_threads_for_user($args);
		$cnt_sentbox_msgs = $sentbox_msgs['total'];
		$args['box'] = 'inbox';
		$inbox_msgs = BP_Messages_Thread::get_current_threads_for_user($args);
		$cnt_inbox_msgs = $inbox_msgs['total'];
    	if(($cnt_inbox_msgs + $cnt_sentbox_msgs) >= $comments_check_number)
    		$is_max_comments = true;
    }
	
	if($is_max_comments)
		return;

	//Getting request params
	
	$sender_user_obj = get_user_by('id', $bp_message_obj->sender_id);
	
	$message = $bp_message_obj->message;
	$subject = $bp_message_obj->subject;
	$email = $sender_user_obj->data->user_email;
	$nickname = $sender_user_obj->data->user_login;
	
	$post_info['comment_type'] = 'feedback'; 
    $post_info['post_url'] = $_SERVER['HTTP_REFERER']; 
    $post_info = json_encode($post_info);
    if ($post_info === false)
	    $post_info = '';
	
	$checkjs = js_test('ct_checkjs', $_COOKIE, true);
    if ($checkjs === null) 
        $checkjs = js_test('ct_checkjs', $_POST, true);
	
	$sender_info = array(
	    'sender_url' => null
    );
	
	//Making a call
	
	$ct_base_call_result = ct_base_call(array(
        'message' => $subject." ".$message,
        'example' => null,
        'sender_email' => $email,
        'sender_nickname' => $nickname,
        'post_info' => $post_info,
        'checkjs' => $checkjs,
        'sender_info' => $sender_info
    ));
	
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];

    if ($ct_result->allow == 0)
		wp_die("<h1>Spam Protection by CleanTalk</h1><h2>".$ct_result->comment."</h2>", '', array('response' => 403, "back_link" => true, "text_direction" => 'ltr'));
}

/**
* Public function - Tests for Pirate contact froms
* return NULL
*/
function ct_pirate_forms_check(){
	global $ct_options;
	
	$ct_options = ct_get_options();

	//Check for enabled option
	if($ct_options['contact_forms_test'] == 0)
		return;

	$ct_temp_msg_data = ct_get_fields_any($_POST);
	
	//Getting request params
	
	$ct_temp_msg_data = ct_get_fields_any($_POST);
	
    $sender_email = ($ct_temp_msg_data['email'] ? $ct_temp_msg_data['email'] : '');
    $sender_nickname = ($ct_temp_msg_data['nickname'] ? $ct_temp_msg_data['nickname'] : '');
    $subject = ($ct_temp_msg_data['subject'] ? $ct_temp_msg_data['subject'] : '');
    $contact_form = ($ct_temp_msg_data['contact'] ? $ct_temp_msg_data['contact'] : true);
    $message = ($ct_temp_msg_data['message'] ? $ct_temp_msg_data['message'] : array());

    if($subject != '')
		$message = array_merge(array('subject' => $subject), $message);
	
    $message = json_encode($message);
	
	$post_info['comment_type'] = 'feedback_pirate_contact_form'; 
    $post_info['post_url'] = $_SERVER['HTTP_REFERER']; 
    $post_info = json_encode($post_info);
    if ($post_info === false)
	    $post_info = '';
	
	$checkjs = js_test('ct_checkjs', $_COOKIE, true);
	
	$sender_info = array(
	    'sender_url' => null
    );
	
	//Making a call
	
	$ct_base_call_result = ct_base_call(array(
        'message' => $message,
        'example' => null,
        'sender_email' => $sender_email,
        'sender_nickname' => $sender_nickname,
        'post_info' => $post_info,
        'checkjs' => $checkjs,
        'sender_info' => $sender_info
    ));
	
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];

    if ($ct_result->allow == 0)
		wp_die("<h1>Spam Protection by CleanTalk</h1><h2>".$ct_result->comment."</h2>", '', array('response' => 403, "back_link" => true, "text_direction" => 'ltr'));
}

/**
 *    Does actions to prepare anti-spam tests. 
 *    @return bool;
 */
function ct_setup_page_timer($set_global = false) {
    global $ct_formtime_label, $ct_page_timer_setuped;

    //
    // Timer is already setuped.
    //
    if ($ct_page_timer_setuped) {
        return $ct_page_timer_setuped;
    }

    //
    // Skip sessions to do not break Varnish caching.
    //
    if ($set_global) {
        $ct_options = ct_get_options();
        if ($ct_options['set_cookies'] != 1) {
            return false;
        }
    }
    
    ct_init_session();
    
    $_SESSION[$ct_formtime_label] = time();
    
    $ct_page_timer_setuped = true;

    return true;
}

function ct_ajaxurl() {
	?>
	<script type="text/javascript">
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
	<?php
	wp_enqueue_script('ct_nocache_js',plugins_url( '/cleantalk_nocache.js' , __FILE__ ));
}

/**
 * Adds hidden filed to comment form 
 */
function ct_comment_form($post_id) {
    global $ct_options, $ct_data;
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if (ct_is_user_enable() === false) {
        return false;
    }

    if ($ct_options['comments_test'] == 0) {
        return false;
    }
    
    ct_add_hidden_fields(true, 'ct_checkjs', false, false);

    ct_setup_page_timer();

    return null;
}

/**
 * Adds cookie script filed to footer
 */
function ct_footer_add_cookie() {
    
    ct_setup_page_timer(true);

    ct_add_hidden_fields(true, 'ct_checkjs', false, true);

    return null;
}

/**
 * Adds initiates and ++ page counter
 */
function ct_page_count(){		
	$_SESSION['ct_page_hits'] = (!isset($_SESSION['ct_page_hits']) ? 1 : $_SESSION['ct_page_hits'] + 1);	
}

/**
 * Adds hidden filed to define avaialbility of client's JavaScript
 * @param 	bool $random_key switch on generation random key for every page load 
 */
function ct_add_hidden_fields($random_key = false, $field_name = 'ct_checkjs', $return_string = false, $cookie_check = false) {
    global $ct_checkjs_def, $ct_plugin_name, $ct_options, $ct_data;
    $ct_options = ct_get_options();
    
    $ct_checkjs_key = ct_get_checkjs_value($random_key); 
    $field_id_hash = md5(rand(0, 1000));
    
    if ($cookie_check && isset($ct_options['set_cookies']) && $ct_options['set_cookies'] == 1) { 
			$html = '
<script type="text/javascript">
function ctSetCookie(c_name, value, def_value) {
    document.cookie = c_name + "=" + escape(value) + "; path=/";
}
ctSetCookie("%s", "%s", "%s");
</script>
';      
		$html = sprintf($html, $field_name, $ct_checkjs_key, $ct_checkjs_def);
    } else {
        $ct_input_challenge = sprintf("'%s'", $ct_checkjs_key);

    	$field_id = $field_name . '_' . $field_id_hash;
		$html = '
<input type="hidden" id="%s" name="%s" value="%s" />
<script type="text/javascript">
setTimeout(function(){
    var ct_input_name = \'%s\';
    if (document.getElementById(ct_input_name) !== null) {
        var ct_input_value = document.getElementById(ct_input_name).value;
        document.getElementById(ct_input_name).value = document.getElementById(ct_input_name).value.replace(ct_input_value, %s); 
    }
}, 1000);
</script>
';
		$html = sprintf($html, $field_id, $field_name, $ct_checkjs_def, $field_id, $ct_input_challenge);
    };

    // Simplify JS code
    // and fixing issue with wpautop()
    $html = str_replace(array("\n","\r"),'', $html);

    if ($return_string === true) {
        return $html;
    } else {
        echo $html;
    } 
}

/**
 * Adds mouse tracking via JavaScript
 * @param 	bool $random_key switch on generation random key for every page load 
 */
function ct_add_mouse_tracking($return_string = false){
		
	$js_script = '<script type="text/javascript">
	function ctSetCookie(c_name, value) {
		document.cookie = c_name + "=" + encodeURIComponent(value) + "; path=/";
	}

	ctSetCookie("ct_ps_timestamp", Math.floor(new Date().getTime()/1000));
	ctSetCookie("ct_fkp_timestamp", "0");
	ctSetCookie("ct_pointer_data", "0");
	ctSetCookie("ct_timezone", "0");

	setTimeout(function(){
		ctSetCookie("ct_timezone", d.getTimezoneOffset()/60*(-1));
	},1000);

	//Stop observing function
	function ctMouseStopData(){
		if(typeof window.addEventListener == "function")
			window.removeEventListener("mousemove", ctFunctionMouseMove);
		else
			window.detachEvent("onmousemove", ctFunctionMouseMove);
		clearInterval(ctMouseReadInterval);
		clearInterval(ctMouseWriteDataInterval);				
	}

	//Stop key listening function
	function ctKeyStopStopListening(){
		if(typeof window.addEventListener == "function"){
			window.removeEventListener("mousedown", ctFunctionFirstKey);
			window.removeEventListener("keydown", ctFunctionFirstKey);
		}else{
			window.detachEvent("mousedown", ctFunctionFirstKey);
			window.detachEvent("keydown", ctFunctionFirstKey);
		}
		clearInterval(ctMouseReadInterval);
		clearInterval(ctMouseWriteDataInterval);				
	}

	var d = new Date(), 
		ctTimeMs = new Date().getTime(),
		ctMouseEventTimerFlag = true, //Reading interval flag
		ctMouseData = "[",
		ctMouseDataCounter = 0;
		
	//Reading interval
	var ctMouseReadInterval = setInterval(function(){
			ctMouseEventTimerFlag = true;
		}, 300);
		
	//Writting interval
	var ctMouseWriteDataInterval = setInterval(function(){ 
			var ctMouseDataToSend = ctMouseData.slice(0,-1).concat("]");
			ctSetCookie("ct_pointer_data", ctMouseDataToSend);
		}, 3000);

	//Logging mouse position each 300 ms
	var ctFunctionMouseMove = function output(event){
		if(ctMouseEventTimerFlag == true){
			var mouseDate = new Date();
			ctMouseData += "[" + event.pageY + "," + event.pageX + "," + (mouseDate.getTime() - ctTimeMs) + "],";
			ctMouseDataCounter++;
			ctMouseEventTimerFlag = false;
			if(ctMouseDataCounter >= 100)
				ctMouseStopData();
		}
	}
	//Writing first key press timestamp
	var ctFunctionFirstKey = function output(event){
		var KeyTimestamp = Math.floor(new Date().getTime()/1000);
		ctSetCookie("ct_fkp_timestamp", KeyTimestamp);
		ctKeyStopStopListening();
	}

	if(typeof window.addEventListener == "function"){
		window.addEventListener("mousemove", ctFunctionMouseMove);
		window.addEventListener("mousedown", ctFunctionFirstKey);
		window.addEventListener("keydown", ctFunctionFirstKey);
	}else{
		window.attachEvent("onmousemove", ctFunctionMouseMove);
		window.attachEvent("mousedown", ctFunctionFirstKey);
		window.attachEvent("keydown", ctFunctionFirstKey);
	}
	</script>';
	
	if($return_string)
		return $js_script;
	else
		echo $js_script;
}

/**
 * Is enable for user group
 * @return boolean
 */
function ct_is_user_enable() {
    global $current_user;

    if (!isset($current_user->roles)) {
        return true; 
    }

    $disable_roles = array('administrator', 'editor', 'author');
    foreach ($current_user->roles as $k => $v) {
        if (in_array($v, $disable_roles))
            return false;
    }

    return true;
    //return !current_user_can('publish_posts');
}

/**
* Public function - Insert JS code for spam tests
* return null;
*/
function ct_frm_entries_footer_scripts($fields, $form) {
    global $ct_options, $ct_checkjs_frm;
    
    if ($ct_options['contact_forms_test'] == 0)
        return false;
    
    $ct_checkjs_key = ct_get_checkjs_value();
    $ct_frm_base_name = 'form_';
    $ct_frm_name = $ct_frm_base_name . $form->form_key;
    
    ct_setup_page_timer();

    echo "var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', '$ct_checkjs_frm');
    input.setAttribute('value', '$ct_checkjs_key');
    
    for (i = 0; i < document.forms.length; i++) {
        if (document.forms[i].id && document.forms[i].id.search('$ct_frm_name') != -1) {
            document.forms[i].appendChild(input);
        }
    }";
	
    $js_code = ct_add_hidden_fields(true, 'ct_checkjs', true, true);
    $js_code = strip_tags($js_code); // Removing <script> tag
    echo $js_code;
}

/**
* Public function - Test Formidable data for spam activity
* return @array with errors if spam has found
*/
function ct_frm_validate_entry ($errors, $values) {
    global $wpdb, $current_user, $ct_agent_version, $ct_checkjs_frm, $ct_options, $ct_data;

    $ct_options = ct_get_options();
    $ct_data = ct_get_data();
    
    if ($ct_options['contact_forms_test'] == 0) {
        return $errors;
    }
    
    // Skip processing for logged in users.
    if ($ct_options['protect_logged_in'] != 1 && is_user_logged_in()) {
        return $errors;
    }
     
    $checkjs = js_test('ct_checkjs', $_COOKIE, true);
    if($checkjs != 1){
        $checkjs = js_test($ct_checkjs_frm, $_POST, true);
    }

    $post_info['comment_type'] = 'feedback';
    $post_info = json_encode($post_info);
    if ($post_info === false)
        $post_info = '';

	$ct_temp_msg_data = ct_get_fields_any($values['item_meta']);
	
    $sender_email = ($ct_temp_msg_data['email'] ? $ct_temp_msg_data['email'] : '');
    $sender_nickname = ($ct_temp_msg_data['nickname'] ? $ct_temp_msg_data['nickname'] : '');
    $subject = ($ct_temp_msg_data['subject'] ? $ct_temp_msg_data['subject'] : '');
    $contact_form = ($ct_temp_msg_data['contact'] ? $ct_temp_msg_data['contact'] : true);
    $message = ($ct_temp_msg_data['message'] ? $ct_temp_msg_data['message'] : array());
    
    $message = json_encode($message);

    $ct_base_call_result = ct_base_call(array(
        'message' => $message,
        'example' => null,
        'sender_email' => $sender_email,
        'sender_nickname' => $sender_nickname,
        'post_info' => $post_info,
        'checkjs' => $checkjs
    ));
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];

    if ($ct_result->allow == 0) {
        $errors['ct_error'] = '<br /><b>' . $ct_result->comment . '</b><br /><br />';
    }

    return $errors;
}

/**
 * Public filter 'bbp_*' - Get new topic name to global $ct_bbp_topic
 * @param 	mixed[] $comment Comment string 
 * @return  mixed[] $comment Comment string 
 */
function ct_bbp_get_topic($topic){
	global $ct_bbp_topic;
	
	$ct_bbp_topic=$topic;
	
	return $topic;
}

/**
 * Public filter 'bbp_*' - Checks topics, replies by cleantalk
 * @param 	mixed[] $comment Comment string 
 * @return  mixed[] $comment Comment string 
 */
function ct_bbp_new_pre_content ($comment) {
    global $ct_options, $ct_data, $current_user, $ct_bbp_topic;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if ($ct_options['comments_test'] == 0 ) {
        return $comment;
    }
		
    // Skip processing for logged in users and admin.
    if ($ct_options['protect_logged_in'] != 1 && is_user_logged_in() ||
		in_array("administrator", $current_user->roles))
        return $comment;
     
    $checkjs = js_test('ct_checkjs', $_COOKIE, true);
    if ($checkjs === null) {
        $checkjs = js_test('ct_checkjs', $_POST, true);
    }

    $example = null;
    
    $sender_info = array(
	    'sender_url' => isset($_POST['bbp_anonymous_website']) ? $_POST['bbp_anonymous_website'] : null 
    );

    $post_info['comment_type'] = 'bbpress_comment'; 
    $post_info['post_url'] = bbp_get_topic_permalink(); 

    $post_info = json_encode($post_info);
    if ($post_info === false) {
	    $post_info = '';
    }
	
	if(isset($ct_bbp_topic))
		$message = $ct_bbp_topic." ".$comment;
	else
		$message = $comment;
	
    $ct_base_call_result = ct_base_call(array(
        'message' => $comment,
        'example' => $example,
        'sender_email' => isset($_POST['bbp_anonymous_email']) ? $_POST['bbp_anonymous_email'] : null, 
        'sender_nickname' => isset($_POST['bbp_anonymous_name']) ? $_POST['bbp_anonymous_name'] : null, 
        'post_info' => $post_info,
        'checkjs' => $checkjs,
        'sender_info' => $sender_info
    ));
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];

    if ($ct_result->allow == 0) {
        bbp_add_error('bbp_reply_content', $ct_result->comment);
    }

    return $comment;
}

/**
 * Public filter 'preprocess_comment' - Checks comment by cleantalk server
 * @param 	mixed[] $comment Comment data array
 * @return 	mixed[] New data array of comment
 */
function ct_preprocess_comment($comment) {
    // this action is called just when WP process POST request (adds new comment)
    // this action is called by wp-comments-post.php
    // after processing WP makes redirect to post page with comment's form by GET request (see above)
    global $wpdb, $current_user, $comment_post_id, $ct_agent_version, $ct_comment_done, $ct_approved_request_id_label, $ct_jp_comments, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

	// Skip processing admin.
    if (in_array("administrator", $current_user->roles))
        return $comment;
    
    if(defined('CLEANTALK_CHECK_COMMENTS_NUMBER'))
    	$comments_check_number = CLEANTALK_CHECK_COMMENTS_NUMBER;
    else
    	$comments_check_number = 3;
    
    $is_max_comments = false;
    if(isset($ct_options['check_comments_number']))
    	$value = @intval($ct_options['check_comments_number']);
    else
    	$value=1;
    
    if($value == 1){
	   	$args=Array('author_email' => $comment['comment_author_email'],
    				'status' => 'approve',
    				'count' => false,
    				'number' => $comments_check_number
    				);
    	$cnt = sizeof(get_comments( $args ));
		
    	if($cnt >= $comments_check_number)
    		$is_max_comments = true;
		
    }

    if (($comment['comment_type']!='trackback') && (ct_is_user_enable() === false || $ct_options['comments_test'] == 0 || $ct_comment_done || (isset($_SERVER['HTTP_REFERER']) && stripos($_SERVER['HTTP_REFERER'],'page=wysija_campaigns&action=editTemplate')!==false) || $is_max_comments || strpos($_SERVER['REQUEST_URI'],'/wp-admin/')!==false)) {
        return $comment;
    }

    $local_blacklists = wp_blacklist_check(
        $comment['comment_author'],
        $comment['comment_author_email'], 
        $comment['comment_author_url'], 
        $comment['comment_content'], 
        @$_SERVER['REMOTE_ADDR'], 
        @$_SERVER['HTTP_USER_AGENT']
    );

    // Go out if author in local blacklists
    if ($comment['comment_type']!='trackback' && $local_blacklists === true) {
        return $comment;
    }

    // Skip pingback anti-spam test
    /*if ($comment['comment_type'] == 'pingback') {
        return $comment;
    }*/

    $ct_comment_done = true;

    $comment_post_id = $comment['comment_post_ID'];

    $sender_info = array(
	    'sender_url' => @$comment['comment_author_url']
    );

    //
    // JetPack comments logic
    //
    $checkjs = 0;
    if ($ct_jp_comments) {
        $post_info['comment_type'] = 'jetpack_comment'; 
        $checkjs = js_test('ct_checkjs', $_COOKIE, true);
    } else {
        $post_info['comment_type'] = $comment['comment_type'];
        $checkjs = js_test('ct_checkjs', $_POST, true);
    }
    if($checkjs==0)
    {
    	$checkjs = js_test('ct_checkjs', $_POST, true);
    }
    if($checkjs==0)
    {
    	$checkjs = js_test('ct_checkjs', $_COOKIE, true);
    }

    $post_info['post_url'] = ct_post_url(null, $comment_post_id); 
    $post_info = json_encode($post_info);
    if ($post_info === false) {
	    $post_info = '';
    }
    
    $example = null;
    if ($ct_options['relevance_test']) {
        $post = get_post($comment_post_id);
        if ($post !== null){
            $example['title'] = $post->post_title;
            $example['body'] = $post->post_content;
            $example['comments'] = null;

            $last_comments = get_comments(array('status' => 'approve', 'number' => 10, 'post_id' => $comment_post_id));
            foreach ($last_comments as $post_comment){
                $example['comments'] .= "\n\n" . $post_comment->comment_content;
            }

            $example = json_encode($example);
        }

        // Use plain string format if've failed with JSON
        if ($example === false || $example === null){
            $example = ($post->post_title !== null) ? $post->post_title : '';
            $example .= ($post->post_content !== null) ? "\n\n" . $post->post_content : '';
        }
    }

    $ct_base_call_result = ct_base_call(array(
        'message' => $comment['comment_content'],
        'example' => $example,
        'sender_email' => $comment['comment_author_email'],
        'sender_nickname' => $comment['comment_author'],
        'post_info' => $post_info,
        'checkjs' => $checkjs,
        'sender_info' => $sender_info
    ));
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];
		
	ct_hash($ct_result->id);
	
	//Don't check trusted users
	if (isset($comment['comment_author_email'])){
		$approved_comments = get_comments(array('status' => 'approve', 'count' => true, 'author_email' => $comment['comment_author_email']));
		$new_user = $approved_comments == 0 ? true : false;
	}

    // Change comment flow only for new authors
	if ($new_user || $ct_result->stop_words !== null || $ct_result->spam == 1)
		add_action('comment_post', 'ct_set_meta', 10, 2);	
	
	if($ct_result->allow){ // Pass if allowed
		if(get_option('comment_moderation') === '1') // Wordpress moderation flag
			add_filter('pre_comment_approved', 'ct_set_not_approved', 999, 2);
		else
			add_filter('pre_comment_approved', 'ct_set_approved', 999, 2);
	}else{
		
		global $ct_comment, $ct_stop_words;
		$ct_comment = $ct_result->comment;
		$ct_stop_words = $ct_result->stop_words;
		$err_text = '<center><b style="color: #49C73B;">Clean</b><b style="color: #349ebf;">Talk.</b> ' . __('Spam protection', 'cleantalk') . "</center><br><br>\n" . $ct_result->comment;
		$err_text .= '<script>setTimeout("history.back()", 5000);</script>';
		
		if($ct_result->stop_queue == 1) // Terminate. Definitely spam.
			wp_die($err_text, 'Blacklisted', array('back_link' => true));

		if($ct_result->spam == 3) // Don't move to spam folder. Delete.
			wp_die($err_text, 'Blacklisted', array('back_link' => true));
		
		if($ct_result->spam == 2){
			add_filter('pre_comment_approved', 'ct_set_comment_spam', 997, 2);
			add_action('comment_post', 'ct_wp_trash_comment', 997, 2);
		}
		
		if($ct_result->spam == 1)
			add_filter('pre_comment_approved', 'ct_set_comment_spam', 997, 2);
		
		if($ct_result->stop_words){ // Contains stop_words. Move to pending folder.
			add_filter('pre_comment_approved', 'ct_set_not_approved', 998, 2);
			add_action('comment_post', 'ct_mark_red', 998, 2);
		}
		
		add_action('comment_post', 'ct_die', 999, 2);
	}
		
	if(isset($ct_options['remove_comments_links']) && $ct_options['remove_comments_links'] == '1'){
		$comment = preg_replace("~(http|https|ftp|ftps)://(.*?)(\s|\n|[,.?!](\s|\n)|$)~", '[Link deleted]', $comment);
	}
		
    return $comment;
}

/**
 * Set die page with Cleantalk comment.
 * @global type $ct_comment
    $err_text = '<center><b style="color: #49C73B;">Clean</b><b style="color: #349ebf;">Talk.</b> ' . __('Spam protection', 'cleantalk') . "</center><br><br>\n" . $ct_comment;
 * @param type $comment_status
 */
function ct_die($comment_id, $comment_status) {
    global $ct_comment;
    $err_text = '<center><b style="color: #49C73B;">Clean</b><b style="color: #349ebf;">Talk.</b> ' . __('Spam protection', 'cleantalk') . "</center><br><br>\n" . $ct_comment;
        $err_text .= '<script>setTimeout("history.back()", 5000);</script>';
        if(isset($_POST['et_pb_contact_email']))
        {
        	$mes='<div id="et_pb_contact_form_1" class="et_pb_contact_form_container clearfix"><h1 class="et_pb_contact_main_title">Blacklisted</h1><div class="et-pb-contact-message"><p>'.$ct_comment.'</p></div></div>';
        	wp_die($mes, 'Blacklisted', array('back_link' => true,'response'=>200));
        }
        else
        {
        	wp_die($err_text, 'Blacklisted', array('back_link' => true));
        }
}

/**
 * Set die page with Cleantalk comment from parameter.
 * @param type $comment_body
 */
function ct_die_extended($comment_body) {
    $err_text = '<center><b style="color: #49C73B;">Clean</b><b style="color: #349ebf;">Talk.</b> ' . __('Spam protection', 'cleantalk') . "</center><br><br>\n" . $comment_body;
        $err_text .= '<script>setTimeout("history.back()", 5000);</script>';
        wp_die($err_text, 'Blacklisted', array('back_link' => true));
}

/**
 * Validates JavaScript anti-spam test
 *
 */
function js_test($field_name = 'ct_checkjs', $data = null, $random_key = false) {
    global $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    $checkjs = null;
    $js_post_value = null;
    
    if (!$data)
        return $checkjs;

    if (isset($data[$field_name])) {
	    $js_post_value = $data[$field_name];

        //
        // Random key check
        //
        if ($random_key) {
            
            $keys = $ct_data['js_keys'];
            if (isset($keys[$js_post_value])) {
                $checkjs = 1;
            } else {
                $checkjs = 0; 
            }
        } else {
            $ct_challenge = ct_get_checkjs_value();
            
            if(preg_match("/$ct_challenge/", $js_post_value)) {
                $checkjs = 1;
            } else {
                $checkjs = 0; 
            }
        }
        

    }

    return $checkjs;
}

/**
 * Get post url 
 * @param int $comment_id 
 * @param int $comment_post_id
 * @return string|bool
 */
function ct_post_url($comment_id = null, $comment_post_id) {

    if (empty($comment_post_id))
	return null;

    if ($comment_id === null) {
	    $last_comment = get_comments('number=1');
	    $comment_id = isset($last_comment[0]->comment_ID) ? (int) $last_comment[0]->comment_ID + 1 : 1;
    }
    $permalink = get_permalink($comment_post_id);

    $post_url = null;
    if ($permalink !== null)
	$post_url = $permalink . '#comment-' . $comment_id;

    return $post_url;
}

/**
 * Public filter 'pre_comment_approved' - Mark comment unapproved always
 * @return 	int Zero
 */
function ct_set_not_approved() {
    return 0;
}

/**
 * @author Artem Leontiev
 * Public filter 'pre_comment_approved' - Mark comment approved if it's not 'spam' only
 * @return 	int 1
 */
function ct_set_approved($approved, $comment) {
    if ($approved == 'spam'){
        return $approved;
    } else {
        return 1;
    }
}

/**
 * Public filter 'pre_comment_approved' - Mark comment unapproved always
 * @return 	int Zero
 */
function ct_set_comment_spam() {
    return 'spam';
}

/**
 * Public action 'comment_post' - Store cleantalk hash in comment meta 'ct_hash'
 * @param	int $comment_id Comment ID
 * @param	mixed $comment_status Approval status ("spam", or 0/1), not used
 */
function ct_set_meta($comment_id, $comment_status) {
    global $comment_post_id;
    $hash1 = ct_hash();
    if (!empty($hash1)) {
        update_comment_meta($comment_id, 'ct_hash', $hash1);
        if (function_exists('base64_encode') && isset($comment_status) && $comment_status != 'spam') {
			$post_url = ct_post_url($comment_id, $comment_post_id);
			$post_url = base64_encode($post_url);
			if ($post_url === false)
			return false;
			// 01 - URL to approved comment
			$feedback_request = $hash1 . ':' . '01' . ':' . $post_url . ';';
			ct_send_feedback($feedback_request);
		}
    }
    return true;
}

/**
 * Mark bad words
 * @global string $ct_stop_words
 * @param int $comment_id
 * @param int $comment_status Not use
 */
function ct_mark_red($comment_id, $comment_status) {
    global $ct_stop_words;

    $comment = get_comment($comment_id, 'ARRAY_A');
    $message = $comment['comment_content'];
    foreach (explode(':', $ct_stop_words) as $word) {
        $message = preg_replace("/($word)/ui", '<font rel="cleantalk" color="#FF1000">' . "$1" . '</font>', $message);

    }
    $comment['comment_content'] = $message;
    kses_remove_filters();
    wp_update_comment($comment);
}

//
//Send post to trash
//
function ct_wp_trash_comment($comment_id, $comment_status){
	wp_trash_comment($comment_id);
}

/**
	* Tests plugin activation status
	* @return bool 
*/
function ct_plugin_active($plugin_name){
	foreach (get_option('active_plugins') as $k => $v) {
	    if ($plugin_name == $v)
		    return true;
	}
	return false;
}

/**
 * Insert a hidden field to registration form
 * @return null
 */
function ct_register_form() {
    global $ct_checkjs_register_form, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if ($ct_options['registrations_test'] == 0) {
        return false;
    }

    ct_add_hidden_fields(true, $ct_checkjs_register_form, false);
    ct_add_mouse_tracking(false);
    ct_setup_page_timer();

    return null;
}

/**
 * Adds notification text to login form - to inform about approced registration
 * @return null
 */
function ct_login_message($message) {
    global $errors, $ct_session_register_ok_label, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if ($ct_options['registrations_test'] != 0) {
        ct_init_session();

        if( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] ) {
	    if (isset($_SESSION[$ct_session_register_ok_label])) {
		unset($_SESSION[$ct_session_register_ok_label]);
		if(is_wp_error($errors))
		    $errors->add('ct_message','<br />' . sprintf(__('Registration is approved by %s.', 'cleantalk'), '<b style="color: #49C73B;">Clean</b><b style="color: #349ebf;">Talk</b>'), 'message');
	    }
        }
    }
    return $message;
}

/**
 * Test users registration for pPress
 * @return array with errors 
 */
function ct_registration_errors_ppress($reg_errors, $form_id) {
    
	$email = $_POST['reg_email'];
	$login = $_POST['reg_username'];
	
	$reg_errors = ct_registration_errors($reg_errors, $login, $email);
	        
    return $reg_errors;
}

/**
 * Test users registration for multisite enviroment
 * @return array with errors 
 */
function ct_registration_errors_wpmu($errors) {
    global $ct_signup_done;
    
    //
    // Multisite actions
    //
    $sanitized_user_login = null;
    if (isset($errors['user_name'])) {
        $sanitized_user_login = $errors['user_name']; 
        $wpmu = true;
    }
    $user_email = null;
    if (isset($errors['user_email'])) {
        $user_email = $errors['user_email'];
        $wpmu = true;
    }
    
    if ($wpmu && isset($errors['errors']->errors) && count($errors['errors']->errors) > 0) {
        return $errors;
    }
    
    $errors['errors'] = ct_registration_errors($errors['errors'], $sanitized_user_login, $user_email);

    // Show CleanTalk errors in user_name field
    if (isset($errors['errors']->errors['ct_error'])) {
        $errors['errors']->errors['user_name'] = $errors['errors']->errors['ct_error']; 
        unset($errors['errors']->errors['ct_error']);
     }
    
    return $errors;
}

/**
 *  Shell for action register_post 
 * @return array with errors 
 */
function ct_register_post($sanitized_user_login = null, $user_email = null, $errors) {
    return ct_registration_errors($errors, $sanitized_user_login, $user_email);
}

/**
 * Check messages for external plugins
 * @return array with checking result;
 */

function ct_test_message($nickname, $email, $ip, $text){
	$checkjs = js_test('ct_checkjs', $_COOKIE, true);
  
    $post_info['comment_type'] = 'feedback_plugin_check';
    $post_info = json_encode($post_info);
    
    $ct_base_call_result = ct_base_call(array(
        'message' => $text,
        'example' => null,
        'sender_email' => $email,
        'sender_nickname' => $nickname,
        'post_info' => $post_info,
	    'sender_info' => get_sender_info(),
        'checkjs' => $checkjs
    ));
    
    $ct_result = $ct_base_call_result['ct_result'];
    
    $result=Array(
        'allow' => $ct_result->allow,
        'comment' => $ct_result->comment,
    );
    return $result;
}

/**
 * Check registrations for external plugins
 * @return array with checking result;
 */
function ct_test_registration($nickname, $email, $ip){
    global $ct_checkjs_register_form, $ct_agent_version, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();
    
    $submit_time = submit_time_test();
    
    $sender_info = get_sender_info();
    
    $checkjs=0;

    $checkjs = js_test($ct_checkjs_register_form, $_POST, true);
    $sender_info['post_checkjs_passed'] = $checkjs;
   
    //
    // This hack can be helpfull when plugin uses with untested themes&signups plugins.
    //
    if ($checkjs == 0) {
        $checkjs = js_test('ct_checkjs', $_COOKIE, true);
        $sender_info['cookie_checkjs_passed'] = $checkjs;
    }

    $sender_info = json_encode($sender_info);
    if ($sender_info === false) {
        $sender_info= '';
    }
 
    require_once('cleantalk.class.php');
    $config = ct_get_server();
    $ct = new Cleantalk();
    $ct->work_url = $config['ct_work_url'];
    $ct->server_url = $ct_options['server'];

    $ct->server_ttl = $config['ct_server_ttl'];
    $ct->server_changed = $config['ct_server_changed'];
    $ct->ssl_on = $ct_options['ssl_on'];
    
    $ct_request = new CleantalkRequest();
    $ct_request->auth_key = $ct_options['apikey'];
    $ct_request->sender_email = $email; 
    $ct_request->sender_ip = $ip;
    $ct_request->sender_nickname = $nickname; 
    $ct_request->agent = $ct_agent_version; 
    $ct_request->sender_info = $sender_info;
    $ct_request->js_on = $checkjs;
    $ct_request->submit_time = $submit_time; 
    
    $ct_result = $ct->isAllowUser($ct_request);
    
    $ct_result = ct_change_plugin_resonse($ct_result, $checkjs);
    
    ct_add_event($ct_result->allow);
    
    $result=Array(
        'allow' => $ct_result->allow,
        'comment' => $ct_result->comment,
    );
    return $result;
}

/**
 * Test users registration
 * @return array with errors 
 */
function ct_registration_errors($errors, $sanitized_user_login = null, $user_email = null) {
    global $ct_agent_version, $ct_checkjs_register_form, $ct_session_request_id_label, $ct_session_register_ok_label, $bp, $ct_signup_done, $ct_formtime_label, $ct_negative_comment, $ct_options, $ct_data, $ct_registration_error_comment;
    	
    $ct_options=ct_get_options();
	$ct_data=ct_get_data();
	
    // Go out if a registrered user action
    if (ct_is_user_enable() === false) {
        return $errors;
    }

    if ($ct_options['registrations_test'] == 0) {
        return $errors;
    }

    //
    // The function already executed
    // It happens when used ct_register_post(); 
    //
    if ($ct_signup_done && is_object($errors) && count($errors->errors) > 0) {
        return $errors;
    }

    //
    // BuddyPress actions
    //
    $buddypress = false;
    if ($sanitized_user_login === null && isset($_POST['signup_username'])) {
        $sanitized_user_login = $_POST['signup_username'];
        $buddypress = true;
    }
    if ($user_email === null && isset($_POST['signup_email'])) {
        $user_email = $_POST['signup_email'];
        $buddypress = true;
    }
    
    //
    // Break tests because we already have servers response
    //
    if ($buddypress && $ct_signup_done) {
        if ($ct_negative_comment) {
            $bp->signup->errors['signup_username'] = $ct_negative_comment;
        }
        return $errors;
    }

    $submit_time = submit_time_test();

    $sender_info = get_sender_info();
    
    $checkjs=0;

    $checkjs = js_test($ct_checkjs_register_form, $_POST, true);
    $sender_info['post_checkjs_passed'] = $checkjs;
    //
    // This hack can be helpfull when plugin uses with untested themes&signups plugins.
    //
    if ($checkjs == 0) {
        $checkjs = js_test('ct_checkjs', $_COOKIE, true);
        $sender_info['cookie_checkjs_passed'] = $checkjs;
    }

	// Pointer data
	$pointer_data = isset($_COOKIE['ct_pointer_data']) ? json_decode($_COOKIE['ct_pointer_data']) : 0;
	
	// Timezone from JS
	$js_timezone = isset($_COOKIE['ct_timezone']) ? $_COOKIE['ct_timezone'] : 0;

	//First key down timestamp
	$first_key_press_timestamp = isset($_COOKIE['ct_fkp_timestamp']) ? $_COOKIE['ct_fkp_timestamp'] : 0;
	$page_set_timestamp = (isset($_COOKIE['ct_ps_timestamp']) ? $_COOKIE['ct_ps_timestamp'] : 0);
		
	$sender_info['mouse_cursor_positions'] = $pointer_data;
	$sender_info['js_timezone'] = $js_timezone;
	$sender_info['key_press_timestamp'] = $first_key_press_timestamp;
	$sender_info['page_set_timestamp'] = $page_set_timestamp;
	
    $sender_info = json_encode($sender_info);
    if ($sender_info === false) {
        $sender_info= '';
    }

    require_once('cleantalk.class.php');
    $config = ct_get_server();
    $ct = new Cleantalk();
    $ct->work_url = $config['ct_work_url'];
    $ct->server_url = $ct_options['server'];

    $ct->server_ttl = $config['ct_server_ttl'];
    $ct->server_changed = $config['ct_server_changed'];
    $ct->ssl_on = $ct_options['ssl_on'];
    
    $ct_request = new CleantalkRequest();
    $ct_request->auth_key = $ct_options['apikey'];
    $ct_request->sender_email = $user_email; 
    $ct_request->sender_ip = $ct->ct_session_ip($_SERVER['REMOTE_ADDR']);
    $ct_request->sender_nickname = $sanitized_user_login; 
    $ct_request->agent = $ct_agent_version; 
    $ct_request->sender_info = $sender_info;
    $ct_request->js_on = $checkjs;
    $ct_request->submit_time = $submit_time; 
	
    $ct_result = $ct->isAllowUser($ct_request);
    if ($ct->server_change) {
        update_option(
                'cleantalk_server', array(
                'ct_work_url' => $ct->work_url,
                'ct_server_ttl' => $ct->server_ttl,
                'ct_server_changed' => time()
                )
        );
    }
	
    $ct_signup_done = true;

    $ct_result = ct_change_plugin_resonse($ct_result, $checkjs);
    
    if ($ct_result->inactive != 0) {
        ct_send_error_notice($ct_result->comment);
        return $errors;
    }

    ct_init_session();

    if ($ct_result->allow == 0) {
        
        // Restart submit form counter for failed requests
        $_SESSION[$ct_formtime_label] = time();
        		
        if ($buddypress === true) {
            $bp->signup->errors['signup_username'] = $ct_result->comment;
        }else{
			if(is_wp_error($errors))
				$errors->add('ct_error', $ct_result->comment);
				$ct_negative_comment = $ct_result->comment;
        }
		
		$ct_registration_error_comment = $ct_result->comment;
		
    } else {
        if ($ct_result->id !== null) {
            $_SESSION[$ct_session_request_id_label] = $ct_result->id;
            $_SESSION[$ct_session_register_ok_label] = $ct_result->id;
        }
    }
    		
    ct_add_event($ct_result->allow);

    return $errors;
}

/**
 * Checks registration error and set it if it was dropped
 * @return errors 
 */
function ct_check_registration_erros($errors, $sanitized_user_login = null, $user_email = null) {
	global $bp, $ct_registration_error_comment;
	
	if($ct_registration_error_comment){
		
		if(isset($bp))
			if(method_exists($bp, 'signup'))
				if(method_exists($bp->signup, 'errors'))
					if(isset($bp->signup->errors['signup_username']))
						if($bp->signup->errors['signup_username'] != $ct_registration_error_comment)
							$bp->signup->errors['signup_username'] = $ct_registration_error_comment;
							
		if(isset($errors))
			if(method_exists($errors, 'errors'))
				if(isset($errors->errors['ct_error']))
					if($errors->errors['ct_error'][0] != $ct_registration_error_comment)
						$errors->add('ct_error', $ct_registration_error_comment);
				
	}
	return $errors;
}

/**
 * Set user meta 
 * @return null 
 */
function ct_user_register($user_id) {
    global $ct_session_request_id_label;
    
    ct_init_session();

    if (isset($_SESSION[$ct_session_request_id_label])) {
        update_user_meta($user_id, 'ct_hash', $_SESSION[$ct_session_request_id_label]);
	unset($_SESSION[$ct_session_request_id_label]);
    }
}


/**
 * Test for JetPack contact form 
 */
function ct_grunion_contact_form_field_html($r, $field_label) {
    global $ct_checkjs_jpcf, $ct_jpcf_patched, $ct_jpcf_fields, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if ($ct_options['contact_forms_test'] == 1 && $ct_jpcf_patched === false && preg_match("/[text|email]/i", $r)) {

        // Looking for element name prefix
        $name_patched = false;
        foreach ($ct_jpcf_fields as $v) {
            if ($name_patched === false && preg_match("/(g\d-)$v/", $r, $matches)) {
                $ct_checkjs_jpcf = $matches[1] . $ct_checkjs_jpcf;
                $name_patched = true;
            }
        }

        $r .= ct_add_hidden_fields(true, $ct_checkjs_jpcf, true);
        $ct_jpcf_patched = true;
    
        ct_setup_page_timer();
    }

    return $r;
}
/**
 * Test for JetPack contact form 
 */
function ct_contact_form_is_spam($form) {
    global $ct_checkjs_jpcf, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if ($ct_options['contact_forms_test'] == 0) {
        return null;
    }

    $js_field_name = $ct_checkjs_jpcf;
    foreach ($_POST as $k => $v) {
        if (preg_match("/^.+$ct_checkjs_jpcf$/", $k))
           $js_field_name = $k; 
    }
    
    $checkjs = js_test($js_field_name, $_POST, true);

    $sender_info = array(
	'sender_url' => @$form['comment_author_url']
    );

    $post_info['comment_type'] = 'feedback';
    $post_info = json_encode($post_info);
    if ($post_info === false)
        $post_info = '';

    $sender_email = null;
    $sender_nickname = null;
    $message = '';
    if (isset($form['comment_author_email']))
        $sender_email = $form['comment_author_email']; 

    if (isset($form['comment_author']))
        $sender_nickname = $form['comment_author']; 

    if (isset($form['comment_content']))
        $message = $form['comment_content']; 

    $ct_base_call_result = ct_base_call(array(
        'message' => $message,
        'example' => null,
        'sender_email' => $sender_email,
        'sender_nickname' => $sender_nickname,
        'post_info' => $post_info,
	'sender_info' => $sender_info,
        'checkjs' => $checkjs
    ));
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];

    if ($ct_result->allow == 0) {
        global $ct_comment;
        $ct_comment = $ct_result->comment;
        ct_die(null, null);
        exit;
    }

    return (bool) !$ct_result->allow;
}

function ct_contact_form_is_spam_jetpack($is_spam,$form) {
    global $ct_checkjs_jpcf, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if ($ct_options['contact_forms_test'] == 0) {
        return null;
    }

    $js_field_name = $ct_checkjs_jpcf;
    foreach ($_POST as $k => $v) {
        if (preg_match("/^.+$ct_checkjs_jpcf$/", $k))
           $js_field_name = $k; 
    }
    
    $checkjs = js_test($js_field_name, $_POST, true);

    $sender_info = array(
	'sender_url' => @$form['comment_author_url']
    );

    $post_info['comment_type'] = 'feedback';
    $post_info = json_encode($post_info);
    if ($post_info === false)
        $post_info = '';

    $sender_email = null;
    $sender_nickname = null;
    $message = '';
    if (isset($form['comment_author_email']))
        $sender_email = $form['comment_author_email']; 

    if (isset($form['comment_author']))
        $sender_nickname = $form['comment_author']; 

    if (isset($form['comment_content']))
        $message = $form['comment_content']; 

    $ct_base_call_result = ct_base_call(array(
        'message' => $message,
        'example' => null,
        'sender_email' => $sender_email,
        'sender_nickname' => $sender_nickname,
        'post_info' => $post_info,
	'sender_info' => $sender_info,
        'checkjs' => $checkjs
    ));
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];

    if ($ct_result->allow == 0) {
        global $ct_comment;
        $ct_comment = $ct_result->comment;
        ct_die(null, null);
        exit;
    }

    return (bool) !$ct_result->allow;
}



/**
 * Inserts anti-spam hidden to CF7
 */
function ct_wpcf7_form_elements($html) {
    global $wpdb, $current_user, $ct_checkjs_cf7, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if ($ct_options['contact_forms_test'] == 0) {
        return $html;
    }

    $html .= ct_add_hidden_fields(true, $ct_checkjs_cf7, true);
    
    ct_setup_page_timer();

    return $html;
}

/**
 * Test CF7 message for spam
 */
function ct_wpcf7_spam($param) {
    global $wpdb, $current_user, $ct_agent_version, $ct_checkjs_cf7, $ct_cf7_comment, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if (WPCF7_VERSION >= '3.0.0') {
	if($param === true)
    	    return $param;
    }else{
	if($param == false)
    	    return $param;
    }

    if ($ct_options['contact_forms_test'] == 0) {
        return $param;
    }
    
    // Skip processing for logged in users.
    if ($ct_options['protect_logged_in'] != 1 && is_user_logged_in()) {
        return $param;
    }
 
    $checkjs = js_test('ct_checkjs', $_COOKIE, true);
    if($checkjs != 1){
        $checkjs = js_test($ct_checkjs_cf7, $_POST, true);
    }

    $post_info['comment_type'] = 'feedback';
    $post_info = json_encode($post_info);
    if ($post_info === false)
        $post_info = '';

    $sender_email = null;
    $sender_nickname = null;
    $message = '';
    $subject = '';
    foreach ($_POST as $k => $v) {
    	if(is_array($v))
    	{
    		continue;
    	}
        if ($sender_email === null && preg_match("/^\S+@\S+\.\S+$/", $v)) {
            $sender_email = $v;
        }
        else if ($sender_nickname === null && preg_match("/-name$/", $k)) {
            $sender_nickname = $v;
        }
        else if ($subject === '' && ct_get_data_from_submit($k, 'subject')) {
            $subject = $v;
        }
        else if (preg_match("/(\-message|\w*message\w*|contact|comment|contact\-)$/", $k))
        {
            $message.= $v."\n";
        }

    }

    if ($subject != '') {
        if ($message != '') {
            $message = "\n\n" . $message;    
        }
        $message = sprintf("%s%s", $subject, $message);
    }

    $ct_base_call_result = ct_base_call(array(
        'message' => $message,
        'example' => null,
        'sender_email' => $sender_email,
        'sender_nickname' => $sender_nickname,
        'post_info' => $post_info,
        'checkjs' => $checkjs
    ));
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];
   
    if ($ct_result->allow == 0) {
	
		if (WPCF7_VERSION >= '3.0.0')
			$param = true;
		else
			$param = false;
		
			$ct_cf7_comment = $ct_result->comment;
			add_filter('wpcf7_display_message', 'ct_wpcf7_display_message', 10, 2);
    }

    return $param;
}

/**
 * Changes CF7 status message 
 * @param 	string $hook URL of hooked page
 */
function ct_wpcf7_display_message($message, $status = 'spam') {
    global $ct_cf7_comment;

    if ($status == 'spam') {
        $message = $ct_cf7_comment; 
    }

    return $message;
}

/**
 * Inserts anti-spam hidden to Fast Secure contact form
 */
function ct_si_contact_display_after_fields($string = '', $style = '', $form_errors = array(), $form_id_num = 0) {
    $string .= ct_add_hidden_fields(true, 'ct_checkjs', true);
    
    ct_setup_page_timer();

    return $string;
}

/**
 * Test for Fast Secure contact form
 */
function ct_si_contact_form_validate($form_errors = array(), $form_id_num = 0) {
    global $ct_options, $ct_data, $cleantalk_executed;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if (!empty($form_errors))
	return $form_errors;

    if ($ct_options['contact_forms_test'] == 0)
	return $form_errors;

    // Skip processing because data already processed.
    if ($cleantalk_executed) {
	    return $form_errors;
    }


	$sender_info='';

    $checkjs = js_test('ct_checkjs', $_POST, true);

    $post_info['comment_type'] = 'feedback';
    $post_info = json_encode($post_info);
    if ($post_info === false)
        $post_info = '';

	//getting info from custom fields
	$ct_temp_msg_data = ct_get_fields_any($_POST);
	
    $sender_email = ($ct_temp_msg_data['email'] ? $ct_temp_msg_data['email'] : '');
    $sender_nickname = ($ct_temp_msg_data['nickname'] ? $ct_temp_msg_data['nickname'] : '');
    $subject = ($ct_temp_msg_data['subject'] ? $ct_temp_msg_data['subject'] : '');
    $contact_form = ($ct_temp_msg_data['contact'] ? $ct_temp_msg_data['contact'] : true);
    $message = ($ct_temp_msg_data['message'] ? $ct_temp_msg_data['message'] : array());
	
	//setting fields if they with defaults names
    if ($subject != '') {
        $message = array_merge(array('subject' => $subject), $message);
    }
    $message = json_encode($message);


    $ct_base_call_result = ct_base_call(array(
        'message' => $message,
        'example' => null,
        'sender_email' => $sender_email,
        'sender_nickname' => $sender_nickname,
        'post_info' => $post_info,
	    'sender_info' => $sender_info,
        'checkjs' => $checkjs
    ));
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];
    
    $cleantalk_executed = true;

    if ($ct_result->allow == 0) {
        global $ct_comment;
        $ct_comment = $ct_result->comment;
        ct_die(null, null);
        exit;
    }

    return $form_errors;
}

/**
 * Notice for commentators which comment has automatically approved by plugin 
 * @param 	string $hook URL of hooked page
 */
function ct_comment_text($comment_text) {
    global $comment, $ct_approved_request_id_label;

    if (isset($_COOKIE[$ct_approved_request_id_label]) && isset($comment->comment_ID)) {
        $ct_hash = get_comment_meta($comment->comment_ID, 'ct_hash', true);

        if ($ct_hash !== '' && $_COOKIE[$ct_approved_request_id_label] == $ct_hash) {
            $comment_text .= '<br /><br /> <em class="comment-awaiting-moderation">' . __('Comment approved. Anti-spam by CleanTalk.', 'cleantalk') . '</em>'; 
        }
    }

    return $comment_text;
}


/**
 * Checks WordPress Landing Pages raw $_POST values
*/
function ct_check_wplp(){
    global $ct_wplp_result_label, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();
    if (!isset($_COOKIE[$ct_wplp_result_label])) {
        // First AJAX submit of WPLP form
        if ($ct_options['contact_forms_test'] == 0)
                return;

        $checkjs = js_test('ct_checkjs', $_COOKIE, true);

        $post_info['comment_type'] = 'feedback';
        $post_info = json_encode($post_info);
        if ($post_info === false)
            $post_info = '';

        $sender_email = '';
        foreach ($_POST as $v) {
            if (preg_match("/^\S+@\S+\.\S+$/", $v)) {
                $sender_email = $v;
                break;
            }
        }

        $message = '';
        if(array_key_exists('form_input_values', $_POST)){
            $form_input_values = json_decode(stripslashes($_POST['form_input_values']), true);
            if (is_array($form_input_values) && array_key_exists('null', $form_input_values))
                $message = $form_input_values['null'];
        } else if (array_key_exists('null', $_POST)) {
            $message = $_POST['null'];
        }

        $ct_base_call_result = ct_base_call(array(
                'message' => $message,
                'example' => null,
                'sender_email' => $sender_email,
                'sender_nickname' => null,
                'post_info' => $post_info,
                'checkjs' => $checkjs
        ));
        $ct = $ct_base_call_result['ct'];
        $ct_result = $ct_base_call_result['ct_result'];

        if ($ct_result->allow == 0) {
            $cleantalk_comment = $ct_result->comment;
        } else {
            $cleantalk_comment = 'OK';
        }

        setcookie($ct_wplp_result_label, $cleantalk_comment, strtotime("+5 seconds"), '/');
    } else {
        // Next POST/AJAX submit(s) of same WPLP form
        $cleantalk_comment = $_COOKIE[$ct_wplp_result_label];
    }
    if ($cleantalk_comment !== 'OK')
        ct_die_extended($cleantalk_comment);
}

/**
 * Places a hidding field to Gravity.
 * @return string 
 */
function ct_gforms_hidden_field ( $form_string, $form ) {
    $ct_hidden_field = 'ct_checkjs';

    // Do not add a hidden field twice.
    if (preg_match("/$ct_hidden_field/", $form_string)) {
        return $form_string;
    }

    $search = "</form>";
    $js_code = ct_add_hidden_fields(true, $ct_hidden_field, true, false);
    $form_string = str_replace($search, $js_code . $search, $form_string);
    
    ct_setup_page_timer();

    return $form_string;
}

/**
 * Gravity forms anti-spam test.
 * @return boolean
 */
function ct_gforms_spam_test ($is_spam, $form, $entry) {
    global $ct_options, $ct_data, $cleantalk_executed;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();

    if ($is_spam) {
	    return $is_spam;
    }

    if ($ct_options['contact_forms_test'] == 0) {
	    return $is_spam;
    }
	
    // Return unchanged result if the submission was already tested.
    if ($cleantalk_executed) {
	    return $is_spam;
    }
    
    $sender_info='';

    $checkjs = js_test('ct_checkjs', $_COOKIE, true);
    if (!$checkjs) {
        $checkjs = js_test('ct_checkjs', $_POST, true);
    }
    
    $post_info['comment_type'] = 'feedback_gravity';
    $post_info = json_encode($post_info);
    if ($post_info === false)
        $post_info = '';
	
	$ct_temp = array();
	foreach($entry as $key => $value){
		if(is_numeric($key))
			$ct_temp[$key]=$value;
	} unset($key, $value);
		
	$ct_temp_msg_data = ct_get_fields_any($ct_temp);
	
    $sender_email = ($ct_temp_msg_data['email'] ? $ct_temp_msg_data['email'] : '');
    $sender_nickname = ($ct_temp_msg_data['nickname'] ? $ct_temp_msg_data['nickname'] : '');
    $subject = ($ct_temp_msg_data['subject'] ? $ct_temp_msg_data['subject'] : '');
    $contact_form = ($ct_temp_msg_data['contact'] ? $ct_temp_msg_data['contact'] : true);
    $message = ($ct_temp_msg_data['message'] ? $ct_temp_msg_data['message'] : array());
	
    if ($subject != '') {
        $message = array_merge(array('subject' => $subject), $message);
    }
    $message = json_encode($message);

    $ct_base_call_result = ct_base_call(array(
        'message' => $message,
        'example' => null,
        'sender_email' => $sender_email,
        'sender_nickname' => $sender_nickname,
        'post_info' => $post_info,
	    'sender_info' => $sender_info,
        'checkjs' => $checkjs
    ));
    $ct_result = $ct_base_call_result['ct_result'];

    if ($ct_result->allow == 0) {
        $is_spam = true;
        //wp_die("<h1>Spam Protection by CleanTalk</h1><h2>".$ct_result->comment."</h2>", '', array('response' => 403, "back_link" => true, "text_direction" => 'ltr'));
    }

    return $is_spam;
}

/**
 * Test S2member registration
 * @return array with errors 
 */
function ct_s2member_registration_test() {
    global $ct_agent_version, $ct_post_data_label, $ct_post_data_authnet_label, $ct_formtime_label, $ct_options, $ct_data;
    
    $ct_options = ct_get_options();
    $ct_data = ct_get_data();
    
    if ($ct_options['registrations_test'] == 0) {
        return null;
    }
    
    $submit_time = submit_time_test();

    $checkjs = js_test('ct_checkjs', $_COOKIE, true);

    require_once('cleantalk.class.php');
    
    $sender_info = get_sender_info();
    $sender_info = json_encode($sender_info);
    if ($sender_info === false) {
        $sender_info= '';
    }
    
    $sender_email = null;
    if (isset($_POST[$ct_post_data_label]['email']))
        $sender_email = $_POST[$ct_post_data_label]['email'];
    
    if (isset($_POST[$ct_post_data_authnet_label]['email']))
        $sender_email = $_POST[$ct_post_data_authnet_label]['email'];

    $sender_nickname = null;
    if (isset($_POST[$ct_post_data_label]['username']))
        $sender_nickname = $_POST[$ct_post_data_label]['username'];
    
    if (isset($_POST[$ct_post_data_authnet_label]['username']))
        $sender_nickname = $_POST[$ct_post_data_authnet_label]['username'];

    $config = ct_get_server();

    $ct = new Cleantalk();
    $ct->work_url = $config['ct_work_url'];
    $ct->server_url = $ct_options['server'];
    $ct->server_ttl = $config['ct_server_ttl'];
    $ct->server_changed = $config['ct_server_changed'];
    $ct->ssl_on = $ct_options['ssl_on'];

    $ct_request = new CleantalkRequest();

    $ct_request->auth_key = $ct_options['apikey'];
    $ct_request->sender_email = $sender_email; 
    $ct_request->sender_ip = $ct->ct_session_ip($_SERVER['REMOTE_ADDR']);
    $ct_request->sender_nickname = $sender_nickname; 
    $ct_request->agent = $ct_agent_version; 
    $ct_request->sender_info = $sender_info;
    $ct_request->js_on = $checkjs;
    $ct_request->submit_time = $submit_time; 

    $ct_result = $ct->isAllowUser($ct_request);
    if ($ct->server_change) {
        update_option(
                'cleantalk_server', array(
                'ct_work_url' => $ct->work_url,
                'ct_server_ttl' => $ct->server_ttl,
                'ct_server_changed' => time()
                )
        );
    }
    
    $ct_result = ct_change_plugin_resonse($ct_result, $checkjs);
    
    ct_add_event($ct_result->allow);
    
    // Restart submit form counter for failed requests
    if ($ct_result->allow == 0) {
        ct_init_session();
        $_SESSION[$ct_formtime_label] = time();
    }

    if ($ct_result->allow == 0) {
        ct_die_extended($ct_result->comment);
    }

    return true;
}

/**
 * General test for any contact form
 */
function ct_contact_form_validate() {
	global $pagenow,$cleantalk_executed, $cleantalk_url_exclusions,$ct_options, $ct_data, $ct_checkjs_frm;

    $ct_options = ct_get_options();
    $ct_data = ct_get_data();
	
	if($cleantalk_executed)
	{
		return null;
	}
	if(isset($cleantalk_url_exclusions))
	{
		$ct_cnt=sizeof($cleantalk_url_exclusions);
	}
	else
	{
		$ct_cnt=0;
	}
	//@header("CtExclusions: ".$ct_cnt);
	cleantalk_debug("CtExclusions", $ct_cnt);

    if (@sizeof($_POST)==0 ||
    	(isset($_POST['signup_username']) && isset($_POST['signup_email']) && isset($_POST['signup_password'])) ||
        (isset($pagenow) && $pagenow == 'wp-login.php') || // WordPress log in form
        (isset($pagenow) && $pagenow == 'wp-login.php' && isset($_GET['action']) && $_GET['action']=='lostpassword') ||
        (strpos($_SERVER['REQUEST_URI'],'/wp-admin/')!== false && (empty($_POST['your-phone']) && empty($_POST['your-email']) && empty($_POST['your-message']))) || //Bitrix24 Contact
        strpos($_SERVER['REQUEST_URI'],'wp-login.php')!==false||
        strpos($_SERVER['REQUEST_URI'],'wp-comments-post.php')!==false ||
        (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],'/wp-admin/') !== false) ||
        strpos($_SERVER['REQUEST_URI'],'/login/')!==false||
        isset($_GET['ptype']) && $_GET['ptype']=='login' ||
        check_url_exclusions() ||
        ct_check_array_keys($_POST) ||
        isset($_POST['ct_checkjs_register_form']) ||
        (isset($_POST['signup_username']) && isset($_POST['signup_password_confirm']) && isset($_POST['signup_submit']) ) ||
        @intval($ct_options['general_contact_forms_test'])==0 ||
        isset($_POST['bbp_topic_content']) ||
        isset($_POST['bbp_reply_content']) ||
        isset($_POST['fscf_submitted']) ||
        strpos($_SERVER['REQUEST_URI'],'/wc-api/')!==false ||
        isset($_POST['log']) && isset($_POST['pwd']) && isset($_POST['wp-submit']) ||
        isset($_POST[$ct_checkjs_frm]) && (@intval($ct_options['contact_forms_test']) == 1) ||// Formidable forms
        isset($_POST['comment_post_ID']) || // The comment form 
        isset($_GET['for']) ||
		(isset($_POST['log'], $_POST['pwd'])) || //WooCommerce Sensei login form fix
        (isset($_POST['_wpcf7'], $_POST['_wpcf7_version'], $_POST['_wpcf7_locale'])) || //CF7 fix) 
		(isset($_POST['hash'], $_POST['device_unique_id'], $_POST['device_name'])) ||//Mobile Assistant Connector fix
		isset($_POST['gform_submit']) || //Gravity form
		(isset($_POST['wc_reset_password'], $_POST['_wpnonce'], $_POST['_wp_http_referer'])) || //WooCommerce recovery password form
		(isset($_POST['woocommerce-login-nonce'], $_POST['login'], $_POST['password'], $_POST['_wp_http_referer'])) || //WooCommerce login form
		(isset($_POST['ccf_form']) && intval($_POST['ccf_form']) == 1)
		) {
        return null;
    }

    // Do not execute anti-spam test for logged in users.
    if (isset($_COOKIE[LOGGED_IN_COOKIE]) && $ct_options['protect_logged_in'] != 1) {
        return null;
    }
	
	//Skip the test if the checkout setting is unset && and it's not WooCommerce
	if($ct_options['wc_checkout_test'] == 0 && strpos($_SERVER['REQUEST_URI'],'wc-ajax=checkout') && strpos($_POST['_wp_http_referer'],'wc-ajax=update_order_review'))
		return null;

    //@header("CtConditions: Passed");
    cleantalk_debug("CtConditions", "Passed");

    $_POST=ct_filter_array($_POST);
    //@header("CtFilterArray: Passed");
    cleantalk_debug("CtFilterArray", "Passed");

    $checkjs = js_test('ct_checkjs', $_COOKIE, true);
  
    $post_info['comment_type'] = 'feedback_general_contact_form';
    $post_info = json_encode($post_info);
    if ($post_info === false) {
        $post_info = '';
    }

	$ct_temp_msg_data = ct_get_fields_any($_POST);
	
    $sender_email = ($ct_temp_msg_data['email'] ? $ct_temp_msg_data['email'] : '');
    $sender_nickname = ($ct_temp_msg_data['nickname'] ? $ct_temp_msg_data['nickname'] : '');
    $subject = ($ct_temp_msg_data['subject'] ? $ct_temp_msg_data['subject'] : '');
    $contact_form = ($ct_temp_msg_data['contact'] ? $ct_temp_msg_data['contact'] : true);
    $message = ($ct_temp_msg_data['message'] ? $ct_temp_msg_data['message'] : array());

    if ($subject != '') {
        $message = array_merge(array('subject' => $subject), $message);
    }
    $message = json_encode($message);

    //@header("CtGetFieldsAny: Passed");
    cleantalk_debug("CtGetFieldsAny", "Passed");
    //@header("CtSenderEmail: $sender_email");
    cleantalk_debug("CtSenderEmail", $sender_email);
    if($contact_form)
    {
    	//@header("CtContactForm: true");
    	cleantalk_debug("CtContactForm", "true");
    }
    else
    {
    	//@header("CtContactForm: false");
    	cleantalk_debug("CtContactForm", "false");
    }
    
    // Skip submission if no data found
    if ($sender_email===''|| !$contact_form) {
        return false;
    }
    $cleantalk_executed=true;
    
    if(isset($_POST['TellAFriend_Link']))
    {
    	$tmp=$_POST['TellAFriend_Link'];
    	unset($_POST['TellAFriend_Link']);
    }

    //@header("CtBaseCallBefore: 1");
    cleantalk_debug("CtBaseCallBefore", "1");
	
    $ct_base_call_result = ct_base_call(array(
        'message' => $message,
        'example' => null,
        'sender_email' => $sender_email,
        'sender_nickname' => $sender_nickname,
        'post_info' => $post_info,
	    'sender_info' => get_sender_info(),
        'checkjs' => $checkjs
    ));

    //@header("CtBaseCall: Executed");
    cleantalk_debug("CtBaseCall", "Executed");

    if(isset($_POST['TellAFriend_Link']))
    {
    	$_POST['TellAFriend_Link']=$tmp;
    }

    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];
    if ($ct_result->allow == 0) {

    	//@header("CtResult: Not Allow");
    	cleantalk_debug("CtResult", "Not Allow");
        
        $ajax_call = false;
        if ((defined( 'DOING_AJAX' ) && DOING_AJAX) 
            ) {
            $ajax_call = true;
        }
        if ($ajax_call) {
        	//@header("AJAX: Yes");
        	cleantalk_debug("AJAX", "Yes");
            echo $ct_result->comment;
        } else {

        	//@header("AJAX: No");
        	cleantalk_debug("AJAX", "No");
            global $ct_comment;
            $ct_comment = $ct_result->comment;
            if(isset($_POST['cma-action'])&&$_POST['cma-action']=='add'){
            	$result=Array('success'=>0, 'thread_id'=>null,'messages'=>Array($ct_result->comment));
            	header("Content-Type: application/json");
				print json_encode($result);
				die();
				
            }else if(isset($_POST['TellAFriend_email'])){
            	echo $ct_result->comment;
            	die();
				
            }else if(isset($_POST['gform_submit'])){ // Gravity forms submission
                $response = sprintf("<!DOCTYPE html><html><head><meta charset='UTF-8' /></head><body class='GF_AJAX_POSTBACK'><div id='gform_confirmation_wrapper_1' class='gform_confirmation_wrapper '><div id='gform_confirmation_message_1' class='gform_confirmation_message_1
 gform_confirmation_message'>%s</div></div></body></html>",
                    $ct_result->comment
                );
                echo $response;
            	die();
				
            }elseif(isset($_POST['_wp_http_referer']) && strpos($_POST['_wp_http_referer'],'wc-ajax=update_order_review')){ //WooCommerce checkout ("Place Oreder button")
				$result = Array(
					result => 'failure',
					messages => "<ul class=\"woocommerce-error\"><li>".$ct_result->comment."</li></ul>",
					refresh => 'false',
					reload => 'false'
				);
				print json_encode($result);
				die();
				
			}elseif(isset($_POST['action']) && $_POST['action'] == 'ct_check_internal'){	
                return $ct_result->comment;
				
            }elseif(isset($_POST['vfb-submit']) && defined('VFB_VERSION')){
				wp_die("<h1>Spam Protection by CleanTalk</h1><h2>".$ct_result->comment."</h2>", '', array('response' => 403, "back_link" => true, "text_direction" => 'ltr'));
                
			}elseif(isset($_POST['action']) && $_POST['action'] == 'cf_process_ajax_submit'){	
                echo "<h3>Antispam by CleanTalk: <u>".$ct_result->comment."</u></h3>";	
				die();
            }else
            	ct_die(null, null);
			
        }
        exit;
    }
    //@header("CtResult: Allow");
    cleantalk_debug("CtResult", "Allow");

    return null;
}

/**
 * General test for any post data
 */
function ct_contact_form_validate_postdata() {
	global $pagenow,$cleantalk_executed, $cleantalk_url_exclusions, $ct_options, $ct_data;

    $ct_options = ct_get_options();
    $ct_data = ct_get_data();
    
	if($cleantalk_executed)
		return null;
	
	if ((defined( 'DOING_AJAX' ) && DOING_AJAX))
		return null;
	
	if(isset($cleantalk_url_exclusions))
		$ct_cnt=sizeof($cleantalk_url_exclusions);
	else
		$ct_cnt=0;

	//@header("CtExclusions: ".$ct_cnt);
	cleantalk_debug("CtExclusions", $ct_cnt);
	
    if (@sizeof($_POST)==0 ||
    	(isset($_POST['signup_username']) && isset($_POST['signup_email']) && isset($_POST['signup_password'])) ||
        (isset($pagenow) && $pagenow == 'wp-login.php') || // WordPress log in form
        (isset($pagenow) && $pagenow == 'wp-login.php' && isset($_GET['action']) && $_GET['action']=='lostpassword') ||
        strpos($_SERVER['REQUEST_URI'],'/checkout/')!==false ||
        strpos($_SERVER['REQUEST_URI'],'/wp-admin/')!==false ||
        strpos($_SERVER['REQUEST_URI'],'wp-login.php')!==false||
        strpos($_SERVER['REQUEST_URI'],'wp-comments-post.php')!==false ||
        @strpos($_SERVER['HTTP_REFERER'],'/wp-admin/')!==false ||
        strpos($_SERVER['REQUEST_URI'],'/login/')!==false||
        isset($_GET['ptype']) && $_GET['ptype']=='login' ||
        check_url_exclusions() ||
        ct_check_array_keys($_POST) ||
        isset($_POST['ct_checkjs_register_form']) ||
        (isset($_POST['signup_username']) && isset($_POST['signup_password_confirm']) && isset($_POST['signup_submit']) ) ||
        @intval($ct_options['general_contact_forms_test'])==0 ||
        isset($_POST['bbp_topic_content']) ||
        isset($_POST['bbp_reply_content']) ||
        isset($_POST['fscf_submitted']) ||
        isset($_POST['log']) && isset($_POST['pwd']) && isset($_POST['wp-submit'])||
        strpos($_SERVER['REQUEST_URI'],'/wc-api/')!==false ||
		(isset($_POST['wc_reset_password'], $_POST['_wpnonce'], $_POST['_wp_http_referer'])) || //WooCommerce recovery password form
		(isset($_POST['woocommerce-login-nonce'], $_POST['login'], $_POST['password'], $_POST['_wp_http_referer'])) //WooCommerce login form
        ) {
        return null;
    }
    
    $_POST=ct_filter_array($_POST);

    $checkjs = js_test('ct_checkjs', $_COOKIE, true);
  
    $post_info['comment_type'] = 'feedback_general_postdata';
    $post_info = json_encode($post_info);
    if ($post_info === false) {
        $post_info = '';
    }

    $message = ct_get_fields_any_postdata($_POST);
	
    $message = json_encode($message);
    
    if(strlen(trim($message))<10)
    {
    	return null;
    }
    $skip_params = array(
	    'ipn_track_id', // PayPal IPN #
	    'txn_type', // PayPal transaction type
	    'payment_status', // PayPal payment status
    );
    
    foreach($skip_params as $key=>$value)
   	{
   		if(@array_key_exists($value,$_GET)||@array_key_exists($value,$_POST))
   		{
   			return null;
   		}
   	}
    
    $ct_base_call_result = ct_base_call(array(
        'message' => $message,
        'example' => null,
        'sender_email' => '',
        'sender_nickname' => '',
        'post_info' => $post_info,
	    'sender_info' => get_sender_info(),
        'checkjs' => $checkjs
    ));
    
    $cleantalk_executed=true;
    
    $ct = $ct_base_call_result['ct'];
    $ct_result = $ct_base_call_result['ct_result'];
       
    if ($ct_result->allow == 0) {
        
        if (!(defined( 'DOING_AJAX' ) && DOING_AJAX)) {
            global $ct_comment;
            $ct_comment = $ct_result->comment;
            if(isset($_POST['cma-action'])&&$_POST['cma-action']=='add')
            {
            	$result=Array('success'=>0, 'thread_id'=>null,'messages'=>Array($ct_result->comment));
            	header("Content-Type: application/json");
				print json_encode($result);
				die();
            }
            else
            {
            	ct_die(null, null);
            }
        } else {
            echo $ct_result->comment; 
        }
        exit;
    }

    return null;
}


/**
 * Inner function - Finds and returns pattern in string
 * @return null|bool
 */
function ct_get_data_from_submit($value = null, $field_name = null) {
    if (!$value || !$field_name || !is_string($value)) {
        return false;
    }
    if (preg_match("/[a-z0-9_\-]*" . $field_name. "[a-z0-9_\-]*$/", $value)) {
        return true;
    }
}

/**
 * Sends error notice to admin
 * @return null
 */
function ct_send_error_notice ($comment = '') {
    global $ct_plugin_name, $ct_admin_notoice_period;

    $timelabel_reg = intval( get_option('cleantalk_timelabel_reg') );
    if(time() - $ct_admin_notoice_period > $timelabel_reg){
        update_option('cleantalk_timelabel_reg', time());

        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $message  = __('Attention, please!', 'cleantalk') . "\r\n\r\n";
        $message .= sprintf(__('"%s" plugin error on your site %s:', 'cleantalk'), $ct_plugin_name, $blogname) . "\r\n\r\n";
        $message .= $comment . "\r\n\r\n";
        @wp_mail(ct_get_admin_email(), sprintf(__('[%s] %s error!', 'cleantalk'), $ct_plugin_name, $blogname), $message);
    }

    return null;
}

function ct_print_form($arr,$k)
{
	foreach($arr as $key=>$value)
	{
		if(!is_array($value))
		{
			if($k=='')
			{
				print '<textarea name="'.$key.'" style="display:none;">'.htmlspecialchars($value).'</textarea>';
			}
			else
			{
				print '<textarea name="'.$k.'['.$key.']" style="display:none;">'.htmlspecialchars($value).'</textarea>';
			}
		}
		else
		{
			if($k=='')
			{
				ct_print_form($value,$key);
			}
			else
			{
				ct_print_form($value,$k.'['.$key.']');
			}
		}
	}
}

?>
