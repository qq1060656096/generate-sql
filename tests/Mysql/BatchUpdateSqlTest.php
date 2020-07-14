<?php
namespace Zwei\GenerateSql\Tests\Mysql;


use Zwei\GenerateSql\Mysql\BatchUpdateSql;

class BatchUpdateSqlTest extends \PHPUnit\Framework\TestCase
{
    public function testGet()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'andy.update.1',
                'age' => 110.6,
            ],
            [
                'id' => 2,
                'name' => 'yoki.update.2',
                'age' => 4.5,
            ],
        ];
        $where = [
            [
                'id' => 1,
                'name' => 'andy',
                'age' => 110,
            ],
            [
                'id' => 2,
                'name' => 'yoki',
                'age' => 4,
            ],
        ];
        $field = 'id';
        $obj = new BatchUpdateSql('test', $where, $data, $field);
        var_dump("\n", $obj->getSql(), $obj->getPlaceholderSql(), $obj->getPlaceholderParams());
        $this->assertTrue(true);
    }
}
