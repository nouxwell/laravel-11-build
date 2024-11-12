<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /*body {*/
        /*    font-family: 'DejaVu Sans', sans-serif; !* DejaVu Sans fontunu kullan *!*/
        /*}*/
        *{
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }
        #pdfTitle {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
            word-wrap: break-word;
            width: 150px;
        }
        thead {
            display: table-header-group; /* Ensure thead is repeated */
        }
        tfoot {
            display: table-row-group;
        }
        tr {
            page-break-inside: avoid; /* Avoid breaking rows over pages */
        }
        table, th, td {
            page-break-inside: avoid;
        }

    </style>
    <title>{{ __('messages.template.mail.export_title') }}</title>
</head>
<body>
<table>
    <thead>
    <tr>
        @foreach($fields as $field)
            <th>{{ $field }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            @foreach($item as $value)
                <td>{{ $value }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
