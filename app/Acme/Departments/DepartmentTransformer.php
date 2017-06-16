<?php

namespace App\Acme\Departments;

use League\Fractal\TransformerAbstract;

use App\Department;

class DepartmentTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(Department $department) {

        if($this->total == 1) {
            return [
                'name' => $department->nama,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.departments.show', ['id' => $department->id]),
                'name' => $department->nama,
            ];
        }
    }
}
