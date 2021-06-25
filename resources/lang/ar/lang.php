<?php

/*
|--------------------------------------------------------------------------
| Authentication Language Lines
|--------------------------------------------------------------------------
|
| The following language lines are used during authentication for various
| messages that we need to display to the user. You are free to modify
| these language lines according to your application's requirements.
|
*/

return [
    'AdminNotFound'   => 'لم يتم العثور على معرف المسؤول المقدم.',
    'InvalidAuthCredentials' => 'بيانات اعتماد المصادقة المقدمة غير صالحة.',
    'PasswordMissmatch' => 'كلمة المرور الحالية لا تتطابق مع كلمة المرور التي قدمتها.',
    'TypeNewPassword' => 'لا يمكن أن تكون كلمة المرور الجديدة هي نفسها كلمة مرورك الحالية. الرجاء اختيار كلمة مرور مختلفة.',
    'PasswordChanged' => 'تم تغيير الرقم السري بنجاح.',
    'CreateTrnxFailed' => 'تعذر إنشاء المعاملة!',
    'CreateAttendanceFailed' => 'لم نتمكن من إنشاء أو تحديث سجل حضور!',
    'TripAlreadyStarted' => 'هذه الرحلة بدأت بالفعل!',
    'CaptainArrived' => 'وصل كابتن قروز إلى محطتك وسيغادر بعد دقيقة واحدة',
    'NotifyStationFailed' => 'لم نتمكن من إخطار مستخدمي المحطة المحددة!',
    'WelcomeTrip' => 'مرحبا! أتمنى أن تكون سعيدًا وآمنًا طوال هذه الرحلة.',
    'ByeTrip' => 'وداعا! لا يمكننا الانتظار لرؤيتك في المرة القادمة.',
    'TripEnded' => 'هذه الرحلة قد انتهت بالفعل!',
    'ChangeUserStatusFailed' => 'لا يمكن تغيير حالة المستخدمين المختارين!',
    'AttendenceChanged' => ':user قام بتغيير حالة حضوره إلى :status',
    'CaptainChangedAttendance' => 'قام قائد الرحلة بتغيير حالة حضورك إلى: الحالة ، إذا لم تكن هذه هي الحالة ، فيمكنك إعادتها مرة أخرى من داخل الرحلة.',
    'CreateTripFailed' => 'لم نتمكن من إنشاء هذه الرحلة!',
    'AddRequestFailed' => 'لم نتمكن من إضافة هذه الطلبات إلى رحلة عمل!',
    'AssignUserStationFailed' => 'لم نتمكن من تعيين المستخدمين لمحطة محددة',
    'TripNotFound' => 'لم يتم العثور على رحلة بالمعرف المقدم.',
    'UpdateRouteFailed' => 'تعذر تحديث المسار',
    'CopyTripFailed' => 'لم نتمكن من نسخ هذه الرحلة!',
    'InviteUserFailed' => 'لم نتمكن من دعوة المستخدمين المختارين!',
    'UserInvitedNotVerified' => 'تمت دعوة المستخدمين المحددين ولكن لم يتم التحقق منهم',
    'SubscribeUserFailed' => 'لم نتمكن من الاشتراك في المستخدمين المختارين!',
    'SubscribeUser' => 'تم الاشتراك في المستخدمين المختارين',
    'AlreadySubscribed' => 'لقد اشتركت بالفعل في هذه الرحلة.',
    'CancelSubscribeFailed' => 'فشل إلغاء الاشتراك.',
    'ToggleSubscribeFailed' => 'لم نتمكن من تبديل هذا الاشتراك!',
    'SubscriptionCode' => 'عزيزي المستخدم ، يرجى استخدام هذا الرمز لتأكيد اشتراكك في الرحلة :trip_name = :subscription_code',
    'CreateScheduleFailed' => 'لم نتمكن من تحديث أو حتى إنشاء هذا الجدول!',
    'StationNotFound' => 'لم يتم العثور على معرف المحطة المقدم.',
    'SomethingWentWrong' => 'هناك خطأ ما! حاول مرة اخرى',
    'AcceptStationFailed' => 'لم نتمكن من قبول هذه المحطة!',
    'CarModelNotFound' => 'لم يتم العثور على معرّف carModel المقدم.',
    'CarTypeNotFound' => 'لم يتم العثور على معرّف carType المقدم.',
    'SendMessageFailed' => 'لم نتمكن من إرسال رسالة إلى المستلمين المحددين!',
    'SaveMessageFailed' => 'لم نتمكن من حفظ هذه الرسالة!',
    'DocumentNotFound' => 'لم يتم العثور على المستند بالمعرف المقدم.',
    'DocumentDeleted' => 'تم حذف المستند.',
    'DriverNotFound' => 'لم يتم العثور على معرف السائق المقدم.',
    'AssignmentFailed' => 'فشل تعيين القيمة',
    'AssignVehicle' => 'تم تعيين المركبات المختارة بنجاح.',
    'AssignCancelFailed' => 'فشل إلغاء تعيين القيمة.',
    'UnassignVehicle' => 'تم إلغاء تخصيص المركبات المختارة بنجاح',
    'FleetNotFound' => 'لم يتم العثور على معرف الأسطول المقدم.',
    'CreateRequestFailed' => 'لم نتمكن من إنشاء هذا الطلب!',
    'RequestNotFound' => 'لم يتم العثور على معرف الطلب المقدم.',
    'ChangeRequestFailed' => 'لا يمكن تغيير حالة الطلب.',
    'CancelRequestFailed' => 'لا يمكن إلغاء هذا الطلب.',
    'RequestSubmitted' => 'تم تقديم طلب On-Demand جديد',
    'RequestIDSubmitted' => 'طلب On-Demand الجديد # :request_id تم تقديمه',
    'PartnerNotFound' => 'لم يتم العثور على معرف الشريك المقدم.',
    'DriverAssignFailed' => 'لا يمكن تعيين السائق لنفس الشريك أكثر من مرة.',
    'DriverAssigned' => 'تم تعيين السائقين المختارين بنجاح.',
    'DriverUnassigned' => 'تم إلغاء تعيين السائقين المحددين بنجاح.',
    'UserAssignFailed' => 'لا يمكن تعيين المستخدم لنفس الشريك أكثر من مرة.',
    'UserAssigned' => 'تم تعيين المستخدمين المختارين بنجاح.',
    'UserUnassigned' => 'تم إلغاء تعيين المستخدمين المحددين بنجاح.',
    'AddCardFailed' => 'لم نتمكن من إضافة هذه البطاقة.',
    'CardAdded' => 'تمت إضافة بطاقة الدفع بنجاح.',
    'ResendCodeFailed' => 'لم نتمكن من إعادة إرسال الرمز.',
    'CodeResent' => 'تمت إعادة إرسال رمز التحقق بنجاح.',
    'ValidateOTPFailed' => 'لم نتمكن من التحقق من صحة OTP.',
    'OTPValidated' => 'تم التحقق من صحة OTP بنجاح.',
    'ProcessPaymentFailed' => 'لم نتمكن من معالجة هذا الدفع.',
    'CardNotFound' => 'البطاقة غير موجودة.',
    'CreatePriceFailed' => 'لم نتمكن من إنشاء حزمة الأسعار هذه!',
    'UpdatePriceFailed' => 'لم نتمكن من تحديث حزمة الأسعار هذه!',
    'InvalidPromoCode' => 'الرمز الترويجي غير صالح أو منتهي الصلاحية!',
    'PermittedUsageExceeded' => 'لقد تجاوزت أوقات الاستخدام المسموح بها!',
    'RoleNotFound' => 'لم يتم العثور على معرّف الدور المقدم.',
    'CreateSchoolRequestFailed' => 'لم نتمكن من إنشاء طلب المدرسة هذا!',
    'UpdateSchoolRequestFailed' => 'لم نتمكن من تحديث طلب المدرسة هذا!',
    'RequestChanged' => 'تم تغيير حالة الطلبات المختارة',
    'DeleteRequestFailed' => 'لم نتمكن من حذف الطلبات المحددة!',
    'RequestDeleted' => 'تم حذف الطلبات المحددة',
    'CopyLineFailed' => 'لم نتمكن من نسخ هذا الخط!',
    'UpdateBookingFailed' => 'لم نتمكن من تحديث هذا الحجز!',
    'NoSeats' => 'لا توجد مقاعد متاحة',
    'AvailableSeats' => 'فقط :availableSeats :pluralSeats متوفرة',
    'CreateBookingFailed' => 'تعذر إنشاء هذا الحجز!',
    'UpadateWalletFailed' => 'لا يمكن تحديث المحفظة!',
    'DropUserFailed' => 'لا يمكن انزال المستخدم!',
    'PasswordPhoneNotProvided' => 'كلمة المرور أو الهاتف مطلوب ولكن لم يتم توفيرهما.',
    'CreateUserFailed' => 'لم نتمكن من إنشاء المستخدمين!',
    'UserNotFound' => 'لم يتم العثور على معرف المستخدم المقدم.',
    'InvalidToken' => 'الرمز المقدم غير صالح.',
    'VehicleNotFound' => 'لم يتم العثور على معرف السيارة المقدم.',
    'CreateWorkplaceFailed' => 'لم نتمكن من إنشاء طلب مكان العمل هذا!',
    'UpdateWorkplaceFailed' => 'لم نتمكن من تحديث طلب مكان العمل هذا!',
    'ChangeRequestsFailed' => 'لم نتمكن من تغيير حالة الطلبات المحددة!',
    'NoSchedule' => 'لا يوجد جدول زمني لهذا المستخدم في هذه الرحلة!',
    'GetUserStatusFailed' => 'لم نتمكن من الحصول على حالة المستخدم في هذه الرحلة!',
    'NoChatMessages' => 'لم نتمكن من العثور على رسائل الدردشة هذه!',
    'NotAvailableName' => 'الاسم المختار غير متوفر',
    'TerminalExist' => 'هذه المحطة موجودة بالفعل',
    'NotAvailablePhone' => 'الهاتف المختار غير متوفر',
    'NotAvailableEmail' => 'البريد الإلكتروني المختار غير متوفر',
    'NotAvailableArabicName' => 'الاسم العربي المختار غير متوفر',
    'NotAvailableType' => 'النوع المختار غير متوفر',
    'NotAvailableLicense' => 'لوحة الترخيص المختارة غير متوفرة',
    'SetLanguageFailed' => 'تعذر تكوين لغة التطبيق!',
    'UploadFileFailed' => 'لم نتمكن من تحميل هذا الملف.',
    'UpdateFailed' => 'لم نتمكن من التحديث!',
];