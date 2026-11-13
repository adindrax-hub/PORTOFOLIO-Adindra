<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController,ContactController,AdminController};
use App\Http\Middleware\AdminAuth;
use App\Models\Project;
Route::get('/',[HomeController::class,'index']);
Route::get('/projects/{slug}',fn($slug)=>redirect('/#project-'.Project::where('slug',$slug)->firstOrFail()->slug));
Route::post('/contact',[ContactController::class,'store'])->middleware('throttle:5,1');
Route::prefix('admin')->middleware(AdminAuth::class)->group(function(){
 Route::get('/messages',[AdminController::class,'index']);
 Route::post('/messages/{message}/read',[AdminController::class,'read']);
 Route::delete('/messages/{message}',[AdminController::class,'destroy']);
});
Route::get('/robots.txt',fn()=>response("User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: ".url('/sitemap.xml')."\n",200,['Content-Type'=>'text/plain']));
Route::get('/sitemap.xml',function(){
 $u=[url('/')];foreach(Project::pluck('slug') as $s)$u[]=url('/projects/'.$s);
 return response('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.collect($u)->map(fn($x)=>"<url><loc>$x</loc></url>")->implode('').'</urlset>',200,['Content-Type'=>'application/xml']);
});
