<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UploadFileManager extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      protected $user;

      public function private_folder_name(){
        if(apiAuth() != null)
            return apiAuth()->id;

        if ($this->user != null)
            return $this->user->id;
      }

      public function base_directory(){

        return config('lfm.base_directory') ;
      }

      public function path(){

        return    $this->private_folder_name() ;

      //return   $this->base_directory().'/'. $this->private_folder_name()   ;

      }


   /*  public function __construct($file,$sub_directory=null)
     {
         $fileName = $file->getClientOriginalName() ;
         $path=$this->path() .'/'.$sub_directory;
         $storage_path= $file->storeAs($path
             , $fileName);
         $this->storage_path='store/' . $storage_path ;
     }*/

     public function __construct($file,$user=null,$sub_directory=null)
     {
         $this->user = $user;
         $fileName = $file->getClientOriginalName() ;
         $path=$this->path() .'/'.$sub_directory;
         $storage_path= $file->storeAs($path
             , $fileName);
         $this->storage_path='store/' . $storage_path ;
     }

    public function __invoke(Request $request)
    {
        dd('dd') ;
    }
}
