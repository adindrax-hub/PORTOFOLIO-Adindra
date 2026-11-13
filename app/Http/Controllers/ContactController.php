<?php
namespace App\Http\Controllers;
use App\Models\{Message,Contact};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class ContactController extends Controller{
 public function store(Request $r){
  if(filled($r->input('website')))return response()->json(['ok'=>true]); // honeypot: bot mengisi kolom tersembunyi
  $d=$r->validate([
   'name'=>'required|string|min:2|max:100',
   'email'=>'required|email|max:150',
   'message'=>'required|string|min:10|max:3000',
  ],[
   'name.required'=>'Nama wajib diisi.','name.min'=>'Nama terlalu pendek.',
   'email.required'=>'Email wajib diisi.','email.email'=>'Format email belum benar.',
   'message.required'=>'Pesan wajib diisi.','message.min'=>'Pesan minimal 10 karakter.',
  ]);
  Message::create(['name'=>$d['name'],'email'=>$d['email'],'body'=>$d['message']]);
  $to=Contact::where('type','email')->value('value');
  if($to){try{Mail::raw("Pesan baru dari {$d['name']} <{$d['email']}>\n\n{$d['message']}",fn($m)=>$m->to($to)->replyTo($d['email'],$d['name'])->subject('Pesan portofolio dari '.$d['name']));}catch(\Throwable $e){report($e);}}
  return response()->json(['ok'=>true],201);
 }
}
