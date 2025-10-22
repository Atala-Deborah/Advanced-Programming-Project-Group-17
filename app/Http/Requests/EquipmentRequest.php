<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ElectronicsPhaseRule;

class EquipmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'FacilityId' => 'required|exists:facilities,FacilityId',
            'Name' => 'required|string|max:255',
            'Capabilities' => 'required|string',
            'Description' => 'nullable|string',
            'InventoryCode' => 'required|string|unique:equipment,InventoryCode',
            'UsageDomain' => 'required|string|in:Electronics,Mechanical,IoT',
            'SupportPhase' => ['required', 'string', new ElectronicsPhaseRule()],
        ];
    }
}