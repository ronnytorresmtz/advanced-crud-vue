<?php namespace MyCode\Repositories\Eloquent;
 
interface MyEloquentRepositoryInterface {
   
  public function all();
  public function paginate($itemsByPage);
  public function find($id);
  public function where($column, $operator = null, $value = null, $boolean = 'and');
  public function orWhere($column, $operator = null, $value = null);
  public function join($table, $one, $operator = null, $two = null, $type = 'inner', $where = false);
  public function leftJoin($table, $first, $operator = null, $second = null);
  public function orderBy($column, $direction = 'asc');
 
}