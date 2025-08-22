<?php

namespace Danupe\Plugin\User\Services;

use Danupe\Core\Classes\DataTableQuery;
use Danupe\Plugin\Database\Classes\Database;

class UserTableService
{
    public function __construct(private readonly DataTableQuery $dataTable = new DataTableQuery()) {}

    /**
     * Fetch paginated/searchable/sortable user table data.
     * @param array $params request-derived params
     * @return array ['total'=>int,'data'=>[]]
     */
    public function fetch(array $params): array
    {
        $db = new Database('users');

        return $this->dataTable->build($db, $params, [
            'searchColumns' => ['email','role'],
            'allowedSort'   => ['id','email','role'],
            'defaultSort'   => ['id' => 'asc'],
            'select'        => ['id','email','role'],
        ]);
    }
}
