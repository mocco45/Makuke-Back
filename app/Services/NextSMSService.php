<?php

namespace App\Services;

use GuzzleHttp\Client;

class NextSMSService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;
    protected $senderId;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('NEXT_SMS_API_URL');
        $this->apiKey = env('NEXT_SMS_API_KEY');
        $this->senderId = env('NEXTSMS_SENDER_ID');
    }

    public function sendSMS($to, $message)
    {
        $headers = [
            'Authorization' => 'Basic ' . $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $data = [
            'from' => $this->senderId,
            'to' => $to,
            'text' => $message,
            'reference' => 'aswqetgcv',
        ];

        $response = $this->client->post($this->apiUrl, [
            'headers' => $headers,
            'json' => $data,
        ]);

        return $response->getBody()->getContents();
    }

    public function generateReceiptNumber()
    {
        $receiptNumber = '';

        // Generating receipt number pattern: Number(1) + Characters(3) + Numbers(3) + Characters(2) + Number(1)
        $receiptNumber .= rand(1, 9); // Start with a random number between 1 and 9
        $receiptNumber .= $this->generateRandomCharacters(3);
        $receiptNumber .= rand(100, 999); // Generate a random 3-digit number
        $receiptNumber .= $this->generateRandomCharacters(2);
        $receiptNumber .= rand(0, 9); // End with a random single digit

        return $receiptNumber;
    }

    public function generateRandomCharacters($length = 3)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public function generateReceiptMessage($amountReceived, $recipient, $loanRemain,$contact)
    {
        $receiptNo = $this->generateReceiptNumber();
        $message = "Risiti Namba: $receiptNo\n";
        $message .= "Kiwango Ulicholipa: $amountReceived\n";
        $message .= "Mpokeaji: $recipient\n";
        $message .= "Deni Lililobaki: $loanRemain\n";
        $message .= "\n";
        $message .= "Kwa zaidi wasiliana nasi kupitia namba:\n"; 
        $message .= "$contact\n";



        return $message;
    }
}
