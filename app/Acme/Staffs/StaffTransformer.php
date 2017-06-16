<?php

namespace App\Acme\Staffs;

use League\Fractal\TransformerAbstract;
use App\Extensions\Serializers\CustomSerializer;

use App\Staff;

class StaffTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(Staff $staff) {

        if($this->total == 1) {
            $services = [];

            foreach ($staff->services as $service) {
                $cs = new CustomSerializer();
                $resourceKey = "service";

                $services[] = $cs->item($resourceKey, $service->toArray());
            }

            return [
                'name' => (String) $staff->nama,
                'phone_number' => (Int) $staff->no_telp,
                'address' => (String) $staff->alamat,
                'department' => (String) $staff->department->nama,
                'services' => $services,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.staffs.show', ['id' => $staff->id]),
                'name' => (String) $staff->nama,
                'phone_number' => (Int) $staff->no_telp,
                'address' => (String) $staff->alamat,
                'department' => (String) $staff->department->nama,
            ];
        }
    }
}
