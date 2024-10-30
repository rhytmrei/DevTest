<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
use App\Services\Contracts\ZohoServiceContract;
use Illuminate\Http\JsonResponse;

class ZohoController extends Controller
{
    public function __construct(protected ZohoServiceContract $zohoService)
    {
        //
    }

    public function deals(): JsonResponse
    {
        $deals = $this->zohoService->getDataByModule('Deals', 'Deal_Name,Stage,Account_Name');

        if ($deals !== false) {
            return response()->json($deals, 200);
        }

        return response()->json(['message' => 'Failed to retrieve deals.'], 500);
    }

    public function create(CreateRequest $request): JsonResponse
    {
        $accountData = $request->input('account');
        $dealData = $request->input('deal');

        $accountResponse = $this->zohoService->createByModule('Accounts', $accountData);

        if ($accountResponse->failed()) {
            return response()->json(['error' => 'Account creation failed'], 500);
        }

        $accountResponseData = $accountResponse->json()['data'];
        $accountData = reset($accountResponseData);

        $dealData['Account_Name'] = ['id' => $accountData['details']['id']];
        $dealResponse = $this->zohoService->createByModule('Deals', $dealData);

        if ($dealResponse->failed()) {
            return response()->json(['status' => 'error', 'message' => 'Deal creation failed'], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Deal and Account created successfully',
            'account' => $accountData,
            'deal' => $dealResponse->json()['data'],
        ]);
    }

}
