<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
//Route::miss('api/Index/miss');

Route::rule('news/[:page]/[:art_type_id]','home/Index/news','get');
Route::rule('newsdetail/:art_id','home/Index/news_detail','get');
Route::rule('/','admin/Index/index');
Route::rule('cases/[:page]/[:case_type_id]','home/Index/cases','get');
Route::rule('casedetail/:case_id','home/Index/case_detail','get');
Route::rule('phone/:case_id','home/Index/phone','get');
Route::rule('phone/:case_id','home/Index/phone','get');
Route::rule('solutions/[:page]','home/Index/solutions','get');
Route::rule('soludetail/:prog_id','home/Index/solutions_detail','get');
Route::rule('service','home/Index/service','get');
Route::rule('about','home/Index/about','get');
Route::rule('contact','home/Index/contact','get');
