@component('mail::message')

@foreach ($time as $tim)

{{$tim['user_name']}} is going to over soon! Please issue the contract or you can just ignore it! {{$tim['time']}} <br>

@endforeach




Thanks,<br>
Practical Action
@endcomponent
