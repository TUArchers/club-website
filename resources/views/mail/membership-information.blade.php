@extends('layouts.email')

@section('title', 'Join Teesside University Archers')

@section('content')
    {{--Logo and Header--}}
    @include('mail.components.media-left', [
        'src'   => 'http://tuarchers.org.uk/assets/images/tua-club-logo-small.png',
        'title' => 'Join Teesside University Archers',
        'body'  => 'Thanks ' . $first_name . ', for showing interest in archery at Teesside University. If you managed to make it to a taster session, we also hope you enjoyed yourself. <br /><br /> Want to carry on? Here\'s some information on what to do next.'
    ])

    {{--Membership Fees--}}
    @include('mail.components.callout-box', [
        'url'   => 'https://www.tees-su.org.uk/get_involved/club/archerysoc/',
        'label' => 'Join Now',
        'title' => 'Membership',
        'body'  => 'To join the club, all you need to do is buy a sports club membership from the Students\' Union. This can be done at reception on the first floor of the Students\' Union building, or online using the link below. <br /><br /> Membership costs £51 for the entire year, includes loads of extra stuff and also allows you to join almost any sports club at the university. If you\'ve done this already and have a red membership card, then you can skip this part!'
    ])

    {{--Beginners' Course--}}
    @include('mail.components.full-width', [
        'title' => 'Beginners\' Course',
        'body'  => 'Once you have a sports club membership, you\'ll need to complete a short beginners\' course. The course consists of one session every week for three consecutive weeks, after which you will be able to shoot at any of our regular member sessions. <br /><br /> There are two course times on offer, starting this week: <br /><ul><li>Tuesdays 7:00pm - 9:00pm</li><li>Saturdays 5:30pm - 9:00pm</li></ul> To book your place just email our club secretary, David (secretary@tuarchers.org.uk).'
    ])

    {{--Extra Bits--}}
    @include('mail.components.full-width', [
        'title' => 'Members\' Sessions',
        'body'  => 'Once you have completed your beginners\' course, you\'ll become a full club member and be able to shoot at our regular member sessions. These are held: <br/><ul><li>Tuesdays 7:30pm - 9:15pm</li><li>Saturdays 11:30am - 2:00pm</li><li>Saturdays 6:00pm - 9:00pm</li></ul> Club equipment remains free to use while you are a member and you will also be invited to our Facebook group. <br /><br /> If you have any queries or questions, please ask by emailing our club committee (committee@tuarchers.org.uk). <br /><br /> <i>P.S. Do not reply directly to this email - your reply will go nowhere!</i>'
    ])
@endsection