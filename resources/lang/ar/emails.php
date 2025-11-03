<?php

return [
  'common' => [
    'subject_fallback' => 'تحديث بخصوص طلب وظيفة :job',
    'preheader_fallback' => 'أحدث مستجدات حالة الطلب من :brand.',
  ],
  'auth' => [
    'common' => [
      'greeting' => 'مرحباً :name،',
      'fallback_name' => 'صديقنا العزيز',
      'signature' => 'مع أطيب التحيات،',
      'team' => 'فريق :app',
      'footer' => '© :year :app. جميع الحقوق محفوظة.',
      'button_fallback' => 'إذا واجهت مشكلة في النقر على زر ":button"، انسخ الرابط التالي والصقه في متصفحك:',
    ],
    'verify' => [
      'subject' => 'تأكيد بريدك الإلكتروني في :app',
      'preheader' => 'قم بتأكيد بريدك الإلكتروني لبدء استخدام :app.',
      'title' => 'تأكيد عنوان بريدك الإلكتروني',
      'intro' => 'شكراً لانضمامك إلى :app! الرجاء تأكيد بريدك الإلكتروني لتفعيل حسابك.',
      'action' => 'تأكيد البريد الإلكتروني',
      'support' => 'إذا لم تقم بإنشاء حساب، فلا حاجة لأي إجراء.',
    ],
    'reset' => [
      'subject' => 'إعادة تعيين كلمة المرور في :app',
      'preheader' => 'استخدم الرابط أدناه لإعادة تعيين كلمة مرور :app.',
      'title' => 'إعادة تعيين كلمة المرور',
      'intro' => 'وصلتك هذه الرسالة لأننا تلقينا طلباً لإعادة تعيين كلمة المرور لحسابك.',
      'action' => 'إعادة تعيين كلمة المرور',
      'expires' => 'سينتهي صلاحية رابط إعادة التعيين خلال :count دقيقة.',
      'support' => 'إذا لم تطلب إعادة تعيين كلمة المرور، تجاهل هذه الرسالة.',
    ],
  ],
  'applications' => [
    'common' => [
      'user_action' => 'عرض طلبك',
      'admin_action' => 'فتح الطلب',
    ],
    'user' => [
      'pending' => [
        'subject' => 'تم استلام طلبك لوظيفة :job',
        'preheader' => 'شكراً لتقديمك على وظيفة :job لدى :brand.',
        'intro' => 'يسعدنا إبلاغك بأننا استلمنا طلبك لوظيفة ":job" ونتطلع للتعرف عليك أكثر.',
        'lines' => [
          'فريق التوظيف لدينا سيبدأ بمراجعة بياناتك خلال وقت قصير.',
          'يمكنك متابعة حالة الطلب وإرسال أي تحديثات من لوحة طلباتي في أي وقت.',
        ],
        'action' => 'عرض طلبك',
        'support' => 'للاستفسار، يكفي أن ترد على هذه الرسالة أو تراسلنا من خلال البوابة.',
      ],
      'shortlisted' => [
        'subject' => 'تم ترشيحك لوظيفة :job',
        'preheader' => 'أخبار سارة من :brand حول طلبك.',
        'intro' => 'خبر رائع! تم ترشيحك للقائمة القصيرة لوظيفة ":job".',
        'lines' => [
          'سنتواصل معك قريباً بخصوص تفاصيل المقابلة والخطوات القادمة في العملية.',
          'يرجى متابعة بريدك ولوحة التحكم حتى لا يفوتك أي تحديث.',
        ],
        'action' => 'متابعة حالة الطلب',
        'support' => 'عند وجود أي استفسار، راسلنا وسنكون سعداء بمساعدتك.',
      ],
      'documents_requested' => [
        'subject' => 'مطلوب إجراء: مستندات خاصة بوظيفة :job',
        'preheader' => 'يرجى رفع المستندات المطلوبة لمتابعة طلبك لدى :brand.',
        'intro' => 'نحتاج لبعض المستندات الداعمة لمتابعة طلبك لوظيفة ":job".',
        'lines' => [
          'سجّل الدخول إلى لوحة التحكم للاطلاع على المستندات المطلوبة ورفعها بأمان.',
          'إرسال المستندات في أقرب وقت يساعدنا على متابعة طلبك بدون تأخير.',
        ],
        'action' => 'رفع المستندات',
        'support' => 'إذا واجهت أي مشكلة في الرفع، تواصل معنا وسنساعدك فوراً.',
      ],
      'rejected' => [
        'subject' => 'تحديث بخصوص طلبك لوظيفة :job',
        'preheader' => 'شكراً لاهتمامك بالانضمام إلى :brand.',
        'intro' => 'نشكر لك وقتك واهتمامك بالتقديم على وظيفة ":job" لدى :brand.',
        'lines' => [
          'بعد مراجعة دقيقة، نأسف لإبلاغك بأننا لن نتمكن من متابعة طلبك في الوقت الحالي.',
          'نقدّر اهتمامك وندعوك لمتابعة فرصنا القادمة التي تناسب خبراتك.',
        ],
        'action' => 'زيارة لوحة التحكم',
        'support' => 'لأي استفسار إضافي أو لطلب ملاحظات، تواصل معنا متى شئت.',
      ],
      'hired' => [
        'subject' => 'تهانينا! تم اختيارك لوظيفة :job',
        'preheader' => 'مرحباً بك في فريق :brand.',
        'intro' => 'تهانينا! يسرنا انضمامك إلى فريق :brand في وظيفة ":job".',
        'lines' => [
          'سيقوم فريق الموارد البشرية بمراسلتك قريباً بتفاصيل العرض وخطة الانضمام.',
          'يرجى التأكد من تزويدنا ببيانات التواصل المناسبة لتسهيل الإجراءات.',
        ],
        'action' => 'استعرض تفاصيل الانضمام',
        'support' => 'إن احتجت لأي مساعدة أو استفسار، يكفي الرد على هذه الرسالة.',
      ],
    ],
    'admin' => [
      'pending' => [
        'subject' => 'New application received for :job',
        'preheader' => 'A candidate just applied through the :brand careers portal.',
        'intro' => ':applicant submitted a new application for ":job".',
        'lines' => [
          'Review the candidate information, answers, and attachments from the admin dashboard.',
          'Remember to update the application status so the candidate stays informed.',
        ],
        'action' => 'Open application',
        'support' => 'Sign in to the admin portal to continue managing this candidate.',
      ],
      'documents_submitted' => [
        'subject' => 'Documents received for :job application',
        'preheader' => ':applicant uploaded the requested documents for ":job".',
        'intro' => ':applicant has submitted all requested documents for their application.',
        'lines' => [
          'Review the uploaded files to verify the information and proceed with the evaluation.',
          'Update the application status after reviewing so the candidate receives the latest information.',
        ],
        'action' => 'Review documents',
        'support' => 'Visit the admin dashboard to continue the hiring workflow.',
      ],
      'hired' => [
        'subject' => 'New employee hired: :applicant for :job',
        'preheader' => ':applicant has been hired for ":job" position.',
        'intro' => 'Great news! :applicant has been successfully hired for the ":job" position.',
        'lines' => [
          'The candidate has been notified and an employee record has been automatically created.',
          'You can now proceed with onboarding steps and prepare the necessary documentation.',
          'Access the employee details from the admin dashboard to manage their information.',
        ],
        'action' => 'View employee details',
        'support' => 'Visit the admin dashboard to continue with the onboarding process.',
      ],
    ],
  ],
];
