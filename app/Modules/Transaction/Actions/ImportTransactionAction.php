<?php

namespace App\Modules\Transaction\Actions;

use App\Modules\Transaction\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\JsonResponse;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportTransactionAction
{
    public function __construct(protected Auth $auth)
    {

    }

    public function execute(array $transactions)
    {   
        $collection = (new FastExcel)->import($transactions['file']);
        $success = [];
        $failed = [];

        foreach ($collection as $index => $transaction) {
            $upload = Transaction::create([
                  'user_id' => $this->auth->user()->id,
                  'description' => isset($transaction['Description']) ? $transaction['Description'] : '', 
                  'total' => isset($transaction['Total']) ? $transaction['Total'] : '', 
                  'source' => isset($transaction['Source']) ? $transaction['Source'] : '', 
                  'category' => isset($transaction['Category']) ? $transaction['Category'] : '', 
                  'date' => isset($transaction['Date']) ? $transaction['Date'] : '', 
                ]);
                
            if($upload){
                array_push($success, 'Row ' . ($index+1) . ' sucessfully uploaded.');
            }else{
                array_push($failed, 'Row ' . ($index+1) . ' upload failed.');
            }
        }

        return [
            'collection' => $collection,
            'success' => $success,
            'failed' => $failed,
        ];
    }
}
