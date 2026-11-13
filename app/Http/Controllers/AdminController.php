<?php
namespace App\Http\Controllers;
use App\Models\Message;
class AdminController extends Controller{
 public function index(){return view('admin.messages',['messages'=>Message::latest()->get()]);}
 public function read(Message $message){$message->update(['is_read'=>true]);return back();}
 public function destroy(Message $message){$message->delete();return back();}
}
