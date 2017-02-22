<?php
/**
 * 调度类
 *
 */
final class Front
{
	protected $pre_action = array();
	
	protected $error_action;
	
	public function addPreAction($pre_action) {
		$this->pre_action[] = $pre_action;
	}
	
	public function dispatch($action, $error_action)
	{
		$this->error_action = $error_action;

		while ($action) {
			foreach ($this->pre_action as $pre_action) {
				$result = $this->execute($pre_action);
						
				if ($result) {
					$action = $result;
					
					break;
				}
			}
			
			$action = $this->execute($action);
		}
	}
	
	/**
	 * 执行调度，即实例化控制器类，并调用指定方法
	 *
	 */
	private function execute($action)
	{
		$file = DIR_APPLICATION . 'controller/' . str_replace('../', '', $action->getFilePath()) . '.php';
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $action->getFilePath());
		$method = $action->getMethod();
		$args = $action->getArgs();
		
		$action = '';
		
		if (file_exists($file)) {
			require_once($file);
			
			$controller = new $class();
			
			if (is_callable(array($controller, $method))) {
				$action = call_user_func_array(array($controller, $method), $args);
			} else {
				$action = $this->error_action;
				$this->error_action = '';
			}
		} else {
			$action = $this->error_action;
			$this->error_action = '';
		}
		
		return $action;
	}
}

?>