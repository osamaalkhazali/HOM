<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 6px;
        }

        .meta {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 6px 8px;
            vertical-align: top;
        }

        th {
            background-color: #f3f4f6;
            font-weight: 600;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            background: #eef2ff;
            color: #312e81;
            font-size: 10px;
            margin-right: 4px;
        }

        .muted {
            color: #6b7280;
            font-size: 10px;
        }

        .wrap {
            white-space: pre-wrap;
        }
    </style>
</head>

<body>
    @if (!empty($meta['title']))
        <h1>{{ $meta['title'] }}</h1>
    @endif

    @if (!empty($meta['description']))
        <div class="meta">{{ $meta['description'] }}</div>
    @endif

    @if (!empty($meta['generated_at']) || !empty($meta['filters']))
        <div class="meta">
            @if (!empty($meta['generated_at']))
                <div>Generated at: {{ $meta['generated_at'] }}</div>
            @endif
            @if (!empty($meta['filters']))
                <div>Filters: {{ $meta['filters'] }}</div>
            @endif
        </div>
    @endif

    <table>
        <thead>
            <tr>
                @foreach ($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td class="wrap">{!! nl2br(e((string) $cell)) !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
