<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'id' => ucfirst(strtolower($this->Employees->id)),
                'salutation' => ucfirst(strtolower($this->Employees->salutation)),
                'Fname' => ucfirst(strtolower($this->Employees->Fname)),
                'street' => ucfirst(strtolower($this->Employees->street)),
                'apartment' => ucfirst(strtolower($this->Employees->apartment)),
                'city' => ucfirst(strtolower($this->Employees->city)),
                'state' => ucfirst(strtolower($this->Employees->state)),
                'Zcode' => ucfirst(strtolower($this->Employees->Zcode)),
                'Hphone' => ucfirst(strtolower($this->Employees->Hphone)),
                'Aphone' => ucfirst(strtolower($this->Employees->Aphone)),
                'Pemail' => ucfirst(strtolower($this->Employees->Pemail)),
                'nationalId' => ucfirst(strtolower($this->Employees->nationalId)),
                'Krapin' => ucfirst(strtolower($this->Employees->Krapin)),
                'nssf' => ucfirst(strtolower($this->Employees->nssf)),
                'nhif' => ucfirst(strtolower($this->Employees->nhif)),
                'Bankname' => ucfirst(strtolower($this->Employees->Bankname)),
                'AccNo' => ucfirst(strtolower($this->Employees->AccNo)),
                'Branchname' => ucfirst(strtolower($this->Employees->Branchname)),
                'Branchcode' => ucfirst(strtolower($this->Employees->Branchcode)),
                'dob' => ucfirst(strtolower($this->Employees->dob)),
                'status' => ucfirst(strtolower($this->Employees->status)),
                'spouseN' => ucfirst(strtolower($this->Employees->spouseN)),
                'spouseE' => ucfirst(strtolower($this->Employees->spouseE)),
                'spousePhone' => ucfirst(strtolower($this->Employees->spousePhone)),
                'title' => ucfirst(strtolower($this->jobInfos->title)),
                'EmployeeId' => ucfirst(strtolower($this->jobInfos->EmployeeId)),
                'supervisor' => ucfirst(strtolower($this->jobInfos->supervisor)),
                'department' => ucfirst(strtolower($this->jobInfos->department)),
                'Wlocation' => ucfirst(strtolower($this->jobInfos->Wlocation)),
                'Cphone' => ucfirst(strtolower($this->jobInfos->Cphone)),
                'Wphone' => ucfirst(strtolower($this->jobInfos->Wphone)),
                'Wemail' => ucfirst(strtolower($this->jobInfos->Wemail)),
                'Sdate' => ucfirst(strtolower($this->jobInfos->Sdate)),
                'Fname' => ucfirst(strtolower($this->emergency->Fname)),
                'street' => ucfirst(strtolower($this->emergency->street)),
                'apartment' => ucfirst(strtolower($this->emergency->apartment)),
                'city' => ucfirst(strtolower($this->emergency->city)),
                'state' => ucfirst(strtolower($this->emergency->state)),
                'Zcode' => ucfirst(strtolower($this->emergency->Zcode)),
                'Pphone' => ucfirst(strtolower($this->emergency->Pphone)),
                'Aphone' => ucfirst(strtolower($this->emergency->Aphone)),
                'relationship' => ucfirst(strtolower($this->emergency->relationship)),
                'Images' => $this->Images,
            ]
        ];
    }
}
