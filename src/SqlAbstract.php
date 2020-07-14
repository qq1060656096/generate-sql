<?php


namespace Zwei\GenerateSql;


abstract class SqlAbstract implements SqlInterface
{
    protected $tableName = '';
    protected $sql = '';
    protected $placeholderSql = '';
    protected $placeholderParams = [];
    protected $isCompile = false;
    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }
    
    /**
     * @return string
     */
    public function getSql()
    {
        if (!$this->isCompile) {
            $this->compile();
        }
        return $this->sql;
    }
    
    /**
     * @return string
     */
    public function getPlaceholderSql()
    {
        if (!$this->isCompile) {
            $this->compile();
        }
        return $this->placeholderSql;
    }
    
    /**
     * @return array
     */
    public function getPlaceholderParams()
    {
        if (!$this->isCompile) {
            $this->compile();
        }
        return $this->placeholderParams;
    }
    
    /**
     * @inheritDoc
     */
    public function toString()
    {
        return $this->getSql();
    }
    
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [$this->getPlaceholderSql(), $this->getPlaceholderParams()];
    }
    
}
