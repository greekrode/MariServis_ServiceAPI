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
            // $cs = new CustomSerializer();
            // $services = array();
            // $new_formatted_service = array();
            //
            // foreach ($staff->services->sortBy('id') as $service) {
            //     $resourceKey = "service";
            //     // formatted
            //     $new_formatted_service['url'] = route('api.v1.services.show', ['id' => $service->id]);
            //     $new_formatted_service['serviceId'] = $service['id'];
            //
            //     // REMEMBER: APPENDING "ITEM(JSON OF $new_formatted_service)" to "$services = array()"
            //     $services[] = $cs->item($resourceKey, $new_formatted_service);
            // }

            $department = [
                'url' => route('api.v1.departments.show', ['id' => $staff->department->id]),
                'name' => ucfirst($staff->department->nama),
            ];

            return [
                'name' => (String) ucfirst($staff->nama),
                'phoneNumber' => (String) $staff->no_telp,
                'address' => (String) $staff->alamat,
                'department' => $department,
                // 'services' => $services,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.staffs.show', ['id' => $staff->id]),
                'name' => (String) ucfirst($staff->nama),
            ];
        }
    }
}
