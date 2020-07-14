<?php


namespace Zwei\GenerateSql;


use Zwei\GenerateSql\Mysql\BatchUpdateSql;

class GenerateSqlFacade
{
    
    /**
     * @param string $tableName
     * @param array $where
     * @param array $data
     * @param string $field
     * @return BatchUpdateSql
     */
    public function getMysqlBatchUpdateSql($tableName, array $where, array $data, $field)
    {
        $obj = new BatchUpdateSql($tableName, $where, $data, $field);
        return $obj;
    }
}
