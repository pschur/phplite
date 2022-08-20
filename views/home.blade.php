@extends('layouts.app')

@section('content')
    <h1>Hello from <u>{{ config('app.name', 'PHPLite') }}</u></h1>
    <article>
        Get started by changeing the title in the config file <code>config/app.php</code>
        <footer class="code">
            <pre><code><b>/**
 * The name of the App
 * 
 * <i>@var string</i>
 */</b>
<u>'name'</u> => <u>'<del>{{ config('app.name', 'PHPLite') }}</del> <ins>[YOUR-APPLICATION-NAME]</ins>'</u>, <em><cite>// Here you can set your own application name.</cite></em></code></pre>
        </footer>
    </article>
@endsection