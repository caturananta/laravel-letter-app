<?php

namespace App\Http\Controllers;

use App\Discuss;
use App\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getnotif($id)
    {
        $currentuser = Auth::user();
        $comments = null;
        if ($currentuser->user_role == 2) {
            $comments = Letter::join('recipient AS r', 'r.recipient_letter_id', '=', 'letter.id')
                ->join('discuss AS d', 'd.discuss_letter_id','=','letter.id')
                ->join('users AS u', 'u.id', '=', 'd.discuss_author')
                ->select('d.*','u.email')
                ->where('d.discuss_author','!=',$currentuser->id)
                ->whereNull('d.p2')
                ->get();
        }
        else if($currentuser->user_role == 1){
            $comments = Letter::join('recipient AS r', 'r.recipient_letter_id', '=', 'letter.id')
                ->join('discuss AS d', 'd.discuss_letter_id','=','letter.id')
                ->join('users AS u', 'u.id', '=', 'd.discuss_author')
                ->select('d.*','u.email')
                ->where('d.discuss_author','!=',$currentuser->id)
                ->where('letter.author', $currentuser->id)
                ->whereNull('d.p1')
                ->get();
        }
        else {
            $comments = Letter::join('status AS s', 's.status_letter_id', '=', 'letter.id')
                ->join('recipient AS r', 'r.recipient_letter_id', '=', 'letter.id')
                ->join('discuss AS d', 'd.discuss_letter_id','=','letter.id')
                ->join('users AS u', 'u.id', '=', 'd.discuss_author')
                ->select('d.*','u.email')
                ->where('r.user_id', $currentuser->id)
                ->where('d.discuss_author','!=',$currentuser->id)
                ->where('s.forward_status', "Y")
                ->whereNull('d.p3')
                ->get();
        }

        $return["id"] = $id;
        $return["message"] = "Success";
        $return["data"] = $comments;
        return response()->json($return, 200);
    }
}
