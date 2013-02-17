<?php



class Model extends NObject
{
	/** @var NConnection */
	private $database;

	public function __construct(NConnection $database)
	{
		$this->database = $database;
	}

	public function getDb() {
		return $this->database;
	}
	
	protected function getTable()
	{
		preg_match('#(\w+)Model$#', get_class($this), $m);
		return $this->database->table(lcfirst($m[1]));
	}

	public function findAll() {
		return $this->getTable();
	}

	public function findBy(array $by)
    {
        return $this->getTable()->where($by);
    }

    /** @return NTableRow */
	public function findById($id)
	{
		return $this->findAll()->get($id);
	}

	public function insert($values)
	{
		return $this->findAll()->insert($values);
	}

}
