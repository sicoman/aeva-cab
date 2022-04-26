<?php

namespace App\Repository\Eloquent\Mutations;

use JWTAuth;

use App\Driver;
use App\Document;
use App\DriverVehicle;
use App\PartnerDriver;

use App\Jobs\SendOtp;
use App\Traits\HandleUpload;
use App\Exceptions\CustomException;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Repository\Eloquent\BaseRepository;
use App\Repository\Mutations\DriverRepositoryInterface;

class DriverRepository extends BaseRepository implements DriverRepositoryInterface
{
    use HandleUpload;

    public function __construct(Driver $model)
    {
        parent::__construct($model);
    }

    public function handleAvatar(array $args)
    {
        try {
            $driver = $this->model->findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            throw new CustomException(__('lang.driver_not_found'));
        }

        if ($driver->avatar) $this->deleteOneFile($driver->avatar, 'avatars');
        $url = $this->uploadOneFile($args['avatar'], 'avatars');

        $driver->update(['avatar' => $url]);

        return $driver;
    }

    public function create(array $args)
    {
        $input = collect($args)->except(['directive', 'avatar'])->toArray();
        $input['password'] = Hash::make($input['phone']);
        $input['status'] = true;
 
        if (array_key_exists('avatar', $args) && $args['avatar']) {
            $url = $this->uploadOneFile($args['avatar'], 'avatars');
            $input['avatar'] = $url;
        }

        $driver = $this->model->create($input);

        if (array_key_exists('car_type_id', $args) && $args['car_type_id']) {
            Auth::onceUsingId($driver->id);
            $driver->token = JWTAuth::fromUser($driver);
        }

        $verification_code = mt_rand(1000, 9999);

        $message = __('lang.verification_code', [
            'verification_code' => $verification_code,
            'signature' => config('custom.otp_signature'),
        ]);
        
        SendOtp::dispatch($args['phone'], $message);

        $driver->verification_code = $verification_code;

        $row = [
            'documentable_id' => $driver->id,
            'documentable_type' =>'App\\Driver',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        for ($i = 0; $i < 10; $i++) {$rows[] = $row;}

        $rows[0]['name'] = 'البطاقة الشخصية:اﻷمام';
        $rows[1]['name'] = 'البطاقة الشخصية:الخلف';
        $rows[2]['name'] = 'رخصة قيادة مصرية سارية';
        $rows[3]['name'] = 'رخصة سيارة سارية:اﻷمام';
        $rows[4]['name'] = 'رخصة سيارة سارية:الخلف';
        $rows[5]['name'] = 'الصورة الشخصية';
        $rows[6]['name'] = 'صورة السيارة';
        $rows[7]['name'] = 'سجل جنائي';
        $rows[8]['name'] = 'اختبار المخدرات';
        $rows[9]['name'] = 'فحص السيارة';

        Document::insert($rows);
        
        if (array_key_exists('partner_id', $args) && $args['partner_id']) {
            $this->createPartnerDriver($args['partner_id'], $driver->id);
        }

        return $driver;
    }

    public function update(array $args)
    {
        $input = collect($args)->except(['id', 'directive', 'avatar'])->toArray();

        try {
            $driver = $this->model->findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            throw new CustomException(__('lang.driver_not_found'));
        }

        if (array_key_exists('avatar', $args) && $args['avatar']) {
            if ($driver->avatar) $this->deleteOneFile($driver->avatar, 'avatars');
            $url = $this->uploadOneFile($args['avatar'], 'avatars');
            $input['avatar'] = $url;
        }

        $driver->update($input);

        return $driver;
    }

    public function login(array $args)
    {
        $credentials["phone"] = $args['phone'];
        $credentials["password"] = $args['password'];

        if (!$token = auth('driver')->attempt($credentials)) {
            throw new CustomException(__('lang.invalid_auth_credentials'));
        }

        $driver = auth('driver')->user();

        if (!$driver->status) {
            throw new CustomException(__('lang.your_account_is_disabled'));
        }

        if (!$driver->phone_verified_at) 
        {
            $verification_code = mt_rand(1000, 9999);

            $message = __('lang.verification_code', [
                'verification_code' => $verification_code,
                'signature' => config('custom.otp_signature'),
            ]);
            
            SendOtp::dispatch($args['phone'], $message);

            $driver->verification_code = $verification_code;
        }

        if (array_key_exists('device_id', $args) 
            && $args['device_id'] 
            && $driver->device_id != $args['device_id']) 
        {
            $driver->update(['device_id' => $args['device_id']]);
        }

        return [
            'access_token' => $token,
            'driver' => $driver
        ];
    }

    public function updatePassword(array $args)
    {
        try {
            $driver = $this->model->findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            throw new \Exception(__('lang.driver_not_found'));
        }

        if (!(Hash::check($args['current_password'], $driver->password))) {
            throw new CustomException(
                __('lang.password_missmatch'),
                'customValidation'
            );
        }

        if (strcmp($args['current_password'], $args['new_password']) == 0) {
            throw new CustomException(
                __('lang.type_new_password'),
                'customValidation'
            );
        }

        $driver->password = Hash::make($args['new_password']);
        $driver->save();

        return [
            'status' => true,
            'message' => __('lang.password_changed')
        ];

    }

    public function assignVehicle(array $args)
    {
        $data = [];
        $arr = [];

        foreach($args['vehicle_id'] as $val) {
            $arr['driver_id'] = $args['driver_id'];
            $arr['vehicle_id'] = $val;
            array_push($data, $arr);
        } 

        try {
            DriverVehicle::insert($data);
        } catch (\Exception $e) {
            throw new CustomException(__('lang.assignment_failed'));
        }
 
        return [
            "status" => true,
            "message" => __('lang.assign_vehicle')
        ];
    }

    public function unassignVehicle(array $args)
    {
        try {
            DriverVehicle::where('driver_id', $args['driver_id'])
                ->whereIn('vehicle_id', $args['vehicle_id'])
                ->delete();
        } catch (\Exception $e) {
            throw new CustomException(__('lang.assign_cancel_failed') . $e->getMessage());
        }

        return [
            "status" => true,
            "message" => __('lang.unassign_vehicle')
        ];
    }

    public function destroy(array $args)
    {
        return $this->model->whereIn('id', $args['id'])->delete();
    }

    protected function createPartnerDriver($partner_id, $driver_id)
    {
        PartnerDriver::create([
            "partner_id" => $partner_id,
            "driver_id" => $driver_id
        ]);
    }
}
