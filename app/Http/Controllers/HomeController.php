<?php /** @noinspection PhpUnused */

namespace App\Http\Controllers;

use App\Discuss;
use App\Letter;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Validator;

class HomeController extends Controller
{
    public function index()
    {
        /**
         * get active user
         */
        $currentuser = Auth::user();

        /**
         * query to get all email inbox by recipient id and forward status is Y
         * if user login is sekretaris then get letter by user role 3
         */
        $letter = null;
        if ($currentuser->id == 2) {
            $letter = Letter::join('status AS s', 's.status_letter_id', '=', 'letter.id')
                ->join('recipient AS r', 'r.recipient_letter_id', '=', 'letter.id')
                ->leftjoin('doc AS d', 'd.doc_letter_id', '=', 'letter.id')
                ->join('priority AS p', 'p.id', '=', 'letter.letter_priority')
                ->join('users AS u', 'u.id', '=', 'letter.author')
                ->select('letter.id AS _id','r.user_id as letter_to_email ', 'letter.*', 's.id AS status_id','s.review_date', 's.forward_status', 's.forward_date', 's.read_status', 's.read_date', 'u.email AS letter_from_email', 'u.name AS letter_from_name', 'd.filename AS file_name', 'd.location AS file_loc', 'p.status')
                ->paginate(20);
        }
        else {
            $letter = Letter::join('status AS s', 's.status_letter_id', '=', 'letter.id')
                ->join('recipient AS r', 'r.recipient_letter_id', '=', 'letter.id')
                ->leftjoin('doc AS d', 'd.doc_letter_id', '=', 'letter.id')
                ->join('priority AS p', 'p.id', '=', 'letter.letter_priority')
                ->join('users AS u', 'u.id', '=', 'letter.author')
                ->select('letter.id AS _id', 'letter.*', 's.id AS status_id', 's.review_date', 's.forward_status', 's.forward_date', 's.read_status', 's.read_date', 'u.email AS letter_from_email', 'u.name AS letter_from_name', 'd.filename AS file_name', 'd.location AS file_loc', 'p.status')
                ->where('r.user_id', $currentuser->id)
                ->where('s.forward_status', "Y")
                ->paginate(20);
        }

//        dd($letter);
        return view('page.inbox', ['inbox' => $letter]);
    }

    public function sent()
    {
        /**
         * get active user
         */
        $currentuser = Auth::user();

        /**
         * query to get all email by author
         */
        $letter_sent = Letter::join('status AS s', 's.status_letter_id', '=', 'letter.id')
            ->join('recipient AS r', 'r.recipient_letter_id', '=', 'letter.id')
            ->leftjoin('doc AS d', 'd.doc_letter_id', '=', 'letter.id')
            ->join('priority AS p', 'p.id', '=', 'letter.letter_priority')
            ->join('users AS u', 'u.id', '=', 'r.user_id')
            ->select('letter.id AS _id','letter.*', 's.id AS status_id', 's.review_date', 's.forward_status', 's.read_status', 's.read_date', 'u.email AS letter_to_email', 'u.name AS letter_to_name', 'd.filename AS file_name', 'd.location AS file_loc', 'p.status')
            ->where('letter.author', $currentuser->id)
            ->paginate(20);

        return view('page.sent', ['letter_sent' => $letter_sent]);
    }

    public function files()
    {
        return view('page.files');
    }

    public function compose()
    {
        $kabiro = User::select('email')->where('user_role', 3)->get();
        return view('page.compose', ['kabiro' => $kabiro]);
    }

    public function detail($id)
    {
        $currentuser = Auth::user();
        if ($currentuser->user_role == 2){
            Discuss::where('discuss_letter_id', $id)->whereNull('p2')->update(array('p2'=>'Y'));
            Status::where('status_letter_id',$id)->whereNull('review_date')->update(array('review_date'=>now()));
        }
        else if ($currentuser->user_role == 3){
            Discuss::where('discuss_letter_id', $id)->whereNull('p3')->update(array('p3'=>'Y'));
            Status::where('status_letter_id',$id)->update(array('read_date'=>now(),'read_status'=>'Y'));
        }
        else {
            Discuss::where('discuss_letter_id', $id)->whereNull('p1')->update(array('p1'=>'Y'));
        }

        /**
         * query to get email by letter id
         */
        $data['letter_detail'] = Letter::join('status AS s', 's.status_letter_id', '=', 'letter.id')
            ->join('recipient AS r', 'r.recipient_letter_id', '=', 'letter.id')
            ->leftjoin('doc AS d', 'd.doc_letter_id', '=', 'letter.id')
            ->join('priority AS p', 'p.id', '=', 'letter.letter_priority')
            ->join('users AS u', 'u.id', '=', 'r.user_id')
            ->select('letter.id AS _id','letter.*', 's.id AS status_id', 's.review_date', 's.forward_status', 's.forward_date', 's.read_status', 's.read_date', 'u.email AS letter_to_email', 'u.name AS letter_to_name', 'd.filename AS file_name', 'd.location AS file_loc', 'p.status', 'r.id AS rid')
            ->where('letter.ID',$id)
            ->first();

        $data['comments'] = Discuss::join('users AS u','u.id','=','discuss.discuss_author')
            ->select('discuss.*','u.email as author')
            ->where('discuss_letter_id', $id)
            ->orderBy('created_date', 'asc')
            ->get();

        $data['users'] = User::select('id','email', 'name')->where('user_role', 3)->get();

        return view('page.detail')->with('data',$data);
    }

