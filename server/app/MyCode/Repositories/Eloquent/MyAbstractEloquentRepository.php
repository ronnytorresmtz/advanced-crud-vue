<?php namespace MyCode\Repositories\Eloquent;


abstract class MyAbstractEloquentRepository {
 
  public function all()
  {
    return $this->model->all();
  }

  public function paginate($itemsByPage) 
  {
    return $this->model->paginate($itemsByPage);
  }

  public function find($id)
  {
    return $this->model->find($id); 
  }

  public function where($column, $operator = null, $value = null, $boolean = 'and')
  {
    return $this->model->where($column, $operator, $value, $boolean);
  }

  public function orWhere($column, $operator = null, $value = null)
  {
    return $this->model->where($column, $operator, $value, 'or');
  }

  public function join($table, $one, $operator = null, $two = null, $type = 'inner', $where = false)
  {
    return $this->model->join($table, $one, $operator, $two, $type, $where); 
  }

  public function leftJoin($table, $first, $operator = null, $second = null)
  {
    return $this->model->leftJoin($table, $first, $operator, $second);
  }

  public function orderBy($column, $direction = 'asc')
  {  
    return $this->model->orderBy($column, $direction);
  }

 
}