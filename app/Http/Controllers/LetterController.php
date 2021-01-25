<?php

namespace App\Http\Controllers;

use App\Discuss;
use App\Doc;
use App\Letter;
use App\Recipient;
use App\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;

class LetterController extends Controller
{
    public function send(Request $request)
    {
        /**
         * get active user
         */
        $currentuser = Auth::user();

        $request->validate([
            'sender' => 'required',
//            'destinationEmail' => 'required|email',
            'subjectEmail' => 'required',
            'letterNo' => 'required',
            'letter_date' => 'required',
            'agenda_date' => 'required',
            'agenda_no' => 'required',
        ], [
            'sender.required' => '*Pengirim harus diisi',
            'letterNo.required' => '*Nomor surat harus diisi',
//            'destinationEmail.required' => '*Email harus diisi',
            'subjectEmail.required' => '*Perihal harus diisi',
            'letter_date.required' => '*Tanggal harus diisi',
            'agenda_date.required' => '*Tanggal harus diisi',
            'agenda_no.required' => '*No agenda harus diisi',
        ]);

        $data = [
            'from' => $request->input('sender'),
//            'destinationEmail' => $request->input('destinationEmail'),
            'subjectEmail' => $request->input('subjectEmail'),
            'priority' => $request->input('priority'),
            'message' => $request->input('msg'),
            'file_upload' => $request->file('file_upload'),
            'no' => $request->input('letterNo'),
            'letter_date' => $request->input('letter_date'),
            'agenda_date' => $request->input('agenda_date'),
            'agenda_no' => $request->input('agenda_no')
        ];
        $filename = null;
        $array_file = [];
        if ($data['file_upload'] !== null) {
            $filename = $data['file_upload']->getClientOriginalName();
            array_push($array_file, $filename);
        }

        try {
            DB::beginTransaction();

            $letter_id = (string)Str::uuid();
            $recipient_id = (string)Str::uuid();
            $status_id = (string)Str::uuid();
            $doc_id = (string)Str::uuid();

            $json_file = json_encode($array_file);
            $recipient_user = User::select('id')->where('user_role', 2)->first();

            if ($recipient_user == null) {
                return back()->with('error', 'Surel gagal dikirim. Email tujuan tidak ditemukan.');
            }

            $letter_date =  Carbon::createFromFormat('d/m/Y', $data['letter_date'])->format('Y-m-d');
            $agenda_date =  Carbon::createFromFormat('d/m/Y', $data['agenda_date'])->format('Y-m-d');

            Letter::insert(['id' => $letter_id, 'author' => $currentuser->id, 'letter_no' => $data['no'], 'sender' => $data['from'],'letter_msg' => $data['message'], 'letter_priority' => $data['priority'], 'letter_date' => $letter_date,'agenda_date' => $agenda_date,'agenda_no' => $data['agenda_no'] , 'created_date' => now(), 'letter_sub' => $data['subjectEmail']]);
            Recipient::insert(['id' => $recipient_id, 'user_id' => $recipient_user['id'], 'recipient_letter_id' => $letter_id]);
            Status::insert(['id' => $status_id, 'status_letter_id' => $letter_id]);

            if (!empty($array_file)){
                Doc::insert(['id' => $doc_id, 'doc_letter_id' => $letter_id, 'filename' => $filename, 'location' => 'file/' . $letter_id]);
            }

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
            return back()->with('error', 'Sistem sedang mengalami gangguan');
        }

        if ($filename != null) {
            $data['file_upload']->move('file/' . $letter_id, $filename);
        }

        return back()->with('success', 'Surel berhasil dikirim');
    }

    public function manage(Request $request)
    {
        $request->validate(
            ['forward_email' => 'required'],
            ['forward_email.required' => '*Tujuan harus diisi']);

        $forward_email = $request->input('forward_email');

        if ($request->has('submit')) {
            try {
                DB::beginTransaction();
                Recipient::where('id', $request->_rid)->update(array('user_id' => $forward_email));
                Status::where('id', $request->_id)->update(array('forward_status' => 'Y', 'forward_date' => now()));
                DB::commit();
                return back()->with('success', 'Surel berhasil diteruskan');
            } catch (\Exception $e) {
                Log::error($e);
                DB::rollback();
            }
        } else if ($request->has('cancel')) {

            Log::error('cancel');
            try {
                DB::beginTransaction();
                Status::where('id', $request->_id)->update(array('forward_status' => 'N', 'forward_date' => now()));
                DB::commit();
                return back()->with('error', 'Surel tidak diteruskan');
            } catch (\Exception $e) {
                Log::error($e);
                DB::rollback();
            }
        }
    }

    public function discuss(Request $request)
    {
        $request->validate(['disc_msg' => 'required']);
        $currentuser = Auth::user();
        try {
            $discuss_id = (string)Str::uuid();
            Discuss::insert(array('id' => $discuss_id, 'discuss_letter_id' => $request->disc_id, 'discuss_author' => $currentuser->id, 'discuss_message' => $request->disc_msg, 'created_date' => now()));
            return back()->with('success', 'Berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
        }
    }
}