    public function search(Request $request){
        $search = $request->search;

        /**
         * get active user
         */
        $currentuser = Auth::user();

        /**
         * query to get all email inbox by recipient id and forward status is Y
         * if user login is sekretaris then get letter by user role 3
         */
        $letter = null;
        if ($currentuser->id == 2) {
            $letter = Letter::join('status AS s', 's.status_letter_id', '=', 'letter.id')
                ->join('recipient AS r', 'r.recipient_letter_id', '=', 'letter.id')
                ->leftjoin('doc AS d', 'd.doc_letter_id', '=', 'letter.id')
                ->join('priority AS p', 'p.id', '=', 'letter.letter_priority')
                ->join('users AS u', 'u.id', '=', 'letter.author')
                ->select('letter.id AS _id','r.user_id as letter_to_email ', 'letter.*', 's.id AS status_id','s.review_date', 's.forward_status', 's.forward_date', 's.read_status', 's.read_date', 'u.email AS letter_from_email', 'u.name AS letter_from_name', 'd.filename AS file_name', 'd.location AS file_loc', 'p.status')
                ->where('letter.letter_sub', 'like', "%".$search."%")
                ->paginate();
        }
        else {
            $letter = Letter::join('status AS s', 's.status_letter_id', '=', 'letter.id')
                ->join('recipient AS r', 'r.recipient_letter_id', '=', 'letter.id')
                ->leftjoin('doc AS d', 'd.doc_letter_id', '=', 'letter.id')
                ->join('priority AS p', 'p.id', '=', 'letter.letter_priority')
                ->join('users AS u', 'u.id', '=', 'letter.author')
                ->select('letter.id AS _id', 'letter.*', 's.id AS status_id', 's.review_date', 's.forward_status', 's.forward_date', 's.read_status', 's.read_date', 'u.email AS letter_from_email', 'u.name AS letter_from_name', 'd.filename AS file_name', 'd.location AS file_loc', 'p.status')
                ->where('r.user_id', $currentuser->id)
                ->where('s.forward_status', "Y")
                ->where('letter.letter_sub', 'like', "%".$search."%")
                ->paginate();
        }

        return view('page.inbox', ['inbox' => $letter]);
    }

    public function sent_search(Request $request){
        $search = $request->search;
        /**
         * get active user
         */
        $currentuser = Auth::user();

        /**
         * query to get all email by author
         */
        $letter_sent = Letter::join('status AS s', 's.status_letter_id', '=', 'letter.id')
            ->join('recipient AS r', 'r.recipient_letter_id', '=', 'letter.id')
            ->leftjoin('doc AS d', 'd.doc_letter_id', '=', 'letter.id')
            ->join('priority AS p', 'p.id', '=', 'letter.letter_priority')
            ->join('users AS u', 'u.id', '=', 'r.user_id')
            ->select('letter.id AS _id','letter.*', 's.id AS status_id', 's.review_date', 's.forward_status', 's.read_status', 's.read_date', 'u.email AS letter_to_email', 'u.name AS letter_to_name', 'd.filename AS file_name', 'd.location AS file_loc', 'p.status')
            ->where('letter.author', $currentuser->id)
            ->where('letter.letter_sub', 'like', "%".$search."%")
            ->paginate();

        return view('page.sent', ['letter_sent' => $letter_sent]);
    }

    public function profil(){
        return view('page.profil');
    }

    public function profil_update(Request $request){
        $rules = [
            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ];

        $messages = [
            'oldpassword.required' => 'Password wajib diisi',
            'password.confirmed' => 'Password tidak sama dengan konfirmasi password'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $valid = Hash::check($request->oldpassword, Auth::user()->password);
        if ($valid) {
            try {
                DB::beginTransaction();
                User::where('id',$request->_id)->update(array("password"=>Hash::make($request->password)));
                DB::commit();
            }
            catch (\Exception $e){
                Log::error($e);
                DB::rollBack();
                return back()->with('error', 'Password lama tidak sesuai');
            }

        }
        return back()->with('success', 'Berhasil mengupdate');
    }
}
