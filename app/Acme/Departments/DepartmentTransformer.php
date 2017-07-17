<?php

namespace App\Acme\Departments;

use League\Fractal\TransformerAbstract;
use App\Extensions\Serializers\CustomSerializer;

use App\Department;

class DepartmentTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(Department $department) {

        if($this->total == 1) {
            $cs = new CustomSerializer();
            $staffs = array();
            $new_staff_formatted = array();

            foreach ($department->staffs->sortBy('id') as $staff) {
                $resourceKey = "staff";
                // formatted
                $new_staff_formatted['url'] = route('api.v1.staffs.show', $staff->id);
                $new_staff_formatted['name'] = $staff->nama;
                // appending to $staff array, same as array_push($staff, $cs->item(..., ...));
                $staffs[] = $cs->item($resourceKey, $new_staff_formatted);
            }

            if(count($staffs) == 0) {
                return [
                    'name' => $department->nama,
                ];
            } else {
                return [
                    'name' => $department->nama,
                    'staffs' => $staffs,
                ];
            }
        } else {
            return [
                'url' => (String) route('api.v1.departments.show', ['id' => $department->id]),
                'name' => $department->nama,
            ];
        }
    }
}
