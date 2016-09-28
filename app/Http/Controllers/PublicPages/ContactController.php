<?php
namespace TuaWebsite\Http\Controllers\PublicPages;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Mail;
use TuaWebsite\Http\Controllers\Controller;
use View;

/**
 * Contact Controller
 *
 * @package TuaWebsite\Http\Controllers\PublicPages
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class ContactController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function contact()
    {
        return View::make('public.contact');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function postContact(Request $request)
    {
        // Get request data
        $data = $request->request->all();

        // Grab the details and email them
        Mail::send('mail.enquiry', $data, function(Message $message) use($data){
            $message->to('archery@tees-su.org.uk', 'Teesside University Archers');
            $message->subject('Web Enquiry');
            $message->from($data['email'], $data['name']);
        });

        return response()->json([], 204);
    }
}