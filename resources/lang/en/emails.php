<?php

return [
  'common' => [
    'subject_fallback' => 'Application update for :job',
    'preheader_fallback' => 'Latest status update from :brand.',
  ],
  'auth' => [
    'common' => [
      'greeting' => 'Hello :name,',
      'fallback_name' => 'there',
      'signature' => 'Kind regards,',
      'team' => ':app Team',
      'footer' => '© :year :app. All rights reserved.',
      'button_fallback' => 'If you’re having trouble clicking the ":button" button, copy and paste the URL below into your web browser:',
    ],
    'verify' => [
      'subject' => 'Verify your email for :app',
      'preheader' => 'Confirm your email to start using :app.',
      'title' => 'Verify your email address',
      'intro' => 'Thanks for joining :app! Please confirm your email address to activate your account.',
      'action' => 'Verify Email',
      'support' => 'If you did not create an account, no further action is required.',
    ],
    'reset' => [
      'subject' => 'Reset your :app password',
      'preheader' => 'Use the link below to reset your :app password.',
      'title' => 'Reset your password',
      'intro' => 'You are receiving this message because we received a password reset request for your account.',
      'action' => 'Reset Password',
      'expires' => 'This password reset link will expire in :count minutes.',
      'support' => 'If you did not request a password reset, no further action is required.',
    ],
  ],
  'applications' => [
    'common' => [
      'user_action' => 'View your application',
      'admin_action' => 'Open application',
    ],
    'user' => [
      'pending' => [
        'subject' => 'We received your application for :job',
        'preheader' => 'Thanks for applying to :job at :brand.',
        'intro' => 'Thank you for submitting your application for ":job". We’re excited to learn more about you.',
        'lines' => [
          'Our hiring team has received your details and will review them shortly.',
          'You can follow progress and share updates any time from your applications dashboard.',
        ],
        'action' => 'View your application',
        'support' => 'If you have any questions, simply reply to this email or contact us through the portal.',
      ],
      'shortlisted' => [
        'subject' => 'You were shortlisted for :job',
        'preheader' => 'Great news from :brand about your application.',
        'intro' => 'Great news! You made the shortlist for ":job".',
        'lines' => [
          'We will reach out soon with interview details and the next steps in the process.',
          'Keep an eye on your email and dashboard so you don’t miss any updates.',
        ],
        'action' => 'Follow your application',
        'support' => 'Questions? Reply to this email and our team will be happy to help.',
      ],
      'documents_requested' => [
        'subject' => 'Action needed: upload documents for :job',
        'preheader' => 'Please upload the requested documents to continue your application with :brand.',
        'intro' => 'We need a few supporting documents to keep your application for ":job" moving.',
        'lines' => [
          'Log in to your dashboard to review the list of requested documents and upload them securely.',
          'Submitting the documents soon helps us keep your application on track without delays.',
        ],
        'action' => 'Upload documents',
        'support' => 'If you run into any issues while uploading, contact us and we will support you right away.',
      ],
      'rejected' => [
        'subject' => 'Update on your application for :job',
        'preheader' => 'Thank you for your interest in :brand.',
        'intro' => 'Thank you for taking the time to apply for ":job" with :brand.',
        'lines' => [
          'After careful review, we will not be moving forward with your application at this time.',
          'We encourage you to stay connected with :brand and apply to future opportunities that match your experience.',
        ],
        'action' => 'Visit your dashboard',
        'support' => 'If you have any questions or would like feedback, feel free to reach out to our team.',
      ],
      'hired' => [
        'subject' => 'Congratulations! You were selected for :job',
        'preheader' => 'Welcome to the :brand team.',
        'intro' => 'Congratulations! We’re thrilled to welcome you aboard for ":job" at :brand.',
        'lines' => [
          'Our HR team will share your offer details and onboarding plan very soon.',
          'Please confirm the best contact information so we can support you through the next steps.',
        ],
        'action' => 'Review onboarding details',
        'support' => 'If you need anything before then, reply to this email and we’ll be glad to assist.',
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
    ],
  ],
];
