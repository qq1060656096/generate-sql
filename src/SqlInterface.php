<?php


namespace Zwei\GenerateSql;


interface SqlInterface
{
    /**
     * @return void
     */
    public function compile();
    
    /**
     * @return string
     */
    public function getTableName();
    
    /**
     * @return string
     */
    public function getSql();
    
    /**
     * @return string
     */
    public function getPlaceholderSql();
    
    /**
     * @return array
     */
    public function getPlaceholderParams();
    
    /**
     * @return string $rawSql
     */
    public function toString();
    
    /**
     * @return array [$placeholderSql, $placeholderParams]
     */
    public function toArray();
}
