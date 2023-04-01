{{--{{$title}}--}}
{{--{{$host}}--}}
{{--{{$protocol}}--}}

<html lang="ja">
<head>
    <title>{{$title}}</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>{{$title}}</h1>
<dl>
    <dt>php version</dt>
    <dd>{{$php_version}}</dd>
    <dt>IP:</dt>
    <dd>{{$ip}}</dd>
    <dt>host</dt>
    <dd>{{$docker_on}}</dd>
</dl>
<h2>Services</h2>
<ul>
    @for ($i = 0; $i < sizeof($links); $i++)
        <li><a target="_blank" href="{{$links[$i]['href']}}">{{$links[$i]['service_name']}}</a></li>
    @endfor
</ul>
</body>
</html>
