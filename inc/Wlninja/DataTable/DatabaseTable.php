<?php
namespace Wlninja\DataTable;

class DatabaseTable
{	
	private $pdo;
	private $table;
	private $primaryKey;
	private $className;
	private $constructorArgs;
		
	public function __construct( \PDO $pdo, string $table, string $primaryKey, string $className = '\stdClass', array $constructorArgs = [] )
		{
			$this->pdo = $pdo;
			$this->table = $table;
			$this->primaryKey = $primaryKey;
			$this->className = $className;
			$this->constructorArgs = $constructorArgs;

		}

		private function query($sql, $parameters = []) {
			$query = $this->pdo->prepare($sql);
			$query->execute($parameters);
			return $query;
		}

		//INSERT/CREATE - EDIT/UPDATE
		public function save($record) {
			$entity = new $this->className(...$this->constructorArgs);

			//print_r($entity);die;

			try{ 
				if ( $record[$this->primaryKey] == '' /*|| !isset($record[$this->primaryKey])*/ ){
					$record[$this->primaryKey] = null;
				}
				$insertId = $this->insert($record);

				//echo $insertId; die;
				$entity->{$this->primaryKey} = $insertId;
				//echo $entity->{$this->primaryKey}; die;
			}
			catch (\PDOException $e) {
				// return $e;
				//print_r($e);//die;
				try {
					// return $this -> update($record);
					$this -> update($record);
				} catch (\PDOException $th) { // \Throwable
					return $th;
				}

				$entity->updated = 1;				
			}

			foreach ($record as $key => $value) {
				if ( !empty($value) ) {
					$entity->$key = $value;
				}
			}

			return $entity;
		}
		public function insert($fields) {
			$query = 'INSERT INTO `' . $this->table . '` (';
			
			foreach ($fields as $key => $value) {
				$query .= '`' . $key . '`,';
			}
			
			$query = rtrim($query, ',');
			
			$query .= ') VALUES (';
			
			foreach($fields as $key => $value) {
				$query .= ':' . $key . ',';
			}
			
			$query = rtrim($query, ',');
			
			$query .= ');';

			// return $query;
			
			$fields = $this -> processDates($fields);
			
			$this -> query($query, $fields);

			return $this->pdo->lastInsertId();
		}

		private function update($fields) {
			$query = 'UPDATE `' . $this->table . '` SET ';
			
			foreach ($fields as $key => $value) {
				$query .= '`' . $key . '` = :' . $key . ',';
			}
			
			$query = rtrim($query, ',');
			
			$query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';
			
			$fields['primaryKey'] = $fields['id'];
						
			$fields = $this -> processDates($fields);

			// return $query;
			
			$this -> query($query, $fields);
		}
		private function processDates($fields) {
			foreach ($fields as $key => $value) {
				if ($value instanceof \DateTime) {
					$fields[$key] = $value->format('Y-m-d');
				}
			}
			return $fields;
		}

