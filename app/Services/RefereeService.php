<?php
namespace App\Services;

use App\Models\Referee;

class RefereeService
{

    public function store($request, $cid)
    {
            
            if ($request->hasFile('ref_photo')) {
            $uploadedRefFile = $request->file('ref_photo');
            $refImage = time() . '.' . $uploadedRefFile->getClientOriginalExtension();
            $uploadedRefFile->storeAs('public/images/referee', $refImage);
            }
            else{
                
                return response()->json(['there is error in ref_photo']);
            }
           
            if ($request->hasFile('ref_photo')) {
            $uploadedRef2File = $request->file('ref_photo');
            $ref2Image = time() . '.' . $uploadedRef2File->getClientOriginalExtension();
            $uploadedRef2File->storeAs('public/images/referee', $ref2Image);
            }
            else{
                return response()->json(['there is error in ref2_photo']);
            }

            $Referee1 = [
                'firstName' => $request->ref_firstName,
                'lastName' => $request->ref_lastName,
                'gender' => $request->ref_gender,
                'occupation' => $request->ref_occupation,
                'region' => $request->ref_region,
                'district' => $request->ref_district,
                'street' => $request->ref_street,
                'photo' => $refImage,
                'nida' => $request->nida,
                'phone' => $request->ref_phone,
                'customer_loan_id' => $cid
            ];

            $Referee2 = [
                'firstName' => $request->ref2_firstName,
                'lastName' => $request->ref2_lastName,
                'gender' => $request->ref2_gender,
                'occupation' => $request->ref2_occupation,
                'region' => $request->ref2_region,
                'district' => $request->ref2_district,
                'street' => $request->ref2_street,
                'photo' => $ref2Image,
                'nida' => $request->nida,
                'phone' => $request->ref2_phone,
                'customer_loan_id' => $cid
            ];

            $Ref1 = Referee::create($Referee1);
            $Ref2 = Referee::create($Referee2);
            $ref1 = $Ref1->id;
            $ref2 = $Ref2->id;
            $Gservice = app(GuaranteeService::class);
            $Gservice->Rstore($request, $ref1, $ref2);
            $Gservice->Cstore($request, $cid);

            return response()->json(["Referee Created Successfully"]);

    }
}