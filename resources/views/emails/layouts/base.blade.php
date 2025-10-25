@php
    $locale = $locale ?? app()->getLocale();
    $dir = in_array($locale, ['ar', 'he', 'fa']) ? 'rtl' : 'ltr';
    $align = $dir === 'rtl' ? 'right' : 'left';
    $fontFamily =
        $dir === 'rtl' ? "'Tahoma','Arial',sans-serif" : "'Poppins','Segoe UI','Helvetica Neue','Arial',sans-serif";
    $brand = $brand ?? config('app.name', 'HOM');
    $logoUrl = $logoUrl ?? asset('assets/images/HOM-logo.png');
    $primaryColor = $primaryColor ?? '#18458f';
    $preheader = $preheader ?? '';
    $footer = $footer ?? '';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $dir }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? $brand }}</title>
</head>

<body
    style="margin:0; padding:0; background-color:#f3f4f6; font-family:{{ $fontFamily }}; direction:{{ $dir }};">
    @if (!empty($preheader))
        <div
            style="display:none; max-height:0; overflow:hidden; font-size:1px; line-height:1px; color:#f3f4f6; opacity:0;">
            {{ $preheader }}
        </div>
    @endif
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
        style="background-color:#f3f4f6; padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                    style="max-width:620px; background-color:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 18px 45px rgba(24,69,143,0.12);">
                    <tr>
                        <td
                            style="background-color:{{ $primaryColor }}; padding:24px 32px; text-align:{{ $align }};">
                            @if (!empty($logoUrl))
                                <img src="{{ $logoUrl }}" alt="{{ $brand }}"
                                    style="max-height:42px; display:inline-block;">
                            @else
                                <span
                                    style="color:#ffffff; font-size:20px; font-weight:700; letter-spacing:0.5px;">{{ $brand }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding:32px; text-align:{{ $align }}; color:#1f2937; font-size:16px; line-height:1.7;">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="background-color:#f8fafc; padding:20px 28px; text-align:center; color:#6b7280; font-size:13px;">
                            {{ $footer }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