		public function delete($id) {
			$parameters = [':id' => $id];
			
			$this -> query('DELETE FROM `' . $this->table . '`
			WHERE `' . $this->primaryKey . '` = :id', $parameters);
		}

		public function deleteByField($field, $value) {
			if ($field != null && $value != null) {
				$query = 'DELETE FROM `' . $this->table . '`
						WHERE `' . $field . '` = :value';
				
				$parameters = [':value' => $value];

				$this -> query($query, $parameters);
			}
		}

		public function findById($value) {
			$query = 'SELECT * FROM `' . $this->table . '`
			WHERE `' . $this->primaryKey . '` = :value';
			
			$parameters = [ 'value' => $value ];
			
			$query = $this->query($query, $parameters);
			return $query->fetchObject($this->className, $this->constructorArgs);
			// return $query->fetch();
		}
		
		public function findUnique($column, $value)
		{
			$query = 'SELECT * FROM `' . $this->table . '`
				WHERE `' . $column . '` = :value';
			
			$parameters = [ 'value' => $value ];
			$query = $this -> query($query, $parameters);
			return $query->fetchObject($this->className, $this->constructorArgs);
		}

		public function findAll($orderBy = null, $limit = null, $offset = null) {
			$query = 'SELECT * FROM ' . $this->table;
			
			if($orderBy != null) {
				$query .= ' ORDER BY ' . $orderBy;
			}
			
			if($limit != null) {
				$query .= ' LIMIT ' . $limit;
			}
			
			if($offset != null) {
				$query .= ' OFFSET ' . $offset;
			}

			// return $query;
			
			$result = $this->query($query);

			// return $result->fetchAll(\PDO::FETCH_ASSOC); // No duplicate index
			return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
		}
        // public function findAll($orderBy = null, $limit = null, $offset = null) {
		// 	$query = 'SELECT * FROM ' . $this->table;
			
		// 	if($orderBy != null) {
		// 		$query .= ' ORDER BY ' . $orderBy;
		// 	}
			
		// 	if($limit != null) {
		// 		$query .= ' LIMIT ' . $limit;
		// 	}
			
		// 	if($offset != null) {
		// 		$query .= ' OFFSET ' . $offset;
		// 	}

		// 	// return $query;
			
		// 	$result = $this->query($query);

		// 	return $result->fetchAll(\PDO::FETCH_ASSOC); // No duplicate index
		// 	// return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
		// 	// return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
		// }

		public function find($column = null, $value = null, $orderBy = null, $limit = null, $offset = null) {
			$query = 'SELECT * FROM `' . $this->table . '`';
			if ( $column != null ) {
				$query .= ' WHERE `' . $column . '` = :value';
			
				$parameters = [
					'value' => $value
				];
			} else $parameters = [];
			
			if($orderBy != null) {
				$query .= ' ORDER BY ' . $orderBy;
			}
			
			if($limit != null) {
				$query .= ' LIMIT ' . $limit;
			}
			
			if($offset != null) {
				$query .= ' OFFSET ' . $offset;
			}
			
			$result = $this->query($query, $parameters);

			// return $result->fetchAll(\PDO::FETCH_ASSOC); // No duplicate index
			return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
			// $query = $this->query($query, $parameters);
			
			// // return $query->fetchAll();
			// return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
		}

		public function findByFind($column1 = null, $value1 = null, $column2 = null, $value2 = null, $orderBy = null, $limit = null, $offset = null) {
			$query = 'SELECT * FROM `' . $this->table . '`';
			if ( $column1 != null && $column2 != null) {
				$query .= ' WHERE `' . $column1 . '` = :value1 AND `' . $column2 . '` = :value2';
			
				$parameters = [
					'value1' => $value1,
					'value2' => $value2
				];
			} else $parameters = [];
			
			if($orderBy != null) {
				$query .= ' ORDER BY ' . $orderBy;
			}
			
			if($limit != null) {
				$query .= ' LIMIT ' . $limit;
			}
			
			if($offset != null) {
				$query .= ' OFFSET ' . $offset;
			}
			
			$query = $this->query($query, $parameters);
			
			return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
		}

		public function findContain ($column, $value, $orderBy = null, $limit = null, $offset = null) {
			$query = 'SELECT * FROM ' . $this->table . ' WHERE `' . $column . '` LIKE :value';
			
			$value = '%' . $value . '%';
			
			$parameters = [
				'value' => $value
			];
			
			if($orderBy != null) {
				$query .= ' ORDER BY ' . $orderBy;
			}
			
			if($limit != null) {
				$query .= ' LIMIT ' . $limit;
			}
			
			if($offset != null) {
				$query .= ' OFFSET ' . $offset;
			}
			
			$query = $this->query($query, $parameters);
			
			return $query->fetchObject( $this->className, $this->constructorArgs);
		}

		public function total($field = null, $value = null) {
			$sql = 'SELECT COUNT(*)
			FROM `' . $this->table . '`';
			$parameters = [];
			
			if(!empty($field)) {
				$sql .= ' WHERE `' . $field . '` = :value';
				$parameters = ['value' => $value];
			}
			$query = $this->query($sql,$parameters);
			
			$row = $query->fetch();
			return $row[0];
		}

		public function max($field = 'id')
		{
			$sql = 'SELECT MAX(`' . $field . '`) FROM `' . $this->table . '`';
			$query = $this->query($sql);
			$row = $query->fetch();
			return $row[0];
		}

		public function max_year($year, $field = 'id' )
		{
			$sql = 'SELECT MAX(`' . $field . '`) FROM `' . $this->table . '` WHERE `year` = :value';
				
			$parameters = ['value' => $year];

			$query = $this->query($sql, $parameters);
			$row = $query->fetch();

			if ($row[0] != null) {
				return $row[0];
			} else {
				return 0;
			}	
		}

		public function sum( $sum_column, $field = null, $value = null )
		{
			$sql = 'SELECT SUM(`' . $sum_column . '`) FROM `'  . $this->table . '`';
			$parameters = [];

			if($field != null && $value != null) {
				$sql .= ' WHERE `' . $field . '` = :value';
				$parameters = ['value' => $value];
			}

			$query = $this->query($sql,$parameters);
			
			$row = $query->fetch();
			return $row[0];
		}

		public function sumGroupedMonth( $grouped_column, $sum_column, $join_table, $join_column, $sec_join_table = null, $sec_join_column = null, $field_column = null, $field_val = null, $field_table = null )
		{
			$sql = 'SELECT MONTH (`' . $this->table . '`.`' . $grouped_column . '`) month, SUM(`' . $join_table . '`.`' . $sum_column . '`) month_total FROM `'  . $this->table . '`, `' . $join_table . '`';
			$parameters = [];

			if ($sec_join_table != null && $sec_join_column != null) {
				$sql .= ', `' . $sec_join_table . '`';
			}

			$sql .= ' WHERE `' . $this->table . '`.`' . $this->primaryKey . '` = `' . $join_table . '`.`' . $join_column . '`';

			if ($sec_join_table != null && $sec_join_column != null) {
				$sql .= ' AND `' . $this->table . '`.`' . $this->primaryKey . '` = `' . $sec_join_table . '`.`' . $sec_join_column . '`';
			}
			
			if ($field_column != null && $field_val != null && $field_table != null) {
				$sql .= ' AND `' . $field_table . '`.`' . $field_column . '` = :field_val';
				$parameters = ['field_val' => $field_val];
			}

			$sql .= ' GROUP BY MONTH (`' . $this->table . '`.`' . $grouped_column . '`)';
			$sql .= ' ORDER BY MONTH (`' . $this->table . '`.`' . $grouped_column . '`)';

			// return $sql;

			$query = $this->query($sql,$parameters);
			
			return $query->fetchAll();
		}

		// public function sumGroupedMonth( $grouped_column, $sum_column, $join_table, $join_column, $sec_join_table = null, $sec_join_column = null, $field_column = null, $field_val, $field_table = null )
		// {
		// 	$sql = 'SELECT MONTH (`' . $this->table . '`.`' . $grouped_column . '`) month, SUM(`' . $join_table . '`.`' . $sum_column . '`) month_total FROM `'  . $this->table . '`, `' . $join_table . '`';
		// 	$parameters = [];

		// 	// $sql .= ' WHERE `' . $this->table . '`.`' . $this->primaryKey . '` = :value';
		// 	// $parameters = ['value' => '`' . $join_table . '`.`' . $join_column . '`'];
		// 	$sql .= ' WHERE `' . $this->table . '`.`' . $this->primaryKey . '` = `' . $join_table . '`.`' . $join_column . '`';
		// 	// $parameters = ['value' => '`' . $join_table . '`.`' . $join_column . '`'];

		// 	$sql .= ' GROUP BY MONTH (`' . $this->table . '`.`' . $grouped_column . '`)';

		// 	// return $sql;

		// 	$query = $this->query($sql,$parameters);
			
		// 	return $query->fetchAll();
		// }

		// public function sumGroupedMonth( $grouped_column, $sum_column, $join_table, $join_column )
		// {
		// 	$sql = 'SELECT MONTH (`' . $this->table . '`.`' . $grouped_column . '`) month, SUM(`' . $join_table . '`.`' . $sum_column . '`) month_total FROM `'  . $this->table . '`, `' . $join_table . '`';
		// 	$parameters = [];

		// 	$sql .= ' WHERE `' . $this->table . '`.`' . $this->primaryKey . '` = :value';
		// 	$parameters = ['value' => '`' . $join_table . '`.`' . $join_column . '`'];
		// 	// if($field != null && $value != null) {
		// 	// 	$sql .= ' WHERE `' . $field . '` = :value';
		// 	// 	$parameters = ['value' => $value];
		// 	// }

		// 	$sql .= ' GROUP BY MONTH (`' . $this->table . '`.`' . $grouped_column . '`)';

		// 	// return $sql;

		// 	$query = $this->query($sql,$parameters);
			
		// 	return $query->fetchAll();
		// }
		// BACKUP
		// public function sumGroupedMonth( $grouped_column, $sum_column, $field = null, $value = null )
		// {
		// 	$sql = 'SELECT MONTH (`' . $grouped_column . '`) month, SUM(`' . $sum_column . '`) month_total FROM `'  . $this->table . '`';
		// 	$parameters = [];

		// 	if($field != null && $value != null) {
		// 		$sql .= ' WHERE `' . $field . '` = :value';
		// 		$parameters = ['value' => $value];
		// 	}

		// 	$sql .= ' GROUP BY MONTH (`' . $grouped_column . '`)';

		// 	$query = $this->query($sql,$parameters);
			
		// 	$row = $query->fetch();
		// 	return $row[0];
		// }


	/** WPDB */
    // private $pdo;
	// private $table;
	// private $primaryKey;
	// private $className;
	// private $constructorArgs;
		
	// public function __construct( string $table, string $primaryKey )
	// {
	// 	$this->table = $table;
	// 	$this->primaryKey = $primaryKey;
	// }

	// // public function sayHello()
	// // {
	// // 	return 'Hello';
	// // }

	// private function query($sql)
	// {
	// 	global $wpdb;

	// 	return $wpdb->query($sql);
	// }

	// public function save($record)
	// {
	// 	if ( $record[$this->primaryKey] == '' /*|| !isset($record[$this->primaryKey])*/ ){
	// 		$record[$this->primaryKey] = null; // null;

	// 		return $this->insert($record);
	// 	} else {
	// 		$this->update($record);
	// 	}
	// }

	// public function insert($fields) {
	// 	$query = 'INSERT INTO `' . $this->table . '` (';
		
	// 	foreach ($fields as $key => $value) {
	// 		$query .= '`' . $key . '`,';
	// 	}
		
	// 	$query = rtrim($query, ',');
		
	// 	$query .= ') VALUES (';
		
	// 	foreach($fields as $key => $value) {
	// 		// $query .= ':' . $key . ',';
	// 		$query .= $value . ',';
	// 	}
		
	// 	$query = rtrim($query, ',');
		
	// 	$query .= ')';

	// 	// return $query;
		
	// 	// $fields = $this -> processDates($fields);
		
	// 	// return $this->query($query);
	// 	$this->query($query);
	// 	return 'Saved..';

	// 	// return $this->pdo->lastInsertId();
	// }

	// 	//INSERT/CREATE - EDIT/UPDATE
	// 	// public function save($record) {
	// 	// 	$entity = new $this->className(...$this->constructorArgs);

	// 	// 	//print_r($entity);die;

	// 	// 	try{ 
	// 	// 		if ( $record[$this->primaryKey] == '' /*|| !isset($record[$this->primaryKey])*/ ){
	// 	// 			$record[$this->primaryKey] = null;
	// 	// 		}
	// 	// 		$insertId = $this->insert($record);

	// 	// 		//echo $insertId; die;
	// 	// 		$entity->{$this->primaryKey} = $insertId;
	// 	// 		//echo $entity->{$this->primaryKey}; die;
	// 	// 	}
	// 	// 	catch (\PDOException $e) {
	// 	// 		//print_r($e);//die;
	// 	// 		try {
	// 	// 			$this -> update($record);
	// 	// 		} catch (\PDOException $th) { // \Throwable
	// 	// 			print_r($th);die;
	// 	// 		}
				
	// 	// 	}

	// 	// 	foreach ($record as $key => $value) {
	// 	// 		if ( !empty($value) ) {
	// 	// 			$entity->$key = $value;
	// 	// 		}
	// 	// 	}

	// 	// 	return $entity;
	// 	// }

		

	// 	private function update($fields) {
	// 		$query = 'UPDATE `' . $this->table . '` SET ';
			
	// 		foreach ($fields as $key => $value) {
	// 			$query .= '`' . $key . '` = :' . $key . ',';
	// 		}
			
	// 		$query = rtrim($query, ',');
			
	// 		$query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';
			
	// 		$fields['primaryKey'] = $fields['id'];
						
	// 		$fields = $this -> processDates($fields);
			
	// 		$this -> query($query, $fields);
	// 	}
	// 	private function processDates($fields) {
	// 		foreach ($fields as $key => $value) {
	// 			if ($value instanceof \DateTime) {
	// 				$fields[$key] = $value->format('Y-m-d');
	// 			}
	// 		}
	// 		return $fields;
	// 	}

	// 	public function delete($id) {
	// 		$parameters = [':id' => $id];
			
	// 		$this -> query('DELETE FROM `' . $this->table . '`
	// 		WHERE `' . $this->primaryKey . '` = :id', $parameters);
	// 	}

	// 	public function deleteByField($field, $value) {
	// 		if ($field != null && $value != null) {
	// 			$query = 'DELETE FROM `' . $this->table . '`
	// 					WHERE `' . $field . '` = :value';
				
	// 			$parameters = [':value' => $value];

	// 			$this -> query($query, $parameters);
	// 		}
	// 	}

	// 	public function findById($value) {
	// 		$query = 'SELECT * FROM `' . $this->table . '`
	// 		WHERE `' . $this->primaryKey . '` = :value';
			
	// 		$parameters = [ 'value' => $value ];
			
	// 		$query = $this -> query($query, $parameters);
	// 		return $query->fetchObject($this->className, $this->constructorArgs);
	// 	}
		
	// 	public function findUnique($column, $value)
	// 	{
	// 		$query = 'SELECT * FROM `' . $this->table . '`
	// 			WHERE `' . $column . '` = :value';
			
	// 		$parameters = [ 'value' => $value ];
	// 		$query = $this -> query($query, $parameters);
	// 		return $query->fetchObject($this->className, $this->constructorArgs);
	// 	}

    //     public function findAll($orderBy = null, $limit = null, $offset = null) {
	// 		$query = 'SELECT * FROM ' . $this->table;
			
	// 		if($orderBy != null) {
	// 			$query .= ' ORDER BY ' . $orderBy;
	// 		}
			
	// 		if($limit != null) {
	// 			$query .= ' LIMIT ' . $limit;
	// 		}
			
	// 		if($offset != null) {
	// 			$query .= ' OFFSET ' . $offset;
	// 		}
			
	// 		$result = $this->query($query);
			
	// 		return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
	// 	}

	// 	public function find($column = null, $value = null, $orderBy = null, $limit = null, $offset = null) {
	// 		$query = 'SELECT * FROM `' . $this->table . '`';
	// 		if ( $column != null ) {
	// 			$query .= ' WHERE `' . $column . '` = :value';
			
	// 			$parameters = [
	// 				'value' => $value
	// 			];
	// 		} else $parameters = [];
			
	// 		if($orderBy != null) {
	// 			$query .= ' ORDER BY ' . $orderBy;
	// 		}
			
	// 		if($limit != null) {
	// 			$query .= ' LIMIT ' . $limit;
	// 		}
			
	// 		if($offset != null) {
	// 			$query .= ' OFFSET ' . $offset;
	// 		}
			
	// 		$query = $this->query($query, $parameters);
			
	// 		return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
	// 	}

	// 	public function findByFind($column1 = null, $value1 = null, $column2 = null, $value2 = null, $orderBy = null, $limit = null, $offset = null) {
	// 		$query = 'SELECT * FROM `' . $this->table . '`';
	// 		if ( $column1 != null && $column2 != null) {
	// 			$query .= ' WHERE `' . $column1 . '` = :value1 AND `' . $column2 . '` = :value2';
			
	// 			$parameters = [
	// 				'value1' => $value1,
	// 				'value2' => $value2
	// 			];
	// 		} else $parameters = [];
			
	// 		if($orderBy != null) {
	// 			$query .= ' ORDER BY ' . $orderBy;
	// 		}
			
	// 		if($limit != null) {
	// 			$query .= ' LIMIT ' . $limit;
	// 		}
			
	// 		if($offset != null) {
	// 			$query .= ' OFFSET ' . $offset;
	// 		}
			
	// 		$query = $this->query($query, $parameters);
			
	// 		return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
	// 	}

	// 	public function findContain ($column, $value, $orderBy = null, $limit = null, $offset = null) {
	// 		$query = 'SELECT * FROM ' . $this->table . ' WHERE `' . $column . '` LIKE :value';
			
	// 		$value = '%' . $value . '%';
			
	// 		$parameters = [
	// 			'value' => $value
	// 		];
			
	// 		if($orderBy != null) {
	// 			$query .= ' ORDER BY ' . $orderBy;
	// 		}
			
	// 		if($limit != null) {
	// 			$query .= ' LIMIT ' . $limit;
	// 		}
			
	// 		if($offset != null) {
	// 			$query .= ' OFFSET ' . $offset;
	// 		}
			
	// 		$query = $this->query($query, $parameters);
			
	// 		return $query->fetchObject( $this->className, $this->constructorArgs);
	// 	}

	// 	public function total($field = null, $value = null) {
	// 		$sql = 'SELECT COUNT(*)
	// 		FROM `' . $this->table . '`';
	// 		$parameters = [];
			
	// 		if(!empty($field)) {
	// 			$sql .= ' WHERE `' . $field . '` = :value';
	// 			$parameters = ['value' => $value];
	// 		}
	// 		$query = $this->query($sql,$parameters);
			
	// 		$row = $query->fetch();
	// 		return $row[0];
	// 	}

	// 	public function max($field = 'id')
	// 	{
	// 		$sql = 'SELECT MAX(`' . $field . '`) FROM `' . $this->table . '`';
	// 		$query = $this->query($sql);
	// 		$row = $query->fetch();
	// 		return $row[0];
	// 	}

	// 	public function max_year($year, $field = 'id' )
	// 	{
	// 		$sql = 'SELECT MAX(`' . $field . '`) FROM `' . $this->table . '` WHERE `year` = :value';
				
	// 		$parameters = ['value' => $year];

	// 		$query = $this->query($sql, $parameters);
	// 		$row = $query->fetch();

	// 		if ($row[0] != null) {
	// 			return $row[0];
	// 		} else {
	// 			return 0;
	// 		}	
	// 	}

	// 	public function sum( $sum_column, $field = null, $value = null )
	// 	{
	// 		$sql = 'SELECT SUM(`' . $sum_column . '`) FROM `'  . $this->table . '`';
	// 		$parameters = [];

	// 		if($field != null && $value != null) {
	// 			$sql .= ' WHERE `' . $field . '` = :value';
	// 			$parameters = ['value' => $value];
	// 		}

	// 		$query = $this->query($sql,$parameters);
			
	// 		$row = $query->fetch();
	// 		return $row[0];
	// 	}

}