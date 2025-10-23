<?php

return [
    'nav' => [
        'services' => 'خدماتنا',
        'clients' => 'عملاؤنا',
        'about' => 'من نحن',
        'contact' => 'تواصل معنا',
        'jobs' => 'الوظائف',
        'login' => 'تسجيل الدخول',
        'register' => 'ابدأ الآن',
        'dashboard' => 'لوحة التحكم',
        'profile' => 'الملف الشخصي',
        'logout' => 'تسجيل الخروج',
        'notifications' => 'الإشعارات',
        'no_notifications' => 'لا توجد إشعارات جديدة',
        'mark_all_read' => 'تمييز الكل كمقروء',
        'view_all' => 'عرض الكل',
        'language' => [
            'label' => 'اللغة',
            'english' => 'الإنجليزية',
            'arabic' => 'العربية',
            'short_en' => 'EN',
            'short_ar' => 'AR',
        ],
    ],

    'hero' => [
        'heading_html' => 'نُمكّن الأعمال عبر <span class="text-gradient">التميز الاستراتيجي</span>',
        'description_html' => 'يقدّم بيت الإدارة للدراسات والاستشارات (HOM) خدمات استشارية مالية متكاملة، واستراتيجيات تجارية، وإدارة مشاريع، واستشارات إنشائية للمنظمات العاملة في قطاعات <strong>الصناعة، والحكومة، والعقارات، والرعاية الصحية، والسياحة، والمنظمات غير الربحية</strong>.',
        'cta_primary' => 'استكشف خدماتنا',
        'cta_secondary' => 'تعرّف على الفرص الوظيفية',
        'typing_texts' => [
            'الاستشارات الإدارية',
            'حلول استراتيجية',
            'تميز الأعمال',
        ],
    ],

    'services' => [
        'title' => 'خدماتنا الرئيسية',
        'subtitle_html' => 'خبرات شاملة نقدّمها عبر <strong>فريق عمل مرن</strong> و<strong>شركاء أعمال معتمدين</strong>',
        'tabs' => [
            [
                'id' => 'project-development',
                'label' => 'تطوير المشاريع',
                'icon' => 'fas fa-project-diagram',
                'color_class' => 'bg-blue',
            ],
            [
                'id' => 'project-management',
                'label' => 'إدارة المشاريع',
                'icon' => 'fas fa-tasks',
                'color_class' => 'bg-green',
            ],
            [
                'id' => 'engineering-services',
                'label' => 'الخدمات الهندسية',
                'icon' => 'fas fa-cogs',
                'color_class' => 'bg-purple',
            ],
            [
                'id' => 'administrative-studies',
                'label' => 'الدراسات الإدارية',
                'icon' => 'fas fa-chart-line',
                'color_class' => 'bg-orange',
            ],
            [
                'id' => 'feasibility-studies',
                'label' => 'دراسات الجدوى',
                'icon' => 'fas fa-search-dollar',
                'color_class' => 'bg-red',
            ],
        ],
        'data' => [
            'project-development' => [
                'title' => 'خدمات تطوير المشاريع',
                'icon' => 'fas fa-project-diagram',
                'iconColor' => 'bg-blue',
                'textColor' => 'text-primary',
                'status' => 'نشط',
                'description' => 'حلول متكاملة لتطوير المشاريع بدءاً من الفكرة وحتى التسليم، تشمل التخطيط والتصميم والتنفيذ وإدارة التسليم.',
                'team' => 'مديرو مشاريع: 3، مهندسون: 5، معماريون: 2، مستشارون: 4',
                'projects' => [
                    [
                        'name' => 'PET Recycling Plant - قطر',
                        'description' => '<strong>وصف المشروع:</strong> مصنع جديد لإعادة تدوير عبوات البلاستيك بقيمة 12 مليون دولار أمريكي في قطر.<br><br><strong>خدمات HOM:</strong> تطوير المشروع: دراسة جدوى، تأسيس الشركة، اختيار الأرض والتقنية، إعداد الميزانية، إدارة التمويل، وبناء الاستراتيجية.<br><br><strong>التقدم:</strong> اكتمل نطاق العمل في الوقت المحدد.',
                        'image' => '/assets/images/projects/project-development-project-1.png',
                    ],
                ],
            ],
            'project-management' => [
                'title' => 'خدمات إدارة المشاريع',
                'icon' => 'fas fa-tasks',
                'iconColor' => 'bg-green',
                'textColor' => 'text-success',
                'status' => 'في توسّع',
                'description' => 'إشراف استراتيجي وإدارة متكاملة للمشاريع لضمان الالتزام بالجدول الزمني والميزانية ومعايير الجودة.',
                'team' => 'مديرو مشاريع أول: 2، منسقون: 4، محللون: 3، مدراء جودة: 2',
                'projects' => [
                    [
                        'tag' => 'القطاع الصناعي',
                        'name' => 'Jordan Bromine Co. Ltd. (JBC) - الأردن',
                        'description' => '<strong>وصف المشروع:</strong> توسعة بقيمة 18 مليون دولار أمريكي لمصنع تصنيع المواد الكيميائية القائم.<br><br><strong>خدمات HOM:</strong> إدارة المشروع، ضبط التكاليف، الإشراف على الإنشاء، التشغيل التجريبي، والإطلاق.<br><br><strong>الإنجازات:</strong> تنفيذ ناجح مع توفير 10% من الميزانية والانتهاء قبل الموعد بشهرين؛ حصلت HOM على مكافأة تقديرية.',
                        'image' => '/assets/images/projects/project-management-project-1.png',
                    ],
                    [
                        'tag' => 'القطاع الصناعي',
                        'name' => 'Jordan India Fertilizers Co. Ltd. (JIFCO) - الأردن',
                        'description' => '<strong>وصف المشروع:</strong> مصنع أسمدة بقيمة 700 مليون دولار أمريكي.<br><br><strong>خدمات HOM:</strong> تشخيص أوجه القصور الإنشائية، اقتراح خطط التعافي، مراجعة إجراءات التسليم والتشغيل التجريبي لإعادة المشروع إلى الجدول والميزانية.<br><br><strong>الإنجازات:</strong> تم الإنجاز بنجاح.',
                        'image' => '/assets/images/projects/project-management-project-2.png',
                    ],
                    [
                        'tag' => 'قطاع السياحة',
                        'name' => 'Lagoon Hotel & Resort, البحر الميت - الأردن',
                        'description' => '<strong>وصف المشروع:</strong> بحيرة اصطناعية ومنتجع وفندق خمس نجوم بقيمة 30 مليون دولار أمريكي.<br><br><strong>خدمات HOM:</strong> إدارة المشروع وإدارة أعمال الإنشاء.<br><br><strong>الإنجازات:</strong> تم التسليم في الوقت المحدد وضمن الميزانية.',
                        'image' => '/assets/images/projects/project-management-project-3.png',
                    ],
                    [
                        'tag' => 'قطاع الطاقة المتجددة',
                        'name' => 'Photovoltaic Power Generation Project - الأردن',
                        'description' => '<strong>وصف المشروع:</strong> مشروع توليد طاقة كهروضوئية بقيمة 1.3 مليون دولار أمريكي لتطبيقات منزلية مع مواقف سيارات مظللة بقدرة 500 كيلوواط متكاملة بالكامل.<br><br><strong>خدمات HOM:</strong> إدارة المشروع وإدارة أعمال الإنشاء.<br><br><strong>الإنجازات:</strong> اكتمل التنفيذ بنجاح.',
                        'image' => '/assets/images/projects/project-management-project-4.png',
                    ],
                ],
            ],
            'engineering-services' => [
                'title' => 'الخدمات الهندسية',
                'icon' => 'fas fa-cogs',
                'iconColor' => 'bg-purple',
                'textColor' => 'text-purple',
                'status' => 'نمو مستمر',
                'description' => 'خدمات هندسية متخصصة عبر عدة مجالات تضمن التميّز الفني، وضبط الجودة، وحلولاً مبتكرة للمشاريع المعقدة.',
                'team' => 'مهندسون قياديون: 4، مختصون: 6، خبراء ميدانيون: 3، مفتشون: 4',
                'projects' => [
                    [
                        'tag' => 'القطاع الصناعي',
                        'name' => 'Al-Biariq Fertilizers Co., ينبع - المملكة العربية السعودية',
                        'description' => '<strong>وصف المشروع:</strong> مصنع لإنتاج أسمدة SOP بطاقة 22,000 طن سنوياً وHCl بطاقة 25,000 طن سنوياً بتقنية مفاعلات مانهايم، مع مرافق خدمية وخط خلط NPK.<br><br><strong>خدمات HOM:</strong> تقييم ما قبل التشغيل، إعداد خطة التشغيل التجريبي بما يشمل التكاليف والمواد الخام والأدوات والكوادر، ودراسة فرص التوسّع قصيرة وطويلة الأجل.<br><br><strong>الإنجازات:</strong> تم الإنجاز وإصدار التقارير في الوقت المحدد.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-1-1.png',
                            '/assets/images/projects/engineering-services-project-1-2.png',
                            '/assets/images/projects/engineering-services-project-1-3.png',
                        ],
                    ],
                    [
                        'tag' => 'القطاع الصناعي',
                        'name' => 'Almarai Poultry Co., حائل - المملكة العربية السعودية',
                        'description' => '<strong>وصف المشروع:</strong> مشروع بقيمة 30 مليون دولار أمريكي لخطوط نقل وتوزيع الكهرباء والربط بالشبكة الوطنية لمشروع دواجن المراعي في حائل، السعودية.<br><br><strong>خدمات HOM:</strong> إعداد المواصفات الفنية، التصاميم المفاهيمية، ووثائق العطاءات لنظم نقل وتوزيع الجهد المتوسط (بالتعاون مع مركز الرياض الهندسي).<br><br><strong>الإنجازات:</strong> اكتمل التنفيذ بنجاح في الوقت المحدد.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-2-1.png',
                            '/assets/images/projects/engineering-services-project-2-2.png',
                        ],
                    ],
                    [
                        'tag' => 'القطاع الصناعي',
                        'name' => 'National Chlorine Industries Co. - الأردن',
                        'description' => '<strong>وصف المشروع:</strong> تقييم تقني لمصادر الطاقة البديلة بما يشمل التوليد المشترك، والطاقة الشمسية، والأنظمة الهجينة مقارنة بالربط مع الشبكة الوطنية.<br><br><strong>خدمات HOM:</strong> تحليل العروض الفنية والتجارية، وتقديم تقييم مالي لمدة 25 عاماً، وإصدار التوصيات.<br><br><strong>الإنجازات:</strong> تم الإنجاز بنجاح في الوقت المحدد.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-3-1.png',
                            '/assets/images/projects/engineering-services-project-3-2.png',
                        ],
                    ],
                    [
                        'tag' => 'القطاع الصناعي',
                        'name' => 'Jordan Bromine Co. Ltd., الصافي - الأردن',
                        'description' => '<strong>وصف المشروع:</strong> تقييم خيارات تزويد الطاقة بما يشمل الشبكة الوطنية، واتفاقيات شراء الطاقة الشمسية، والتوليد المشترك في الموقع لتوفير الكهرباء والبخار.<br><br><strong>خدمات HOM:</strong> جمع البيانات، طلب العروض، التقييم الفني والمالي، وإصدار التوصيات بالتعاون مع Energy Edge Consulting (الولايات المتحدة).<br><br><strong>الإنجازات:</strong> تم الإنجاز بنجاح في الوقت المحدد.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-4.png',
                        ],
                    ],
                    [
                        'tag' => 'القطاع الصناعي',
                        'name' => 'Chlorine ISO Tank Parking Area - Jordan Bromine Co.',
                        'description' => '<strong>وصف المشروع:</strong> مبنى فولاذي بمساحة 600 متر مربع لمواقف خزانات الكلور ISO في مصنع Jordan Bromine Co.<br><br><strong>خدمات HOM:</strong> التصميم، وإعداد وثائق المشروع، ومستندات الطرح.<br><br><strong>الإنجازات:</strong> تم الإنجاز بنجاح في الوقت المحدد.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-5.png',
                        ],
                    ],
                    [
                        'tag' => 'القطاع الصناعي',
                        'name' => 'Ammunition Factory - الأردن',
                        'description' => '<strong>وصف المشروع:</strong> تصميم هندسي كامل لمصنع ذخيرة.<br><br><strong>خدمات HOM:</strong> التصميمان الأساسي والتفصيلي، تصميم غرفة كهرباء منطقة 2، أنظمة شفط الغبار والعادم والتكييف، مخططات مسار العمليات، حسابات الأحمال، وتصميم المبنى مسبق الصنع والرافعات.<br><br><strong>الإنجازات:</strong> تم الإنجاز بنجاح في الوقت المحدد.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-6-1.png',
                            '/assets/images/projects/engineering-services-project-6-2.png',
                        ],
                    ],
                ],
            ],
            'administrative-studies' => [
                'title' => 'الدراسات الإدارية والاستشارات',
                'icon' => 'fas fa-chart-line',
                'iconColor' => 'bg-orange',
                'textColor' => 'text-warning',
                'status' => 'شريك موثوق',
                'description' => 'استشارات إدارية تغطي تطوير الهيكل التنظيمي، والتخطيط الاستراتيجي، وتحسين العمليات، ورفع أداء الوحدات التشغيلية.',
                'team' => 'مستشارو أعمال: 5، محللون: 4، باحثون: 3، خبراء قطاعات: 3',
                'projects' => [
                    [
                        'tag' => 'القطاع الحكومي',
                        'name' => 'وزارة الطاقة والثروة المعدنية - الأردن',
                        'description' => '<strong>وصف المشروع:</strong> نموذج تقييم اقتصادي لفرص الاستثمار في معالجة الموارد المعدنية مثل البوتاس، والفوسفات، والمعادن الصناعية الأخرى.<br><br><strong>خدمات HOM:</strong> تطوير نموذج اقتصادي لمشروعات قطاع التعدين مع مراعاة الأبعاد الاقتصادية والاجتماعية.<br><br><strong>الإنجازات:</strong> تم الإنجاز بنجاح في الوقت المحدد.',
                        'image' => '/assets/images/projects/administrative-studies-project-1.png',
                    ],
                    [
                        'tag' => 'قطاع المنظمات غير الربحية',
                        'name' => 'مؤسسة نهر الأردن (JRF) - الأردن',
                        'description' => '<strong>وصف المشروع:</strong> تخطيط استراتيجي يشمل تطوير المنتجات، والتوسع في الأسواق، وقنوات التسويق، وتوصيات خطط المبيعات.<br><br><strong>خدمات HOM:</strong> التخطيط الاستراتيجي، إعداد خطة الأعمال، أبحاث السوق، وخطة التسويق.<br><br><strong>الإنجازات:</strong> تم الإنجاز بنجاح في الوقت المحدد.',
                        'image' => '/assets/images/projects/administrative-studies-project-2.png',
                    ],
                    [
                        'tag' => 'القطاع الحكومي',
                        'name' => 'وزارة التخطيط والتعاون الدولي - الأردن',
                        'description' => '<strong>وصف المشروع:</strong> تحديث استراتيجية القطاعات الاقتصادية وخطط الوحدات المؤسسية لقطاعات السياحة والصناعة وتكنولوجيا المعلومات والاتصالات.<br><br><strong>خدمات HOM:</strong> تحديث الاستراتيجيات، إعداد خطط الوحدات، أبحاث السوق، وتحليل SWOT.<br><br><strong>الإنجازات:</strong> تم الإنجاز بنجاح في الوقت المحدد.',
                        'image' => '/assets/images/projects/administrative-studies-project-3.png',
                    ],
                ],
            ],
            'feasibility-studies' => [
                'title' => 'دراسات الجدوى',
                'icon' => 'fas fa-search-dollar',
                'iconColor' => 'bg-red',
                'textColor' => 'text-danger',
                'status' => 'بحث وتقييم',
                'description' => 'دراسات جدوى شاملة تشمل تحليل السوق، والنمذجة المالية، وتقييم المخاطر، وتقديم توصيات الاستثمار.',
                'team' => 'باحثو سوق: 3، محللون ماليون: 2، مقيمو مخاطر: 2، خبراء قطاعات: 3',
                'projects' => [
                    [
                        'name' => 'خبراتنا',
                        'description' => 'تتمتع HOM بخبرة قوية في إعداد التقييمات المالية ودراسات الجدوى للمشاريع الجديدة وتقييم فرص الاستثمار عبر مختلف القطاعات والأحجام.',
                        'image' => '/assets/images/projects/feasibility-studies.png',
                        'fullWidth' => true,
                    ],
                ],
            ],
        ],
    ],

    'focus' => [
        'title' => 'مناطق تركيزنا ونهجنا',
        'subtitle' => 'تُبرز الفئات التالية مجالات تركيز HOM ونهج الأداء لتقديم خدمات ذات قيمة مضافة لعملائنا في مختلف القطاعات.',
        'cards' => [
            [
                'icon' => 'fas fa-chart-line',
                'title' => 'التحليل المالي',
                'items' => [
                    'تعظيم قيمة رأس المال المستثمر',
                    'تحديد المخاطر والفرص',
                    'إجراء تحليلات حساسية شاملة',
                    'إبراز فرص التوفير',
                    'حلول تمويل استراتيجية',
                ],
            ],
            [
                'icon' => 'fas fa-clock',
                'title' => 'إدارة الوقت',
                'items' => [
                    'تحديد المسارات الحرجة ونقاط الاختناق',
                    'متابعة التقدم في الوقت الفعلي',
                    'أنظمة إنذار مبكر للتأخير',
                    'ضمان إتمام الأعمال في الوقت المحدد',
                ],
            ],
            [
                'icon' => 'fas fa-search',
                'title' => 'أبحاث السوق',
                'items' => [
                    'تحديد الشرائح السوقية المستهدفة',
                    'تحليل اتجاهات السوق المستقبلية',
                    'تحليل SWOT شامل',
                    'تعظيم إمكانات الحصة السوقية',
                ],
            ],
            [
                'icon' => 'fas fa-shield',
                'title' => 'الصحة والسلامة والبيئة',
                'items' => [
                    'التزام كامل بحماية الصحة والسلامة والبيئة',
                    'آليات حماية متينة',
                    'تغطية تشغيلية شاملة',
                ],
            ],
            [
                'icon' => 'fas fa-microchip',
                'title' => 'تقنيات متقدمة',
                'items' => [
                    'أحدث التقنيات والتطويرات',
                    'حلول أداء محسّنة',
                    'استراتيجيات تحسين الموارد',
                ],
            ],
            [
                'icon' => 'fas fa-smile',
                'title' => 'رضا العملاء',
                'items' => [
                    'نهج تجاري يرتكز على العميل',
                    'استطلاعات رضا دورية',
                    'استهداف معدلات صفرية للشكاوى',
                    'شراكات استراتيجية طويلة الأجل',
                ],
            ],
        ],
        'unique' => [
            'title' => 'لماذا نتميز',
            'items' => [
                'خبرة عميقة في منطقتنا مع إدراك كامل للمتطلبات والمخاطر والفرص.',
                'كفاءة في إدارة مشاريع بمختلف الأحجام في القطاعات الحكومية وغير الربحية والقطاع الخاص.',
                'شراكات دولية مع شركات رائدة في الولايات المتحدة وأوروبا وآسيا ومنطقة الشرق الأوسط وشمال أفريقيا.',
                'دعم تمويلي عبر علاقاتنا مع أهم جهات التمويل المحلية والدولية.',
                'فريق عمل متحفز يسعى لتحقيق نجاح مستدام.',
            ],
            'cta' => [
                'heading' => 'هل أنت مستعد للتعاون مع HOM؟',
                'description' => 'دعنا نناقش كيف يمكن لمزيجنا الفريد من الخبرة الإقليمية والشراكات العالمية والمنهجيات المجربة أن يحقق نتائج تحولية لمنظمتك.',
                'buttons' => [
                    'primary' => [
                        'label' => 'احجز اجتماعاً',
                        'icon' => 'fas fa-calendar-check',
                        'href' => '#contact',
                    ],
                    'secondary' => [
                        'label' => 'استعرض الخدمات',
                        'icon' => 'fas fa-list-check',
                        'href' => '#services',
                    ],
                ],
                'note' => 'موثوق بنا من قبل مؤسسات رائدة حول العالم',
            ],
        ],
    ],

    'clients' => [
        'title' => 'عملاؤنا المميزون',
        'subtitle_html' => 'نفخر بشراكاتنا مع شركات ومنظمات مبتكرة تشاركنا رؤية <strong>التميّز والنمو</strong> عبر قطاعات متعددة.',
    ],

    'partners' => [
        'title' => 'شركاؤنا في الأعمال',
        'subtitle_html' => 'نتعاون مع <strong>روّاد الصناعة</strong> و<strong>شركات مبتكرة</strong> لتقديم حلول متكاملة وتحقيق نجاح مشترك.',
    ],

    'jobs' => [
        'at' => 'لدى',
        'levels' => [
            'entry' => 'مستوى مبتدئ',
            'mid' => 'مستوى متوسط',
            'senior' => 'مستوى متقدم',
            'executive' => 'مستوى تنفيذي',
        ],
        'labels' => [
            'header_title' => 'تفاصيل الوظيفة',
            'back_to_jobs' => 'العودة إلى الوظائف',
            'apply_by' => 'آخر موعد للتقديم',
            'posted_on' => 'تاريخ النشر',
            'job_description' => 'وصف الوظيفة',
            'benefits' => 'المزايا',
            'job_information' => 'معلومات الوظيفة',
            'company' => 'الشركة',
            'location' => 'الموقع',
            'job_type' => 'نوع الوظيفة',
            'schedule' => 'نظام العمل',
            'level' => 'مستوى الخبرة',
            'job_snapshot' => 'ملخص الوظيفة',
            'application_form' => 'نموذج التقديم',
            'personal_information' => 'البيانات الشخصية',
            'contact_details' => 'بيانات التواصل',
            'cover_letter' => 'رسالة التغطية',
            'upload_resume' => 'رفع السيرة الذاتية',
            'use_profile_cv' => 'استخدام السيرة الذاتية من الملف الشخصي',
            'upload_new_cv' => 'رفع سيرة ذاتية جديدة',
            'profile_reminder' => 'هل تحتاج إلى تحديث سيرتك الذاتية في الملف؟',
            'share' => 'مشاركة الوظيفة',
            'company_overview' => 'نبذة عن الشركة',
            'quick_actions' => 'إجراءات سريعة',
            'similar_jobs' => 'وظائف مشابهة',
        ],
        'buttons' => [
            'back' => 'العودة إلى الوظائف',
            'submit_application' => 'إرسال الطلب',
            'view_jobs' => 'عرض الوظائف',
            'download_profile' => 'تحميل ملف الشركة',
            'apply_now' => 'قدّم الآن',
            'view_details' => 'عرض التفاصيل',
            'view_expired' => 'عرض (منتهية)',
            'view_all' => 'عرض جميع الوظائف',
            'apply_for_job' => 'التقديم على هذه الوظيفة',
            'share_linkedin' => 'مشاركة عبر لينكدإن',
            'share_facebook' => 'فيسبوك',
            'share_twitter' => 'إكس',
            'share_whatsapp' => 'واتساب',
            'copy_link' => 'نسخ الرابط',
        ],
        'messages' => [
            'login_to_apply' => 'يجب تسجيل الدخول للتقديم.',
            'profile_upload_hint' => 'يرجى رفع ملف PDF أو Word بحجم لا يتجاوز 5 ميجابايت.',
            'job_closed' => 'هذه الوظيفة لم تعد تستقبل طلبات جديدة.',
            'job_expired' => 'انتهت صلاحية هذا الإعلان الوظيفي.',
            'share_prompt' => 'مشاركة الوظيفة',
        ],
    ],

    'profile' => [
        'title' => 'تحميل ملف الشركة (PDF)',
        'subtitle' => 'تعرّف على خدمات HOM وإمكاناتنا بشكل مفصل',
        'button' => 'تحميل الملف',
    ],

    'confirm' => [
        'title' => 'تأكيد الإجراء',
        'message' => 'هل أنت متأكد من رغبتك في المتابعة؟',
        'approve' => 'تأكيد',
        'cancel' => 'إلغاء',
        'delete' => [
            'title' => 'تأكيد الحذف',
            'message' => 'سيتم حذف هذا السجل ولا يمكن التراجع عن ذلك. هل ترغب بالاستمرار؟',
            'approve' => 'نعم، احذف',
        ],
        'restore' => [
            'title' => 'تأكيد الاستعادة',
            'message' => 'سيتم استعادة هذا السجل إلى حالته النشطة.',
            'approve' => 'استعادة',
        ],
        'actions' => [
            'users' => [
                'restore' => [
                    'message' => 'هل أنت متأكد من رغبتك في استعادة هذا المستخدم؟',
                    'confirm' => 'استعادة',
                ],
                'delete_soft' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف هذا المستخدم وملفه التعريفي؟',
                    'confirm' => 'حذف',
                ],
                'delete_force' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف هذا المستخدم نهائياً؟ لا يمكن التراجع عن هذا الإجراء، كما سيؤدي إلى حذف ملفه وجميع البيانات المرتبطة به نهائياً.',
                    'confirm' => 'حذف نهائي',
                ],
            ],
            'admins' => [
                'delete' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف هذا المدير؟',
                    'confirm' => 'حذف',
                ],
                'delete_force' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف هذا المدير؟ لا يمكن التراجع عن هذا الإجراء.',
                    'confirm' => 'حذف',
                ],
            ],
            'jobs' => [
                'restore_all' => [
                    'message' => 'هل أنت متأكد من رغبتك في استعادة جميع الوظائف المحذوفة؟',
                    'confirm' => 'استعادة',
                ],
                'delete_all' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف جميع الوظائف بشكل نهائي؟ لا يمكن التراجع عن هذا الإجراء!',
                    'confirm' => 'حذف الكل',
                ],
                'restore' => [
                    'message' => 'هل أنت متأكد من رغبتك في استعادة هذه الوظيفة؟',
                    'confirm' => 'استعادة',
                ],
                'delete_force' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف هذه الوظيفة نهائياً؟ لا يمكن التراجع عن هذا الإجراء!',
                    'confirm' => 'حذف',
                ],
                'delete_soft' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف هذه الوظيفة؟',
                    'confirm' => 'حذف',
                ],
                'delete_soft_notice' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف هذه الوظيفة؟ يمكن التراجع عن هذا الإجراء من قسم الوظائف المحذوفة.',
                    'confirm' => 'حذف',
                ],
            ],
            'categories' => [
                'delete' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف هذه الفئة؟',
                    'confirm' => 'حذف',
                ],
                'delete_with_jobs' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف ":name"؟ يحتوي هذا التصنيف على :count وظيفة يجب إعادة تعيينها أو حذفها أولاً.',
                    'confirm' => 'حذف',
                ],
                'delete_with_children' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف ":name"؟ سيؤدي ذلك أيضاً إلى حذف جميع التصنيفات الفرعية المرتبطة بها.',
                    'confirm' => 'حذف',
                ],
                'restore' => [
                    'message' => 'هل أنت متأكد من رغبتك في استعادة هذه الفئة؟',
                    'confirm' => 'استعادة',
                ],
                'force_delete' => [
                    'message_with_children' => 'تحذير: سيؤدي حذف ":name" نهائياً إلى إزالة :count من التصنيفات الفرعية المرتبطة بها. لا يمكن التراجع عن هذا الإجراء. هل تود المتابعة؟',
                    'message' => 'تحذير: لا يمكن التراجع عن حذف ":name" نهائياً. هل تود المتابعة؟',
                    'confirm' => 'حذف نهائي',
                ],
            ],
            'applications' => [
                'update_status' => [
                    'message' => 'هل ترغب في تحديث حالة الطلبات المحددة؟',
                    'confirm' => 'تحديث',
                ],
                'delete_bulk' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف الطلبات المحددة؟',
                    'confirm' => 'حذف',
                ],
                'delete' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف هذا الطلب؟',
                    'confirm' => 'حذف',
                ],
                'delete_detailed' => [
                    'message' => 'هل أنت متأكد من رغبتك في حذف هذا الطلب؟ لا يمكن التراجع عن هذا الإجراء.',
                    'confirm' => 'حذف',
                ],
                'hire' => [
                    'message' => 'هل أنت متأكد من رغبتك في تعيين هذا المرشح؟',
                    'confirm' => 'تعيين',
                ],
                'reject' => [
                    'message' => 'هل أنت متأكد من رغبتك في رفض هذا الطلب؟',
                    'confirm' => 'رفض',
                ],
            ],
        ],
    ],
];
