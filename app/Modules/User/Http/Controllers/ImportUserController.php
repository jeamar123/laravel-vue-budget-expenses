<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Actions\CreateUserAction;
use Illuminate\Http\JsonResponse;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\Request;
use App\Modules\User\Models\User;

class ImportUserController
{
    public function __invoke( 
        Request $request,
        CreateUserAction $createUserAction,
    ): JsonResponse 
    {
        $file = $request->file('file');
        $collection = (new FastExcel)->import($file);
        $results = [];

        foreach ($collection as $index => $user) {
            $first_name = str_replace(' ', '',$user['First Name']);
            $last_name = str_replace(' ', '',$user['Last Name']);
            $full_name = $first_name . ' ' . $last_name;
            $email = $user['Email'];
            $checkDuplicate = User::where('full_name', $full_name)->count();
            if(!$checkDuplicate){
                $createUserAction->execute([
                  'full_name' => $full_name, 
                  'first_name' => $first_name, 
                  'last_name' => $last_name, 
                  'email' => isset($user['Email']) ? $user['Email'] : '', 
                  'code' => isset($user['Code']) ? $user['Code'] : '', 
                  'group' => isset($user['Group']) ? $user['Group'] : '', 
                ]);

                array_push($results, 'User ' . $full_name . ' sucessfully uploaded.');
            }else{
                array_push($results, 'User ' . $full_name . ' already exist. Failed to upload.');
            }
        }
        
        return response()->json([
            'data' => $collection,
            'results' => $results,
            'message' => 'Success',
        ], 201);
    }
}