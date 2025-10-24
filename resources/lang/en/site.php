<?php

return [
    'nav' => [
        'services' => 'Services',
        'clients' => 'Clients',
        'about' => 'About',
        'contact' => 'Contact',
        'jobs' => 'Jobs',
        'login' => 'Login',
        'register' => 'Get Started',
        'dashboard' => 'Dashboard',
        'profile' => 'Profile',
        'logout' => 'Logout',
        'notifications' => 'Notifications',
        'no_notifications' => 'No new notifications',
        'mark_all_read' => 'Mark all as read',
        'view_all' => 'View all',
        'language' => [
            'label' => 'Language',
            'english' => 'English',
            'arabic' => 'Arabic',
            'short_en' => 'EN',
            'short_ar' => 'AR',
        ],
    ],

    'hero' => [
        'heading_html' => 'Empowering Businesses with <span class="text-gradient">Strategic Excellence</span>',
        'description_html' => 'House of Management for Studies and Consultations (HOM) delivers comprehensive financial advisory, commercial strategy, project management, and construction consulting services to organizations across <strong>industry, government, real estate, healthcare, tourism, and NGO sectors</strong>.',
        'cta_primary' => 'Explore Our Services',
        'cta_secondary' => 'View Career Opportunities',
        'typing_texts' => [
            'Management Consulting',
            'Strategic Solutions',
            'Business Excellence',
        ],
    ],

    'services' => [
        'title' => 'Our Core Services',
        'subtitle_html' => 'Comprehensive expertise delivered through our <strong>flexible staff base</strong> and <strong>qualified business partners</strong>',
        'tabs' => [
            [
                'id' => 'project-development',
                'label' => 'Project Development',
                'icon' => 'fas fa-project-diagram',
                'color_class' => 'bg-blue',
            ],
            [
                'id' => 'project-management',
                'label' => 'Project Management',
                'icon' => 'fas fa-tasks',
                'color_class' => 'bg-green',
            ],
            [
                'id' => 'engineering-services',
                'label' => 'Engineering Services',
                'icon' => 'fas fa-cogs',
                'color_class' => 'bg-purple',
            ],
            [
                'id' => 'administrative-studies',
                'label' => 'Administrative Studies',
                'icon' => 'fas fa-chart-line',
                'color_class' => 'bg-orange',
            ],
            [
                'id' => 'feasibility-studies',
                'label' => 'Feasibility Studies',
                'icon' => 'fas fa-search-dollar',
                'color_class' => 'bg-red',
            ],
        ],
        'data' => [
            'project-development' => [
                'title' => 'Project Development Services',
                'icon' => 'fas fa-project-diagram',
                'iconColor' => 'bg-blue',
                'textColor' => 'text-primary',
                'status' => 'Active',
                'description' => 'End-to-end project development solutions from conception to completion, including planning, design, execution, and delivery management.',
                'team' => 'Project Managers: 3, Engineers: 5, Architects: 2, Consultants: 4',
                'projects' => [
                    [
                        'name' => 'PET Recycling Plant - Qatar',
                        'description' => '<strong>Project Description:</strong> USD 12 Million grass root recycling plant for plastics packaging in Qatar.<br><br><strong>HOM Services:</strong> Project Development: Feasibility study, company formation, land selection, technology selection, project budgeting, fund management, and strategy building.<br><br><strong>Progress:</strong> Scope completed on time.',
                        'image' => '/assets/images/projects/project-development-project-1.png',
                    ],
                ],
            ],
            'project-management' => [
                'title' => 'Project Management Services',
                'icon' => 'fas fa-tasks',
                'iconColor' => 'bg-green',
                'textColor' => 'text-success',
                'status' => 'Scaling',
                'description' => 'Strategic project oversight and management services ensuring timely delivery, budget compliance, and quality standards.',
                'team' => 'Senior PMs: 2, Coordinators: 4, Analysts: 3, Quality Managers: 2',
                'projects' => [
                    [
                        'tag' => 'Industrial Sector',
                        'name' => 'Jordan Bromine Co. Ltd. (JBC) - Jordan',
                        'description' => '<strong>Project Description:</strong> 18 Million USD expansion of the existing chemical manufacturing plant.<br><br><strong>HOM Services:</strong> Project management, cost control, construction supervision, commissioning, and startup.<br><br><strong>Achievements:</strong> Completed successfully with 10% saving on budget and two months earlier than plan; HOM received an incentive award for appreciation.',
                        'image' => '/assets/images/projects/project-management-project-1.png',
                    ],
                    [
                        'tag' => 'Industrial Sector',
                        'name' => 'Jordan India Fertilizers Co. Ltd. (JIFCO) - Jordan',
                        'description' => '<strong>Project Description:</strong> 700 Million USD fertilizers manufacturing plant.<br><br><strong>HOM Services:</strong> Diagnosed construction deficiencies, proposed recovery plans, reviewed handover procedures and commissioning planning to bring the project back on schedule and budget.<br><br><strong>Achievements:</strong> Completed successfully.',
                        'image' => '/assets/images/projects/project-management-project-2.png',
                    ],
                    [
                        'tag' => 'Tourism Sector',
                        'name' => 'Lagoon Hotel and Resort Project, Dead Sea - Jordan',
                        'description' => '<strong>Project Description:</strong> 30 Million USD artificial lagoon and five-star resort and spa.<br><br><strong>HOM Services:</strong> Project management and construction management.<br><br><strong>Achievements:</strong> Completed on time and on budget.',
                        'image' => '/assets/images/projects/project-management-project-3.png',
                    ],
                    [
                        'tag' => 'Renewable Energy Sector',
                        'name' => 'Photovoltaic Power Generation Project - Jordan',
                        'description' => '<strong>Project Description:</strong> 1.3 Million USD photovoltaic power generation project for domestic applications with roof-mounted car park, fully integrated, 500 KW capacity.<br><br><strong>HOM Services:</strong> Project management and construction management.<br><br><strong>Achievements:</strong> Construction successfully completed.',
                        'image' => '/assets/images/projects/project-management-project-4.png',
                    ],
                ],
            ],
            'engineering-services' => [
                'title' => 'Engineering Services',
                'icon' => 'fas fa-cogs',
                'iconColor' => 'bg-purple',
                'textColor' => 'text-purple',
                'status' => 'Growing',
                'description' => 'Specialized engineering services across multiple disciplines ensuring technical excellence, quality control, and innovative solutions for complex projects.',
                'team' => 'Lead Engineers: 4, Specialists: 6, Field Experts: 3, Inspectors: 4',
                'projects' => [
                    [
                        'tag' => 'Industrial Sector',
                        'name' => 'Al-Biariq Fertilizers Co., Yanbu â€“ Saudi Arabia',
                        'description' => '<strong>Project Description:</strong> SOP fertilizers plant producing 22,000 MT/Year SOP and 25,000 MT/Year HCl, with Manheim technology reactors, utilities, and NPK physical blending plant.<br><br><strong>HOM Services:</strong> Pre-startup evaluation, commissioning plan preparation including cost, raw material, tools/equipment and staff requirements assessment, short- and long-term expansion opportunities.<br><br><strong>Achievements:</strong> Completed and reported successfully on time.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-1-1.png',
                            '/assets/images/projects/engineering-services-project-1-2.png',
                            '/assets/images/projects/engineering-services-project-1-3.png',
                        ],
                    ],
                    [
                        'tag' => 'Industrial Sector',
                        'name' => 'Almarai Poultry Co., Hail â€“ Saudi Arabia',
                        'description' => '<strong>Project Description:</strong> 30 Million USD electricity transmission, distribution, and national grid connection for Almarai poultry project in Hail, KSA.<br><br><strong>HOM Services:</strong> Technical specifications, conceptual design, and tender documents for MV electrical transmission and distribution (with Riyadh Engineering Center).<br><br><strong>Achievements:</strong> Completed successfully on time.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-2-1.png',
                            '/assets/images/projects/engineering-services-project-2-2.png',
                        ],
                    ],
                    [
                        'tag' => 'Industrial Sector',
                        'name' => 'National Chlorine Industries Co. â€“ Jordan',
                        'description' => '<strong>Project Description:</strong> Technical assessment of alternative energy sources including cogeneration, solar, and hybrid off-grid systems versus national grid connection.<br><br><strong>HOM Services:</strong> Analysis of technical and commercial proposals, 25-year financial assessment, evaluation, and recommendations.<br><br><strong>Achievements:</strong> Completed successfully on time.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-3-1.png',
                            '/assets/images/projects/engineering-services-project-3-2.png',
                        ],
                    ],
                    [
                        'tag' => 'Industrial Sector',
                        'name' => 'Jordan Bromine Co. Ltd., Safi - Jordan',
                        'description' => '<strong>Project Description:</strong> Evaluation of energy supply options including utility supply, solar PPA, and on-site cogeneration PPA for electricity and steam.<br><br><strong>HOM Services:</strong> Data collection, soliciting offers, technical and financial evaluation, recommendations and reporting (with Energy Edge Consulting - USA).<br><br><strong>Achievements:</strong> Completed successfully on time.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-4.png',
                        ],
                    ],
                    [
                        'tag' => 'Industrial Sector',
                        'name' => 'Chlorine ISO Tank Parking Area â€“ Jordan Bromine Co.',
                        'description' => '<strong>Project Description:</strong> 600 mÂ² steel building for chlorine ISO tank parking at Jordan Bromine Co. plant.<br><br><strong>HOM Services:</strong> Design, engineering, project specification, and tender document preparation.<br><br><strong>Achievements:</strong> Completed successfully on time.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-5.png',
                        ],
                    ],
                    [
                        'tag' => 'Industrial Sector',
                        'name' => 'Ammunition Factory - Jordan',
                        'description' => '<strong>Project Description:</strong> Complete process design and engineering of an ammunition factory.<br><br><strong>HOM Services:</strong> Basic and detailed design, Zone 2 electrical room, dust extraction, exhaust and HVAC systems, process flow diagrams, load calculations, pre-engineered building and crane design.<br><br><strong>Achievements:</strong> Completed successfully on time.',
                        'images' => [
                            '/assets/images/projects/engineering-services-project-6-1.png',
                            '/assets/images/projects/engineering-services-project-6-2.png',
                        ],
                    ],
                ],
            ],
            'administrative-studies' => [
                'title' => 'Administrative Studies & Business Consulting',
                'icon' => 'fas fa-chart-line',
                'iconColor' => 'bg-orange',
                'textColor' => 'text-warning',
                'status' => 'Trusted Partner',
                'description' => 'Administrative consulting services covering organizational development, strategic planning, operational optimization, and business unit performance improvements.',
                'team' => 'Business Consultants: 5, Analysts: 4, Researchers: 3, Sector Specialists: 3',
                'projects' => [
                    [
                        'tag' => 'Government Sector',
                        'name' => 'Ministry of Energy & Mineral Resources - Jordan',
                        'description' => '<strong>Project Description:</strong> Economic evaluation model for mineral resources processing investment opportunities: potash, phosphate, and other industrial minerals.<br><br><strong>HOM Services:</strong> Economic model for mineral sector projects considering socio-economic aspects.<br><br><strong>Achievements:</strong> Completed successfully on time.',
                        'image' => '/assets/images/projects/administrative-studies-project-1.png',
                    ],
                    [
                        'tag' => 'Non-Profit Sector',
                        'name' => 'Jordan River Foundation (JRF) - Jordan',
                        'description' => '<strong>Project Description:</strong> Strategic planning covering product development, market expansion, marketing channels, and sales plan recommendations.<br><br><strong>HOM Services:</strong> Strategic planning, business plan preparation, market research, marketing plan.<br><br><strong>Achievements:</strong> Completed successfully on time.',
                        'image' => '/assets/images/projects/administrative-studies-project-2.png',
                    ],
                    [
                        'tag' => 'Government Sector',
                        'name' => 'Ministry of Planning and International Cooperation - Jordan',
                        'description' => '<strong>Project Description:</strong> Economic sector strategy update and business unit plans for tourism, industry, and ICT government institutions.<br><br><strong>HOM Services:</strong> Strategy update, business unit plans, market research, SWOT analysis.<br><br><strong>Achievements:</strong> Completed successfully on time.',
                        'image' => '/assets/images/projects/administrative-studies-project-3.png',
                    ],
                ],
            ],
            'feasibility-studies' => [
                'title' => 'Feasibility Studies',
                'icon' => 'fas fa-search-dollar',
                'iconColor' => 'bg-red',
                'textColor' => 'text-danger',
                'status' => 'Research',
                'description' => 'Comprehensive feasibility studies including market analysis, financial modeling, risk assessment, and investment recommendations.',
                'team' => 'Market Researchers: 3, Financial Analysts: 2, Risk Assessors: 2, Industry Experts: 3',
                'projects' => [
                    [
                        'name' => 'Our Experience',
                        'description' => 'HOM has strong experience in preparing financial assessments and feasibility studies for new projects and evaluating investment opportunities across sectors and scales.',
                        'image' => '/assets/images/projects/feasibility-studies.png',
                        'fullWidth' => true,
                    ],
                ],
            ],
        ],
    ],

    'focus' => [
        'title' => 'Our Focus & Approach',
        'subtitle' => 'The following categories demonstrate HOM\'s areas of focus and performance approach to provide exceptional value services to our clients across diverse industries.',
        'cards' => [
            [
                'icon' => 'fas fa-chart-line',
                'title' => 'Financial Analysis',
                'items' => [
                    'Get maximum value of money',
                    'Identify risks and opportunities',
                    'Comprehensive sensitivity analysis',
                    'Highlight saving opportunities',
                    'Strategic financing solutions',
                ],
            ],
            [
                'icon' => 'fas fa-clock',
                'title' => 'Time Management',
                'items' => [
                    'Identify critical paths and bottlenecks',
                    'Real-time progress monitoring',
                    'Early alert systems for delays',
                    'Guaranteed timely completion',
                ],
            ],
            [
                'icon' => 'fas fa-search',
                'title' => 'Market Research',
                'items' => [
                    'Identify targeted market segments',
                    'Analyze future market trends',
                    'Comprehensive SWOT analysis',
                    'Maximize market share potential',
                ],
            ],
            [
                'icon' => 'fas fa-shield',
                'title' => 'Health, Safety & Environment',
                'items' => [
                    'Total commitment to HSE protection',
                    'Robust protection mechanisms',
                    'End-to-end operational coverage',
                ],
            ],
            [
                'icon' => 'fas fa-microchip',
                'title' => 'State of the Art',
                'items' => [
                    'Latest technologies & developments',
                    'Enhanced performance solutions',
                    'Resource optimization strategies',
                ],
            ],
            [
                'icon' => 'fas fa-smile',
                'title' => 'Customer Satisfaction',
                'items' => [
                    'Customer-oriented business approach',
                    'Regular satisfaction surveys',
                    'Zero complaint achievement target',
                    'Long-term strategic partnerships',
                ],
            ],
        ],
        'unique' => [
            'title' => 'Why We Are Unique',
            'items' => [
                'Experience in our region with full awareness of requirements, risks, and opportunities.',
                'Expertise in managing projects of various sizes across governmental, NGO, and private sectors.',
                'International partnerships with leading firms across the USA, Europe, Asia, and MENA.',
                'Financing support through relationships with leading local and international funding firms.',
                'A motivated team that is eager to achieve lasting success.',
            ],
            'cta' => [
                'heading' => 'Ready to Partner with HOM?',
                'description' => 'Let\'s discuss how our unique combination of regional expertise, global partnerships, and proven methodologies can drive transformational results for your organization.',
                'buttons' => [
                    'primary' => [
                        'label' => 'Book Meeting',
                        'icon' => 'fas fa-calendar-check',
                        'href' => '#contact',
                    ],
                    'secondary' => [
                        'label' => 'View Services',
                        'icon' => 'fas fa-list-check',
                        'href' => '#services',
                    ],
                ],
                'note' => 'Trusted by leading organizations worldwide',
            ],
        ],
    ],

    'clients' => [
        'title' => 'Our Valued Clients',
        'subtitle_html' => 'We\'re proud to partner with innovative companies and organizations that share our vision for <strong>excellence and growth</strong> across diverse industries.',
    ],

    'partners' => [
        'title' => 'Our Business Partners',
        'subtitle_html' => 'We collaborate with <strong>industry leaders</strong> and <strong>innovative companies</strong> to deliver comprehensive solutions and drive mutual success.',
    ],

    'jobs' => [
        'at' => 'at',
        'levels' => [
            'entry' => 'Entry Level',
            'mid' => 'Mid Level',
            'senior' => 'Senior Level',
            'executive' => 'Executive Level',
        ],
        'labels' => [
            'header_title' => 'Job Details',
            'back_to_jobs' => 'Back to Jobs',
            'apply_by' => 'Apply by',
            'posted_on' => 'Posted',
            'job_description' => 'Job Description',
            'benefits' => 'Benefits',
            'job_information' => 'Job Information',
            'company' => 'Company',
            'location' => 'Location',
            'job_type' => 'Job Type',
            'schedule' => 'Schedule',
            'level' => 'Experience Level',
            'job_snapshot' => 'Job Snapshot',
            'application_form' => 'Application Form',
            'personal_information' => 'Personal Information',
            'contact_details' => 'Contact Details',
            'cover_letter' => 'Cover Letter',
            'upload_resume' => 'Upload Resume',
            'use_profile_cv' => 'Use CV from Profile',
            'upload_new_cv' => 'Upload New CV',
            'profile_reminder' => 'Need to update your profile CV?',
            'description_acknowledgement' => 'I confirm I have read the full job description and requirements.',
            'share' => 'Share Job',
            'company_overview' => 'Company Overview',
            'quick_actions' => 'Quick Actions',
            'similar_jobs' => 'Similar Jobs',
        ],
        'buttons' => [
            'back' => 'Back to Jobs',
            'submit_application' => 'Submit Application',
            'view_jobs' => 'View Jobs',
            'download_profile' => 'Download Company Profile',
            'apply_now' => 'Apply Now',
            'view_details' => 'View Details',
            'view_expired' => 'View (Expired)',
            'view_all' => 'View All Jobs',
            'apply_for_job' => 'Apply for this Job',
            'share_linkedin' => 'Share on LinkedIn',
            'share_facebook' => 'Facebook',
            'share_twitter' => 'Twitter',
            'share_whatsapp' => 'WhatsApp',
            'copy_link' => 'Copy Link',
        ],
        'messages' => [
            'login_to_apply' => 'You must be logged in to apply.',
            'profile_upload_hint' => 'Upload a PDF or Word document up to 5MB.',
            'job_closed' => 'This job is no longer accepting applications.',
            'job_expired' => 'This job posting has expired.',
            'share_prompt' => 'Share Job',
        ],
        'apply' => [
            'header' => [
                'title' => 'Apply for Job',
                'subtitle' => 'Submit your application for this position',
            ],
            'alerts' => [
                'missing_cv_title' => 'CV Required for Application',
                'missing_cv_message' => 'We recommend uploading your CV to your profile first. This will make future applications faster and easier.',
                'missing_cv_button' => 'Upload CV to Profile',
                'profile_cv_notice' => 'Great! You have a CV uploaded to your profile. You can still upload a specific CV for this job below if needed.',
            ],
            'form' => [
                'resume_label' => 'Resume/CV *',
                'cover_letter_placeholder' => 'Tell us why you\'re the perfect fit for this role...',
                'use_profile_cv' => 'Use CV from my profile',
                'upload_new_cv' => 'Upload a specific CV for this job',
                'accepted_formats' => 'Accepted formats: PDF, DOC, DOCX (Max: 5MB)',
                'cover_letter_optional' => ':label (Optional)',
            ],
            'tips' => [
                'title' => 'Application Tips',
                'items' => [
                    'Ensure your resume is up-to-date and tailored to this position',
                    'Write a compelling cover letter that highlights your relevant experience',
                    'Double-check all information before submitting',
                    'You\'ll receive a confirmation email after submission',
                ],
            ],
        'help' => [
            'title' => 'Need Help?',
            'items' => [
                'Make sure uploaded files are under 5MB and in PDF, DOC, or DOCX format.',
                'If you run into issues, contact support or try a different browser.',
            ],
        ],
        'sections' => [
            'questions_title' => 'Additional Questions',
            'questions_help' => 'Please answer the following questions to help us better understand your experience.',
            'documents_title' => 'Supporting Documents',
            'documents_help' => 'Upload any additional documents requested for this position.',
            'optional' => 'Optional',
        ],
        'buttons' => [
            'back_to_job' => 'Back to Job',
        ],
    ],
    ],

    'profile' => [
        'title' => 'Download Company Profile (PDF)',
        'subtitle' => 'Learn more about HOM services and capabilities',
        'button' => 'Download PDF',
    ],

    'footer' => [
        'company_name' => 'House of Management',
        'company_tagline' => 'for Studies and Consultations',
        'office_address_title' => 'Office Address',
        'mail_address_title' => 'Mail Address',
        'electronic_address_title' => 'Electronic Address',
        'useful_links_title' => 'Useful Links',
        'email' => 'Email',
        'call' => 'Call',
        'tel' => 'Tel.',
        'fax' => 'Fax.',
        'email_label' => 'E-mail:',
        'website_label' => 'Website:',
        'services' => 'Services',
        'our_focus' => 'Our Focus & Approach',
        'clients' => 'Clients',
        'partners' => 'Partners',
        'back_to_top' => 'Back to Top',
        'all_rights_reserved' => 'All rights reserved.',
    ],

    'dashboard_user' => [
        'header' => [
            'title' => 'Dashboard',
            'welcome' => 'Welcome back, :name!',
            'buttons' => [
                'browse_jobs' => 'Browse Jobs',
                'profile' => 'Profile',
            ],
        ],
        'alerts' => [
            'verify_email' => [
                'title' => 'Email Verification Required:',
                'message' => 'Please verify your email to access all features.',
                'action' => 'Verify Now',
            ],
            'upload_cv' => [
                'title' => 'Complete Your Profile:',
                'message' => 'Upload your CV/Resume to increase your chances of getting hired!',
                'action' => 'Upload CV Now',
            ],
            'pending_documents' => [
                'title' => 'Action Required: Document Upload',
                'message' => 'You have applications that require additional documents.',
                'action' => 'Upload Now',
            ],
        ],
        'profile' => [
            'title' => 'Profile Overview',
            'edit_button' => 'Edit Profile',
            'location' => 'Location',
            'current_position' => 'Current Position',
            'experience' => 'Experience',
            'resume' => 'Resume',
            'resume_view' => 'View CV',
            'resume_missing' => 'Not uploaded',
            'not_specified' => 'Not specified',
            'skills' => 'Skills',
            'website' => 'Website',
            'linkedin' => 'LinkedIn',
        ],
        'applications' => [
            'title' => 'Recent Applications',
            'filter' => 'Filter',
            'filters' => [
                'all' => 'All',
                'pending' => 'Pending',
                'reviewed' => 'Reviewed',
                'under_reviewing' => 'Under Reviewing',
                'shortlisted' => 'Shortlisted',
                'documents_requested' => 'Documents Requested',
                'documents_submitted' => 'Documents Submitted',
                'rejected' => 'Rejected',
                'hired' => 'Hired',
            ],
            'view_all' => 'View All',
            'job_unavailable' => 'Job Unavailable',
            'deleted_job' => 'Deleted Job',
            'job_removed_badge' => 'Job Removed',
            'view_job' => 'View Job',
            'download_cv' => 'Download CV',
            'applied' => 'Applied:',
            'no_applications_title' => 'No Applications Yet',
            'no_applications_message' => 'Start exploring job opportunities!',
            'show_requested_documents' => 'Show Requested Documents',
        ],
        'statuses' => [
            'pending' => 'Pending',
            'under_reviewing' => 'Under Reviewing',
            'rejected' => 'Rejected',
            'reviewed' => 'Reviewed',
            'shortlisted' => 'Shortlisted',
            'hired' => 'Hired',
            'documents_requested' => 'Documents Requested',
            'documents_submitted' => 'Documents Submitted',
            'accepted' => 'Accepted',
            'draft' => 'Draft',
        ],
        'metrics' => [
            'title' => 'Status Summary',
            'total' => 'Total',
            'pending' => 'Pending',
            'under_reviewing' => 'Under Reviewing',
            'reviewed' => 'Reviewed',
            'documents_requested' => 'Documents Requested',
        ],
        'quick_actions' => [
            'title' => 'Quick Actions',
            'browse_jobs' => 'Browse Jobs',
            'edit_profile' => 'Edit Profile',
            'applications' => 'My Applications',
            'latest_jobs' => 'Latest Jobs',
        ],
        'checklist' => [
            'title' => 'Checklist',
            'email_verified' => 'Email verified',
            'verify_email' => 'Verify your email',
            'verify_action' => 'Verify',
            'cv_uploaded' => 'CV uploaded',
            'upload_cv' => 'Upload your CV/Resume',
            'upload_action' => 'Upload',
        ],
    ],

    'jobs_index' => [
        'header' => [
            'title' => 'Find Your Job',
            'subtitle' => 'Discover amazing opportunities',
            'back_to_dashboard' => 'Back to Dashboard',
        ],
        'filters' => [
            'title' => 'Filter Jobs',
            'search_label' => 'Search Jobs',
            'search_placeholder' => 'Job title, company, keywords...',
            'category_label' => 'Category',
            'category_all' => 'All Categories',
            'subcategory_label' => 'Subcategory',
            'subcategory_all' => 'All Subcategories',
            'location_label' => 'Location',
            'location_placeholder' => 'City, State, Country',
            'level_label' => 'Level',
            'level_all' => 'All Levels',
        ],
        'results' => [
            'count' => '{0} No jobs found|{1} :count job found|[2,*] :count jobs found',
            'filtered' => 'Filtered results',
            'all' => 'Showing all available positions',
            'sort_label' => 'Sort by:',
            'sort_options' => [
                'newest' => 'Newest First',
                'oldest' => 'Oldest First',
                'title' => 'Job Title',
                'company' => 'Company',
            ],
            'posted' => 'Posted :time',
        ],
        'badges' => [
            'expired' => 'Expired',
            'days_left' => '{1} :count day left|[2,*] :count days left',
        ],
        'empty' => [
            'title' => 'No Jobs Found',
            'description' => "We couldn't find any jobs matching your criteria. Try adjusting your filters or search terms.",
        ],
    ],

    'profile_edit' => [
        'header' => [
            'title' => 'Profile Settings',
            'subtitle' => 'Manage your account information and security settings',
            'buttons' => [
                'dashboard' => 'Dashboard',
                'browse_jobs' => 'Browse Jobs',
            ],
        ],
        'sections' => [
            'profile_information' => 'Profile Information',
            'security' => 'Security Settings',
            'danger' => 'Danger Zone',
        ],
        'sidebar' => [
            'verified' => 'Verified',
            'joined' => 'Joined',
            'last_login' => 'Last Login',
            'buttons' => [
                'applications' => 'My Applications',
                'dashboard' => 'Dashboard',
            ],
        ],
        'quick_actions' => [
            'title' => 'Quick Actions',
            'browse_jobs' => 'Browse Jobs',
            'applications' => 'Applications',
            'dashboard' => 'Dashboard',
            'export' => 'Export Data',
        ],
        'tips' => [
            'title' => 'Tips',
            'items' => [
                'strong_password' => 'Use a strong password with 8+ characters.',
                'keep_profile_updated' => 'Keep your profile information up to date.',
                'verify_email' => 'Verify your email to unlock all features.',
            ],
        ],
    ],

    'profile_completion' => [
        'title' => 'Profile Completion',
        'profile' => 'Profile',
        'complete_all' => 'All profile requirements are complete!',
        'complete_prompt' => 'Complete: :fields',
        'complete_more' => ' and :count more',
        'fields' => [
            'name' => 'Name',
            'headline' => 'Professional headline',
            'location' => 'Location',
            'current_position' => 'Current position',
            'experience_years' => 'Experience level',
            'skills' => 'Skills',
            'about' => 'About section',
            'education' => 'Education',
            'linkedin_url' => 'LinkedIn profile',
            'cv_path' => 'Resume/CV',
        ],
    ],

    'application_statuses' => [
        'pending' => 'Pending',
        'under_reviewing' => 'Under Reviewing',
        'reviewed' => 'Reviewed',
        'shortlisted' => 'Shortlisted',
        'documents_requested' => 'Documents Requested',
        'documents_submitted' => 'Documents Submitted',
        'rejected' => 'Rejected',
        'hired' => 'Hired',
        'accepted' => 'Accepted',
    ],

    'applications_index' => [
        'header' => [
            'title' => 'My Applications',
            'subtitle' => 'Track and manage all your job applications in one place.',
            'dashboard' => 'Dashboard',
            'browse_jobs' => 'Browse Jobs',
        ],
        'alerts' => [
            'pending_documents' => [
                'title' => 'Action Required: Document Upload',
                'message' => 'Some of your applications require additional documents to be uploaded. Please review and submit them below.',
            ],
        ],
        'stats' => [
            'total' => 'Total Applications',
            'pending' => 'Pending Review',
            'under_reviewing' => 'Under Reviewing',
            'reviewed' => 'Reviewed',
            'shortlisted' => 'Shortlisted',
            'documents_requested' => 'Documents Requested',
            'documents_submitted' => 'Documents Submitted',
            'rejected' => 'Rejected',
            'hired' => 'Hired',
            'monthly' => 'This Month',
        ],
        'filters' => [
            'title' => 'Filter Applications',
            'search_label' => 'Search Applications',
            'search_placeholder' => 'Job title, company...',
            'status_label' => 'Status',
            'status' => [
                'all' => 'All Statuses',
            ],
            'sort_label' => 'Sort By',
            'sort' => [
                'newest' => 'Newest First',
                'oldest' => 'Oldest First',
                'job_title' => 'Job Title',
                'company' => 'Company',
            ],
            'submit' => 'Filter',
        ],
        'status' => [
            'labels' => [
                'pending' => 'Pending',
                'under_reviewing' => 'Under Reviewing',
                'reviewed' => 'Reviewed',
                'shortlisted' => 'Shortlisted',
                'documents_requested' => 'Documents Requested',
                'documents_submitted' => 'Documents Submitted',
                'accepted' => 'Accepted',
                'rejected' => 'Rejected',
                'hired' => 'Hired',
            ],
        ],
        'list' => [
            'deleted_job' => 'Deleted Job',
            'job_deleted_note' => 'This job is no longer available.',
            'view_job' => 'View Job',
            'job_unavailable' => 'Job Unavailable',
            'download_cv' => 'CV',
            'reference' => 'Application #:id',
            'applied_on' => 'Applied: :date',
            'date_format' => 'M d, Y',
            'toggle' => 'Details',
        ],
        'details' => [
            'cover_letter' => [
                'title' => 'Cover Letter',
            ],
            'questions' => [
                'title' => 'Application Questions',
                'empty' => 'No additional questions were answered.',
            ],
            'documents' => [
                'title' => 'Supporting Documents',
                'empty' => 'No supporting documents were uploaded.',
                'download' => 'Download',
            ],
        ],
        'documents_requested' => [
            'title' => 'Requested Documents',
            'alert_title' => 'Action Required: Document Upload',
            'alert_message' => 'The employer has requested additional documents. Please upload the required files below.',
            'pending' => 'Pending',
            'submitted' => 'Submitted',
            'file_hint' => 'Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max 5MB)',
            'submit_button' => 'Upload Documents',
            'download' => 'Download',
        ],
        'empty' => [
            'title' => 'No Applications Found',
            'filtered' => 'No applications match your current filters. Try adjusting your search criteria.',
            'default' => 'You haven\'t submitted any job applications yet. Start exploring opportunities!',
            'reset' => 'Clear Filters',
            'browse' => 'Browse Jobs',
        ],
    ],

    'profile_form' => [
        'profile_information' => [
            'title' => 'Profile Information',
            'description' => "Update your account's profile information and email address.",
            'fields' => [
                'name' => 'Name',
                'email' => 'Email',
                'headline' => [
                    'label' => 'Professional Headline',
                    'placeholder' => 'e.g., Senior Software Developer',
                ],
                'location' => [
                    'label' => 'Location',
                    'placeholder' => 'City, Country',
                ],
                'current_position' => [
                    'label' => 'Current Position',
                    'placeholder' => 'Current job title',
                ],
                'experience' => [
                    'label' => 'Years of Experience',
                    'placeholder' => 'Select experience level',
                    'options' => [
                        '0-1' => '0-1 years',
                        '2-4' => '2-4 years',
                        '5-7' => '5-7 years',
                        '8-10' => '8-10 years',
                        '10+' => '10+ years',
                    ],
                ],
                'website' => [
                    'label' => 'Website/Portfolio (Optional)',
                    'placeholder' => 'https://your-website.com',
                ],
                'linkedin' => [
                    'label' => 'LinkedIn Profile',
                    'placeholder' => 'https://linkedin.com/in/your-profile',
                ],
                'education' => [
                    'label' => 'Education',
                    'placeholder' => 'Degree, University/Institution, Year',
                ],
                'skills' => [
                    'label' => 'Skills',
                    'placeholder' => 'List your key skills separated by commas',
                    'tip' => 'Tip: Separate skills with commas, e.g., :example',
                    'preview_label' => 'Preview',
                    'preview_empty' => 'No skills to preview',
                ],
                'about' => [
                    'label' => 'About / Bio',
                    'placeholder' => 'Tell us about yourself, your experience, and career goals',
                ],
                'cv' => [
                    'label' => 'CV/Resume',
                    'current' => 'Current CV:',
                    'view' => 'View',
                    'hint' => 'Upload your CV/Resume (PDF, DOC, DOCX formats only. Max size: 2MB)',
                ],
            ],
            'buttons' => [
                'save' => 'Save Changes',
            ],
            'messages' => [
                'saved' => 'Saved successfully!',
            ],
            'verification' => [
                'unverified' => 'Your email address is unverified.',
                'resend' => 'Click here to re-send the verification email.',
                'sent' => 'A new verification link has been sent to your email address.',
            ],
        ],
        'password' => [
            'title' => 'Update Password',
            'description' => 'Ensure your account is using a long, random password to stay secure.',
            'current' => 'Current Password',
            'new' => 'New Password',
            'confirm' => 'Confirm Password',
            'button' => 'Update Password',
            'updated' => 'Password updated!',
        ],
        'delete' => [
            'title' => 'Delete Account',
            'description' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
            'button' => 'Delete Account',
            'modal_title' => 'Confirm Account Deletion',
            'modal_question' => 'Are you sure you want to delete your account?',
            'modal_description' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',
            'password_label' => 'Password',
            'password_placeholder' => 'Enter your password to confirm',
            'cancel' => 'Cancel',
        ],
    ],

    'flash' => [
        'success' => 'Success!',
        'error' => 'Error!',
        'warning' => 'Warning!',
        'info' => 'Information',
        'profile_updated' => 'Your profile has been updated successfully.',
        'password_updated' => 'Your password has been updated successfully.',
        'verification_link_sent' => 'A new verification link has been sent to your email address.',
        'application_submitted' => 'Your application has been submitted successfully!',
        'application_error' => 'There was an error submitting your application. Please try again.',
        'login_success' => 'You have been logged in successfully.',
        'logout_success' => 'You have been logged out successfully.',
        'settings_saved' => 'Settings have been saved successfully.',
        'email_verified' => 'Your email has been verified successfully.',
        'unauthorized' => 'You are not authorized to perform this action.',
        'not_found' => 'The requested resource was not found.',
        'validation_error' => 'Please fix the errors in the form and try again.',
        'saved_successfully' => 'Saved successfully!',
        'deleted_successfully' => 'Deleted successfully!',
        'updated_successfully' => 'Updated successfully!',
        'restored_successfully' => 'Restored successfully!',
        'account_deactivated' => 'This account has been deactivated. Please contact support for assistance.',

        // Job-related messages
        'job_created' => 'Job created successfully.',
        'job_updated' => 'Job updated successfully.',
        'job_deleted' => 'Job deleted successfully.',
        'job_restored' => 'Job restored successfully.',
        'job_permanently_deleted' => 'Job permanently deleted.',
        'job_deadline_extended' => 'Job deadline extended by 14 days.',
        'all_jobs_restored' => 'All jobs restored successfully.',
        'all_jobs_deleted' => 'All jobs permanently deleted.',
        'job_deadline_passed' => 'This job application deadline has passed. You can no longer apply for this position.',
        'job_no_longer_accepting' => 'This job is no longer accepting applications.',
        'already_applied' => 'You have already applied for this job.',

        // Category-related messages
        'category_created' => 'Category created successfully.',
        'category_updated' => 'Category and subcategories updated successfully.',
        'category_deleted' => 'Category deleted successfully.',
        'category_cannot_delete' => 'Cannot delete category with existing jobs. Please move or delete the jobs first.',

        // Admin-related messages
        'admin_created' => 'Admin created successfully.',
        'admin_updated' => 'Admin updated successfully.',
        'admin_deleted' => 'Admin deleted successfully.',
        'cannot_delete_self' => 'You cannot delete your own account.',
        'admin_status_updated' => 'Admin :status successfully.',

        // Notification messages
        'notifications_marked_read' => 'All notifications marked as read.',
        'notification_not_found' => 'Notification not found.',
    ],

    'confirm' => [
        'title' => 'Confirm Action',
        'message' => 'Are you sure you want to continue?',
        'approve' => 'Confirm',
        'cancel' => 'Cancel',
        'delete' => [
            'title' => 'Confirm Deletion',
            'message' => 'This record will be permanently deleted. Do you want to proceed?',
            'approve' => 'Yes, delete it',
        ],
        'restore' => [
            'title' => 'Confirm Restore',
            'message' => 'This record will be restored to its active state.',
            'approve' => 'Restore',
        ],
        'actions' => [
            'users' => [
                'restore' => [
                    'message' => 'Are you sure you want to restore this user?',
                    'confirm' => 'Restore',
                ],
                'delete_soft' => [
                    'message' => 'Are you sure you want to delete this user and their profile?',
                    'confirm' => 'Delete',
                ],
                'delete_force' => [
                    'message' => 'Are you sure you want to permanently delete this user? This action cannot be undone and will also permanently delete their profile and all related data.',
                    'confirm' => 'Delete Forever',
                ],
            ],
            'admins' => [
                'delete' => [
                    'message' => 'Are you sure you want to delete this admin?',
                    'confirm' => 'Delete',
                ],
                'delete_force' => [
                    'message' => 'Are you sure you want to delete this admin? This action cannot be undone.',
                    'confirm' => 'Delete',
                ],
            ],
            'jobs' => [
                'restore_all' => [
                    'message' => 'Are you sure you want to restore all deleted jobs?',
                    'confirm' => 'Restore',
                ],
                'delete_all' => [
                    'message' => 'Are you sure you want to permanently delete all jobs? This action cannot be undone!',
                    'confirm' => 'Delete All',
                ],
                'restore' => [
                    'message' => 'Are you sure you want to restore this job?',
                    'confirm' => 'Restore',
                ],
                'delete_force' => [
                    'message' => 'Are you sure you want to permanently delete this job? This action cannot be undone!',
                    'confirm' => 'Delete',
                ],
                'delete_soft' => [
                    'message' => 'Are you sure you want to delete this job?',
                    'confirm' => 'Delete',
                ],
                'delete_soft_notice' => [
                    'message' => 'Are you sure you want to delete this job? This action can be undone from the deleted jobs section.',
                    'confirm' => 'Delete',
                ],
            ],
            'categories' => [
                'delete' => [
                    'message' => 'Are you sure you want to delete this category?',
                    'confirm' => 'Delete',
                ],
                'delete_with_jobs' => [
                    'message' => 'Are you sure you want to delete ":name"? This category has :count job(s) that will need to be reassigned or removed first.',
                    'confirm' => 'Delete',
                ],
                'delete_with_children' => [
                    'message' => 'Are you sure you want to delete ":name"? This will also delete all its subcategories.',
                    'confirm' => 'Delete',
                ],
                'restore' => [
                    'message' => 'Are you sure you want to restore this category?',
                    'confirm' => 'Restore',
                ],
                'force_delete' => [
                    'message_with_children' => 'WARNING: Permanently deleting ":name" will also remove its :count subcategory(ies). This action cannot be undone. Continue?',
                    'message' => 'WARNING: Permanently deleting ":name" cannot be undone. Continue?',
                    'confirm' => 'Delete Forever',
                ],
            ],
            'applications' => [
                'update_status' => [
                    'message' => 'Update status for selected applications?',
                    'confirm' => 'Update',
                ],
                'delete_bulk' => [
                    'message' => 'Are you sure you want to delete selected applications?',
                    'confirm' => 'Delete',
                ],
                'delete' => [
                    'message' => 'Are you sure you want to delete this application?',
                    'confirm' => 'Delete',
                ],
                'delete_detailed' => [
                    'message' => 'Are you sure you want to delete this application? This action cannot be undone.',
                    'confirm' => 'Delete',
                ],
                'hire' => [
                    'message' => 'Are you sure you want to hire this candidate?',
                    'confirm' => 'Hire',
                ],
                'reject' => [
                    'message' => 'Are you sure you want to reject this application?',
                    'confirm' => 'Reject',
                ],
            ],
        ],
    ],
];


