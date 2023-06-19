@extends('emails.common')

@section('content')
<div style="width: 600px; margin:auto; background-color: #F7F7F7; padding-bottom: 30px; border-top-left-radius: 10px; border-top-right-radius: 10px; box-shadow: 0px 0px 10px 1px #00000021; margin-bottom: 30px;">
    <div style="width: 100%;padding: 20px 0px;text-align: center;border-top-left-radius: 0;border-top-right-radius: 0;">
        <div style="font-size: 18px;color:#73879C;line-height: 100%;margin-bottom: 0px;text-transform: uppercase;letter-spacing: 4px;">
            {{ $subject }}
        </div>
    </div>
    <div style="padding-left: 30px; padding-right: 30px; padding-top: 30px; text-align: center;">
        <div style="font-size: 19px;color: #707070;line-height: 120%;margin-bottom: 30px;">
            Hey <span style="color: #2e2e2e;">{{ ucfirst($receiver) }}</span>, You have reached your max application limit of. {{ $data['limit'] }}
        </div>
    </div>
<div style="width: 100%; border-top: 1px solid #cccccc; margin: 30px 0px"></div>
@endsection
