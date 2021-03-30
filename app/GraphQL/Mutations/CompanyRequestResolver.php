<?php

namespace App\GraphQL\Mutations;

use App\User;
use App\CompanyRequest;
use App\Jobs\SendPushNotification;
use App\Traits\HandleDeviceTokens;
use App\Exceptions\CustomException;

class CompanyRequestResolver
{
    use HandleDeviceTokens;

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */

    public function create($_, array $args)
    {
        try {
            $input = collect($args)->except(['directive'])->toArray();

            User::updateSecondaryNumber($args['contact_phone']);

            $companyRequest = CompanyRequest::create($input);
        } catch (\Exception $e) {
            throw new CustomException('We could not able to create this company request!');
        }

        return $companyRequest;
    }

    public function update($_, array $args)
    {
        try {
            $input = collect($args)->except(['id', 'directive'])->toArray();
            $companyRequest = CompanyRequest::findOrFail($args['id']);

            if (array_key_exists('contact_phone', $args) && $args['contact_phone'])
                User::updateSecondaryNumber($args['contact_phone']);
    
            $companyRequest->update($input);
        } catch (\Exception $e) {
            throw new CustomException('We could not able to update this company request!');
        }

        return $companyRequest;
    }

    public function changeStatus($_, array $args)
    {
        try {
            $updateInput = collect($args)->only(['status', 'response'])->toArray();

            switch($args['status']) {
                case 'PENDING':
                    CompanyRequest::restore($args['requestIds']);
                    break;

                default:
                    CompanyRequest::exclude($args['requestIds'], $updateInput);
                    if (array_key_exists('notify', $args) && $args['notify'])
                        $this->notifyUsers($args);
                    break;
            }
            
        } catch (\Exception $e) {
            throw new CustomException('We could not able to change selected requests status!');
        }

        return "selected requests status has been changed";
    }

    protected function notifyUsers(array $args)
    {
        try {
               
            foreach($args['users'] as $user) {

                $responseMsg = 'Your company request # ' 
                    . $user['requestId'] . ' has been ' 
                    . strtolower($args['status']);
    
                if (array_key_exists('response', $args) && $args['response']) 
                    $responseMsg .= '. '. $args['response'];

                SendPushNotification::dispatch(
                    $this->userToken($user['userId']), 
                    $responseMsg, 
                    'Qruz to School',
                    ['view' => 'CompanyRequest', 'id' => $user['requestId']]
                );
            }
        } catch (\Exception $e) {
            //
        }
    }
    
    public function destroy($_, array $args)
    {
        try {
            CompanyRequest::whereIn('id', $args['id'])->delete();
        } catch (\Exception $e) {
            throw new CustomException('We could not able to delete selected requests!');
        }

        return "Selected requests have been deleted";
    }
}
