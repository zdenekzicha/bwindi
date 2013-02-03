<?php

/**
 * Provádí operace nad databázovou tabulkou.
 */
class Kids extends NObject
{
    /** @var Nette\Database\Connection */
    protected $connection;

    public function __construct(NConnection $db)
    {
        $this->connection = $db;
    }

    /**
     * Vrací objekt reprezentující databázovou tabulku.
     * @return Nette\Database\Table\Selection
     */
    protected function getTable()
    {
        return $this->connection->table("kids");
    }

    /**
     * Vrací všechny řádky z tabulky.
     * @return Nette\Database\Table\Selection
     */
    public function findAll()
    {
        return $this->getTable();
    }

    /**
     * Vrací řádky podle filtru, např. array('name' => 'John').
     * @return Nette\Database\Table\Selection
     */
    public function findBy(array $by)
    {
        return $this->getTable()->where($by);
    }

}