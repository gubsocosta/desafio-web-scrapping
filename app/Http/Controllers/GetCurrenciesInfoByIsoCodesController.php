<?php

namespace App\Http\Controllers;

use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\GetCurrenciesInfoByIsoCodesInput;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\GetCurrenciesInfoByIsoCodesUseCase;
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
        $this->validateRequestInputs($request->all());
        $isoCodeList = array_unique($request->input('isoCodes'));
        try {
            $result = $this->useCase->execute(new GetCurrenciesInfoByIsoCodesInput($isoCodeList));
            return response()->json($result->currencyInfoList);
        } catch (\Exception $e) {
            Log::error('Error to process request: ' . $e->getMessage());
            abort(500);
        }
    }

    /**
     * @param array $requestInputs
     * @return void
     */
    private function validateRequestInputs(array $requestInputs): void
    {
        $validator = Validator::make($requestInputs, [
            'isoCodes' => 'required|array|min:1',
            'isoCodes.*' => 'required|alpha|size:3'
        ]);

        if ($validator->fails()) {
            response()->json(['errors' => $validator->errors()], 422);
        }
    }
}
