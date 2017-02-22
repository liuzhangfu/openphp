<?php
/**
 * session类
 *
 */
final class Session
{
	private $data = array();
	
	public function __construct()
	{
		if (!session_id()) {
			// 设置开启用cookie传递session_id
			ini_set('session.use_cookies', 'On');
			// 设置关闭用url传递session_id
			ini_set('session.use_trans_sid', 'Off');
			
			// 设置session的过期时间是关闭浏览器，第二个参数是只cookie的存放路径可以任意
			session_set_cookie_params(0, '/');
			// 开启session
			session_start();
		}
		
		$this->data = & $_SESSION;
	}
}

?>