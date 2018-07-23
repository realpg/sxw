<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/20
 * Time: 16:40
 */

namespace App\Http\Controllers;

class SortContainer
{
	private $array = array();
	private $primaryKey;
	private $keys;
	private $volume;
	
	function __construct($array, $primaryKey, $keys, $volume = 0)
	{
		$this->array = $array;
		$this->primaryKey = $primaryKey;
		$this->keys = $keys;
		$this->volume = $volume;
	}
	
	public function push($value)
	{
		$exist = false;
		foreach ($this->array as $key=>$valueArr) {
			if ($valueArr[$this->primaryKey] == $value[$this->primaryKey]) {
				$exist = true;
				$this->array[$key] = array_merge($valueArr, $value);
			}
		}
		if (!$exist)
			array_push($this->array, $value);
		$this->sort();
		if (count($this->array) > $this->volume) {
			array_pop($this->array);
		}
	}
	
	public function sort()
	{
		$cnt = count($this->array);
		for ($i = 0; $i < $cnt - 1; $i++) {
			for ($j = 0; $j < $cnt - $i - 1; $j++) {
				for ($k = 0; $k < count($this->keys); $k++) {
					if (array_key_exists($this->keys[$k], $this->array[$j]) && array_key_exists($this->keys[$k], $this->array[$j + 1]))
						if ($this->array[$j][$this->keys[$k]] == $this->array[$j + 1][$this->keys[$k]]) {
							continue;
						} else if ($this->array[$j][$this->keys[$k]] < $this->array[$j + 1][$this->keys[$k]]) {
							$temp = $this->array[$j];
							$this->array[$j] = $this->array[$j + 1];
							$this->array[$j + 1] = $temp;
							break;
						}
				}
			}
		}
	}
	
	public function getArray()
	{
		return $this->array;
	}
}