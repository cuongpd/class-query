<?php // Class Query
	class Query{
		/* DELETE */
		public function delete($table){
			// delete_from() alias
			return self::delete_from($table);
		}
		public function delete_from($table){
			$this->delete_from=$table;
			return $this;
		}
		public function get_deleted(){
			return self::get_affected();
		}
		/* INSERT */
		public function get_insert_id(){
			// alias for get_inserted_id()
			return self::get_inserted_id();
		}
		public function get_inserted(){
			// alias for get_inserted_id()
			return self::get_inserted_id();
		}
		public function get_inserted_id(){
			$this->inserted=mysql_insert_id();
			return $this->inserted;
		}
		public function insert($table,$keys_and_values){
			// insert_into() alias
			return self::insert_into($table,$keys_and_values);
		}
		public function insert_into($table,$keys_and_values){
			self::set_table($table);
			self::set_keys_and_values($keys_and_values);
			$insert_keys=array();
			$insert_values=array();
			foreach($keys_and_values as $key=>$value){
				$insert_keys[]=$key;
				$insert_values[]=(!is_null($value)?sprintf('\'%s\'',mysql_real_escape_string($value)):'NULL');
			}
			self::set_keys($insert_keys);
			self::set_values($insert_values);
			$this->insert_into="\n".
				'INSERT INTO '.$table.'('."\n".
					"\t".implode(','."\n\t",$insert_keys)."\n".
				')'."\n".
				'VALUES('."\n".
					"\t".implode(','."\n\t",$insert_values)."\n".
				')'."\n".
				'';
			return $this;
		}
		/* INSERTS */
		public function inserts($table,$keys,$values){
			// insert_multiple() alias
			return self::insert_multiple($table,$keys,$values);
		}
		public function insert_multiple($table,$keys,$values){
			self::set_table($table);
			$insert_keys=$keys;
			self::set_keys($insert_keys);
			$insert_values=array();
			foreach($values as $v){
				$vs=array();
				foreach($v as $value){
					$vs[]=(!is_null($value)?sprintf('\'%s\'',mysql_real_escape_string($value)):'NULL');
				}
				$insert_values[]='('.implode(',',$vs).')';
			}
			self::set_values($insert_values);
			$this->insert_multiple="\n".
				'INSERT INTO '.$table.'('."\n".
					"\t".implode(','."\n\t",$insert_keys)."\n".
				')'."\n".
				'VALUES'."\n".
					"\t".implode(','."\n\t",$insert_values)."\n".
				'';
			return $this;
		}
		/* REPLACE */
		public function get_replaced(){
			return self::get_affected();
		}
		public function replace($table,$keys_and_values){
			$replace_keys=array();
			$replace_values=array();
			foreach($keys_and_values as $key=>$value){
				$replace_keys[]=$key;
				$replace_values[]=(!is_null($value)?sprintf('\'%s\'',mysql_real_escape_string($value)):'NULL');
			}
			$this->insert_into="\n".
				'REPLACE INTO '.$table.'('."\n".
					"\t".implode(','."\n\t",$replace_keys)."\n".
				')'."\n".
				'VALUES('."\n".
					"\t".implode(','."\n\t",$replace_values)."\n".
				')'."\n".
				'';
			return $this;
		}
		public function replace_into($table,$keys_and_values){
			return self::replace($table,$keys_and_values);
		}
		/* SELECT */
		public function get_selected(){
			// returns an array of the SELECT result(s)
			if(isset($this->limit)&&1==$this->limit){
				// for use when selecting with limit(1)
				$result=array();
				while($this->result&&$result[]=mysql_fetch_assoc($this->result)){}
				array_pop($result);
				$results=array();
				foreach($result as $values){
					$results=$values;
				}
			}
			else{
				// for use when selecting with no limit or a limit > 1
				$results=array();
				while($this->result&&$results[]=mysql_fetch_assoc($this->result)){}
				array_pop($results);
			}
			return $results;
		}
		public function select($select='*'){
			// SELECT Retrieves fields from one or more tables.
			$this->select=$select;
			return $this;
		}
		public function select_from($select,$table){
			// alias for select() instead of using both select() && from()
			self::select($select);
			self::from($table);
			return $this;
		}
		/* UPDATE */
		public function get_updated(){
			return self::get_affected();
		}
		public function set($set){
			$this->set=$set;
			return $this;
		}
		public function update($update){
			$this->update=$update;
			return $this;
		}
		/* Get helpers */
		private function set_keys($keys){
			$this->keys=$keys;
		}
		private function set_keys_and_values($keys_and_values){
			$this->keys_and_values=$keys_and_values;
		}
		private function set_table($table){
			$this->table=$table;
		}
		private function set_values($values){
			$this->values=$values;
		}
		/* Query helpers */
		private function get_affected(){
			// Returns number of affected rows by the last INSERT, UPDATE, REPLACE or DELETE
			return mysql_affected_rows();
		}
		public function distinct($distinct){
			$this->distinct=$distinct;
			return $this;
		}
		public function from($from){
			// FROM target the specifed tables.
			$this->from=$from;
			return $this;
		}
		public function group_by($group_by){
			$this->group_by=$group_by;
			return $this;
		}
		public function having($having){
			// HAVING Used with GROUP BY to specify the criteria for the grouped records.
			$this->having=$having;
			return $this;
		}
		public function inner_join($inner_join){
			$this->inner_join=$inner_join;
			return $this;
		}
		public function limit($limit){
			// LIMIT Limit the number of records selected or deleted.
			$this->limit=(int)$limit;
			return $this;
		}
		public function offset($offset){
			$this->offset=(int)$offset;
			return $this;
		}
		public function order_by($order_by){
			$this->order_by=$order_by;
			return $this;
		}
		public function page($page){
			$this->page=(int)$page;
			return $this;
		}
		public function range($limit,$offset){
			// alias instead of using both limit() && offset()
			self::limit($limit);
			self::offset($offset);
			return $this;
		}
		public function where_between($where_between){
			$this->where_between=$where_between;
			return $this;
		}
		public function where_equal($where_equal){
			// alias for where_equal_to()
			return self::where_equal_to($where_equal);
		}
		public function where_equal_or($where_equal_or){
			$this->where_equal_or=$where_equal_or;
			return $this;
		}
		public function where_equal_to($where_equal_to){
			$this->where_equal_to=$where_equal_to;
			return $this;
		}
		public function where_greater_than($where_greater_than){
			$this->where_greater_than=$where_greater_than;
			return $this;
		}
		public function where_greater_than_or_equal_to($where_greater_than_or_equal_to){
			$this->where_greater_than_or_equal_to=$where_greater_than_or_equal_to;
			return $this;
		}
		public function where_in($where_in){
			$this->where_in=$where_in;
			return $this;
		}
		public function where_less_than($where_less_than){
			$this->where_less_than=$where_less_than;
			return $this;
		}
		public function where_less_than_or_equal_to($where_less_than_or_equal_to){
			$this->where_less_than_or_equal_to=$where_less_than_or_equal_to;
			return $this;
		}
		public function where_like($where_like){
			$this->where_like=$where_like;
			return $this;
		}
		public function where_like_binary($where_like_binary){
			$this->where_like_binary=$where_like_binary;
			return $this;
		}
		public function where_not_equal_to($where_not_equal_to){
			$this->where_not_equal_to=$where_not_equal_to;
			return $this;
		}
		public function where_not_in($where_not_in){
			$this->where_not_in=$where_not_in;
			return $this;
		}
		public function where_not_like($where_not_like){
			$this->where_not_like=$where_not_like;
			return $this;
		}
		/* GET */
		public function get(){
			// returns select, insert or update query
			if(self::get_delete_query()){
				return $this->delete_query;
			}
			elseif(self::get_insert_into_query()){
				return $this->insert_into_query;
			}
			elseif(self::get_select_query()){
				return $this->select_query;
			}
			elseif(self::get_update_query()){
				return $this->update_query;
			}
			elseif(self::get_insert_multiple()){
				return $this->insert_multiple_query;
			}
			else{
				return false;
			}
		}
		private function get_distinct(){
			// FINISH
		}
		private function get_delete_from(){
			return
				'DELETE FROM'."\n".
					"\t".$this->delete_from."\n".
					'';
		}
		private function get_delete_query(){
			if(isset($this->delete_from)){
				$this->query_type='delete';
				$this->delete_query="\n".
					self::get_delete_from().
					self::get_where().
					self::get_order_by().
					self::get_limit().
					'';
				return true;
			}
			return false;
		}
		private function get_from(){
			return
				'FROM'."\n".
					"\t".$this->from."\n".
					'';
		}
		private function get_group_by(){
			// GROUP BY Determines how the records should be grouped.
			if(isset($this->group_by)){
				return
					'GROUP BY'."\n".
						"\t".$this->group_by."\n".
						'';
			}
		}
		private function get_having(){
			if(isset($this->having)){
				return
					'HAVING'."\n".
						"\t".$this->having."\n".
						'';
			}
		}
		private function get_inner_join(){
			if(isset($this->inner_join)){
				return
					'INNER JOIN'."\n".
						"\t".$this->inner_join."\n".
						'';
			}
		}
		private function get_insert_into_query(){
			if(isset($this->insert_into)){
				$this->query_type='insert_into';
				$this->insert_into_query=$this->insert_into;
				return true;
			}
			return false;
		}
		private function get_insert_multiple(){
			if(isset($this->insert_multiple)){
				$this->query_type='insert_multiple';
				$this->insert_multiple_query=$this->insert_multiple;
				return true;
			}
			return false;
		}
		private function get_join(){
			// FINISH
			return self::get_inner_join();
		}
		private function get_limit(){
			if(!isset($this->limit)){
				return '';
			}
			else{
				if(isset($this->offset)){
					return
						'LIMIT'."\n".
							"\t".$this->offset.','.$this->limit."\n".
							'';
				}
				return
					'LIMIT'."\n".
						"\t".$this->limit."\n".
						'';
			}
		}
		private function get_order_by(){
			// ORDER BY to order the records.
			if(!isset($this->order_by)){
				return '';
			}
			else{
				return
					'ORDER BY'."\n".
						"\t".$this->order_by."\n".
						'';
			}
		}
		private function get_select(){
			if(!is_array($this->select)){
				return
					'SELECT'."\n".
						"\t".'*'."\n".
						'';
			}
			else{
				$selects=array();
				foreach($this->select as $select){
					$selects[]=$select;
				}
				return
					'SELECT'."\n".
						"\t".implode(','."\n\t",$selects)."\n".
						'';
			}
		}
		private function get_select_query($use_limit=null){
			if(isset($this->select)){
				$this->query_type='select';
				$this->select_query="\n".
					self::get_select().
					self::get_from().
					self::get_join().
					self::get_where().
					self::get_group_by().
					self::get_having().
					self::get_order_by().
					($use_limit||!isset($this->page)?self::get_limit():'').
					'';
				return true;
			}
			return false;
		}
		private function get_set(){
			$sets=array();
			$set_equals=array();
			foreach($this->set as $k=>$v){
				if(!is_null($v)){
					$set_equals[]=sprintf($k.'=\'%s\'',mysql_real_escape_string($v));
				}
				else{
					$set_equals[]=sprintf($k.'=NULL');
				}
			}
			$sets[]=implode(', '."\n\t",$set_equals);
			return
				'SET'."\n".
					"\t".implode(','."\n\t",$sets)."\n".
					'';
		}
		private function get_update(){
			return
				'UPDATE'."\n".
					"\t".$this->update."\n".
					'';
		}
		private function get_update_query(){
			if(isset($this->update)){
				$this->query_type='update';
				$this->update_query="\n".
					self::get_update().
					self::get_set().
					self::get_where().
					self::get_limit().
					'';
				return true;
			}
			return false;
		}
		private function get_where(){
			$wheres=array();
			$where_greater_than_or_equal_to=self::get_where_greater_than_or_equal_to();
			$where_less_than_or_equal_to=self::get_where_less_than_or_equal_to();
			$where_equal_or=self::get_where_equal_or();
			$where_equal_to=self::get_where_equal_to();
			$where_like_binary=self::get_where_like_binary();
			if(!empty($where_greater_than_or_equal_to)){
				$wheres[]=$where_greater_than_or_equal_to;
			}
			if(!empty($where_less_than_or_equal_to)){
				$wheres[]=$where_less_than_or_equal_to;
			}
			if(!empty($where_equal_or)){
				$wheres[]=$where_equal_or;
			}
			if(!empty($where_equal_to)){
				$wheres[]=$where_equal_to;
			}
			if(!empty($where_like_binary)){
				$wheres[]=$where_like_binary;
			}
			if(empty($wheres)){
				return '';
			}
			else{
				return
					'WHERE'."\n".
						"\t".implode('AND'."\n\t",$wheres)."\n".
						'';
			}
		}
		private function get_where_between(){
			// FINISH
			// BETWEEN Checks for values between a range
		}
		private function get_where_equal_or(){
			if(
				!isset($this->where_equal_or)||
				!is_array($this->where_equal_or)
				){
				return '';
			}
			else{
				$where_equal_or=array();
				foreach($this->where_equal_or as $k=>$v){
					if(false!==strpos($k,'%s')){
						$where_equal_or[]=sprintf($k,mysql_real_escape_string($v));
					}
					elseif(!is_null($v)){
						$where_equal_or[]=sprintf($k.'=\'%s\'',mysql_real_escape_string($v));
					}
				}
				return
					'('."\n".
						"\t\t".implode(' OR'."\n\t\t",$where_equal_or)."\n".
						"\t".
					') ';
			}
		}
		private function get_where_equal_to(){
			// = Equal to
			if(
				!isset($this->where_equal_to)||
				!is_array($this->where_equal_to)
				){
				return '';
			}
			else{
				$where_equal_to=array();
				foreach($this->where_equal_to as $k=>$v){
					$where_equal_to[]=is_null($v)?$k.' IS NULL':sprintf($k.'=\'%s\'',mysql_real_escape_string($v));
				}
				return implode(' AND'."\n\t",$where_equal_to).' ';
			}
		}
		private function get_where_greater_than(){
			// FINISH
			// > greater than
		}
		private function get_where_greater_than_or_equal_to(){
			// >= greater than or equal to
			if(
				!isset($this->where_greater_than_or_equal_to)||
				!is_array($this->where_greater_than_or_equal_to)
				){
				return '';
			}
			else{
				$where_greater_than_or_equal_to=array();
				foreach($this->where_greater_than_or_equal_to as $k=>$v){
					$where_greater_than_or_equal_to[]=is_null($v)?$k.' IS NULL':sprintf($k.'>=\'%s\'',mysql_real_escape_string($v));
				}
				return implode(' AND'."\n\t",$where_greater_than_or_equal_to).' ';
			}
		}
		private function get_where_in(){
			// FINISH
			// IN Checks for values in a list
		}
		private function get_where_less_than(){
			// FINISH
			// < Less than
		}
		private function get_where_less_than_or_equal_to(){
			// <= Less than or equal to
			if(
				!isset($this->where_less_than_or_equal_to)||
				!is_array($this->where_less_than_or_equal_to)
				){
				return '';
			}
			else{
				$where_less_than_or_equal_to=array();
				foreach($this->where_less_than_or_equal_to as $k=>$v){
					$where_less_than_or_equal_to[]=is_null($v)?$k.' IS NULL':sprintf($k.'<=\'%s\'',mysql_real_escape_string($v));
				}
				return implode(' AND'."\n\t",$where_less_than_or_equal_to).' ';
			}
		}
		private function get_where_like(){
			// FINISH
			// LIKE Used to compare strings
		}
		private function get_where_like_binary(){
			if(
				!isset($this->where_like_binary)||
				!is_array($this->where_like_binary)
				){
				return '';
			}
			else{
				$where_like_binary=array();
				foreach($this->where_like_binary as $k=>$v){
					if(!is_null($v)){
						$where_like_binary[]=sprintf($k.' LIKE BINARY \'%s\'',mysql_real_escape_string($v));
					}
				}
				return implode(' AND'."\n\t",$where_like_binary)."\n";
			}
		}
		private function get_where_not_equal_to(){
			// FINISH
			// <> Not equal to
			// != Not equal to
		}
		private function get_where_not_in(){
			// FINISH
			// NOT IN Ensures the value is not in the list
		}
		private function get_where_not_like(){
			// FINISH
			// NOT LIKE Used to compare strings
		}
		/* RUN */
		public function run(){
			// runs query, returns mysql result
			if(self::get()){
				$function='run_'.$this->query_type;
				switch($this->query_type){
					case 'delete':
					case 'insert_into':
					case 'insert_multiple':
					case 'update':
						return self::$function();
						break;
					case 'select':
						if(!isset($this->page)){
							// no pagination
							return self::$function();
						}
						else{
							// with pagination
							if(self::$function()){
								// calculate pages
								$this->pages=(int)ceil($this->results/$this->limit);
								// set offset
								self::offset(($this->page*$this->limit)-$this->limit);
								// update select query with limit now that pages is set
								self::get_select_query(true);
								// run select query with updated limit and offset
								return self::run_select();
							}
						}
						break;
					default:
						die('err: bad query type:'.$this->query_type);
						break;
				}
			}
			return false;
		}
		private function run_delete(){
			return self::run_query($this->delete_query);
		}
		private function run_insert_into(){
			return self::run_query($this->insert_into_query);
		}
		private function run_insert_multiple(){
			return self::run_query($this->insert_multiple_query);
		}
		private function run_select(){
			return self::run_query($this->select_query);
		}
		private function run_update(){
			return self::run_query($this->update_query);
		}
		private function run_query($query){
			// $debug=false;
			$debug=true;
			$result=mysql_query($query) or die('Error in query'.($debug?': '.mysql_error():'.'));
			switch($this->query_type){
				case 'delete':
					return self::get_affected();
				case 'insert_into':
					return self::get_inserted_id();
				case 'insert_multiple':
					return true;
				case 'select':
					$this->results=mysql_num_rows($result);
					if($result&&$this->results>0){
						return $this->result=$result;
					}
					return false;
				case 'update':
					return self::get_affected();
			}
		}
		/* SHOW */
		public function show(){
			echo self::get();
		}
		/* DISPLAY */
		public function display(){
			// show() alias
			return self::show();
		}
	}
?>