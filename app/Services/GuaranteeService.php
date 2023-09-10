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
            'photo' => $refGuaranteeImg,
            'value' => $request->ref_trusteeGuaranteeValue,
            'property_address' => $request->ref_trusteeGuaranteeLocation, 
            'referee_id' => $id1
        ]);

        Referee_Guarantee::create([
            'property_name' => $request->ref2_trusteeGuaranteeName,
            'photo' => $ref2GuaranteeImg,
            'value' => $request->ref2_trusteeGuaranteeValue,
            'property_address' => $request->ref2_trusteeGuaranteeLocation, 
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
            'photo' => $customerGuaranteeImage,
            'value' => $request->customerGuaranteeValue,
            'property_address' => $request->customerGuaranteeLocation,
            'customer_loan_id' => $id
        ]);
    }
}