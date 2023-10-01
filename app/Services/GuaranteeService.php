<?php
namespace App\Services;

use App\Models\Customer_Guarantee;
use App\Models\Referee_Guarantee;

class GuaranteeService
{
    public function Rstore($request, $id1, $id2)
    {

        if ($request->hasFile('ref_trusteeGuaranteeImage')) {
            $uploadedRFile = $request->file('ref_trusteeGuaranteeImage');
            $refGuaranteeImg = time() . '.' . $uploadedRFile->getClientOriginalExtension();
            $uploadedRFile->storeAs('public/images/referee-guarantees', $refGuaranteeImg);
        }
        
        // Check if the first referee guarantee image was uploaded
        if ($request->hasFile('ref2_trusteeGuaranteeImage')) {
            $uploadedR2File = $request->file('ref2_trusteeGuaranteeImage');
            $ref2GuaranteeImg = time() . '.' . $uploadedR2File->getClientOriginalExtension();
            $uploadedR2File->storeAs('public/images/referee-guarantees', $ref2GuaranteeImg);
        }

        Referee_Guarantee::create([
            'property_name' => $request->ref_trusteeGuaranteeName,
            'photo_ref_guarantee' => $refGuaranteeImg,
            'value' => $request->ref_trusteeGuaranteeValue,
            'region' => $request->ref_region,
            'district' => $request->ref_district,
            'street' => $request->ref_street,
            'referee_id' => $id1
        ]);

        Referee_Guarantee::create([
            'property_name' => $request->ref2_trusteeGuaranteeName,
            'photo_ref_guarantee' => $ref2GuaranteeImg,
            'value' => $request->ref2_trusteeGuaranteeValue,
            'region' => $request->ref2_region,
            'district' => $request->ref2_district,
            'street' => $request->ref2_street, 
            'referee_id' => $id2
        ]);
    }

    public function Cstore($request, $id)
    {
        if($request->hasFile('customerGuaranteeImage')){
            $img = $request->file('customerGuaranteeImage');
            $customerGuaranteeImage = time() . '.' .$img->getClientOriginalExtension();
            $img->storeAs('public/images/customer-guarantees', $customerGuaranteeImage);

        }

        Customer_Guarantee::create([
            'property_name' => $request->customerGuaranteeName,
            'photo_customer_guarantee' => $customerGuaranteeImage,
            'value' => $request->customerGuaranteeValue,
            'region' => $request->ref_region,
            'district' => $request->ref_district,
            'street' => $request->ref_street,
            'customer_loan_id' => $id
        ]);
    }
}