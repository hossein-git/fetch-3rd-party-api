Monitoring:
Class Name: {{ $class }} ,
Method Name: {{ $methodName }} ,
Arguments :
@forelse($arguments as $key => $arg)
   {{ $key }} : {{ $arg }}
@empty
   No Arguments
@endforelse
Result: {{ $result }}

{{--{{ now()->toDateTimeString() }}--}}
