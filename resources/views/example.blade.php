example.blade is loaded successfully<br/>
Translation ping: {{ trans('example::package.ping') }}<br/>
Config ping: {{ config('example.ping') }}<br/>
Facade: Ping -> {{ Example::ping() }}<br/>
<x-example-ping />