<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\Http;

class CustomerPhone
{
    public $plate;

    /**
     * CustomerPhone constructor.
     * @param $plate
     */
    public function __construct($plate)
    {
        $this->plate = str_replace(' ', '', $plate);
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        $contacts = [];
//        $customer = Customer::where('PlateNumber', $this->plate)->first();
//
//        if ($customer) {
//            $contacts[] = $customer->CustomerPhoneNumber;
//            $contacts[] = $customer->CustomerPhoneNumber2;
//
//        } else {

            $login = Http::asForm()->post('https://mac.petromin.com/Services/KSA/MiGeneralApi/token', [
                'username' => 'chatbotServiceUser',
                'password' => 'Admin',
                'grant_type' => 'password'
            ]);


            $token = $login->json();
            $data = [
                [
                    'PlateNumber' => $this->plate,
                ]
            ];

            $url = 'https://mac.petromin.com/Services/KSA/MiGeneralApi/MiAPI/CustomerPhoneNumber';
            $headers = [
                'Authorization' => "Bearer {$token['access_token']}",
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);
            $result = json_decode($res);

            if ($result[0]->success == "True" and $result[0]->data == 1) {
                $phone1 = $result[0]->CustomerPhoneNumber;
                if (!is_null($phone1)) {
                    $phone1 = 'whatsapp:+' . phoneHandeler($result[0]->CustomerPhoneNumber);
                }
                $phone2 = $result[0]->CustomerPhoneNumber2;
                if (!is_null($phone2)) {
                    $phone2 = 'whatsapp:+' . phoneHandeler($result[0]->CustomerPhoneNumber);
                }

                $PlateNumber = str_replace(' ', '', $result[0]->PlateNumber);

                Customer::create([
                    'PlateNumber' => $PlateNumber,
                    'NameAr' => $result[0]->NameAr,
                    'NameEn' => $result[0]->NameEn,
                    'CustomerPhoneNumber' => $phone1,
                    'CustomerPhoneNumber2' => $phone2,
                ]);

                $contacts[] = $phone1;
                $contacts[] = $phone2;

            }

//        }

        return $contacts;

    }


}
