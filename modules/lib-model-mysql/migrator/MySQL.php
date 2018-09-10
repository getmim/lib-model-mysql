<?php
/**
 * MySQL migrator
 * @package lib-model-mysql
 * @version 0.0.1
 */

namespace LibModelMysql\Migrator;

use LibModelMysql\Library\{
    Data,
    Index,
    Query,
    Table
};
use Mim\Library\Fs;

class MySQL implements \LibModel\Iface\Migrator
{
    private $model;
    private $data;
    private $error;

    public function __construct(string $model, array $data){
        $this->model = $model;
        $this->data  = $data;
    }

    public function lastError(): ?string{
        return $this->error;
    }

    public function schema(string $file): bool{
        $diff = $this->test();
        if(!$diff)
            return true;

        $sql = Query::build($this->model, $this->data, $diff);

        if($sql){
            $target_file = $file . '.sql';
            Fs::write($target_file, $sql, true);
        }

        return true;
    }

    public function start(): bool{
        $diff = $this->test();
        if(!$diff)
            return true;

        $sqls = Query::buildMutliple($this->model, $this->data, $diff, false);
        if(!$sqls)
            return true;

        $model = $this->model;

        $result = true;

        foreach($sqls as $sql){
            $res = $model::query($sql, 'write');
            if(!$res){
                $result = false;
                $this->error = $model::lastError();
            }
        }
        
        return $result;
    }

    public function test(): ?array{
        $result = [];
        
        // table structure
        $res_table = Table::test($this->model, $this->data['fields']);
        if($res_table)
            $result = array_replace($result, $res_table);

        // index structure
        $res_index = Index::test($this->model, $this->data['indexes'] ?? [], $this->data['fields']);
        if($res_index)
            $result = array_replace($result, $res_index);

        // data row
        if(isset($this->data['data'])){
            $res_data = Data::test($this->model, $this->data['data']);
            if($res_data)
                $result = array_replace($result, $res_data);
        }

        return $result;
    }
}