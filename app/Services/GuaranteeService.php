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
        else{
            echo 'there is error in ref guarantee';
        }
        
        // Check if the first referee guarantee image was uploaded
        if ($request->hasFile('ref2_trusteeGuaranteeImage')) {
            $uploadedR2File = $request->file('ref2_trusteeGuaranteeImage');
            $ref2GuaranteeImg = time() . '.' . $uploadedR2File->getClientOriginalExtension();
            $uploadedR2File->storeAs('public/images/referee-guarantees', $ref2GuaranteeImg);
        }
        else{
            echo 'there is error in ref2 guarantee';
        }
        $txtConvert = $request->ref_trusteeGuaranteeValue;
        $amountRef1 = (int)str_replace(',', '', $txtConvert);

        Referee_Guarantee::create([
            'property_name' => $request->ref_trusteeGuaranteeName,
            'photo_ref_guarantee' => $refGuaranteeImg,
            'value' => $amountRef1,
            'region' => $request->ref_region,
            'district' => $request->ref_district,
            'street' => $request->ref_street,
            'referee_id' => $id1
        ]);

        $txtConvert2 = $request->ref2_trusteeGuaranteeValue;
        $amountRef2 = (int)str_replace(',', '', $txtConvert2);

        Referee_Guarantee::create([
            'property_name' => $request->ref2_trusteeGuaranteeName,
            'photo_ref_guarantee' => $ref2GuaranteeImg,
            'value' => $amountRef2,
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
        else{
            echo 'there is error in customer guarantee';
        }

        $txtConvert = $request->customerGuaranteeValue;
        $amount = (int)str_replace(',', '', $txtConvert);

        $verify = Customer_Guarantee::create([
            'property_name' => $request->customerGuaranteeName,
            'photo_customer_guarantee' => $customerGuaranteeImage,
            'value' => $amount,
            'region' => $request->region, 
            'district' => $request->district,
            'street' => $request->street,
            'customer_loan_id' => $id
        ]);

        if($verify){
            try {
                $sendin = new NextSMSService();
                $fullName = $request->firstName . ' ' . $request->lastName;
                $message = "Hongera na karibu kwenye familia! $fullName Tunafurahi Kukujulisha kua Mkopo wako umeshasajiliwa kikamilifu kwenye mfumo wetu.\n";
                $message .= "Wasiliana nasi kwa Msaada kuhusu huduma zetu:\n";
                $message .= "Office\n";
                $message .= "0769461300\n"; 
                $message .= "0672461304\n";
                $message .= "CEO\n"; 
                $message .= "0769963421";
                $tel = $request->phone;
                $response = $sendin->sendSMS($tel, $message);
        
                echo $response;
            } catch (\Throwable $th) {
                return response()->json(['Error occurred', 'error' => $th->getMessage()], 500);
            }
        }



    }
    
}