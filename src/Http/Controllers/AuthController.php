<?php 
/**
|----------------------------------------------
| Bee admin 
|----------------------------------------------
| @Author: studyboy
| @E-mail: johngao@qq.com
| @Date:   2019-04-12 01:23:55
| @Last Modified by:   gsw
| @Last Modified time: 2019-04-12 01:33:12
|----------------------------------------------
 */
namespace Bee\Admin\Http\Controllers;

use Encore\Admin\Http\Controllers\AuthController as AuthAdminController;



class AuthController extends AuthAdminController {


    public function getLogin(){
        dd('hhh');
        return view('admin:admin-login-bee');
    }
}