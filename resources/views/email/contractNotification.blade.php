@component('mail::message')

@foreach ($time as $tim)

{{$tim['user_name']}} is going to over soon! Please issue the contract or you can just ignore it! {{$tim['time']}} <br>

@endforeach




[example link]({{route('endUserNotification')}})

Thanks,<br>
Practical Action
@endcomponent
