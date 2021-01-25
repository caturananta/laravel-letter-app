<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function download($id, $filename){
        $file = public_path()."/file/".$id."/".$filename;
        return Response::download($file);
    }

}
