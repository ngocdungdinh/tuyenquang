<?php
    // app/config/settings.php
	class DBconfiguratorObject implements ArrayAccess, Serializable {
		protected $config = array();
		protected $table = null;

		private static $_instance = null;

		public static function instance($tableName = 'settings'){
			if(self::$_instance === null){
				self::$_instance = new self($tableName);
			}
			return self::$_instance;
		}

		private function __construct($tableName = 'settings'){
			$this->table = DB::table($tableName);
			$this->config = $this->table->lists('value', 'key');
		}

		public function offsetGet($key){
			return $this->config[$key];
		}

		public function offsetSet($key, $value){
			if($this->offsetExists($key)){
				$this->table->where('key', $key)->update(array(
					'value' => $value
				));
			} else {
				$this->table->insert(array(
					'key' => $key,
					'value' => $value
				));
			}
			$this->config[$key] = $value;
		}

		public function offsetExists($key){
			return isset($this->config[$key]);
		}

		public function offsetUnset($key){
			unset($this->config[$key]);
			$this->table->where('key', $key)->delete();
		}

		public function serialize(){
			return serialize($this->config);
		}

		public function unserialize($serialized){
			$config = unserialize($serialized);
			foreach($config as $key => $value){
				$this[$key] = $value;
			}
		}

		public function toJson(){
			return json_encode($this->config);
		}

		public function toArray(){
			return $this->config;
		}
	}

	return DBconfiguratorObject::instance();