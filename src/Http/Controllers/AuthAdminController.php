<?php 
/**
|----------------------------------------------
| Bee admin 
|----------------------------------------------
| @Author: studyboy
| @E-mail: johngao@qq.com
| @Date:   2019-04-12 01:23:55
| @Last Modified by:   gsw
| @Last Modified time: 2019-04-12 01:51:00
|----------------------------------------------
 */
namespace Bee\Admin\Http\Controllers;

use Encore\Admin\Http\Controllers\AuthController;



class AuthAdminController extends AuthController {


    public function getLogin(){
        dd('hhh');
        return view('admin:admin-login-bee');
    }
}