<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class AdminAuth{
 public function handle(Request $request,Closure $next){
  $pass=(string)env('ADMIN_PASSWORD');$user=(string)env('ADMIN_USER','admin');
  if($pass==='')abort(404); // inbox nonaktif sampai ADMIN_PASSWORD diisi di .env
  if(!hash_equals($user,(string)$request->getUser())||!hash_equals($pass,(string)$request->getPassword()))
   return response('Login diperlukan.',401,['WWW-Authenticate'=>'Basic realm="Inbox portofolio"']);
  return $next($request);
 }
}
