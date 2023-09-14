<?php

namespace App\Http\Controllers;

use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\GetCurrenciesInfoByIsoCodesInput;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\GetCurrenciesInfoByIsoCodesUseCase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GetCurrenciesInfoByIsoCodesController extends Controller
{
    public function __construct(
        private readonly GetCurrenciesInfoByIsoCodesUseCase $useCase
    )
    {
    }

    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isoCodes' => 'required|array|min:1',
            'isoCodes.*' => 'required|alpha|size:3'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $isoCodeList = $request->input('isoCodes');
        try {
            $result = $this->useCase->execute(new GetCurrenciesInfoByIsoCodesInput($isoCodeList));
            return response()->json($result->currencyInfoList);
        } catch (Exception $e) {
            Log::error('Error to process request: ' . $e->getMessage());
            abort(500);
        }
    }
}
