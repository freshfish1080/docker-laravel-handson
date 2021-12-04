<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <style>
        @font-face{
            font-family: ipag;
            font-style: normal;
            font-weight: normal;
            src:url('{{ storage_path('fonts/ipag.ttf') }}');
        }
        body{
            font-family: ipag;
        }
    </style>
</head>
<body>
    
    <div>
        【受領書】
    </div>
    <div>
        お名前：上様
    </div>
    <div>
        合計金額:{{ $total_price }}
    </div>
    <div>
        販売者：わたし
    </div>
        
   
</body>
</html>
